# TheSocialWeb

Project Assignment: Company Popularity On The Social Web _ Group 22

This Github repository contains the scripts and data used in the project of the course Social Web of the Vrije Universiteit Amsterdam.

It contains the code which has been build using PHP/HTML/CSS/JS technologies to produce the final dashboard that contains all statistics and analysis charts.

In order to run the code locally, two commands need to be run on the local machine (to get all dependencies packages)
1. composer install
2. bower install

The folder /server/data contains the scripts of gathering and full data. 
(ALL PYTHON FILES (.py) ARE CREATED AND RUNED IN PYCHARM ON PYTHON 2.7)

All the gathered Twitter data can be found in the folder called: twitter_data. This folder contains the old restricted data, the full data, and the cleaned data used in the final version of the project in the respectivly folders old_twitter_data, new_twitter_data and KLM and Deloitte.

The old twitter data folder contains the data created with the use of the Python script called OldVersionTwitterScript.py. The folder also contains the set parameters in the run of the code.

The new twitter data folder contains the data about the companies KLM and Deloite. The explanation also in folder contains a link to a folder with all data gathered, which were stored there due to the size limit of Github. The new twitter data is gathered by running 2 scripts. Gathering_of_tweets.py and Tweets_of_a_user.py. Gathering_of_tweets.py is for collecting the tweets about a company. The Tweets_of_a_user is used to gather tweets posted by a specific user.

Furthermore contains the folder the iPython notebook files for the scraping and API of different social media platforms: Facebook, LinkedIn and Youtube. These are developed, but were not used in the final project. An example result of the Facebook scraper has been stored in the img folder.


