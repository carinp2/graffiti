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

if($vType == "add-newsletter"){
	$vQueryResult = 0;
	$vBlobPath =  $_FILES['newsletter_blob_path']["name"];
		if(!empty($vBlobPath)){
			$vTempFolder = $_FILES['newsletter_blob_path']["tmp_name"];
			$vDirectory = "../documents/newsletters/";
			$vUniqueDirectory = $vDirectory ;
			if(!is_dir($vUniqueDirectory)) {
				mkdir($vUniqueDirectory, 0777);
			}
			$vData['newsletter_blob_path'] = preg_replace('/\s+/', '', $vBlobPath);
			if(file_exists($vUniqueDirectory.preg_replace('/\s+/', '', $vBlobPath)) == 1){
				$vDouble = 1;
				unset($_SESSION['SessionGrafCmsMessage']);
				$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"error-message\"><i class=\"fa fa-times fa-lg space-right red\" aria-hidden=\"true\"></i>'n Nuusbrief met dieselfde naam bestaan reeds. Verander die nuwe l&#234;ernaam of kies 'n ander l&#234;er.</h4>";
			}
			else {
				$vDouble = 0;
				$vQueryResult = move_uploaded_file($vTempFolder, $vUniqueDirectory.preg_replace('/\s+/', '', $vBlobPath));
			}
		}
	if ($vQueryResult == TRUE && $vDouble == 0){//success && no double
		unset($_SESSION['SessionGrafCmsMessage']);
		$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"success-message\"><i class=\"fa fa-check fa-lg space-right green\" aria-hidden=\"true\"></i>Die nuusbrief is gelaai.</h4>";
	}
	else if ($vQueryResult == 0 && $vDouble == 1){//success && double
		unset($_SESSION['SessionGrafCmsMessage']);
		$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"error-message\"><i class=\"fa fa-times fa-lg space-right red\" aria-hidden=\"true\"></i>'n Nuusbrief met dieselfde naam bestaan reeds. Verander die nuwe l&#234;ernaam of kies 'n ander l&#234;er.</h4>";
	}
	else if ($vQueryResult == FALSE &&  $vDouble == 0){//error && no double
		unset($_SESSION['SessionGrafCmsMessage']);
		$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"error-message\"><i class=\"fa fa-times fa-lg space-right red\" aria-hidden=\"true\"></i>Die nuusbrief is nie gelaai nie. Probeer asseblief weer of kontak die Webmaster.</h4>";
	}
	$vUrl = "index.php?page=newsletters&type=list";
	//error_log("Oplaai: ".$vQueryResult."    &&  Double:".$vDouble, 0, "C:/Temp/php_errors.log");
	General::echoRedirect($vUrl, "");
}

include "../include/connect/CloseConnect.php";
