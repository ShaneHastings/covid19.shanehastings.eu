<?php
/*  Using the library below to place text onto a predefined image.
 */

date_default_timezone_set('Europe/Dublin');

require('../vaccineData.php');

/* This is for using OWID Data
$dataArray = getLatestVaccineData();
$vaccineNumber = $dataArray['vaccinesGiven'];
$dataDate = $dataArray['date'];
*/

/* Using GeoHive Data */
$vaccineNumber = getGeoHiveTotalVaccinations();
$dataDate = getGeoHiveFirstDoseTotalsDate();

$firstDose = getGeoHiveFirstDoseTotals();
$secondDose = getGeoHiveSecondDoseTotals();
$dateGeohive = getGeoHiveFirstDoseTotalsDate();

/*  PHP Add text to image library
 *  GitHub: https://github.com/Ghostff/PHP-Add-text-to-image/blob/master/index.php
 */

require_once __DIR__ . '/src/TextToImage.php';

header("Content-Type: image/png");




$firstDoseGiven = function (TextToImage $handler) {
    global $firstDose;
    $handler->add(number_format($firstDose))
        ->position(75, 250)
        ->font(45, __DIR__ . '/Lato-Regular.ttf')
        ->color(0, 0, 0);
};

$firstDoseGivenText = function (TextToImage $handler) {
    $handler->add("first dose vaccinations")
        ->position(350, 245)
        ->font(30, __DIR__ . '/Lato-Regular.ttf')
        ->color(0, 0, 0);
};

$secondDoseGiven = function (TextToImage $handler) {
    global $secondDose;
    $handler->add(number_format($secondDose))
        ->position(75, 320)
        ->font(45, __DIR__ . '/Lato-Regular.ttf')
        ->color(0, 0, 0);
};

$secondDoseGivenText = function (TextToImage $handler) {
    $handler->add("second dose vaccinations")
        ->position(350, 315)
        ->font(30, __DIR__ . '/Lato-Regular.ttf')
        ->color(0, 0, 0);
};

$vaccinesGiven = function (TextToImage $handler) {
    global $vaccineNumber;
    $handler->add(number_format($vaccineNumber))
        ->position(75, 390)
        ->font(45, __DIR__ . '/Lato-Bold.ttf')
        ->color(0, 0, 0);
};

$vaccinesGivenText = function (TextToImage $handler) {
    $handler->add("vaccines administered")
        ->position(350, 385)
        ->font(30, __DIR__ . '/Lato-Bold.ttf')
        ->color(0, 0, 0);
};

$date = function (TextToImage $handler) {
    global $dateGeohive;
    $handler->add(date("d-m-Y", strtotime($dateGeohive)))
        ->position(400, 430)
        ->font(15, __DIR__ . '/Lato-Regular.ttf')
        ->color(0, 0, 0);
};


# Write to an existing image
TextToImage::setImage(__DIR__ . '/vaccineimg.png')->open(

    $vaccinesGiven,
    $vaccinesGivenText,
    $firstDoseGiven,
    $firstDoseGivenText,
    $secondDoseGiven,
    $secondDoseGivenText,
    $date


)->close();

/*
 *  End image processing
 */
