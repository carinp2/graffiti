<?php
/**
 * @author Carin Pretorius - CEIT Development
 * Created on 2016-11_02
 */
session_start();
session_cache_limiter( 'nocache' );
require_once ("application/classes/General.class.php");
$vGeneral = new General();

//include "application/config/session_config.php";
include "include/connect/Connect.php";

require_once ("application/classes/MysqlQuery.class.php");
$vQuery = new MysqlQuery();
require_once ("application/classes/StringUtils.class.php");
$vString = new StringUtils();

if($_POST['payment_result'] == 0){//success
	$vOrderBindParams = array();
	$vOrderBindLetters = "s";
	$vOrderBindParams[] = & $_POST['order_id'];
	$vOrderLimit = "LIMIT 1";
	$vOrderWhere = " WHERE id = ?";
	$vOrderResult = MysqlQuery::getOrder($conn, $vOrderWhere, "", $vOrderBindLetters, $vOrderBindParams, $vOrderLimit);

	$vOrderDetailResult = MysqlQuery::getOrderDetail($conn, "order_id = ?", $vOrderResult[0][0]);

	if($vOrderResult[10][0] != 5){
		$vShortDeliveryCostText = MysqlQuery::getCourierTextPerIdBilingual($conn, $vOrderResult[10][0], 1);
	}
	else if($vOrderResult[10][0] == 5){
		$vShortDeliveryCostText = MysqlQuery::getCourierTextPerIdBilingual($conn, $vOrderResult[10][0], 0);
	}
	include_once "include/Invoice.php";
	include_once "include/Email.php";
}
else if($_POST['payment_result'] == 1){//error
	$vOrderBindParams = array();
	$vOrderBindLetters = "s";
	$vOrderBindParams[] = & $_POST['order_id'];
	$vOrderLimit = "LIMIT 1";
	$vOrderWhere = " WHERE id = ?";
	$vOrderResult = MysqlQuery::getOrder($conn, $vOrderWhere, "", $vOrderBindLetters, $vOrderBindParams, $vOrderLimit);

	$vOrderDetailResult = MysqlQuery::getOrderDetail($conn, "order_id = ?", $vOrderResult[0][0]);

	if($vOrderResult[10][0] != 5){
		$vShortDeliveryCostText = MysqlQuery::getCourierTextPerIdBilingual($conn, $vOrderResult[10][0], 1);
	}
	else if($vOrderResult[10][0] == 5){
		$vShortDeliveryCostText = MysqlQuery::getCourierTextPerIdBilingual($conn, $vOrderResult[10][0], 0);
	}
	include_once "include/Invoice.php";
	include_once "include/Email.php";
}

include "include/connect/CloseConnect.php";