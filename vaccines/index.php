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
$vaccinationRatePer100 = ((getGeoHiveTotalVaccinations()/$populationIreland)*100);

$populationNorthernIreland = 1893700;
$northernIrelandVaccinationRatePer100 = ((getNITotalVaccinations()/$populationNorthernIreland)*100);

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
                ['Moderna', 'Approved', new Date("2021-1-6"), new Date("<?php echo $currentDate; ?>")],
                ['AstraZeneca', 'Approved', new Date('2021-01-29'), new Date("<?php echo $currentDate; ?>")]]);

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
        <!-- Start of of tab-content -->
        <div class="tab-content" id="pills-tabContent">

            <!-- Start of ROI tab-content -->
            <div class="tab-pane fade show active" id="Ireland" role="tabpanel" aria-labelledby="pills-home-tab">

        <div class="row mt-3 pt-3">
            <div class="col-md-6">
                <!-- Card group -->
                <div class="card-group">

                    <!-- Card -->
                    <div class="card mb-4">
                        <!-- Card content -->
                        <div class="card-body">
                            <!-- Title -->
                            <h6 class="card-title">First dose vaccinations </h6>
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
                            <h6 class="card-title">Second dose vaccinations</h6>
                            <!-- Text -->
                            <p class="card-text green-text"><i class="fas fa-chart-line fa-2x"></i><span class="ml-2"
                                                                                                          style="font-size: 30px;"><?php echo number_format(getGeoHiveSecondDoseTotals()); ?></span>
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
                            <h6 class="card-title" style="text-underline-position: under; text-decoration:underline; text-decoration-style: dotted;" data-toggle="tooltip" title="Based on Irish population of <?php echo number_format($populationIreland); ?> from the CSO's April 2020 estimate.">Vaccinations per 100 people</h6>
                            <!-- Text -->
                            <p class="card-text blue-text"><i class="fas fa-user-shield fa-2x"></i><span class="ml-2"
                                                                                                          style="font-size: 30px;"><?php echo round($vaccinationRatePer100, 2); ?></span>/100
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
                            <h6 class="card-title">Total vaccinations</h6>
                            <!-- Text -->
                            <p class="card-text red-text"><i class="fas fa-syringe fa-2x"></i></i><span class="ml-2"
                                                                                                        style="font-size: 30px;"><?php echo number_format(getGeoHiveTotalVaccinations()); ?></span>
                            </p>
                        </div>
                        <!-- Card content -->
                    </div>
                    <!-- Card -->
                </div>
                <!-- Card group -->
            </div>



        </div>
        <!-- Ireland Vaccine Tracker Chart -->
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted card-subtitle mb-2">Total vaccines administered by date reported<br></h6>
                        <p class="card-text">
                            <canvas id="VaccinationsByDate"></canvas>
                            <b>Source:</b> Our World in Data
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Ireland Vaccine Tracker Chart End -->

            </div>
            <!-- End of ROI tab-content -->

            <!-- Start of NI tab-content -->
            <div class="tab-pane fade" id="NorthernIreland" role="tabpanel" aria-labelledby="pills-profile-tab">


                <div class="row mt-3 pt-3">
                    <div class="col-md-6">
                        <!-- Card group -->
                        <div class="card-group">

                            <!-- Card -->
                            <div class="card mb-4">
                                <!-- Card content -->
                                <div class="card-body">
                                    <!-- Title -->
                                    <h6 class="card-title">First dose vaccinations </h6>
                                    <!-- Text -->
                                    <p class="card-text red-text"><i class="fas fa-chart-line fa-2x"></i><span class="ml-2" style="font-size: 30px;"><?php echo number_format(getNIFirstDoseTotal()); ?></span>
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
                                    <h6 class="card-title">Second dose vaccinations</h6>
                                    <!-- Text -->
                                    <p class="card-text green-text"><i class="fas fa-chart-line fa-2x"></i><span class="ml-2"
                                                                                                                 style="font-size: 30px;"><?php echo number_format(getNISecondDoseTotal()); ?></span>
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
                                    <h6 class="card-title" style="text-underline-position: under; text-decoration:underline; text-decoration-style: dotted;" data-toggle="tooltip" title="Based on NI population of <?php echo number_format($populationNorthernIreland); ?> from NISRA mid-year 2019 estimates.">Vaccinations per 100 people</h6>
                                    <!-- Text -->
                                    <p class="card-text blue-text"><i class="fas fa-user-shield fa-2x"></i><span class="ml-2"
                                                                                                                 style="font-size: 30px;"><?php echo round($northernIrelandVaccinationRatePer100, 2); ?></span>/100
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
                                    <h6 class="card-title">Total vaccinations</h6>
                                    <!-- Text -->
                                    <p class="card-text red-text"><i class="fas fa-syringe fa-2x"></i></i><span class="ml-2"
                                                                                                                style="font-size: 30px;"><?php echo number_format(getNITotalVaccinations()); ?></span>
                                    </p>
                                </div>
                                <!-- Card content -->
                            </div>
                            <!-- Card -->
                        </div>
                        <!-- Card group -->
                    </div>



                </div>
                <!-- Ireland Vaccine Tracker Chart -->
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="text-muted card-subtitle mb-2">Total vaccines administered by date reported<br></h6>
                                <p class="card-text">
                                    <canvas id="NIVaccinationsByDate"></canvas>
                                    <b>Source:</b> Our World in Data
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Ireland Vaccine Tracker Chart End -->

















            </div>
            <!-- End of NI tab-content -->

        </div>
        <!-- End of tab-content -->

        <hr>
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist" >
            <li class="nav-item">
                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#Ireland" role="tab" aria-controls="pills-home" aria-selected="true">Ireland</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#NorthernIreland" role="tab" aria-controls="pills-profile" aria-selected="false">Northern Ireland</a>
            </li>
        </ul>

        <!-- Our World in Data | EU Chart -->
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted card-subtitle mb-2">Vaccinations per 100 people in the European Union</h6>

                        <iframe src="https://ourworldindata.org/grapher/covid-vaccination-doses-per-capita?tab=chart&stackMode=absolute&time=latest&country=AUT~BEL~BGR~HRV~CYP~CZE~DNK~EST~European%20Union~FIN~FRA~DEU~GRC~HUN~ISL~IRL~ITA~LVA~LUX~MLT~NLD~POL~PRT~ROU~SVK~SVN~ESP~SWE&region=World" loading="lazy" style="width: 100%; height: 600px; border: 0px none;"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <!-- Our World in Data | EU Chart End -->
        <br>

        <!-- Vaccine Tracker -->
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
        <!-- Vaccine Tracker End-->

        <br>

    </div> <!-- container end -->
