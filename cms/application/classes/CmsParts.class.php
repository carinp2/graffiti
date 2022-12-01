<?php

/**
 * @author Carin Pretorius - CEIT Development - CEIT Development
 * Created on 2016-09-22
 */

class CmsParts {

	public function returnTopMenu($pConn, $pPage) {
		$vString = "\n   <div id='pagetop'><div id='menu'>";
		if(in_array("boeke", $_SESSION['SessionGrafCmsUserSections'])){
			$vString .= "\n     <a href='index.php?page=books&type=add'";
			if($pPage == "books"){
				$vString .= " class='active'";
			}
			$vString .= ">Boeke/Item</a>";
		}
		if(in_array("tuisblad", $_SESSION['SessionGrafCmsUserSections'])){
			$vString .= "\n     <a href='index.php?page=landing&type=new'";
			if($pPage == "landing"){
				$vString .= " class='active'";
			}
			$vString .= ">Tuisblad</a>";
		}
		if(in_array("bestellings", $_SESSION['SessionGrafCmsUserSections'])){
			$vString .= "\n     <a href='index.php?page=orders&type=completed_0'";
			if($pPage == "orders"){
				$vString .= " class='active'";
			}
			$vString .= ">Bestellings</a>";
		}
		if(in_array("kliente", $_SESSION['SessionGrafCmsUserSections'])){
			$vString .= "\n     <a href='index.php?page=clients&type=validated_0&id=0'";
			if($pPage == "clients"){
				$vString .= " class='active'";
			}
			$vString .= ">Kli&#235;nte</a>";
		}
		if(in_array("batch", $_SESSION['SessionGrafCmsUserSections'])){
			$vString .= "\n     <a href='index.php?page=batch&type=stock_update'";
			if($pPage == "batch"){
				$vString .= " class='active'";
			}
			$vString .= ">Batch funksies</a>";
		}
//		if(in_array("nuusbriewe", $_SESSION['SessionGrafCmsUserSections'])){
//			$vString .= "\n     <a href='index.php?page=newsletters&type=list'";
//			if($pPage == "newsletters"){
//				$vString .= " class='active'";
//			}
//			$vString .= ">Nuusbriewe</a>";
//		}
//		if(in_array("boek-koek", $_SESSION['SessionGrafCmsUserSections'])){
//			$vString .= "\n     <a href='index.php?page=events&type=future'";
//			if($pPage == "events"){
//				$vString .= " class='active'";
//			}
//			$vString .= ">Funksies</a>";
//		}
		if(in_array("uitgewers", $_SESSION['SessionGrafCmsUserSections'])){
			$vString .= "\n     <a href='index.php?page=publishers&type=list&id=0'";
			if($pPage == "publishers"){
				$vString .= " class='active'";
			}
			$vString .= ">Uitgewers</a>";
		}
		if(in_array("afleweringskoste", $_SESSION['SessionGrafCmsUserSections'])){
			$vString .= "\n     <a href='index.php?page=courier'";
			if($pPage == "courier"){
				$vString .= " class='active'";
			}
			$vString .= ">Afleweringskoste</a>";
		}
		if(in_array("taal", $_SESSION['SessionGrafCmsUserSections'])){
			$vString .= "\n     <a href='index.php?page=language'";
			if($pPage == "language"){
				$vString .= " class='active'";
			}
			$vString .= ">&nbsp;Taal&nbsp;</a>";
		}
		if(in_array("gebruikers", $_SESSION['SessionGrafCmsUserSections'])){
			$vString .= "\n     <a href='index.php?page=users&type=list'";
			if($pPage == "users"){
				$vString .= " class='active'";
			}
			$vString .= ">Gebruikers</a>";
		}
//		if(in_array("market-export", $_SESSION['SessionGrafCmsUserSections'])){
//			$vString .= "\n     <a href='exportToExcel.php?type=marketing-export'";
//			if($pPage == "export"){
//				$vString .= " class='active'";
//			}
//			$vString .= ">Market export</a>";
//		}
        if(in_array("kompetisies", $_SESSION['SessionGrafCmsUserSections'])){
            $vString .= "\n     <a href='index.php?page=competitions&type=list_1'";
            if($pPage == "competitions"){
                $vString .= " class='active'";
            }
            $vString .= ">Kompetisies</a>";
        }

		if(isset($_SESSION['SessionGrafCmsUserId'])){
				$vString .= "\n     <span id='user'>";
					$vString .= "\n      <a href='index.php?page=users&type=password&id=".$_SESSION['SessionGrafCmsUserId']."' ".General::echoTooltip("bottom", "Verander jou wagwoord")."><i class='fa fa-user top'></i>&nbsp;".$_SESSION['SessionGrafCmsUserName']." ".$_SESSION['SessionGrafCmsUserSurname']."</a>&nbsp;&nbsp;";
					$vString .= "\n      <a href='index.php?page=logout'>Teken af</a>";
				$vString .= "\n     </span>";
		}
		else {
				$vString .= "\n     <span id='user'>";
					$vString .= "\n      <a href='index.php?page=home'>Teken aan</a>";
				$vString .= "\n     </span>";
		}

		$vString .= "\n   </div></div>";
		return General::prepareStringForDisplay($vString, $pConn);
	}

	public static function returnSubMenu($pConn, $pPage, $vType) {
		$vSubMenuResults = MysqlQuery::getSubMenu($pConn, $pPage);//$vMenuId, $vMenuPage, $vMenuText, $vMenuType
		$vString = "\n   <div id='submenu'>";
        if(isset($vSubMenuResults[0])) {
            for ($x = 0; $x < count($vSubMenuResults[0]); $x++) {
                if (strpos($vSubMenuResults[3][$x], '#') !== false) {
                    $vSubUrl = str_replace("#", "", $vSubMenuResults[3][$x]);
                    $vString .= "\n     <a href='#' id='" . $vSubUrl . "'";
                } else {
                    $vSubUrl = $vSubMenuResults[3][$x];
                    $vString .= "\n     <a href='index.php?page=" . $pPage . "&type=" . $vSubMenuResults[3][$x] . "'";
                }
                if ($vType == $vSubUrl) {
                    $vString .= " class='active'";
                }
                $vString .= "><i class='fa fa-chevron-right menu space-right' aria-hidden='true'></i>" . $vSubMenuResults[2][$x] . "</a>";
            }
        }

			$vString .= "\n   </div>";
		return General::prepareStringForDisplay($vString, $pConn);
	}

	public function returnBeginHtml(){
		$vString = "<!DOCTYPE html>";
		$vString .= "\n<html lang='en'>";
			$vString .= "\n <head>";
			$vString .= "\n		<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>";
			$vString .= "\n		<meta name='viewport' content='width=device-width, initial-scale=1'>";
			$vString .= "\n		<meta content='CEIT Development Namibia CC' name='author'>";
			$vString .= "\n		<link href='../images/icon.ico' rel='shortcut icon' type='image/ico'>";
			$vString .= "\n		<script type='text/javascript' src='js/js_quicktags.js'></script>";
			$vString .= "\n		<link href='../css/bootstrap.css' media='screen' id='callCss' rel='stylesheet' />";
			$vString .= "\n		<link href='".$_SESSION['SessionGrafCmsStyle']."' rel='stylesheet'>";
			$vString .= "\n		<link href='../css/lightbox.min.css' rel='stylesheet' />";
			$vString .= "\n		<link href='css/jquery.dataTables.min.css' rel='stylesheet' />";
			$vString .= "\n		<link rel='stylesheet' href='../css/font-awesome.css' type='text/css' />";
			$vString .= "\n		<link rel='stylesheet' href='css/jquery-ui.css'>";
			$vString .= "\n		<link rel='stylesheet' href='css/buttons.dataTables.min.css'>";
			$vString .= "<title>GRAFFITI - CMS</title>";

		$vString .= "\n </head>";
		$vString .= "\n <body>";
			$vString .= "\n <div id='pre_load'></div>";
			$vString .= "\n  <div id='wrapper'>";
		return $vString;
	}

	public function returnContentStart(){
		$vString = "\n   <div id='page-content'>";
		return $vString;
	}

	public function returnEndHtml($pConn){
        $vString = "\n    <div id='pagebottom' class='copy'>Copyright © Graffiti Books. All Rights Reserved.</div>";
        $vString .= "\n   </div>";
// 					$vString .= "\n   <footer>";
// 						$vString .= "\n    <div id='logo-s'><img src='../images/logo.png' title='GRAFFITI'></div>";
// 						$vString .= "\n    <p id='copy'>Copyright © Graffiti Books. All Rights Reserved.</p>";
// 						$vString .= "\n    <a id='small_ceit' href='https://www.ceit.cc' target='_blank'>A product of CEIT Development</a>";
                $vString .= "\n	<a href='#pagetop' id='scroll-top'><i class='fa fa-chevron-up' aria-hidden='true'></i></a>&nbsp;&nbsp;&nbsp;";
                $vString .= "\n	<a href='#pagebottom' id='scroll-bottom'><i class='fa fa-chevron-down' aria-hidden='true'></i></a>";
//					$vString .= "\n   </footer>";
        $vString .= "\n  </div>";

        $vString .= "\n		<script src='../js/jquery-3.1.1.min.js'></script>";
        $vString .= "\n		<script src='../js/lightbox.min.js'></script>";
        $vString .= "\n		<script src='js/jquery.dataTables.min.js'></script>";
        $vString .= "\n		<script src='../js/modernizr.js' type='text/javascript'></script>";
        $vString .= "\n		<script type='text/javascript' src='".$_SESSION['SessionGrafCmsScript']."'></script>";
        $vString .= "\n		<script type='text/javascript' src='js/jquery-ui.min.js'></script>";
        $vString .= "\n		<script src='../js/bootstrap.min.js' type='text/javascript'></script>";
        $vString .= "\n		<script src='js/dataTables.rowReorder.js' type='text/javascript'></script>";
        $vString .= "\n		<script src='js/dataTables.fixedHeader.min.js' type='text/javascript'></script>";
        $vModals = CmsModal::loadCmsModals($pConn);
        $vString .= $vModals;

			$vString .= "<script>";
 					$vString .="$(window).on('load', function() {";
 						$vString .="$('#pre_load').fadeOut('slow');";
 					$vString .="});";
			$vString .= "</script>";

			$vString .= "\n</body>";
		$vString .= "\n</html>";
		return $vString;
	}

	public function returnHome($pConn){
		if(isset($_SESSION['SessionGrafCmsUserId'])){
			$vString = "<article>";
				$vString .= "<br><h1 class='red'>AANTEKEN SUKSES!</h1><br>";
				$vString .= "<h2><i class='fa fa-check fa-lg space-right blue' aria-hidden='true'></i>Welcome ".$_SESSION['SessionGrafCmsUserName']." ".$_SESSION['SessionGrafCmsUserSurname']."</h2><br>";
				$vString .= "<p>Gaan voort deur 'n item op die boonste skakels te kies.</p>";
			$vString .= "</article>";
		}
		return General::prepareStringForDisplay($vString, $pConn);
	}

	public function returnLogin($pConn){
		$vString = "<h1>Graffiti - Bestuurstelsel</h1>";
		$vString .= "<h2>Teken aan</h2>";
		$vString .= "<article>";
		if($_SESSION['SessionGrafCmsLoginNo'] <= 3 || !isset($_SESSION['SessionGrafCmsLoginNo'])) {
			$vString .= "<form name='FormLogin' id='FormLogin' method='post'>";
			$vString .= "<div>";
			$vString .= "<label for='username'>Epos:</label>";
			$vString .= General::returnInput($pConn, "text", "username", "username", "", 30, 50, "", "[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$", "required", "", "");
			$vString .= "</div>";
			$vString .= "<div>";
			$vString .= "<label for='password'>Wagwoord:</label>";
			$vString .= General::returnInput($pConn, "password", "password", "password", "", 20, 20, "", ".{6,}", "required", "6 Karakters of langer", "");
			$vString .= "</div>";
			$vString .= "<div>";
			$vString .= "<label><input type='submit' value='Gaan voort'></label>";
			$vString .= "</div>";
			$vString .= "<input type='hidden' name='page' value='login'>";
			$vString .= "</form>";
		}
		else {
			$vString .= "<h3 class='error'>Aanteken fout</h3>";
			$vString .= "<p><img src='images/error.png' class='info-icon'/>";
			$vString .= "Jy het te veel keer probeer aanteken. Kontak jou webbestuurder <a href='mailto:carin@ceit.cc?subject=Graffitit unsuccessful CMS login'>carin@ceit.cc</a></p>";
		}
		$vString .= "</article>";
		return General::prepareStringForDisplay($vString, $pConn);
	}

	public function returnRegister($pConn, $pType){
		$vString = "<article>";
			if($pType == "success"){
				$vString .= "<h1>Home</h1>";
				$vString .= "<h4>Success!!</h4>";
				$vString .= "<p><img src='images/yes.png' class='info-icon'/>User registration successful!</p>";
			}
			else if($pType == "unsuccess"){
				$vString .= "<h1>Home</h1>";
				$vString .= "<h4>Unsuccessful!!</h4>";
				$vString .= "<p><img src='images/error.png' class='info-icon'/>User registration unsuccessful!</p>";
			}
		$vString .= "</article>";
		return General::prepareStringForDisplay($vString, $pConn);
	}

	public function doLogout(){
		unset($_SESSION['SessionGrafCmsUserId']);
		unset($_SESSION['SessionGrafCmsUserName']);
		unset($_SESSION['SessionGrafCmsUserSurname']);
		unset($_SESSION['SessionGrafCmsUserEmail']);
		unset($_SESSION['SessionGrafCmsLoginNo']);
		unset($_SESSION['SessionGrafCmsUserSections']);
		unset($_SESSION['SessionGrafCmsUserRights']);
		$vUrl = "index.php?page=home";
		General::echoRedirect($vUrl, "");
		//header("Location: " . $vUrl);
	}

