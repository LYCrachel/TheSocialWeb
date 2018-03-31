import tweepy
import json
import sys
import operator
reload(sys)
sys.setdefaultencoding('utf8')
from tweepy import OAuthHandler
from operator import itemgetter

consumer_key = 'qdWegIX31At3iv4h0SZY9gLO3'
consumer_secret = 'SDGN79lQrdznPqAlNaqt7eyAJf1Rly7eQF5Kqwus76lmlrpF1c'
access_token = '961185409366724608-Vih2ASLQ5fFNPQh6TYX81NKarJELlYn'
access_secret = 'TQfDu5Hvaf4V3SVRWBhh2AjVkn6CQr1ZabB7fcvGl28qd'

auth = OAuthHandler(consumer_key, consumer_secret)
auth.set_access_token(access_token, access_secret)

api = tweepy.API(auth)

search_query = "deloitte"
amount_of = 100

tweets = tweepy.Cursor(api.search, q = search_query,since='2018-03-02',until='2018-03-09').items(amount_of)
tweets_list = []
for tweet in tweets:
    tweet_dict = {}
    tweet_likes = tweet.favorite_count
    full_tweet_hashtags = tweet.entities.get('hashtags')
    tweet_hashtags = []
    for hashtag in full_tweet_hashtags:
        tweet_hashtags.append(hashtag['text'])
    tweet_username = tweet.author.screen_name
    tweet_user_id =  tweet.author.id
    tweet_time_date = str(tweet.created_at)
    tweet_location_enabled = tweet.author.geo_enabled
    tweet_user_location = tweet.author.location
    tweet_text = tweet.text
    tweet_number_retweeted = tweet.retweet_count
    tweet_id = tweet.id
    if hasattr(tweet, 'retweeted_status'):
        retweeted_user_id = tweet.retweeted_status.author.id
        retweeted_user_name = tweet.retweeted_status.author.screen_name
        retweeted_count = tweet.retweeted_status.retweet_count
        retweeted_text = tweet.retweeted_status.text
        retweeted_time = str(tweet.retweeted_status.created_at)
        retweeted_id = tweet.retweeted_status.id
        retweeted_list = [retweeted_user_id, retweeted_user_name, retweeted_count, retweeted_text, retweeted_time, retweeted_id]
    else:
        retweeted_list = ['', '', '', '', '', '']
    tweet_list = [tweet_id, tweet_likes, tweet_username, tweet_user_id, tweet_time_date, tweet_user_location, tweet_location_enabled, tweet_text, tweet_hashtags]
    for item in retweeted_list:
        tweet_list.append(item)
    tweet_headers = ['id', '#likes', 'username', 'user id', 'time and date', 'user location', 'geolocation enabled', 'text', 'hashtags', 'retweeted user id', 'retweeted user name', 'retweeted amount', 'retweeted text', 'retweeted time', 'retweeted id']
    for header in tweet_headers:
        header_index = tweet_headers.index(header)
        correct_value = tweet_list[header_index]
        tweet_dict[header] = correct_value
    tweets_list.append(tweet_dict)

users = tweepy.Cursor(api.search_users, q = search_query).items(amount_of)
users_list = []
for user in users:
    user_dict = {}
    user_name = user.screen_name
    user_id = user.id
    user_followers = user.followers_count
    user_tweets = user.statuses_count
    user_friends = user.friends_count
    user_likes = user.favourites_count
    user_list = [user_name, user_id, user_followers, user_tweets, user_friends, user_likes]
    user_headers = ['user name', 'user id', '#followers', '#tweets', '#friends', '#likes']
    for header in user_headers:
        header_index = user_headers.index(header)
        correct_value = user_list[header_index]
        user_dict[header] = correct_value
    users_list.append(user_dict)

# This is the code to write the results to JSON files
# with open('tweets.json', 'w') as outfile:
#     json.dump(tweets_list, outfile,indent=4, separators=(',', ': '))
#
# with open('users.json', 'w') as outfile:
#     json.dump(users_list, outfile, indent=4,separators=(',', ': '))

# Code to look up the most retweeted tweet text and id
most_retweeted = 0
most_retweeted_id = ""
most_retweeted_text = ''
for tweet in tweets_list:
    retweeted = tweet["retweeted amount"]
    if retweeted > most_retweeted and retweeted != "" and search_query in tweet['retweeted text']:
        most_retweeted = retweeted
        most_retweeted_id = tweet["retweeted id"]
        most_retweeted_text = tweet["retweeted text"]

# Code that returns the amount of tweets are only returned because the query is in the username
amount_of_tweets_by_query_users = 0
for tweet in tweets_list:
    if search_query in tweet['username'] and search_query not in tweet['text']:
        amount_of_tweets_by_query_users += 1

#returns the list of tweets sorted based on the amount of likes (the first tweet has the most likes)
likes_sorted = sorted(tweets_list, key=itemgetter('#likes'), reverse=True)


# The code finds the hashtags of the tweets and creates a dictionary of the hashtags and their occurence. Also the number of hashtags per tweet can be returned.
hashtag_dict = {}
for tweet in tweets_list:
    number_of_hashtags = len(tweet['hashtags'])
    if number_of_hashtags > 0:
        for hashtag in tweet['hashtags']:
            if hashtag in hashtag_dict:
                hashtag_dict[hashtag] += 1
            else:
                hashtag_dict[hashtag] = 1
sorted_hashtag = sorted(hashtag_dict.items(), key=operator.itemgetter(1))



# dictionary for each user and their amount of tweets
users_dict = {}
user_id_list = []
for tweet in tweets_list:
    tweet_user_id = tweet['user id']
    tweet_user = tweet['username']
    if tweet_user_id in user_id_list:
        users_dict[tweet_user] += 1
    else:
        user_id_list.append(tweet_user_id)
        users_dict[tweet_user] = 1
sorted_users = sorted(users_dict.items(), key=operator.itemgetter(1))


#Average tweet length
total_text_length = 0
amount_of_tweets = len(tweets_list)
for tweet in tweets_list:
    total_text_length += len(tweet['text'])
average_tweet_length = total_text_length/float(amount_of_tweets)

# Amount of tweets retweets of same tweet
retweets_dict = {}
for tweet in tweets_list:
    retweeted_id = tweet['retweeted id']
    if retweeted_id != '':
        if retweeted_id in retweets_dict:
            retweets_dict[retweeted_id] += 1
        else:
            retweets_dict[retweeted_id] = 1
sorted_retweets = sorted(retweets_dict.items(), key=operator.itemgetter(1))

# code to find the account with the most friends, likes, followers, tweets
def most(label):
    return_sorted = sorted(users_list, key=itemgetter(label), reverse=True)
    return return_sorted[0]

amounts_list = ['#tweets', '#friends', '#followers', '#likes']
for item in amounts_list:
    print most(item)

#Average amount of likes, tweets, friends, followers of all accounts

def find_average(label):
    total_users = len(users_list)
    total_amount = 0
    for user in users_list:
        total_amount += user[label]
    average = total_amount/float(total_users)
    return average

# print len(users_list)
# for item in amounts_list:
#     print item, find_average(item)

# Find the most used words in the tweets
words_dict = {}
useless_list = ['RT', 'the', 'a', 'and', 'for', 'to', 'of']
for tweet in tweets_list:
    tweet_words = tweet['text'].split()
    for word in tweet_words:
        if word in useless_list:
            continue
        if word in words_dict:
            words_dict[word] += 1
        else:
            words_dict[word] = 1

sorted_words = sorted(words_dict.items(), key=operator.itemgetter(1))
# print sorted_words[-1]

