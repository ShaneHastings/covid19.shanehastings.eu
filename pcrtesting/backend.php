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
    'Carlow'    =>	'ed18c9cd-be86-44fb-86ba-8c54d55a2faa',
    'Cavan'     => '962520d3-8dc0-42e4-811b-b3225d74addb',
    'Clare'     =>	'69111ae8-fb94-4151-b4ec-fd4ce0f605e5',
    'Cork'      =>	'88d1ac9e-f531-4b7a-a6d5-499e84ed4463',
    'Donegal'   =>	'f961fbee-ee98-4ce3-be47-1319876fe47c',
    'Dublin'    =>	'446b0e00-ee77-435c-b83b-afb6dd469551',
    'Galway'    =>	'b7725be0-10a9-4113-8aae-3a5a92f5e150',
    'Kerry'     =>	'b15b0c8e-a727-425f-b714-8fea314a4f50',
    'Kildare'   =>	'4a994c3c-2725-4b16-906b-d9be4d9004bc',
    'Kilkenny'  =>	'af5d94d2-c27e-494a-a228-d03d4c2c2b9f',
    'Laois'     =>	'2f6b2415-76a6-4b29-8551-77ec19988a86',
    'Leitrim'   =>	'b894ac4c-3f58-434a-a1d8-8e3265195f88',
    'Limerick'  =>	'2f5eb9a3-ae8c-437e-aef7-bd2957be6a7e',
    'Longford'  =>	'40972358-e4a3-4a99-8f42-a2aee761a9f9',
    'Louth'     =>	'b773371f-bb5d-405a-9c03-6ba94b0993df',
    'Mayo'      =>	'63a79dd4-49e3-408b-bf61-0fae55c8917a',
    'Meath'     =>	'3d3136b7-8893-4226-9f28-d06967022123',
    'Monaghan'  =>	'd6fbc7ac-4a8b-4dba-874d-d939faf06ccb',
    'Offaly'    =>	'24abc3c6-5e28-49fe-99f8-f3d8118cae18',
    'Roscommon' =>	'ef236290-f45a-4353-869b-a66e25bd68ce',
    'Sligo'     =>	'c4f8a8c2-8ec6-49e5-937d-e0b0e8ee7e6b',
    'Tipperary' =>	'e2d27461-9dbc-43d1-878e-061a07fa2a25',
    'Waterford' =>	'113db5f7-00b9-4e95-83b1-ff73c27317c8',
    'Westmeath' =>	'eb4cf636-821b-47f5-b940-f86231a1edec',
    'Wexford'   =>	'83ee9614-ec96-4720-9909-c9b6d8ddc616',
    'Wicklow'   =>	'49d32785-ed2c-4a8b-ab14-585e089b2043'
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