	public static function echoBooks($pConn, $pData){
		$vString = "";
		$vBindParams = array();
		$vBindLetters = "";
		if($pData['type'] == "list"){
			$vWhere = "WHERE b.id >  ?";
			$vOrder = " ORDER BY b.title ASC";
			$vValue = 0;
			$vBindLetters .= "i";
			$vBindParams[] = & $vValue;
			$vLimit = "";
			$_SESSION['SessionGrafCmsReturnUrl'] = General::getUrlParameters();
		}
		else if($pData['type'] == "list_new"){
			$vWhere = "WHERE b.date_publish <=  ?";
			$vOrder = " ORDER BY b.date_publish DESC";
			$vValue = $_SESSION['now_date'];
			$vBindLetters .= "s";
			$vBindParams[] = & $vValue;
			$vLimit = "LIMIT 300";
			$_SESSION['SessionGrafCmsReturnUrl'] = General::getUrlParameters();
		}
		else if($pData['type'] == "list_latest_loaded"){
			$vWhere = "WHERE b.id >  ?";
			$vOrder = " ORDER BY b.id DESC";
			$vValue = 0;
			$vBindLetters .= "i";
			$vBindParams[] = & $vValue;
			$vLimit = "LIMIT 100";
			$_SESSION['SessionGrafCmsReturnUrl'] = General::getUrlParameters();
		}
		else if($pData['type'] == "no_summary"){
			$vWhere = "WHERE b.summary IS NULL OR b.summary = '' AND b.id > ?";
			$vOrder = " ORDER BY b.date_publish DESC";
			$vValue = 0;
			$vBindLetters .= "i";
			$vBindParams[] = & $vValue;
			$vLimit = "LIMIT 100";
			$_SESSION['SessionGrafCmsReturnUrl'] = General::getUrlParameters();
		}
		else if($pData['type'] == "publisher"){
			$vPublisherId = $pData['id'];
			($vPublisherId == 0 ? $vValue = 2500 : $vValue = $vPublisherId);
			$vWhere = "WHERE b.publisher = ?";
			$vOrder = " ORDER BY b.date_publish DESC";
			$vBindLetters .= "i";
			$vBindParams[] = & $vValue;
			$vLimit = "";
			$_SESSION['SessionGrafCmsReturnUrl'] = General::getUrlParameters();
		}
		else if($pData['type'] == "searchBook"){
			$vBookId = $pData['id'];
			$vWhere = "WHERE b.id = ?";
			$vOrder = "";
			$vBindLetters .= "i";
			$vBindParams[] = & $vBookId;
			$vLimit = "";
			$_SESSION['SessionGrafCmsReturnUrl'] = General::getUrlParameters();
		}
		else if($pData['type'] == "searchBookPublisher"){
			$vPublisherId = $pData['id'];
			$vWhere = "WHERE b.publisher = ?";
			$vOrder = "";
			$vBindLetters .= "i";
			$vBindParams[] = & $vPublisherId;
			$vLimit = "";
			$_SESSION['SessionGrafCmsReturnUrl'] = General::getUrlParameters();
		}
		else if($pData['type'] == "searchBookSubCategory"){
			$vSubCategoryId = $pData['id'];
			$vWhere = "WHERE b.sub_category = ?";
			$vOrder = "";
			$vBindLetters .= "i";
			$vBindParams[] = & $vSubCategoryId;
			$vLimit = "";
			$_SESSION['SessionGrafCmsReturnUrl'] = General::getUrlParameters();
		}
		else if($pData['type'] == "searchBookAuthor"){
			$vAuthor = "%{$pData['id']}%";
			$vWhere = "WHERE b.author like ?";
			$vOrder = "";
			$vBindLetters .= "s";
			$vBindParams[] = & $vAuthor;
			$vLimit = "";
			$_SESSION['SessionGrafCmsReturnUrl'] = General::getUrlParameters();
		}
		else if($pData['type'] == "searchBookTitle"){
			$vTitle = "%{$pData['id']}%";
			$vWhere = "WHERE b.title LIKE ?";
			$vOrder = "";
			$vBindLetters .= "s";
			$vBindParams[] = & $vTitle;
			$vLimit = "";
			$_SESSION['SessionGrafCmsReturnUrl'] = "page=books&type=searchBookTitle&id=".$pData['id'];
		}
		else if($pData['type'] == "list_tv"){
			$vWhere = "WHERE b.tv =  ?";
			$vOrder = " ORDER BY b.date_publish DESC";
			$vValue = 1;
			$vBindLetters .= "i";
			$vBindParams[] = & $vValue;
			$vLimit = "";
			$_SESSION['SessionGrafCmsReturnUrl'] = General::getUrlParameters();
		}
		else if($pData['type'] == "list_rr"){
			$vWhere = "WHERE b.rr =  ?";
			$vOrder = " ORDER BY b.rr_date DESC";
			$vValue = 1;
			$vBindLetters .= "i";
			$vBindParams[] = & $vValue;
			$vLimit = "";
			$_SESSION['SessionGrafCmsReturnUrl'] = General::getUrlParameters();
		}
		else if($pData['type'] == "searchStationarySupplier"){
			$vWhere = "WHERE section = ? AND publisher = ?";
			$vOrder = " ORDER BY b.id DESC";
			$vValue = 3;
			$vSupplierId = $pData['id'];
			$vBindLetters .= "i";
			$vBindLetters .= "i";
			$vBindParams[] = & $vValue;
			$vBindParams[] = & $vSupplierId;
			$vLimit = "";
			$_SESSION['SessionGrafCmsReturnUrl'] = General::getUrlParameters();
		}

		$vPublishers = MysqlQuery::getPublishers($pConn);//$vPubId, $vPub, $vPubSupplier

		include "include/BookLookupForms.php";

		$vResults = MysqlQuery::getBooks($pConn, $vWhere, $vOrder, $vBindLetters, $vBindParams, $vLimit);
		$vString .= "<h1>Boeke</h1>";
		$vString .= "<p class='green space-right' id='right-float'><i><b>Tuisblad boeke</b></i></p>";
		if(isset($_SESSION['SessionGrafCmsMessage']) && !empty($_SESSION['SessionGrafCmsMessage'])){
			$vString .= "<h5>".$_SESSION['SessionGrafCmsMessage']."</h5>";
			unset($_SESSION['SessionGrafCmsMessage']);
		}
		if($pData['type'] == "searchBookPublisher"){
	            $vString .= "<article><form method='post' action='exportToExcel.php' id='right-float'>";
	            	$vString .= "<input type='hidden' name='page' value='export'>";
	            	$vString .= "<input type='hidden' name='type' value='".$pData['type']."'>";
	            	$vString .= "<input type='hidden' name='id' value='".$vPublisherId."'>";
	            	$vString .= "<input type='submit' name='export_excel' value='Laai in Excel' />";
	            $vString .= "</form></article>";
		}
		else if($pData['type'] == "searchBookSubCategory"){
	            $vString .= "<article><form method='post' action='exportToExcel.php' id='right-float'>";
	            	$vString .= "<input type='hidden' name='page' value='export'>";
	            	$vString .= "<input type='hidden' name='type' value='".$pData['type']."'>";
	            	$vString .= "<input type='hidden' name='id' value='".$vSubCategoryId."'>";
	            	$vString .= "<input type='submit' name='export_excel' value='Laai in Excel' />";
	            $vString .= "</form></article>";
		}

		$vString .= "<table id='tableBooks' class='cell-border dataTable hover' cellspacing='0'>";
			$vString .= "<thead>";
				$vString .= "<tr class='red'>";
				if($pData['type'] != "searchStationarySupplier"){
					include "include/BookTableHeadings.php";
				}
				else {
					include "include/StationaryTableHeadings.php";
				}
				$vString .= "</tr>";
			$vString .= "</thead>";
			$vString .= "<tfoot>";
				$vString .= "<tr class='red'>";
				if($pData['type'] != "searchStationarySupplier"){
					include "include/BookTableHeadings.php";
				}
				else {
					include "include/StationaryTableHeadings.php";
				}
				$vString .= "</tr>";
			$vString .= "</tfoot>";
			$vString .= "<tbody>";
			if(count($vResults[0]) > 0){
				for($x = 0; $x < count($vResults[0]); $x++){
					//$vBookUrl = $vResults[4][$x];
					//$vViewUrl = $vResults[18][$x]."/".$vResults[0][$x];
					$vYNValueArray = array(1, 0);
					$vYNTextArray = array("J", "N");
					(strlen($vResults[14][$x]) == 1 ? $vTopRank = "0".$vResults[14][$x] : $vTopRank = $vResults[14][$x]);
					if(!empty($vResults[17][$x])){
						$key = array_search($vResults[17][$x], $vPublishers[0]);
						$vPublisher = $vPublishers[1][$key];
					}
					else {
						$vPublisher = 0;
					}
					$vFormat = MysqlQuery::getCmsLookup($pConn, "book_format");
					$vString .= "<tr id='tr_".$vResults[0][$x]."'>";
						$vString .= "<td class='dt-body-center'><span class='hidden-input'>".$vResults[0][$x]."</span>";
							$vString .= "<i class='fa fa-floppy-o fa-lg saveButton green' aria-hidden='true' id='saveBookButton_".$vResults[0][$x]."' data-id='".$vResults[0][$x]."' ".General::echoTooltip("right", "Stoor die veranderinge")."></i>";
							$vString .= "<br><i class='fa fa-pencil fa-lg space-top green' aria-hidden='true' id='editBookButton_".$vResults[0][$x]."' data-id='".$vResults[0][$x]."' ".General::echoTooltip("right", "Verander boek info")."></i>";
							$vString .= "<br><i class='fa fa-times fa-lg space-top red' aria-hidden='true' id='deleteBookButton_".$vResults[0][$x]."' data-id='".$vResults[0][$x]."' ".General::echoTooltip("right", "Vee boek uit")."></i>";
							if(in_array(4, $_SESSION['SessionGrafCmsUserRights'])){
								$vUser = MysqlQuery::getUserName($pConn, $vResults[24][$x]);
								$vString .= "<br><i class='fa fa-user fa-lg space-top green' ".General::echoTooltip("right", "Verander deur: ".$vUser)."></i>";
							}
						$vString .= "</td>";//manage
						$vString .= "<td>".$vResults[4][$x]."<br><div class='lgray'>..../af/".$vResults[0][$x]."/Boeke</div><div class='lgray'>..../en/".$vResults[0][$x]."/Books</div><br>".($pData['type'] == "searchStationarySupplier" ? $vResults[27][$x] : '')."</td>";//title
						$vString .= "<td>".$vResults[1][$x]."</td>";//isbn
						$vString .= "<td>".$vResults[19][$x]."<i class='fa fa-caret-right fa-lg gray s-space-left s-space-right' aria-hidden='true'></i>".$vResults[20][$x]."</td>";//cat - sub-cat
						$vString .= "<td><span class='hidden-input'>".$vResults[8][$x]."</span>";
							$vString .= "<input type='text' name='price_".$vResults[0][$x]."' id='price_".$vResults[0][$x]."' value='".$vResults[8][$x]."' class='small' size='4'>";
							$vString .= "<input type='text' name='default_discount_".$vResults[0][$x]."' id='default_discount_".$vResults[0][$x]."' value='".$vResults[26][$x]."' class='small' size='4'>";
						$vString .= "</td>";//price
						$vString .= "<td><span class='hidden-input'>".$vResults[12][$x]."</span>";
							$vString .= "<select class='small' id='special_".$vResults[0][$x]."' name='special_".$vResults[0][$x]."'>";
								for($s = 0; $s < count($vYNValueArray); $s++){
									$vString .= "<option value='".$vYNValueArray[$s]."'";
										if($vYNValueArray[$s] == $vResults[12][$x]){
											$vString .= " selected";
										}
									$vString .= ">".$vYNTextArray[$s]."</option>";
								}
							$vString .= "</select><br>";
							$vString .= "<input type='text' name='special_price_".$vResults[0][$x]."' id='special_price_".$vResults[0][$x]."' value='".$vResults[7][$x]."' class='small' size='4'><br>";
							$vString .= "<input type='text' name='cost_price_".$vResults[0][$x]."' id='cost_price_".$vResults[0][$x]."' value='".$vResults[38][$x]."' class='small' size='4'>";
						$vString .= "</td>";//special - special price

						$vString .= "<td class='dt-body-center'><span class='hidden-input'>".$vResults[34][$x]."</span>";
							$vString .= "<select class='small' id='soon_".$vResults[0][$x]."' name='soon_".$vResults[0][$x]."'>";
								for($s = 0; $s < count($vYNValueArray); $s++){
									$vString .= "<option value='".$vYNValueArray[$s]."'";
										if($vYNValueArray[$s] == $vResults[34][$x]){
											$vString .= " selected";
										}
									$vString .= ">".$vYNTextArray[$s]."</option>";
								}
							$vString .= "</select><br>";
							$vString .= "<select class='small' id='soon_discount_".$vResults[0][$x]."' name='soon_discount_".$vResults[0][$x]."'>";
								for($s = 0; $s < count($vYNValueArray); $s++){
									$vString .= "<option value='".$vYNValueArray[$s]."'";
										if($vYNValueArray[$s] == $vResults[32][$x]){
											$vString .= " selected";
										}
									$vString .= ">".$vYNTextArray[$s]."</option>";
								}
							$vString .= "</select><br>";
							$vString .= "<input type='text' name='soon_rank_".$vResults[0][$x]."' id='soon_rank_".$vResults[0][$x]."' value='".$vResults[33][$x]."' class='small' size='3'>";
						$vString .= "</td>";//soon - soon discount - soon rank

						$vString .= "<td class='dt-body-center'><span class='hidden-input'>".$vResults[11][$x]."</span>";
							$vString .= "<select class='small' id='new_".$vResults[0][$x]."' name='new_".$vResults[0][$x]."'>";
								for($n = 0; $n < count($vYNValueArray); $n++){
									$vString .= "<option value='".$vYNValueArray[$n]."'";
										if($vYNValueArray[$n] == $vResults[11][$x]){
											$vString .= " selected";
										}
									$vString .= ">".$vYNTextArray[$n]."</option>";
								}
							$vString .= "</select><br>";
							$vString .= "<input type='text' name='new_rank_".$vResults[0][$x]."' id='new_rank_".$vResults[0][$x]."' value='".$vResults[31][$x]."' class='small' size='3'>";
						$vString .= "</td>";//new

						$vString .= "<td><span class='hidden-input'>".$vResults[25][$x]."</span>";
							$vString .= "<input type='date' name='pub_".$vResults[0][$x]."' id='pub_".$vResults[0][$x]."' value='".$vResults[25][$x]."' class='small' size='4'>";
						$vString .= "</td>";//publication date
						$vString .= "<td><span class='hidden-input'>".$vTopRank."</span>";
							$vString .= "<select class='small' id='top_seller_".$vResults[0][$x]."' name='top_seller_".$vResults[0][$x]."'>";
								for($t = 0; $t < count($vYNValueArray); $t++){
									$vString .= "<option value='".$vYNValueArray[$t]."'";
										if($vYNValueArray[$t] == $vResults[13][$x]){
											$vString .= " selected";
										}
									$vString .= ">".$vYNTextArray[$t]."</option>";
								}
							$vString .= "</select><br>";
							$vString .= "<input type='text' name='top_seller_rank_".$vResults[0][$x]."' id='top_seller_rank_".$vResults[0][$x]."' value='".$vResults[14][$x]."' class='small' size='4'>";
						$vString .= "</td>";//topseller  - rank
						$vString .= "<td class='dt-body-center'><span class='hidden-input'>".$vResults[15][$x]."</span>";
							$vString .= "<select class='small' id='out_print_".$vResults[0][$x]."' name='out_print_".$vResults[0][$x]."'>";
								for($o = 0; $o < count($vYNValueArray); $o++){
									$vString .= "<option value='".$vYNValueArray[$o]."'";
										if($vYNValueArray[$o] == $vResults[15][$x]){
											$vString .= " selected";
										}
									$vString .= ">".$vYNTextArray[$o]."</option>";
								}
							$vString .= "</select>";
						$vString .= "</td>";//out of print
						$vString .= "<td><span class='hidden-input'>".$vResults[16][$x]."</span>";
							$vString .= "<input type='text' name='instock_".$vResults[0][$x]."' id='instock_".$vResults[0][$x]."' value='".$vResults[16][$x]."' class='small' size='4'>";
						$vString .= "</td>";//in_stock
						$vString .= "<td>";
//						if($pData['type'] != "searchBookPublisher"){
							$vString .= "<span class='hidden-input'>".$vPublisher."</span>";
							$vString .= "<select class='small xnarrow' id='publisher_".$vResults[0][$x]."' name='publisher_".$vResults[0][$x]."'>";
								$vString .= "<option value='0'>Kies Uitgewer</option>";
								for($p = 0; $p < count($vPublishers[0]); $p++){
									$vString .= "<option value='".$vPublishers[0][$p]."'";
										if($vPublishers[0][$p] == $vResults[17][$x]){
											$vString .= " selected";
										}
									$vString .= ">".$vPublishers[1][$p]."</option>";
								}
							$vString .= "</select>";
//						}
//						else {
//							$vString .= $vPublisher;
//							$vString .= "<input type='hidden' name='publisher_".$vResults[0][$x]."' id='publisher_".$vResults[0][$x]."' value='".$vResults[17][$x]."'>";
//						}
						$vString .= "</td>";//publisher
						$vString .= "<td class='dt-body-center'>".$vResults[18][$x]."</td>";//language
						$vString .= "<td><span class='green'>".str_replace(",", ", ", $vResults[21][$x])."</span><br><span class='red'>".str_replace(",", ", ",$vResults[22][$x])."</span><br><span class='dblue'>".str_replace(",", ", ",$vResults[23][$x])."</span></td>";//author - translator - illustrator
						$vString .= "<td><span class='hidden-input'>".$vResults[37][$x]."</span>";
							$vString .= "<select class='small' id='tv_".$vResults[0][$x]."' name='tv_".$vResults[0][$x]."'>";
								for($o = 0; $o < count($vYNValueArray); $o++){
									$vString .= "<option value='".$vYNValueArray[$o]."'";
										if($vYNValueArray[$o] == $vResults[36][$x]){
											$vString .= " selected";
										}
									$vString .= ">".$vYNTextArray[$o]."</option>";
								}
							$vString .= "</select><br>";
							$vString .= "<input type='date' name='tv_date_".$vResults[0][$x]."' id='tv_date_".$vResults[0][$x]."' value='".$vResults[37][$x]."' class='small xnarrow' size='4'>";
						$vString .= "</td>";//tv - tv date

						$vString .= "<td><span class='hidden-input'>".$vResults[40][$x]."</span>";
							$vString .= "<select class='small' id='rr_".$vResults[0][$x]."' name='rr_".$vResults[0][$x]."'>";
								for($o = 0; $o < count($vYNValueArray); $o++){
									$vString .= "<option value='".$vYNValueArray[$o]."'";
										if($vYNValueArray[$o] == $vResults[39][$x]){
											$vString .= " selected";
										}
									$vString .= ">".$vYNTextArray[$o]."</option>";
								}
							$vString .= "</select><br>";
							$vString .= "<input type='date' name='rr_date_".$vResults[0][$x]."' id='rr_date_".$vResults[0][$x]."' value='".$vResults[40][$x]."' class='small xnarrow' size='4'>";
						$vString .= "</td>";//rooirose - rr date

						$vString .= "<td class='dt-body-center'>";
						if($pData['type'] != "searchBookPublisher"){
							(!empty($vResults[6][$x]) ? $vString .=  "<img src='../images/books/".$vResults[6][$x]."' class='thumb'>" : $vString .= "");
						}
						else{
							(!empty($vResults[6][$x]) ? $vString .=  "<i class='fa fa-check green' aria-hidden='true'></i>" : $vString .= "<i class='fa fa-times red' aria-hidden='true'></i>");
						}
						$vString .= "</td>";//cover
					$vString .= "</tr>";
				}
			}
			else {
				$vString .= "<tr>";
					$vString .= "<td colspan='20'>Geen data gevind</td>";
					$vString .= "</tr>";
			}
				$vString .= "</tbody>";
			$vString .= "</table>";
	return General::prepareStringForDisplay($vString, $pConn);
	}

	public static function echoBookPerId($pConn, $pData){
		$vString = "";
		$vBindParams = array();
		$vBindLetters = "";
		$vWhere = "WHERE b.id =  ?";
		$vOrder = "";
		$vValue = $pData['id'];
		$vBindLetters .= "i";
		$vBindParams[] = & $vValue;

		$vResults = MysqlQuery::getBooks($pConn, $vWhere, $vOrder, $vBindLetters, $vBindParams, "LIMIT 1");

		include "include/BookLookupForms.php";
		if($pData['type'] == "add"){
			$vHeading = "LAAI NUWE BOEK";
			$vSectionId = 1;
			$vAuthor = "";
		}
		else if($pData['type'] == "add_stat"){
			$vHeading = "LAAI NUWE ITEM";
			$vSectionId = 3;
			$vLanguage = 'en';
			$vAuthor = "-";
		}
		if($pData['type'] == "edit" && $vResults[41][0] == 1){
			$vSectionId = 1;
			$vHeading = "VERANDER BOEK";
			$vLanguage = $vResults[18][0];
			$vAuthor = $vResults[21][0];
		}
		else if($pData['type'] == "edit"  && $vResults[41][0] == 3){
			$vSectionId = 3;
			$vHeading = "VERANDER ITEM";
			$vLanguage = 'en';
			$vAuthor = $vResults[21][0];
		}
		$vString .= "<article>";
			$vString .= "<h1>".$vHeading."</h1>";
			if(isset($_SESSION['SessionGrafCmsMessage']) && !empty($_SESSION['SessionGrafCmsMessage'])){
				$vString .= "<h5>".$_SESSION['SessionGrafCmsMessage']."</h5>";
				unset($_SESSION['SessionGrafCmsMessage']);
			}
			$vString .= "<form name='bookForm' id='bookForm' method='post' enctype='multipart/form-data' action='book_process.php'>";
				$vString .= "<div class='border'>";
					$vString .= "<label for='language'>Taal:</label>";
					$vLanguageValue = array('af', 'en');
					$vLanguageDisplay = array('Afrikaans', 'Engels');
					$vString .= General::returnSelect($pConn, (isset($vLanguage) ? $vLanguage : ''), "language", "language", $vLanguageValue, $vLanguageDisplay, "", 1, "required");
					$vString .= "<span class='compulsory'><i class='fa fa-asterisk' aria-hidden='true'></i></span>";
				$vString .= "</div>";
				$vString .= "<div class='border'>";
					$vString .= "<label for='isbn'>".($vSectionId == 1 ? "ISBN:" : "SKU:")."</label>";
					$vString .= General::returnInput($pConn, "text", "isbn", "isbn", (isset($vResults[1][0]) ? $vResults[1][0] : '') , 20, 20, "", "", "required", "", "");
					$vString .= "<input type='hidden' name='current_isbn' id='current_isbn' value='".(isset($vResults[1][0]) ? $vResults[1][0] : '')."'>";
					$vString .= "<span class='compulsory'><i class='fa fa-asterisk' aria-hidden='true'></i></span>";
					$vString .= "<div>";
						  $vString .= "<div id='isbn_exist' class='error' style='display:none;'>Die ISBN bestaan reeds in die databasis.</div>";
					$vString .= "</div>";
				$vString .= "</div>";
				$vString .= "<div class='border'>";
					$vString .= "<label for='title'>".($vSectionId == 1 ? "Titel:" : "Name:")."</label>";
					$vString .= General::returnInput($pConn, "text", "title", "title", (isset($vResults[4][0]) ? $vResults[4][0] : ''),100, 100, "", "", "required", "", "");
					$vString .= "<span class='compulsory'><i class='fa fa-asterisk' aria-hidden='true'></i></span>";
				$vString .= "</div>";
				$vString .= "<div class='border'>";
					$vString .= "<label for='category'>Kategorie:</label>";
					$vCategories = MysqlQuery::getAllCategoriesPerSection($pConn, $vSectionId, 1);
					$vString .= General::returnSelect($pConn, (isset($vResults[2][0]) ? $vResults[2][0]: ''), "category", "category", $vCategories[0], $vCategories[1], "", 1, "required");
					$vString .= "<span class='compulsory'><i class='fa fa-asterisk' aria-hidden='true'></i></span>";
				$vString .= "</div>";
				$vString .= "<div class='border'>";
					$vString .= "<label for='sub_category'>Sub-kategorie:</label>";
                    if(isset($vResults[2][0])) {
                        $vSubCategories = MysqlQuery::getAllSubCategoriesPerCategory($pConn, $vResults[2][0], 1);//$vSubCategoryId, $vSubCategory
                        $vString .= General::returnSelect($pConn, (isset($vResults[3][0]) ? $vResults[3][0] : ''), "sub_category", "sub_category", $vSubCategories[0], $vSubCategories[1], "", 1, "required");
                    }
                    else {
                        $vString .= "<select name='sub_category' id='sub_category' class='small'></select>";
                    }
					$vString .= "<span class='compulsory'><i class='fa fa-asterisk' aria-hidden='true'></i></span>";
				$vString .= "</div>";
				$vString .= "<div class='border'>";
					$vString .= "<label for='author'>".($vSectionId == 1 ? "Outeur:" : "Graffiti note:")."</label>";
					$vString .= General::returnInput($pConn, "text", "author", "author", (isset($vAuthor) ? $vAuthor : ''), 100, 150, "", "", ($vSectionId == 1 ? "required:" : ""), "", "");
					if($vSectionId == 1){
						$vString .= "<div class='message-bottom'><i class='fa fa-hand-o-right space-right' aria-hidden='true'></i> Tik alle Outeur name in met 'n , tussen die name (GEEN SPASIES) bv. Engela Riekerd,Laura Arnesen,Marie Wivel</div>";
					}
				$vString .= "</div>";
				if($vSectionId == 1){
					$vString .= "<div class='border'>";
						$vString .= "<label for='illustrator'>Illustreerder</label>";
						$vString .= General::returnInput($pConn, "text", "illustrator", "illustrator", (isset($vResults[22][0]) ? $vResults[22][0] : ''),50, 50, "", "", "", "", "");
							$vString .= "<div class='message-bottom'><i class='fa fa-hand-o-right space-right' aria-hidden='true'></i> Tik alle Illustreerder name in met 'n , tussen die name (GEEN SPASIES) bv. Engela Riekerd,Laura Arnesen,Marie Wivel</div>";
					$vString .= "</div>";
				}
				$vString .= "<div class='border'>";
					$vString .= "<label for='translator'>".($vSectionId == 1 ? "Vertaler:" : "Brand name:")."</label>";
					$vString .= General::returnInput($pConn, "text", "translator", "translator", (isset($vResults[23][0]) ? $vResults[23][0] : ''),50, 50, "", "", "", "", "");
					if($vSectionId == 1){
						$vString .= "<div class='message-bottom'><i class='fa fa-hand-o-right space-right' aria-hidden='true'></i>Tik alle Vertaler name in met 'n , tussen die name (GEEN SPASIES) bv. Engela Riekerd,Laura Arnesen,Marie Wivel</div>";
					}
				$vString .= "</div>";
				$vString .= "<div class='border'>";
				if($vSectionId == 1){
					$vString .= "<label for='publisher'>Uitgewer:</label>";
					$vPublishers = MysqlQuery::getPublishers($pConn);
					$vString .= General::returnSelect($pConn, (isset($vResults[17][0]) ? $vResults[17][0] : ''), "publisher", "publisher", $vPublishers[0], $vPublishers[3], "", 1, "");
				}
				else if($vSectionId == 3){
					$vString .= "<label for='publisher'>Supplier:</label>";
					$vSupplier = MysqlQuery::getStationarySuppliers($pConn);
					$vString .= General::returnSelect($pConn, $vResults[17][0], "publisher", "publisher", $vSupplier[0], $vSupplier[1], "updateSelectString('publisher');", 1, "required");
					$vString .= "<input type='hidden' name='illustrator' id='illustrator' value='".$vResults[22][0]."'>";
				}
					$vString .= "<span class='compulsory'><i class='fa fa-asterisk' aria-hidden='true'></i></span>";
				$vString .= "</div>";
				$vString .= "<div class='border'>";
					$vString .= "<label for='summary'>".($vSectionId == 1 ? "Opsomming:" : "Description:")."</label>";
					$vString .= General::returnTextarea($pConn, "summary", "summary", (isset($vResults[5][0]) ? General::prepareStringForInputDisplay($vResults[5][0]) : ''), 130, 10, 3000, "", "");
				$vString .= "</div>";
				$vString .= "<div class='border'>";
					$vString .= "<label for='language'>".($vSectionId == 1 ? "Prys:" : "Retail price:")."</label>";
					$vString .= "R ".General::returnInput($pConn, "text", "price", "price", (isset($vResults[8][0]) ? $vResults[8][0] : ''), 6,6, "", "", "required", "", "");
					$vString .= "<span class='compulsory'><i class='fa fa-asterisk' aria-hidden='true'></i></span>";
					$vString .= "<div>";
						  $vString .= "<div id='priceError' class='error' style='display:none;'>Slegs getalle word toegelaat bv. 100.<br>Verwyder alle punte(.), spasies en kommas(,)!</div>";
					$vString .= "</div>";
				$vString .= "<div class='border'>";
					$vString .= "<label for='language'>".($vSectionId == 1 ? "Kosprys:" : "Cost price:")."</label>";
					$vString .= "R ".General::returnInput($pConn, "text", "cost_price", "cost_price", (isset($vResults[38][0]) ? $vResults[38][0] : ''), 6,6, "", "", "", "", "");
				$vString .= "</div>";
				$vString .= "</div>";
				if($vSectionId == 1){
					$vString .= "<div class='border'>";
						$vString .= "<label for='date_publish'>Publikasie datum:</label>";
						$vString .= "<input type='date' class='small' name='date_publish' id='date_publish' value='".(isset($vResults[25][0]) ? $vResults[25][0] : '')."'>";
						$vString .= "<span class='compulsory'><i class='fa fa-asterisk' aria-hidden='true'></i></span>";
					$vString .= "</div>";
				}
				else {
					$vString .= "<input type='hidden' name='date_publish' id='date_publish' value='".$_SESSION['now_date']."'>";
				}
				$vString .= "<div class='no-border'>";
					$vString .= "<label for='special_price'>".($vSectionId == 1 ? "Winskopie prys:" : "Special price:")."</label>";
					$vString .= "R ".General::returnInput($pConn, "text", "special_price", "special_price", (isset($vResults[7][0]) ? $vResults[7][0] : ''), 6, 6, "", "", "required", "", "");
					$vString .= "<div>";
						  $vString .= "<div id='specialPriceError' class='error' style='display:none;'>Slegs getalle word toegelaat bv. 100.<br>Verwyder alle punte(.), spasies en kommas(,)!</div>";
					$vString .= "</div>";
				$vString .= "</div>";
				if($vSectionId == 1){
					$vString .= "<div class='border'>";
						(isset($vResults[12][0]) && $vResults[12][0] == 1 ? $vSpecialChecked = "checked" : $vSpecialChecked = "");
						$vString .= "<label for='special'>Winskopie:</label>";
						$vString .= "<input type='checkbox' name='special' id='special' value='1' ".$vSpecialChecked.">";
					$vString .= "</div>";
					$vString .= "<div class='border'>";
						$vString .= "<label for='special_price'>Auto afslag:</label>";
						$vString .= "R ".General::returnInput($pConn, "text", "default_discount", "default_discount", (isset($vResults[26][0]) ? $vResults[26][0] : ''), 6, 6, "", "", "required", "", "")."&nbsp;e.g.&nbsp;0.2";
						$vString .= "<div>";
							  $vString .= "<div id='defaultDiscountError' class='error' style='display:none;'>Slegs getalle word toegelaat bv. 100.<br>Verwyder alle punte(.), spasies en kommas(,)!</div>";
						$vString .= "</div>";
					$vString .= "</div>";
					$vString .= "<div class='no-border'>";
						(isset($vResults[34][0]) && $vResults[34][0] == 1 ? $vSoonChecked = "checked" : $vSoonChecked = "");
						$vString .= "<label for='new'>TUIS Binnekort:</label>";
						$vString .= "<input type='checkbox' name='soon' id='soon' value='1' ".$vSoonChecked.">";
					$vString .= "</div>";
					$vString .= "<div>";
						(isset($vResults[32][0]) && $vResults[32][0] == 1 ? $vSoonChecked = "checked" : $vSoonChecked = "");
						$vString .= "<label for='soon_discount'>Binnekort afslag:</label>";
						$vString .= "<input type='checkbox' name='soon_discount' id='soon_discount' value='1' ".$vSoonChecked.">";
					$vString .= "</div>";
					$vString .= "<div class='border'>";
						$vRankNumber = range(1, 15);
						$vString .= "<label for='soon_rank'>Binnekort posisie:</label>";
						$vString .= General::returnInput($pConn, "text", "soon_rank", "soon_rank", (isset($vResults[33][0]) ? $vResults[33][0] : ''), 5, 5, "", "", "", "", "");
					$vString .= "</div>";
					$vString .= "<div>";
						(isset($vResults[11][0]) && $vResults[11][0] == 1 ? $vNewChecked = "checked" : $vNewChecked = "");
						$vString .= "<label for='new'>TUIS Nuut:</label>";
						$vString .= "<input type='checkbox' name='new' id='new' value='1' ".$vNewChecked.">";
					$vString .= "</div>";
					$vString .= "<div class='border'>";
						$vRankNumber = range(1, 15);
						$vString .= "<label for='new_rank'>Nuut posisie:</label>";
						$vString .= General::returnInput($pConn, "text", "new_rank", "new_rank", (isset($vResults[31][0]) ? $vResults[31][0] : ''), 5, 5, "", "", "", "", "");
					$vString .= "</div>";
					$vString .= "<div class='no-border'>";
						(isset($vResults[13][0]) && $vResults[13][0] == 1 ? $vTopChecked = "checked" : $vTopChecked = "");
						$vString .= "<label for='top_seller'>Topverkoper:</label>";
						$vString .= "<input type='checkbox' name='top_seller' id='top_seller' value='1' ".$vTopChecked.">";
					$vString .= "</div>";
					$vString .= "<div class='border'>";
						$vRankNumber = range(1, 15);
						$vString .= "<label for='top_seller_rank'>Topverkoper posisie:</label>";
						$vString .= General::returnSelect($pConn, (isset($vResults[14][0]) ? $vResults[14][0] : ''), "top_seller_rank", "top_seller_rank", $vRankNumber, $vRankNumber, "", 3, "");
					$vString .= "</div>";
					$vString .= "<div class='border'>";
						($vResults[15][0] == 1 ? $vOutChecked = "checked" : $vOutChecked = "");
						$vString .= "<label for='out_of_print'>Uit druk:</label>";
						$vString .= "<input type='checkbox' name='out_of_print' id='out_of_print' value='1' ".$vOutChecked.">";
					$vString .= "</div>";
				}
				$vString .= "<div class='border'>";
					$vString .= "<label for='in_stock'>".($vSectionId == 1 ? "Voorraad:" : "In stock:")."</label>";
					$vString .= General::returnInput($pConn, "text", "in_stock", "in_stock", $vResults[16][0], 5, 5, "", "", "required", "", "");
				$vString .= "</div>";
				$vString .= "<div class='border'>";
					$vString .= "<label for='in_stock'>".($vSectionId == 1 ? "Dimensies (H x W):" : "Code:")."</label>";
					$vString .= General::returnInput($pConn, "text", "dimensions", "dimensions", $vResults[27][0], 25, 25, "", "", "required", "", "");
				$vString .= "</div>";
				if($vSectionId == 1){
					$vString .= "<div class='border'>";
						$vString .= "<label for='in_stock'>Gewig:</label>";
						$vString .= General::returnInput($pConn, "text", "weight", "weight", $vResults[28][0], 10, 10, "", "", "required", "", "")."&nbsp;gram";
					$vString .= "</div>";
					$vString .= "<div class='border'>";
						$vFormat = MysqlQuery::getCmsLookup($pConn, "book_format");
						$vString .= "<label for='in_stock'>Formaat:</label>";
							$vString .= "<select class='small' id='format' name='format'>";
								$vString .= "<option value='0'>Kies</option>";
								for($f = 0; $f < count($vFormat[0]); $f++){
									$vString .= "<option value='".$vFormat[0][$f]."'";
										if($vFormat[0][$f] == $vResults[29][0]){
											$vString .= " selected";
										}
									$vString .= ">".$vFormat[1][$f]."</option>";
								}
							$vString .= "</select>";
					$vString .= "</div>";
					$vString .= "<div class='border'>";
						$vString .= "<label for='in_stock'>Aantal bladsye:</label>";
						$vString .= General::returnInput($pConn, "text", "pages", "pages", $vResults[30][0], 10, 5, "", "", "required", "", "");
					$vString .= "</div>";
				}
				if(!empty($vResults[6][0])){
					$vString .= "<div class='border'>";
						$vString .= "<label for='deleteBookImage'>".($vSectionId == 1 ? "Voorblad:" : "Image:")."</label>";
							$vString .= "<a href='#'  id='deleteBookImage' data-id='".$vResults[0][0]."' data-path='".$vResults[6][0]."' ".General::echoTooltip("right", "Vee boek prent uit")."<i class='fa fa-times fa-lg space left red' aria-hidden='true'></i></a>";
							$vString .= "<figure class='border'>";
								$vString .= "<a href='../images/books/".$vResults[6][0]."' data-lightbox='".$vResults[6][0]."' title='".$vResults[4][0]."'>";
									$vString .= "<img class='img-responsive' src='../images/books/".$vResults[6][0]."' class='thumb'>";
								$vString .= "</a>";
								$vString .= "<input type='hidden' name='current_blob_path' id='current_blob_path' value='".$vResults[6][0]."'>";
							$vString .= "</figure>";
					$vString .= "</div>";
				}
				$vString .= "<div class='border'>";
					if($pData['type'] == "edit"){
						$vString .= "<label for='blob_path'>".($vSectionId == 1 ? "Verander Voorblad:" : "Change image:")."</label>";
					}
					else {
						$vString .= "<label for='blob_path'>".($vSectionId == 1 ? "Voorblad:" : "Image:")."</label>";
					}
					$vString .= "<label for='url-file'></label>";
					$vString .= "<input type='file' class='small' name='blob_path' id='blob_path' accept='.gif,.jpg,.jpeg,.png' value='' size='50' maxlength='50'>";
					$vString .= "<div>";
						  $vString .= "<div id='fileError' class='error' style='display:none;'>Slegs .gif, .jpg, .jpeg, .png prente toegelaat</div>";
						  $vString .= "<div id='fileSizeError' class='error' style='display:none;'>Die voorblad is te groot. Slegs 1MB l&#234;ergrootte word toegelaat!</div>";
					$vString .= "</div>";
				$vString .= "</div>";
				$vString .= "<div>";
					$vString .= "<div class='message-bottom'><span class='compulsory'><i class='fa fa-asterisk' aria-hidden='true'></i></span> Verpligte velde</div>";
				$vString .= "</div>";

	            $vString .= "<div>";
					  $vString .= "<div id='submitError' class='error' style='display:none;'>Voltooi asseblief die verpligte velde</div>";
				$vString .= "</div>";

				$vString .= "<div>";
					$vString .= "<input type='button' id='submitBook' value='Stoor'>";
//					$vString .= "<input type='button' id='backButton' value='Terug'>";
				$vString .= "</div>";

				$vString .= "<input type='hidden' name='section' value='".$vSectionId."'>";
				$vString .= "<input type='hidden' name='id' value='".$vResults[0][0]."'>";
				$vString .= "<input type='hidden' name='page' value='books'>";
				$vString .= "<input type='hidden' name='type' id='type' value='".$pData['type']."-sql'>";
				$vString .= "<input type='hidden' name='edit_by' id='edit_by' value='".$_SESSION['SessionGrafCmsUserId']."'>";
			$vString .= "</form>";
		$vString .= "</article>";
	return General::prepareStringForDisplay($vString, $pConn);
	}

