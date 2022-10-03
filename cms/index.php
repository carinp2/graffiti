<?php

/**
 * @author Carin Pretorius - CEIT Development
 * Created on 2016-09-22
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

$vPage = ($_REQUEST['page'] ?? "home");
$vType = ($_REQUEST['type'] ?? "");
$vId = ($_REQUEST['id'] ?? 0);

if($vPage != "export"){
	$vBegin = $vCmsParts->returnBeginHtml();
	echo $vBegin;

	if(isset($_SESSION['SessionGrafCmsUserId'])){
		$vMenu = $vCmsParts->returnTopMenu($conn, $vPage);
		echo $vMenu;
	}

	$vContent = $vCmsParts->returnContentStart();
	echo $vContent;
}

if(!isset($_SESSION['SessionGrafCmsUserId']) && $vPage != "login"){
	$vLogin = $vCmsParts->returnLogin($conn);
	echo $vLogin;
}
else if(!isset($_SESSION['SessionGrafCmsUserId']) && $vPage == "login"){
	$vUsername = $vRequest->getParameter('username');
	$vPassword = $vRequest->getParameter('password');
	$vDateMinTwoMonths = $_SESSION['date_min_two_month'];
	MysqlQuery::doCmsLogin($conn, $vUsername, $vPassword, $vDateMinTwoMonths);
}
else if(isset($_SESSION['SessionGrafCmsUserId'])){
	if($vPage != "home"){
		$vSubMenu = $vCmsParts->returnSubMenu($conn, $vPage, $vType);
		echo $vSubMenu;
	}
	if($vPage == "home"){
		$vHome = $vCmsParts->returnHome($conn);
		echo $vHome;
	}
	else if($vPage == "register"){
		$vName = $vRequest->getParameter('name');
		$vSurname = $vRequest->getParameter('surname');
		$vPassword = $vRequest->getParameter('pass');
		$vEmail = $vRequest->getParameter('email');
		MysqlQuery::doRegister($conn, $vName, $vSurname, $vPassword, $vEmail);
	}
	else if($vPage == "register-return"){
		if($vType == "success"){
			$vRegister = $vCmsParts->returnRegister($conn, $vType);
			echo $vRegister;
		}
		else if($vType == "unsuccess"){
			$vRegister =  $vCmsParts->returnRegister($conn, $vType);
			echo $vRegister;
		}
	}
	else if($vPage == "logout"){
		$vCmsParts->doLogout();
	}
	else if($vPage == "books"){
		$vData['type'] = $vType;
		$vData['id'] = $vId;
		if($vType == "list" || $vType == "list_new" || $vType == "list_latest_loaded" || $vType == "no_summary" || $vType == "publisher" || $vType == "searchBook" || $vType == "searchBookPublisher" || $vType == "searchBookSubCategory" || $vType == "searchBookAuthor" || $vType == "searchBookTitle" || $vType== "list_stationary" || $vType == "searchStationarySupplier" || $vType == "list_tv" || $vType == "list_rr"){
			$vBooks = $vCmsParts->echoBooks($conn, $vData);
			echo $vBooks;
		}
		else if($vType == "edit" || $vType == "add" || $vType == "add_stat"){
			if($vType == "add"){
				unset($_SESSION['SessionGrafCmsReturnUrl']);
			}
			$vOneBook = $vCmsParts->echoBookPerId($conn, $vData);
			echo $vOneBook;
		}
	}
	else if($vPage == "landing"){
		$vData['type'] = $vType;
		if($vType == "images"){
			$vRotatingImages = $vCmsParts->echoRotatingImages($conn, $vData);
			echo $vRotatingImages;
		}
		else{
			$vLanding = $vCmsParts->echoLanding($conn, $vData);
			echo $vLanding;
		}
	}
	else if($vPage == "language"){
		$vLanguage = $vCmsParts->echoLanguage($conn);
		echo $vLanguage;
	}
	else if($vPage == "orders"){
		$vData['type'] = $vType;
		if($vData['type'] != 'isbn'){
			$vData['client_id'] = $vId;
			$vOrders = $vCmsParts->echoOrders($conn, $vData);
		}
		else if($vData['type'] == 'isbn'){
			$vData['isbn'] = $vId;
			$vOrders = $vCmsParts->echoOrderBooks($conn, $vData);
		}
		echo $vOrders;
	}
	else if($vPage == "clients"){
		$vData['type'] = $vType;
		if($vType == "searchClient"){
			$vData['client_id'] = $_POST['client_id'];
			$vData['client'] = strtolower($_POST['client']);
		}
		else {
			$vData['client_id'] = $vId;
		}
		$vClients = $vCmsParts->echoClients($conn, $vData);
		echo $vClients;
	}
	else if($vPage == "wishlist"){
		$vData['type'] = $vType;
		$vData['client_id'] = $vId;
		$vWishlist = $vCmsParts->echoWishlist($conn, $vData);
		echo $vWishlist;
	}
	else if($vPage == "courier"){
		$vCourier = $vCmsParts->echoCourier($conn, $vData);
		echo $vCourier;
	}
	else if($vPage == "publishers"){
		$vPublishers = $vCmsParts->echoPublishers($conn, $vData);
		echo $vPublishers;
	}
	else if($vPage == "newsletters"){
		$vData['dir'] = "../documents/newsletters";
		$vNewsletters = $vCmsParts::returnCmsNewsletters($conn, $vData);
		echo $vNewsletters;
	}
	else if($vPage == "users"){
		$vData['type'] = $vType;
		$vData['user_id'] = $vId;
		$vUsers = $vCmsParts->echoUsers($conn, $vData);
		echo $vUsers;
	}
	else if($vPage == "events"){
		$vData['type'] = $vType;
		$vData['id'] = $vId;
		if($vType == "future" || $vType == "past"){
			$vEvents = $vCmsParts->echoEvents($conn, $vData);
			echo $vEvents;
		}
		else if($vType == "edit" || $vType == "add"){
			$vOneEvent = $vCmsParts->echoEventsPerId($conn, $vData);
			echo $vOneEvent;
		}
		else if($vType == "edit-photos"){
			$vData['title']  =  $vRequest->getParameter('title');
			$vPhotoEvent = $vCmsParts->echoEventPhotos($conn, $vData);
			echo $vPhotoEvent;
		}
	}
	else if($vPage == "batch"){
		if($vType == "stock_update"){
			$vBatch = $vCmsParts->echoStockUpdate($conn, 'books');
			echo $vBatch;
		}
		else if($vType == "stock_update_music"){
			$vBatch = $vCmsParts->echoStockUpdate($conn, 'music');
			echo $vBatch;
		}
		else if($vType == "out_of_print"){
			$vBatch = $vCmsParts->echoOutOfPrint($conn);
			echo $vBatch;
		}
		else if($vType == "load_book_list"){
			$vBatch = $vCmsParts->echoLoadBookList($conn);
			echo $vBatch;
		}
		else if($vType == "in_print_publisher"){
			$vBatch = $vCmsParts->echoLoadInPrintPublisher($conn);
			echo $vBatch;
		}
		else if($vType == "load_price_list"){
			$vBatch = $vCmsParts->echoLoadPriceList($conn);
			echo $vBatch;
		}
		else if($vType == "load_images"){
			$vBatch = $vCmsParts->echoLoadImages($conn);
			echo $vBatch;
		}
	}
	else if($vPage  == "export"){
		$vData['type'] =  $vType;
		$vData['id']  =  $vId;
		if($vType  == "books-publisher"){
			$vExcel->getBookExport($conn, $vData);
		}
	}
    else if($vPage  == "competitions"){
        $vData['type'] =  $vType;
        $vData['id']  =  $vId;
        if($vType  == "list_1"){
            $vCompetition = $vCmsParts->echoCompetionList($conn, 1);
        }
        if($vType  == "list_0"){
            $vCompetition = $vCmsParts->echoCompetionList($conn, 0);
        }
        echo $vCompetition;
    }
}

if($vPage != "export"){
	$vEnd = $vCmsParts->returnEndHtml($conn);
	echo $vEnd;
	include "../include/connect/CloseConnect.php";
}
?>