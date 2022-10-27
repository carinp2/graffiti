<?php
/**
 * @author Carin Pretorius - CEIT Development
 * Created on 2016-11_02
 */

session_start();
//session_cache_limiter( 'nocache' );
require_once ("application/classes/General.class.php");
$vGeneral = new General();

//include "application/config/session_config.php";
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

$vType =  $vRequest->getParameter('type');

if($vType == "update-cart" || $vType == "update-cart-on-checkout"){
	if((isset($_SESSION['SessionGrafUserId']) && $_SESSION['SessionGrafUserId'] > 0) || (!isset($_SESSION['SessionGrafUserId']) && isset($_SESSION['SessionGrafUserSessionId']))){
        $vTempClientId = (isset($_SESSION['SessionGrafUserId']) ? $_SESSION['SessionGrafUserId'] : $_SESSION['SessionGrafUserSessionId']);
        $vData['client_id'] = $vTempClientId;
        $vData['book_id'] = $_POST['book_id'];
        $vData['add_date'] = $_SESSION['now_date'];
        $vData['temp_salt'] = General::createSalt(15);
        $vExistsNumber = $vQuery->checkBookExistsCart($conn, "client_id = '".$vTempClientId."' and book_id = ".$_POST['book_id']." and order_date is NULL and order_reference is NULL and order_id is NULL");
        if($vExistsNumber > 0){
            ($vType == "update-cart-on-checkout" ? $vNumber = $_POST['book_number'] : $vNumber = $vExistsNumber+1);
            $vOrder = "";
            $vBindParams = array();
            $vBindLetters = "ii";
            $vBindParams[] =& $vData['client_id'];
            $vBindParams[] =& $_POST['book_id'];
            $vLimit = "";
            $vWhere = "WHERE client_id = ? and book_id = ? and order_date is NULL and order_reference is NULL and order_id is NULL";
            if($vNumber > 0){
                $vQueryResult = $vQuery->updateCart($conn, $vWhere, $vBindLetters,  $vBindParams, $vNumber);//1 = Success | 0 = Error
            }
            else {
                $vQueryResult = $vQuery->doDelete($conn,  'cart', "client_id = ".$vData['client_id']." and book_id = ".$_POST['book_id']." and order_date is NULL and order_reference is NULL and order_id is NULL");//1 = Success | 0 = Error
            }
        }
        else {
            $vData['number'] = 1;
            $vQueryResult = $vQuery->doInsert($conn, 'cart', $vData);//>1 = Success | 0 = Error
        }
		if ($vQueryResult > 0){
			$vResult =  1;
		}
		else {
			$vResult =0;
		}
	}
	else {
		$vResult = 0;
	}
	//error_log("RESULT: ".$vResult, 0, "C:/Temp/php_errors.log");
	echo $vResult;
}
else if($vType == "delete-book"){
	$vId = $_POST['temp_cart_id'];

	$vQueryResult = $vQuery->doDelete($conn, 'cart', "id = ".$vId);
	if ($vQueryResult > 0){
		echo "success";
	}
	else {
		echo "error";
	}
}
else if($vType == "delete-wish-book"){
	$vId = $_POST['wish_id'];
	$vQueryResult = $vQuery->doDelete($conn, 'wishlist', "id = ".$vId);
	if ($vQueryResult > 0){
		echo "success";
	}
	else {
		echo "error";
	}
}
else if($vType == "move-book"){
	$vCartId = $_POST['temp_cart_id'];
	$vData['book_id'] = $_POST['book_id'];
	($_SESSION['SessionGrafUserId'] == $_COOKIE['cookie_graf_ui'] ? $vData['client_id'] = $_SESSION['SessionGrafUserId'] : $vData['client_id'] = 0);
	if($vData['client_id'] > 0){
		$vExists= MysqlQuery::checkExists($conn, "wishlist", "id", "client_id = ".$vData['client_id']." and book_id = ".$vData['book_id']);
		if($vExists > 0){
			$vQueryResult = MysqlQuery::doDelete($conn, 'cart', "id = ".$vCartId);
		}
		else {
			$vQueryResult = MysqlQuery::doInsert($conn, 'wishlist', $vData);
			$vQueryResult = MysqlQuery::doDelete($conn, 'cart', "id = ".$vCartId);
		}
		if ($vQueryResult > 0){
			echo "success";
		}
		else {
			echo "error";
		}
	}
	else {
		echo "error";
	}
}
else if($vType == "add-wishlist-book"){
	$vData['book_id'] = $_POST['book_id'];
	($_SESSION['SessionGrafUserId'] == $_COOKIE['cookie_graf_ui'] ? $vData['client_id'] = $_SESSION['SessionGrafUserId'] : $vData['client_id'] = 0);
	if($vData['client_id'] > 0){
		//error_log("Binne client_id > 0. Client id = : ".$vData['client_id'], 0, "C:/Temp/php_errors.log");
		$vExists= MysqlQuery::checkExists($conn, "wishlist", "id", "client_id = ".$vData['client_id']." and book_id = ".$vData['book_id']);
		if($vExists > 0){
			echo "double";
			return false;
		}
		else {
			$vQueryResult = MysqlQuery::doInsert($conn, 'wishlist', $vData);
		}
		if ($vQueryResult > 0){
			echo "success";
		}
		else {
			echo "error";
		}
	}
	else {
		echo "error";
	}
}
else if($vType == "add-order"){
	$vPage = MysqlQuery::getText($conn, 283);//BestelNouKoerier
}

include "include/connect/CloseConnect.php";
