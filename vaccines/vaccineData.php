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

/* Original Vaccine Data Sources
*  I've kept these here for debugging purposes, and so they can be easily switched out.
*/

/*
$ourWorldInData_Ireland = "https://raw.githubusercontent.com/owid/covid-19-data/master/public/data/vaccinations/country_data/Ireland.csv";
$ourWorldInData_NorthernIreland = "https://raw.githubusercontent.com/owid/covid-19-data/master/public/data/vaccinations/country_data/Northern%20Ireland.csv";
// Below URL was updated on 28/01/2021 to include the 2nd dose data. So far, daily updates have not materialised.
$geoHiveVaccineAPI = "https://services-eu1.arcgis.com/z6bHNio59iTqqSUY/arcgis/rest/services/Covid19_Vaccine_Administration_Data_View/FeatureServer/0/query?where=1%3D1&objectIds=&time=&geometry=&geometryType=esriGeometryEnvelope&inSR=&spatialRel=esriSpatialRelIntersects&resultType=none&distance=0.0&units=esriSRUnit_Meter&returnGeodetic=false&outFields=*&returnGeometry=true&featureEncoding=esriDefault&multipatchOption=xyFootprint&maxAllowableOffset=&geometryPrecision=&outSR=&datumTransformation=&applyVCSProjection=false&returnIdsOnly=false&returnUniqueIdsOnly=false&returnCountOnly=false&returnExtentOnly=false&returnQueryGeometry=false&returnDistinctValues=false&cacheHint=false&orderByFields=&groupByFieldsForStatistics=&outStatistics=&having=&resultOffset=&resultRecordCount=&returnZ=false&returnM=false&returnExceededLimitFeatures=true&quantizationParameters=&sqlFormat=none&f=pjson&token=";
$northernIrelandGovUK = "https://api.coronavirus.data.gov.uk/v2/data?areaType=nation&areaCode=N92000002&metric=cumPeopleVaccinatedCompleteByPublishDate&metric=cumPeopleVaccinatedFirstDoseByPublishDate&metric=cumPeopleVaccinatedSecondDoseByPublishDate&format=json";
*/

/* Self hosted sources */
$ourWorldInData_Ireland = "https://covid19.shanehastings.eu/vaccines/datasets/roiVaccineDataOWID.csv";
$ourWorldInData_NorthernIreland = "https://covid19.shanehastings.eu/vaccines/datasets/niVaccineDataOWID.csv";
$geoHiveVaccineAPI = "https://covid19.shanehastings.eu/vaccines/datasets/roiVaccineData.json";
$northernIrelandGovUK = "https://covid19.shanehastings.eu/vaccines/datasets/niVaccineData.json";


/* Grab GOV.UK data for Northern Ireland */
$globalGovUKDataArray = getGOVUKData();

/* Grab data from geohive once to prevent multiple requests */
$globalGeoHiveDataArray = getGeoHiveData();

/* Grab ROI data from github once to prevent multiple requests. */
$globalVaccineDataArray = getVaccineDataFromCSV();

/* Grab NI data from github once to prevent multiple requests. */
$globalNIVaccineDataArray = getNIVaccineDataFromCSV();

/*  Our World in Data Vaccine Sources */


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

