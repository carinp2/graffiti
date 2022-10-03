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

if($vType == "get_sub_cat"){
	//type: edit, book_id: vBookId, price: vPrice, special: vSpecial, special_price: vSpecial_price, bnew: vNew, topseller: vTopseller, topseller_rank: vTopseller_rank, out_print: vOut_print, in_stock: vInstock, publisher: vPublisher
    $vQueryResult = 0;
    $vCategory =  $vRequest->getParameter('category');
    $vId = $_POST['book_id'];
		$vResult = MysqlQuery::getAllSubCategoriesPerCategory($conn, $vCategory, 1);
		$vString = "<option value=\"\">Kies 'n waarde</option>";
		for($x = 0; $x < count($vResult[0]); $x++){
		 	$vString .= "<option value=\"".$vResult[0][$x]."\">".$vResult[1][$x]."</option>";
		}
		echo $vString;
		 exit;
}

include "../include/connect/CloseConnect.php";
