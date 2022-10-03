<?php
/**
 * @author Carin Pretorius - CEIT Development
 * Created on 2016-11_02
 */

session_start();

require_once ("application/classes/General.class.php");
$vGeneral = new General();

include "application/config/session_config.php";
include "include/connect/Connect.php";

require_once ("application/classes/RequestUtils.class.php");
$vRequest = new RequestUtils();
require_once ("application/classes/MysqlQuery.class.php");
$vQuery = new MysqlQuery();

    $vQueryResult = 0;

	$vUsername = $_POST['username'];
	$vPassword = $_POST['password'];
	$vRemember = $_POST['remember'];

	$vQueryResult = $vQuery->doLogin($conn, $vUsername, $vPassword);

	if ($vQueryResult == 1){
		echo 'success';
	}
	else if($vQueryResult == 2 && $_SESSION['SessionGrafLoginNo'] >= 4){
		echo 'attempts';
	}
	else {
		echo 'error';
	}

include "include/connect/CloseConnect.php";

?>