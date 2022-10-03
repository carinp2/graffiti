<?php
/**
 * @author Carin Pretorius - CEIT Development
 * Created on 2022-04-25
 */

session_start();
require_once ("../application/classes/General.class.php");
$vGeneral = new General();
require_once ("application/classes/CmsParts.class.php");
$vCmsParts = new CmsParts();
require_once ("../application/classes/MysqlQuery.class.php");
$vQuery = new MysqlQuery();
require_once ("../application/classes/RequestUtils.class.php");
$vRequest = new RequestUtils();
require_once ("../application/classes/StringUtils.class.php");
$vString = new StringUtils();

include "../application/config/session_config.php";
include "../include/connect/Connect.php";

$vOrderId =  $vRequest->getParameter('order_id');
$vOrderResult = MysqlQuery::getOrder($conn, $vOrderId);

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.shiplogic.com/shipments',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => '{
    "collection_address": {
        "type": "business",
        "company": "Graffiti Zambezi Junction",
        "street_address": "Winkel no 10, Zambezi Junction, Hoek van Breedstraat en Sefako Makgathorylaan",
        "local_area": "Montana",
        "city": "Pretoria",
        "code": "0181",
        "zone": "Gauteng",
        "country": "ZA",
        "lat": -25.68187839881142,
        "lng": 28.272422149038896
    },
    "collection_contact": {
        "name": "Leonie van Rensburg",
        "mobile_number": "",
        "email": "leonie@graffitibooks.co.za"
    },
    "delivery_address": {
        "type": "residential",
        "company": "",
        "street_address": "10 Midas Ave",
        "local_area": "Olympus AH",
        "city": "Pretoria",
        "code": "0081",
        "zone": "Gauteng",
        "country": "ZA",
        "lat": -25.80665579999999,
        "lng": 28.334732
    },
    "delivery_contact": {
        "name": "",
        "mobile_number": "",
        "email": "cornel+sandyreceiver@uafrica.com"
    },
    "parcels": [
        {
            "parcel_description": "Standard flyer",
            "submitted_length_cm": 20,
            "submitted_width_cm": 20,
            "submitted_height_cm": 10,
            "submitted_weight_kg": 2
        }
    ],
    "opt_in_rates": [],
    "opt_in_time_based_rates": [
        76
    ],
    "special_instructions_collection": "Pick up at door",
    "special_instructions_delivery": "Beware of dog",
    "declared_value": 1100,
    "collection_min_date": "2021-05-21T00:00:00.000Z",
    "collection_after": "08:00",
    "collection_before": "16:00",
    "delivery_min_date": "2021-05-21T00:00:00.000Z",
    "delivery_after": "10:00",
    "delivery_before": "17:00",
    "custom_tracking_reference": "",
    "customer_reference": "ORDERNO123",
    "service_level_code": "ECO",
    "mute_notifications": false
}',
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Authorization: ',
        'accessKeyId: AKIA55D5DNTBCDR75VEW',
        'secret: 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',
        'X-Amz-Date: 20210202T112645Z'
    ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