	public static function echoLanding($pConn, $pData){
		$vBindParams = array();
		$vBindLetters = "";
		if($pData['type'] == "new" || $pData['type'] == "nuut"){
			($pData['type'] == "nuut" ? $vLanguage = 'af' : $vLanguage = 'en');
			$vWhere = "WHERE b.new =  ? AND b.language = ? AND b.category != 4 AND b.category != 5 AND b.category != 8 AND b.category != 9 AND  b.category != 7 AND b.category != 6";
			$vOrder = " ORDER BY b.new_rank ASC";
			$vValue = 1;
			$vBindLetters .= "i";
			$vBindParams[] = & $vValue;
			$vBindLetters .= "s";
			$vBindParams[] = & $vLanguage;
			$vTableId = "booksLandingNewTable";
			$vLimit = "";
		}
		else if($pData['type'] == "nuut-c"){
			$vWhere = "WHERE b.new =  ? AND (b.category = 4 or b.category = 5 or b.category = 8 or b.category = 9 or b.category = 7 or b.category = 6)";
			$vOrder = " ORDER BY b.new_rank ASC";
			$vValue = 1;
			$vBindLetters .= "i";
			$vBindParams[] = & $vValue;
			$vTableId = "booksLandingNewTable";
			$vLimit = "";
		}
		else if($pData['type'] == "top" || $pData['type'] == "best"){
			($pData['type'] == "top" ? $vLanguage = 'af' : $vLanguage = 'en');
			$vWhere = "WHERE b.top_seller =  ? AND b.language = ? AND b.category != 4 AND b.category != 5 AND b.category != 8 AND b.category != 9 AND b.category != 7 AND b.category != 6";
			$vOrder = " ORDER BY b.top_seller_rank ASC";
			$vValue = 1;
			$vBindLetters .= "i";
			$vBindParams[] = & $vValue;
			$vBindLetters .= "s";
			$vBindParams[] = & $vLanguage;
			$vTableId= "booksLandingTopTable";
			$vLimit = "";
		}
		else if($pData['type'] == "top-c"){
			($pData['type'] == "top" ? $vLanguage = 'af' : $vLanguage = 'en');
			$vWhere = "WHERE b.top_seller =  ? AND (b.category = 4 or b.category = 5 or b.category = 8 or b.category = 9 or b.category = 7 or b.category = 6)";
			$vOrder = " ORDER BY b.top_seller_rank ASC";
			$vValue = 1;
			$vBindLetters .= "i";
			$vBindParams[] = & $vValue;
			$vTableId= "booksLandingTopTable";
			$vLimit = "";
		}
		else if($pData['type'] == "specials"){
			$vWhere = "WHERE b.special =  ? and special_rank > ?";
//			$vOrder = " ORDER BY b.special_rank ASC"; Leonie vra via whatsapp op 27/01/2022
			$vOrder = " ORDER BY b.in_stock DESC";
			$vValue = 1;
			$vValue2 = -1;
			$vBindLetters .= "ii";
			$vBindParams[] = & $vValue;
			$vBindParams[] = & $vValue2;
			$vTableId= "booksLandingSpecialsTable";
			$vLimit = "";
		}
		else if($pData['type'] == "soon"){
			$vValue = 1;
			$vWhere = "WHERE b.date_publish > ? AND soon = ?";
			$vOrder = " ORDER BY b.soon DESC, b.soon_rank ASC, b.date_publish ASC";
			$vBindLetters .= "s";
			$vBindParams[] = & $_SESSION['now_date'];
			$vBindLetters .= "i";
			$vBindParams[] = & $vValue;
			$vTableId= "booksLandingSoonTable";
			$vLimit = "";
		}
		else if($pData['type'] == "soon_50"){
			$vWhere = "WHERE b.date_publish >  ?";
			//$vOrder = " ORDER BY b.soon DESC, b.soon_rank ASC, b.date_publish ASC";
			$vOrder = " ORDER BY b.date_publish ASC, b.soon DESC, b.soon_rank ASC";
			$vValue = $_SESSION['now_date'];
			$vBindLetters .= "s";
			$vBindParams[] = & $_SESSION['now_date'];
			$vLimit = "LIMIT 300";
			$vTableId= "booksLandingSoon50Table";
		}
		$_SESSION['SessionGrafCmsReturnUrl'] = General::getUrlParameters();
		$vFormat = MysqlQuery::getCmsLookup($pConn, "book_format");
		$vResults = MysqlQuery::getBooks($pConn, $vWhere, $vOrder, $vBindLetters, $vBindParams, $vLimit);
		$vString = "<h1>Boeke</h1>";
		$vString .= "<h5>(".count($vResults[0]).")</h5>";
		$vString .= "<div id='query-message'></div>";

		$vString .= "<table id='".$vTableId."' class='cell-border dataTable hover' cellspacing='0'>";
			$vString .= "<thead>";
				$vString .= "<tr class='red'>";
					include "include/LandingBookTableHeadings.php";
				$vString .= "</tr>";
			$vString .= "</thead>";
			$vString .= "<tfoot>";
				$vString .= "<tr class='red'>";
					include "include/LandingBookTableHeadings.php";
				$vString .= "</tr>";
			$vString .= "</tfoot>";
			$vString .= "<tbody>";
			if(count($vResults[0]) > 0){
				for($x = 0; $x < count($vResults[0]); $x++){
					$vYNValueArray = array(1, 0);
					$vYNTextArray = array("J", "N");
					$vPublishers = MysqlQuery::getPublishers($pConn);//$vPubId, $vPub, $vPubSupplier
					$vString .= "<tr id='tr_".$vResults[0][$x]."'>";
						if($pData['type'] == "new" || $pData['type']  == "nuut" || $pData['type']  == "nuut-c"){
							$vString .= "<td class='dt-body-center green' style='cursor: move;'>".$vResults[31][$x]."</td>";//new_rank
							$vString .= "<td class='dt-body-center'>";
								$vString .= "<select class='small' id='new_".$vResults[0][$x]."' name='new_".$vResults[0][$x]."'>";
									for($n = 0; $n < count($vYNValueArray); $n++){
										$vString .= "<option value='".$vYNValueArray[$n]."'";
											if($vYNValueArray[$n] == $vResults[11][$x]){
												$vString .= " selected";
											}
										$vString .= ">".$vYNTextArray[$n]."</option>";
									}
								$vString .= "</select>";
							$vString .= "</td>";//new
							$vString .= "<td class='dt-body-center'>".General::returnYesNo($vResults[32][$x])."<br>".$vResults[33][$x]."</span>";
								$vString .= "<input type='hidden' id='soon_".$vResults[0][$x]."' name='soon_".$vResults[0][$x]."' value='".$vResults[32][$x]."'>";
								$vString .= "<input type='hidden' id='soon_discount_".$vResults[0][$x]."' name='soon_discount_".$vResults[0][$x]."' value='".$vResults[33][$x]."'>";
							$vString .= "</td>";//soon_discount && soon_rank
							$vString .= "<td class='dt-body-center'>".General::returnYesNo($vResults[13][$x])."<br>".$vResults[14][$x]."</span>";
								$vString .= "<input type='hidden' id='top_seller_".$vResults[0][$x]."' name='top_seller_".$vResults[0][$x]."' value='".$vResults[13][$x]."'>";
								//$vString .= "<input type='hidden' id='top_seller_rank_".$vResults[0][$x]."' name='top_seller_rank_".$vResults[0][$x]."' value='".$vResults[14][$x]."'>";
							$vString .= "</td>";//topseller & top_seller_rank
							$vString .= "<td><span class='hidden-input'>".$vResults[12][$x]."</span>";
								$vString .= "<select class='small' id='special_".$vResults[0][$x]."' name='special_".$vResults[0][$x]."'>";
									for($s = 0; $s < count($vYNValueArray); $s++){
										$vString .= "<option value='".$vYNValueArray[$s]."'";
											if($vYNValueArray[$s] == $vResults[12][$x]){
												$vString .= " selected";
											}
										$vString .= ">".$vYNTextArray[$s]."</option>";
									}
								$vString .= "</select><br>";
								$vString .= "<input type='text' name='special_price_".$vResults[0][$x]."' id='special_price_".$vResults[0][$x]."' value='".$vResults[7][$x]."' class='small' size='4'>";
							$vString .= "</td>";//special - special price
						}
						else if($pData['type']  == "soon" || $pData['type']  == "soon_50"){
							$vString .= "<td class='dt-body-center green' style='cursor: move;'>".$vResults[33][$x]."</td>";//soon_rank
							$vString .= "<td class='dt-body-center'><span class='hidden-input'>".$vResults[34][$x]."</span>";
								$vString .= "<select class='small' id='soon_".$vResults[0][$x]."' name='soon_".$vResults[0][$x]."'>";
									for($n = 0; $n < count($vYNValueArray); $n++){
										$vString .= "<option value='".$vYNValueArray[$n]."'";
											if($vYNValueArray[$n] == $vResults[34][$x]){
												$vString .= " selected";
											}
										$vString .= ">".$vYNTextArray[$n]."</option>";
									}
								$vString .= "</select>";
							$vString .= "</td>";//soon
							$vString .= "<td class='dt-body-center'><span class='hidden-input'>".$vResults[32][$x]."</span>";
								$vString .= "<select class='small' id='soon_discount_".$vResults[0][$x]."' name='soon_discount_".$vResults[0][$x]."'>";
									for($n = 0; $n < count($vYNValueArray); $n++){
										$vString .= "<option value='".$vYNValueArray[$n]."'";
											if($vYNValueArray[$n] == $vResults[32][$x]){
												$vString .= " selected";
											}
										$vString .= ">".$vYNTextArray[$n]."</option>";
									}
								$vString .= "</select>";
							$vString .= "</td>";//soon_discount
							$vString .= "<td class='dt-body-center'>".General::returnYesNo($vResults[11][$x])."<br>".$vResults[31][$x]."</span>";
								$vString .= "<input type='hidden' id='new_".$vResults[0][$x]."' name='new_".$vResults[0][$x]."' value='".$vResults[11][$x]."'>";
							$vString .= "</td>";//new && new_rank
							$vString .= "<td class='dt-body-center'>".General::returnYesNo($vResults[13][$x])."<br>".$vResults[14][$x]."</span>";
								$vString .= "<input type='hidden' id='top_seller_".$vResults[0][$x]."' name='top_seller_".$vResults[0][$x]."' value='".$vResults[13][$x]."'>";
								//$vString .= "<input type='hidden' id='top_seller_rank_".$vResults[0][$x]."' name='top_seller_rank_".$vResults[0][$x]."' value='".$vResults[14][$x]."'>";
							$vString .= "</td>";//topseller & top_seller_rank
							$vString .= "<td><span class='hidden-input'>".$vResults[12][$x]."</span>";
								$vString .= "<select class='small' id='special_".$vResults[0][$x]."' name='special_".$vResults[0][$x]."'>";
									for($s = 0; $s < count($vYNValueArray); $s++){
										$vString .= "<option value='".$vYNValueArray[$s]."'";
											if($vYNValueArray[$s] == $vResults[12][$x]){
												$vString .= " selected";
											}
										$vString .= ">".$vYNTextArray[$s]."</option>";
									}
								$vString .= "</select><br>";
								$vString .= "<input type='text' name='special_price_".$vResults[0][$x]."' id='special_price_".$vResults[0][$x]."' value='".$vResults[7][$x]."' class='small' size='4'>";
							$vString .= "</td>";//special - special price
						}
						else if($pData['type'] == "top" || $pData['type'] == "best" || $pData['type'] == "top-c"){
							$vString .= "<td class='dt-body-center green' style='cursor: move;'>".$vResults[14][$x]."</td>";//rank
							$vString .= "<td class='dt-body-center'>";
								$vString .= "<select class='small' id='top_seller_".$vResults[0][$x]."' name='top_seller_".$vResults[0][$x]."'>";
									for($t = 0; $t < count($vYNValueArray); $t++){
										$vString .= "<option value='".$vYNValueArray[$t]."'";
											if($vYNValueArray[$t] == $vResults[13][$x]){
												$vString .= " selected";
											}
										$vString .= ">".$vYNTextArray[$t]."</option>";
									}
								$vString .= "</select>";
							$vString .= "</td>";//topseller
							$vString .= "<td class='dt-body-center'>".General::returnYesNo($vResults[11][$x])."<br>".$vResults[31][$x]."</span>";
								$vString .= "<input type='hidden' id='new_".$vResults[0][$x]."' name='new_".$vResults[0][$x]."' value='".$vResults[11][$x]."'>";
							$vString .= "</td>";//new && new_rank
							$vString .= "<td class='dt-body-center'>".General::returnYesNo($vResults[32][$x])."<br>".$vResults[33][$x]."</span>";
								$vString .= "<input type='hidden' id='soon_".$vResults[0][$x]."' name='soon_".$vResults[0][$x]."' value='".$vResults[32][$x]."'>";
								$vString .= "<input type='hidden' id='soon_discount_".$vResults[0][$x]."' name='soon_discount_".$vResults[0][$x]."' value='".$vResults[33][$x]."'>";
							$vString .= "</td>";//soon_discount && soon_rank
							$vString .= "<td><span class='hidden-input'>".$vResults[12][$x]."</span>";
								$vString .= "<select class='small' id='special_".$vResults[0][$x]."' name='special_".$vResults[0][$x]."'>";
									for($s = 0; $s < count($vYNValueArray); $s++){
										$vString .= "<option value='".$vYNValueArray[$s]."'";
											if($vYNValueArray[$s] == $vResults[12][$x]){
												$vString .= " selected";
											}
										$vString .= ">".$vYNTextArray[$s]."</option>";
									}
								$vString .= "</select><br>";
								$vString .= "<input type='text' name='special_price_".$vResults[0][$x]."' id='special_price_".$vResults[0][$x]."' value='".$vResults[7][$x]."' class='small' size='4'>";
							$vString .= "</td>";//special - special price
						}
						else if( $pData['type'] == "specials"){
							$vString .= "<td class='dt-body-center green' style='cursor: move;'>".$vResults[35][$x]."</td>";//special_rank
							$vString .= "<td><span class='hidden-input'>".$vResults[12][$x]."</span>";
								$vString .= "<select class='small' id='special_".$vResults[0][$x]."' name='special_".$vResults[0][$x]."'>";
									for($s = 0; $s < count($vYNValueArray); $s++){
										$vString .= "<option value='".$vYNValueArray[$s]."'";
											if($vYNValueArray[$s] == $vResults[12][$x]){
												$vString .= " selected";
											}
										$vString .= ">".$vYNTextArray[$s]."</option>";
									}
								$vString .= "</select><br>";
								$vString .= "<input type='text' name='special_price_".$vResults[0][$x]."' id='special_price_".$vResults[0][$x]."' value='".$vResults[7][$x]."' class='small' size='4'>";
							$vString .= "</td>";//special - special price
							$vString .= "<td class='dt-body-center'>".General::returnYesNo($vResults[11][$x])."<br>".$vResults[31][$x]."</span>";
								$vString .= "<input type='hidden' id='new_".$vResults[0][$x]."' name='new_".$vResults[0][$x]."' value='".$vResults[11][$x]."'>";
							$vString .= "</td>";//new && new_rank
							$vString .= "<td class='dt-body-center'>".General::returnYesNo($vResults[32][$x])."<br>".$vSoonRank."</span>";
								$vString .= "<input type='hidden' id='soon_".$vResults[0][$x]."' name='soon_".$vResults[0][$x]."' value='".$vResults[32][$x]."'>";
								$vString .= "<input type='hidden' id='soon_discount_".$vResults[0][$x]."' name='soon_discount_".$vResults[0][$x]."' value='".$vResults[33][$x]."'>";
							$vString .= "</td>";//soon_discount && soon_rank
							$vString .= "<td class='dt-body-center'>".General::returnYesNo($vResults[13][$x])."<br>".$vTopRank."</span>";
								$vString .= "<input type='hidden' id='top_seller_".$vResults[0][$x]."' name='top_seller_".$vResults[0][$x]."' value='".$vResults[13][$x]."'>";
								//$vString .= "<input type='hidden' id='top_seller_rank_".$vResults[0][$x]."' name='top_seller_rank_".$vResults[0][$x]."' value='".$vResults[14][$x]."'>";
							$vString .= "</td>";//topseller & top_seller_rank
						}
						$vString .= "<td class='dt-body-center'>";
							$vString .= "<i class='fa fa-floppy-o fa-lg saveButton green' aria-hidden='true' id='saveBookButton_".$vResults[0][$x]."' data-id='".$vResults[0][$x]."' ".General::echoTooltip("left", "Stoor die veranderinge")."></i>";
							$vString .= "<br><i class='fa fa-pencil fa-lg green space-top' aria-hidden='true' id='editBookButton_".$vResults[0][$x]."' data-id='".$vResults[0][$x]."' ".General::echoTooltip("left", "Verander die info")."></i>";
							$vString .= "<br><i class='fa fa-times fa-lg red space-top' aria-hidden='true' id='deleteBookButton_".$vResults[0][$x]."' data-id='".$vResults[0][$x]."' ".General::echoTooltip("left", "Vee boek uit")."></i>";
						$vString .= "</td>";//manage
						$vString .= "<td>".$vResults[4][$x]."</td>";//title
						$vString .= "<td>".$vResults[1][$x]."</td>";//title
						$vString .= "<td><span class='green'>".str_replace(",", ", ", $vResults[21][$x])."</span><br><span class='red'>".str_replace(",", ", ",$vResults[22][$x])."</span><br><span class='dblue'>".str_replace(",", ", ",$vResults[23][$x])."</span></td>";//author - translator - illustrator
						$vString .= "<td>".$vResults[19][$x]."<i class='fa fa-caret-right fa-lg gray s-space-left s-space-right' aria-hidden='true'></i>".$vResults[20][$x]."</td>";//cat - sub-cat
						$vString .= "<td class='dt-body-center' id='side-by-side'>";
							(!empty($vResults[6][$x]) ? $vString .=  "<img src='../images/books/".$vResults[6][$x]."' class='thumb'>" : $vString .= "");
						$vString .= "</td>";//cover
						$vString .= "<td><span class='hidden-input'>".$vResults[8][$x]."</span>";
							$vString .= "<input type='text' name='price_".$vResults[0][$x]."' id='price_".$vResults[0][$x]."' value='".$vResults[8][$x]."' class='small' size='4'><br>";
							$vString .= "<input type='text' name='cost_price_".$vResults[0][$x]."' id='cost_price_".$vResults[0][$x]."' value='".$vResults[38][$x]."' class='small' size='4'><br>";
							$vString .= "<input type='text' name='default_discount_".$vResults[0][$x]."' id='default_discount_".$vResults[0][$x]."' value='".$vResults[26][$x]."' class='small' size='4'>";
						$vString .= "</td>";//price
						$vString .= "<td><span class='hidden-input'>".$vResults[25][$x]."</span>";
							$vString .= "<input type='date' name='pub_".$vResults[0][$x]."' id='pub_".$vResults[0][$x]."' value='".$vResults[25][$x]."' class='small' size='4'>";
						$vString .= "</td>";//publication date
						$vString .= "<td class='dt-body-center'><span class='hidden-input'>".$vResults[15][$x]."</span>";
							$vString .= "<select class='small' id='out_print_".$vResults[0][$x]."' name='out_print_".$vResults[0][$x]."'>";
								for($o = 0; $o < count($vYNValueArray); $o++){
									$vString .= "<option value='".$vYNValueArray[$o]."'";
										if($vYNValueArray[$o] == $vResults[15][$x]){
											$vString .= " selected";
										}
									$vString .= ">".$vYNTextArray[$o]."</option>";
								}
							$vString .= "</select>";
						$vString .= "</td>";//out of print
						$vString .= "<td><span class='hidden-input'>".$vResults[16][$x]."</span>";
							$vString .= "<input type='text' name='instock_".$vResults[0][$x]."' id='instock_".$vResults[0][$x]."' value='".$vResults[16][$x]."' class='small' size='4'>";
						$vString .= "</td>";//in_stock
						$vString .= "<td><span class='hidden-input'>".$vResults[17][$x]."</span>";
							$vString .= "<select class='small narrow' id='publisher_".$vResults[0][$x]."' name='out_print_".$vResults[0][$x]."'>";
								$vString .= "<option value='0'>Kies Uitgewer</option>";
								for($p = 0; $p < count($vPublishers[0]); $p++){
									$vString .= "<option value='".$vPublishers[0][$p]."'";
										if($vPublishers[0][$p] == $vResults[17][$x]){
											$vString .= " selected";
										}
									$vString .= ">".$vPublishers[1][$p]."</option>";
								}
							$vString .= "</select>";
							$vString .= "<input type='hidden' id='tv_".$vResults[0][$x]."' name='tv_".$vResults[0][$x]."' value='".$vResults[36][$x]."'>";//tv
							$vString .= "<input type='hidden' id='tv_date_".$vResults[0][$x]."' name='tv_date_".$vResults[0][$x]."' value='".$vResults[37][$x]."'>";//tv_date
							$vString .= "<input type='hidden' id='default_discount_".$vResults[0][$x]."' name='default_discount_".$vResults[0][$x]."' value='".$vResults[26][$x]."'>";//default_discount
						$vString .= "</td>";//publisher
						$vString .= "<td class='dt-body-center'>".$vResults[18][$x]."</td>";//language
						$vString .= "<td class='hidden-input'>".$vResults[0][$x]."</td>";//id
					$vString .= "</tr>";
				}
			}
			else {
				$vString .= "<tr>";
					$vString .= "<td colspan='22'>Geen data gevind</td>";
				$vString .= "</tr>";
			}
				$vString .= "</tbody>";
			$vString .= "</table>";

	return General::prepareStringForDisplay($vString, $pConn);
	}

