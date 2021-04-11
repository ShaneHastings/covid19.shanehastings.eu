<?php
error_reporting(0);
ini_set('display_errors', 0);

include "../vaccines/vaccineData.php";
include "../pwa/includes/testingData.php";
include_once "../api/swabs/api_url.php";
require_once 'vendor/mobiledetect/mobiledetectlib/Mobile_Detect.php';
$detect = new Mobile_Detect;
$notMobile = false;
// Any mobile device (phones or tablets).
if ( !$detect->isiOS() && !$detect->isAndroidOS() && !$detect->isiPadOS() && !$detect->isiPad() && !$detect->version('iPad')) {
    $notMobile = true;
}
$populationIreland = 4977400;
$testingDataArray = getTestingData();
$caseDataArray = getCaseData();
$firstDosePercent = round((getGeoHiveFirstDoseTotals() / $populationIreland)*100, 1);
$secondDosePercent = round((getGeoHiveSecondDoseTotals() / $populationIreland)*100, 1);
$totalDosesPercent = round((getGeoHiveTotalVaccinations() / $populationIreland)*100, 1);
?>
<!DOCTYPE html>
<html>
<head>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-54144087-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-54144087-3');
    </script>
    <link rel="stylesheet" href="css/onsenui.css">
    <title>COVID-19 Data IE | PWA</title>


    <link id="theme" rel="stylesheet" href="css/onsen-css-components.min.css">
    <script>document.querySelector('#theme').setAttribute('href', 'css/dark-onsen-css-components.css');</script>
    <meta name="theme-color" content="#000000">
    <script src="https://unpkg.com/onsenui/js/onsenui.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css">
    <link rel="stylesheet" href="css/material-dark-custom.css">
    <script src="main.js"></script>
    <script>themeChecker();</script>
    <script src="routing.js"></script>
    <script src="moment.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <link rel="manifest" href="https://covid19.shanehastings.eu/pwa/manifest.json">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="application-name" content="COVID Data IE">
    <meta name="apple-mobile-web-app-title" content="COVID Data IE">
    <meta name="msapplication-navbutton-color" content="#000000">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="msapplication-starturl" content="https://covid19.shanehastings.eu/pwa">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" type="image/png" sizes="512x512" href="https://covid19.shanehastings.eu/assets/pwa/app_icon_512.png">
    <link rel="apple-touch-icon" type="image/png" sizes="512x512" href="https://covid19.shanehastings.eu/assets/pwa/app_icon_512.png">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

</head>
<body>
<ons-navigator swipeable id="navigator" page="home.html">

<template id="home.html">
    <ons-page id="page1">
        <ons-toolbar>
            <div class="center"><i class="fas fa-shield-virus"></i> COVID-19 Data Ireland</div>
            <div style="padding-right: 15px" class="right"><a href="/pwa"><i class="fas fa-sync"></i></a></div>
        </ons-toolbar>

        <ons-row style="padding-left: 10px">
            <h2>Daily update for <?php echo date('l, F jS Y', strtotime($caseDataArray['date'])); ?></h2>
        </ons-row>

        <ons-row>
            <ons-col>
                <ons-card>
                    <div class="title">
                        <i class="fas fa-user-check"></i> Cases
                    </div>
                    <div class="content">
                        <headlineFigure><?php echo number_format($caseDataArray['newCases']); ?></headlineFigure>
                    </div>
                </ons-card>
            </ons-col>

            <ons-col>
                <ons-card>
                    <div class="title">
                        <i class="fas fa-procedures"></i> Deaths
                    </div>
                    <div class="content">
                        <headlineFigure><?php echo number_format($caseDataArray['newDeaths']); ?></headlineFigure>
                    </div>
                </ons-card>
            </ons-col>

        </ons-row>

        <ons-row>
            <ons-col>
                <ons-card>
                    <div class="title">
                        <i class="fas fa-virus"></i> Total cases
                    </div>
                    <div class="content">
                        <headlineFigure><?php echo number_format($caseDataArray['totalCases']); ?></headlineFigure>
                    </div>
                </ons-card>
            </ons-col>

            <ons-col>
                <ons-card>
                    <div class="title">
                        <i class="fas fa-procedures"></i> Total deaths
                    </div>
                    <div class="content">
                        <headlineFigure><?php echo number_format($caseDataArray['totalDeaths']); ?></headlineFigure>
                    </div>
                </ons-card>
            </ons-col>

        </ons-row>

        <ons-button onclick="routePage('vaccines.html')" style="background-color: transparent; width: 100%" >
        <ons-card style="margin-left: 0; margin-right: 0;  text-transform: capitalize; background-color: #00BFF3;color: white;text-align: center">
            <div class="title">
                <i class="fas fa-syringe fa-2x"></i><br>Vaccinations
            </div>
            <div class="content">

            </div>
        </ons-card>
        </ons-button>

        <ons-button onclick="routePage('testing.html')" style="background-color: transparent; width: 100%" >
            <ons-card style="margin-left: 0; margin-right: 0; text-transform: capitalize; background-color: #FFEF10;color: black;text-align: center">
                <div class="title">
                    <i class="fas fa-vial fa-2x"></i><br>Testing
                </div>
                <div class="content">

                </div>
            </ons-card>
        </ons-button>

        <ons-button onclick="routePage('settings.html')" style="background-color: transparent; width: 100%" >
            <ons-card style="margin-left: 0; margin-right: 0; text-transform: capitalize; color: white;text-align: center">
                <div class="title">
                    <i class="fas fa-user-cog fa-2x"></i><br>About & Settings
                </div>
                <div class="content">

                </div>
            </ons-card>
        </ons-button>


        <ons-card style="padding-top: 1px;">
            <div class="content">
                <h1>About the data</h1>

                <p>All data displayed here is taken from official and reputable sources. The vast majority is directly from the official COVID-19 GeoHive collection. This page is a
                    work in progress so not all elements from the <a href="https://covid19.shanehastings.eu" target="_blank">desktop site</a> will be available here.</p>
            </div>
        </ons-card>


        <?php
        if ($notMobile){
            echo "        <ons-card style='background-color: rgb(255, 45, 85)'>
            <div class='title'>
                <h1>Desktop Browsing</h1>
            </div>
            <div class='content'>
                <p>Please note that this was designed with phones and tablets in mind. As you may be browsing on a PC, you may not have the best experience.</p>
            </div>
        </ons-card>";
        }

        ?>
    </ons-page>
