@extends('layout')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-6">
                <div id="files-panel" class="panel panel-primary">
                    <div class="panel-body">
                        <div class="col-md-4"><span>Select Company:</span></div>
                        <div class="col-md-4">
                            <select id="companies">
                                <option></option>
                                <option>KLM</option>
                                <option>Deloitte</option>
                            </select>
                        </div>
                        <button class="btn btn-success col-md-4" onclick="getAccountData()">Get Data</button>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-default statistics-panel" hidden>
                    <div class="panel-body">
                        <div class="row">
                            <label class="col-md-2" style="text-align: center">Tweets</label>
                            <label class="col-md-5" style="text-align: center">From</label>
                            <label class="col-md-5" style="text-align: center">To</label>
                        </div>
                        <div class="row">
                            <span class="col-md-2" style="text-align: center" id="tweets"></span>
                            <span class="col-md-5" style="text-align: center" id="first_tweet"></span>
                            <span class="col-md-5" style="text-align: center" id="last_tweet"></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default statistics-panel" hidden>
                    <div class="panel-heading">Account info<img id="img_url" src="" style="float: right;"></div>
                    <div class="panel-body">
                        <div class="row">
                            <label class="col-md-2">Name:</label>
                            <span class="col-md-10" id="account"></span>
                        </div>
                        <div class="row">
                            <label class="col-md-2">Company:</label>
                            <span class="col-md-10" id="company"></span>
                        </div>
                        <div class="row">
                            <label class="col-md-2">Location:</label>
                            <span class="col-md-10" id="location"></span>
                        </div>
                        <div class="row">
                            <label class="col-md-2">Created:</label>
                            <span class="col-md-10" id="account_created"></span>
                        </div>
                        <div class="row">
                            <label class="col-md-2">About:</label>
                            <span class="col-md-10" id="desc"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-default statistics-panel" hidden>
                    <div class="panel-heading">Keywords</div>
                    <div class="panel-body">
                        <div class="row">
                            <label class="col-md-3">Count:</label>
                            <span class="col-md-9" id="keywords_count"></span>
                        </div>
                        <div class="row">
                            <label class="col-md-3">Top {{MOST_REPEATED_KEYWORDS}}:</label>
                            <span class="col-md-9" id="top_keywords"></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">

        </div>

        <div class="row">
            <div class="col-md-6" id="lang-chart-container" hidden>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div id="lang-chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 chart" id="date-chart-container" hidden>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div id="date-chart"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6" id="retweeted-chart-container" hidden>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div id="retweeted-chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6" id="tweets-per-time-chart-container" hidden>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div id="tweets-per-time-chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script>
        var accountDataUrl = '{{$app->urlFor('accountData')}}';
        var langChartDataUrl = '{{$app->urlFor('langChartData')}}';
        var dateChartDataUrl = '{{$app->urlFor('dateChartData')}}';
        var retweetedChartDataUrl = '{{$app->urlFor('retweetedChartData')}}';
        var tweetPerTimeChartDataUrl = '{{$app->urlFor('tweetsPerTimeChartData')}}';

    </script>
@endsection