	public static function echoLanguage($pConn){
		$vResults = MysqlQuery::getAllText($pConn);//$vId, $vAfrikaans, $vEnglish
		$vString = "<h1>Taal</h1>";
		$vString .= "<div id='query-message'></div>";
		$vString .= "<table id='languageTable' class='cell-border dataTable hover' cellspacing='0'>";
			$vString .= "<thead>";
				$vString .= "<tr class='red'>";
					$vString .= "<th>Id</th>";
					$vString .= "<th>Afrikaans</th>";
					$vString .= "<th>Engels</th>";
					$vString .= "<th></th>";
				$vString .= "</tr>";
			$vString .= "</thead>";
			$vString .= "<tfoot>";
				$vString .= "<tr class='red'>";
					$vString .= "<th>Id</th>";
					$vString .= "<th>Afrikaans</th>";
					$vString .= "<th>Engels</th>";
					$vString .= "<th></th>";
				$vString .= "</tr>";
			$vString .= "</tfoot>";
			$vString .= "<tbody>";
			if(count($vResults[0]) > 0){
				for($x = 0; $x < count($vResults[0]); $x++){
					$vString .= "<tr id='tr_".$vResults[0][$x]."'>";
						$vString .= "<td class='dt-body-center'>".$vResults[0][$x]."</td>";//id
						$vString .= "<td><span style='display: none;'>".$vResults[1][$x]."</span>";
							if(strlen($vResults[1][$x]) > 100){
								$vString .= General::returnTextarea($pConn, "af_".$vResults[0][$x], "af_".$vResults[0][$x], General::prepareStringForInputDisplay($vResults[1][$x]), 90, 4, 1000, "", "required");
							}
							else {
								$vString .= General::returnInput($pConn, "text", "af_".$vResults[0][$x], "af_".$vResults[0][$x], General::prepareStringForInputDisplay($vResults[1][$x]), 90, 1000, "", "", "required", "", "");
							}
						$vString .= "</td>";//af
						$vString .= "<td><span style='display: none;'>".$vResults[2][$x]."</span>";
							if(strlen($vResults[2][$x]) > 100){
								$vString .= General::returnTextarea($pConn, "en_".$vResults[0][$x], "en_".$vResults[0][$x], General::prepareStringForInputDisplay($vResults[2][$x]), 90, 4, 1000, "", "required");
							}
							else {
								$vString .= General::returnInput($pConn, "text", "en_".$vResults[0][$x], "en_".$vResults[0][$x], General::prepareStringForInputDisplay($vResults[2][$x]), 90, 1000, "", "", "required", "", "");
							}
						$vString .= "</td>";//en
						$vString .= "<td class='dt-body-center' id='side-by-side'>";
							$vString .= "<i class='fa fa-floppy-o fa-lg saveLanguageButton green' aria-hidden='true' id='saveLanguageButton_".$vResults[0][$x]."' data-id='".$vResults[0][$x]."' ".General::echoTooltip("left", "Stoor die veranderinge")."></i>";
						$vString .= "</td>";//manage
					$vString .= "</tr>";
				}
			}
			else {
				$vString .= "<tr>";
					$vString .= "<td colspan='17'>Geen data gevind</td>";
				$vString .= "</tr>";
			}
				$vString .= "</tbody>";
			$vString .= "</table>";

	return General::prepareStringForDisplay($vString, $pConn);
	}

	public static function echoRotatingImages($pConn, $pData){
		$vYNValueArray = array(1, 0);
		$vYNTextArray = array("J", "N");
		$vDateTomorrow = date("Y-m-d", strtotime('+1 day'));
		$vDateDayAfterTomorrow = date("Y-m-d", strtotime('+2 day'));
		$vDateNow = date("Y-m-d");
		$vWhere = "";

		$vResults = MysqlQuery::getCarouselImages($pConn, $vWhere);//$vId, $vUrl, $vAlt, $vBlobPath, $vSortOrder, $vAdvert, $vStartDt, $vEndDt
		$vString .= "<h1>Roterende prente</h1>";
		$vString .= "<div id='query-message'></div>";
		if(isset($_SESSION['SessionGrafCmsMessage']) && !empty($_SESSION['SessionGrafCmsMessage'])){
			$vString .= "<h5>".$_SESSION['SessionGrafCmsMessage']."</h5>";
			unset($_SESSION['SessionGrafCmsMessage']);
		}
		$vString .= "<form name='rotateForm' id='rotateForm' method='post' enctype='multipart/form-data' action='rotate_process.php'>";
		$vString .= "<table id='rotateTable' class='cell-border dataTable hover' cellspacing='0'>";
			$vString .= "<thead>";
				$vString .= "<tr class='red'>";
					$vString .= "<th>Posisie</th>";
					$vString .= "<th>Id</th>";
					$vString .= "<th>URL</th>";
					$vString .= "<th>Alternatiewe teks</th>";
					//$vString .= "<th>Advert</th>";
					//$vString .= "<th>Start</th>";
					//$vString .= "<th>End</th>";
					$vString .= "<th>Prent</th>";
					$vString .= "<th></th>";
				$vString .= "</tr>";
			$vString .= "</thead>";
			$vString .= "<tbody>";
			if(count($vResults[0]) > 0){
				for($x = 0; $x < count($vResults[0]); $x++){
					//($vResults[7][$x] == $vDateTomorrow ? $vEndClass = "class=bg-error" : $vResults[7][$x] == $vDateDayAfterTomorrow ? $vEndClass = "class=bg-3" : $vEndClass = "class=bg-1");
					if($vResults[5][$x] == 1){
						if($vResults[7][$x] == $vDateTomorrow){
							$vEndClass = "class=bg-0";//red
						}
						else if($vResults[7][$x] <= $vDateNow){
							$vEndClass = "class=bg-gray";//gray
						}
						else if ($vResults[7][$x] == $vDateDayAfterTomorrow){
							$vEndClass = "class=bg-3";//orange
						}
						else {
							$vEndClass = "class=bg-1";
						}
					}
					else if($vResults[5][$x] == 0){
						$vEndClass = "";//white
					}
					$vString .= "<tr id='tr_".$vResults[0][$x]."'>";
						$vString .= "<td class='dt-body-center green' style='cursor: move;'>".$vResults[4][$x]."</td>";//order
						$vString .= "<td class='dt-body-center'>".$vResults[0][$x]."</td>";//id
						$vString .= "<td>";
								$vString .= General::returnInput($pConn, "text", "url_".$vResults[0][$x], "url_".$vResults[0][$x], General::prepareStringForInputDisplay($vResults[1][$x]), 60, 60, "", "", "required", "", "");
						$vString .= "</td>";//URL
						$vString .= "<td>";
								$vString .= General::returnInput($pConn, "text", "alt_".$vResults[0][$x], "alt_".$vResults[0][$x], General::prepareStringForInputDisplay($vResults[2][$x]), 100, 100, "", "", "required", "", "");
						$vString .= "</td>";//Alt
//						$vString .= "<td class='dt-body-center'><span class='hidden-input'>".$vResults[5][$x]."</span>";
//							$vString .= "<select class='small' id='advert_".$vResults[0][$x]."' name='advert_".$vResults[0][$x]."'>";
//								for($o = 0; $o < count($vYNValueArray); $o++){
//									$vString .= "<option value='".$vYNValueArray[$o]."'";
//										if($vYNValueArray[$o] == $vResults[5][$x]){
//											$vString .= " selected";
//										}
//									$vString .= ">".$vYNTextArray[$o]."</option>";
//								}
//							$vString .= "</select>";
//						$vString .= "</td>";//advert
//						$vString .= "<td><span class='hidden-input'>".$vResults[6][$x]."</span>";
//							$vString .= "<input type='date' name='start_date_".$vResults[0][$x]."' id='start_date_".$vResults[0][$x]."' value='".$vResults[6][$x]."' class='small' size='4'>";
//						$vString .= "</td>";//start date
//						$vString .= "<td ".$vEndClass."><span class='hidden-input'>".$vResults[7][$x]."</span>";
//							$vString .= "<input type='date' name='end_date_".$vResults[0][$x]."' id='end_date_".$vResults[0][$x]."' value='".$vResults[7][$x]."' class='small' size='4'>";
//						$vString .= "</td>";//end date
						$vString .= "<td>";
								$vString .= "<img src='../images/uploads/".$vResults[3][$x]."' class='thumb'>";
						$vString .= "</td>";//File
						$vString .= "<td class='dt-body-center' id='side-by-side'>";
							$vString .= "<i class='fa fa-floppy-o fa-lg saveRotateButton green' aria-hidden='true' id='saveRotateButton_".$vResults[0][$x]."' data-id='".$vResults[0][$x]."' ".General::echoTooltip("left", "Stoor die veranderinge")."></i>";
							$vString .= "<i class='fa fa-times fa-lg space-left red deleteRotateButton' aria-hidden='true' id='deleteRotateButton_".$vResults[0][$x]."' data-id='".$vResults[0][$x]."' data-path='".$vResults[3][$x]."' ".General::echoTooltip("left", "Vee die prent uit")."></i>";
						$vString .= "</td>";//manage
					$vString .= "</tr>";
				}
			}
			else {
				$vString .= "<tr>";
					$vString .= "<td colspan='17'>Geen data gevind</td>";
				$vString .= "</tr>";
			}
					$vString .= "<tr id='new_tr'>";
						$vString .= "<td class='dt-body-center green' style='cursor: move;'>New</td>";//order
						$vString .= "<td class='dt-body-center'>New</td>";//id
						$vString .= "<td>";
								$vString .= General::returnInput($pConn, "text", "new_url", "new_url", "", 60, 60, "", "", "required", "", "");
						$vString .= "</td>";//URL
						$vString .= "<td>";
								$vString .= General::returnInput($pConn, "text", "new_alt", "new_alt", "", 100, 100, "", "", "required", "", "");
						$vString .= "</td>";//Alt
//						$vString .= "<td class='dt-body-center'>";
//							$vString .= "<select class='small' id='new_advert' name='new_advert'>";
//								for($o = 0; $o < count($vYNValueArray); $o++){
//									$vString .= "<option value='".$vYNValueArray[$o]."'>".$vYNTextArray[$o]."</option>";
//								}
//							$vString .= "</select>";
//						$vString .= "</td>";//advert
//						$vString .= "<td>";
//							$vString .= "<input type='date' name='new_start_date' id='new_start_date' value='' class='small' size='4'>";
//						$vString .= "</td>";//start date
//						$vString .= "<td>";
//							$vString .= "<input type='date' name='new_end_date' id='new_end_date' value='' class='small' size='4'>";
//						$vString .= "</td>";//end date
						$vString .= "<td>";
								$vString .= General::returnInput($pConn, "file", "new_blob_path", "new_blob_path", "", 50, 50, "", "", "required", "", "");
					            $vString .= "<div>";
									  $vString .= "<div class='red'>NB!! Prent dimensies: 1170 x 410 pixels </div>";
								$vString .= "</div>";
						$vString .= "</td>";//File
						$vString .= "<td class='dt-body-center' style='display: table-cell;'>";
							$vString .= "<i class='fa fa-plus fa-lg green' aria-hidden='true'  id='addRotateButton' title='Laai nuwe prent'></i>";
						$vString .= "</td>";//manage
					$vString .= "</tr>";
				$vString .= "</tbody>";
				$vString .= "<input type='hidden' name='max_sort' value='".max($vResults[4])."'>";
				$vString .= "<input type='hidden' name='type' value='add-rotate'>";
			$vString .= "</table>";

	            $vString .= "<article>";
		            $vString .= "<div>";
						  $vString .= "<div id='submitError' class='error' style='display:none;'>Voltooi asseblief die verpligte velde</div>";
						  $vString .= "<div id='fileTypeError' class='error' style='display:none;'>Slegs .jpg, .jpeg, .png, .gif tipe prente word toegelaat. Kies asb. die regte formaat prent.</div>";
						  $vString .= "<div id='fileSizeError' class='error' style='display:none;'>Die prent se l&#234;ergrootte is te groot (maksimum 1MB word toegelaat). Optimaliseer die l&#234;er asb.</div>";
						  $vString .= "<div id='filePhysicalWidthError' class='error' style='display:none;'>Die prent se wydte is verkeerd. Die prent moet 1170 pixels wyd wees.</div>";
						  $vString .= "<div id='filePhysicalHeightErro' class='error' style='display:none;'>Die prent se hoogte is verkeerd. Die prent moet 410 pixels hoog wees.</div>";
					$vString .= "</div>";
				$vString .= "</article>";
			$vString .= "</form>";

	return General::prepareStringForDisplay($vString, $pConn);
	}

