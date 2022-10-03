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
require_once ("application/classes/Parts.class.php");
$vParts = new Parts();
require_once ("application/classes/Pages.class.php");
$vPages = new Pages();

$vData1['default_discount'] = 0.1;
$vResult1 = $vQuery->doUpdate($conn, "books", $vData1, "id > 0 AND rr <> 1");

$vMonthDate = date("Y-m-d", strtotime('-2 month'));
$vDateNow = $_SESSION['date_now'];
$vData['default_discount'] = 0.1;
$vResult2 = $vQuery->doUpdate($conn, "books", $vData, " section = 1 AND (category = 6 or category = 7) or (date_publish <= '".$vMonthDate."' and (top_seller = 0 or top_seller is null)) AND rr <> 1");

if($vResult1 == 1 && $vResult2 == 1){
	if($vResult1 == 1){
		echo "SUKSES - Default discount 20%!\n\r";
	}
	if($vResult2 == 1){
		echo "SUKSES - Default discount 10% vir alles ouer as 2 maande en topseller = 0!\n\r";
	}
}
else {
		echo "FOUT - Default discount fout!\n\r";
}

$vDataOld['new'] = 0;
$vDataOld['new_rank'] = 0;
$vResult3 = $vQuery->doUpdate($conn, "books", $vDataOld, "date_publish < '".$vMonthDate."' AND section = 1 AND rr <> 1");

$vDataNew['new'] = 1;
$vDataNew['new_rank'] = 7;
$vResult4 = $vQuery->doUpdate($conn, "books", $vDataNew, "(date_publish >= '".$vMonthDate."' AND date_publish < '".$vDateNow."') AND (new_rank < 1 OR new_rank > 6) AND section = 1 AND rr <> 1");

if($vResult3 == 1 && $vResult4 == 1){
	if($vResult3 == 1){
		echo "SUKSES - Alle boeke ouer as vandag -2 maande nie meer NUUT nie: new = 0 and new_rank = 0\n\r";
	}
	if($vResult4 == 1){
		echo "SUKSES - Alle boeke met pub_date vandag -2 maand en nuwer is NUUT: new = 1 and rank = 7\n\r";
	}
}
else {
		echo "FOUT - met NUUT!\n\r";
}

//Binnekort
$vDataSoonReset['soon'] = 0;
$vDataSoonReset['soon_rank'] = 0;
$vDataSoonReset['soon_discount'] = 0;
$vResult6 = $vQuery->doUpdate($conn, "books", $vDataSoonReset, "date_publish <= '".$vDateNow."' AND section = 1 AND rr <> 1");

$vDataSoon['soon'] = 1;
$vDataSoon['soon_rank'] = 7;
$vDataSoon['soon_discount'] = 1;
$vResult5 = $vQuery->doUpdate($conn, "books", $vDataSoon, "date_publish > '".$vDateNow."' AND (soon_rank < 1 OR soon_rank > 6) AND section = 1 AND rr <> 1");

if($vResult5 == 1){
	echo "SUKSES - Alle boeke met pub_date > as vandag SOON = 1, SOON_DISCOUNT = 1, SOON_RANK = 7\n\r";
}
else {
		echo "FOUT - met SOON!\n\r";
}

//Rooirose
//$vDataRr['rr'] = 0;
//$vDataRr['default_discount'] = 0.1;
//$vResult7 = $vQuery->doUpdate($conn, "books", $vDataRr, "rr = 1 AND rr_date <= '".$vMonthDate."'");

// if($vResult7 == 1){
// 	echo "SUKSES - Rooi rose boeke met rr_date < as ".$vMonthDate." is nie meer aktief nie.\n\r";
// }
// else {
// 		echo "FOUT - met Rooi rose!\n\r";
// }
