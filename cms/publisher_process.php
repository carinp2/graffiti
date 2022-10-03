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
	//type: "edit", publisher_id: vPublisherId, publisher: vPublisher, supplier: vSupplier
    $vQueryResult = 0;
    $vId = $_POST['publisher_id'];
	$vData['publisher'] = $vGeneral->prepareStringForQuery($_POST['publisher']);
	$vData['supplier'] = General::prepareStringForQuery($_POST['supplier']);

	$vQueryResult = MysqlQuery::doUpdate($conn, 'publishers', $vData, "id = ".$vId);
	if ($vQueryResult == 1){
		echo 'success';
	}
	else if ($vQueryResult == 0){
		echo 'error';
	}
}
else if($vType == "add"){
	//type: "add",publisher: vPublisher, supplier: vSupplier
    $vQueryResult = 0;
    $vData['id'] = $_POST['new_id'];
	$vData['publisher'] = $vGeneral->prepareStringForQuery($_POST['new_publisher']);
	$vData['supplier'] = General::prepareStringForQuery($_POST['new_supplier']);

	$vQueryResult = MysqlQuery::doInsert($conn, 'publishers', $vData);
	if ($vQueryResult > 0){
		unset($_SESSION['SessionGrafCmsMessage']);
		$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"success-message\"><i class=\"fa fa-check fa-lg space-right green\" aria-hidden=\"true\"></i>Die uitgewer is gelaai</h4>";
	}
	else if ($vQueryResult == 0){
		unset($_SESSION['SessionGrafCmsMessage']);
		$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"error-message\"><i class=\"fa fa-times fa-lg space-right red\" aria-hidden=\"true\"></i>Die uitgewer is nie gelaai nie. Probeer asseblief weer of kontak die Webmaster.</h4>";
	}
	$vUrl = "index.php?page=publishers&type=list&id=0";
	General::echoRedirect($vUrl, "");
}
else if($vType == "delete"){
	//type: "add",publisher: vPublisher, supplier: vSupplier
    $vQueryResult = 0;
	$vId = RequestUtils::getParameter("id");

	$vQueryResult = MysqlQuery::doDelete($conn, 'publishers', "id = ".$vId);
	if ($vQueryResult == 1){
		unset($_SESSION['SessionGrafCmsMessage']);
		$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"success-message\"><i class=\"fa fa-check fa-lg space-right green\" aria-hidden=\"true\"></i>Die uitgewer is uitgevee</h4>";
	}
	else if ($vQueryResult == 0){
		unset($_SESSION['SessionGrafCmsMessage']);
		$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"error-message\"><i class=\"fa fa-times fa-lg space-right red\" aria-hidden=\"true\"></i>Die uitgewer is nie uitgevee nie. Probeer asseblief weer of kontak die Webmaster.</h4>";
	}
	$vUrl = "index.php?page=publishers&type=list&id=0";
	General::echoRedirect($vUrl, "");
}
else if($vType == "check-id"){
	$vQueryResult = 0;
	$vId = $_POST['new_id'];

	$vQueryResult = MysqlQuery::checkExists($conn, 'publishers', 'id', "id = ".$vId);
	if ($vQueryResult > 0){
		echo 'exist';
	}
	else if ($vQueryResult == 0){
		echo 'not-exist';
	}
}
else if($vType == "check-publisher"){
	$vQueryResult = 0;
	$vPublisher = $_POST['new_publisher'];

	$vQueryResult = MysqlQuery::checkExists($conn, 'publishers', 'id', "publisher = '".$vPublisher."'");
	if ($vQueryResult > 0){
		echo 'exist';
	}
	else if ($vQueryResult == 0){
		echo 'not-exist';
	}
}

include "../include/connect/CloseConnect.php";