	public static function echoOrders($pConn, $pData){
		$vString = "";
		$vBindParams = array();
		$vBindLetters = "";
		if($pData['type'] == "list"){
			$vWhere = "WHERE submitted =  ?";
			$vValue = 1;
			$vLength = 15;
            $vBindParams[] = & $vValue;
		    $vBindLetters .= "i";
		}
		else if($pData['type'] == "paid_1"){
			$vWhere = "WHERE paid =  ?";
			$vValue = 1;
			$vLength = 15;
            $vBindParams[] = & $vValue;
		    $vBindLetters .= "i";
		}
		else if($pData['type'] == "paid_0"){
			$vWhere = "WHERE paid =  ?";
			$vValue = 0;
			$vLength = 15;
            $vBindParams[] = & $vValue;
		    $vBindLetters .= "i";
		}
		else if($pData['type'] == "process_1"){
			$vWhere = "WHERE processed =  ?";
			$vValue = 1;
			$vLength = 15;
            $vBindParams[] = & $vValue;
		    $vBindLetters .= "i";
		}
		else if($pData['type'] == "process_0"){
			$vWhere = "WHERE processed =  ?";
			$vValue = 0;
			$vLength = 15;
            $vBindParams[] = & $vValue;
		    $vBindLetters .= "i";
		}
		else if($pData['type'] == "dispatch_1"){
			$vWhere = "WHERE posted =  ?";
			$vValue = 51;
			$vLength = 15;
            $vBindParams[] = & $vValue;
		    $vBindLetters .= "i";
		}
		else if($pData['type'] == "dispatch_0"){
			$vWhere = "WHERE posted =  ?";
			$vValue = 52;
			$vLength = 15;
            $vBindParams[] = & $vValue;
		    $vBindLetters .= "i";
		}
		else if($pData['type'] == "dispatch_3"){
			$vWhere = "WHERE posted =  ?";
			$vValue = 53;
			$vLength = 15;
            $vBindParams[] = & $vValue;
		    $vBindLetters .= "i";
		}
		else if($pData['type'] == "completed_0"){
			$vWhere = "WHERE completed = ?";
			$vValue = 0;
			$vLength = -1;
            $vBindParams[] = & $vValue;
		    $vBindLetters .= "i";
		}
		else if($pData['type'] == "completed_1"){
			$vWhere = "WHERE completed = ? AND order_date < ?";
			$vValue = 1;
            $vValue2 = '2022-01-01';
			$vLength = 15;
            $vBindParams[] = & $vValue;
            $vBindParams[] = & $vValue2;
		    $vBindLetters .= "is";
		}
        else if($pData['type'] == "completed_3"){
			$vWhere = "WHERE completed = ? AND order_date >= ? AND order_date < ?";
			$vValue = 1;
            $vValue2 = '2022-01-01';
            $vValue3 = '2022-07-01';
			$vLength = 15;
            $vBindParams[] = & $vValue;
            $vBindParams[] = & $vValue2;
            $vBindParams[] = & $vValue3;
		    $vBindLetters .= "iss";
		}
        else if($pData['type'] == "completed_4"){
			$vWhere = "WHERE completed = ? AND order_date >= ?";
			$vValue = 1;
            $vValue2 = '2022-07-01';
			$vLength = 15;
            $vBindParams[] = & $vValue;
            $vBindParams[] = & $vValue2;
		    $vBindLetters .= "is";
		}
		else if($pData['type'] == "client"){
			$vWhere = "WHERE client_id = ?";
			$vValue = $pData['client_id'];
			$vLength = 15;
            $vBindParams[] = & $vValue;
		    $vBindLetters .= "i";
		}
		else if($pData['type'] == "reference"){
			$vWhere = "WHERE id = ?";
			$vValue = $pData['client_id'];
			$vLength = 15;
            $vBindParams[] = & $vValue;
		    $vBindLetters .= "i";
		}
		$vOrder = " ORDER BY id DESC";

		$vYNValueArray = array(1, 0);
		$vYNTextArray = array("J", "N");
		$vSendLookup = MysqlQuery::getLookup($pConn, "send");

		include "include/OrderLookupForms.php";

		$vResults = MysqlQuery::getOrder($pConn, $vWhere, $vOrder, $vBindLetters, $vBindParams, "LIMIT 100");
        $vX = count($vResults[0]);
		$vString .= "<h1>Bestellings</h1>";
		if(isset($_SESSION['SessionGrafCmsMessage']) && !empty($_SESSION['SessionGrafCmsMessage'])){
			$vString .= "<h5>".$_SESSION['SessionGrafCmsMessage']."</h5>";
			unset($_SESSION['SessionGrafCmsMessage']);
		}
		$vString .= "<table id='orderTable' class='cell-border dataTable hover' cellspacing='0' data-page-length='".$vLength."'>";
			$vString .= "<thead>";
				$vString .= "<tr class='red'>";
					include "include/OrderTableHeadings.php";
				$vString .= "</tr>";
			$vString .= "</thead>";
			$vString .= "<tfoot>";
				$vString .= "<tr class='red'>";
					include "include/OrderTableHeadings.php";
				$vString .= "</tr>";
			$vString .= "</tfoot>";
			$vString .= "<tbody>";
			if(isset($vResults) && count($vResults[0]) > 0){
				for($x = 0; $x < count($vResults[0]); $x++){
                    if(is_numeric($vResults[1][$x])) {
                        $vClientResults = MysqlQuery::getOrderClient($pConn, $vResults[1][$x]);//$vId, $vFirstname, $vSurname, $vEmail, $vPhone
                    }
                    else {
                        $vClientResults = array();
                    }
					$vCourierResults = MysqlQuery::getCourierSelection($pConn, 9);//$vId, $vCourier_type
                    if(isset($vResults[23][$x]) && !empty($vResults[23][$x]) && $vResults[23][$x] != '') {
                        $vCourierCountry = MysqlQuery::getCmsCourierCountry($pConn, $vResults[23][$x]);
                    }
                    else {
                        $vCourierCountry = array();
                    }
					//$vPaymentType = MysqlQuery::getCmsLookupPerId($pConn, $vResults[14][$x]);
					$vPaymentType = MysqlQuery::getLookup($pConn, "payment");
					$vOrderDetail = MysqlQuery::getOrderDetail($pConn, "order_id = ?", $vResults[0][$x]);//$vId, $vOrder_id, $vBook_id, $vPrice, $vNumber_books, $vTemp_salt, $vTitle, $vInStock
					//(empty($vResults[20][$x]) ? $vTracking = "None" : $vTracking = $vResults[20][$x]);

					$vString .= "<tr id='tr_".$vResults[0][$x]."'>";
						$vString .= "<td>".$vResults[0][$x]."</td>";//id
						$vString .= "<td>";
                        if(isset($vClientResults[0]) && !empty($vClientResults[0])) {
                            $vString .= $vClientResults[1] . " " . $vClientResults[2] . "
                                <a href='index.php?page=clients&type=edit&id=" . $vResults[1][$x] . "'>
                                    <i class='fa fa-user fa-lg green space-left' aria-hidden='true' " . General::echoTooltip("right", "Besigting kli&#235;nt info") . "></i>
                                </a> (" . $vResults[1][$x] . ")<br>";
                            $vString .= "<a href='mailto:" . $vClientResults[3] . "' class='email'>" . $vClientResults[3] . "</a><br>";//Email
                            $vString .= $vClientResults[4] . "<br>";
                        }
                        else {
                            $vString .= "<span class='red'>Klient nie ingelog</span><br>";
                            $vString .= "<a href='mailto:" . $vResults[32][$x] . "' class='email'>" . $vResults[32][$x] . '</a><br>';//Email
                        }
                            $vCountryString = (!empty($vResults[8][$x]) && $vResults[8][$x] > 0 && $vResults[10][$x] <> 4 ? MysqlQuery::getCountry($pConn, $vResults[8][$x]) : '');

                            (!empty($vResults[4][$x]) ? $vString .= $vResults[4][$x] : $vString .= "");//Address1
                            (!empty($vResults[5][$x]) ? $vString .= ", ".$vResults[5][$x] : $vString .= "");//Address2
                            (!empty($vResults[6][$x]) ? $vString .= ", ".$vResults[6][$x] : $vString .= "");//City
                            (!empty($vResults[7][$x]) ? $vString .= ", ".$vResults[7][$x] : $vString .= "");//Province
                            (!empty($vCountryString[1]) ? $vString .= ", ".$vCountryString[1] : '');//Country
                            (!empty($vResults[9][$x]) ? $vString .= ", ".$vResults[9][$x] : $vString .= "");//Postal code
                            (!empty($vResults[27][$x]) ? $vString .= "<br>Ontvanger: ". $vResults[27][$x] : $vString .= "");
                            (!empty($vResults[28][$x]) ? $vString .= "<br>Ontvanger no: ".$vResults[28][$x] : $vString .= "");
                            (!empty($vResults[23][$x]) ? $vString .= "<br>(".$vResults[23][$x].")" : $vString .= "");//Courier detail
						$vString .= "</td>";//client & delivery address
						$vString .= "<td>".$vResults[0][$x]."/".$vResults[3][$x]."</td>";//order ref
						$vString .= "<td>";
                            if(isset($vOrderDetail['id'])) {
                                $vDefaultClass = '';
                                $vBookString = '';
                                $vBooks = '';
                                $vIconClass = '';
                                if(isset($vOrderDetail['number_books'])){
                                    $vTotalNumberBooks = array_sum($vOrderDetail['number_books']);
                                    $vString .= 'Totaal: ' . $vTotalNumberBooks;
                                }
                                for ($b = 0; $b < count($vOrderDetail['id']); $b++) {
                                    $vClass = ($vOrderDetail['in_stock'][$b] > 0 ? 'green' : 'red');
                                    if($vIconClass == 'green' && $vClass == 'red'){
                                        $vIconClass = 'red';
                                    }
                                    else if($vIconClass == 'red' || $vClass == 'red'){
                                        $vIconClass = 'red';
                                    }
                                    else {
                                        $vIconClass = 'green';
                                    }
                                    if($vTotalNumberBooks > 5) {
                                        $vBooks .= $vOrderDetail['number_books'][$b] . " x " . $vOrderDetail['title'][$b].($vOrderDetail['in_stock'][$b] == 0 ? "<span class='".$vClass."'>&nbsp;(Nie in voorraad)</span><br>" : '<br>');
                                    }
                                    else {
                                        $vBookString .= "<br>".$vOrderDetail['number_books'][$b]." x ".$vOrderDetail['title'][$b]. ($vOrderDetail['in_stock'][$b] == 0 ? "&nbsp;<span class='".$vClass."'>(Nie in voorraad)</span>" : "");
                                    }
                                }
                                if(!empty($vBooks)) {
                                    $vString .= "<a href=\"#orderbooks\" id=\"orderbooks_" . $vResults[0][$x] . "\" data-toggle=\"modal\" data-id=\"" . $vResults[0][$x] . "\" data-books=\"".$vBooks."\"><i class=\"fa fa-book fa-lg space-left ".$vIconClass."\" aria-hidden=\"true\"  data-toggle=\"tooltip\" data-html=\"true\" title=\"Wys boeke\"></i></a>";
                                }
                                else {
                                    $vString .= $vBookString;
                                }
                            }

//                            if(isset($vOrderDetail['number_books'])) {
//                                $vString .= "Totaal: ".array_sum($vOrderDetail['number_books']);
//                                if(array_sum($vOrderDetail['number_books']) > 2) {
//                                    $vString .= "&nbsp;&nbsp;<a href=\"#orderbooks\" id=\"orderbooks_".$vResults[0][$x]."\" data-toggle=\"modal\" data-id=\"" . $vResults[0][$x] . "\" data-books=\"" . $vBooksString . "\"><i class=\"fa fa-book fa-lg " . $vDefaultClass . " space-left\" aria-hidden=\"true\"  data-toggle=\"tooltip\" data-html=\"true\" title=\"" . $vDefaultText . "\"></i></a>";
//                                }
//                                else{
//                                    $vString .= "<br>".$vBooksString . ' ' . $vDefaultText;
//                                }
//                            }
						$vString .= "</td>";//Book no & books
						$vString .= "<td>".$vResults[2][$x]."</td>";//order date
						$vString .= "<td>";
							if($vResults[10][$x] != 5){
							$vString .= "<select name='courier-type_".$vResults[0][$x]."' id='courier-type_".$vResults[0][$x]."' class='small narrow'>";
		            			if(count($vCourierResults[0]) > 0){
		            				for($c = 0; $c < count($vCourierResults[0]); $c++){
		            					$vString .= "<option value='".$vCourierResults[0][$c]."' ".( $vResults[10][$x] == $vCourierResults[0][$c] ? "selected" : "").">".$vCourierResults[1][$c]."</option>";
		            				}
		            			}
		            		$vString .= "</select>";
		            		$vString .= "<div class='text-small'>".MysqlQuery::getCourierTextPerId($pConn, $vResults[10][$x])."</div>";
							}
							else{
								$vString .= MysqlQuery::getCourierTextPerId($pConn, $vResults[10][$x]);
								(!empty($vCourierCountry[1]) ? $vString .= ", ".$vCourierCountry[1] : $vString .= "");
							}
						$vString .= "</td>";//courier_type & country
						$vString .= "<td class='dt-body-right'>".$vResults[12][$x]."</td>";//price
						$vString .= "<td class='dt-body-right'>";
							$vString .= "<input type='text' name='courier_cost_".$vResults[0][$x]."' id='courier_cost_".$vResults[0][$x]."' value='".$vResults[11][$x]."' class='small' size='5'>";
						$vString .= "</td>";//courier_cost
						$vString .= "<td class='dt-body-right'>";
							$vString .= "<input type='text' name='total_cost_".$vResults[0][$x]."' id='total_cost_".$vResults[0][$x]."' value='".$vResults[13][$x]."' class='small' size='5'>";
						$vString .= "</td>";//total_cost
						$vString .= "<td>";
						//$vPaymentType;
							$vString .= "<select name='payment-type_".$vResults[0][$x]."' id='payment-type_".$vResults[0][$x]."' class='small narrow'>";
		            			if(count($vPaymentType[0]) > 0){
		            				for($pt = 0; $pt < count($vPaymentType[0]); $pt++){
		            					$vString .= "<option value='".$vPaymentType[0][$pt]."' ".( $vResults[14][$x] == $vPaymentType[0][$pt] ? "selected" : "").">".$vPaymentType[1][$pt]."</option>";
		            				}
		            			}
		            		$vString .= "</select>";
						$vString .= "</td>";//payment_type
						$vString .= "<td>".$vResults[16][$x]."</td>";//message
						($vResults[14][$x] == 16 && $vResults[17][$x] == 0 ? $vPaidClass = "bg-3" : $vPaidClass = "bg-".$vResults[17][$x]);
						$vString .= "<td class='dt-body-center ".$vPaidClass." '><span class='hidden-input'>".$vResults[17][$x]."</span>";
						($vResults[24][$x] == 1 && $vResults[17][$x] ==1  ? $vPaidDisabled = "disabled='true'" : $vPaidDisabled = "");
							($vDefaultClass == "green" ? $vAllInStock = 1 : $vAllInStock = 0);
							$vString .= "<select class='small' id='paid_".$vResults[0][$x]."' name='paid_".$vResults[0][$x]."' ".$vPaidDisabled." data-id='".$vResults[0][$x]."' data-client='".$vResults[1][$x]."' data-amount='".$vResults[13][$x]."' data-ref='".$vResults[3][$x]."' data-instock='".$vAllInStock."' data-couriertype='".$vResults[10][$x]."'>";
								for($n = 0; $n < count($vYNValueArray); $n++){
									$vString .= "<option value='".$vYNValueArray[$n]."'";
										if($vYNValueArray[$n] == $vResults[17][$x]){
											$vString .= " selected";
										}
									$vString .= ">".$vYNTextArray[$n]."</option>";
								}
							$vString .= "</select>";
							if($vResults[24][$x] == 1){
								$vString .= "<br><i class='fa fa-envelope-open fa-lg dgreen' aria-hidden='true' ".General::echoTooltip("left", "Betaling ontvang - Epos gestuur")."></i>";
							}
						$vString .= "</td>";//paid & paid email
						$vString .= "<td class='dt-body-center bg-".$vResults[29][$x]."'><span class='hidden-input'>".$vResults[29][$x]."</span>";
							($vResults[29][$x] == 1 ? $vSettledDisabled = "disabled='true'" : $vSettledDisabled = "");
							$vString .= "<select class='small' id='settled_".$vResults[0][$x]."' name='settled_".$vResults[0][$x]."' ".$vSettledDisabled." data-id='".$vResults[0][$x]."'>";
								for($n = 0; $n < count($vYNValueArray); $n++){
									$vString .= "<option value='".$vYNValueArray[$n]."'";
										if($vYNValueArray[$n] == $vResults[29][$x]){
											$vString .= " selected";
										}
									$vString .= ">".$vYNTextArray[$n]."</option>";
								}
							$vString .= "</select>";
						$vString .= "</td>";//settled
						$vString .= "<td class='dt-body-center bg-".$vResults[18][$x]."'><span class='hidden-input'>".$vResults[18][$x]."</span>";
							($vResults[18][$x] == 1 && $vResults[25][$x] == 1 ? $vProcessedDisabled = "disabled='true'" : $vProcessedDisabled = "");
							$vString .= "<select class='small' id='processed_".$vResults[0][$x]."' name='processed_".$vResults[0][$x]."' ".$vProcessedDisabled." data-id='".$vResults[0][$x]."' data-client='".$vResults[1][$x]."' data-amount='".$vResults[13][$x]."' data-ref='".$vResults[3][$x]."' data-couriertype='".$vResults[10][$x]."'>";
								for($n = 0; $n < count($vYNValueArray); $n++){
									$vString .= "<option value='".$vYNValueArray[$n]."'";
										if($vYNValueArray[$n] == $vResults[18][$x]){
											$vString .= " selected";
										}
									$vString .= ">".$vYNTextArray[$n]."</option>";
								}
							$vString .= "</select>";
							if($vResults[25][$x] == 1){
								$vString .= "<br><i class='fa fa-envelope-open fa-lg dgreen' aria-hidden='true' ".General::echoTooltip("left", "Verwerk - Epos gestuur")."></i>";
							}
						$vString .= "</td>";//processed & processed email

						if($vResults[10][$x] != 4){//Not collect
							($vResults[19][$x] == 51 ? $vPostedClass = 1 : ($vResults[19][$x] == 52 ? $vPostedClass = 0 : $vPostedClass = 3));
							$vString .= "<td class='bg-".$vPostedClass."'><span class='hidden-input'>".$vResults[19][$x]."</span>";
								($vResults[19][$x] == 1 && $vResults[26][$x] == 1 ? $vDispatchedDisabled = "disabled='true'" : $vDispatchedDisabled = "");
								$vString .= "<select class='small' id='posted_".$vResults[0][$x]."' name='posted_".$vResults[0][$x]."' ".$vDispatchedDisabled.">";
									for($n = 0; $n < count($vSendLookup[0]); $n++){
										$vString .= "<option value='".$vSendLookup[0][$n]."'";
											if($vSendLookup[0][$n] == $vResults[19][$x]){
												$vString .= " selected";
											}
										$vString .= ">".$vSendLookup[1][$n]."</option>";
									}
								$vString .= "</select><br>";
								$vString .= "<input type='text' name='tracking_no_".$vResults[0][$x]."' id='tracking_no_".$vResults[0][$x]."' value='".$vResults[20][$x]."' class='small' size='15' ".$vDispatchedDisabled.">";
								$vString .= "<select name='courier_selected_".$vResults[0][$x]."' id='courier_selected_".$vResults[0][$x]."' class='small' ".$vDispatchedDisabled." data-id='".$vResults[0][$x]."'>
                                    <option value='courier_guy' ".($vResults[31][$x] == 'courier_guy' ? 'selected' : '').">Courier Guy</option>
                                    <option value='aramex'".($vResults[31][$x] == 'aramex' ? 'selected' : '').">Aramex</option>
                                    <option value='internet_express'".($vResults[31][$x] == 'internet_express' ? 'selected' : '').">Internet Express</option>
                                    <option value='pargo'".($vResults[31][$x] == 'pargo' ? 'selected' : '').">Pargo</option>
								</select>";
								$vString .= "<div id='trackingError_".$vResults[0][$x]."' class='error' style='display:none;'>Tik naspoorno. in</div>";
								if($vResults[26][$x] == 0){
									$vString .= "<br><i class='fa fa-envelope fa-lg dgreen' aria-hidden='true' id='tracking_email_".$vResults[0][$x]."' data-html='true' data-id='".$vResults[0][$x]."' ".General::echoTooltip("left", "Stoor &amp; Stuur versendingsepos met Nasppornommer<br><b><span class='red'><br><u>NB! EMAIL WORD OUTOMATIES GESTUUR</u><br>- Tik volledige naspoorno. in!<br>- Bevestig 'Koerier tipe' en bedrag is korrek!<br>- Onthou om koerier veranderinge te stoor voor jy hier klik!</span></b>")." data-client='".$vResults[1][$x]."' data-courier='".$vResults[10][$x]."' data-ref='".$vResults[3][$x]."'></i>";
								}
								else if($vResults[26][$x] == 1){
									$vString .= "<br><span class='text-small'>".$vResults[30][$x]."</span>";
									$vString .= "<br><i class='fa fa-envelope-open fa-lg dgreen' aria-hidden='true' ".General::echoTooltip("left", "Versend - Epos gestuur")."></i>";
								}
//								$vString .= "<i class='fa fa-file-text-o fa-lg dgreen space-left no-display' aria-hidden='true' id='createWaybill_".$vResults[0][$x]."' data-html='true' data-id='".$vResults[0][$x]."' ".General::echoTooltip("left", "Kry Waybill")."></i>";//createWaybill
							$vString .= "</td>";//posted & tracking no & posted email
						}
						else if($vResults[10][$x] == 4){//Collect at Graffiti
							$vString .= "<td><span class='hidden-input'>".$vResults[19][$x]."</span>Afhaal</td>";//posted & tracking no & posted email
						}
						$vString .= "<td class='dt-body-center bg-".$vResults[21][$x]."'><span class='hidden-input'>".$vResults[21][$x]."</span>";
							( $vResults[21][$x] ? $vCompletedDisabled = "disabled='true'" : $vCompletedDisabled = "");
							$vString .= "<select class='small' id='completed_".$vResults[0][$x]."' name='completed_".$vResults[0][$x]."' ".$vCompletedDisabled." data-id='".$vResults[0][$x]."'>";
								for($n = 0; $n < count($vYNValueArray); $n++){
									$vString .= "<option value='".$vYNValueArray[$n]."'";
										if($vYNValueArray[$n] == $vResults[21][$x]){
											$vString .= " selected";
										}
									$vString .= ">".$vYNTextArray[$n]."</option>";
								}
							$vString .= "</select>";
						$vString .= "</td>";//completed
						$vString .= "<td><span class='hidden-input'>".$vResults[22][$x]."</span>";
							$vString .= "<textarea name='note_".$vResults[0][$x]."' id='note_".$vResults[0][$x]."' class='small' cols='20' rows='5'>".$vResults[22][$x]."</textarea>";
							//$vString .= "<br><i class='fa fa-floppy-o fa-lg green' aria-hidden='true' id='saveOrderNoteButton_".$vResults[0][$x]."' data-id='".$vResults[0][$x]."' ".General::echoTooltip("left", "Stoor die nota")."></i>";
						$vString .= "</td>";//note
						$vString .= "<td class='dt-body-center'>";
							$vString .= "<i class='fa fa-floppy-o fa-lg green' aria-hidden='true' id='saveOrder_".$vResults[0][$x]."' data-id='".$vResults[0][$x]."' ".General::echoTooltip("left", "Stoor die veranderinge")."></i>";
							$vString .= "<br><i class='fa fa-print fa-lg green space-top' aria-hidden='true' id='printInvoiceButton_".$vResults[0][$x]."' data-id='".$vResults[0][$x]."' data-clientid='".$vClientResults[0]."' ".General::echoTooltip("left", "Druk faktuur")."></i>";
							$vString .= "<br><i class='fa fa-print fa-lg lgray space-top' aria-hidden='true' id='printInvoiceButton2_".$vResults[0][$x]."' data-id='".$vResults[0][$x]."' data-clientid='".$vClientResults[0]."' ".General::echoTooltip("left", "Druk faktuur met ander ontvanger")."></i>";
							$vString .= "<br><i class='fa fa-times fa-lg red space-top' aria-hidden='true' id='deleteOrderButton_".$vResults[0][$x]."' data-id='".$vResults[0][$x]."' ".General::echoTooltip("left", "Vee bestelling uit")."></i>";
						$vString .= "</td>";//manage
					$vString .= "</tr>";
				}
			}
			else {
				$vString .= "<tr>";
					$vString .= "<td colspan='15'>Geen data gevind</td>";
					$vString .= "</tr>";
			}
				$vString .= "</tbody>";
			$vString .= "</table>";
//	return General::prepareStringForDisplay($vString, $pConn);
    return $vString;
	}

	public static function echoOrderBooks($pConn, $pData){
        $vString = "";
		include "include/OrderLookupForms.php";

		$vResults = MysqlQuery::getOrderDetail($pConn, " b.isbn = ?", $pData['isbn']);
        if(isset($vResults['number_books'])) {
            $vTotalForIsbn = array_sum($vResults['number_books']);
        }
        else {
            $vTotalForIsbn = 0;
        }
		$vString = "<h1>Bestellings</h1>";
		$vString .= "<h4 class='success-message'>Totale bestellings vir ISBN ".$pData['isbn'].": <span class='red'>".$vTotalForIsbn."</h4>";
		$vString .= "<table id='orderBooksTable' class='cell-border dataTable hover' cellspacing='0'>";
			$vString .= "<thead>";
				$vString .= "<tr class='red'>";
					include "include/OrderBooksTableHeadings.php";
				$vString .= "</tr>";
			$vString .= "</thead>";
			$vString .= "<tfoot>";
				$vString .= "<tr class='red'>";
					include "include/OrderBooksTableHeadings.php";
				$vString .= "</tr>";
			$vString .= "</tfoot>";
			$vString .= "<tbody>";

			if(isset($vResults['id']) && count($vResults['id']) > 0){
				for($x = 0; $x < count($vResults['id']); $x++){
					$vString .= "<tr>";
						$vString .= "<td><a href='index.php?page=orders&type=reference&id=".$vResults['order_id'][$x]."'>GRAF/".$vResults['order_id'][$x]."/".$vResults['temp_salt'][$x]."</a></td>";//id
						$vString .= "<td>".$vResults['title'][$x]."</td>";//title
						$vString .= "<td>".$vResults['isbn'][$x]."</td>";//isbn
						$vString .= "<td>".$vResults['number_books'][$x]."</td>";//no books
						$vString .= "<td>".$vResults['price'][$x]."</td>";//price
						$vString .= "<td>".$vResults['price'][$x]."</td>";//original price
						$vString .= "<td>".$vResults['in_stock'][$x]."</td>";//in stock
					$vString .= "</tr>";
				}
			}
			else {
				$vString .= "<tr>";
					$vString .= "<td colspan='15'>Geen data gevind</td>";
					$vString .= "</tr>";
			}
				$vString .= "</tbody>";
			$vString .= "</table>";
	return $vString;
	}

