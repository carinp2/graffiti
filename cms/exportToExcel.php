<?php

/**
 * @author Carin Pretorius - CEIT Development
 * Created on 2016-10-18
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
require_once ("application/classes/CmsExcelExports.class.php");
$vExcel = new CmsExcelExports();

include "../application/config/session_config.php";
include "../include/connect/Connect.php";

$vData['type'] =  $vRequest->getParameter('type');
$vData['id']  =  $vRequest->getParameter('id');
$vString = "";

if($vData['type']  == "searchBookPublisher" || $vData['type']  == "searchBookSubCategory"){
	$vExcel->getBookExport($conn, $vData);
}
else if($vData['type']  == "marketing-export"){
		$vExcel->getBookMarketExport($conn);
}
else if($vData['type']  == "me"){
	$vStartDate = $_GET['sd'];
	$vEndDate = $_GET['ed'];
	$vExcel->getMonthEndExport($conn, $vStartDate, $vEndDate);
}
include "../include/connect/CloseConnect.php";
