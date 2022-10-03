<?php
/**
 * @author Carin Pretorius - CEIT Development
 * Created on 2016-11_02
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

$vType =  $vRequest->getParameter('type');

if($vType == "edit"){
	//type: "edit", client_id: vClientId, special_discount: vSpecial_discount
    $vQueryResult = 0;
    $vId = $_POST['client_id'];
	$vData['special_discount'] = $_POST['special_discount'];
	$vData['validated'] = $_POST['validated'];

	$vQueryResult = MysqlQuery::doUpdate($conn, 'clients', $vData, "id = ".$vId);
	if ($vQueryResult == 1){
		echo 'success';
	}
	else if ($vQueryResult == 0){
		echo 'error';
	}
}

include "../include/connect/CloseConnect.php";