	public static function echoClients($pConn, $pData){
		if($pData['client_id'] > 0 && $pData['type'] != "searchClient"){
			$vValue = $pData['client_id'];
			$vOrder = "";
			$vBindParams = array();
			$vBindLetters = "i";
			$vBindParams[] =& $vValue;
			$vLimit = "";
			$vWhere = " WHERE c.id = ?";
		}
		else if($pData['client_id'] == 0 && $pData['type'] != "searchClient"){
			($pData['type'] == "validated_0" ? $vValue = 0 : $vValue = 1);
			$vOrder = "";
			$vBindParams = array();
			$vBindLetters = "i";
			$vBindParams[] =& $vValue;
			$vLimit = "";
			$vWhere = " WHERE c.validated = ?";
		}
		else if($pData['client_id'] == -1 && $pData['type'] == "searchClient"){
			$vClient1 = "%{$pData['client']}%";
			$vClient2 = "%{$pData['client']}%";
			$vClient3 = "%{$pData['client']}%";
			$vOrder = "ORDER BY c.firstname ASC";
			$vBindParams = array();
			$vBindLetters = "sss";
			$vBindParams[] =& $vClient1;
			$vBindParams[] =& $vClient2;
			$vBindParams[] =& $vClient3;
			$vLimit = "";
			$vWhere = " WHERE lower(c.firstname) LIKE ? OR lower(c.surname) LIKE ? OR lower(c.email) LIKE ?";
		}

		$vString = "";
		include "include/ClientLookupForms.php";

		$vResults = MysqlQuery::getClients($pConn, $vWhere, $vOrder, $vBindLetters, $vBindParams, $vLimit);

		$vYNValueArray = array(0.1, 0);
		$vYNTextArray = array("Ja", "Nee");
		$vValidateYNValueArray = array(1, 0);
		$vValidateYNTextArray = array("Ja", "Nee");

		$vString .= "<h1>Kli&#235;nte</h1>";
		if(isset($_SESSION['SessionGrafCmsMessage']) && !empty($_SESSION['SessionGrafCmsMessage'])){
			$vString .= "<h5>".$_SESSION['SessionGrafCmsMessage']."</h5>";
			unset($_SESSION['SessionGrafCmsMessage']);
		}
		$vString .= "<table id='clientsTable' class='cell-border dataTable hover' cellspacing='0'>";
			$vString .= "<thead>";
				$vString .= "<tr class='red'>";
					include "include/ClientTableHeadings.php";
				$vString .= "</tr>";
			$vString .= "</thead>";
			$vString .= "<tfoot>";
				$vString .= "<tr class='red'>";
					include "include/ClientTableHeadings.php";
				$vString .= "</tr>";
			$vString .= "</tfoot>";
			$vString .= "<tbody>";
			if(isset($vResults[0]) && count($vResults[0]) > 0){
				for($x = 0; $x < count($vResults[0]); $x++){
					($vResults[18][$x] == 1 ? $vNewsletter = "Ja" : $vNewsletter = "Nee");
					($vResults[19][$x] == "af" ? $vLanguage = "Afr" : $vLanguage = "Eng");
					$vOBindParams = array();
					$vOBindLetters = "i";
					$vOBindParams[] =& $vResults[0][$x];
					$vOrderCount = MysqlQuery::getCount($pConn, "orders", "id", "WHERE client_id = ?", $vOBindLetters, $vOBindParams);
					$vWishCount = MysqlQuery::getCount($pConn, "wishlist", "id", "WHERE client_id = ?", $vOBindLetters, $vOBindParams);
//$vId, $vFirstname, $vSurname, $vEmail, $vValidated, $vPhone, $vPostal_address1, $vPostal_address2, $vPostal_city, $vPostal_province, $vPostal_code, $vPostal_country, $vPhysical_address1, $vPhysical_address2, $vPhysical_city,
//	0				1							2						3					4						5								6										7									8								9									10								11							12												13									14
//$vPhysical_province, $vPhysical_country, $vPhysical_code, $vNewsletter, $vLanguage, $vSpecial_discount
//				15											16								17							18						19							20

					$vString .= "<tr id='tr_".$vResults[0][$x]."'>";
						$vString .= "<td>".$vResults[1][$x]." ".$vResults[2][$x]."</td>";//name surname
						$vString .= "<td><a href='mailto:' class='email'>".$vResults[3][$x]."</a></td>";//email
						$vString .= "<td>".$vResults[5][$x]."</td>";//phone
						$vString .= "<td>";
								(!empty($vResults[6][$x]) ? $vString .= $vResults[6][$x] : $vString .= "");
								(!empty($vResults[7][$x]) ? $vString .= ", ".$vResults[7][$x] : $vString .= "");
								(!empty($vResults[8][$x]) ? $vString .= ", ".$vResults[8][$x] : $vString .= "");
								(!empty($vResults[9][$x]) ? $vString .= ", ".$vResults[9][$x] : $vString .= "");
								(!empty($vResults[10][$x]) ? $vString .= ", ".$vResults[10][$x] : $vString .= "");
								(!empty($vResults[11][$x]) ? $vString .= ", ".$vResults[11][$x] : $vString .= "");
						$vString .= "</td>";//postal
						$vString .= "<td>";
								(!empty($vResults[12][$x]) ? $vString .= $vResults[12][$x] : $vString .= "");
								(!empty($vResults[13][$x]) ? $vString .= ", ".$vResults[13][$x] : $vString .= "");
								(!empty($vResults[14][$x]) ? $vString .= ", ".$vResults[14][$x] : $vString .= "");
								(!empty($vResults[15][$x]) ? $vString .= ", ".$vResults[15][$x] : $vString .= "");
								(!empty($vResults[16][$x]) ? $vString .= ", ".$vResults[16][$x] : $vString .= "");
								(!empty($vResults[17][$x]) ? $vString .= ", ".$vResults[17][$x] : $vString .= "");
						$vString .= "</td>";//physical address
						$vString .= "<td class='dt-body-center'><span class='hidden-input'>".$vResults[20][$x]."</span>";
							$vString .= "<select class='small' id='special_discount_".$vResults[0][$x]."' name='special_discount_".$vResults[0][$x]."'>";
								for($t = 0; $t < count($vYNValueArray); $t++){
									$vString .= "<option value='".$vYNValueArray[$t]."'";
										if($vYNValueArray[$t] == $vResults[20][$x]){
											$vString .= " selected";
										}
									$vString .= ">".$vYNTextArray[$t]."</option>";
								}
							$vString .= "</select>";
						$vString .= "</td>";//special_discount
						$vString .= "<td class='dt-body-center'>";
							$vString .= "<select class='small' id='validated_".$vResults[0][$x]."' name='validated_".$vResults[0][$x]."'>";
								for($v = 0; $v < count($vValidateYNValueArray); $v++){
									$vString .= "<option value='".$vValidateYNValueArray[$v]."'";
										if($vValidateYNValueArray[$v] == $vResults[4][$x]){
											$vString .= " selected";
										}
									$vString .= ">".$vValidateYNTextArray[$v]."</option>";
								}
							$vString .= "</select>";
						$vString .= "</td>";//validated
						$vString .= "<td>".$vNewsletter."</td>";//newsletter
						$vString .= "<td>".$vLanguage."</td>";//language
						$vString .= "<td>".$vOrderCount;
							if($vOrderCount > 0){
								$vString .= "<a href='index.php?page=orders&type=client&id=".$vResults[0][$x]."' ".General::echoTooltip("bottom", "Besigtig bestellings")."><i class='fa fa-list-alt fa-lg green space-left' aria-hidden='true'></i></a>";
							}
						$vString .= "</td>";//orders
						$vString .= "<td>".$vWishCount;
							if($vWishCount > 0){
								$vString .= "<a href='index.php?page=wishlist&type=client&id=".$vResults[0][$x]."'><i class='fa fa-list-alt fa-lg green space-left' aria-hidden='true' ".General::echoTooltip("bottom", "Besigtig wenslysitems")."></i></a>";
							}
						$vString .= "</td>";//wishlist
						$vString .= "<td class='dt-body-center' id='side-by-side'>";
							$vString .= "<i class='fa fa-floppy-o fa-lg green' aria-hidden='true' id='saveClient_".$vResults[0][$x]."' data-id='".$vResults[0][$x]."' ".General::echoTooltip("left", "Stoor die info")."></i>";
						$vString .= "</td>";//manage
					$vString .= "</tr>";
				}
			}
			else {
				$vString .= "<tr>";
					$vString .= "<td colspan='11'>Geen data gevind</td>";
				$vString .= "</tr>";
			}
				$vString .= "</tbody>";
			$vString .= "</table>";

	return General::prepareStringForDisplay($vString, $pConn);
	}

	public static function echoWishlist($pConn, $pData){
		$vOrder = "ORDER BY id desc";
		$vBindParams = array();
		$vBindLetters = "i";
		$vBindParams[] =& $pData['client_id'];
		$vLimit = "";
		$vWhere = " WHERE client_id = ?";
		$vResults = MysqlQuery::getWishlist($pConn, $vWhere, $vOrder, $vBindLetters, $vBindParams, $vLimit);
		//$vId, $vBookId, $vTitle, $vPrice, $vBlobPath, $vInStock

		$vCOrder = "";
		$vCBindParams = array();
		$vCBindLetters = "i";
		$vCBindParams[] =& $pData['client_id'];
		$vCLimit = "";
		$vCWhere = " WHERE id = ?";
		$vClientResults = MysqlQuery::getClients($pConn, $vCWhere, $vCOrder, $vCBindLetters, $vCBindParams, $vCLimit);
		$vString = "<h1>Kli&#235;nt wenslys</h1>";
		$vString .= "<h3>".$vClientResults[1][0]." ".$vClientResults[2][0]."</h3>";
		$vString .= "<table id='wishlistTable' class='cell-border dataTable hover' cellspacing='0'>";
			$vString .= "<thead>";
				$vString .= "<tr class='red'>";
					$vString .= "<th>Boek</th>";
					$vString .= "<th>Prys</th>";
					$vString .= " <th>In voorraad</th>";
				$vString .= "</tr>";
			$vString .= "</thead>";
			$vString .= "<tbody>";
			if(count($vResults[0]) > 0){
				for($x = 0; $x < count($vResults[0]); $x++){
					($vResults[18][$x] == 1 ? $vNewsletter = "Ja" : $vNewsletter = "Nee");
					$vString .= "<tr id='tr_".$vResults[0][$x]."'>";
						$vString .= "<td>".$vResults[2][$x]."</td>";//title
						$vString .= "<td>R ".$vResults[3][$x]."</td>";//price
						$vString .= "<td>".$vResults[5][$x]."</td>";//in stock
					$vString .= "</tr>";
				}
			}
			else {
				$vString .= "<tr>";
					$vString .= "<td colspan='3'>Geen data gevind</td>";
				$vString .= "</tr>";
			}
				$vString .= "</tbody>";
			$vString .= "</table>";

	return General::prepareStringForDisplay($vString, $pConn);
	}

	public static function echoCourier($pConn){
		$vResults = MysqlQuery::getCmsAllCourierCosts($pConn);//$vId, $vAf, $vEn, $vRate1, $vRate2, $vRate3, $vRate4, $vRate5, $vRate6, $vRate7
		$vString = "<h1>Koerierkoste</h1>";
		$vString .= "<div id='query-message'></div>";
		$vString .= "<table id='courierTable' class='cell-border dataTable hover' cellspacing='0'>";
			$vString .= "<thead>";
				$vString .= "<tr class='red'>";
					include "include/CourierTableHeadings.php";
				$vString .= "</tr>";
			$vString .= "</thead>";
			$vString .= "<tfoot>";
				$vString .= "<tr class='red'>";
					include "include/CourierTableHeadings.php";
				$vString .= "</tr>";
			$vString .= "</tfoot>";
			$vString .= "<tbody>";
			if(count($vResults[0]) > 0){
				for($x = 0; $x < count($vResults[0]); $x++){
					$vString .= "<tr id='tr_".$vResults[0][$x]."'>";
						$vString .= "<td><span style='display: none;'>".$vResults[1][$x]."</span>";
							$vString .= General::returnInput($pConn, "text", "af_".$vResults[0][$x], "af_".$vResults[0][$x], General::prepareStringForInputDisplay($vResults[1][$x]), 40, 100, "", "", "required", "", "");
						$vString .= "</td>";//af
						$vString .= "<td><span style='display: none;'>".$vResults[2][$x]."</span>";
							$vString .= General::returnInput($pConn, "text", "en_".$vResults[0][$x], "en_".$vResults[0][$x], General::prepareStringForInputDisplay($vResults[2][$x]), 40, 100, "", "", "required", "", "");
						$vString .= "</td>";//en
						$vString .= "<td><span style='display: none;'>".$vResults[3][$x]."</span>";
							$vString .= "R ".General::returnInput($pConn, "text", "rate_1_".$vResults[0][$x], "rate_1_".$vResults[0][$x], $vResults[3][$x], 10, 10, "", "", "required", "", "");
						$vString .= "</td>";//1
						$vString .= "<td><span style='display: none;'>".$vResults[4][$x]."</span>";
							$vString .= "R ".General::returnInput($pConn, "text", "rate_2_".$vResults[0][$x], "rate_2_".$vResults[0][$x], $vResults[4][$x], 10, 10, "", "", "required", "", "");
						$vString .= "</td>";//1
						$vString .= "<td><span style='display: none;'>".$vResults[5][$x]."</span>";
							$vString .= "R ".General::returnInput($pConn, "text", "rate_3_".$vResults[0][$x], "rate_3_".$vResults[0][$x], $vResults[5][$x], 10, 10, "", "", "required", "", "");
						$vString .= "</td>";//1
						$vString .= "<td><span style='display: none;'>".$vResults[6][$x]."</span>";
							$vString .= "R ".General::returnInput($pConn, "text", "rate_4_".$vResults[0][$x], "rate_4_".$vResults[0][$x], $vResults[6][$x], 10, 10, "", "", "required", "", "");
						$vString .= "</td>";//1
						$vString .= "<td><span style='display: none;'>".$vResults[7][$x]."</span>";
							$vString .= "R ".General::returnInput($pConn, "text", "rate_5_".$vResults[0][$x], "rate_5_".$vResults[0][$x], $vResults[7][$x], 10, 10, "", "", "required", "", "");
						$vString .= "</td>";//1
						$vString .= "<td><span style='display: none;'>".$vResults[8][$x]."</span>";
							$vString .= "R ".General::returnInput($pConn, "text", "rate_6_".$vResults[0][$x], "rate_6_".$vResults[0][$x], $vResults[8][$x], 10, 10, "", "", "required", "", "");
						$vString .= "</td>";//1
						$vString .= "<td><span style='display: none;'>".$vResults[9][$x]."</span>";
							$vString .= "R ".General::returnInput($pConn, "text", "rate_7_".$vResults[0][$x], "rate_7_".$vResults[0][$x], $vResults[9][$x], 10, 10, "", "", "required", "", "");
						$vString .= "</td>";//1
						$vString .= "<td class='dt-body-center' id='side-by-side'>";
							$vString .= "<i class='fa fa-floppy-o fa-lg saveCourierButton green' aria-hidden='true' id='saveCourierButton_".$vResults[0][$x]."' data-id='".$vResults[0][$x]."' ".General::echoTooltip("left", "Stoor die veranderinge")."></i>";
						$vString .= "</td>";//manage
					$vString .= "</tr>";
				}
			}
			else {
				$vString .= "<tr>";
					$vString .= "<td colspan='10'>Geen data gevind</td>";
				$vString .= "</tr>";
			}
				$vString .= "</tbody>";
			$vString .= "</table>";

	return General::prepareStringForDisplay($vString, $pConn);
	}

	public static function echoPublishers($pConn){
		$vResults = MysqlQuery::getPublishers($pConn);//$vPubId, $vPub, $vPubSupplier
		$vString = "<h1>Uitgewers</h1>";
		$vString .= "<div id='query-message'></div>";
		if(isset($_SESSION['SessionGrafCmsMessage']) && !empty($_SESSION['SessionGrafCmsMessage'])){
			$vString .= "<h5>".$_SESSION['SessionGrafCmsMessage']."</h5>";
			unset($_SESSION['SessionGrafCmsMessage']);
		}
		$vString .= "<form name='publishersForm' id='publishersForm' method='post' action='newsletters_process.php'>";
			$vString .= "<table id='publishersTable' class='cell-border dataTable hover' cellspacing='0'>";
				$vString .= "<thead>";
					$vString .= "<tr class='red'>";
						$vString .= "<th>Id</th>";
						$vString .= "<th>Uitgewer</th>";
						$vString .= "<th>Verskaffer</th>";
						$vString .= "<th class='dt-head-center'><a href='#add-publisher' role='button' data-toggle='modal'><i  class='fa fa-plus fa-lg green' aria-hidden='true' title='Laai nuwe uitgewer'></i></a></th>";
					$vString .= "</tr>";
				$vString .= "</thead>";
				$vString .= "<tfoot>";
					$vString .= "<tr class='red'>";
						$vString .= "<th>Id</th>";
						$vString .= "<th>Uitgewer</th>";
						$vString .= "<th>Verskaffer</th>";
						$vString .= "<th></th>";
					$vString .= "</tr>";
				$vString .= "</tfoot>";
				$vString .= "</tr>";
				$vString .= "<tbody>";
				if(count($vResults[0]) > 0){
					for($x = 0; $x < count($vResults[0]); $x++){
						$vString .= "<tr id='tr_".$vResults[0][$x]."'>";
							$vString .= "<td class='dt-body-center'>".$vResults[0][$x]."</td>";//id
							$vString .= "<td><span style='display: none;'>".$vResults[1][$x]."</span>";
								$vString .= General::returnInput($pConn, "text", "publisher_".$vResults[0][$x], "publisher_".$vResults[0][$x], General::prepareStringForInputDisplay($vResults[1][$x]), 50, 50, "", "", "required", "", "");
							$vString .= "</td>";//publisher
							$vString .= "<td><span style='display: none;'>".$vResults[2][$x]."</span>";
								$vString .= General::returnInput($pConn, "text", "supplier_".$vResults[0][$x], "supplier_".$vResults[0][$x], General::prepareStringForInputDisplay($vResults[2][$x]), 50, 50, "", "", "required", "", "");
							$vString .= "</td>";//supplier
							$vString .= "<td class='dt-body-center' id='side-by-side'>";
								$vString .= "<i class='fa fa-floppy-o fa-lg savePublisherButton green' aria-hidden='true' id='savePublisherButton_".$vResults[0][$x]."' data-id='".$vResults[0][$x]."' ".General::echoTooltip("left", "Stoor die veranderinge")."></i>";
								$vString .= "<i class='fa fa-times fa-lg red space-left' aria-hidden='true' id='deletePublisherButton_".$vResults[0][$x]."' data-id='".$vResults[0][$x]."' ".General::echoTooltip("left", "Vee uitgewer uit")."></i>";
							$vString .= "</td>";//manage
						$vString .= "</tr>";
					}
				}
				else {
					$vString .= "<tr>";
						$vString .= "<td colspan='17'>Geen data gevind</td>";
					$vString .= "</tr>";
				}
					$vString .= "</tbody>";
				$vString .= "</table>";
			$vString .= "<input type='hidden' name='type' value='add-newsletter'>";
			$vString .= "</form>";

	return General::prepareStringForDisplay($vString, $pConn);
	}

	public static function returnCmsNewsletters($pConn, $pData){
		$vDirectory = $pData['dir'];
		$vFiles = General::listDirectoryFiles($vDirectory);
		// $vFileSize, $vFileName, $vFileUrl

		$vString = "<h1>Nuusbriewe</h1>";
		$vString .= "<div id='query-message'></div>";
		if(isset($_SESSION['SessionGrafCmsMessage']) && !empty($_SESSION['SessionGrafCmsMessage'])){
			$vString .= "<h5>".$_SESSION['SessionGrafCmsMessage']."</h5>";
			unset($_SESSION['SessionGrafCmsMessage']);
		}
		$vString .= "<form name='newslettersForm' id='newslettersForm' method='post' enctype='multipart/form-data' action='newsletters_process.php'>";
		$vString .= "<table id='newslettersTable' class='cell-border dataTable hover' cellspacing='0'>";
			$vString .= "<thead>";
				$vString .= "<tr class='red'>";
					$vString .= "<th>L&#234;ernaam</th>";
					$vString .= "<th>Datum</th>";
					$vString .= "<th>L&#234;ergrootte</th>";
					$vString .= "<th></th>";
				$vString .= "</tr>";
			$vString .= "</thead>";
			$vString .= "<tfoot>";
				$vString .= "<tr class='red'>";
					$vString .= "<th>L&#234;ernaam</th>";
					$vString .= "<th>Datum</th>";
					$vString .= "<th>L&#234;ergrootte</th>";
					$vString .= "<th></th>";
				$vString .= "</tr>";
			$vString .= "</tfoot>";
			$vString .= "<tbody>";
			if(count($vFiles[0]) > 0){
				for($x = 0; $x < count($vFiles[0]); $x++){
					$vString .= "<tr>";
						$vString .= "<td>".$vFiles[2][$x]."<a href='".$vDirectory."/".$vFiles[2][$x]."' target='_blank' ".General::echoTooltip("right", "Maak l&#234;er oop").">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-file-pdf-o fa-lg green space-left' aria-hidden='true'></i></a></td>";//dir
						$vString .= "<td>".$vFiles[1][$x]."</td>";//date
						$vString .= "<td>".$vFiles[0][$x]."</td>";//size
						$vString .= "<td class='dt-body-center' id='side-by-side'>";
							$vString .= "<i class='fa fa-times fa-lg red' aria-hidden='true' id='deleteNewsletterButton_".$vResults[0][$x]."' data-id='".$vResults[0][$x]."' ".General::echoTooltip("left", "Vee nuusbrief uit")."></i>";
						$vString .= "</td>";//manage
					$vString .= "</tr>";
				}
			}
			else {
				$vString .= "<tr>";
					$vString .= "<td colspan='4'>Geen data gevind</td>";
				$vString .= "</tr>";
			}
					$vString .= "<tr id='new_tr'>";
						$vString .= "<td>";
								$vString .= General::returnInput($pConn, "file", "newsletter_blob_path", "newsletter_blob_path", "", 50, 50, "", "", "required", "", "accept='.pdf'");
					            $vString .= "<div>";
									  $vString .= "<div class='red'>NB!! L&#234;ernaam moet Nuusbrief datum wees! Formaat: dd_mm_yyyy.pdf (30_01_2017.pdf)</div>";
								$vString .= "</div>";
						$vString .= "</td>";//File
						$vString .= "<td></td>";//size
						$vString .= "<td></td>";//size
						$vString .= "<td class='dt-body-center' style='display: table-cell;'>";
							$vString .= "<i class='fa fa-plus fa-lg green' aria-hidden='true'  id='addNewslettersButton' title='Laai nuwe nuusbrief'></i>";
						$vString .= "</td>";//manage
					$vString .= "</tr>";
			$vString .= "</table>";

	            $vString .= "<article>";
		            $vString .= "<div>";
						  $vString .= "<div id='submitError' class='error' style='display:none;'>Kies asb. 'n nuusbrief om te laai.</div>";
						  $vString .= "<div id='fileTypeError' class='error' style='display:none;'>Slegs .pdf l&#234;ers word toegelaat. Kies asb. die regte formaat nuusbrief.</div>";
						  $vString .= "<div id='fileSizeError' class='error' style='display:none;'>Die prent se l&#234;ergrootte is te groot (maksimum 1MB word toegelaat). Optimaliseer die l&#234;er asb.</div>";
					$vString .= "</div>";
				$vString .= "</article>";
				$vString .= "<input type='hidden' name='type' value='add-newsletter'>";
			$vString .= "</form>";

		return General::prepareStringForDisplay($vString);
	}

