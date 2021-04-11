<?php

/* Check if user is using PWA */
function checkPWAInstalled(){

    $url =  "{$_SERVER['REQUEST_URI']}";
    $escaped_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );
    if ($escaped_url == "/?pwa"){
        echo "fixed-top";
    } else{
        // do nothing
    }

}

?>
<!DOCTYPE html>
<html>

<head>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-54144087-3');

    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <!-- Primary Meta Tags -->
    <title>COVID-19 Data | Resources</title>
    <meta name="title" content="COVID-19 Data | Resources">
    <meta name="description" content="COVID-19 data resources from official and reputable sources, primarily aimed for an Irish audience.">
    <meta name="theme-color" content="#FFEF10">
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://covid19.shanehastings.eu/">
    <meta property="og:title" content="COVID-19 Data | Resources">
    <meta property="og:description" content="COVID-19 data resources from official and reputable sources, primarily aimed for an Irish audience.">
    <meta property="og:image" content="https://covid19.shanehastings.eu/social.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://covid19.shanehastings.eu/">
    <meta property="twitter:title" content="COVID-19 Data | Resources">
    <meta property="twitter:description" content="COVID-19 data resources from official and reputable sources, primarily aimed for an Irish audience.">
    <meta property="twitter:image" content="https://covid19.shanehastings.eu/social.png" >


    <link rel="manifest" href="/manifest.json">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="application-name" content="COVID Data IE">
    <meta name="apple-mobile-web-app-title" content="COVID Data IE">
    <meta name="msapplication-navbutton-color" content="#FFEF10">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="msapplication-starturl" content="https://covid19.shanehastings.eu/">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" type="image/png" sizes="512x512" href="https://covid19.shanehastings.eu/assets/pwa/app_icon_512.png">
    <link rel="apple-touch-icon" type="image/png" sizes="512x512" href="https://covid19.shanehastings.eu/assets/pwa/app_icon_512.png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css">
    <link rel="stylesheet" href="/assets-home/css/Article-List.css">
    <link rel="stylesheet" href="/assets-home/css/Footer-Dark.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="/assets-home/css/Navigation-Clean.css">
    <link rel="stylesheet" href="/assets-home/css/styles.css">
<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>


    <style>
        @media (max-width: 768px) {

            [class*="col-"] {
                margin-bottom: 15px;
            }



        }
    </style>

</head>

