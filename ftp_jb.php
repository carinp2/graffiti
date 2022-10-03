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
$ftp_server = "ftp://ftp2.nasftp.com";
$ftp_user = "graffiti";
$ftp_pass = "GrafBooks";

$GLOBALS['conn_id'] = ftp_connect($ftp_server) or die("Couldn't connect to $ftp_server");
$GLOBALS['a'] = 0;
$GLOBALS['date_min_one_month'] = date("Y-m-d", strtotime('-1 month'));
$GLOBALS['date_day'] = date("dd");
$GLOBALS['date_month'] = date("mm");
$GLOBALS['date_year'] = date("Y");

function get_file($strDir) {
	$contents = ftp_nlist($GLOBALS['conn_id'], $strDir);
	for($i=0; $i<count($contents); $i++) {
		if (strstr($contents[$i], ".") !== FALSE) {
			if (ftp_get($GLOBALS['conn_id'], "ftp_jb/".$contents[$i], $contents[$i], FTP_ASCII)) {
				echo "Successfully written to ".$contents[$i]."<br>";
			} else {
				echo "There was a problem ".$contents[$i]."<br>";
			}
		}
		else {
			//mkdir(substr($contents[$i],1),0777,true);
			//$a = get_file($contents[$i]);
		}
	}
	return 1;
}

if (ftp_login($GLOBALS['conn_id'], $ftp_user, $ftp_pass)) {
	$contents = ftp_nlist($GLOBALS['conn_id'], "/"); //OUT removed
	for($i=0; $i<count($contents); $i++) {
		if($contents[$i] == 'JB'.$GLOBALS['date_month'].$GLOBALS['date_day'].$GLOBALS['date_year'].'.txt'){
			$GLOBALS['a'] = get_file($contents[$i]);
		}
	}
}

 if($GLOBALS['a'] == 1){
//     $vData["out_of_print"] = 1;
//     $vData['edit_by'] = 999;// 999 = Cronjob
//  	$vQueryResult = $vQuery->doUpdate($conn, "books", $vData, "publisher = 5000 AND in_stock = 0 AND date_publish <= '".$GLOBALS['date_min_one_month']."'");

// 	//############################################################################ NB Uitgewers
// 	$txt_file = file_get_contents('ftp_jb/JBPStock.csv');
// 	$rows = explode("\n", $txt_file);
// 	//array_shift($rows);
// 	$vTotalRows = 0;
// 	$vInStock = 0;

 	foreach($rows as $row => $data){
  	    $row_data = explode('","', $data);
  	    $vIsbn = str_replace('"', '', $row_data[0]);
  	    $vPrice = $row_data[5];
  	    $vNumberInStock = str_replace('"', '', $row_data[8]);

  		if($vNumberInStock > 0){
  			echo "In stock Isbn: ".$vIsbn." - Price: ".$vPrice." - Stock: ".$vNumberInStock."<br>";
//  			$vDataIP["out_of_print"] = 0;
//  			$vDataIP['edit_by'] = 999;
//  			$vDataIP['price'] = $vPrice;
//  			$vQueryResult = $vQuery->doUpdate($conn, "books", $vDataIP, "isbn = '".$vIsbn."' and publisher = 5000");
//  			//echo $vTotalRowsNB.". ISBN: ".$vIsbn." - Result: ".$vQueryResult."<br><br>";
//  			//echo "<br>isbn: ".$vIsbn." - no in stock: ".$vNumberInStock." - Result: ".$vQueryResult;
//  			$vInStock++;
  		}
  		else {
  			echo "Nie in stock Isbn: ".$vIsbn." - Price: ".$vPrice." - Stock: ".$vNumberInStock."<br>";
  		}
//  		$vTotalRows++;
 	}
//  	echo "\nJB uitgewers gedoen. Boeke in file: ".$vTotalRows."\n";
// 	echo "\nDatum vir boeke 'uit voorraad' gemerk: ".$GLOBALS['date_min_one_month']."\n";
// 	echo "\nNo veranderinge na 'in stock': ".$vInStock."\n";
 }
