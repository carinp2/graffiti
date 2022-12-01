<?php
/**
 * @author Carin Pretorius - CEIT Development
 * Created on 2016-11_03
 */
//session_cache_limiter('must-revalidate');
//session_cache_expire(60);
session_start();

require_once ("application/classes/General.class.php");
$vGeneral = new General();

include "application/config/session_config.php";
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
require_once ("application/classes/Modal.class.php");
$vModal= new Modal();
require_once ("application/classes/Client.class.php");
$vClient= new Client();
require_once ("application/resources/PasswordHashClass.php");



$vString = "";
//$vPage = $vRequest->getParameter('page');
$vPage = (isset($_REQUEST['page']) ? $_REQUEST['page'] : "Tuisblad");
//(empty($vPage) ? $vPage = "Tuisblad" : $vPage = $vPage);

//Change Language start
if(isset($_REQUEST['lang']) && ($_REQUEST['lang'] != $_SESSION['SessionGrafLanguage'])){
	$vLang = $_REQUEST['lang'];
	unset($_SESSION['SessionGrafLanguage']);
	$_SESSION['SessionGrafLanguage'] = $vLang;
}
include_once "application/config/session_menu.php";

if($vPage == "Logout"){
	include "include/AdminQueries.php";
}
else {
	$vValue = (isset($_REQUEST['id']) ? $_REQUEST['id'] : "");
	$vParam = (isset($_REQUEST['cat']) ? $_REQUEST['cat'] : "");
	$vSubCatId = (isset($_REQUEST['c_id']) ? $_REQUEST['c_id'] : "");
	$vHtmlBegin = $vParts->getHtmlBegin($conn, $vPage, $vValue, $vParam, $vSubCatId);
	echo $vHtmlBegin;

	$vSections = $vQuery->getSections($conn, "", "ORDER BY sort_order", 0);//$vId, $vSection, $vUrl, $vDescription, $vSortOrder
	$vHeader = $vParts->getHeader($conn, $vSections);
	echo $vHeader;
	$vTopMenu = $vParts->getTopMenu($conn, $vPage, $vSections);
	echo $vTopMenu;
		if($vPage == "Home" || $vPage == "Tuisblad"){
			$vCarousel = $vPages->returnCarousel($conn);
			echo $vCarousel;

			$vMainBodyTop = $vParts->getMainBodyTop($conn);
			echo $vMainBodyTop;

			$vNewBooksAf = $vPages->returnBooks($conn, 204, "af");//204 =  Nuwe vrystellings
			echo $vNewBooksAf;

			$vTopBooksAf = $vPages->returnBooks($conn, 209, "af");//209 = Topverkopers
			echo $vTopBooksAf;

 			$vNewBooksEn = $vPages->returnBooks($conn, 204, "en");//204 = New releases
			echo $vNewBooksEn;

			$vTopBooksEn = $vPages->returnBooks($conn, 209, "en");//209 = Bestsellers
			echo $vTopBooksEn;

			$vNewChildrenBooks = $vPages->returnBooks($conn, 446, "all");//206 = Nuut Kinders / New Children
			echo $vNewChildrenBooks;

			$vTopChildrenBooks = $vPages->returnBooks($conn, 447, "all");//206 = Topverkopers Kinders / Bestsellers Children
			echo $vTopChildrenBooks;

 			$vSpecialBooks = $vPages->returnBooks($conn, 208, "all");//208 = Winskopies/Specials
 			echo $vSpecialBooks;

			$vSoonBooks = $vPages->returnBooks($conn, 206, "all");//206 = Binnekort/Comming soon
			echo $vSoonBooks;

			$vMainBodyBottom = $vParts->getMainBodyBottom();
			echo $vMainBodyBottom;
		}
		else {
			$vPagesTop = $vParts->getPagesPageTop($conn);
			echo $vPagesTop;
			if($vPage == "Register" || $vPage == "Registreer" || $vPage == "Profiel" || $vPage == "Profile"){
				$vId = $_REQUEST['id'];
				$vTemp = (isset($_REQUEST['temp']) ? $_REQUEST['temp'] : 0);
				$vRegister = $vPages->returnRegisterForm($conn, $vId, $vTemp);//TODO checked
				echo $vRegister;
			}
			else if($vPage == "Verifieer" || $vPage == "Verify"){
				include "include/AdminQueries.php";
			}
			else if($vPage == "NuweVrystellings" || $vPage == "NewReleases" || $vPage == "Topverkopers" || $vPage == "Bestsellers" || $vPage == "Winskopies" || $vPage == "Specials" || $vPage == "Binnekort" || $vPage == "ComingSoon" || $vPage == "Winskopies-Specials" || $vPage == "Binnekort-ComingSoon" || $vPage == "NuutKinders-NewChildren" || $vPage == "TopverkopersKinders-BestsellersChildren"){
				$vTypeId = $vRequest->getParameter('id');
				$vLanguage = $vRequest->getParameter('temp');
				$vSort = urldecode($vRequest->getParameter('rand'));
				if($vPage == "Topverkopers" || $vPage == "Bestsellers" || $vPage == "TopverkopersKinders-BestsellersChildren"){
					(empty($vSort) ? $vSort = "top_seller_rank ASC" : $vSort = $vSort);
				}
				else if($vPage == "Specials" || $vPage == "Winskopies-Specials"){
//					(empty($vSort) ? $vSort = "special_rank ASC" : $vSort = $vSort); --Leonie request on 27/01/2022 via whatsapp
					(empty($vSort) ? $vSort = "in_stock DESC" : $vSort = $vSort);
				}
				else if($vPage == "NewReleases" || $vPage == "NuweVrystellings"){
					(empty($vSort) ? $vSort = "new_rank ASC" : $vSort = $vSort);
				}
				else if($vPage == "Binnekort-ComingSoon"){
					(empty($vSort) ? $vSort = "soon_rank ASC, date_publish DESC" : $vSort = $vSort);
				}
				else{
					(empty($vSort) ? $vSort = "date_publish DESC" : $vSort = $vSort);
				}
				$vMorePages = $vPages->returnMorePages($conn, $vTypeId, $vSort, $vLanguage);
				echo $vMorePages;
			}
			else if($vPage == "Boeke" || $vPage == "Books"){
				$vSearchData['page'] = $vRequest->getParameter('page');
				$vSearchData['lang'] = $vRequest->getParameter('lang');
				$vSearchData['id'] = $vRequest->getParameter('id');
				$vSearchData['title'] = $vRequest->getParameter('temp');
				$vSearchData['type'] = "b";
				$vMorePages = $vPages->returnResultPages($conn, $vSearchData);
				echo $vMorePages;
			}
			else if($vPage == "Boek" || $vPage == "Book"){
				$vSearchData['page'] = $vRequest->getParameter('page');
				$vSearchData['lang'] = $vRequest->getParameter('lang');
				$vSearchData['id'] = $vRequest->getParameter('id');
				$vSearchData['title'] = $vRequest->getParameter('temp');
				$vSearchData['type'] = "book-id";
				$vMorePages = $vPages->returnResultPages($conn, $vSearchData);
				echo $vMorePages;
			}
			else if($vPage == "BoekI" || $vPage == "BookI"){
				$vSearchData['page'] = $vRequest->getParameter('page');
				$vSearchData['lang'] = $vRequest->getParameter('lang');
				$vSearchData['isbn'] = $vRequest->getParameter('isbn');
				$vSearchData['title'] = $vRequest->getParameter('temp');
				$vSearchData['type'] = "book-isbn";
				$vMorePages = $vPages->returnResultPages($conn, $vSearchData);
				echo $vMorePages;
			}
			else if($vPage == "Skryfbehoeftes" || $vPage == "Stationery"){
				$vSearchData['page'] = $vRequest->getParameter('page');
				$vSearchData['lang'] = $vRequest->getParameter('lang');
				($vSearchData['lang'] == "af" ? $vSearchData['type'] = "Skryfbehoeftes" : $vSearchData['type'] = "Stationery");
				$vSearchData['subcat_id'] = 164;
				$vSearchData['cat_id'] = 3;
				$vMorePages = $vPages->returnResultPages($conn, $vSearchData);
				echo $vMorePages;
			}
			else if($vPage == "CheckOut" || $vPage == "BestelNou"){
				$vClientId = $vRequest->getParameter('id');
				$vCheckoutForm = $vPages->returnCheckoutForm($conn, $vClientId);
				echo $vCheckoutForm;
			}
			else if($vPage == "CheckOutCourier" || $vPage == "BestelNouKoerier"){
				$vClientId = $vRequest->getParameter('id');
				$vCheckoutCourierForm = $vPages->returnCheckoutCourierForm($conn, $vClientId);
				echo $vCheckoutCourierForm;
			}
			else if($vPage == "Betaling" || $vPage == "Payment"){
				include_once 'include/OrderQueries.php';

				$vCheckoutPaymentForm = $vPages->returnCheckoutPaymentForm($conn, $vData);
				echo $vCheckoutPaymentForm;
			}
			else if($vPage == "BestelFinaal" || $vPage == "OrderFinal"){
				$vPt = $vRequest->getParameter('payment_type');
				if($vPt != 57){
					$vLoadingPage = $vPages->returnLoadingPage($conn);
					echo $vLoadingPage;
				}
				include_once 'include/OrderQueries.php';
			}
			else if($vPage == "BestellingSukses" || $vPage == "OrderSuccess"){
				$vPaymentType = $vRequest->getParameter('id');
                $vOrderId = $vRequest->getParameter('temp');
				if($vPaymentType == 16 || $vPaymentType == 57){//16 = EFT | 57 = Zapper
					$vData['client_id'] = $vRequest->getParameter('client_id');
					$vData['temp_salt'] = $vRequest->getParameter('temp_salt');
					$vData['reference'] = $vRequest->getParameter('reference');
					$vData['lang'] = $vRequest->getParameter('lang');
					include_once 'include/OrderQueries.php';
					$vPaymentResult = 0;
				}
				if($vPaymentType != 16 && $vPaymentType != 57){//15 = Credit card| 17 = Instant EFT
					$vPaymentType = $_POST['VARIABLE3'];//15 = Credit card| 17 = Instant EFT
					$vData['client_id'] = $_POST['VARIABLE2'];
					$vData['temp_salt'] = $_POST['VARIABLE1'];
					$vPaymentResult = $_POST['_RESULT'];
//                    $vOrderInfo = $vQuery->getOrdersInfo($conn, $vOrderId);

					if ($vPaymentResult == 0) {//Success
						$vData['reference'] = $vOrderId;
						$vData['price'] = $_POST['_AMOUNT'];
//                        $vData['client_id'] = $vOrderInfo[0];
//                        $vData['temp_salt'] = $vOrderInfo[1];
//                        $vPaymentResult = 0;
//                        $vData['price'] = $vOrderInfo[2];
						$vData['payment_type'] = $vPaymentType;

						include_once 'include/OrderQueries.php';
					}
				}
				$vOrderConfirmation = $vPages->returnOrderCondfirmation($conn, $vPaymentType, $vPaymentResult, $vData);
				echo $vOrderConfirmation;
			}
			else if($vPage == "BestellingFout" || $vPage == "OrderError"){
				$vPaymentType = $vRequest->getParameter('id');
                $vOrderId = $vRequest->getParameter('temp');
				$vPaymentResult = $_POST['_RESULT'];
				$vData['error_code'] = $_POST['_ERROR_CODE'];
				$vData['error_message'] = $_POST['_ERROR_MESSAGE'];
				$vData['error_detail'] = $_POST['_ERROR_DETAIL'];
				$vData['error_source'] = $_POST['_ERROR_SOURCE'];
				$vData['bank_error_code'] = $_POST['_BANK_ERROR_CODE'];
				$vData['bank_error_message'] = $_POST['_BANK_ERROR_MESSAGE'];
				$vData['reference'] = $vOrderId;
				$vData['price'] = $_POST['_AMOUNT'];
				$vData['payment_type'] = $vPaymentType;
				$vData['client_id'] = $_POST['VARIABLE2'];
				$vData['temp_salt'] = $_POST['VARIABLE1'];
				$vData['lang'] = $vRequest->getParameter('lang');
				$vOrderErrorPage = $vPages->returnOrderError($conn, $vPaymentType, $vPaymentResult, $vData);
				echo $vOrderErrorPage;
				//$vId = $vRequest->getParameter('id');
				//include_once 'include/OrderQueries.php';
			}
			else if($vPage == "Soek" || $vPage == "Search"){
				$vSearchType = $vRequest->getParameter('id');////k = Keyword | m = Menu | a = Advanced
				$vSort = $vRequest->getParameter('sort');
				(empty($vSort) ? $vSearchData['sort'] = "date_publish DESC" : $vSearchData['sort'] = $vSort);
				if($vSearchType == "k" || $vSearchType == "a" || $vSearchType == "ks"){//keyword | author | keyword with sort
					$vSearchData['page'] = $vRequest->getParameter('page');
					$vSearchData['lang'] = $vRequest->getParameter('lang');
					$vSearchData['type'] = $vSearchType;
					$vSearchData['cat'] = str_replace("~", ".", $vRequest->getParameter('cat'));
					$vSearchData['autocomplete'] = $vRequest->getParameter('autocomplete');
					$vMorePages = $vPages->returnResultPages($conn, $vSearchData);
					echo $vMorePages;
				}
				else if ($vSearchType == "m"){//menu
					$vSearchData['page'] = $vRequest->getParameter('page');
					$vSearchData['lang'] = $vRequest->getParameter('lang');
					$vSearchData['type'] = $vSearchType;
					$vSearchData['subcat_id'] = $vRequest->getParameter('c_id');
					$vSearchData['cat'] = $vRequest->getParameter('cat');
					$vSearchData['subcat'] = $vRequest->getParameter('subcat');
					$vMorePages = $vPages->returnResultPages($conn, $vSearchData);
					echo $vMorePages;
				}
				else if ($vSearchType == "c"){//category
					$vSearchData['page'] = $vRequest->getParameter('page');
					$vSearchData['lang'] = $vRequest->getParameter('lang');
					$vSearchData['type'] = $vSearchType;
					$vSearchData['cat_id'] = $vRequest->getParameter('c_id');
					$vSearchData['cat'] = $vRequest->getParameter('cat');
					$vMorePages = $vPages->returnResultPages($conn, $vSearchData);
					echo $vMorePages;
				}
			}
			else if($vPage == "Moleskine" ){
				$vSort = $vRequest->getParameter('sort');
				(empty($vSort) ? $vSearchData['sort'] = "date_publish DESC" : $vSearchData['sort'] = $vSort);
				$vSearchData['page'] = $vRequest->getParameter('page');
				$vSearchData['lang'] = $vRequest->getParameter('lang');
				$vSearchData['type'] = "Moleskine";
				$vSearchData['subcat_id'] =26;
				$vSearchData['cat_id'] = 3;
				$vMorePages = $vPages->returnResultPages($conn, $vSearchData);
				echo $vMorePages;
			}
			else if($vPage == "Info"){
				$vType = $vRequest->getParameter('temp');
				$vId = $vRequest->getParameter('id');
				if($vId == 30){//T&C
					echo "<Script>window.open('".$_SESSION['SessionGrafFullServerUrl']."documents/".$_SESSION['SessionGrafLanguage']."TC2018.pdf', '_blank');</Script>";
					$vGeneral->echoRedirect($_SESSION['SessionGrafLanguage']."/".MysqlQuery::getText($conn, 1)/*Tuisblad*/, "");
				}
				else {
						$vContactString = $vPages->returnInfo($conn, $vType, $vId);
						echo $vContactString;
					}
			}
			else if($vPage == "BookLaunches" || $vPage == "Boekbekendstellings"){
				$vTemp = $vRequest->getParameter('temp');
				$vEventsString = $vPages->returnEvents($conn, $vTemp);//1 = Book launches
				echo $vEventsString;
			}
			else if($vPage == "Nuusbriewe" || $vPage == "Newsletters"){
				$vData['dir'] = "documents/newsletters";
				$vNewsletterString = $vPages->returnNewsletters($conn, $vData);
				echo $vNewsletterString;
			}
			else if($vPage == "Grootontbyt"){
				$vSearchData['type'] = "tv";
				$vTvString = $vPages->returnTv($conn, $vPage, $vSearchData);
				echo $vTvString;
			}
			else if($vPage == "rooirose"){
				$vSearchData['type'] = "rr";
				$vRrString = $vPages->returnRr($conn, $vPage, $vSearchData);
				echo $vRrString;
			}
			else if($vPage == "sp"){//special pages
				$vSearchData['type'] = "rr";
				$vRrString = $vPages->returnRr($conn, $vPage, $vSearchData);
				echo $vRrString;
			}
            else if($vPage == "Kompetisies" || $vPage == "Competitions"){
				$vCompetitionString = $vPages->returnCompetitions($conn);//1 = Book launches
				echo $vCompetitionString;
			}
			$vPagesPageBottom = $vParts->getPagesPageBottom();
			echo $vPagesPageBottom;
		}

	$vFooter = $vParts->getFooter($conn, $vPage);
	echo $vFooter;

	$vPageBottom = $vParts->getPageBottom($conn);
	echo $vPageBottom;

	$vModals = $vModal->loadModals($conn);
	echo $vModals;
}

include "include/connect/CloseConnect.php";

$vHtmlEnd = $vParts->getHtmlEnd();
echo $vHtmlEnd;