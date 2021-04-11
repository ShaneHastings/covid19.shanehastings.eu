<ons-page id="settings">
    <ons-toolbar>
        <div class="left">
            <ons-back-button>Back</ons-back-button>
        </div>
        <div class="center"><i class="fas fa-vial"></i> COVID-19 Testing</div>
        <div style="padding-right: 15px" class="right"><a onclick="updateTestingData();"><i class="fas fa-sync"></i></a>
        </div>
    </ons-toolbar>


    <ons-row style="padding-left: 10px">
        <h1 id="testingDataDate"><?php echo date("l, F jS Y", strtotime($testingDataArray['date'])); ?></h1>
    </ons-row>
    <ons-row style="padding-left: 10px">
        Last checked at&nbsp;<currentTime id="curTime"></currentTime>

        <script>
            var today = new Date();
            var time = today.toLocaleTimeString();
            document.getElementById("curTime").innerText = time;
        </script>
    </ons-row>

    <ons-row>
        <ons-col>

            <ons-card>
                <div class="title">
                    <i class="fas fa-user-plus"></i> Positive swabs
                </div>
                <div class="content">
                    <headlineFigure
                            id="positiveTests"><?php echo number_format($testingDataArray['positive_swabs']); ?></headlineFigure>
                </div>
            </ons-card>

        </ons-col>
        <ons-col>

            <ons-card>
                <div class="title">
                    <i class="fas fa-percentage"></i> Positivity
                </div>
                <div class="content">
                    <headlineFigure
                            id="positivityRate"><?php echo $testingDataArray['positivity_rate']; ?></headlineFigure>
                </div>
            </ons-card>

        </ons-col>
    </ons-row>
    <ons-row>
        <ons-col>

            <ons-card>
                <div class="title">
                    <i class="fas fa-vial"></i> Total tests
                </div>
                <div class="content">
                    <headlineFigure
                            id="totalTests"><?php echo number_format($testingDataArray['swabs_24hr']); ?></headlineFigure>

                </div>
            </ons-card>

        </ons-col>

        <ons-col>

            <ons-card>
                <div class="title">
                    <i class="fas fa-percentage"></i> 7 day positivity
                </div>
                <div class="content">
                    <headlineFigure
                            id="positivityRate7Day"><?php echo $testingDataArray['positivity_rate_7day']; ?></headlineFigure>

                </div>
            </ons-card>

        </ons-col>
    </ons-row>


    <ons-row>
        <ons-card style="width: 100%">
            <div class="title">
                Confirmed cases and positive tests over the last month
            </div>
            <div class="content">
                <div id="apexCharts-swabsAndCases" style="width: 100%"></div>
                <script>

                    var options = {
                        series: [{
                            name: 'Confirmed Cases',
                            type: 'area',
                            data: [<?php getPositiveCases(); ?> ]
                        }, {
                            name: 'Positive Swabs',
                            type: 'line',

                            data: [<?php getPositiveSwabs(); ?> ]
                        }],
                        chart: {
                            height: '450px',
                            type: 'line',
                            foreColor: '#ffffff',
                            toolbar: {
                                show: false,
                            }
                        },
                        yaxis: {
                            tickAmount: 7,
                            min: 0,
                            forceNiceScale: true,
                        },
                        /* Options for mobile devices. If you display too many x-axis labels it gets fairly messy. */
                        /* x-axis docs: https://apexcharts.com/docs/options/xaxis/ */
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                chart: {
                                    height: '300px'
                                },
                                xaxis: {
                                    tickAmount: 7,
                                },
                                yaxis: {
                                    tickAmount: 5,
                                    min: 0,
                                    forceNiceScale: true,
                                },
                                markers: {
                                    size: 0,

                                },
                                stroke: {
                                    curve: 'smooth',
                                    width: 2,

                                },
                            }
                        }],
                        /* Mobile options end */
                        stroke: {
                            curve: 'smooth',
                            width: 3,

                        },
                        fill: {
                            type: 'solid',
                            opacity: [.1, 1],

                        },
                        labels: [<?php lastXDays(); ?> ],
                        markers: {
                            size: .8,

                        },
                        tooltip: {
                            theme: 'dark',
                            shared: true,
                            y: {
                                /* Add comma separator. e.g. 1000 -> 1,000 */
                                formatter: function (y) {
                                    if (y >= 1000) {
                                        return y.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                    }
                                    return y;

                                }
                            }
                        },
                    };

                    var chart = new ApexCharts(document.querySelector("#apexCharts-swabsAndCases"), options);
                    chart.render();


                </script>
            </div>
        </ons-card>

    </ons-row>

    <ons-row>
        <ons-card style="width: 100%">
            <div class="title">
                Positivity rates over the last month
            </div>
            <div class="content">
                <div id="apexCharts-positivityRates" style="width: 100%"></div>
                <script>
                    var options = {
                        series: [{
                            name: "7 day positivity",
                            data: [<?php getPositiveSwabsAverage(); ?>]
                        },
                            {
                                name: "Daily positivity",
                                data: [<?php getDailySwabsAverage(); ?>]
                            }],
                        chart: {
                            height: 450,
                            foreColor: '#FFFFFF',
                            type: 'line',
                            toolbar: {
                                show: false,
                            }
                        },
                        dataLabels: {
                            enabled: false,
                        },
                        yaxis: {
                            tickAmount: 7,
                            min: 0,
                            forceNiceScale: true,
                            labels: {
                                formatter: function (value) {
                                    return (Math.round(value * 100) / 100).toFixed(2) + "%";
                                }
                            },
                        },
                        /* Options for mobile devices. If you display too many x-axis labels it gets fairly messy. */
                        /* x-axis docs: https://apexcharts.com/docs/options/xaxis/ */
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                chart: {
                                    height: '300px'
                                },
                                xaxis: {
                                    tickAmount: 7,
                                },
                                yaxis: {
                                    tickAmount: 5,
                                    min: 0,
                                    forceNiceScale: true,
                                },
                                markers: {
                                    size: 0,

                                },
                                stroke: {
                                    curve: 'smooth',
                                    width: 2,

                                },
                            }
                        }],
                        /* Mobile options end */
                        stroke: {
                            curve: 'smooth',
                            width: 3,

                        },
                        fill: {
                            type: 'solid',
                            opacity: [1, 1],

                        },
                        markers: {
                            size: .8,

                        },
                        xaxis: {
                            categories: [<?php lastXDaysSwabAverage(); ?>],
                        },
                        tooltip: {
                            theme: 'dark',
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#apexCharts-positivityRates"), options);
                    chart.render();
                </script>
            </div>
        </ons-card>

    </ons-row>

    <ons-row>
        <ons-card style="width: 100%">
            <div class="title">
                Daily tests over the last month
            </div>
            <div class="content">
                <div id="apexCharts-testsLastMonth" style="width: 100%"></div>
                <script>
                    var options = {
                        series: [{
                            name: 'Tests Completed',
                            data: [<?php getTotalSwabs(); ?>]
                        }],
                        chart: {
                            type: 'bar',
                            height: 350,
                            foreColor: '#FFFFFF',
                            toolbar: {
                                show: false,
                            }
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                //columnWidth: '55%',
                                endingShape: 'rounded'
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        /* Options for mobile devices. If you display too many x-axis labels it gets fairly messy. */
                        /* x-axis docs: https://apexcharts.com/docs/options/xaxis/ */
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                chart: {
                                    height: '300px'
                                },
                                xaxis: {
                                    tickAmount: 7,
                                },
                                yaxis: {
                                    tickAmount: 5,
                                    min: 0,
                                    forceNiceScale: true,
                                },
                            }
                        }],
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ['transparent']
                        },
                        xaxis: {
                            categories: [<?php lastXDaysSwabAverage(); ?>],
                        },
                        fill: {
                            opacity: 1
                        },
                        tooltip: {
                            theme: 'dark',
                            y: {
                                /* Add comma separator. e.g. 1000 -> 1,000 */
                                formatter: function (y) {
                                    if (y >= 1000) {
                                        return y.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                    }
                                    return y;

                                }
                            }
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#apexCharts-testsLastMonth"), options);
                    chart.render();
                </script>
            </div>
        </ons-card>

    </ons-row>

    <ons-row>
        <ons-card style="width: 100%">
            <div class="content">
                All data sourced live from the COVID-19 Open Data Hub provided by the Government of Ireland. Laboratory
                Specimen Testing statistics are updated daily at approximately 3pm from Monday to Saturday.
            </div>
        </ons-card>

    </ons-row>

</ons-page>