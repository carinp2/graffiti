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

if($vType == "update-rotate-rank"){
	$vQueryResult = 0;
	$vId = $_POST['rotate_id'];
	$vData['sort_order'] = +$_POST['rank'];

	$vQueryResult = MysqlQuery::doUpdate($conn, "carousel_images", $vData, "id = ".$vId);
	if ($vQueryResult > 0){
		echo 'success';
	}
	else if ($vQueryResult == 0){
		echo 'error';
	}
}
else if($vType == "save-rotate"){
	$vQueryResult = 0;
	$vId = $_POST['rotate_id'];
	$vData['url'] = General::prepareStringForQuery($_POST['url']);
	$vData['alt'] = General::prepareStringForQuery($_POST['alt']);

	$vQueryResult = MysqlQuery::doUpdate($conn, "carousel_images", $vData, "id = ".$vId);
	if ($vQueryResult > 0){
		echo 'success';
	}
	else if ($vQueryResult == 0){
		echo 'error';
	}
}
else if($vType == "delete-rotate"){
	$vQueryResult = 0;
	$vId = $_POST['rotate_id'];
	$vBlobPath = $_POST['blob_path'];

	$dir = "../images/uploads/".substr($vBlobPath,0,14);
	foreach(glob($dir . '*.*') as $v) {
		unlink($v);
	}
	rmdir($dir);

	$vQueryResult = MysqlQuery::doDelete($conn, "carousel_images", "id = ".$vId);
	if ($vQueryResult > 0){
		echo 'success';
	}
	else if ($vQueryResult == 0){
		echo 'error';
	}
}
else if($vType == "add-rotate"){
	$vQueryResult = 0;
	$vMaxSort = RequestUtils::getParameter('max_sort');
	$vData['url'] =  General::prepareStringForQuery(RequestUtils::getParameter('new_url'));
	$vData['alt'] = General::prepareStringForQuery(RequestUtils::getParameter('new_alt'));
	$vData['sort_order'] = $vMaxSort+1;
	$vBlobPath =  $_FILES['new_blob_path']["name"];
		if(!empty($vBlobPath)){
			$vTempFolder = $_FILES['new_blob_path']["tmp_name"];
			$vDirectory = "../images/uploads/";
			$vUnique = uniqid() . "/";
			$vUniqueDirectory = $vDirectory . $vUnique;
		if(!is_dir($vUniqueDirectory)) {
			mkdir($vUniqueDirectory, 0777);
		}
		$vData['blob_path'] = $vUnique.preg_replace('/\s+/', '', $vBlobPath);
		move_uploaded_file($vTempFolder, $vUniqueDirectory.preg_replace('/\s+/', '', $vBlobPath));
		}

	$vQueryResult = MysqlQuery::doInsert($conn, "carousel_images", $vData);
	if ($vQueryResult > 0){//success
		unset($_SESSION['SessionGrafCmsMessage']);
		$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"success-message\"><i class=\"fa fa-check fa-lg space-right green\" aria-hidden=\"true\"></i>Die roterende prent is gelaai.</h4>";
	}
	else if ($vQueryResult == 0){//error
		unset($_SESSION['SessionGrafCmsMessage']);
		$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"error-message\"><i class=\"fa fa-times fa-lg space-right red\" aria-hidden=\"true\"></i>Die roterende prent is nie gelaai nie. Probeer asseblief weer of kontak die Webmaster.</h4>";
	}
	$vUrl = "index.php?page=landing&type=images";
	General::echoRedirect($vUrl, "");
}

include "../include/connect/CloseConnect.php";
