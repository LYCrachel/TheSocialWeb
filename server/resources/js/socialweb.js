function initLangChart(company) {
    var options = {
        chart: {
            renderTo: 'lang-chart',
            type: 'column',
            allowPointSelect: true,
            zoomType: 'x'
        },
        title: {
            text: 'Tweets per Language'
        },
        xAxis: {
            type: 'category',
            title: {
                text: 'Languages'
            },
            labels: {
                rotation: -45,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 50,
            title: {
                text: 'Tweets Count'
            }
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            enabled: false
        },
        series: [{
            name: 'Tweets',
            dataLabels: {
                enabled: true,
                rotation: -90,
                color: '#FFFFFF',
                align: 'right',
                y: 10 // 10 pixels down from the top
            }
        }]
    };

    $.get(langChartDataUrl, {companyName: company}, function (data) {
        options.series[0].data = data;
        var chart = new Highcharts.Chart(options);
        $("#lang-chart-container").removeAttr('hidden');
    });
}

function initDateChart(company) {

    var options = {
        chart: {
            renderTo: 'date-chart',
            type: 'column',
            allowPointSelect: true,
            zoomType: 'x'
        },
        title: {
            text: 'Tweets per Day'
        },
        xAxis: {
            type: 'category',
            title: {
                text: 'Date'
            },
            labels: {
                rotation: -45,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 50,
            title: {
                text: 'Tweets Count'
            }
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            enabled: false
        },
        series: [{
            name: 'Tweets',
            dataLabels: {
                enabled: true,
                rotation: -90,
                color: '#FFFFFF',
                align: 'right',
                y: 10 // 10 pixels down from the top
            }
        }]
    };

    $.get(dateChartDataUrl, {companyName: company}, function (data) {
        options.series[0].data = data;
        var chart = new Highcharts.Chart(options);
        $("#date-chart-container").removeAttr('hidden');
    });
}

function initRetweetedChart(company) {
    var options = {
        chart: {
            renderTo: 'retweeted-chart',
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'reTweeted Count'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'tweets',
            colorByPoint: true
        }]
    };

    $.get(retweetedChartDataUrl, {companyName: company}, function (data) {
        options.series[0].data = data;
        var chart = new Highcharts.Chart(options);
        $("#retweeted-chart-container").removeAttr('hidden');
    });
}

function inittweetsPerTimeChart(company) {
    var options = {
        chart: {
            renderTo: 'tweets-per-time-chart',
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Tweets Count'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage} %</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },
        series: [{
            name: 'tweets',
            colorByPoint: true
        }]
    };

    $.get(tweetPerTimeChartDataUrl, {companyName: company}, function (data) {
        options.series[0].data = data;
        var chart = new Highcharts.Chart(options);
        $("#tweets-per-time-chart-container").removeAttr('hidden');
    });
}

function getAccountData() {
    var company = $('#companies :selected').text();
    if (company) {
        $.get(accountDataUrl, {companyName: company}, function (data) {
            $("#img_url").attr("src", data.profile_image_url);
            $("#company").html(data.company);
            $("#account").html(data.account);
            $("#location").html(data.location);
            $("#desc").html(data.description);
            $("#following").html(data.following);
            $("#followers").html(data.followers);
            $("#tweets").html(data.tweets);
            $("#account_created").html(data.account_created_at);
            $("#first_tweet").html(data.first_tweet_created_at);
            $("#last_tweet").html(data.last_tweet_created_at);
            $("#keywords_count").html(data.keywords_count);
            $("#top_keywords").html(data.top_keywords);
            $(".statistics-panel").removeAttr('hidden');
            initLangChart(company);
            initDateChart(company);
            initRetweetedChart(company);
            inittweetsPerTimeChart(company);
        });
    }
}