function getNIVaccineDataFromCSV()
{
    global $ourWorldInData_NorthernIreland;
    $csv = array();
    /* Try grab the file from GitHub. If it fails, throw an error. */
    $file = fopen($ourWorldInData_NorthernIreland, 'r');
    if ( !$file ) {
        echo "<h1>Data source unavailable. Try again later.</h1><br>Data source: " . $ourWorldInData_NorthernIreland;
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

/*  Returns the total vaccinations as comma separated values for the chart.
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

/*  Returns the total number of people fully vaccinated as comma separated values for the chart.
 */
function getChartTotalFullyVaccinations()
{
    global $globalVaccineDataArray;
    $vaccineData = $globalVaccineDataArray;

    /* Loop through array and get totals */
    foreach (array_slice($vaccineData, 1) as $vaccinesGiven) {
        echo $vaccinesGiven[6];
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
        echo date('d-M-Y', strtotime($vaccineDates[1]));;
        echo "',";
    }
}


/*  Grabbing the latest data from the COVID-19 GeoHive Data Hub
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
    $totalNumberFirstDoseAdministered =  $globalGeoHiveDataArray['features'][$keyOfLatestData]['attributes']['firstDose'];
    return $totalNumberFirstDoseAdministered;
}

function getGeoHiveSecondDoseTotals(){

    global $globalGeoHiveDataArray;

    /* Find the key of the last element, which will be the most recent data. */
    $sizeOfFeaturesArray = sizeof($globalGeoHiveDataArray['features']);
    $keyOfLatestData = $sizeOfFeaturesArray - 1;
    $totalNumberSecondDoseAdministered =  $globalGeoHiveDataArray['features'][$keyOfLatestData]['attributes']['secondDose'];
    return $totalNumberSecondDoseAdministered;
}

function getGeoHiveTotalVaccinations(){

    global $globalGeoHiveDataArray;

    /* Find the key of the last element, which will be the most recent data. */
    $sizeOfFeaturesArray = sizeof($globalGeoHiveDataArray['features']);
    $keyOfLatestData = $sizeOfFeaturesArray - 1;
    $totalDosesAdmininistered =  $globalGeoHiveDataArray['features'][$keyOfLatestData]['attributes']['totalAdministered'];
    return $totalDosesAdmininistered;

}

/*  Sort through the GeoHive data array and extract the daily vaccination totals date.
 */
function getGeoHiveFirstDoseTotalsDate(){

    global $globalGeoHiveDataArray;

    /* Find the key of the last element, which will be the most recent data. */
    $sizeOfFeaturesArray = sizeof($globalGeoHiveDataArray['features']);
    $keyOfLatestData = $sizeOfFeaturesArray - 1;
    $dateOfTotalNumberFirstDoseAdministered =  $globalGeoHiveDataArray['features'][$keyOfLatestData]['attributes']['relDate'];
    $convertedDate = timestampToDate($dateOfTotalNumberFirstDoseAdministered);

    return $convertedDate;
}

/*  Get the number of vaccines given out for each manufacturer.
 *  Key:    "pf"     = Pfizer/BioNTech
 *          "modern" = Moderna
 */
function getGeoHiveVaccineTotalsByManufacturer($vaccineManufacturer){

    global $globalGeoHiveDataArray;

    /* Find the key of the last element, which will be the most recent data. */
    $sizeOfFeaturesArray = sizeof($globalGeoHiveDataArray['features']);
    $keyOfLatestData = $sizeOfFeaturesArray - 1;
    $totalVaccinesFromManufacturer =  $globalGeoHiveDataArray['features'][$keyOfLatestData]['attributes'][$vaccineManufacturer];

    return $totalVaccinesFromManufacturer;
}

/*  Get the number of vaccines given out to each cohort.
 *  Key:    "totalcoh1"  = Cohort 1 (65+ in LTRC, + Staff)
 *          "totalcoh2"  = Cohort 2 (Frontline healthcare workers)
 *          "totalcoh16" = Others (everyone else outside the two groups in 1 + 2)
 */
function getGeoHiveVaccineTotalsByCohort($cohortID){

    global $globalGeoHiveDataArray;

    /* Find the key of the last element, which will be the most recent data. */
    $sizeOfFeaturesArray = sizeof($globalGeoHiveDataArray['features']);
    $keyOfLatestData = $sizeOfFeaturesArray - 1;
    $totalVaccinesGivenToCohort =  $globalGeoHiveDataArray['features'][$keyOfLatestData]['attributes'][$cohortID];

    return $totalVaccinesGivenToCohort;
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


/*  Northern Ireland Data functions
 */


/*  Grabbing the latest data from GOV.UK for Northern Ireland.
 */

function getGOVUKData(){

    global $northernIrelandGovUK;
    $govUKJSON = file_get_contents($northernIrelandGovUK);
    $govUKJSONObject = json_decode($govUKJSON, true);

    return $govUKJSONObject;
}

/*  Get first dose NI vaccinations
 *  returns unformatted number
 */
function getNIFirstDoseTotal(){

    global $globalGovUKDataArray;
    $firstDose = $globalGovUKDataArray['body'][0]['cumPeopleVaccinatedFirstDoseByPublishDate'];
    return $firstDose;

}

/*  Get second dose NI vaccinations
 *  returns unformatted number
 */
function getNISecondDoseTotal(){

    global $globalGovUKDataArray;
    $secondDose = $globalGovUKDataArray['body'][0]['cumPeopleVaccinatedSecondDoseByPublishDate'];
    return $secondDose;

}

/*  Get the publish date of array key [0] (most recent data)
 *  returns YYYY-MM-DD
 */
function getNIDataPublishDate(){

    global $globalGovUKDataArray;
    $dataDate = $globalGovUKDataArray['body'][0]['date'];
    return $dataDate;

}

/*  Get total NI vaccinations (first+second dose)
 * returns unformatted number
 */
function getNITotalVaccinations(){

    $totalVaccinations = getNIFirstDoseTotal() + getNISecondDoseTotal();
    return $totalVaccinations;

}

/*  Returns the total Northern Irish vaccinations as comma separated values for the chart.
*   Data source: Our World in Data
 */
function getNIChartTotalVaccinations()
{
    global $globalNIVaccineDataArray;
    $vaccineData = $globalNIVaccineDataArray;

    /* Loop through array and get totals */
    foreach (array_slice($vaccineData, 1) as $vaccinesGiven) {
        echo $vaccinesGiven[4];
        echo ",";
    }
}

/*  Returns the Northehrn Irish vaccine dates as comma separated values for the chart.
*   Data source: Our World in Data
 */
function getNIChartVaccinationDates()
{

    global $globalNIVaccineDataArray;
    $vaccineData = $globalNIVaccineDataArray;

    /* Loop through array and get dates */
    foreach (array_slice($vaccineData, 1) as $vaccineDates) {
        echo "'";
        echo date('M-d', strtotime($vaccineDates[1]));;
        echo "',";
    }
}

/*  Returns the total number of people fully vaccinated in Northern Ireland as comma separated values for the chart.
*   Data source: Our World in Data
 */
function getNIChartTotalFullyVaccinated()
{
    global $globalNIVaccineDataArray;
    $vaccineData = $globalNIVaccineDataArray;

    /* Loop through array and get totals */
    foreach (array_slice($vaccineData, 1) as $vaccinesGiven) {
        echo $vaccinesGiven[6];
        echo ",";
    }
}

/*  Vaccine distribution statistics
 *
 */

function getEstimatedDeliveredDoses($totalECDCDeliveries){

    /* Source: Eurostat, 2021 (https://ec.europa.eu/eurostat/databrowser/view/tps00001/default/table?lang=en)
                EU27 +  Norway and Iceland = 453,437,923*/
    $irelandProportionOfEUEEAPopulation = 0.010947119;

    $estimatedDeliveries = $totalECDCDeliveries * $irelandProportionOfEUEEAPopulation;
    return $estimatedDeliveries;


}