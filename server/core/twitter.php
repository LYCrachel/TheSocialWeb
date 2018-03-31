<?php namespace socialWeb\core;

use Carbon\Carbon;
use function socialWeb\core\functions\val;
use function socialWeb\core\functions\nav;
use function socialWeb\core\functions\getLanguageCodes;
use function socialWeb\core\functions\getTimeQuarters;

/**
 * Class TwitterData
 * @package socialWeb\core
 */
Class Twitter
{

    /**
     * @var array|mixed
     */
    public $data = array();


    /**
     * TwitterData constructor.
     * @param $app
     * @param bool $companyTweets
     */
    public function __construct($app, $companyTweets = false)
    {
        $params = $app->request()->params();
        $companyName = val('companyName', $params);
        $path = TWEETER_DATA_PATH . "/" . $companyName;
        $fileName = $companyTweets
            ? $path . "/" . strtolower($companyName) . TWEETS_BY_COMPANY
            : $path . "/tweets_about_" . strtolower($companyName) . ".json";
        $this->data = json_decode(file_get_contents($fileName), true);
    }

    /**
     * @return array
     */
    public function accountData()
    {
        $tweets_dates = array_map(function ($tweet) {
            $str = str_replace('+0000 ', '', val('created_at', $tweet));
            return Carbon::createFromFormat(TWEETER_DATE_FORMAT, $str)->toDateTimeString();
        }, $this->data);

        $tweet = reset($this->data);
        return [
            'profile_image_url'         => nav('user -> profile_image_url_https', $tweet),
            'company'                   => nav('user -> name', $tweet),
            'account'                   => nav('user -> screen_name', $tweet),
            'location'                  => nav('user -> location', $tweet),
            'description'               => nav('user -> description', $tweet),
            'following'                 => nav('user -> friends_count', $tweet),
            'followers'                 => nav('user -> followers_count', $tweet),
            'tweets'                    => count($this->data),
            'account_created_at'        => Carbon::createFromFormat(TWEETER_DATE_FORMAT, str_replace('+0000 ', '', nav('user -> created_at', $tweet)))->diffForHumans(),
            'first_tweet_created_at'    => min($tweets_dates),
            'last_tweet_created_at'     => max($tweets_dates)
        ];
    }

    /**
     * @return array
     */
    public function extractKeywords()
    {
        $text_only = array_filter(array_map(function ($tweet) {
            return val('lang', $tweet) == 'en' ? val('text', $tweet) : null;
        }, $this->data));

        $text = implode(" ", $text_only);

        // Strip HTML and PHP tags from a string
        $text = strip_tags($text);

        // Keep letters only
        $text = preg_replace('/[^a-z]+/i', ' ', $text);

        // To lower case
        $text = trim(strtolower($text));

        // String to array of words (filter words with less than MINIMUM_WORD_LENGTH)
        $words = array_filter(mb_split(' +', $text), function ($word) {
            return strlen($word) >= MINIMUM_WORD_LENGTH;
        });

        // Remove StopWords
        $words = array_diff($words, STOP_WORDS);

        // Remove Unwanted Words
        $words = array_diff($words, UNWANTED_WORDS);

        // Count the number of times each word occurs in an array
        $keywordCounts = array_count_values($words);

        // Filter keywords with count less than the MINIMUMS_REPETITION
        $keywordCounts = array_filter($keywordCounts, function ($count) {
            return $count >= MINIMUM_REPETITION;
        });

        // Sort DESC
        arsort($keywordCounts, SORT_NUMERIC);

        // Get MOST_REPEATED_KEYWORDS
        $topKeywords = array_slice($keywordCounts, 0, MOST_REPEATED_KEYWORDS);

        return [
            'keywords_count' => count($keywordCounts),
            'top_keywords'   => implode(', ', array_keys($topKeywords))
        ];
    }

    /**
     * @return array
     */
    public function mapTweetsPerLanguage()
    {
        // Languages
        $languageMapping = getLanguageCodes();
        $lang = array_map(function ($tweet) use ($languageMapping) {
            return val('lang', $tweet);
        }, $this->data);

        $langCounts = array_count_values($lang);
        arsort($langCounts, SORT_NUMERIC);

        $res = [];
        foreach (array_slice($langCounts, 0, 10) as $key => $value) {
            $res[] = [$languageMapping[$key], $value];
        }
        $res[] = ['other', array_sum(array_slice($langCounts, 10))];

        return $res;
    }

    /**
     * @return array
     */
    public function mapTweetsPerDay()
    {
        // Dates
        $dates = array_map(function ($tweet) {
            $str = str_replace('+0000 ', '', val('created_at', $tweet));
            return Carbon::createFromFormat(TWEETER_DATE_FORMAT, $str)->toDateString();
        }, $this->data);

        $res = [];
        foreach (array_count_values($dates) as $key => $value) {
            $res[] = [$key, $value];
        }
        return $res;
    }

    /**
     * @return array
     */
    public function reTweetsCount()
    {
        $reTweetCount = count(array_filter($this->data, function ($tweet) {
            return val('retweet_count', $tweet) > 0;
        }));

        return [
            ['retweeted', round(100 * $reTweetCount / count($this->data))],
            ['not retweeted', round(100 * (count($this->data) - $reTweetCount) / count($this->data))]
        ];
    }

    /**
     * @return array
     */
    public function tweetsPerTime()
    {
        return array_values(array_map(function ($quarter) {
            $count = count(array_filter($this->data, function ($tweet) use ($quarter) {
                $str = str_replace('+0000 ', '', val('created_at', $tweet));
                $created_at = Carbon::createFromFormat(TWEETER_DATE_FORMAT, $str)->format(TIME_FORMAT);
                return $tweet ? $created_at >= $quarter['from'] && $created_at <= $quarter['to'] : null;
            }));
            return [$quarter['time'], round(100 * $count / count($this->data), 2)];
        }, getTimeQuarters()));
    }
}