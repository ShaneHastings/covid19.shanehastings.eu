<?php
/*  COVID-19 API Wrapper for vaccines
 *  @author Shane Hastings
 *  @version 1.0
 */

// Set timezone, will be needed when GeoHive data is available.
date_default_timezone_set('Europe/Dublin');
require('vaccineData.php');
// Assign 3-column row data.
$vaccineData = getLatestVaccineData();
// 40000/4,977,400*100 calculate rate per 100

$populationIreland = 4977400;
$vaccinationRatePer100 = ((getGeoHiveFirstDoseTotals()/$populationIreland)*100);

$currentDate =  date('Y-m-d');

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-54144087-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-54144087-3');
    </script>

    <!-- SEO / Social Stuff -->
    <title>COVID-19 Vaccine Rollout Data | Ireland </title>
    <meta name="title" content="COVID-19 Vaccine Rollout Data | Ireland">
    <meta name="description" content="COVID-19 vaccine rollout data, using official data sources.">
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://covid19.shanehastings.eu/vaccines/">
    <meta property="og:title" content="COVID-19 Vaccine Rollout Data | Ireland">
    <meta property="og:description" content="COVID-19 vaccine rollout data, using official data sources.">
    <meta property="og:image" content="https://covid19.shanehastings.eu/vaccines/social.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://covid19.shanehastings.eu/vaccines/">
    <meta property="twitter:title" content="COVID-19 Vaccine Rollout Data | Ireland">
    <meta property="twitter:description" content="COVID-19 vaccine rollout data, using official data sources.">
    <meta property="twitter:image" content="https://covid19.shanehastings.eu/vaccines/social.png">
    <!-- End of SEO -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="../assets/css/Footer-Basic.css">
    <meta name="theme-color" content="#00BFF3">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"
          integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w=="
          crossorigin="anonymous"/>
    <meta name=”description”
          content="Dashboard showing daily swab data for COVID-19 in Ireland. All data is sourced directly from the Government of Ireland's Open Data Hub for COVID-19.">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
            integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"
            integrity="sha512-s+xg36jbIujB2S2VKfpGmlC3T5V2TF3lY48DX7u2r9XzGzgPsa6wTpOQA7J9iffvdeBN0q9tKzRxVxw1JviZPg=="
            crossorigin="anonymous"></script>
    <style>

    </style>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", {packages: ["timeline"]});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var container = document.getElementById('approvedVaccineTimeline');
            var chart = new google.visualization.Timeline(container);
            var dataTable = new google.visualization.DataTable();

            dataTable.addColumn({type: 'string', id: 'Vaccine'});
            dataTable.addColumn({type: 'string', id: 'ApprovalStatus'});
            dataTable.addColumn({type: 'date', id: 'Start'});
            dataTable.addColumn({type: 'date', id: 'End'});
            dataTable.addRows([
                ['Pfizer/BioNTech', 'Approved', new Date('2020-12-21'), new Date("<?php echo $currentDate; ?>")],
                ['Moderna', 'Approved', new Date("2021-1-6"), new Date("<?php echo $currentDate; ?>")]]);

            var options = {
                timeline: {groupByRowLabel: false},
                colors: ['green', 'green']
            };

            chart.draw(dataTable, options);

            // Source for approved vaccines: https://www.ema.europa.eu/en/human-regulatory/overview/public-health-threats/coronavirus-disease-covid-19/treatments-vaccines/treatments-vaccines-covid-19-authorised-medicines
        }
    </script>

    <script type="text/javascript">
        google.charts.load("current", {packages: ["timeline"]});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var container = document.getElementById('unapprovedVaccineTimeline');
            var chart = new google.visualization.Timeline(container);
            var dataTable = new google.visualization.DataTable();

            dataTable.addColumn({type: 'string', id: 'Vaccine'});
            dataTable.addColumn({type: 'string', id: 'ApprovalStatus'});
            dataTable.addColumn({type: 'date', id: 'Start'});
            dataTable.addColumn({type: 'date', id: 'End'});
            dataTable.addRows([
                ['AstraZeneca', 'Rolling Review', new Date('2020-10-01'), new Date("2021-01-12")],
                ['AstraZeneca', 'Conditional Marketing Authorisation - Under Review', new Date('2021-01-12'), new Date("<?php echo $currentDate; ?>")],
                ['Johnson & Johnson', 'Rolling Review', new Date("2020-12-01"), new Date("<?php echo $currentDate; ?>")]]);

            var options = {
                timeline: {groupByRowLabel: true},
                colors: ['orange', 'red']
            };

            chart.draw(dataTable, options);

            // Source for rolling review/CMA data: https://www.ema.europa.eu/en/human-regulatory/overview/public-health-threats/coronavirus-disease-covid-19/treatments-vaccines/treatments-vaccines-covid-19-medicines-under-evaluation
        }
    </script>
