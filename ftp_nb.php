<?php

/**
 * @author Carin Pretorius - CEIT Development
 * Created on 2018-02-07
 */

session_start();
require_once ("application/classes/General.class.php");
$vGeneral = new General();
require_once ("cms/application/classes/CmsParts.class.php");
$vCmsParts = new CmsParts();
require_once ("application/classes/MysqlQuery.class.php");
$vQuery = new MysqlQuery();
require_once ("application/classes/RequestUtils.class.php");
$vRequest = new RequestUtils();
require_once ("application/classes/StringUtils.class.php");
$vString = new StringUtils();
require_once ("cms/application/classes/CmsModal.class.php");
$vCmsModal= new CmsModal();

include "application/config/session_config.php";
include "include/connect/Connect.php";
include "cms/application/config/session_cms_config.php";
$ftp_server = "ftp2.nasftp.com";
$ftp_user = "NBStock";
$ftp_pass = "NBStock.123";

$GLOBALS['conn_id'] = ftp_connect($ftp_server) or die("Couldn't connect to $ftp_server");
$GLOBALS['a'] = 0;
$GLOBALS['vYesterdayDate'] = date("d-m-Y", strtotime('-1 day'));
$GLOBALS['date_min_one_month'] = date("Y-m-d", strtotime('-1 month'));

function get_file($strDir) {
	$contents = ftp_nlist($GLOBALS['conn_id'], $strDir);
	for($i=0; $i<count($contents); $i++) {
		if (strstr($contents[$i], ".") !== FALSE && ($contents[$i] == 'NBStockFile_'.$GLOBALS['vYesterdayDate'].'.csv' || $contents[$i] == 'VSStockFile_'.$GLOBALS['vYesterdayDate'].'.csv' || $contents[$i] == 'VAStockFile_'.$GLOBALS['vYesterdayDate'].'.csv')) {//NBStockFile_20-03-2018.csv
			if (ftp_get($GLOBALS['conn_id'], "ftp_nb/".$contents[$i], $contents[$i], FTP_ASCII)) {
				echo "Successfully written to ".$contents[$i]."<br><br>";
			} else {
				echo "There was a problem ".$contents[$i]."<br><br>";
			}
		}
		else {
			//mkdir(substr($contents[$i],1),0777,true);
			//$a = get_file($contents[$i]);
			//echo "No - ".$contents[$i];
		}
	}
	return 1;
}

if (ftp_login($GLOBALS['conn_id'], $ftp_user, $ftp_pass)) {
	$contents = ftp_nlist($GLOBALS['conn_id'], ".");
	for($i=0; $i<count($contents); $i++) {
		if($contents[$i] == 'NBStockFile_'.$GLOBALS['vYesterdayDate'].'.csv' || $contents[$i] == 'VSStockFile_'.$GLOBALS['vYesterdayDate'].'.csv' || $contents[$i] == 'VAStockFile_'.$GLOBALS['vYesterdayDate'].'.csv'){
			$GLOBALS['a'] = get_file($contents[$i]);
		}
	}
}