	public static function echoUsers($pConn, $pData){
		$vResults = MysqlQuery::getUsers($pConn);//$vId, $vName, $vSurname, $vEmail, $vSections, $vRights
		$vSections = MysqlQuery::getCmsLookup($pConn, "cms_sections");
		$vRightsValue = array(1,4);
		$vRightsDisplay = array("Normaal", "Admin");
		$vString = "<h1>Gebruikers</h1>";
		$vString .= "<div id='query-message'></div>";
		if(isset($_SESSION['SessionGrafCmsMessage']) && !empty($_SESSION['SessionGrafCmsMessage'])){
			$vString .= "<h5>".$_SESSION['SessionGrafCmsMessage']."</h5>";
			unset($_SESSION['SessionGrafCmsMessage']);
		}
		$vString .= "<form name='usersForm' id='usersForm' method='post' action='users_process.php'>";
			$vString .= "<table id='usersTable' class='cell-border dataTable hover' cellspacing='0'>";
				$vString .= "<thead>";
					$vString .= "<tr class='red'>";
						$vString .= "<th>Name</th>";
						$vString .= "<th>Surname</th>";
						$vString .= "<th>Epos</th>";
						$vString .= "<th>Seksies</th>";
						$vString .= "<th>Regte</th>";
						$vString .= "<th>Nuwe wagwoord</th>";
						$vString .= "<th></th>";
					$vString .= "</tr>";
				$vString .= "</thead>";
				$vString .= "<tfoot>";
					$vString .= "<tr class='red'>";
						$vString .= "<th>Name</th>";
						$vString .= "<th>Surname</th>";
						$vString .= "<th>Epos</th>";
						$vString .= "<th>Seksies</th>";
						$vString .= "<th>Regte</th>";
						$vString .= "<th>Nuwe wagwoord</th>";
						$vString .= "<th></th>";
					$vString .= "</tr>";
				$vString .= "</tfoot>";
				$vString .= "<tbody>";
				if(count($vResults[0]) > 0){
					for($x = 0; $x < count($vResults[0]); $x++){
						$vString .= "<tr id='tr_".$vResults[0][$x]."'>";
							$vString .= "<td><span style='display: none;'>".$vResults[1][$x]."</span>";
								$vString .= General::returnInput($pConn, "text", "name_".$vResults[0][$x], "name_".$vResults[0][$x], General::prepareStringForInputDisplay($vResults[1][$x]), 25, 30, "", "", "required", "", "");
							$vString .= "</td>";//name
							$vString .= "<td><span style='display: none;'>".$vResults[2][$x]."</span>";
								$vString .= General::returnInput($pConn, "text", "surname_".$vResults[0][$x], "surname_".$vResults[0][$x], General::prepareStringForInputDisplay($vResults[2][$x]), 25, 30, "", "", "required", "", "");
							$vString .= "</td>";//surname
							$vString .= "<td><span style='display: none;'>".$vResults[3][$x]."</span>";
								$vString .= General::returnInput($pConn, "text", "email_".$vResults[0][$x], "email_".$vResults[0][$x], General::prepareStringForInputDisplay($vResults[3][$x]), 30, 50, "", "", "required", "", "");
							$vString .= "</td>";//email
							$vString .= "<td>";
								for($s = 0; $s < count($vSections[0]); $s++){
									(in_array($vSections[1][$s], $vResults[4][$x]) ? $vChecked = "checked='checked'" : $vChecked = "");
									$vString .= "<span class='keep-together'><input type='checkbox' name='sections_".$vResults[0][$x]."[]' id='sections_".$vResults[0][$x]."' value='".$vSections[1][$s]."' ".$vChecked." class='space-right'>";
									$vString .= "<label for='".$vSections[1][$s]."' class='space-left'>".$vSections[1][$s]."</label></span>";
								}
							$vString .= "</td>";//sections
							$vString .= "<td>";
								$vString .= General::returnSelect($pConn, $vResults[5][$x], "rights_".$vResults[0][$x], "rights_".$vResults[0][$x], $vRightsValue, $vRightsDisplay, "", "", "required");
							$vString .= "</td>";//rights
							$vString .= "<td>";
								$vString .= General::returnInput($pConn, "text", "password_".$vResults[0][$x], "password_".$vResults[0][$x], "", 15, 20, "", "", "", "", "");
							$vString .= "</td>";//password
							$vString .= "<td class='dt-body-center' id='side-by-side'>";
								$vString .= "<i class='fa fa-floppy-o fa-lg saveUserButton green' aria-hidden='true' id='saveUserButton_".$vResults[0][$x]."' data-id='".$vResults[0][$x]."' ".General::echoTooltip("left", "Stoor die veranderinge")."></i>";
								$vString .= "<i class='fa fa-times fa-lg red space-left' aria-hidden='true' id='deleteUserButton_".$vResults[0][$x]."' data-id='".$vResults[0][$x]."' ".General::echoTooltip("left", "Vee gebruiker uit")."></i>";
							$vString .= "</td>";//manage
						$vString .= "</tr>";
					}
				}
				else {
					$vString .= "<tr>";
						$vString .= "<td colspan='7'>Geen data gevind</td>";
					$vString .= "</tr>";
				}
				$vString .= "<tr id='new_tr'>";
						$vString .= "<td><span style='display: none;'>Zz</span>";
							$vString .= General::returnInput($pConn, "text", "name", "name", "", 30, 30, "", "", "required", "", "");
						$vString .= "</td>";//name
						$vString .= "<td><span style='display: none;'>".$vResults[2][$x]."</span>";
							$vString .= General::returnInput($pConn, "text", "surname", "surname","", 30, 30, "", "", "required", "", "");
						$vString .= "</td>";//surname
						$vString .= "<td><span style='display: none;'>".$vResults[3][$x]."</span>";
							$vString .= General::returnInput($pConn, "text", "email", "email", "", 30, 50, "", "", "required", "", "");
						$vString .= "</td>";//email
						$vString .= "<td id='rights-td'>";
							for($s = 0; $s < count($vSections[0]); $s++){
								$vString .= "<span class='keep-together'><input type='checkbox' name='sections[]' id='sections' value='".$vSections[1][$s]."' class='space-right'>";
								$vString .= "<label for='".$vSections[1][$s]."' class='space-left'>".$vSections[1][$s]."</label></span>";
							}
						$vString .= "</td>";//sections
						$vString .= "<td>";
							$vString .= General::returnSelect($pConn, "", "rights", "rights", $vRightsValue, $vRightsDisplay, "", "", "required");
						$vString .= "</td>";//rights
						$vString .= "<td>";
							$vString .= General::returnInput($pConn, "text", "password", "password", "", 15, 20, "", "", "", "", "");
						$vString .= "</td>";//password
						$vString .= "<td class='dt-body-center' id='side-by-side'>";
							$vString .= "<i class='fa fa-plus fa-lg addUserButton green' aria-hidden='true' id='addUserButton' ".General::echoTooltip("left", "Stoor die nuwe gebruiker")."></i>";
						$vString .= "</td>";//manage
				$vString .= "</tr>";
			$vString .= "</table>";

            $vString .= "<article>";
	            $vString .= "<div>";
					  $vString .= "<div id='submitError' class='error' style='display:none;'>Voltooi asb. al die velde</div>";
				$vString .= "</div>";
			$vString .= "</article>";
			$vString .= "<input type='hidden' name='type' value='add-sql'>";
		$vString .= "</form>";

	return General::prepareStringForDisplay($vString, $pConn);
	}

	public static function echoEvents($pConn, $pData){
		$vBindParams = array();
		$vBindLetters = "";
		if($pData['type'] == "past"){
			$vWhere = "WHERE date <  ?";
			$vOrder = " ORDER BY date DESC";
			$vValue = $_SESSION['now_date'];
			$vBindLetters .= "s";
			$vBindParams[] = & $vValue;
			$vLimit = "";
		}
		else if($pData['type'] == "future"){
			$vWhere = "WHERE date >=  ?";
			$vOrder = " ORDER BY date DESC";
			$vValue = $_SESSION['now_date'] ;
			$vBindLetters .= "s";
			$vBindParams[] = & $vValue;
			$vLimit = "";
		}
		($pData['type'] == "past" ? $vDisabled = "disabled='true'" : $vDisabled = "");
		$vResults = MysqlQuery::getEvents($pConn, $vWhere, $vOrder, $vBindLetters, $vBindParams, $vLimit);
		//$vId, $vName, $vDetail, $vDate, $vTime, $vRsvp, $vPrice, $vLocation, $vPosterPath
		//	0			1						2				3				4					5				6					7						8
		$vString .= "<h1>Funksies</h1>";
		if(isset($_SESSION['SessionGrafCmsMessage']) && !empty($_SESSION['SessionGrafCmsMessage'])){
			$vString .= "<h5>".$_SESSION['SessionGrafCmsMessage']."</h5>";
			unset($_SESSION['SessionGrafCmsMessage']);
		}
		  $vString .= "<article>";
            $vString .= "<div>";
				  $vString .= "<div id='submitError' class='error' style='display:none;'>Voltooi asb. al die velde</div>";
			$vString .= "</div>";
		$vString .= "</article>";
			$vString .= "<table id='eventsTable' class='cell-border dataTable hover' cellspacing='0'>";
				$vString .= "<thead>";
					$vString .= "<tr class='red'>";
						include "include/EventsTableHeadings.php";
					$vString .= "</tr>";
				$vString .= "</thead>";
				$vString .= "<tfoot>";
					$vString .= "<tr class='red'>";
						include "include/EventsTableHeadings.php";
					$vString .= "</tr>";
				$vString .= "</tfoot>";
				$vString .= "<tbody>";
				if(count($vResults[0]) > 0){
					for($x = 0; $x < count($vResults[0]); $x++){
							$vEventsImages = MysqlQuery::getEventImages($pConn, $vResults[0][$x]);//$vId, $vEventId, $vBlobPath
							$vString .= "<tr id='tr_".$vResults[0][$x]."'>";
								$vString .= "<td><span class='hidden-input'>".$vResults[1][$x]."</span>";
									$vString .= General::returnInput($pConn, "text", "name_".$vResults[0][$x], "name_".$vResults[0][$x], $vResults[1][$x],25, 100, "", "", $vRequired, "",$vDisabled);
								$vString .= "</td>";//name
								$vString .= "<td><span class='hidden-input'>".$vResults[3][$x]."</span>";
									$vString .= General::returnInput($pConn, "date", "date_".$vResults[0][$x], "date_".$vResults[0][$x], $vResults[3][$x], 10, 15, "", "", $vRequired, "", $vDisabled);
								$vString .= "</td>";//date
								$vString .= "<td><span class='hidden-input'>".$vResults[4][$x]."</span>";
									$vString .= General::returnInput($pConn, "text", "time_".$vResults[0][$x], "time_".$vResults[0][$x], $vResults[4][$x], 10, 20, "", "", $vRequired, "", $vDisabled);
								$vString .= "</td>";//time
								$vString .= "<td><span class='hidden-input'>".$vResults[2][$x]."</span>";
									$vString .= General::returnTextarea($pConn, "detail_".$vResults[0][$x], "detail_".$vResults[0][$x], General::prepareStringForInputDisplay($vResults[2][$x]), 40, 4, 1000, "", $vDisabled);
								$vString .= "</td>";//detail
								$vString .= "<td><span class='hidden-input'>".$vResults[5][$x]."</span>";
									$vString .= General::returnInput($pConn, "date", "rsvp_".$vResults[0][$x], "rsvp_".$vResults[0][$x], $vResults[5][$x], 10, 15, "", "", $vRequired, "",$vDisabled);
								$vString .= "</td>";//rsvp
								$vString .= "<td><span class='hidden-input'>".$vResults[6][$x]."</span>";
									$vString .= General::returnInput($pConn, "text", "price_".$vResults[0][$x], "price_".$vResults[0][$x], $vResults[6][$x], 4, 5, "", "", $vRequired, "", $vDisabled);
								$vString .= "</td>";//price
								$vString .= "<td><span class='hidden-input'>".$vResults[7][$x]."</span>";
									$vString .= General::returnInput($pConn, "text", "location_".$vResults[0][$x], "location_".$vResults[0][$x], $vResults[7][$x], 50, 60, "", "", $vRequired, "", $vDisabled);
								$vString .= "</td>";//loaction
								$vString .= "<td class='dt-body-center'>";
									(!empty($vResults[8][$x]) ? $vString .=  "<img src='../images/posters/".$vResults[8][$x]."' class='thumb'>" : $vString .= "");
								$vString .= "</td>";//poster
								$vString .= "<td class='dt-body-center'>";
									if(count($vEventsImages[0]) > 0){
										for($i = 0; $i < 1; $i++){
											//$vString .= "<a href='../images/events/".$vEventsImages[2][$i]."' data-lightbox='event".$vResults[0][$x]."' data-title='".$vEventsImages[3][$i]."'>";
											$vString .=  "<img src='../images/events/".$vEventsImages[2][$i]."' class='thumb'>";
											//$vString.= "</a>";
										}
										$vString .= "<br><span class='message'>".count($vEventsImages[0])." foto's</span>";
									}
								$vString .= "</td>";//images
								$vString .= "<td class='dt-body-center' id='side-by-side'>";
									if($pData['type'] == "future"){
										$vString .= "<i class='fa fa-floppy-o fa-lg green' aria-hidden='true' id='saveEventsButton_".$vResults[0][$x]."' data-id='".$vResults[0][$x]."' ".General::echoTooltip("left", "Stoor die veranderinge")."></i>";
									}
									$vString .= "<a href='index.php?page=events&type=edit&id=".$vResults[0][$x]."' role='button' data-toggle='modal'><i class='fa fa-pencil fa-lg space-top green space-left' aria-hidden='true' id='editEventsButton_".$vResults[0][$x]."' data-id='".$vResults[0][$x]."' ".General::echoTooltip("left", "Verander boek info")."></i></a>";
									if(count($vEventsImages[0]) > 0){
										$vString .= "<a href='index.php?page=events&type=edit-photos&id=".$vResults[0][$x]."&title=".urlencode($vResults[1][$x])."' role='button' data-toggle='modal'><i class='fa fa-file-image-o fa-lg space-top green space-left' aria-hidden='true' id='editEventsPhotosButton_".$vResults[0][$x]."' data-id='".$vResults[0][$x]."' ".General::echoTooltip("left", "Verander foto beskrywings")."></i></a>";
									}
									$vString .= "<i class='fa fa-times fa-lg space-top red space-left' aria-hidden='true' id='deleteEventsButton_".$vResults[0][$x]."' data-id='".$vResults[0][$x]."' ".General::echoTooltip("left", "Vee boek uit")."></i>";
								$vString .= "</td>";//manage
							$vString .= "</tr>";
							$vString .= "<input type='hidden' name='type' id='type' value='photos'>";
					}
				}
				else {
					$vString .= "<tr>";
						$vString .= "<td colspan='10'>Geen data gevind</td>";
						$vString .= "</tr>";
				}
					$vString .= "</tbody>";
				$vString .= "</table>";
	return General::prepareStringForDisplay($vString, $pConn);
	}

	public static function echoEventsPerId($pConn, $pData){
		$vBindParams = array();
		$vBindLetters = "";
		$vWhere = "WHERE id =  ?";
		$vOrder = "";
		$vValue = $pData['id'];
		$vBindLetters .= "i";
		$vBindParams[] = & $vValue;

		$vResults = MysqlQuery::getEvents($pConn, $vWhere, $vOrder, $vBindLetters, $vBindParams, "LIMIT 1");
		$vEventsImages = MysqlQuery::getEventImages($pConn, $vResults[0][0]);//$vId, $vEventId, $vBlobPath, $vDescription

		($pData['type'] == "edit" ? $vHeading = "VERANDER FUNKSIE" : $vHeading = "LAAI NUWE FUNKSIE");
		$vString = "<article>";
			$vString .= "<h1>".$vHeading."</h1>";
			if(isset($_SESSION['SessionGrafCmsMessage']) && !empty($_SESSION['SessionGrafCmsMessage'])){
				$vString .= "<h5>".$_SESSION['SessionGrafCmsMessage']."</h5>";
				unset($_SESSION['SessionGrafCmsMessage']);
			}
//$vId, $vName, $vDetail, $vDate, $vTime, $vRsvp, $vPrice, $vLocation, $vPosterPath
//0					1					2				3					4				5				6					7							8
			$vString .= "<form name='eventsForm' id='eventsForm' method='post' enctype='multipart/form-data' action='events_process.php'>";
				$vString .= "<div class='border'>";
					$vString .= "<label for='name'>Funkise:</label>";
					$vString .= General::returnInput($pConn, "text", "name", "name", $vResults[1][0], 100, 100, "", "", "required", "", "");
					$vString .= "<span class='compulsory'><i class='fa fa-asterisk' aria-hidden='true'></i></span>";
				$vString .= "</div>";
				$vString .= "<div class='border'>";
					$vString .= "<label for='date'>Datum:</label>";
					$vString .= General::returnInput($pConn, "date", "date", "date", $vResults[3][0], 20, 20, "", "", "required", "", "");
					$vString .= "<span class='compulsory'><i class='fa fa-asterisk' aria-hidden='true'></i></span>";
				$vString .= "</div>";
				$vString .= "<div class='border'>";
					$vString .= "<label for='time'>Tyd:</label>";
					$vString .= General::returnInput($pConn, "text", "time", "time", $vResults[4][0],20, 20, "bv. 12:00 vir/for 12:30", "", "required", "", "");
					$vString .= "<span class='compulsory'><i class='fa fa-asterisk' aria-hidden='true'></i></span>";
				$vString .= "</div>";
				$vString .= "<div class='border'>";
					$vString .= "<label for='date'>Plek:</label>";
					$vString .= General::returnInput($pConn, "text", "location", "location", $vResults[7][0], 100, 150, "", "", "required", "", "");
					$vString .= "<span class='compulsory'><i class='fa fa-asterisk' aria-hidden='true'></i></span>";
				$vString .= "</div>";
				$vString .= "<div class='border'>";
					$vString .= "<label for='detail'>Detail:</label>";
					$vString .= General::returnTextarea($pConn, "detail", "detail", General::prepareStringForInputDisplay($vResults[2][0]), 130, 10, 3000, "", "");
				$vString .= "</div>";
				$vString .= "<div class='border'>";
					$vString .= "<label for='rsvp'>RSVP:</label>";
					$vString .= General::returnInput($pConn, "date", "rsvp", "rsvp", $vResults[5][0], 20, 20, "", "", "required", "", "");
					$vString .= "<span class='compulsory'><i class='fa fa-asterisk' aria-hidden='true'></i></span>";
				$vString .= "</div>";
				$vString .= "<div class='border'>";
					$vString .= "<label for='price'>Prys:</label>";
					$vString .= General::returnInput($pConn, "text", "price", "price", $vResults[6][0], 6, 6, "", "", "required", "", "");
					$vString .= "<span class='compulsory'><i class='fa fa-asterisk' aria-hidden='true'></i></span>";
				$vString .= "</div>";
				$vString .= "<div>";
					$vString .= "<div id='priceError' class='error' style='display:none;'>Slegs getalle word toegelaat bv. 100.<br>Verwyder alle punte(.), spasies en kommas(,)!</div>";
				$vString .= "</div>";
				if(!empty($vResults[8][0])){
					$vString .= "<div class='space-top space-bottom'>";
						$vString .= "<label for='blob_path'>Advertensie:</label>";
						$vString .= "<a href='../images/posters/".$vResults[8][0]."' data-lightbox='".$vResults[8][0]."'>";
							$vString .= "<img  src='../images/posters/".$vResults[8][0]."' class='thumb space-right'>";
						$vString .= "</a>";
						$vString .= "<a href='#'  id='deleteEventImage' data-id='".$vResults[0][0]."' data-path='".$vResults[8][0]."' ".General::echoTooltip("right", "Vee advertensie uit")."<i class='fa fa-times fa-lg space left red' aria-hidden='true'></i></a>";
					$vString .= "</div>";
				}
				$vString .= "<div class='border'>";
					if($pData['type'] == "edit"){
						$vString .= "<label for='url-file'>Verander advertensie:</label>";
					}
					else {
						$vString .= "<label for='url-file'>Advertensie:</label>";
					}
					$vString .= "<input type='file' class='small' name='poster_path' id='poster_path' accept='.gif,.jpg,.jpeg,.png' value='' size='50' maxlength='50'>";
					$vString .= "<div>";
						  $vString .= "<div id='filePosterError' class='error' style='display:none;'>Slegs .gif, .jpg, .jpeg, .png prente toegelaat</div>";
						  $vString .= "<div id='filePosterSizeError' class='error' style='display:none;'>Die voorblad is te groot. Slegs 1MB l&#234;ergrootte word toegelaat!</div>";
						  $vString .= "<div id='filePosterPhysicalWidthError' class='error' style='display:none;'>Die prent is te groot. Die wydte mag nie meer as 900 pixels wyd wees nie.</div>";
						  $vString .= "<div id='filePosterPhysicalHeightError' class='error' style='display:none;'>Die prent is te groot. Die prent mag nie meer as 900 pixels hoog wees nie.</div>";
					$vString .= "</div>";
				$vString .= "</div>";
				if($vResults[3][$x] <=  $_SESSION['now_date']){
					if(count($vEventsImages[0]) > 0){
						$vString .= "<div class='space-top space-bottom'>";
							$vString .= "<label for='url-file'>Foto's gelaai:</label>";
							for($i = 0; $i < count($vEventsImages[0]); $i++){
								$vString .= "<figure class='space-bottom space-top inline'>";
									$vString .= "<a href='../images/events/".$vEventsImages[2][$i]."' data-lightbox='".$vEventsImages[2][$i]."'>";
										$vString .=  "<img src='../images/events/".$vEventsImages[2][$i]."' class='thumb space-right'>";
									$vString .= "</a>";
									$vString .= "<figcaption class='text-small'>".$vEventsImages[3][$i]."</figcaption>";
									$vString .= "<a href='#'  id='deleteEventPhoto' data-id='".$vEventsImages[0][$i]."' data-path='".$vEventsImages[2][$i]."' data-return='event' data-event='".$vResults[0][0]."' ".General::echoTooltip("right", "<< Vee die foto uit")."<i class='fa fa-times fa-lg space left red space-right' aria-hidden='true'></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
								$vString .= "</figure>";
							}
						$vString .= "</div>";
					}
					$vString .= "<div class='border'>";
						$vString .= "<label for='url-file'>Laai foto's:</label>";
						$vString .= "<input type='file' class='small' name='photos[]' id='photos_".$vResults[0][$x]."' accept='.gif,.jpg,.jpeg,.png' value='' data-id='".$vResults[0][$x]."' size='50' maxlength='50' multiple='' directory='' webkitdirectory='' mozdirectory=''>";
						$vString .= "<div>";
							$vString .= "<div id='filePhotosError_".$vResults[0][$x]."' class='error' style='display:none;'>- Slegs .gif, .jpg, .jpeg, .png foto's toegelaat. Een of meer van die items is nie in die regte formaat nie.</div>";
							$vString .= "<div id='filePhotosSizeError_".$vResults[0][$x]."' class='error' style='display:none;'>- Ten minste een van die foto's is te groot. Slegs 500KB l&#234;ergrootte word toegelaat!</div>";
						$vString .= "</div>";
					$vString .= "</div>";
				}
				$vString .= "<div>";
					$vString .= "<div class='message-bottom'><span class='compulsory'><i class='fa fa-asterisk' aria-hidden='true'></i></span> Verpligte velde</div>";
				$vString .= "</div>";

	            $vString .= "<div>";
					  $vString .= "<div id='submitError' class='error' style='display:none;'>Voltooi asseblief die verpligte velde</div>";
				$vString .= "</div>";

				$vString .= "<div>";
					$vString .= "<input type='button' id='submitEvent' value='Stoor'>";
				$vString .= "</div>";

				$vString .= "<input type='hidden' name='id' value='".$vResults[0][0]."'>";
				$vString .= "<input type='hidden' name='page' value='events'>";
				$vString .= "<input type='hidden' name='type' value='".$pData['type']."-sql'>";
				$vString .= "<input type='hidden' name='current_poster_path' id='current_poster_path' value='".$vResults[8][0]."'>";
			$vString .= "</form>";
		$vString .= "</article>";
	return General::prepareStringForDisplay($vString, $pConn);
	}

	public static function echoEventPhotos($pConn, $pData){
		$vEventsImages = MysqlQuery::getEventImages($pConn, $pData['id']);//$vId, $vEventId, $vBlobPath, $vDescription

		$vString = "<article>";
			$vString .= "<h1>FUNKSIE FOTO'S</h1>";
			$vString .= "<h2>".urldecode($pData['title'])."</h2>";
			if(isset($_SESSION['SessionGrafCmsMessage']) && !empty($_SESSION['SessionGrafCmsMessage'])){
				$vString .= "<h5>".$_SESSION['SessionGrafCmsMessage']."</h5>";
				unset($_SESSION['SessionGrafCmsMessage']);
			}
			$vString .= "<form name='photosForm' id='photosForm' method='post' enctype='multipart/form-data' action='events_process.php'>";
				$vString .= "<div class='space-top space-bottom'>";
					for($i = 0; $i < count($vEventsImages[0]); $i++){
					$vString .= "<figure class='space-bottom space-top wide'>";
						$vString .= "<a href='../images/events/".$vEventsImages[2][$i]."' data-lightbox='".$vEventsImages[2][$i]."'>";
							$vString .=  "<img src='../images/events/".$vEventsImages[2][$i]."' class='thumb space-right'>";
						$vString .= "</a>";
						$vString .= "<a href='#'  id='deleteEventPhoto' data-id='".$vEventsImages[0][$i]."' data-path='".$vEventsImages[2][$i]."' data-event='".$pData['id']."' data-return='photo' ".General::echoTooltip("right", "<< Vee die foto uit")."<i class='fa fa-times fa-lg space left red space-right' aria-hidden='true'></i></a>";
						$vString .= "<figcaption class='space-top'>".General::returnInput($pConn, "text", "description_".$vEventsImages[0][$i], "description_".$vEventsImages[0][$i], $vEventsImages[3][$i], 70, 100, "", "", "", "", "")."</figcaption>";
					$vString .= "</figure>";
					$vString .= "<hr class='lgray'>";
					$vString .= "<input type='hidden' name='image_id' value='".$vEventsImages['0'][$i]."'>";
				}
				$vString .= "</div>";
				$vString .= "<div>";
					$vString .= "<input type='submit' id='submitPhotosEvent' value='Stoor'>";
				$vString .= "</div>";
				$vString .= "<input type='hidden' name='page' value='events'>";
				$vString .= "<input type='hidden' name='photo_id_array' value='".implode(",", $vEventsImages[0])."'>";
				$vString .= "<input type='hidden' name='title' value='".urlencode($pData['title'])."'>";
				$vString .= "<input type='hidden' name='id' value='".$pData['id']."'>";
				$vString .= "<input type='hidden' name='type' value='".$pData['type']."-sql'>";
			$vString .= "</form>";
		$vString .= "</article>";
	return General::prepareStringForDisplay($vString, $pConn);
	}