</head>

<body>

<div>
    <nav class="navbar navbar-light navbar-expand-md" style="background: #00BFF3;">
        <div class="container-fluid"><a class="navbar-brand" href="/vaccines"
                                        style="color: white; font-family: Lato, sans-serif;padding-top: 5px;"><strong>COVID-19
                    Vaccine Rollout</strong><br><?php echo date('l, jS F Y', strtotime(getGeoHiveFirstDoseTotalsDate())); ?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">

                <li class="nav-item ">
                    <a class="nav-link" href="/api/swabs/">Swabs</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="/cases">Cases</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="/vaccines">Vaccines</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="/vaccines/img/"><i class="fas fa-share-square"></i></a>
                </li>

                <li class="nav-item ">
                    <a class="nav-link" href="https://twitter.com/COVID19DataIE"><i class="fab fa-twitter"></i></a>
                </li>

            </ul>

        </div>
    </nav>
    <div class="container">
        <br>
        <div class="alert alert-info" role="alert">
            Granular vaccination information is not yet available, so this is quite bare for now. The data shown below
            will be updated when more becomes available.
        </div>

        <div class="row mt-3 pt-3">
            <div class="col-md-6">
                <!-- Card group -->
                <div class="card-group">

                    <!-- Card -->
                    <div class="card mb-4">
                        <!-- Card content -->
                        <div class="card-body">
                            <!-- Title -->
                            <h6 class="card-title">Total vaccinations given </h6>
                            <!-- Text -->
                            <p class="card-text red-text"><i class="fas fa-chart-line fa-2x"></i><span class="ml-2" style="font-size: 30px;"><?php echo number_format(getGeoHiveFirstDoseTotals()); ?></span>
                            </p>
                        </div>
                        <!-- Card content -->
                    </div>
                    <!-- Card -->
                    <!-- Card -->
                    <div class="card mb-4">
                        <!-- Card content -->
                        <div class="card-body">
                            <!-- Title -->
                            <h6 class="card-title">Vaccinations per 100 people</h6>
                            <!-- Text -->
                            <p class="card-text green-text"><i class="fas fa-user-shield fa-2x"></i><span class="ml-2"
                                                                                                          style="font-size: 30px;"><?php echo round($vaccinationRatePer100, 2); ?></span>/100
                            </p>
                        </div>
                        <!-- Card content -->
                    </div>
                    <!-- Card -->
                </div>
                <!-- Card group -->
            </div>

            <div class="col-md-6">
                <!-- Card group -->
                <div class="card-group">
                    <!-- Card -->
                    <div class="card mb-4">
                        <!-- Card content -->
                        <div class="card-body">
                            <!-- Title -->
                            <h6 class="card-title">Vaccines given today</h6>
                            <!-- Text -->
                            <p class="card-text blue-text"><i class="fas fa-calendar-day fa-2x"></i><span class="ml-2"
                                                                                                          style="font-size: 30px;">n/a</span>
                            </p>
                        </div>
                        <!-- Card content -->
                    </div>
                    <!-- Card -->
                    <!-- Card -->
                    <div class="card mb-4">
                        <!-- Card content -->
                        <div class="card-body">
                            <!-- Title -->
                            <h6 class="card-title">People fully vaccinated</h6>
                            <!-- Text -->
                            <p class="card-text red-text"><i class="fas fa-syringe fa-2x"></i></i><span class="ml-2"
                                                                                                        style="font-size: 30px;">n/a</span>
                            </p>
                        </div>
                        <!-- Card content -->
                    </div>
                    <!-- Card -->
                </div>
                <!-- Card group -->
            </div>



        </div>



        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted card-subtitle mb-2">Vaccines administered by manufacturer<br></h6>
                        <p class="card-text">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Vaccine</th>
                                <th>Amount Administered</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><?php echo $vaccineData['vaccineType']; ?></td>
                                <td><?php echo number_format($vaccineData['vaccinesGiven']); ?></td>
                                <td><?php echo date('d M Y', strtotime($vaccineData['date'])); ?></td>
                            </tr>
                            </tbody>
                        </table>
                        <b>Source: </b>Our World in Data.
                        </p>

                    </div>
                </div>
            </div>
        </div>

        <br>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted card-subtitle mb-2">Total vaccines administered by date reported<br></h6>
                        <p class="card-text">
                            <canvas id="VaccinationsByDate"></canvas>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted card-subtitle mb-2">Approved Vaccines<br></h6>
                        <div id="approvedVaccineTimeline" style="height: 200px;"></div>
                        <h6 class="text-muted card-subtitle mb-2">Under review<br></h6>
                        <div id="unapprovedVaccineTimeline" style="height: 200px;"></div>

                        <p class="card-text"><b>Source: </b> <a
                                    href="https://www.ema.europa.eu/en/human-regulatory/overview/public-health-threats/coronavirus-disease-covid-19/treatments-vaccines/treatments-vaccines-covid-19-authorised-medicines">Approved
                                Vaccines</a> | <a
                                    href="https://www.ema.europa.eu/en/human-regulatory/overview/public-health-threats/coronavirus-disease-covid-19/treatments-vaccines/treatments-vaccines-covid-19-medicines-under-evaluation">Vaccines
                                under review</a></p>
                    </div>
                </div>
            </div>
        </div>


    </div> <!-- container end -->