<body>

    <nav class="navbar <?php checkPWAInstalled(); ?> navbar-light navbar-expand-md navigation-clean" style="background: #FFEF10;">
        <div class="container"><a class="navbar-brand" href="/" style="font-family: Lato, sans-serif;">COVID-19 Data</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item text-right"><a class="nav-link text-right" href="https://twitter.com/COVID19DataIE" style="color: rgb(0,0,0);"><i class="fab fa-twitter" style="color: var(--blue);"></i>&nbsp; @COVID19DataIE</a></li>
                    <li class="nav-item"></li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="article-list" style="background: rgb(249,249,249);">
        <div class="container">
            <div class="intro">
                <h2 class="text-center">More good resources</h2>
            </div>
            <h3>Official sources</h3>
            <hr>
            <div class="row articles ">


                <div class="col-sm-3">
                    <div class="card">
                        <img class="card-img-top" src="/img/geohive.jpg" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">COVID-19 Data Hub</h5>
                            <p class="card-text">Official COVID-19 data dashboard for Ireland. Powering most of the data on this website.</p>
                            <a href="https://covid-19.geohive.ie/" target="_blank" style="width: 100%" class="btn btn-info">Visit resource</a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card">
                        <img class="card-img-top" src="/img/ecdc.png" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">ECDC Dashboard</h5>
                            <p class="card-text">ECDC Data reported by EU/EEA member states. Also provides data on vaccine deliveries to EEA countries.</p>
                            <div class="btn-group" style="width: 100%">
                                <a href="https://qap.ecdc.europa.eu/public/extensions/COVID-19/covid-19.html" style="width: 50%" target="_blank" class="btn btn-info">General</a>
                                <a href="https://qap.ecdc.europa.eu/public/extensions/COVID-19/vaccine-tracker.html" style="width: 50%" target="_blank" class="btn btn-success">Vaccines</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card">
                        <img class="card-img-top" src="/img/nidoh.png" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">NI Data Dashboard</h5>
                            <p class="card-text">Official NI data dashboard with cases, testing and hospital statistics.</p>
                            <a href="https://app.powerbi.com/view?r=eyJrIjoiZGYxNjYzNmUtOTlmZS00ODAxLWE1YTEtMjA0NjZhMzlmN2JmIiwidCI6IjljOWEzMGRlLWQ4ZDctNGFhNC05NjAwLTRiZTc2MjVmZjZjNSIsImMiOjh9" target="_blank" style="width: 100%" class="btn btn-info">Visit resource</a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card">
                        <img class="card-img-top" src="/img/govuk.png" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">GOV.UK Data Hub</h5>
                            <p class="card-text">Official UK data on COVID-19, including vaccination data for Northern Ireland used on this website.</p>
                            <a href="https://coronavirus.data.gov.uk/" target="_blank" style="width: 100%" class="btn btn-info">Visit resource</a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row articles ">


                <div class="col-sm-3">
                    <div class="card">
                        <img class="card-img-top" src="/img/hse.png" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">HSE Vaccine IIS</h5>
                            <p class="card-text">Daily reports from the HSE on the vaccination programme.</p>
                            <a href="https://www.hse.ie/eng/services/news/newsfeatures/covid19-updates/integrated-information-service-vaccination-programme-dashboard.html" target="_blank" style="width: 100%" class="btn btn-info">Visit resource</a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card">
                        <img class="card-img-top" src="/img/who.png" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">World Health Organisation</h5>
                            <p class="card-text">Official dashboard from the WHO with global data reported by individual countries during the pandemic.</p>
                            <a href="https://covid19.who.int/" target="_blank" style="width: 100%" class="btn btn-info">Visit resource</a>


                        </div>
                    </div>
                </div>



            </div>

            <h3>Others</h3>
            <hr>
            <div class="row articles ">

                <div class="col-sm-3">
                    <div class="card">
                        <img class="card-img-top" src="/img/ourworldindata.png" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Our World in Data</h5>
                            <p class="card-text">An Oxford University supported open data collection with many great datasets on the COVID-19 pandemic.</p>
                            <a href="https://ourworldindata.org/coronavirus/country/ireland" target="_blank" style="width: 100%" class="btn btn-info">Visit resource</a>
                        </div>
                    </div>
                </div>



            </div>

        </div>
    </div>






    <div class="footer-dark">
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-md-3 item">
                        <h3>Data Sources</h3>
                        <ul>
                            <li><a href="https://covid19ireland-geohive.hub.arcgis.com/datasets/d8eb52d56273413b84b0187a4e9117be_0">Cases</a></li>
                            <li><a href="https://covid19ireland-geohive.hub.arcgis.com/datasets/f6d6332820ca466999dbd852f6ad4d5a_0/">Laboratory Tests</a></li>
                            <li><a href="https://covid19ireland-geohive.hub.arcgis.com/pages/vaccinations">Vaccines</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-md-3 item">
                        <h3>About me</h3>
                        <ul>
                            <li><a href="https://shanehastings.eu"><i class="fas fa-link" style="color: var(--white);"></i>&nbsp;shanehastings.eu</a></li>
                            <li><a href="https://twitter.com/ShaneHastingsIE"><i class="fab fa-twitter" style="color: var(--white);"></i>&nbsp;@ShaneHastingsIE</a></li>
                            <li><a href="mailto:hello@shanehastings.eu"><i class="fas fa-inbox" style="color: var(--white);"></i>&nbsp;hello@shanehastings.eu</a></li>
                            <li><a href="https://covid19.shanehastings.eu/giveback/"><i class="fas fa-hands" style="color: var(--white);"></i>&nbsp;#giveback archive</a></li>
                            <li><a href="https://www.paypal.com/paypalme/shanehastings"><i class="fab fa-paypal"></i> Support</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6 item text">
                        <h3>Disclaimer</h3>
                        <p>This is not an official website or resource in any capacity. All data shown is taken from reputable sources and I do not take responsibility for any errors in the data shown should any occur. If you do spot something off, let me know.</p>
                    </div>
                </div>
                <p class="copyright">covid19.shanehastings.eu</p>
            </div>
        </footer>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.bundle.min.js"></script>
    <script src="/assets-home/js/bs-init.js"></script>
    <script>
        if('serviceWorker' in navigator) {
            navigator.serviceWorker
                .register('/assets/js/sw.js')
                .then(function() { console.log("Service Worker Registered"); });
        }
    </script>
</body>

</html>