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

if($vType == "paid"){
	//id: vId, client_id: vClientId, amount: vOrderAmount, salt: vOrderSalt, instock: vInStock
    $vQueryResult = 0;
    $vOrderId = $_POST['order_id'];
    $vClientId = $_POST['client_id'];
    $vAmount = $_POST['amount'];
    $vSalt = $_POST['salt'];
    $vInStock = $_POST['instock'];
    $vCourierType = $_POST['courier'];
    $vClientResult = MysqlQuery::getOrderClient($conn, $vClientId);

    include_once 'include/CmsEmail.php';

    $vData['paid'] = 1;
	$vQueryResult = MysqlQuery::doUpdate($conn, 'orders', $vData, "id = ".$vOrderId);

	if ($vClient == 2 || $vQueryResult == 0){
		echo 'error';
	}
	else if ($vClient == 1 && $vQueryResult > 0){
		echo 'success';
	}
}
else if($vType == "processed"){
	//id: vId, client_id: vClientId, amount: vOrderAmount, salt: vOrderSalt
    $vQueryResult = 0;
    $vOrderId = $_POST['order_id'];
    $vClientId = $_POST['client_id'];
    $vAmount = $_POST['amount'];
    $vSalt = $_POST['salt'];
    $vCourierType = $_POST['courier'];
    $vClientResult = MysqlQuery::getOrderClient($conn, $vClientId);

    include_once 'include/CmsEmail.php';

    $vData['processed'] = 1;
	$vQueryResult = MysqlQuery::doUpdate($conn, 'orders', $vData, "id = ".$vOrderId);

	if ($vClient == 2 || $vQueryResult == 0){
		echo 'error';
	}
	else if ($vClient == 1 && $vQueryResult > 0){
		echo 'success';
	}
}
else if($vType == "posted"){
	//id: vId, client_id: vClientId, amount: vOrderAmount, salt: vOrderSalt, tracking: vTracking
    $vQueryResult = 0;
    $vOrderId = $_POST['order_id'];
    $vClientId = $_POST['client_id'];
    $vCourierType = $_POST['courier_type'];
    $vSalt = $_POST['salt'];
    $vCourierSelected = $_POST['courier_selected'];
    $vClientResult = MysqlQuery::getOrderClient($conn, $vClientId);

    include_once 'include/CmsEmail.php';

    $vData['posted'] = $_POST['posted'];
    //$vData['posted'] = 1;
    $vData['tracking_no'] = $_POST['tracking'];
    $vData['posted_date'] = $_SESSION['now_date'];
    $vData['courier_comp'] = $_POST['courier_selected'];
	$vQueryResult = MysqlQuery::doUpdate($conn, 'orders', $vData, "id = ".$vOrderId);

	if ($vClient == 2 || $vQueryResult == 0){
		echo 'error';
	}
	else if ($vClient == 1 && $vQueryResult > 0){
		echo 'success';
	}
}
else if($vType == "completed"){
    $vQueryResult = 0;
    $vOrderId = $_POST['order_id'];

    $vData['completed'] = 1;
	$vQueryResult = MysqlQuery::doUpdate($conn, 'orders', $vData, "id = ".$vOrderId);

	if ($vQueryResult == 0){
		echo 'error';
	}
	else if ($vQueryResult > 0){
		echo 'success';
	}
}
else if($vType == "settled"){
    $vQueryResult = 0;
    $vOrderId = $_POST['order_id'];

    $vData['settled'] = 1;
	$vQueryResult = MysqlQuery::doUpdate($conn, 'orders', $vData, "id = ".$vOrderId);

	if ($vQueryResult == 0){
		echo 'error';
	}
	else if ($vQueryResult > 0){
		echo 'success';
	}
}
else if($vType == "order"){// order_id: vOrderId, note: vNote, courier_type: vCourierType, courier_cost: vCourierCost, total_cost: vTotalCost, tracking_no: vTrackingNo
    $vQueryResult = 0;
    $vOrderId = $_POST['order_id'];

    $vData['note'] =  General::prepareStringForQuery($_POST['note']);
    $vData['courier_type'] =  General::prepareStringForQuery($_POST['courier_type']);
    $vData['courier_cost'] =  General::prepareStringForQuery($_POST['courier_cost']);
    $vData['total_price'] =  General::prepareStringForQuery($_POST['total_cost']);
    $vData['tracking_no'] =  General::prepareStringForQuery($_POST['tracking_no']);
    $vData['payment_type'] = General::prepareStringForQuery($_POST['payment_type']);
    $vData['posted'] = General::prepareStringForQuery($_POST['posted']);

	$vQueryResult = MysqlQuery::doUpdate($conn, 'orders', $vData, "id = ".$vOrderId);

	if ($vQueryResult == 0){
		echo 'error';
	}
	else if ($vQueryResult > 0){
		echo 'success';
	}
}
else if($vType == "delete"){
    $vQueryResult = 0;
    $vOrderId = $_POST['order_id'];

	$vQueryResult = MysqlQuery::doDelete($conn, 'orders', "id = ".$vOrderId);
	$vQueryResult = MysqlQuery::doDelete($conn, 'orders_detail', "order_id = ".$vOrderId);

	if ($vQueryResult == 0){
		unset($_SESSION['SessionGrafCmsMessage']);
		$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"error-message\"><i class=\"fa fa-times fa-lg space-right red\" aria-hidden=\"true\"></i>Die bestelling is nie uitgevee nie. Probeer asseblief weer of kontak die Webmaster.</h4>";
		echo 'error';
	}
	else if ($vQueryResult > 0){
		unset($_SESSION['SessionGrafCmsMessage']);
		$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"success-message\"><i class=\"fa fa-check fa-lg space-right green\" aria-hidden=\"true\"></i>Die bestelling is uitgevee.</h4>";
		echo 'success';
	}
}
else if($vType == "invoice_print" || $vType == "invoice_print_wr"){
	$vOrderId = $vRequest->getParameter('order_id');
	$vOrderBindParams = array();
	$vOrderBindLetters = "s";
	$vOrderBindParams[] = & $vOrderId;
	$vOrderLimit = "LIMIT 1";
	$vOrderWhere = " WHERE id = ?";
	$vOrderResult = MysqlQuery::getOrder($conn, $vOrderWhere, "", $vOrderBindLetters, $vOrderBindParams, $vOrderLimit);
	$vOrderDetailResult = MysqlQuery::getOrderDetail($conn, "order_id = ?", $vOrderResult[0][0]);
	$vClientResult = MysqlQuery::getOrderClient($conn,  $vRequest->getParameter('client_id'));

	if($vOrderResult[10][0] != 5){
		$vCourierType = MysqlQuery::getCourierTextPerIdBilingual($conn, $vOrderResult[10][0], 1);
	}
	else if($vOrderResult[10][0] == 5){
		$vCourierType = MysqlQuery::getCourierTextPerIdBilingual($conn, $vOrderResult[10][0], 0);
	}
	if($vOrderResult[14][0] == 15){
		$vPaymentType = "CH";
	}
	else if($vOrderResult[14][0] == 16 || $vOrderResult[14][0] == 17){
		$vPaymentType = "TC";
	}
	else if($vOrderResult[14][0] == 57){
		$vPaymentType = "Z";
	}

	include_once "include/CmsInvoice.php";
}

include "../include/connect/CloseConnect.php";