</div>
<br>


<!-- Charts -->
<script>
    var ctx = document.getElementById('VaccinationsByDate').getContext('2d');
    var ROIChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [<?php getChartVaccinationDates(); ?>],
            datasets: [

                {
                    label: 'Vaccines Administered',
                    data: [<?php getChartTotalVaccinations(); ?>],
                    backgroundColor: [
                        'rgba(0, 191, 243, 0.5)',

                    ],
                    borderColor: [
                        'rgba(0, 0, 0, 1)',

                    ],
                    borderWidth: 1.2
                }]
        },
        options: {

            elements: {},
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },

        },

    });

</script>


<div class="footer-basic" style="background-color: #f0f0f0">
    <footer>
        <ul class="list-inline">
            <li class="list-inline-item"><a
                        href="https://github.com/owid/covid-19-data/tree/master/public/data/vaccinations"
                        target="_blank"><i class="fas fa-database"></i> Data Source</a></li>
            <li class="list-inline-item"><a
                        href="https://github.com/ShaneHastings/covid19.shanehastings.eu"
                        target="_blank"><i class="fab fa-github"></i> GitHub</a></li>
            <li class="list-inline-item"><a href="https://twitter.com/ShaneHastingsIE"><i class="fab fa-twitter"></i>
                    Contact</a></li>
        </ul>
        <p class="copyright">Vaccine data sourced from <b><a style="text-decoration: none; color: #4b4c4d"
                                                             href="https://ourworldindata.org/covid-vaccinations">Our
                    World in Data</a></b>'s open data sources on GitHub. Total vaccination data sourced from COVID-19 Data Hub.<br>
            Vaccinations per 100 people based on Irish population of <?php echo number_format($populationIreland); ?> from the <a href="https://www.cso.ie/en/releasesandpublications/er/pme/populationandmigrationestimatesapril2020/">CSO's April 2020 estimate</a>.</p>
    </footer>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

</body>

</html>