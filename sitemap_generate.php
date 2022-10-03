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
require_once ("application/classes/Parts.class.php");
$vParts = new Parts();
require_once ("application/classes/Pages.class.php");
$vPages = new Pages();

include_once "application/config/session_menu.php";

$vXML = new ZipArchive();
$vFileName = 'sitemap.xml';
$opened = $vXML->open('test.xml', ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);
$x = $vXML->addFromString($vFileName, $vPages->getSitemapXML($conn));
$vXML->close();
