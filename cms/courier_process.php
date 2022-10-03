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
	//type: edit, courier_id: vCourierId, af: vAf, en: vEn, rate1: vRate1, rate2: vRate2, rate3: vRate3, rate4: vRate4, rate5: vRate5, rate6: vRate6, rate7: vRate7
    $vQueryResult = 0;
    $vId = $_POST['courier_id'];
    $vData['af'] = filter_var($_POST['af'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $vData['en'] = filter_var($_POST['en'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//	$vData['af'] = $vGeneral->prepareStringForQuery($_POST['af']);
//	$vData['en'] = $vGeneral->prepareStringForQuery($_POST['en']);
	$vData['rate_1'] = $_POST['rate1'];
	$vData['rate_2'] = $_POST['rate2'];
	$vData['rate_3'] = $_POST['rate3'];
	$vData['rate_4'] = $_POST['rate4'];
	$vData['rate_5'] = $_POST['rate5'];
	$vData['rate_6'] = $_POST['rate6'];
	$vData['rate_7'] = $_POST['rate7'];
//    error_log("Update AF: ".$_POST['af'], 3, "../error.log");
	$vQueryResult = MysqlQuery::doUpdate($conn, 'courier_cost', $vData, "id = ".$vId);
	if ($vQueryResult == 1){
		echo 'success';
	}
	else if ($vQueryResult == 0){
		echo 'error';
	}
}

include "../include/connect/CloseConnect.php";
