<?php

require __DIR__ . "/../vendor/autoload.php";

//------------- display errors -------------
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//To include all core files
foreach (['core/*.php'] as $globList) {
    foreach (glob($globList) as $filename) {
        include_once $filename;
    }
}

const MINIMUM_WORD_LENGTH = 4;
const MINIMUM_REPETITION = 10;
const MOST_REPEATED_KEYWORDS = 20;
const TWEETER_DATA_PATH = 'twitter_data';
const TWEETS_BY_COMPANY = '_tweets.json';
const LANGUAGE_MAPPING_CSV = 'CSV_Files/language_mapping.csv';
const TWEETER_DATE_FORMAT = 'D M d H:i:s Y';
const TIME_FORMAT = 'H:i:s';
const STOP_WORDS = ['a', 'about', 'above', 'after', 'again', 'against', 'all', 'am', 'an', 'and', 'any', 'are', "aren't", 'as', 'at', 'be', 'because', 'been', 'before', 'being', 'below', 'between', 'both', 'but', 'by', "can't", 'cannot', 'could', "couldn't", 'did', "didn't", 'do', 'does', "doesn't", 'doing', "don't", 'down', 'during', 'each', 'few', 'for', 'from', 'further', 'had', "hadn't", 'has', "hasn't", 'have', "haven't", 'having', 'he', "he'd", "he'll", "he's", 'her', 'here', "here's", 'hers', 'herself', 'him', 'himself', 'his', 'how', "how's", 'i', "i'd", "i'll", "i'm", "i've", 'if', 'in', 'into', 'is', "isn't", 'it', "it's", 'its', 'itself', "let's", 'me', 'more', 'most', "mustn't", 'my', 'myself', 'no', 'nor', 'not', 'of', 'off', 'on', 'once', 'only', 'or', 'other', 'ought', 'our', 'ours', 'ourselves', 'out', 'over', 'own', 'same', "shan't", 'she', "she'd", "she'll", "she's", 'should', "shouldn't", 'so', 'some', 'such', 'than', 'that', "that's", 'the', 'their', 'theirs', 'them', 'themselves', 'then', 'there', "there's", 'these', 'they', "they'd", "they'll", "they're", "they've", 'this', 'those', 'through', 'to', 'too', 'under', 'until', 'up', 'very', 'was', "wasn't", 'we', "we'd", "we'll", "we're", "we've", 'were', "weren't", 'what', "what's", 'when', "when's", 'where', "where's", 'which', 'while', 'who', "who's", 'whom', 'why', "why's", 'with', "won't", 'would', "wouldn't", 'you', "you'd", "you'll", "you're", "you've", 'your', 'yours', 'yourself', 'yourselves', 'zero'];
const UNWANTED_WORDS = ['https', 'can', 'please', 'via', 'message', 'send', 'check', 'replied', 'forward', 'share', 'follow', 'looking', 'info', 'thank', 'like', 'regret', 'hello', 'kindly', 'help', 'know', 'will', 'number', 'code', 'hear', 'read', 'order', 'available', 'options', 'responded', 'advise', 'report', 'still', 'currently', 'already', 'details', 'just', 'link', 'request', 'experiencing', 'high', 'glad', 'may', 'sorry', 'property', 'volumes', 'new', 'information', 'sent', 'irregularity', 'possible', 'see', 'name', 'attention', 'bringing', 'contact', 'status', 'full', 'tweet', 'created', 'allow', 'wish', 'also', 'understand', 'create', 'feedback', 'regarding', 'inform', 'due', 'website', 'back', 'use', 'soon', 'care', 'unfortunately', 'delete', 'latest', 'online', 'find', 'get', 'hope', 'values', 'provide', 'colleagues', 'look', 'ask', 'however', 'utmost', 'now', 'reply', 'simply', 'time', 'contains', 'kind', 'able', 'unable', 'avoid', 'checked', 'feel', 'one', 'inconvenience', 'way', 'note', 'change', 'first', 'case', 'malte', 'blue', 'following', 'serious', 'always', 'pleasant', 'experience', 'apologies', 'continue', 'osama', 'confusion', 'sharing', 'travel', 'lorna', 'found', 'keep', 'words', 'welcome', 'elaborate', 'refund', 'rest', 'indeed', 'given', 'apologize', 'itinerary', 'previous', 'email', 'date', 'assured', 'update', 'aware', 'many', 'consideration', 'best', 'moment', 'address', 'remove', 'concern', 'day', 'great', 'matter', 'need', 'working', 'reference', 'michael', 'response', 'make', 'conditions', 'operated', 'received', 'personal', 'reasons', 'private', 'learn', 'weather', 'letting', 'checking', 'mind', 'file', 'thomas', 'question', 'happy', 'preferred', 'add', 'dear', 'business', 'page', 'appreciate', 'service', 'offer', 'alex', 'per', 'situation', 'thanks', 'good', 'dates', 'yet', 'last', 'procedure', 'different', 'reaching', 'possibilities', 'issue'];
const Q1_TIME = '00:00-05:59';
const Q2_TIME = '06:00-11:59';
const Q3_TIME = '12:00-17:59';
const Q4_TIME = '18:00-23:59';
const DAY_QUARTERS = [Q1_TIME, Q2_TIME, Q3_TIME, Q4_TIME];