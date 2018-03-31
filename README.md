# TheSocialWeb

## Brief Introduction

Project Assignment: Company Popularity On The Social Web _ Group 22

This repository contains the scripts and data used in the project of the course Social Web of the Vrije Universiteit Amsterdam.

## Technical related

The project contains the code built with PHP/HTML/CSS/JS for generating the final dashboard that contains all statistics and analysis charts.

To run the code on a local machine, two commands need to be executed to get all dependencies packages
1. composer install
2. bower install

## How it works

* The folder */server/data* contains the scripts of gathering full data. 
(ALL PYTHON FILES (.py) ARE CREATED AND RUN IN PYCHARM ON PYTHON 2.7)

* All Twitter data gathered can be found in the folder *twitter_data*. This folder contains the old restricted data, the full data, and the cleaned data used in the final version of the project in folders *old_twitter_data*, *new_twitter_data*, and KLM and Deloitte, respectively.

* The old twitter data folder contains the data created with the Python script *OldVersionTwitterScript.py*. The folder also contains the set parameters to run the code.

* The new twitter data folder contains the data about the companies KLM and Deloite. The explanation in it also has a link to another folder with all data gathered, which were stored due to size limiting of Github. The new twitter data is gathered by running 2 scripts *Gathering_of_tweets.py* and *Tweets_of_a_user.py*. *Gathering_of_tweets.py* collects tweets about a company, while *Tweets_of_a_user.py* gathers tweets posted by a specific user.

* iPython notebook files are also provided for the scraping and API of different social media platforms: Facebook, LinkedIn and Youtube. These were developed but not used in the final project. An example result of the Facebook scraper can be found in the *img* folder.


