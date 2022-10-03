<?php
session_start();

require_once ("application/classes/General.class.php");
$vGeneral = new General();

require_once("application/config/session_config.php");
include "include/connect/Connect.php";

require_once ("application/classes/RequestUtils.class.php");
$vRequest = new RequestUtils();
require_once ("application/classes/StringUtils.class.php");
$vString = new StringUtils();
require_once ("application/classes/MysqlQuery.class.php");
$vQuery = new MysqlQuery();
require_once("application/classes/Export.class.php");
$vExport = new Export();

$vId = $vRequest->getParameter('id');
$vMarket = $vRequest->getParameter('market');
if((!empty($vId) && $vId == 2490) && empty($vMarket)){//Litera
	$vXML = new ZipArchive();
	$vFileName = 'graffitibooksLitera.xml';
	$opened = $vXML->open('test.xml', ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);
	$x = $vXML->addFromString($vFileName, $vExport->getXMLPerPublisher($conn, $vId));
	$vXML->close();
}
else if ((!empty($vId) && $vId == 2693) && empty($vMarket)){//Quivertree
	$vXML = new ZipArchive();
	$vFileName = 'graffitibooksQuivertree.xml';
	$opened = $vXML->open('test.xml', ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);
	$x = $vXML->addFromString($vFileName, $vExport->getXMLPerPublisher($conn, $vId));
	$vXML->close();
}
else if(empty($vId) && !empty($vMarket)){
	$vXML = new ZipArchive();
	$vFileName = 'graffitibooks.xml';
	$opened = $vXML->open('test.xml', ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);
	$x = $vXML->addFromString($vFileName, $vExport->getFullXML($conn));
	$vXML->close();
}
?>