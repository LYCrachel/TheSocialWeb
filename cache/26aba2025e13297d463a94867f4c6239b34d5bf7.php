<?php $__env->startSection('content'); ?>
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
                        <button class="btn btn-success col-md-4" onclick="getAccountData()">Get Account Data</button>
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
                            <label class="col-md-3">Top <?php echo e(MOST_REPEATED_KEYWORDS); ?>:</label>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('custom-js'); ?>
    <script>
        var accountDataUrl = '<?php echo e($app->urlFor('accountData')); ?>';
        var langChartDataUrl = '<?php echo e($app->urlFor('langChartData')); ?>';
        var dateChartDataUrl = '<?php echo e($app->urlFor('dateChartData')); ?>';
        var retweetedChartDataUrl = '<?php echo e($app->urlFor('retweetedChartData')); ?>';
        var tweetPerTimeChartDataUrl = '<?php echo e($app->urlFor('tweetsPerTimeChartData')); ?>';

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>