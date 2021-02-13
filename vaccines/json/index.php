<?php
/* Disable error reporting.. */
error_reporting(0);
@ini_set('display_errors', 0);

/* Get geohive data */
include '../vaccineData.php';

$populationIreland = 4977400;
$vaccinationRatePer100 = round(((getGeoHiveTotalVaccinations()/$populationIreland)*100), 2);
$populationWithFirstDose = round(((getGeoHiveFirstDoseTotals()/$populationIreland)*100), 1);
$populationFullyVaccinated = round(((getGeoHiveSecondDoseTotals()/$populationIreland)*100), 1);;

/* Encode data for JSON Response */
$jsonResponse = "";
$jsonResponse->date = getGeoHiveFirstDoseTotalsDate();
$jsonResponse->totalFirstDoseAdministered = getGeoHiveFirstDoseTotals();
$jsonResponse->totalSecondDoseAdministered = getGeoHiveSecondDoseTotals();
$jsonResponse->totalVaccinations = getGeoHiveTotalVaccinations();
$jsonResponse->vaccinatedToday = 'unknown';
$jsonResponse->vaccinationsPer100People = $vaccinationRatePer100;
$jsonResponse->populationWithFirstDose = $populationWithFirstDose . "%";
$jsonResponse->populationFullyVaccinated = $populationFullyVaccinated . "%";

$jsonResponse->vaccineManufacturer->pfizerBioNTech = getGeoHiveVaccineTotalsByManufacturer("pf");
$jsonResponse->vaccineManufacturer->moderna = getGeoHiveVaccineTotalsByManufacturer("modern");
$jsonResponse->vaccineManufacturer->astrazeneca =getGeoHiveVaccineTotalsByManufacturer("az");

$jsonResponse->cohorts->Aged65PlusLTRCStaff_1D = getGeoHiveVaccineTotalsByCohort("cohort1");
$jsonResponse->cohorts->Aged65PlusLTRCStaff_2D = getGeoHiveVaccineTotalsByCohort("cohort1b");
$jsonResponse->cohorts->FronlineHCW_1D = getGeoHiveVaccineTotalsByCohort("cohort2");
$jsonResponse->cohorts->FronlineHCW_2D = getGeoHiveVaccineTotalsByCohort("cohort2b");
$jsonResponse->cohorts->Others_1D = getGeoHiveVaccineTotalsByCohort("othercohort1");
$jsonResponse->cohorts->Others_2D = getGeoHiveVaccineTotalsByCohort("othercohort2");

//$jsonResponse->dataSource = 'https://services-eu1.arcgis.com/z6bHNio59iTqqSUY/arcgis/rest/services/Covid19_Vaccine_Administration_Data/FeatureServer/0/query?where=1%3D1&objectIds=&time=&geometry=&geometryType=esriGeometryEnvelope&inSR=&spatialRel=esriSpatialRelIntersects&resultType=none&distance=0.0&units=esriSRUnit_Meter&returnGeodetic=false&outFields=*&returnGeometry=true&featureEncoding=esriDefault&multipatchOption=xyFootprint&maxAllowableOffset=&geometryPrecision=&outSR=&datumTransformation=&applyVCSProjection=false&returnIdsOnly=false&returnUniqueIdsOnly=false&returnCountOnly=false&returnExtentOnly=false&returnQueryGeometry=false&returnDistinctValues=false&cacheHint=false&orderByFields=&groupByFieldsForStatistics=&outStatistics=&having=&resultOffset=&resultRecordCount=&returnZ=false&returnM=false&returnExceededLimitFeatures=true&quantizationParameters=&sqlFormat=none&f=html&token=';



$json = json_encode($jsonResponse);
header('Content-Type: application/json');
echo $json;