<?php

$ch = curl_init();                    // initiate curl
$url = "http://svc.internetexpress.co.za:80/api/point/single"; // where you want to post data
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ch, CURLOPT_POST, false);  // tell curl you want to post something
curl_setopt($ch, CURLOPT_POSTFIELDS, "PointId=2884"); // define what you want to post
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the output in string format
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
	'Accept: application/json')
);
$output = curl_exec ($ch); // execute

curl_close ($ch); // close curl handle

var_dump($output); // show output
?>