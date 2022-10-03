<?php
/**
 * @author Carin Pretorius - CEIT Development
 * Created on 2016-11_02
 */

session_start();
session_cache_limiter( 'nocache' );
require_once ("../application/classes/General.class.php");
$vGeneral = new General();

//include "application/config/session_config.php";
include "../include/connect/Connect.php";

require_once ("../application/classes/RequestUtils.class.php");
$vRequest = new RequestUtils();
require_once ("../application/classes/StringUtils.class.php");
$vString = new StringUtils();
require_once ("../application/classes/MysqlQuery.class.php");
$vQuery = new MysqlQuery();
require_once ("../application/classes/Parts.class.php");
$vParts = new Parts();
require_once ("../application/classes/Pages.class.php");
$vPages = new Pages();

$vSection =  $vRequest->getParameter('section');
//$vKeyword =  $vRequest->getParameter('term');
$vKeyword =  str_replace("-", " ", $vRequest->getParameter('term'));
if(is_int($vKeyword)){
	$vValue = "{$vKeyword}%";
}
else {
	$vValue = "%{$vKeyword}%";
}
$vWhere = "value like ?";
if($vSection == 1){
	$vResults = $vQuery->getBookSearchComplete($conn, $vWhere, $vValue);//$vId, $vTitle, $vIsbn
}

echo json_encode($vResults);

