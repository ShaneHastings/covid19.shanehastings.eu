<?php

/*  Vaccine Data for Ireland
 *
 *  Data source: Our World in Data (GitHub)
 *  https://raw.githubusercontent.com/owid/covid-19-data/master/public/data/vaccinations/country_data/Ireland.csv
 */

/* Vaccine Data Sources */

$ourWorldInData_Ireland = "https://raw.githubusercontent.com/owid/covid-19-data/master/public/data/vaccinations/country_data/Ireland.csv";

/* Grab data from github once to prevent multiple requests. */
$globalVaccineDataArray = getVaccineDataFromCSV();

function getVaccineDataFromCSV()
{
    global $ourWorldInData_Ireland;
    $csv = array();
    $file = fopen($ourWorldInData_Ireland, 'r');

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


