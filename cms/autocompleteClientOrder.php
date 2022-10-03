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
$vFirstname = "%{$vKeyword}%";
$vSurname = "%{$vKeyword}%";
$vWhere = "firstname like ? or surname like ?";
$vResults = $vQuery->getClientsMin($conn, $vWhere, $vFirstname, $vSurname);//$vId, $vTitle, $vIsbn

echo json_encode($vResults);

