<?php

/**
 * @author Carin Pretorius - CEIT Development
 * Created on 2018-02-07
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
require_once ("application/classes/CmsModal.class.php");
$vCmsModal= new CmsModal();

include "../application/config/session_config.php";
include "../include/connect/Connect.php";
include "application/config/session_cms_config.php";
$ftp_server = "ftp.christnet.co.za";
$ftp_user = "graffiti_books";
$ftp_pass = "active771";

$conn_id = ftp_connect($ftp_server) or die("Couldn't connect to $ftp_server");
$a = 0;

function get_file($strDir) {
	global $conn_id;
	$contents = ftp_nlist($conn_id, $strDir);
	for($i=0; $i<count($contents); $i++) {
		if (strstr($contents[$i], ".") !== FALSE) {
			if (ftp_get($conn_id, "ftp_struik/".$contents[$i], $contents[$i], FTP_ASCII)) {
				echo "Successfully written to ".$contents[$i]."<br>";
			} else {
				echo "There was a problem ".$contents[$i]."<br>";
			}

		}
		else {
			//mkdir(substr($contents[$i],1),0777,true);
			$a = get_file($contents[$i]);
		}
	}
	return 1;
}

if (ftp_login($conn_id, $ftp_user, $ftp_pass)) {
	$contents = ftp_nlist($conn_id, ".");
	for($i=0; $i<count($contents); $i++) {
		$a = get_file("/". $contents[$i]);
	}
}

if($a == 1){
	$txt_file = file_get_contents('ftp_struik/stocksheet.txt');
	$rows = explode("\n", $txt_file);
	array_shift($rows);
	$vTotalRows = 0;
	$vInStock = 0;

    $vData["out_of_print"] = 1;
//    $vData['edit_by'] = 9999;// 999 = Cronjob
    $vQueryResult = $vQuery->doUpdate($conn, "books", $vData, "(publisher = 1200 or publisher = 2500) AND in_stock = 0 and date_publish <= '".$_SESSION['now_date']."'");

	foreach($rows as $row => $data){
	    $row_data = explode('|', $data);
	    $vIsbn = trim($row_data[1]);
	    $vPublisherString = trim(substr($row_data[10], 0, 3));
	    ($vPublisherString == "SCM" ? $vPublisherId = 1200 : $vPublisherId = 2500);
		if(trim($row_data[7]) == "YES"){
			$vIsbn = trim($row_data[1]);
			$vDataIP["out_of_print"] = 0;
//			$vDataIP['edit_by'] = 9991;

			$vQueryResult = $vQuery->doUpdate($conn, "books", $vDataIP, "isbn = '".$vIsbn."' and publisher = ".$vPublisherId);
			$vInStock++;
		}
		$vTotalRows++;
	}
	echo "<br>Struik gedoen. Boeke in file: ".$vTotalRows."<br>";
	echo "<br>No veranderinge na 'in stock': ".$vInStock."<br>";
}
