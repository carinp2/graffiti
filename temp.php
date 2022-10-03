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

$vCategories = MysqlQuery::getCategories($conn, 1, 1);//$vCategoryId, $vCategory

for($x = 0; $x < count($vCategories[0]); $x++){
	echo "af/c/Soek/".$vCategories[0][$x]."/date_publish+DESC/".$vCategories[1][$x];
	echo "<br>";
	echo "en/c/Search/".$vCategories[0][$x]."/date_publish+DESC/".$vCategories[1][$x];
	echo "<br>";
}

?>