</div>
<br>


<!-- Charts -->

<!-- Republic of Ireland - Vaccine Chart using OWID Data -->
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
<!-- Northern Ireland - Vaccine Chart using OWID Data -->
<script>
    var ctx = document.getElementById('NIVaccinationsByDate').getContext('2d');
    var ROIChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [<?php getNIChartVaccinationDates(); ?>],
            datasets: [

                {
                    label: 'Vaccines Administered',
                    data: [<?php getNIChartTotalVaccinations(); ?>],
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
<!-- Modal -->
<div class="modal fade" id="dataSourceModal" tabindex="-1" role="dialog" aria-labelledby="dataSourceModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataSourceModalLabel">Data Sources</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <B>Our World in Data</B><br>
                <li><a href="https://raw.githubusercontent.com/owid/covid-19-data/master/public/data/vaccinations/country_data/Ireland.csv">Ireland</a></li>
                <li><a href="https://raw.githubusercontent.com/owid/covid-19-data/master/public/data/vaccinations/country_data/Northern%20Ireland.csv">Northern Ireland</a></li>
                <li><a href="https://ourworldindata.org/grapher/covid-vaccination-doses-per-capita?tab=chart&stackMode=absolute&time=latest&country=AUT~BEL~BGR~HRV~CYP~CZE~DNK~EST~European%20Union~FIN~FRA~DEU~GRC~HUN~ISL~IRL~ITA~LVA~LUX~MLT~NLD~POL~PRT~ROU~SVK~SVN~ESP~SWE&region=World">Country comparison chart</a></li>
                <hr>
                <b>Ireland's COVID-19 Data Hub</b>
                <li><a href="https://services-eu1.arcgis.com/z6bHNio59iTqqSUY/arcgis/rest/services/Covid19_Vaccine_Administration_Data_View/FeatureServer/0/query?where=1%3D1&objectIds=&time=&geometry=&geometryType=esriGeometryEnvelope&inSR=&spatialRel=esriSpatialRelIntersects&resultType=none&distance=0.0&units=esriSRUnit_Meter&returnGeodetic=false&outFields=*&returnGeometry=true&featureEncoding=esriDefault&multipatchOption=xyFootprint&maxAllowableOffset=&geometryPrecision=&outSR=&datumTransformation=&applyVCSProjection=false&returnIdsOnly=false&returnUniqueIdsOnly=false&returnCountOnly=false&returnExtentOnly=false&returnQueryGeometry=false&returnDistinctValues=false&cacheHint=false&orderByFields=&groupByFieldsForStatistics=&outStatistics=&having=&resultOffset=&resultRecordCount=&returnZ=false&returnM=false&returnExceededLimitFeatures=true&quantizationParameters=&sqlFormat=none&f=html&token=">Daily vaccination statistics</a></li>
                <hr>
                <b>GOV.UK - Northern Ireland</b><br>
                <li><a href="https://api.coronavirus.data.gov.uk/v2/data?areaType=nation&areaCode=N92000002&metric=cumPeopleVaccinatedCompleteByPublishDate&metric=cumPeopleVaccinatedFirstDoseByPublishDate&metric=cumPeopleVaccinatedSecondDoseByPublishDate&format=json">Daily vaccination statistics</a></li>
                <hr>
                <b>Population Figures</b><br>
                <li>Ireland (<?php echo number_format($populationIreland); ?>)</li>
                <li>Northern Ireland (<?php echo number_format($populationNorthernIreland); ?>)</li>
            </div>
        </div>
    </div>
</div>


<div class="footer-basic" style="background-color: #f0f0f0">
    <footer>
        <ul class="list-inline">
            <li class="list-inline-item"><a  data-toggle="tooltip" title="Changes to attributes will be made as more data becomes available. Be warned!" href="/vaccines/json/"><i class="fas fa-code"></i> Vaccine Data as JSON</a></li>
            <li class="list-inline-item"><a
                        href="#dataSourceModal" data-toggle="modal" data-target="#dataSourceModal"><i class="fas fa-database"></i> Data Sources</a></li>
            <li class="list-inline-item"><a
                        href="https://github.com/ShaneHastings/covid19.shanehastings.eu/tree/main/vaccines"
                        target="_blank"><i class="fab fa-github"></i> GitHub</a></li>
            <li class="list-inline-item"><a href="https://twitter.com/ShaneHastingsIE"><i class="fab fa-twitter"></i>
                    Contact</a></li>
        </ul>
        <p class="copyright">Vaccine data for graph sourced from <b><a style="text-decoration: none; color: #4b4c4d"
                                                             href="https://ourworldindata.org/covid-vaccinations">Our
                    World in Data</a></b>'s open data sources on GitHub. Other vaccination data sourced from COVID-19 Data Hub and the EMA.<br>
            Vaccinations per 100 people based on Irish population of <?php echo number_format($populationIreland); ?> from the <a href="https://www.cso.ie/en/releasesandpublications/er/pme/populationandmigrationestimatesapril2020/">CSO's April 2020 estimate</a>.</p>
    </footer>
</div>

<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

</body>

</html>