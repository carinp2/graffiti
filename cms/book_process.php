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
	//type: edit, book_id: vBookId, price: vPrice, special: vSpecial, special_price: vSpecial_price, bnew: vNew, topseller: vTopseller, top_seller_rank: vTopseller_rank, out_print: vOut_print, in_stock: vInstock, publisher: vPublisher,
	//default_discount:vDefault_discount, dimensions: vDimensions, weight:vWeight, format: vFormat, pages: vPages, date_publish: vPublishDate, soon: vSoon, soon_discount: vSoonDiscount, soon_rank: vSoonRank, new_rank: vNewRank,
	//tv: vTv, tv_date: vTvDate
    $vQueryResult = 0;
    $vId = $_POST['book_id'];
	$vData['price'] = $vGeneral->prepareStringForQuery($_POST['price']);
	$vData['special'] = General::prepareStringForQuery($_POST['special']);
	$vData['special_price'] = General::prepareStringForQuery($_POST['special_price']);
	//($_POST['special'] == 1 && $_POST['special_price'] > 0 ? $vData['special_rank'] = 1 : $vData['special_rank'] = 0);
	$vData['new'] = General::prepareStringForQuery($_POST['bnew']);
	($vData['new'] == 1 && ($_POST['new_rank'] > 0 && !empty($_POST['new_rank'])) ? $vData['new_rank'] = General::prepareStringForQuery($_POST['new_rank']) : $vData['new_rank'] = 7);
	$vData['top_seller'] = General::prepareStringForQuery($_POST['top_seller']);
	//($vData['top_seller'] == 0 ? $vData['top_seller_rank'] = 0 : $vData['top_seller_rank'] = $_POST['top_seller_rank']);
	$vData['out_of_print'] = General::prepareStringForQuery($_POST['out_print']);
	$vData['in_stock'] = General::prepareStringForQuery($_POST['in_stock']);
	$vData['publisher'] = General::prepareStringForQuery($_POST['publisher']);
	//$vData['default_discount'] = General::prepareStringForQuery($_POST['default_discount']);
//	($_POST['default_discount'] == "" || empty($_POST['default_discount']) ? $vData['default_discount'] = 0.2 : $vData['default_discount'] = $_POST['default_discount']);
//	$vData['dimensions'] = General::prepareStringForQuery($_POST['dimensions']);
//	$vData['weight'] = General::prepareStringForQuery($_POST['weight']);
//	$vData['format'] = General::prepareStringForQuery($_POST['format']);
//	$vData['pages'] = General::prepareStringForQuery($_POST['pages']);
	$vData['date_publish'] = General::prepareStringForQuery($_POST['date_publish']);
	$vData['soon'] = General::prepareStringForQuery($_POST['soon']);
	$vData['soon_discount'] = General::prepareStringForQuery($_POST['soon_discount']);
	(($_POST['soon'] == 1 && $vData['date_publish'] > $_SESSION['now_date']) && ($_POST['soon_rank'] > 0 && !empty($_POST['soon_rank'])) ? $vData['soon_rank'] = General::prepareStringForQuery($_POST['soon_rank']) : ($vData['date_publish'] <= $_SESSION['now_date'] ? $vData['soon_rank'] = 0 : $vData['soon_rank'] = 1));
//	$vData['edit_by'] = $_SESSION['SessionGrafCmsUserId'];
	$vData['tv'] = General::prepareStringForQuery($_POST['tv']);
	($vData['tv'] == 1 ? $vData['tv_date'] = General::prepareStringForQuery($_POST['tv_date']) : $vData['tv_date'] = "NULL");
	$vData['cost_price'] = General::prepareStringForQuery($_POST['cost_price']);
	$vData['rr'] = General::prepareStringForQuery($_POST['rr']);
	($vData['rr'] == 1 ? $vData['rr_date'] = General::prepareStringForQuery($_POST['rr_date']) : $vData['rr_date'] = "NULL");
	($vData['rr'] == 1 ? $vData['default_discount'] = 0.1 : "");

	//Add this on 15-01-2021
    //Remove on 15-03-2022
