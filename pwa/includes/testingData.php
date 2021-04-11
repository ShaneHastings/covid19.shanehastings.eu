<?php


$api = "https://covid19.shanehastings.eu/api/swabs/json/";
$casesAPI = "https://covid19.shanehastings.eu/cases/json/";



function getTestingData(){

    global $api;
    $json = file_get_contents($api);
    $json_data = json_decode($json, true);
    return $json_data;

}

function getCaseData(){

    global $casesAPI;
    $json = file_get_contents($casesAPI);
    $json_data = json_decode($json, true);
    return $json_data;

}