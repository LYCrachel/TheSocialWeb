import sys
import jsonpickle
import os
import tweepy
from tweepy import OAuthHandler

# Replace the API_KEY and API_SECRET with your application's key and secret.
consumer_key = 'qdWegIX31At3iv4h0SZY9gLO3'
consumer_secret = 'SDGN79lQrdznPqAlNaqt7eyAJf1Rly7eQF5Kqwus76lmlrpF1c'
access_token = '961185409366724608-Vih2ASLQ5fFNPQh6TYX81NKarJELlYn'
access_secret = 'TQfDu5Hvaf4V3SVRWBhh2AjVkn6CQr1ZabB7fcvGl28qd'

auth = OAuthHandler(consumer_key, consumer_secret)
auth.set_access_token(access_token, access_secret)

api = tweepy.API(auth, wait_on_rate_limit=True,
				   wait_on_rate_limit_notify=True)

searchQuery = 'deloitte'  # this is what we're searching for
maxTweets = 1000000000000000000000 # Some arbitrary large number
tweetsPerQry = 200  # this is the max the API permits
fName = 'tweets_about_deloitte.txt' # We'll store the tweets in a text file.


# If results from a specific ID onwards are reqd, set since_id to that ID.
# else default to no lower limit, go as far back as API allows
# A tweet created on March 1st in the morning: 969130777110892544
sinceId = 969130777110892544

# If results only below a specific ID are, set max_id to that ID.
# else default to no upper limit, start from the most recent tweet matching the search query.
max_id = -1L

tweetCount = 0
print("Downloading max {0} tweets".format(maxTweets))
with open(fName, 'w') as f:
    while tweetCount < maxTweets:
        try:
            if (max_id <= 0):
                if (not sinceId):
                    new_tweets = api.search(q=searchQuery, count=tweetsPerQry)
                else:
                    new_tweets = api.search(q=searchQuery, count=tweetsPerQry,
                                            since_id=sinceId)
            else:
                if (not sinceId):
                    new_tweets = api.search(q=searchQuery, count=tweetsPerQry,
                                            max_id=str(max_id - 1))
                else:
                    new_tweets = api.search(q=searchQuery, count=tweetsPerQry,
                                            max_id=str(max_id - 1),
                                            since_id=sinceId)
            if not new_tweets:
                print("No more tweets found")
                break
            for tweet in new_tweets:
                f.write(jsonpickle.encode(tweet._json, unpicklable=False) +
                        '\n')
            tweetCount += len(new_tweets)
            print("Downloaded {0} tweets".format(tweetCount))
            max_id = new_tweets[-1].id
        except tweepy.TweepError as e:
            # Just exit if any error
            print("some error : " + str(e))
            break
