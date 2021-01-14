<?php
/*  Using the library below to place text onto a predefined image.
 */

date_default_timezone_set('Europe/Dublin');

require('../vaccineData.php');

$dataArray = getLatestVaccineData();
$vaccineNumber = $dataArray['vaccinesGiven'];
$dataDate = $dataArray['date'];


/*  PHP Add text to image library
 *  GitHub: https://github.com/Ghostff/PHP-Add-text-to-image/blob/master/index.php
 */

require_once __DIR__ . '/src/TextToImage.php';

header("Content-Type: image/png");


$vaccinesGiven = function (TextToImage $handler) {
    global $vaccineNumber;
    $handler->add(number_format($vaccineNumber))
        ->position(235, 325)
        ->font(100, __DIR__ . '/Lato-Bold.ttf')
        ->color(0, 0, 0);
};

$subtext = function (TextToImage $handler) {
    global $vaccineNumber;
    $handler->add("vaccines given")
        ->position(235, 400)
        ->font(50, __DIR__ . '/Lato-Regular.ttf')
        ->color(0, 0, 0);
};

# Write to an existing image
TextToImage::setImage(__DIR__ . '/vaccineimg.png')->open(

    $vaccinesGiven,
    $subtext

)->close();

/*
 *  End image processing
 */
