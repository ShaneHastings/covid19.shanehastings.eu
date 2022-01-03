<?php
/**
* COVID-19 PCR testing 
* A tool to scrape the current available PCR testing capacity from testing centres around Ireland.
* Very much a work-in-progress, so if you have any suggestions on how to make this better then fire ahead.
*
* @author Shane Hastings <https://twitter.com/ShaneHastingsIE>
* @version 1.0
*/

/** This associative array contains the UUID of each county, used on the self-referral site. */
$counties =  array(
    'Carlow'    =>	'78306a67-6c14-11ec-9787-02fd315c6b27',
    'Cavan'     =>	'7832278d-6c14-11ec-9787-02fd315c6b27',
    'Clare'     =>	'7833bd33-6c14-11ec-9787-02fd315c6b27',
    'Cork'      =>	'7834f783-6c14-11ec-9787-02fd315c6b27',
    'Donegal'   =>	'783622a4-6c14-11ec-9787-02fd315c6b27',
    'Dublin'    =>	'78379e23-6c14-11ec-9787-02fd315c6b27',
    'Galway'    =>	'7838b0a4-6c14-11ec-9787-02fd315c6b27',
    'Kerry'     =>	'7839ba89-6c14-11ec-9787-02fd315c6b27',
    'Kildare'   =>	'783ac8dc-6c14-11ec-9787-02fd315c6b27',
    'Kilkenny'  =>	'783c7cad-6c14-11ec-9787-02fd315c6b27',
    'Laois'     =>	'783d9a56-6c14-11ec-9787-02fd315c6b27',
    'Leitrim'   =>	'783ea45b-6c14-11ec-9787-02fd315c6b27',
    'Limerick'  =>	'783fc808-6c14-11ec-9787-02fd315c6b27',
    'Longford'  =>	'7840d923-6c14-11ec-9787-02fd315c6b27',
    'Louth'     =>	'7841cac7-6c14-11ec-9787-02fd315c6b27',
    'Mayo'      =>	'7842c1ba-6c14-11ec-9787-02fd315c6b27',
    'Meath'     =>	'7843d4c5-6c14-11ec-9787-02fd315c6b27',
    'Monaghan'  =>	'7844de6f-6c14-11ec-9787-02fd315c6b27',
    'Offaly'    =>	'7845f6a5-6c14-11ec-9787-02fd315c6b27',
    'Roscommon' =>	'78470859-6c14-11ec-9787-02fd315c6b27',
    'Sligo'     =>	'78481681-6c14-11ec-9787-02fd315c6b27',
    'Tipperary' =>	'78492423-6c14-11ec-9787-02fd315c6b27',
    'Waterford' =>	'784a2afa-6c14-11ec-9787-02fd315c6b27',
    'Westmeath' =>	'784b3aa9-6c14-11ec-9787-02fd315c6b27',
    'Wexford'   =>	'784c3318-6c14-11ec-9787-02fd315c6b27',
    'Wicklow'   =>	'784d4169-6c14-11ec-9787-02fd315c6b27'
);


/** 
 * This function gets the list of available testing centres in a given county 
 * @param county - County you wish to query for testing centres. e.g. "Galway", "Wexford" etc....
 */
function getTestCentresByCounty($county){

    // Make county UUID array accessible
    global $counties;
    // Build the JSON payload
    $body = '{"task":"getConsultantsInCounty","county_uuid":"' . $counties[$county]  . '","travel":false}';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://covid19test.healthservice.ie/swiftflow.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    // Execute the query
    $result = curl_exec($ch);
    $result = json_decode($result, true);
    
    //echo "<pre>";
    //print_r($result);
    return $result;

}

/** 
 * This function gets the available testing slots in a given testing centre 
 * @param facility_id   - The hashed ID of the given COVID-19 test centre, returned by the getTestCentresByCounty function.
 * @param type_id       - The type_id returned by the getTestCentresByCounty function. Not sure what its purpose is, but it is required.
*/
function getOpenSlotsInTestCentre($facility_id, $type_id){

    // Build the JSON payload
    $body = '{"task":"getConsultantAvailability","facility_id":"'.$facility_id.'","type_id":'.$type_id.',"travel":false}';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://covid19test.healthservice.ie/swiftflow.php?future_days=1&minutes_buffer=60&enforce_future_days=1&enforce_today_or_tomorrow_only=0");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    // Execute the query
    $result = curl_exec($ch);

    $result = json_decode($result, true);
    //echo $result['data']['type']['total_slots_available'];
    //echo "<pre>";
    //print_r($result);
    return $result;
}


/** Get the total number of available testing slots in test centres categorised under each county on the self referral website.
 * @param county - County we are querying. e.g. "Galway"
 */
function getTotalFreeSlotsInCounty($county){

    $testCentreData = getTestCentresByCounty($county);
    // Cleansed and minified test centre data.
    $minTestCentreData = array();
    $counter = 0;
    // Loop through test centre data and get the facility name, facility_id, and type_id.
    foreach ($testCentreData['data'] as $centre){

        $minTestCentreData[$counter]['name']        = $centre['name'];
        $minTestCentreData[$counter]['facility_id'] = $centre['fkey'];
        $minTestCentreData[$counter]['type_id']     = $centre['appointment_types'][0]['id'];

        $counter++;
    }

    // Initialise variable for available testing slots
    $totalAvailableSlots = 0;
    foreach ($minTestCentreData as $testCentre){

        // Get the testing slots in the specific test centre we query
        $tempData = getOpenSlotsInTestCentre($testCentre['facility_id'], $testCentre['type_id']);
        // Add the available slots (total number) to the running counter
        $totalAvailableSlots += $tempData['data']['type']['total_slots_available'];

    }

    return $totalAvailableSlots;
}
