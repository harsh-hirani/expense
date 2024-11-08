<?php
include './auth/auth.php';
if (!$islogedin) {
    header('Location: ./unauth.php');
} else {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $_COOKIE['namee'] ?> | Dashboard</title>
        <?php include './base/css.php'; ?>
        <style>
            * {
                box-sizing: border-box;
                margin: 0px;
                padding: 0px;
            }

            .chart {
                width: 50%;
                max-height: 400px;
                margin: 20px auto;

            }

            .bar {
                width: 100%;
            }

            .chart-main {
                display: flex;
                justify-content: space-around;
                margin: 20px;
            }

            .cen {
                display: flex;
                align-items: center;
                justify-content: center;
                flex-direction: column;
                border-radius: 20px;
                padding: 0px;
                box-shadow: 3px 4px 45px 1px #ccc;
                border: 1px dotted #000;
                max-width: 100vw;
                min-width: 45vw;
            }

            @media (max-width: 768px) {
                .chart-main {
                    flex-direction: column;
                }

                .cen {
                    border-radius: 15px;
                    margin-top: 10px;

                }

                .chart {
                    width: auto;
                }
            }
        </style>
    </head>

    <body>
        <?php include './comps/nav.php'; ?>
        <div class="chart-main">
            <div class=" cen">
                <div id="chart1" class="chart"></div>
                <div class="title">
                    Total Expenses by Category
                </div>
            </div>
            <div class="cen">
                <div id="chart2" class="chart"></div>
                <div class="title">
                    Total Expenses by Frequency
                </div>
            </div>
        </div>
        <div class="chart-main">
            <div class=" cen">
                <div id="bar" class=" bar"></div>
                <div class="title">
                    expense by month
                </div>
            </div>
            <div class="cen">
                <div id="chart2" class="chart"></div>
                <div class="title">
                    Total Expenses This Month: <span id="total">0</span>
                </div>
            </div>
        </div>

        <?php include './base/js.php'; ?>
        <?php include './base/chartjs.php'; ?>
        <script>
            var chart1, chart2;
            $.post('./api/chart.php', {
                min: 0,
                max: Date.now() / 1000,
            }, function(data, status) {
                console.log(data, status);
                let labels_cate = data.entries.map(e => e.cate + "-" + e.total);
                let labels_tms = data.entries.map(e => e.cate + "-" + e.tms);
                let series_cate = data.entries.map(e => parseFloat(e.total));
                let series_tms = data.entries.map(e => parseFloat(e.tms));
                var total_display = document.getElementById('total');
                total_display.innerText = series_cate.reduce((a, b) => a + b, 0);
                var options1 = {
                    series: series_cate,
                    chart: {
                        type: 'donut',
                    },
                    labels: labels_cate,
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 350
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };
                var options2 = {
                    series: series_tms,
                    chart: {
                        type: 'donut',
                    },
                    labels: labels_tms,
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 350
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                chart1 = new ApexCharts(document.querySelector("#chart1"), options1);
                chart1.render();
                chart2 = new ApexCharts(document.querySelector("#chart2"), options2);
                chart2.render();
            });
            $.post("./api/bar.php", {}, (d) => {
                console.log(d)

                var options = {
                    series: [{
                        name: 'total',
                        data: d.entries.map(e => e.total_expense)
                    }, {
                        name: 'Food',
                        data: d.entries.map(e => e.Food)
                    }, {
                        name: 'Travel',
                        data: d.entries.map(e => e.Travel)
                    }, {
                        name: 'Shopping',
                        data: d.entries.map(e => e.Shopping)
                    }, {
                        name: 'Medical',
                        data: d.entries.map(e => e.Medical)
                    }, {
                        name: 'Fun',
                        data: d.entries.map(e => e.Fun)
                    }, {
                        name: 'Other',
                        data: d.entries.map(e => e.Other)
                    },
                ],
                    chart: {
                        height: 350,
                        type: 'area'
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth'
                    },
                    xaxis: {
                        type: 'datetime',
                        categories: d.days
                        // categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
                    },
                    tooltip: {
                        x: {
                            format: 'dd/MM/yy'
                        },
                    },
                };

                var bar = new ApexCharts(document.querySelector("#bar"), options);
                bar.render();
            });
            // setInterval(function() {
            //     $.post('./api/chart.php', {
            //     min: 0,
            //     max: Date.now()/1000,
            // }, function(data, status) {
            //     console.log(data);
            //     let labels = data.entries.map(e=>e.cate);
            //     let series = data.entries.map(e=>parseFloat(e.total));



            //     // updateOptions(options);
            //     // chart.updateOptions({series,labels});
            // });
            // }, 10000);
        </script>
    </body>

    </html>


<?php
}
