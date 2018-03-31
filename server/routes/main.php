<?php

use socialWeb\core\Twitter;

$app->get('/', function () use ($app) {
    echo $app->blade->render('main');
});

$app->get('/account-data', function () use ($app) {
    $twitter = new Twitter($app, true);
    $app->response()->header('Content-Type', 'application/json;charset=UTF-8');
    echo json_encode(array_merge($twitter->accountData(), $twitter->extractKeywords()));
})->name('accountData');

$app->get('/tweets-per-language', function () use ($app) {
    $app->response()->header('Content-Type', 'application/json;charset=UTF-8');
    echo json_encode((new Twitter($app))->mapTweetsPerLanguage());
})->name('langChartData');

$app->get('/tweets-per-day', function () use ($app) {
    $app->response()->header('Content-Type', 'application/json;charset=UTF-8');
    echo json_encode((new Twitter($app))->mapTweetsPerDay());
})->name('dateChartData');

$app->get('/retweeted-count', function () use ($app) {
    $app->response()->header('Content-Type', 'application/json;charset=UTF-8');
    echo json_encode((new Twitter($app))->reTweetsCount());
})->name('retweetedChartData');

$app->get('/tweets-count-per-time', function () use ($app) {
    $app->response()->header('Content-Type', 'application/json;charset=UTF-8');
    echo json_encode((new Twitter($app))->tweetsPerTime());
})->name('tweetsPerTimeChartData');