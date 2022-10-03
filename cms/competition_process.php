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

$vType =  $_REQUEST['type'];
$vId = $_REQUEST['id'];

if($vType == "delete"){
//    $vQueryResult = 0;
//	$vId = RequestUtils::getParameter("id");
//
//	$vBlobPath = MysqlQuery::getBlobPath($conn, $vId, "events");
//	if(!empty($vBlobPath)){
//		$dir = "../images/posters/".substr($vBlobPath,0,14);
//		foreach(glob($dir . '*.*') as $v) {
//			unlink($v);
//		}
//		rmdir($dir);
//	}
//
//	$vQueryResult = MysqlQuery::doDelete($conn, 'events', "id = ".$vId);
//	if ($vQueryResult == 1){
//		unset($_SESSION['SessionGrafCmsMessage']);
//		$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"success-message\"><i class=\"fa fa-check fa-lg space-right green\" aria-hidden=\"true\"></i>Die funksie en advertensies is uitgevee.</h4>";
//	}
//	else if ($vQueryResult == 0){
//		unset($_SESSION['SessionGrafCmsMessage']);
//		$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"error-message\"><i class=\"fa fa-times fa-lg space-right red\" aria-hidden=\"true\"></i>Die funksie is nie uitgevee nie. Probeer asseblief weer of kontak die Webmaster.</h4>";
//	}
//	$vUrl = "index.php?page=events&type=future&id=0";
//	General::echoRedirect($vUrl, "");
}
else if($vType == "add" || $vType == "edit"){
    $vQueryResult = 0;

	if($vType == "add"){
        $vData['name'] = filter_var($_REQUEST['name0'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $vData['description'] = filter_var($_REQUEST['description0'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $vData['date_end'] = $_REQUEST['date_end0'];
        $vBlobPath =  $_FILES['blob_path0']["name"];
        $vData['valid'] = $_REQUEST['valid0'];

		if(!empty($vBlobPath)){
            $vFileNameFull = $_FILES['blob_path0']["name"];
            if(strlen($vFileNameFull) > 40){
                $vExt = substr($vFileNameFull, strpos($vFileNameFull, "."));
                $vFileName = substr($vFileNameFull, 0, 20).$vExt;
            }
            else{
                $vFileName = $vFileNameFull;
            }
			$vTempFolder = $_FILES['blob_path0']["tmp_name"];
			$vDirectory = "../images/competitions/";
			$vUnique = uniqid() . "/";
			$vUniqueDirectory = $vDirectory . $vUnique;
			if(!is_dir($vUniqueDirectory)) {
				mkdir($vUniqueDirectory, 0777);
			}
			move_uploaded_file($vTempFolder, $vUniqueDirectory.preg_replace('/\s+/', '', $vFileName));
            $vData['blob_path'] = $vUnique.preg_replace('/\s+/', '', $vFileName);
		}

		$vQueryResult = MysqlQuery::doInsert($conn, 'competitions', $vData);

		if ($vQueryResult > 1){
			unset($_SESSION['SessionGrafCmsMessage']);
			$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"success-message\"><i class=\"fa fa-check fa-lg space-right green\" aria-hidden=\"true\"></i>Die kompetisie is gelaai.</h4>";
            echo 1;
		}
		else if ($vQueryResult == 0){
			unset($_SESSION['SessionGrafCmsMessage']);
			$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"error-message\"><i class=\"fa fa-times fa-lg space-right red\" aria-hidden=\"true\"></i>Die kompetisie is nie gelaai nie. Probeer asseblief weer of kontak die Webmaster.</h4>";
            echo 0;
		}
        $vUrl = "index.php?page=competitions&type=list_1";
        General::echoRedirect($vUrl, "");
	}
	if($vType == "edit"){
        $vData['name'] = filter_var($_REQUEST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $vData['description'] = filter_var($_REQUEST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $vData['date_end'] = $_REQUEST['date_end'];
        $vData['winner'] = filter_var($_REQUEST['winner'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $vData['valid'] = filter_var($_REQUEST['valid'], FILTER_SANITIZE_NUMBER_INT);
		$vQueryResult = MysqlQuery::doUpdate($conn, 'competitions', $vData, "id = ".$vId);

		if ($vQueryResult == 1){
			unset($_SESSION['SessionGrafCmsMessage']);
			$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"success-message\"><i class=\"fa fa-check fa-lg space-right green\" aria-hidden=\"true\"></i>Die kompetisie is verander.</h4>";
            echo 1;
		}
		else if ($vQueryResult == 0){
			unset($_SESSION['SessionGrafCmsMessage']);
			$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"error-message\"><i class=\"fa fa-times fa-lg space-right red\" aria-hidden=\"true\"></i>Die kompetisie is nie verander nie. Probeer asseblief weer of kontak die Webmaster.</h4>";
            echo 0;
		}
	}


}

include "../include/connect/CloseConnect.php";
