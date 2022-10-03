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

if($vType == "edit"){
	//type: "edit", id: vEventId, name: vName, date: vDate, time: Vtime, detail: vDetail, rsvp:vRsvp, price: vPrice, location: vLocation
    $vQueryResult = 0;
    $vId = $_POST['event_id'];
	$vData['name'] = $vGeneral->prepareStringForQuery($_POST['name']);
	$vData['date'] = General::prepareStringForQuery($_POST['date']);
	$vData['time'] = General::prepareStringForQuery($_POST['time']);
	$vData['detail'] = General::prepareStringForQuery($_POST['detail']);
	$vData['rsvp'] = General::prepareStringForQuery($_POST['rsvp']);
	$vData['price'] = General::prepareStringForQuery($_POST['price']);
	$vData['location'] = General::prepareStringForQuery($_POST['location']);

	$vQueryResult = MysqlQuery::doUpdate($conn, 'events', $vData, "id = ".$vId);
	if ($vQueryResult == 1){
		echo 'success';
	}
	else if ($vQueryResult == 0){
		echo 'error';
	}
}
else if($vType == "delete"){
    $vQueryResult = 0;
	$vId = RequestUtils::getParameter("id");

	$vBlobPath = MysqlQuery::getBlobPath($conn, $vId, "events");
	if(!empty($vBlobPath)){
		$dir = "../images/posters/".substr($vBlobPath,0,14);
		foreach(glob($dir . '*.*') as $v) {
			unlink($v);
		}
		rmdir($dir);
	}

	$vQueryResult = MysqlQuery::doDelete($conn, 'events', "id = ".$vId);
	if ($vQueryResult == 1){
		unset($_SESSION['SessionGrafCmsMessage']);
		$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"success-message\"><i class=\"fa fa-check fa-lg space-right green\" aria-hidden=\"true\"></i>Die funksie en advertensies is uitgevee.</h4>";
	}
	else if ($vQueryResult == 0){
		unset($_SESSION['SessionGrafCmsMessage']);
		$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"error-message\"><i class=\"fa fa-times fa-lg space-right red\" aria-hidden=\"true\"></i>Die funksie is nie uitgevee nie. Probeer asseblief weer of kontak die Webmaster.</h4>";
	}
	$vUrl = "index.php?page=events&type=future&id=0";
	General::echoRedirect($vUrl, "");
}
else if($vType == "add-sql" || $vType == "edit-sql"){
    $vQueryResult = 0;
	$vData['name'] = $vGeneral->prepareStringForQuery($_POST['name']);
	$vData['date'] = General::prepareStringForQuery($_POST['date']);
	$vData['time'] = General::prepareStringForQuery($_POST['time']);
	$vData['location'] = General::prepareStringForQuery($_POST['location']);
	$vData['detail'] = General::prepareStringForQuery($_POST['detail']);
	$vData['rsvp'] =  $vGeneral->prepareStringForQuery($_POST['rsvp']);
	$vData['price'] =  $vGeneral->prepareStringForQuery($_POST['price']);

	if($vType == "add-sql"){
		$vNewBlobPath =  $_FILES['poster_path']["name"];

		//DOC LOAD
		if(!empty($vNewBlobPath)){
			$vFileNameFull = $_FILES['poster_path']["name"];
			if(strlen($vFileNameFull) > 40){
				$vExt = substr($vFileNameFull, strpos($vFileNameFull, "."));
				$vFileName = substr($vFileNameFull, 0, 20).$vExt;
			}
			else{
				$vFileName = $vFileNameFull;
			}
			$vTempFolder = $_FILES['poster_path']["tmp_name"];
			$vDirectory = "../images/posters/";
			$vUnique = uniqid() . "/";
			$vUniqueDirectory = $vDirectory . $vUnique;
			if(!is_dir($vUniqueDirectory)) {
				mkdir($vUniqueDirectory, 0777);
			}
			$vData['poster_path'] = $vUnique.preg_replace('/\s+/', '', $vFileName);
			move_uploaded_file($vTempFolder, $vUniqueDirectory.preg_replace('/\s+/', '', $vFileName));
		}

		$vQueryResult = MysqlQuery::doInsert($conn, 'events', $vData);

		if(!empty($_FILES['photos']['name'])){
			$vDirectory = "../images/events/";
			$vUnique = uniqid() . "/";
			$vUniqueDirectory = $vDirectory . $vUnique;
			if(!is_dir($vUniqueDirectory)) {
				mkdir($vUniqueDirectory, 0777);
			}
		    foreach ($_FILES['photos']['name'] as $i => $name) {
		        if (strlen($_FILES['photos']['name'][$i]) > 1) {
					$vDataPhotos['event_id'] = $vQueryResult;
					$vDataPhotos['blob_path'] = $vUnique.preg_replace('/\s+/', '', $name);
					move_uploaded_file($_FILES['photos']['tmp_name'][$i], $vUniqueDirectory.preg_replace('/\s+/', '', $name));
					$vQueryResultImages = MysqlQuery::doInsert($conn, 'event_images', $vDataPhotos);
		        }
		    }
		}

		if ($vQueryResult >= 1 && $vQueryResultImages >= 1){
			unset($_SESSION['SessionGrafCmsMessage']);
			$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"success-message\"><i class=\"fa fa-check fa-lg space-right green\" aria-hidden=\"true\"></i>Die funksie is gelaai.</h4>";
		}
		else if($vQueryResult >= 1 && $vQueryResultImages == 0){
			unset($_SESSION['SessionGrafCmsMessage']);
			$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"success-message\"><i class=\"fa fa-check fa-lg space-right green\" aria-hidden=\"true\"></i>Die funksie is gelaai maar die foto's is nie gelaai nie</h4>";
		}
		else if ($vQueryResult == 0 && $vQueryResultImages == 0){
			unset($_SESSION['SessionGrafCmsMessage']);
			$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"error-message\"><i class=\"fa fa-times fa-lg space-right red\" aria-hidden=\"true\"></i>Die funksie en foto's is nie gelaai nie. Probeer asseblief weer of kontak die Webmaster.</h4>";
		}
	}
	if($vType == "edit-sql"){
		$vId = $vRequest->getParameter('id');
		$vFileNameFull = $_FILES['poster_path']["name"];
		if(strlen($vFileNameFull) > 40){
			$vExt = substr($vFileNameFull, strpos($vFileNameFull, "."));
			$vFileName = substr($vFileNameFull, 0, 20).$vExt;
		}
		else{
			$vFileName = $vFileNameFull;
		}
		$vCurrentBlobPath = $vRequest->getParameter('current_poster_path');

		if(!empty($vCurrentBlobPath) && !empty($vFileName)){
			if(!empty($vFileName)){
				$dir = "../images/posters/".substr($vCurrentBlobPath,0,14);
				foreach(glob($dir . '*.*') as $v) {
					unlink($v);
				}
				rmdir($dir);
			}
		}
		if(!empty($vFileName)){
			$vTempFolder = $_FILES['poster_path']["tmp_name"];
			$vDirectory = "../images/posters/";
			$vUnique = uniqid() . "/";
			$vUniqueDirectory = $vDirectory . $vUnique;
			if(!is_dir($vUniqueDirectory)) {
				mkdir($vUniqueDirectory, 0777);
			}
			$vData['poster_path'] = $vUnique.preg_replace('/\s+/', '', $vFileName);
			move_uploaded_file($vTempFolder, $vUniqueDirectory.preg_replace('/\s+/', '', $vFileName));
		}
		if(!empty($_FILES['photos']['name'])){
			$vDirectory = "../images/events/";
			$vUnique = uniqid() . "/";
			$vUniqueDirectory = $vDirectory . $vUnique;
			if(!is_dir($vUniqueDirectory)) {
				mkdir($vUniqueDirectory, 0777);
			}
		    foreach ($_FILES['photos']['name'] as $i => $name) {
		        if (strlen($_FILES['photos']['name'][$i]) > 1) {
					$vDataPhotos['event_id'] = $vId;
					$vDataPhotos['blob_path'] = $vUnique.preg_replace('/\s+/', '', $name);
					move_uploaded_file($_FILES['photos']['tmp_name'][$i], $vUniqueDirectory.preg_replace('/\s+/', '', $name));
					$vQueryResultImages = MysqlQuery::doInsert($conn, 'event_images', $vDataPhotos);
		        }
		    }
		}
		$vQueryResult = MysqlQuery::doUpdate($conn, 'events', $vData, "id = ".$vId);

		if ($vQueryResult == 1 && $vQueryResultImages >= 1){
			unset($_SESSION['SessionGrafCmsMessage']);
			$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"success-message\"><i class=\"fa fa-check fa-lg space-right green\" aria-hidden=\"true\"></i>Die funksie is verander.</h4>";
		}
		else if ($vQueryResult == 0){
			unset($_SESSION['SessionGrafCmsMessage']);
			$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"error-message\"><i class=\"fa fa-times fa-lg space-right red\" aria-hidden=\"true\"></i>Die funksie is nie verander nie. Probeer asseblief weer of kontak die Webmaster.</h4>";
		}
	}
	$vUrl = "index.php?page=events&type=future";
	General::echoRedirect($vUrl, "");
}
else if($vType == "delete-photo"){
    $vQueryResult = 0;
	$vId = $vRequest->getParameter('id');
	$vBlobPath = $vRequest->getParameter('path');
	$vEventId = $vRequest->getParameter('event-id');

	if(!empty($vBlobPath)){
		$dir = "../images/events/".substr($vBlobPath,0,14);
		unlink("../images/events/".$vBlobPath);
		if (count(glob($dir."/*")) === 0 ) {
			rmdir($dir);
		}
	}
	$vQueryResult = MysqlQuery::doDelete($conn, "event_images", "id = ".$vId);
	if ($vQueryResult == 1){//success
		unset($_SESSION['SessionGrafCmsMessage']);
		$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"success-message\"><i class=\"fa fa-check fa-lg space-right green\" aria-hidden=\"true\"></i>Die foto is uitgevee!</h4>";
	}
	else if ($vQueryResult == 0){//error
		unset($_SESSION['SessionGrafCmsMessage']);
		$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"error-message\"><i class=\"fa fa-times fa-lg space-right red\" aria-hidden=\"true\"></i>Die foto is nie uitgevee nie! Probeer asseblief weer of kontak die Webmaster.</h4>";
	}
	($vRequest->getParameter('return') == "photo" ? $vReturn = "edit-photos" : $vReturn = "edit");
	$vUrl = "index.php?page=events&type=".$vReturn."&id=".$vEventId;
	General::echoRedirect($vUrl, "");
}
else if($vType == "delete-poster"){
    $vQueryResult = 0;
	$vId = $vRequest->getParameter('id');
	$vBlobPath = $vRequest->getParameter('path');
	$vData['poster_path'] = "";

	if(!empty($vBlobPath)){
		$dir = "../images/posters/".substr($vBlobPath,0,14);
		unlink("../images/posters/".$vBlobPath);
		if (count(glob($dir."/*")) === 0 ) {
			rmdir($dir);
		}
	}
	$vQueryResult = MysqlQuery::doUpdate($conn, "events", $vData, "id = ".$vId);
	if ($vQueryResult == 1){//success
		unset($_SESSION['SessionGrafCmsMessage']);
		$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"success-message\"><i class=\"fa fa-check fa-lg space-right green\" aria-hidden=\"true\"></i>Die advertensie is uitgevee!</h4>";
	}
	else if ($vQueryResult == 0){//error
		unset($_SESSION['SessionGrafCmsMessage']);
		$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"error-message\"><i class=\"fa fa-times fa-lg space-right red\" aria-hidden=\"true\"></i>Die advertensie is nie uitgevee nie! Probeer asseblief weer of kontak die Webmaster.</h4>";
	}
	$vUrl = "index.php?page=events&type=edit&id=".$vId;
	General::echoRedirect($vUrl, "");
}
else if($vType == "edit-photos-sql"){
	    $vQueryResult = 0;
	    unset($_SESSION['SessionGrafCmsMessage']);
	    $_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"success-message\"><i class=\"fa fa-check fa-lg space-right green\" aria-hidden=\"true\"></i>Die beskrywings is gelaai!</h4>";
	    $vTitle = $vRequest->getParameter('title');
	    $vId = $vRequest->getParameter('id');
	    $vIdArray = explode(",", $vRequest->getParameter('photo_id_array'));
	    foreach($vIdArray as $image_id) {
	    	$vData['description'] = General::prepareStringForQuery($vRequest->getParameter('description_'.$image_id));
		  	$vQueryResult = MysqlQuery::doUpdate($conn, "event_images", $vData, "id = ".$image_id);
		    if ($vQueryResult == 0){//error
				unset($_SESSION['SessionGrafCmsMessage']);
				$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"error-message\"><i class=\"fa fa-times fa-lg space-right red\" aria-hidden=\"true\"></i>Die beskrywings is nie gelaai nie! Probeer asseblief weer of kontak die Webmaster.</h4>";
			}
	    }
		$vUrl = "index.php?page=events&type=edit-photos&id=".$vId."&title=".$vTitle;
		General::echoRedirect($vUrl, "");
}
include "../include/connect/CloseConnect.php";
