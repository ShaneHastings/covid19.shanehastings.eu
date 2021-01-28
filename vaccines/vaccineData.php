<?php

/*  Vaccine Data for Ireland
 *
 *  Data source: Our World in Data (GitHub)
 *  https://raw.githubusercontent.com/owid/covid-19-data/master/public/data/vaccinations/country_data/Ireland.csv
 */

/* Disable error reporting on production */
$url =  "{$_SERVER['HTTP_HOST']}";
$escaped_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );

if ($escaped_url == "covid19.shanehastings.eudev"){
    //echo "Development.";
} else {
    error_reporting(0);
    @ini_set('display_errors', 0);
}

/* Vaccine Data Sources */

$ourWorldInData_Ireland = "https://raw.githubusercontent.com/owid/covid-19-data/master/public/data/vaccinations/country_data/Ireland.csv";

// Below URL was updated on 28/01/2021 to include the 2nd dose data. So far, daily updates have not materialised.
$geoHiveVaccineAPI = "https://services-eu1.arcgis.com/z6bHNio59iTqqSUY/arcgis/rest/services/Covid19_Vaccine_Administration_Data_View/FeatureServer/0/query?where=1%3D1&objectIds=&time=&geometry=&geometryType=esriGeometryEnvelope&inSR=&spatialRel=esriSpatialRelIntersects&resultType=none&distance=0.0&units=esriSRUnit_Meter&returnGeodetic=false&outFields=*&returnGeometry=true&featureEncoding=esriDefault&multipatchOption=xyFootprint&maxAllowableOffset=&geometryPrecision=&outSR=&datumTransformation=&applyVCSProjection=false&returnIdsOnly=false&returnUniqueIdsOnly=false&returnCountOnly=false&returnExtentOnly=false&returnQueryGeometry=false&returnDistinctValues=false&cacheHint=false&orderByFields=&groupByFieldsForStatistics=&outStatistics=&having=&resultOffset=&resultRecordCount=&returnZ=false&returnM=false&returnExceededLimitFeatures=true&quantizationParameters=&sqlFormat=none&f=pjson&token=";

/* Grab data from geohive once to prevent multiple requests */
$globalGeoHiveDataArray = getGeoHiveData();

/* Grab data from github once to prevent multiple requests. */
$globalVaccineDataArray = getVaccineDataFromCSV();

function getVaccineDataFromCSV()
{
    global $ourWorldInData_Ireland;
    $csv = array();
    /* Try grab the file from GitHub. If it fails, throw an error. */
    $file = fopen($ourWorldInData_Ireland, 'r');
    if ( !$file ) {
        echo "<h1>Data source unavailable. Try again later.</h1><br>Data source: " . $ourWorldInData_Ireland;
        die();
    }
    while (($result = fgetcsv($file)) !== false) {
        $csv[] = $result;
    }

    fclose($file);
    return $csv;

}


/*  Gets the data from the most recent data provided.
 *  In this case, it's the last element of the array.
 */
function getLatestVaccineData()
{
    global $globalVaccineDataArray;
    $vaccineData = $globalVaccineDataArray;
    /* Get the key of the last element in the array (the latest data) */
    end($vaccineData);
    $lastElementOfArray = key($vaccineData);

    /* Create an array of the latest data */
    $latestData = array();
    $latestData['date'] = $vaccineData[$lastElementOfArray][1]; // Date of data
    $latestData['vaccineType'] = $vaccineData[$lastElementOfArray][2]; // Vaccine type
    $latestData['vaccinesGiven'] = $vaccineData[$lastElementOfArray][4]; // Number of vaccines given
    $latestData['peopleFullyVaccinated'] = $vaccineData[$lastElementOfArray][6]; // People fully vaccinated

    return $latestData;

}

/*  Returns the total vaccinations as comma separated values for the ChartJS chart.
 */
function getChartTotalVaccinations()
{
    global $globalVaccineDataArray;
    $vaccineData = $globalVaccineDataArray;

    /* Loop through array and get totals */
    foreach (array_slice($vaccineData, 1) as $vaccinesGiven) {
        echo $vaccinesGiven[4];
        echo ",";
    }
}

/*  Returns the vaccine dates as comma separated values for the ChartJS chart.
 */
function getChartVaccinationDates()
{

    global $globalVaccineDataArray;
    $vaccineData = $globalVaccineDataArray;

    /* Loop through array and get dates */
    foreach (array_slice($vaccineData, 1) as $vaccineDates) {
        echo "'";
        echo date('M-d', strtotime($vaccineDates[1]));;
        echo "',";
    }
}


/*  Grabbing the latest data from the COVID-19 GeoHive Data Hub (what a mouthful, eh?)
 *  As of January 14th, they only provide total vaccination statistics. Daily data comes on stream from
 *  January 25th according to Stephen Donnelly on Twitter.
 */

function getGeoHiveData(){

    global $geoHiveVaccineAPI;
    $geohiveDataJson = file_get_contents($geoHiveVaccineAPI);
    $geoHiveDataObject = json_decode($geohiveDataJson, true);

    return $geoHiveDataObject;
}


/*  Sort through the GeoHive data array and extract the daily vaccination totals.
 */
function getGeoHiveFirstDoseTotals(){

    global $globalGeoHiveDataArray;

    /* Find the key of the last element, which will be the most recent data. */
    $sizeOfFeaturesArray = sizeof($globalGeoHiveDataArray['features']);
    $keyOfLatestData = $sizeOfFeaturesArray - 1;

    /* Long variable names suck, but at least they make sense. */
    $totalNumberFirstDoseAdministered =  $globalGeoHiveDataArray['features'][$keyOfLatestData]['attributes']['total_number_of_1st_dose_admini'];
    return $totalNumberFirstDoseAdministered;
}

function getGeoHiveSecondDoseTotals(){

    global $globalGeoHiveDataArray;

    /* Find the key of the last element, which will be the most recent data. */
    $sizeOfFeaturesArray = sizeof($globalGeoHiveDataArray['features']);
    $keyOfLatestData = $sizeOfFeaturesArray - 1;

    /* Long variable names suck, but at least they make sense. */
    $totalNumberSecondDoseAdministered =  $globalGeoHiveDataArray['features'][$keyOfLatestData]['attributes']['total_number_of_2nd_dose_admini'];
    return $totalNumberSecondDoseAdministered;
}

function getGeoHiveTotalVaccinations(){

    return getGeoHiveSecondDoseTotals() + getGeoHiveFirstDoseTotals();

}

/*  Sort through the GeoHive data array and extract the daily vaccination totals date.
 */
function getGeoHiveFirstDoseTotalsDate(){

    global $globalGeoHiveDataArray;

    /* Find the key of the last element, which will be the most recent data. */
    $sizeOfFeaturesArray = sizeof($globalGeoHiveDataArray['features']);
    $keyOfLatestData = $sizeOfFeaturesArray - 1;

    /* Long variable names suck, but at least they make sense. */
    $dateOfTotalNumberFirstDoseAdministered =  $globalGeoHiveDataArray['features'][$keyOfLatestData]['attributes']['data_relevent_up_to_date'];
    $convertedDate = timestampToDate($dateOfTotalNumberFirstDoseAdministered);

    return $convertedDate;
}

/*  Converts UNIX timestamp returned by GeoHive source and returns in format YYYY-MM-DD.
 *
 */
function timestampToDate($timestamp)
{
    // Remove the last three digits, because they are useless to us.
    $strippedTimestamp = substr($timestamp, 0, -3);
    // Format in YYYY-MM-DD
    $date = date('Y-m-d', $strippedTimestamp);
    return $date;
}