</template>
</ons-navigator>

<template id="vaccines.html">
    <?php include('includes/vaccinesPage.php');?>
</template>


<template id="testing.html">
    <?php include('includes/testingPage.php');?>
</template>

<template id="settings.html">
    <ons-page id="settings">
        <ons-toolbar>
            <div class="left"><ons-back-button>Back</ons-back-button></div>
            <div class="center"><i class="fas fa-info-circle"></i> About & Settings</div>
        </ons-toolbar>

        <ons-card style="padding-top: 1px;">
            <div class="content">
                <h1>About the site</h1>
                <p>This web application collates data from various sources providing COVID-19 information for Ireland. It builds on the other data presented on the
                     <a href="/">main website found here.</a> The primary aim of this is to have a cleaner and better experience for mobile users, as ~80% of visitors
                to my site use mobile, not widescreen computers.</p>

                <ons-list-item style="padding: 0">
                    <div class="left">
                        <img class="list-item__thumbnail" src="/pwa/shanehastings.jpg">
                    </div>
                    <div class="center">
                        <span class="list-item__title">Created by</span><span class="list-item__subtitle"><i class="fab fa-twitter" style="color: #1DA1F2;"></i> <a href="https://twitter.com/ShaneHastingsIE">@ShaneHastingsIE</a></span>
                    </div>
                </ons-list-item>
                <ons-list-item style="padding: 0">
                    <div class="left">
                        <img class="list-item__thumbnail" src="/pwa/coffee.svg">
                    </div>
                    <div class="center">
                        <span class="list-item__title">Buy me a coffee?</span><span class="list-item__subtitle">☕ <a href="https://www.buymeacoffee.com/shanehastings">/shanehastings</a></span>
                    </div>
                </ons-list-item>
            </div>
        </ons-card>

        <ons-row style="padding-left: 10px">
            <h1>Settings</h1>
        </ons-row>
        <ons-list style="margin: 8px">
            <ons-list-item>
                <div class="center">
                    Dark / Light Theme
                </div>
                <div class="right">
                    Coming Soon
                </div>
            </ons-list-item>
            <ons-list-item>
                <div class="center">
                    UI Type&nbsp;<a onclick="cookieWarning()"><i class="fas fa-info-circle"></i></a>
                </div>
                <div class="right">
                    <div class="segment" style="width: 280px; margin: 0 auto;">
                        <div class="segment__item">
                            <input type="radio" class="segment__input" onclick="ons.notification.toast('Updating theme... (reload required)', { timeout: 2000, animation: 'ascend' }); setPageTheme('ios'); " name="segment-a"
                                <?php if ($_COOKIE['theme'] == 'ios') { echo "checked"; } ?>>
                            <div class="segment__button">iOS</div>
                        </div>
                        <div class="segment__item">
                            <input type="radio" class="segment__input" onclick="ons.notification.toast('Updating theme... (reload required)', { timeout: 2000, animation: 'ascend' }); setPageTheme('android'); " name="segment-a"
                                <?php if ($_COOKIE['theme'] == 'android') { echo "checked"; } ?>>
                            <div class="segment__button">Android</div>
                        </div>
                    </div>
                </div>
            </ons-list-item>
        </ons-list>


        <ons-row style="padding-left: 10px">
            <h1>Data Sources</h1>
        </ons-row>

        <ons-list style="margin: 8px">
            <ons-list-header>Official Sources</ons-list-header>
            <ons-list-item>COVID-19 GeoHive Data Hub</ons-list-item>
            <ons-list-item>European Centre for Disease Prevention and Control (ECDC)</ons-list-item>
            <ons-list-item>Government of Ireland (gov.ie)</ons-list-item>
            <ons-list-item>Central Statistics Office (CSO)</ons-list-item>
            <ons-list-header>Reputable Sources</ons-list-header>
            <ons-list-item>Our World in Data</ons-list-item>
        </ons-list>

    </ons-page>
</template>


</body>
</html>