//    ($vData['new'] == 1 || $vData['top_seller'] == 1 || $vData['soon'] == 1 ? $vData['default_discount'] = 0.2 : $vData['default_discount'] = 0.0);
    $vDD = $_POST['default_discount'];
    $vData['default_discount'] = (isset($vDD) && $vDD > 0) ? $vDD : 0.0;

	$vQueryResult = MysqlQuery::doUpdate($conn, 'books', $vData, "id = ".$vId);
	if ($vQueryResult == 1){
		echo 'success';
	}
	else if ($vQueryResult == 0){
		echo 'error';
	}
}
else if($vType == "edit-sql" || $vType == "add-sql" || $vType == "add_stat-sql"){
	$vData['isbn'] = $vGeneral->prepareStringForQuery(str_replace(" ", "", str_replace("-", "", $vRequest->getParameter('isbn'))));
	$vData['category'] = $vRequest->getParameter('category');
	$vData['sub_category'] = $vRequest->getParameter('sub_category');
	$vData['title'] = $vGeneral->prepareStringForQuery(ltrim($vRequest->getParameter('title')));
	$vData['summary'] = $vGeneral->prepareStringForQuery(ltrim($vRequest->getParameter('summary')));
	$vData['author'] = str_replace(", ", ",", $vGeneral->prepareStringForQuery(ltrim($vRequest->getParameter('author'))));
	$vData['illustrator'] = str_replace(", ", ",", $vGeneral->prepareStringForQuery(ltrim($vRequest->getParameter('illustrator'))));
	$vData['translator'] = str_replace(", ", ",", $vGeneral->prepareStringForQuery(ltrim($vRequest->getParameter('translator'))));
	$vData['price'] = $vGeneral->prepareStringForQuery($vRequest->getParameter('price'));
	(!empty($vRequest->getParameter('special_price')) ? $vData['special_price'] = $vGeneral->prepareStringForQuery($vRequest->getParameter('special_price')) : $vData['special_price'] = 0);
	(!empty($vRequest->getParameter('special')) ? $vData['special'] = $vGeneral->prepareStringForQuery($vRequest->getParameter('special')) : $vData['special'] = 0);
	($vRequest->getParameter('special') == 1 && $vRequest->getParameter('special_price') > 0 ? $vData['special_rank'] = 1 : $vData['special_rank'] = 0);
	$vData['date_publish'] = $vGeneral->prepareStringForQuery($vRequest->getParameter('date_publish'));
	(!empty($vRequest->getParameter('new')) ? $vData['new'] = $vGeneral->prepareStringForQuery($vRequest->getParameter('new')) : $vData['new'] = 0);
	//(!empty($vRequest->getParameter('new_rank')) ? $vData['new_rank'] = $vGeneral->prepareStringForQuery($vRequest->getParameter('new_rank')) : $vData['new_rank'] = 0);
	(!empty($vRequest->getParameter('top_seller')) ? $vData['top_seller'] = $vGeneral->prepareStringForQuery($vRequest->getParameter('top_seller')) : $vData['top_seller'] = 0);
	($vData['top_seller'] == 0 ? $vData['top_seller_rank'] =  0 : $vData['top_seller_rank'] = $vGeneral->prepareStringForQuery($vRequest->getParameter('top_seller_rank')));
	(!empty($vRequest->getParameter('out_of_print')) ? $vData['out_of_print'] = $vGeneral->prepareStringForQuery($vRequest->getParameter('out_of_print')) : $vData['out_of_print'] = 0);
	$vData['in_stock'] = $vGeneral->prepareStringForQuery($vRequest->getParameter('in_stock'));
	$vData['publisher'] = $vGeneral->prepareStringForQuery($vRequest->getParameter('publisher'));
	$vData['language'] = $vRequest->getParameter('language');
	if($vType == "add-sql"){
		$vData['edit_by'] = $vRequest->getParameter('edit_by');
	}
	//(!empty($vRequest->getParameter('default_discount')) ? $vData['default_discount'] = $vGeneral->prepareStringForQuery($vRequest->getParameter('default_discount')) : $vData['default_discount'] = 0.1);
	(!empty($vRequest->getParameter('dimensions')) ? $vData['dimensions'] = $vGeneral->prepareStringForQuery($vRequest->getParameter('dimensions')) : $vData['dimensions'] = 0);
	(!empty($vRequest->getParameter('weight')) ? $vData['weight'] = $vGeneral->prepareStringForQuery($vRequest->getParameter('weight')) : $vData['weight'] = 0);
	(!empty($vRequest->getParameter('format')) ? $vData['format'] = $vGeneral->prepareStringForQuery($vRequest->getParameter('format')) : $vData['format'] = 0);
	(!empty($vRequest->getParameter('pages')) ? $vData['pages'] = $vGeneral->prepareStringForQuery($vRequest->getParameter('pages')) : $vData['pages'] = 0);
	(!empty($vRequest->getParameter('soon_discount')) ? $vData['soon_discount'] = $vGeneral->prepareStringForQuery($vRequest->getParameter('soon_discount')) : $vData['soon_discount'] = 0);
	//(!empty($vRequest->getParameter('soon_rank')) ? $vData['soon_rank'] = $vGeneral->prepareStringForQuery($vRequest->getParameter('soon_rank')) : $vData['soon_rank'] = 0);
	(!empty($vRequest->getParameter('soon')) ? $vData['soon'] = $vGeneral->prepareStringForQuery($vRequest->getParameter('soon')) : $vData['soon'] = 0);
	$vData['cost_price'] = General::prepareStringForQuery($_POST['cost_price']);
	$vData['section'] = $_POST['section'];

	//Add this on 15-01-2021
    //Remove on 15-03-2022
//    ($vData['new'] == 1 || $vData['top_seller'] == 1 || $vData['soon'] == 1 ? $vData['default_discount'] = 0.2 : $vData['default_discount'] = 0.0);
    $vDD = $vRequest->getParameter('default_discount');
    $vData['default_discount'] = (isset($vDD) && $vDD > 0) ? $vDD : 0.0;

	$vNewBlobPath =  $_FILES['blob_path']["name"];
	$vCurrentBlobPath = $vRequest->getParameter('current_blob_path');

	if(!empty($vCurrentBlobPath) && !empty($vNewBlobPath)){
		if(!empty($vNewBlobPath)){
			$dir = "../images/books/".substr($vCurrentBlobPath,0,14);
			if(($dir != "../images/books/export0000000/" && strpos($dir, 'export0000000') > 0) && ($dir != "../images/books/stat_import/" && strpos($dir, 'stat_import') > 0)){
				foreach(glob($dir . '*.*') as $v) {
					unlink($v);
				}
				rmdir($dir);
			}
		}
	}
	//DOC LOAD
	if(!empty($vNewBlobPath)){
		$vFileName = $_FILES['blob_path']["name"];
		$vTempFolder = $_FILES['blob_path']["tmp_name"];
		$vDirectory = "../images/books/";
		$vUnique = uniqid() . "/";
		$vUniqueDirectory = $vDirectory . $vUnique;
		if(!is_dir($vUniqueDirectory)) {
			mkdir($vUniqueDirectory, 0777);
		}
		$vData['blob_path'] = $vUnique.preg_replace('/\s+/', '', $vFileName);
		move_uploaded_file($vTempFolder, $vUniqueDirectory.preg_replace('/\s+/', '', $vFileName));
	}

	if($vType == "add-sql" || $vType == "add_stat-sql"){
		$vData['date_loaded'] = $_SESSION['now_date'];
		$vData['search_idx'] = 0;

		$vQueryResult = MysqlQuery::doInsert($conn, 'books', $vData);
		if ($vQueryResult > 0){//success
			unset($_SESSION['SessionGrafCmsMessage']);
			$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"success-message\"><i class=\"fa fa-check fa-lg space-right green\" aria-hidden=\"true\"></i>Die boek info is suksesvol gelaai!</h4>";
		}
		else if ($vQueryResult == 0){//error
			unset($_SESSION['SessionGrafCmsMessage']);
			$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"error-message\"><i class=\"fa fa-times fa-lg space-right red\" aria-hidden=\"true\"></i>Die boek info is nie gelaai nie! Probeer asseblief weer of kontak die Webmaster.</h4>";
		}
		//Do search index
		if($vQueryResult > 0){
			$vId = $vQueryResult;
			$vDataS['id'] = $vId;
			$vDataS['title'] = General::prepareBooksSearchStringData($vData['title']);
			$vDataS['summary'] = General::prepareBooksSearchStringData($vData['summary']);
			$vDataS['author'] = General::prepareBooksSearchStringData($vData['author']);
			$vDataS['illustrator'] = General::prepareBooksSearchStringData($vData['illustrator']);
			$vDataS['translator'] = General::prepareBooksSearchStringData($vData['translator']);
			$vDataS['language'] = General::prepareBooksSearchStringData($vData['language']);
			$vDataS['isbn'] = $vData['isbn'];
			$vQueryS = $vQuery::doInsert($conn, "books_search", $vDataS);

			//Set New Rank if book is New Start
			if($vData['new'] == 1 && empty($vRequest->getParameter('new_rank'))){
				//$vHighRank = MysqlQuery::getMax($conn, 'books', 'new_rank');
				//$vBookData['new_rank'] = $vHighRank + 1;
				$vBookData['new_rank'] = 1;
			}
			//Set New Rank if book is New End

			//Set Soon Rank if book is Soon Start
			if($vData['soon'] == 1 && empty($vRequest->getParameter('soon_rank'))){
				//$vHighRank = MysqlQuery::getMax($conn, 'books', 'soon_rank');
				//$vBookData['soon_rank'] = $vHighRank + 1;
				$vBookData['soon_rank'] = 1;
			}
			//Set Soon Rank if book is Soon End

			if($vQueryS > 0){
				$vBookData['search_idx'] = 1;
				$vQuery->doUpdate($conn, 'books', $vBookData, 'id = '.$vId);
			}
			$vUrl = "index.php?page=books&type=edit&id=".$vId;
		}
		else {
			$vUrl = "index.php?page=books&type=list_new&id=1";
		}
		//General::echoRedirect($vUrl, "");
	}
	if($vType == "edit-sql"){
		$vId = $vRequest->getParameter('id');

		//Set New Rank if book is New Start
		if($vData['new'] == 1){
// 			$vCurrentNewRank = MysqlQuery::getBookCurrentRank($conn, 'new_rank', $vId);
// 			if($vCurrentNewRank == 0){
// 				$vHighRank = MysqlQuery::getMax($conn, 'books', 'new_rank');
// 				$vBookData['new_rank'] = $vHighRank + 1;
// 			}
// 			else {
// 				$vBookData['new_rank'] = $vCurrentNewRank;
// 			}
			if(empty($vRequest->getParameter('new_rank'))){
				$vBookData['new_rank'] =1;
			}
			else {
				$vBookData['new_rank'] = $vRequest->getParameter('new_rank');
			}
		}
		else if($vData['new'] == 0){
			$vBookData['new_rank'] = 0;
		}
		//Set New Rank if book is New End

		//Set Soon Rank if book is Soon Start
		if($vData['soon'] == 1){
// 			$vCurrentSoonRank = MysqlQuery::getBookCurrentRank($conn, 'soon_rank', $vId);
// 			if($vCurrentSoonRank == 0){
// 				$vHighRank = MysqlQuery::getMax($conn, 'books', 'soon_rank');
// 				$vBookData['soon_rank'] = $vHighRank + 1;
// 			}
// 			else {
// 				$vBookData['soon_rank'] = $vCurrentSoonRank;
// 			}
			if(empty($vRequest->getParameter('soon_rank'))){
				$vBookData['soon_rank'] = 1;
			}
			else {
				$vBookData['soon_rank'] = $vRequest->getParameter('soon_rank');
			}
		}
		else if($vData['soon'] == 0){
			$vBookData['soon_rank'] = 0;
		}
		//Set Soon Rank if book is Soon End

		$vQueryResult = MysqlQuery::doUpdate($conn, 'books', $vData, "id = ".	$vId);
		if ($vQueryResult == 1){//success
			unset($_SESSION['SessionGrafCmsMessage']);
			$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"success-message\"><i class=\"fa fa-check fa-lg space-right green\" aria-hidden=\"true\"></i>Die boek info is suksesvol verander!</h4>";
			$vUrl = "index.php?page=books&type=edit&id=".$vId;
		}
		else if ($vQueryResult == 0){//error
			$vUrl = "index.php?page=books&type=list_new&id=1";
			unset($_SESSION['SessionGrafCmsMessage']);
			$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"error-message\"><i class=\"fa fa-times fa-lg space-right red\" aria-hidden=\"true\"></i>Die boek info is nie verander nie! Probeer asseblief weer of kontak die Webmaster.</h4>";
		}
		//Do search index
		if($vQueryResult == 1){
			$vDataS['title'] = General::prepareBooksSearchStringData($vData['title']);
			$vDataS['summary'] = General::prepareBooksSearchStringData($vData['summary']);
			$vDataS['author'] = General::prepareBooksSearchStringData($vData['author']);
			$vDataS['illustrator'] = General::prepareBooksSearchStringData($vData['illustrator']);
			$vDataS['translator'] = General::prepareBooksSearchStringData($vData['translator']);
			$vDataS['language'] = General::prepareBooksSearchStringData($vData['language']);
			$vDataS['isbn'] = $vData['isbn'];
			$vQueryS = $vQuery::doUpdate($conn, "books_search", $vDataS, "id = ".$vId);
			if($vQueryS == 1){
				$vBookData['search_idx'] = 1;
				$vQuery->doUpdate($conn, 'books', $vBookData, 'id = '.$vId);
			}
		}
		//error_log("book_process: ".$_SESSION['SessionGrafCmsReturnUrl'], 0, "C:/Temp/php_errors.log");
		//$vUrl = "index.php?page=books&type=edit&id=".$vId;
		$vUrl = "index.php?".$_SESSION['SessionGrafCmsReturnUrl'];
		//General::echoRedirect($vUrl, "");
	}
	General::echoRedirect($vUrl, "");
	//echo "<Script>history.go(-2);</Script>";
}
else if($vType == "delete-sql"){
	$vId = $vRequest->getParameter('id');
	$vBlobPath = MysqlQuery::getBlobPath($conn, $vId, "books");
	if(!empty($vBlobPath)){
		$dir = "../images/books/".substr($vBlobPath,0,14);
		if(($dir != "../images/books/export0000000/" && strpos($dir, 'export0000000') > 0) && ($dir != "../images/books/stat_import/" && strpos($dir, 'stat_import') > 0)){
				foreach(glob($dir . '*.*') as $v) {
					unlink($v);
				}
				rmdir($dir);
		}
	}
	$vQueryResult = MysqlQuery::doDelete($conn, 'books', "id = ".	$vId);
	$vQueryResult = MysqlQuery::doDelete($conn, 'books_search', "id = ".	$vId);
	if ($vQueryResult == 1){//success
		unset($_SESSION['SessionGrafCmsMessage']);
		$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"success-message\"><i class=\"fa fa-check fa-lg space-right green\" aria-hidden=\"true\"></i>Die boek en alle info is uitgevee!</h4>";
	}
	else if ($vQueryResult == 0){//error
		unset($_SESSION['SessionGrafCmsMessage']);
		$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"error-message\"><i class=\"fa fa-times fa-lg space-right red\" aria-hidden=\"true\"></i>Die boek is nie uitgevee nie! Probeer asseblief weer of kontak die Webmaster.</h4>";
	}
	//$vUrl = "index.php?page=books&type=list_new";
	$vUrl = "index.php?".$_SESSION['SessionGrafCmsReturnUrl'];
	General::echoRedirect($vUrl, "");
}
else if($vType == "delete-image-sql"){
	$vId = $vRequest->getParameter('id');
	$vBlobPath = $vRequest->getParameter('path');
	if(!empty($vBlobPath)){
		$dir = "../images/books/".substr($vBlobPath,0,14);
		if(($dir != "../images/books/export0000000/" && strpos($dir, 'export0000000') > 0) && ($dir != "../images/books/stat_import/" && strpos($dir, 'stat_import') > 0)){
			foreach(glob($dir . '*.*') as $v) {
				unlink($v);
			}
			rmdir($dir);
		}
	}
	$vData['blob_path'] = $vGeneral->prepareStringForQuery("");
//	$vData['edit_by'] = $_SESSION['SessionGrafCmsUserId'];
	$vQueryResult = MysqlQuery::doUpdate($conn, "books", $vData, "id = ".$vId);
	if ($vQueryResult == 1){//success
		unset($_SESSION['SessionGrafCmsMessage']);
		$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"success-message\"><i class=\"fa fa-check fa-lg space-right green\" aria-hidden=\"true\"></i>Die boek prent is uitgevee!</h4>";
	}
	else if ($vQueryResult == 0){//error
		unset($_SESSION['SessionGrafCmsMessage']);
		$_SESSION['SessionGrafCmsMessage'] = "<h4 class=\"error-message\"><i class=\"fa fa-times fa-lg space-right red\" aria-hidden=\"true\"></i>Die boek prent is nie uitgevee nie! Probeer asseblief weer of kontak die Webmaster.</h4>";
	}
	$vUrl = "index.php?page=books&type=edit&id=".$vId;
	General::echoRedirect($vUrl, "");
}
else if($vType == "check-isbn"){
	$vQueryResult = 0;
	$vIsbn = str_replace(" ", "", str_replace("-", "", $_POST['isbn']));

	$vQueryResult = MysqlQuery::checkExists($conn, 'books', 'id', "isbn = ".$vIsbn);
	if ($vQueryResult > 0){
		echo 'exist';
	}
	else if ($vQueryResult == 0){
		echo 'not-exist';
	}
}
else if($vType == "update-topseller-rank"){
	$vQueryResult = 0;
    $i = 1;
    foreach ($_POST['tr'] as $value) {
        $vId = $value;
        $vData['top_seller_rank'] = $i;
//        $vData['edit_by'] = $_SESSION['SessionGrafCmsUserId'];
    	$vQueryResult = MysqlQuery::doUpdate($conn, "books", $vData, "id = ".$vId);
    	$i++;
    }
	if ($vQueryResult > 0){
		echo 'success';
	}
	else if ($vQueryResult == 0){
		echo 'error';
	}
}
else if($vType == "update-new-rank"){
	$vQueryResult = 0;
    $i = 1;
    foreach ($_POST['tr'] as $value) {
        $vId = $value;
        $vData['new_rank'] = $i;
//        $vData['edit_by'] = $_SESSION['SessionGrafCmsUserId'];
    	$vQueryResult = MysqlQuery::doUpdate($conn, "books", $vData, "id = ".$vId);
    	$i++;
    }
	if ($vQueryResult > 0){
		echo 'success';
	}
	else if ($vQueryResult == 0){
		echo 'error';
	}
}
else if($vType == "update-soon-rank"){
	$vQueryResult = 0;
    $i = 1;
    foreach ($_POST['tr'] as $value) {
        $vId = $value;
        $vData['soon_rank'] = $i;
//        $vData['edit_by'] = $_SESSION['SessionGrafCmsUserId'];
    	$vQueryResult = MysqlQuery::doUpdate($conn, "books", $vData, "id = ".$vId);
    	$i++;
    }
	if ($vQueryResult > 0){
		echo 'success';
	}
	else if ($vQueryResult == 0){
		echo 'error';
	}
}
else if($vType == "update-special-rank"){
	$vQueryResult = 0;
    $i = 1;
    foreach ($_POST['tr'] as $value) {
        $vId = $value;
        $vData['special_rank'] = $i;
//        $vData['edit_by'] = $_SESSION['SessionGrafCmsUserId'];
    	$vQueryResult = MysqlQuery::doUpdate($conn, "books", $vData, "id = ".$vId);
    	$i++;
    }
	if ($vQueryResult > 0){
		echo 'success';
	}
	else if ($vQueryResult == 0){
		echo 'error';
	}
}



include "../include/connect/CloseConnect.php";
