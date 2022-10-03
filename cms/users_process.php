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

if($vType == "edit-sql"){
	//"users_process.php", {type: "save", user_id: vUsertId, name: vName, surname: vSurname, email: vEmail, rights: vRights, sections:vSections
    $vQueryResult = 0;
    $vId = $_POST['user_id'];
	$vData['name'] = $vGeneral->prepareStringForQuery($_POST['name']);
	$vData['surname'] = General::prepareStringForQuery($_POST['surname']);
	$vData['email'] = General::prepareStringForQuery($_POST['email']);
	$vData['rights'] = General::prepareStringForQuery($_POST['rights']);
	$vData['sections'] = implode(",", $_POST['sections']);
	$vPassword = $_POST['password'];

	if(!empty($vPassword)){
		$hash = hash('sha256', $vPassword);
		$salt = General::createSalt(15);
		$hash = hash('sha256', $salt . $hash);
		$vData['password'] = $hash;
		$vData['salt'] = $salt;
	}

	$vQueryResult = MysqlQuery::doUpdate($conn, 'users', $vData, "id = ".$vId);
	if ($vQueryResult == 1){
		echo 'success';
	}
	else if ($vQueryResult == 0){
		echo 'error';
	}
}
if($vType == "add-sql"){
    $vQueryResult = 0;
	$vData['name'] = $vGeneral->prepareStringForQuery($_POST['name']);
	$vData['surname'] = General::prepareStringForQuery($_POST['surname']);
	$vData['email'] = General::prepareStringForQuery($_POST['email']);
	$vData['rights'] = General::prepareStringForQuery($_POST['rights']);
	$vData['sections'] = implode(",", $_POST['sections']);
	$vPassword = $_POST['password'];

	$hash = hash('sha256', $vPassword);
	$salt = General::createSalt(15);
	$hash = hash('sha256', $salt . $hash);
	$vData['password'] = $hash;
	$vData['salt'] = $salt;

	$vExists = MysqlQuery::checkExists($conn, "users", "id", "upper(email) = '".strtoupper($vData[email]."'"));

	if($vExists > 0){
		$vDouble = 1;
		unset($_SESSION['SessionGrafCmsMessage']);
		$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"error-message\"><i class=\"fa fa-times fa-lg space-right red\" aria-hidden=\"true\"></i>'n Nuusbrief met dieselfde naam bestaan reeds. Verander die nuwe l&#234;ernaam of kies 'n ander l&#234;er.</h4>";
	}
	else {
		$vDouble = 0;
		$vQueryResult = MysqlQuery::doInsert($conn, 'users', $vData);
	}

	if ($vQueryResult == 1 && $vDouble == 0){
		unset($_SESSION['SessionGrafCmsMessage']);
		$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"success-message\"><i class=\"fa fa-check fa-lg space-right green\" aria-hidden=\"true\"></i>Die nuusbrief is gelaai.</h4>";
	}
	else if($vQueryResult == 0 && $vDouble == 1){
		unset($_SESSION['SessionGrafCmsMessage']);
		$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"error-message\"><i class=\"fa fa-times fa-lg space-right red\" aria-hidden=\"true\"></i>Die gebruiker is nie gelaai nie. Die epos bestaan reeds in die databasis.</h4>";
	}
	else if ($vQueryResult == 0 && $vDouble == 0){
		unset($_SESSION['SessionGrafCmsMessage']);
		$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"error-message\"><i class=\"fa fa-times fa-lg space-right red\" aria-hidden=\"true\"></i>Die gebruiker is nie gelaai nie. Probeer asseblief weer of kontak die Webmaster.</h4>";
	}
	$vUrl = "index.php?page=users&type=list";
	General::echoRedirect($vUrl, "");
}
else if($vType == "delete"){
    $vQueryResult = 0;
	$vId = RequestUtils::getParameter("id");

	$vQueryResult = MysqlQuery::doDelete($conn, 'users', "id = ".$vId);
	if ($vQueryResult == 1){
		unset($_SESSION['SessionGrafCmsMessage']);
		$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"success-message\"><i class=\"fa fa-check fa-lg space-right green\" aria-hidden=\"true\"></i>Die gebruiker is uitgevee.</h4>";
	}
	else if ($vQueryResult == 0){
		unset($_SESSION['SessionGrafCmsMessage']);
		$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"error-message\"><i class=\"fa fa-times fa-lg space-right red\" aria-hidden=\"true\"></i>Die gebruiker is nie uitgevee nie. Probeer asseblief weer of kontak die Webmaster.</h4>";
	}
	$vUrl = "index.php?page=users&type=list&id=0";
	General::echoRedirect($vUrl, "");
}

include "../include/connect/CloseConnect.php";
