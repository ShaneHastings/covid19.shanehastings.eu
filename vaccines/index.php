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
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
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

</head>

<body>

<div>
    <nav class="navbar navbar-light navbar-expand-md" style="background: #00BFF3;">
        <div class="container-fluid"><a class="navbar-brand" href="/vaccines"
                                        style="color: white; font-family: Lato, sans-serif;padding-top: 5px;"><strong>COVID-19
                    Vaccine Rollout</strong><br><?php echo date('d M Y', strtotime($vaccineData['date'])); ?></a>
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
            is from Our World in Data until vaccine data gets added to the the GeoHive Data Hub.
        </div>
        <div class="row">
            <div class="col-md" style="padding-bottom: 10px;padding-top: 10px;">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Vaccines administered</h5>
                    </div>
                    <div class="card-body">
                        <h2 class="text-center card-text"><?php echo number_format($vaccineData['vaccinesGiven']); ?></h2>
                        <div style="text-align: center;"><h6 class="text-muted card-subtitle mb-2">as
                                of <?php echo date('d F Y', strtotime($vaccineData['date'])); ?></h6></div>
                    </div>
                </div>
            </div>
            <div class="col-md" style="padding-bottom: 10px;padding-top: 10px;">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">People fully vaccinated</h5>
                    </div>
                    <div class="card-body">
                        <h2 class="text-center card-text"><?php echo number_format($vaccineData['peopleFullyVaccinated']); ?></h2>
                        <div style="text-align: center;"><h6 class="text-muted card-subtitle mb-2">with two doses (data
                                not available)</h6></div>
                    </div>
                </div>
            </div>
            <div class="col-md" style="padding-bottom: 10px;padding-top: 10px;">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Vaccines approved</h5>
                    </div>
                    <div class="card-body">
                        <h2 class="text-center card-text">2</h2>
                        <div style="text-align: center;"><h6 class="text-muted card-subtitle mb-2">for use in
                                Ireland</h6></div>
                    </div>
                </div>
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
            <li class="list-inline-item"><a href="https://twitter.com/ShaneHastingsIE"><i class="fab fa-twitter"></i>
                    Contact</a></li>
        </ul>
        <p class="copyright">Vaccine data sourced from <b><a style="text-decoration: none; color: #4b4c4d"
                                                             href="https://ourworldindata.org/covid-vaccinations">Our
                    World in Data</a></b>'s open data sources on GitHub. Data source will be changed to the official
            COVID data hub once the data is added.</p>
    </footer>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

</body>

</html>