<ons-page id="vaccines">
    <ons-toolbar>
        <div class="left"><ons-back-button>Back</ons-back-button></div>
        <div class="center"><i class="fas fa-syringe"></i> Ireland's Vaccine Rollout</div>
    </ons-toolbar>

    <ons-row style="padding-left: 10px">
        <h1>Vaccinations on <?php echo date('l, F jS', strtotime(getGeoHiveFirstDoseTotalsDate())); ?></h1>
    </ons-row>

    <ons-row>
        <ons-col>
            <ons-card>
                <div class="title">
                    <i class="fas fa-shield-alt"></i> First dose
                </div>
                <div class="content">
                    <headlineFigure><?php echo getDailyDoseChanges("firstDoseDifference"); ?></headlineFigure>
                </div>
            </ons-card>
        </ons-col>

        <ons-col>
            <ons-card>
                <div class="title">
                    <i class="fas fa-user-shield"></i> <a onclick="secondDoseInfoAlert()">Fully vaccinated</a>
                </div>
                <div class="content">
                    <headlineFigure><?php echo getDailyDoseChanges("secondDoseDifference"); ?></headlineFigure>
                </div>
            </ons-card>
        </ons-col>

    </ons-row>




    <ons-row style="padding-left: 10px">
        <h1>Overall progress</h1>
    </ons-row>

    <ons-row>
        <ons-col>

            <ons-card>
                <div class="title">
                    <i class="fas fa-chart-line fa"></i> First dose
                </div>
                <div class="content">
                    <headlineFigure><?php echo number_format(getGeoHiveFirstDoseTotals()); ?></headlineFigure>
                    <ons-progress-bar value="<?php echo $firstDosePercent; ?>" secondary-value="100"></ons-progress-bar>

                </div>
            </ons-card>

        </ons-col>
        <ons-col>

            <ons-card>
                <div class="title">
                    <i class="fas fa-chart-line fa"></i> Fully vaccinated
                </div>
                <div class="content">
                    <headlineFigure><?php echo number_format(getGeoHiveSecondDoseTotals()); ?></headlineFigure>
                    <ons-progress-bar value="<?php echo $secondDosePercent; ?>" secondary-value="100"></ons-progress-bar>

                </div>
            </ons-card>

        </ons-col>

        <ons-col>

            <ons-card>
                <div class="title">
                    <i class="fas fa-syringe"></i> Total vaccinations
                </div>
                <div class="content">
                    <headlineFigure><?php echo number_format(getGeoHiveTotalVaccinations()); ?></headlineFigure>

                </div>
            </ons-card>

        </ons-col>
    </ons-row>

    <ons-row>
        <ons-card style="width: 100%">
            <div class="title">
                Vaccinations per day
            </div>
            <div class="content">
                <div id="ROIVaccinationsPerDayChart"></div>
                <!-- Republic of Ireland - Daily vaccinations bar chart  -->
                <script>
                    var options = {
                        series: [{
                            name: 'First Dose',
                            type: 'bar',
                            data: [<?php echoDailyFirstDose();?>]
                        }, {
                            name: 'Second Dose',
                            type: 'bar',
                            data: [<?php echoDailySecondDose();?>]
                        }, {
                            name: '7 day average',
                            type: 'line',
                            data: [0,0,0,0,0,0,<?php getSevenDayAveragesChart(); ?> ]
                        }],
                        chart: {
                            foreColor: '#ffffff',
                            height: 400,
                            stacked: true,
                            toolbar: {
                                show: false
                            },
                            zoom: {
                                enabled: true
                            }
                        },
                        stroke: {
                            show: true,
                            curve: 'smooth',
                            lineCap: 'butt',
                            colors: undefined,
                            width: [0,0,4],
                            dashArray: [0,0,2],
                        },
                        responsive: [{
                            breakpoint: 1000,
                            options: {
                                chart: {
                                    height: '300px'
                                },
                                dataLabels: {
                                    enabled: false,
                                },
                                xaxis: {
                                    tickAmount: 8,
                                },

                            },

                        }],
                        plotOptions: {
                            bar: {
                                borderRadius: 0,
                                horizontal: false,

                            },
                        },
                        xaxis: {
                            categories: [<?php echoDailyDoseDate();?>
                            ],
                            tickAmount: 20,
                        },
                        yaxis: {
                            min: 0,
                            max: <?php echo getLargestDailyTotal(); ?>,
                            forceNiceScale: true,

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
                        },
                        dataLabels: {
                            enabled: false,
                            enabledOnSeries: true,
                            formatter: function (val, opts) {
                                if (val >= 1000) {
                                    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                }
                                return val;
                            },
                            textAnchor: 'middle',
                            distributed: false,
                            offsetX: 0,
                            offsetY: 0,
                            style: {
                                fontSize: '8px',
                                fontFamily: 'Helvetica, Arial, sans-serif',
                                fontWeight: 'bold',
                                colors: undefined
                            },
                            background: {
                                enabled: true,
                                foreColor: '#fff',
                                padding: 4,
                                borderRadius: 2,
                                borderWidth: 1,
                                opacity: 0,
                            },
                            dropShadow: {
                                enabled: false,
                                top: 1,
                                left: 1,
                                blur: 1,
                                color: '#000',
                                opacity: 0.45
                            }
                        },
                        fill: {
                            opacity: 1
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#ROIVaccinationsPerDayChart"), options);
                    chart.render();

                </script>
            </div>
        </ons-card>

    </ons-row>

    <ons-row>
        <ons-card style="width: 100%">
            <div class="title">
                Vaccines administered in Ireland
            </div>
            <div class="content">
                <div id="ROIVaccinationsChart"></div>
                <script>
                    var options = {
                        series: [{
                            name: 'Total vaccinations',
                            data: [<?php getChartTotalVaccinations(); ?>]
                        }, {
                            name: 'Total fully vaccinated',
                            data: [<?php getChartTotalFullyVaccinations(); ?>],
                        }],

                        chart: {
                            height: 480,
                            type: 'area',
                            foreColor: '#ffffff',
                            zoom: {
                                enabled: false
                            },
                            toolbar: {
                                show: false,
                            },
                            animations: {
                                enabled: false,
                                easing: 'easein',
                                speed: 800,
                                animateGradually: {
                                    enabled: false,
                                    delay: 150
                                },
                                dynamicAnimation: {
                                    enabled: true,
                                    speed: 350
                                }
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth'
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
                                    tickAmount: 10,
                                },
                                yaxis: {
                                    tickAmount: 5,
                                },
                                markers: {
                                    size: 0,

                                },
                                stroke: {
                                    curve: 'smooth',
                                    width: 2,

                                },
                            }
                        },{
                            breakpoint: 960,
                            options: {
                                chart: {
                                    height: '300px'
                                },
                                xaxis: {
                                    tickAmount: 15,
                                },
                                yaxis: {
                                    tickAmount: 5,
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

                        annotations: {
                            xaxis: [{
                                x: '09-Feb-2021',
                                strokeDashArray: 0,
                                borderColor: '#775DD0',
                                label: {
                                    borderColor: '#775DD0',
                                    style: {
                                        color: '#fff',
                                        background: '#775DD0',
                                    },
                                    orientation: "horizontal",
                                    text: 'AztraZeneca Rollout',
                                }
                            }]
                        },
                        xaxis: {
                            tickAmount: 30,
                        },
                        /* Mobile options end */
                        labels: [<?php getChartVaccinationDates(); ?>],
                        tooltip: {
                            theme: 'dark',
                            y: {
                                /* Add comma separator. e.g. 1000 -> 1,000 */
                                formatter: function (y) {
                                    if (y >= 1000) {
                                        return y.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                    }
                                    return y;

                                },

                            }
                        },
                    };

                    var chartROIVax = new ApexCharts(document.querySelector("#ROIVaccinationsChart"), options);
                    chartROIVax.render();

                </script>
            </div>
        </ons-card>

    </ons-row>




</ons-page>