	public static function echoStockUpdate($pConn, $pBatchType){
	    $vString = "";
		$vString .= "<div class='b-space-left'>";
			$vString .= "<h1>Laai ".($pBatchType == 'music' ? 'Musiek' : '')." voorraadlys op</h1>";
			$vString .= "<h2>Kies die lys om op te laai</h2>";
			$vString .= "<article>";
				$vString .= "<form name='stockUpdateForm' id='stockUpdateForm' method='post' enctype='multipart/form-data' action='batch_process.php'>";
					$vString .= "<div class='space-top space-bottom'>";
						$vString .= General::returnInput($pConn, "file", "stock_file", "stock_file", "", 50, 100, "", "", "required", "", "");
					$vString .= "</div>";
					$vString .= "<div class='space-top space-bottom'>";
						$vString .= "<label><input type='submit' value='Laai op' id='submitFile'></label>";
                        ($pBatchType == 'music' ? $vUpdateType = 'stock_update_music' : $vUpdateType = 'stock_update');
						$vString .= "<input type='hidden' name='type' value='".$vUpdateType."'>";
						$vString .= "<input type='hidden' name='page' value='batch'>";
					$vString .= "</div>";
					$vString .= "<div>";
						  $vString .= "<div id='fileTypeError' class='error' style='display:none;'>Slegs .xls en .xlsx l&#234;ers toegelaat</div>";
						  $vString .= "<div id='fileCompleteError' class='error' style='display:none;'>Kies 'n l&#234;er om op te laai</div>";
					$vString .= "</div>";
					$vString .= "<div class='message-bottom space-left'>";
						$vString .= "- L&#234;er moet in Microsoft Excel (<b>.xlsx OR .xls</b>) formaat wees, met 'n <b>Opskrif ry</b><br>";
						$vString .= "- Kolom volgorde:";
						$vString .= "<ul class='space-left'>";
							$vString .= "<li class='space-left'>Eerste kolom (A) = ISBN</li>";
							$vString .= "<li class='space-left'>Tweede kolom (B) = 'On hand'</li>";
							$vString .= "<li class='space-left'>Derde kolom (C) = 'On hold'</li>";
							$vString .= "<li class='space-left'>Vierde kolom (D) = 'Available (On hand - On hold)'</li>";
						$vString .= "</ul>";
					$vString .= "</div>";
				$vString .= "</form>";
				$vString .= "<div>";
					$vString .= "<figure class='space-left'>";
						$vString .= "<br><img src='images/stock.png' title='Voorbeeld'>";
					$vString .= "</figure>";
				$vString .= "</div>";
			$vString .= "</article>";
		$vString .= "</div>";
		return General::prepareStringForDisplay($vString, $pConn);
	}

	public static function echoOutOfPrint($pConn){
		$vString .= "<div class='b-space-left'>";
			$vString .= "<h1>Laai 'UIT DRUK' lys op</h1>";
			$vString .= "<h2>Kies die lys om op te laai</h2>";
			$vString .= "<article>";
				$vString .= "<form name='outOfPrintForm' id='outOfPrintForm' method='post' enctype='multipart/form-data' action='batch_process.php'>";
					$vString .= "<div class='space-top space-bottom'>";
						$vString .= General::returnInput($pConn, "file", "out_of_print_file", "out_of_print_file", "", 50, 100, "", "", "required", "", "");
					$vString .= "</div>";
					$vString .= "<div class='space-top space-bottom'>";
						$vString .= "<label><input type='submit' value='Laai op' id='submitFile'></label>";
					$vString .= "</div>";
					$vString .= "<input type='hidden' name='type' value='out_of_print'>";
					$vString .= "<input type='hidden' name='page' value='batch'>";
					$vString .= "<div>";
						  $vString .= "<div id='fileTypeError' class='error' style='display:none;'>Slegs .xls en .xlsx l&#234;ers toegelaat</div>";
						  $vString .= "<div id='fileCompleteError' class='error' style='display:none;'>Kies 'n l&#234;er om op te laai</div>";
					$vString .= "</div>";
				$vString .= "<div class='message-bottom space-left'>";
					$vString .= "- L&#234;er moet in Microsoft Excel (<b>.xlsx OR .xls</b>) formaat wees, met 'n <b>Opskrif ry</b><br>";
					$vString .= "- Kolom volgorde:";
					$vString .= "<ul class='space-left'>";
						$vString .= "<li class='space-left'>Eerste kolom (A) = ISBN</li>";
					$vString .= "</ul>";
					$vString .= "</div>";
				$vString .= "</form>";
				$vString .= "<div>";
					$vString .= "<figure class='space-left'>";
						$vString .= "<br><img src='images/out_of_print.png' title='Voorbeeld'>";
					$vString .= "</figure>";
				$vString .= "</div>";
			$vString .= "</article>";
		$vString .= "</div>";
		return General::prepareStringForDisplay($vString, $pConn);
	}

	public static function echoLoadBookList($pConn){
		$vString .= "<div class='b-space-left'>";
			$vString .= "<h1>Laai boekelys</h1>";
			$vString .= "<h2>Kies die lys om op te laai</h2>";
			$vString .= "<article>";
				$vString .= "<form name='loadBookListForm' id='loadBookListForm' method='post' enctype='multipart/form-data' action='batch_process.php'>";
					$vString .= "<div class='space-top space-bottom'>";
						$vString .= General::returnInput($pConn, "file", "load_book_list_file", "load_book_list_file", "", 50, 100, "", "", "required", "", "");
					$vString .= "</div>";
					$vString .= "<div class='space-top space-bottom'>";
						$vString .= "<label><input type='submit' value='Laai op' id='submitFile'></label>";
					$vString .= "</div>";
					$vString .= "<input type='hidden' name='type' value='load_book_list'>";
					$vString .= "<input type='hidden' name='page' value='batch'>";
					$vString .= "<div>";
						  $vString .= "<div id='fileTypeError' class='error' style='display:none;'>Slegs .xls en .xlsx l&#234;ers toegelaat</div>";
						  $vString .= "<div id='fileCompleteError' class='error' style='display:none;'>Kies 'n l&#234;er om op te laai</div>";
					$vString .= "</div>";
				$vString .= "<div class='message-bottom space-left'>";
					$vString .= "- L&#234;er moet in Microsoft Excel (<b>.xlsx OR .xls</b>) formaat wees, met 'n <b>Opskrif ry</b><br>";
					$vString .= "- Kolom volgorde:";
					$vString .= "<ul class='space-left'>";
						$vString .= "<li class='space-left'>Kolom A = ISBN</li>";
						$vString .= "<li class='space-left'>Kolom B = Kategorie</li>";
						$vString .= "<li class='space-left'>Kolom C = Sub-kategorie</li>";
						$vString .= "<li class='space-left'>Kolom D = Titel</li>";
						$vString .= "<li class='space-left'>Kolom E = Opsomming</li>";
						$vString .= "<li class='space-left'>Kolom F = Outeur (<b>NB! Skei name met kommas, geen spasie e.g. Anisa Fielding,Cornel Strydom</b>)</li>";
						$vString .= "<li class='space-left'>Kolom G = Illustreerder (<b>NB! Skei name met komma, geen spasie e.g. Anisa Fielding,Cornel Strydom</b>)</li>";
						$vString .= "<li class='space-left'>Kolom H = Vertaler (<b>NB! Skei name met komma, geen spasie e.g. Anisa Fielding,Cornel Strydom</b>)</li>";
						$vString .= "<li class='space-left'>Kolom I = Prys (<b>NB! Geen desimale e.g. 70</b>)</li>";
						$vString .= "<li class='space-left'>Kolom J = Publikasie datum (<b>NB! yyyy-mm-dd e.g 2017-05-21</b>)</li>";
						$vString .= "<li class='space-left'>Kolom K = Dimensies</li>";
						$vString .= "<li class='space-left'>Kolom L = Gewig (<b>NB! In gram</b>)</li>";
						$vString .= "<li class='space-left'>Kolom M = Formaat (<b>NB! 36 = Sagteband | 37 = Hardeband</b>)</li>";
						$vString .= "<li class='space-left'>Kolom N = Aantal bladsye</li>";
						$vString .= "<li class='space-left'>Kolom O = Uitgewer</li>";
						$vString .= "<li class='space-left'>Kolom P = Taal (<b>NB! af = Afrikaans | en = Engels</b>)</li>";
					$vString .= "</ul>";
					$vString .= "</div>";
				$vString .= "</form>";
				$vString .= "<div>";
					$vString .= "<figure class='space-left'>";
						$vString .= "<br><img src='images/book_list.png' title='Voorbeeld'>";
					$vString .= "</figure>";
				$vString .= "</div>";
			$vString .= "</article>";
		$vString .= "</div>";
		return General::prepareStringForDisplay($vString, $pConn);
	}

	public static function echoLoadInPrintPublisher($pConn){
		$vString .= "<div class='b-space-left'>";
			$vString .= "<h1>Laai 'In Druk' per Uitgewer</h1>";
			$vString .= "<h2>Kies die Uitgewer en boekelys om op te laai</h2>";
			$vString .= "<article>";
				$vString .= "<form name='inPrintPublisherForm' id='inPrintPublisherForm' method='post' enctype='multipart/form-data' action='batch_process.php'>";
					$vString .= "<div class='ui-widget space-top space-bottom'>";
						$vString .= "<label for='publisher-id-select space-right'>Tik Uitgewer naam / Id in en kies 'n Uitgewer:</label><br>";
						$vString .= General::returnInput($pConn, "text", "publisher-id-select", "publisher-id-select", "",40, 100, "", "", "required", "", "");
					$vString .= "</div>";
					$vString .= "<div class='space-top space-bottom'>";
						$vString .= "<label for='publisher-input space-right'>Boekelys:</label><br>";
						$vString .= General::returnInput($pConn, "file", "in_print_file", "in_print_file", "", 40, 100, "", "", "required", "", "");
					$vString .= "</div>";
					$vString .= "<div class='space-top space-bottom'>";
						$vString .= "<label><input type='submit' value='Laai op' id='submitFile'></label>";
					$vString .= "</div>";
					$vString .= "<input type='hidden' name='type' value='in_print_publisher'>";
					$vString .= "<input type='hidden' name='page' value='batch'>";
					$vString .= "<input type='hidden' id='publisher-id' name='publisher-id' value=''>";
					$vString .= "<div>";
						  $vString .= "<div id='fileTypeError' class='error' style='display:none;'>Slegs .xls en .xlsx l&#234;ers toegelaat</div>";
						  $vString .= "<div id='fileCompleteError' class='error' style='display:none;'>Kies 'n l&#234;er om op te laai</div>";
					$vString .= "</div>";
				$vString .= "<div class='message-bottom space-left'>";
					$vString .= "- L&#234;er moet in Microsoft Excel (<b>.xlsx OR .xls</b>) formaat wees, met 'n <b>Opskrif ry</b><br>";
					$vString .= "- Kolom volgorde:";
					$vString .= "<ul class='space-left'>";
						$vString .= "<li class='space-left'>Eerste kolom (A) = ISBN</li>";
					$vString .= "</ul>";
					$vString .= "</div>";
				$vString .= "</form>";
				$vString .= "<div>";
					$vString .= "<figure class='space-left'>";
						$vString .= "<br><img src='images/in_print_publisher.png' title='Voorbeeld'>";
					$vString .= "</figure>";
				$vString .= "</div>";
			$vString .= "</article>";
		$vString .= "</div>";
		return General::prepareStringForDisplay($vString, $pConn);
	}

	public static function echoLoadPriceList($pConn){
		$vString .= "<div class='b-space-left'>";
			$vString .= "<h1>Laai pryslys</h1>";
			$vString .= "<h2>Kies die lys om op te laai</h2>";
			$vString .= "<article>";
				$vString .= "<form name='loadPriceListForm' id='loadPriceListForm' method='post' enctype='multipart/form-data' action='batch_process.php'>";
					$vString .= "<div class='space-top space-bottom'>";
						$vString .= General::returnInput($pConn, "file", "load_price_list_file", "load_price_list_file", "", 50, 100, "", "", "required", "", "");
					$vString .= "</div>";
					$vString .= "<div class='space-top space-bottom'>";
						$vString .= "<label><input type='submit' value='Laai op' id='submitFile'></label>";
					$vString .= "</div>";
					$vString .= "<input type='hidden' name='type' value='load_price_list'>";
					$vString .= "<input type='hidden' name='page' value='batch'>";
					$vString .= "<div>";
						  $vString .= "<div id='fileTypeError' class='error' style='display:none;'>Slegs .xls en .xlsx l&#234;ers toegelaat</div>";
						  $vString .= "<div id='fileCompleteError' class='error' style='display:none;'>Kies 'n l&#234;er om op te laai</div>";
					$vString .= "</div>";
				$vString .= "<div class='message-bottom space-left'>";
					$vString .= "- L&#234;er moet in Microsoft Excel (<b>.xlsx OR .xls</b>) formaat wees, met 'n <b>Opskrif ry</b><br>";
					$vString .= "- Kolom volgorde:";
					$vString .= "<ul class='space-left'>";
						$vString .= "<li class='space-left'>Kolom A = ISBN</li>";
						$vString .= "<li class='space-left'>Kolom B = Prys</li>";
					$vString .= "</ul>";
					$vString .= "</div>";
				$vString .= "</form>";
				$vString .= "<div>";
					$vString .= "<figure class='space-left'>";
						$vString .= "<br><img src='images/price_list.png' title='Voorbeeld'>";
					$vString .= "</figure>";
				$vString .= "</div>";
			$vString .= "</article>";
		$vString .= "</div>";
		return General::prepareStringForDisplay($vString, $pConn);
	}

	public static function echoLoadImages($pConn){
		$vString .= "<div class='b-space-left'>";
			$vString .= "<h1>Laai boeke voorblaaie</h1>";
			$vString .= "<h2>Kies 'n le&#234;r met prente om op te laai</h2>";
			$vString .= "<article>";
				$vString .= "<form name='loadImagesForm' id='loadImagesForm' method='post' enctype='multipart/form-data' action='batch_process.php'>";
					$vString .= "<div class='border'>";
						$vString .= "<input type='file' class='small' name='images[]' id='images' accept='.gif,.jpg,.jpeg,.png' value='' size='50' maxlength='50' multiple='' directory='' webkitdirectory='' mozdirectory=''>";
						$vString .= "</div>";
						$vString .= "<div class='message-bottom'>Slegs 'n maksimum van 45 prente per le&#234;r word toegelaat<div>";
						$vString .= "<div class='space-top space-bottom'>";
							$vString .= "<label><input type='submit' value='Laai op' id='submitFile'></label>";
						$vString .= "</div>";
						$vString .= "<input type='hidden' name='type' value='load_images' id='type'>";
						$vString .= "<input type='hidden' name='page' value='batch'>";
						$vString .= "<div>";
							$vString .= "<div id='fileImagesError' class='error' style='display:none;'>- Slegs .gif, .jpg, .jpeg, .png foto's toegelaat. Een of meer van die items is nie in die regte formaat nie.</div>";
							$vString .= "<div id='fileImagesSizeError' class='error' style='display:none;'>- Ten minste een van die foto's is te groot. Slegs 500KB l&#234;ergrootte word toegelaat!</div>";
							$vString .= "<div id='fileImagesNumberError' class='error' style='display:none;'>Slegs 'n maksimum van 45 prente per le&#234;r word toegelaat</div>";
						$vString .= "</div>";
					$vString .= "</div>";
				$vString .= "</form>";
			$vString .= "</article>";
		$vString .= "</div>";
		return General::prepareStringForDisplay($vString, $pConn);
	}

    public static function echoCompetionList($pConn, $vTypeC){
        $vOperator = ($vTypeC == 1 ? ">" : "<=");
        $vOrder = "ORDER BY id desc";
        $vValue = date("Y-m-d");
        $vBindParams = array();
        $vBindLetters = "s";
        $vBindParams[] =& $vValue;
        $vLimit = "";
        $vWhere = " WHERE date_end ".$vOperator." ?";
        $vResults = MysqlQuery::getCompetitions($pConn, $vWhere, $vOrder, $vBindLetters, $vBindParams, $vLimit);
        //$id, $name, $date_created, $date_end, $description, $blob_path, $winner

        $vString = "<h1>Kompetisies</h1>";
        $vString .= "<div id='query-message'></div>";
            $vString .= "<form name='competitionForm' id='competitionForm' method='post' enctype='multipart/form-data' action='competition_process.php'>";
            $vString .= "<input type='hidden' name='type' id='type' value='add' />";
            $vString .= "<input type='hidden' name='id' id='id' value='0' />";
        $vString .= "<table id='competitionTable' class='cell-border dataTable hover'>";
            $vString .= "<thead>";
            $vString .= "<tr class='red'>";
                $vString .= "<th>Naam</th>";
                $vString .= "<th>Beskrywing</th>";
                $vString .= "<th>Datum eindig</th>";
                $vString .= " <th>Prent</th>";
                $vString .= " <th>Aktief</th>";
                $vString .= " <th>Wenner</th>";
                $vString .= " <th>Action</th>";
            $vString .= "</tr>";
            $vString .= "</thead>";
//            $vString .= "<tbody>";
            if(isset($vResults['id']) && count($vResults['id']) > 0) {
                for ($x = 0; $x < count($vResults['id']); $x++) {
                    $vWinners = "";
                    if(!empty($vResults['winner'][$x])) {
                        $vWOrder = "ORDER BY name ASC";
                        $vWValue = $vResults['winner'][$x];
                        $vWValue2 = $vResults['id'][$x];
                        $vWBindParams = array();
                        $vWBindLetters = "i";
                        $vWBindParams[] =& $vWValue2;
                        $vWLimit = "";
                        $vWWhere = " WHERE id in (".$vWValue.") and competition_id = ?";
                        $vResultsWinner = MysqlQuery::getCompetitionWinners($pConn, $vWWhere, $vWOrder, $vWBindLetters, $vWBindParams, $vWLimit);
                        $vWinners = implode("<br>-&nbsp;", $vResultsWinner['winner']);
                    }
                    else if (empty($vResults['winner'][$x])) {
                        $vEOrder = "ORDER BY name, surname ASC";
                        $vEValue = $vResults['id'][$x];
                        $vEBindParams = array();
                        $vEBindLetters = "i";
                        $vEBindParams[] =& $vEValue;
                        $vEWhere = " WHERE competition_id = ?";
                        $vEntryResults = MysqlQuery::getCompetitionEntries($pConn, $vEWhere, $vEOrder, $vEBindLetters, $vEBindParams, "");
                    }
                    $vString .= "<tr id='com_tr_".$vResults['id'][$x]."'>";
                        $vString .= "<td><input class='small' size='40' type='text' name='name' id='name".$vResults['id'][$x]."' value='".$vResults['name'][$x]."' required></td>";
                        $vString .= "<td><textarea class='small' cols='80' rows='3' name='description' id='description".$vResults['id'][$x]."' required>" . $vResults['description'][$x] . "</textarea></td>";
                        $vString .= "<td><input class='small' size='10' type='datetime-local' name='date_end' id='date_end".$vResults['id'][$x]."' value='".$vResults['date_end'][$x]."' required></td>";
                        $vString .= "<td>";
                        if(!empty($vResults['blob_path'][$x])){
                            $vString .= "<div class='border'>";
                                $vString .= "<figure class='border'>";
                                    $vString .= "<a href='../images/competitions/".$vResults['blob_path'][$x]."' data-lightbox='".$vResults['blob_path'][$x]."'>";
                                        $vString .= "<img class='img-responsive' src='../images/competitions/".$vResults['blob_path'][$x]."' class='thumb'>";
                                    $vString .= "</a>";
                                    $vString .= "<input type='hidden' name='current_blob_path' id='current_blob_path".$vResults['id'][$x]."' value='".$vResults['blob_path'][$x]."'>";
                                $vString .= "</figure>";
                            $vString .= "</div>";
                        }
                        else {
                            $vString .= "<div class='border'>None loaded</div>";
                        }
                        $vString .= "</td>";
                        $vString .= "<td>";
                            $vString .= "<select name='valid".$vResults['id'][$x]."' id='valid".$vResults['id'][$x]."'>";
                                $vString .= "<option value='1' ".($vResults['valid'][$x] == 1 ? 'selected': '').">Ja</option>";
                                $vString .= "<option value='0' ".($vResults['valid'][$x] == 0 ? 'selected': '').">Nee</option>";
                            $vString .= "</select>";
                        $vString .= "</td>";
                        $vString .= "<td>";
                            if(!empty($vResults['winner'][$x])){
                                $vString .= "- ".$vWinners;
                            }
                            else if(empty($vResults['winner'][$x]) && count($vEntryResults) > 0) {
                                $vString .= "<select multiple='multiple' size='5' data-id='".$vResults['id'][$x]."' name='winnerSelect" . $vResults['id'][$x] . "[]' id='winnerSelect" . $vResults['id'][$x] . "'>";
                                for ($e = 0; $e < count($vEntryResults['id']); $e++) {
                                    $vString .= "<option value='" . $vEntryResults['id'][$e] . "'>" . $vEntryResults['name'][$e] . " " . $vEntryResults['surname'][$e] . " (" . $vEntryResults['email'][$e] . ")</option>";
                                }
                                $vString .= "</select>";
                                $vString .= "<div id='winner_display".$vResults['id'][$x]."'></div>";
                            }
                            else {
                                $vString .= "No entries";
                            }
                            $vString .= "<input type='hidden' name='winner".$vResults['id'][$x]."' id='winner".$vResults['id'][$x]."' value='' />";
                        $vString .= "</td>";
                        $vString .= "<td>";
                            $vString .= "<i class='fa fa-floppy-o fa-lg green' id='saveCompButton".$vResults['id'][$x]."' data-id='".$vResults['id'][$x]."' ".General::echoTooltip("left", "Stoor die veranderinge")." onClick='updateCompetition(".$vResults['id'][$x].");'></i>&nbsp;&nbsp;";
                        $vString .= "</td>";
                    $vString .= "</tr>";
                }
            }

            $vString .= "<tr id='0'>";
                $vString .= "<td><input class='small' size='40' type='text' name='name0' id='name0' value='' required='required'></td>";
                $vString .= "<td><input class='small' size='60' type='text' name='description0' id='description0' value='' required='required'></td>";
                $vString .= "<td><input class='small' size='10' type='datetime-local' name='date_end0' id='date_end0' value='' required='required'></td>";
                $vString .= "<td>";
                    $vString .= "<div class='border'>";
                        $vString .= "<input type='file' class='small' required='required' name='blob_path0' id='blob_path0' accept='.gif,.jpg,.jpeg,.png' value='' size='50' maxlength='50' onChange='checkDocType(0, this.value, 'img', 'competitionForm');'>";
                        $vString .= "<div>";
                            $vString .= "<div id='fileError0' class='error' style='display:none;'>Slegs .gif, .jpg, .jpeg, .png prente toegelaat</div>";
                            $vString .= "<div id='fileSizeError0' class='error' style='display:none;'>Die voorblad is te groot. Slegs 1MB l&#234;ergrootte word toegelaat!</div>";
                        $vString .= "</div>";
                    $vString .= "</div>";
                $vString .= "</td>";
                $vString .= "<td>";
                    $vString .= "<select name='valid0' id='valid0'>";
                        $vString .= "<option value='1'>Ja</option>";
                        $vString .= "<option value='0'>Nee</option>";
                    $vString .= "</select>";
                $vString .= "</td>";
                $vString .= "<td></td>";
                $vString .= "<td>";
                        $vString .= "<input class='btn-success btn-xs' type='submit' value='Laai' id='SubmitComp'>";
                $vString .= "</td>";

            $vString .= "</tr>";

        $vString .= "</tbody>";
        $vString .= "</table>";
                $vString .= "</form>";
//        return General::prepareStringForDisplay($vString, $pConn);
        return $vString;
    }

}

?>