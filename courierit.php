<?php
//  $soap = new SoapClient('http://www.citwebservices.co.za/citwebservices.asmx');
//  $token = $soap->Login("Graffiti", "#50284#");

// if (is_soap_fault($token)) {
//     echo "SOAP Fault: (faultcode: {$token->faultcode}, faultstring: {$token->faultstring})";
// }
// else {
// 	 echo "The token: ".$token;
// }



//$params = array('param1'=>$param1);


$soap = "http://www.citwebservice.co.za/citwebservices/CITWebServices.asmx";
try {
	$soap = new SoapClient($soap);
	$data = $soap->Login("Graffiti", "#50284#");
}
catch(Exception $e) {
	die($e->getMessage());
}

var_dump($data);
die;