if($GLOBALS['a'] == 1){
    $vData["out_of_print"] = 1;
    $vData['edit_by'] = 99991;// 999 = Cronjob
 	$vQueryResult = $vQuery->doUpdate($conn, "books", $vData, "publisher = 2300 AND in_stock = 0 AND date_publish <= '".$GLOBALS['date_min_one_month']."'");

	//############################################################################ NB Uitgewers
	$txt_file = file_get_contents('ftp_nb/NBStockFile_'.$GLOBALS['vYesterdayDate'].'.csv');
	$rows = explode("\n", $txt_file);
	//array_shift($rows);
	$vTotalRowsNB = 0;
	$vInStock = 0;

	foreach($rows as $row => $data){
 	    $row_data = explode('","', $data);
 	    $vIsbn = str_replace('"', '', $row_data[0]);
 	    $vPrice = $row_data[6];
 	    $vNumberInStock = str_replace('"', '', $row_data[8]);
// 	    $vPublisher = str_replace('"', '', $row_data[5]);
// 	    ($vPublisher == "00NB" ? $vPublisherId = 2300 : $vPublisher == "00VS" ? $vPublisherId = 627 : $vPublisherId = 2452);
 	    //echo $vTotalRowsNB.". No in stock: ".$vNumberInStock." (".$row_data[9].")<br>";

 		if($vNumberInStock > 0){
 			$vDataIP["out_of_print"] = 0;
 			$vDataIP['edit_by'] = 9991;
 			$vDataIP['price'] = $vPrice;
 			$vQueryResult = $vQuery->doUpdate($conn, "books", $vDataIP, "isbn = '".$vIsbn."' and publisher = 2300");
 			//echo $vTotalRowsNB.". ISBN: ".$vIsbn." - Result: ".$vQueryResult."<br><br>";
 			//echo "<br>isbn: ".$vIsbn." - no in stock: ".$vNumberInStock." - Result: ".$vQueryResult;
 			$vInStock++;
 		}
 		$vTotalRowsNB++;
	}
 	echo "\nNB uitgewers gedoen. Boeke in file: ".$vTotalRowsNB."\n";

 	// ############################################################################ Van Schaik

    $vData["out_of_print"] = 1;
    $vData['edit_by'] = 9991;// 999 = Cronjob
 	$vQueryResult = $vQuery->doUpdate($conn, "books", $vData, "publisher = 627 AND in_stock = 0 AND date_publish <= '".$GLOBALS['date_min_one_month']."'");

	$txt_file = file_get_contents('ftp_nb/VSStockFile_'.$GLOBALS['vYesterdayDate'].'.csv');
	$rows = explode("\n", $txt_file);
	//array_shift($rows);
 	$vTotalRowsVS = 0;

	foreach($rows as $row => $data){
 	    $row_data = explode('","', $data);
 	    $vIsbn = str_replace('"', '', $row_data[0]);
 	    $vPrice = $row_data[7];
 	    $vNumberInStock = str_replace('"', '', $row_data[8]);
// 	    $vPublisher = str_replace('"', '', $row_data[5]);
// 	    ($vPublisher == "00NB" ? $vPublisherId = 2300 : $vPublisher == "00VS" ? $vPublisherId = 627 : $vPublisherId = 2452);
 	    //echo $vTotalRowsNB.". No in stock: ".$vNumberInStock." (".$row_data[9].")<br>";

 		if($vNumberInStock > 0){
 			$vDataIP["out_of_print"] = 0;
 			$vDataIP['edit_by'] = 9991;
 			$vDataIP['price'] = round($vPrice);
 			$vQueryResult = $vQuery->doUpdate($conn, "books", $vDataIP, "isbn = '".$vIsbn."' and publisher = 627");
 			//echo $vTotalRowsNB.". ISBN: ".$vIsbn." - Result: ".$vQueryResult."<br><br>";
 			//echo "<br>isbn: ".$vIsbn." - no in stock: ".$vNumberInStock." - Result: ".$vQueryResult." - Price: ".$vDataIP['price'];
 			$vInStock++;
 		}
 		$vTotalRowsVS++;
	}
	echo "\nVan Schaik gedoen. Boeke in file: ".$vTotalRowsVS."\n";

 	// ############################################################################ Via Afrika
    $vData["out_of_print"] = 1;
    $vData['edit_by'] = 99993;// 999 = Cronjob
 	$vQueryResult = $vQuery->doUpdate($conn, "books", $vData, "publisher = 2452 AND in_stock = 0 AND date_publish <= '".$GLOBALS['date_min_one_month']."'");

	$txt_file = file_get_contents('ftp_nb/VAStockFile_'.$GLOBALS['vYesterdayDate'].'.csv');
	$rows = explode("\n", $txt_file);
	//array_shift($rows);
 	$vTotalRowsVA = 0;

	foreach($rows as $row => $data){
 	    //get row data
 	    $row_data = explode('","', $data);
 	    $vIsbn = str_replace('"', '', $row_data[0]);
 	    $vPrice = $row_data[7];
 	    $vNumberInStock = str_replace('"', '', $row_data[8]);
 	    $vPublisher = str_replace('"', '', $row_data[5]);
 	    ($vPublisher == "00NB" ? $vPublisherId = 2300 : $vPublisher == "00VS" ? $vPublisherId = 627 : $vPublisherId = 2452);
 	    //echo $vTotalRowsNB.". No in stock: ".$vNumberInStock."<br>";

 		if($vNumberInStock > 0){
 			$vDataIP["out_of_print"] = 0;
 			$vDataIP['edit_by'] = 9991;
 			$vDataIP['price'] = round($vPrice);
 			$vQueryResult = $vQuery->doUpdate($conn, "books", $vDataIP, "isbn = '".$vIsbn."' and publisher = 2452");
 			//echo $vTotalRowsNB.". ISBN: ".$vIsbn." - Result: ".$vQueryResult."<br><br>";
 			//echo "<br>isbn: ".$vIsbn." - no in stock: ".$vNumberInStock." - Result: ".$vQueryResult;
 			$vInStock++;
 		}
 		$vTotalRowsVA++;
	}
	echo "\nVia Afrika gedoen: Boeke in file: ".$vTotalRowsVA."\n\n";
	echo "\nDatum vir boeke 'uit voorraad' gemerk: ".$GLOBALS['date_min_one_month']."\n";
	echo "\nFile geupload: ".$GLOBALS['vYesterdayDate']."\n";
	echo "\nAantal veranderinge na 'in stock': ".$vInStock."\n";
}
