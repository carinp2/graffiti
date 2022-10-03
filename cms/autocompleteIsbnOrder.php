<?php
/**
 * @author Carin Pretorius - CEIT Development
 * Created on 2017-07-04
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

$vKeyword =  $vRequest->getParameter('term');
$vIsbn = "%{$vKeyword}%";
$vWhere = "b.isbn like ?";
$vResults = $vQuery->getOrdersIsbnMin($conn, $vWhere, $vIsbn);//$vId, $vTitle, $vIsbn
//error_log("vResults: ".$vResults, 0, "C:/Temp/php_errors.log");
echo json_encode($vResults);

