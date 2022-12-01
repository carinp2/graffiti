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
require_once ("application/classes/CmsModal.class.php");
$vCmsModal= new CmsModal();

include "../application/config/session_config.php";
include "../include/connect/Connect.php";
include "application/config/session_cms_config.php";

($vRequest->getParameter('type') ? $vType = $vRequest->getParameter('type') : $vType = "");
($vRequest->getParameter('page') ? $vPage = $vRequest->getParameter('page') : $vPage = "");

$vBegin = $vCmsParts->returnBeginHtml();
echo $vBegin;

if(isset($_SESSION['SessionGrafCmsUserId'])){
	$vMenu = $vCmsParts->returnTopMenu($conn, $vPage);
	echo $vMenu;
}

$vContent = $vCmsParts->returnContentStart();
echo $vContent;

$vSubMenu = $vCmsParts->returnSubMenu($conn, $vPage, $vType);
echo $vSubMenu;

$vStringA = "";

	//############################################################################################  Stock update
	if($vType == "stock_update"){
			$vStringA .= "<h1>Laai voorraadlys op</h1>";
			$vStringA .= "<h2>Voorraadlys opgelaai - Resultate:</h2>";

			$vStringA .= "<table id=\"stockTable\" class=\"cell-border dataTable hover\" cellspacing=\"0\">";
				$vStringA .= "<thead>";
					$vStringA .= "<tr class=\"red\">";
						$vStringA .= "<th class=\"dt-head-center\">Ry no</th>";
						$vStringA .= "<th class=\"dt-head-center\">ISBN</th>";
						$vStringA .= "<th class=\"dt-head-center\">Publikasie datum</th>";
						$vStringA .= "<th class=\"dt-head-center\">Voorraad</th>";
						$vStringA .= "<th class=\"dt-head-center\">Uitdruk</th>";
					$vStringA .= "</tr>";
			$vStringA .= "</thead>";
				$vStringA .= "<tfoot>";
					$vStringA .= "<tr class=\"red\">";
						$vStringA .= "<th class=\"dt-head-center\">Ry no</th>";
						$vStringA .= "<th class=\"dt-head-center\">ISBN</th>";
						$vStringA .= "<th class=\"dt-head-center\">Publikasie datum</th>";
						$vStringA .= "<th class=\"dt-head-center\">Voorraad</th>";
						$vStringA .= "<th class=\"dt-head-center\">Uitdruk</th>";
					$vStringA .= "</tr>";
			$vStringA .= "</tfoot>";
			$vStringA .= "<tbody>";
			$vFileType = substr($_FILES['stock_file']['name'], strpos($_FILES['stock_file']['name'], "."));
		    if($vFileType == ".xlsx"){
		    	include "application/classes/simplexlsx.class.php";
				$xlsx = new SimpleXLSX( $_FILES['stock_file']['tmp_name'] );
				$rowNo = 2;

				//Set all stock = 0
				$vDataZ['in_stock'] = 0;
				$vQueryResultZ = $vQuery->doUpdate($conn, "books", $vDataZ, "id > 0 AND publisher <> 3");

				foreach( $xlsx->rows() as $k => $r) {
					if ($k == 0) continue; // skip first row
					$vIsbnExists = $vQuery->checkExists($conn, "books", "id", "isbn = '".trim($r[0])."'");
					if($vIsbnExists >= 1){
						$vPubDate = $vQuery->checkPublicationDate($conn, $r[0]);
						($r[3] == -1 ? $vData["in_stock"] = 0 : $vData["in_stock"] = $r[3]);
						($vPubDate > date("Y-m-d") ? $vData["date_publish"] = date("Y-m-d") : $vData["date_publish"] = $vPubDate);
						$vData["out_of_print"] = 0;
						//$vData['edit_by'] = $_SESSION['SessionGrafCmsUserId'];
						$vQueryResult = $vQuery->doUpdate($conn, "books", $vData, "isbn = '".trim($r[0])."'");
							$vStringA .="<tr>";
								$vStringA .= "<td class=\"dt-body-center bg-success\">".$rowNo."</td>";
								$vStringA .= "<td class=\"dt-body-center bg-success\">".trim($r[0])."</td>";
								$vStringA .= "<td class=\"dt-body-center bg-success\">".$vData["date_publish"]."</td>";
								$vStringA .= "<td class=\"dt-body-center bg-success\">".$vData["in_stock"]."</td>";
								$vStringA .= "<td class=\"dt-body-center bg-success\">Nee</td>";
							$vStringA .="</tr>";
					}
					else if($vIsbnExists == 0){
							$vStringA .="<tr>";
								$vStringA .= "<td class=\"bg-error dt-body-center\">".$rowNo."</td>";
								$vStringA .= "<td class=\"bg-error dt-body-center\">".trim($r[0])."</td>";
								$vStringA .= "<td class=\"bg-error dt-body-center\">ISBN nie gevind nie</td>";
								$vStringA .= "<td class=\"bg-error dt-body-center\"></td>";
								$vStringA .= "<td class=\"bg-error dt-body-center\"></td>";
							$vStringA .="</tr>";
					}
					$rowNo++;
				}
		    }
		    else if($vFileType == ".xls"){
				include "include/reader.php";
				$excel = new Spreadsheet_Excel_Reader();
				$excel->read($_FILES['stock_file']["tmp_name"]);
				$x=2;

				//Set all stock = 0
				$vDataZ['in_stock'] = 0;
				$vQueryResultZ = $vQuery->doUpdate($conn, "books", $vDataZ, "id > 0 AND publisher <> 3");

				while($x <= $excel->sheets[0]['numRows']) {
					$vIsbn = isset($excel->sheets[0]['cells'][$x][1]) ? $excel->sheets[0]['cells'][$x][1] : '';
					$vIsbnExists = $vQuery->checkExists($conn, "books", "id", "isbn = '".trim($vIsbn)."'");
					if($vIsbnExists >= 1){
						$vPubDate = $vQuery->checkPublicationDate($conn, trim($vIsbn));
						($excel->sheets[0]['cells'][$x][4] == -1 ? $vData["in_stock"] = 0 : $vData["in_stock"] = $excel->sheets[0]['cells'][$x][4]);
						($vPubDate > date("Y-m-d") ? $vData["date_publish"] = date("Y-m-d") : $vData["date_publish"] = $vPubDate);
						//$vData["in_stock"] = $excel->sheets[0]['cells'][$x][4];
						$vData["out_of_print"] = 0;
						//$vData['edit_by'] = $_SESSION['SessionGrafCmsUserId'];
						$vQueryResult = $vQuery->doUpdate($conn, "books", $vData, "isbn = '".trim($vIsbn)."'");
								$vStringA .="<tr>";
									$vStringA .= "<td class=\"dt-body-center bg-success\">".$x."</td>";
									$vStringA .= "<td class=\"dt-body-center bg-success\">".trim($vIsbn)."</td>";
									$vStringA .= "<td class=\"dt-body-center bg-success\">".$vData["date_publish"]."</td>";
									$vStringA .= "<td class=\"dt-body-center bg-success\">".$vData["in_stock"]."</td>";
									$vStringA .= "<td class=\"dt-body-center bg-success\">Nee</td>";
								$vStringA .="</tr>";
					}
					else if($vIsbnExists == 0){
							$vStringA .="<tr>";
								$vStringA .= "<td class=\"bg-error dt-body-center\">".$x."</td>";
								$vStringA .= "<td class=\"bg-error dt-body-center\">".trim($vIsbn)."</td>";
								$vStringA .= "<td class=\"bg-error dt-body-center\">ISBN nie gevind nie</td>";
								$vStringA .= "<td class=\"bg-error dt-body-center\"></td>";
								$vStringA .= "<td class=\"bg-error dt-body-center\"></td>";
							$vStringA .="</tr>";
					}
					$x++;
				}
		    }
			$vStringA .= "</tbody>";
		}
		//############################################################################################ Out of print
		else if($vType == "out_of_print"){
			$vStringA .= "<h1>Laai 'UIT DRUK' lys op</h1>";
			$vStringA .= "<h2>'Uit druk uit' opgelaai - Resultate:</h2>";

			$vStringA .= "<table id=\"outOfPrintTable\" class=\"cell-border dataTable hover\" cellspacing=\"0\">";
				$vStringA .= "<thead>";
					$vStringA .= "<tr class=\"red\">";
						$vStringA .= "<th class=\"dt-head-center\">Ry no</th>";
						$vStringA .= "<th class=\"dt-head-center\">ISBN</th>";
						$vStringA .= "<th class=\"dt-head-center\">Uitdruk</th>";
					$vStringA .= "</tr>";
			$vStringA .= "</thead>";
				$vStringA .= "<tfoot>";
					$vStringA .= "<tr class=\"red\">";
						$vStringA .= "<th class=\"dt-head-center\">Ry no</th>";
						$vStringA .= "<th class=\"dt-head-center\">ISBN</th>";
						$vStringA .= "<th class=\"dt-head-center\">Uitdruk</th>";
					$vStringA .= "</tr>";
			$vStringA .= "</tfoot>";
			$vStringA .= "<tbody>";
			$vFileType = substr($_FILES['out_of_print_file']['name'], strpos($_FILES['out_of_print_file']['name'], "."));
		    if($vFileType == ".xlsx"){
		    	include "application/classes/simplexlsx.class.php";
				$xlsx = new SimpleXLSX( $_FILES['out_of_print_file']['tmp_name'] );
				$rowNo = 2;
				foreach( $xlsx->rows() as $k => $r) {
					if ($k == 0) continue; // skip first row
					$vIsbnExists = $vQuery->checkExists($conn, "books", "id", "isbn = '".trim($r[0])."'");
					if($vIsbnExists >= 1){
						$vData["out_of_print"] =1;
						//$vData['edit_by'] = $_SESSION['SessionGrafCmsUserId'];
						$vQueryResult = $vQuery->doUpdate($conn, "books", $vData, "isbn = '".trim($r[0])."'");
							$vStringA .="<tr>";
								$vStringA .= "<td class=\"dt-body-center bg-success\">".$rowNo."</td>";
								$vStringA .= "<td class=\"dt-body-center bg-success\">".trim($r[0])."</td>";
								$vStringA .= "<td class=\"dt-body-center bg-success\">Ja</td>";
							$vStringA .="</tr>";
					}
					else if($vIsbnExists == 0){
							$vStringA .="<tr>";
								$vStringA .= "<td class=\"bg-error dt-body-center\">".$rowNo."</td>";
								$vStringA .= "<td class=\"bg-error dt-body-center\">".$r[0]."</td>";
								$vStringA .= "<td class=\"bg-error dt-body-center\">ISBN nie gevind</td>";
							$vStringA .="</tr>";
					}
					$rowNo++;
				}
		    }
		    else if($vFileType == ".xls"){
				include "include/reader.php";
				$excel = new Spreadsheet_Excel_Reader();
				$excel->read($_FILES['out_of_print_file']["tmp_name"]);
				$x=2;
				while($x <= $excel->sheets[0]['numRows']) {
					$vIsbn = isset($excel->sheets[0]['cells'][$x][1]) ? $excel->sheets[0]['cells'][$x][1] : '';
					$vIsbnExists = $vQuery->checkExists($conn, "books", "id", "isbn = '".trim($vIsbn)."'");
					if($vIsbnExists >= 1){
						$vData["out_of_print"] = 1;
						//$vData['edit_by'] = $_SESSION['SessionGrafCmsUserId'];
						$vQueryResult = $vQuery->doUpdate($conn, "books", $vData, "isbn = '".trim($vIsbn)."'");
								$vStringA .="<tr>";
									$vStringA .= "<td class=\"dt-body-center bg-success\">".$x."</td>";
									$vStringA .= "<td class=\"dt-body-center bg-success\">".trim($vIsbn)."</td>";
									$vStringA .= "<td class=\"dt-body-center bg-success\">Ja</td>";
								$vStringA .="</tr>";
					}
					else if($vIsbnExists == 0){
							$vStringA .="<tr>";
								$vStringA .= "<td class=\"bg-error dt-body-center\">".$x."</td>";
								$vStringA .= "<td class=\"bg-error dt-body-center\">".trim($vIsbn)."</td>";
								$vStringA .= "<td class=\"bg-error dt-body-center\">ISBN nie gevind nie</td>";
							$vStringA .="</tr>";
					}
					$x++;
				}
		    }
			$vStringA .= "</tbody>";
		}
		//############################################################################################ Book list upload
		else if($vType == "load_book_list"){
			$vStringA .= "<h1>Laai boekelys</h1>";
			$vStringA .= "<h2>Boekelys opgelaai - Resultate:</h2>";

			$vStringA .= "<table id=\"loadBookListTable\" class=\"cell-border dataTable hover\" cellspacing=\"0\">";
				$vStringA .= "<thead>";
					$vStringA .= "<tr class=\"red\">";
						$vStringA .= "<th class=\"dt-head-center\">Ry no</th>";
						$vStringA .= "<th class=\"dt-head-center\">ISBN</th>";
						$vStringA .= "<th class=\"dt-head-center\">Aksie geneem</th>";
						$vStringA .= "<th class=\"dt-head-center\">Voorraad</th>";
					$vStringA .= "</tr>";
			$vStringA .= "</thead>";
				$vStringA .= "<tfoot>";
					$vStringA .= "<tr class=\"red\">";
						$vStringA .= "<th class=\"dt-head-center\">Ry no</th>";
						$vStringA .= "<th class=\"dt-head-center\">ISBN</th>";
						$vStringA .= "<th class=\"dt-head-center\">Aksie geneem</th>";
						$vStringA .= "<th class=\"dt-head-center\">Voorraad</th>";
					$vStringA .= "</tr>";
			$vStringA .= "</tfoot>";
			$vStringA .= "<tbody>";
			$vFileType = substr($_FILES['load_book_list_file']['name'], strpos($_FILES['load_book_list_file']['name'], "."));
		    if($vFileType == ".xlsx"){
		    	include "application/classes/simplexlsx.class.php";
				$xlsx = new SimpleXLSX( $_FILES['load_book_list_file']['tmp_name'] );
				$rowNo = 2;
				foreach( $xlsx->rows() as $k => $r) {
					if ($k == 0) continue; // skip first row
					$vIsbnExists = $vQuery->checkExists($conn, "books", "id", "isbn = '".trim($r[0])."'");
					if($vIsbnExists >= 1){
							$vStringA .="<tr>";
								$vStringA .= "<td class=\"dt-body-center bg-error\">".$rowNo."</td>";
								$vStringA .= "<td class=\"dt-body-center bg-error\">".trim($r[0])."</td>";
								$vStringA .= "<td class=\"bg-error\">Boek reeds in databasis</td>";
								$vStringA .= "<td class=\"dt-body-center bg-error\">0</td>";
							$vStringA .="</tr>";
					}
					else if($vIsbnExists == 0){
						$vData['isbn'] = trim($r[0]);
						$vData['category'] = $r[1];
						$vData['sub_category'] =$r[2];
						$vData['title'] = General::prepareStringForQuery($r[3]);
						$vData['summary'] = General::prepareStringForQuery($r[4]);
						$vData['author'] = General::prepareStringForQuery($r[5]);
						$vData['illustrator'] = General::prepareStringForQuery($r[6]);
						$vData['translator'] = General::prepareStringForQuery($r[7]);
						$vData['price'] = round(General::prepareStringForQuery($r[8]),0, PHP_ROUND_HALF_EVEN);
						$vData['date_publish'] = General::prepareStringForQuery($r[9]);
						($r[10] == "" ? $vData['dimensions'] = 0 : $vData['dimensions'] = General::prepareStringForQuery(trim($r[10])));
						($r[11] == "" ? $vData['weight'] = 0 : $vData['weight'] = General::prepareStringForQuery(trim($r[11])));
						($r[12] == "" ? $vData['format'] = 0 : $vData['format'] = General::prepareStringForQuery(trim($r[12])));
						($r[13] == "" ? $vData['pages'] = 0 : $vData['pages'] = General::prepareStringForQuery(trim((int)$r[13])));
						($r[14] == "" ? $vData['publisher'] = 0 : $vData['publisher'] = General::prepareStringForQuery($r[14]));
						$vData['language'] = $r[15];
						$vData['date_loaded'] = $_SESSION['now_date'];
						$vData['default_discount'] = 0;
						$vData['in_stock'] = 0;
//						$vData['edit_by'] = $_SESSION['SessionGrafCmsUserId'];

						$vQueryResult = $vQuery->doInsert($conn, "books", $vData);

						if($vQueryResult > 0){
							$vDataS['id'] = $vQueryResult;
							$vDataS['title'] = General::prepareBooksSearchStringData($r[3]);
							$vDataS['summary'] = General::prepareBooksSearchStringData($r[4]);
							$vDataS['author'] = General::prepareBooksSearchStringData($r[5]);
							$vDataS['illustrator'] = General::prepareBooksSearchStringData($r[6]);
							$vDataS['translator'] = General::prepareBooksSearchStringData($r[7]);
							$vDataS['language'] = $r[15];
							$vDataS['isbn'] = trim($r[0]);
							$vQuery::doInsert($conn, "books_search", $vDataS);

							$vBookData['search_idx'] = 1;
							$vQuery->doUpdate($conn, 'books', $vBookData, 'id = '.$vQueryResult);
						}

						$vStringA .="<tr>";
							$vStringA .= "<td class=\"bg-success dt-body-center\">".$rowNo."</td>";
							$vStringA .= "<td class=\"bg-success dt-body-center\">".trim($r[0])."</td>";
							$vStringA .= "<td class=\"bg-success\">Sukses! Boek opgelaai</td>";
							$vStringA .= "<td class=\"dt-body-center bg-success\">0</td>";
						$vStringA .="</tr>";
					}
					$rowNo++;
				}
		    }
		    else if($vFileType == ".xls"){
				include "include/reader.php";
				$excel = new Spreadsheet_Excel_Reader();
				$excel->read($_FILES['load_book_list_file']["tmp_name"]);
				$x=2;
				while($x <= $excel->sheets[0]['numRows']) {
					$vIsbn = isset($excel->sheets[0]['cells'][$x][1]) ? $excel->sheets[0]['cells'][$x][1] : '';
					$vIsbnExists = $vQuery->checkExists($conn, "books", "id", "isbn = '".trim($vIsbn)."'");
					if($vIsbnExists >= 1){
								$vStringA .="<tr>";
									$vStringA .= "<td class=\"dt-body-center bg-error\">".$x."</td>";
									$vStringA .= "<td class=\"dt-body-center bg-error\">".trim($vIsbn)."</td>";
									$vStringA .= "<td class=\"bg-error\">Boek reeds in databasis</td>";
									$vStringA .= "<td class=\"dt-body-center bg-error\">0</td>";
								$vStringA .="</tr>";
					}
					else if($vIsbnExists == 0){
						$vData['isbn'] = isset($excel->sheets[0]['cells'][$x][1]) ? trim($excel->sheets[0]['cells'][$x][1]) : '';
						$vData['category'] = isset($excel->sheets[0]['cells'][$x][2]) ? $excel->sheets[0]['cells'][$x][2] : '';
						$vData['sub_category'] = isset($excel->sheets[0]['cells'][$x][3]) ? $excel->sheets[0]['cells'][$x][3] : '';
						$vData['title'] = General::prepareStringForQuery(isset($excel->sheets[0]['cells'][$x][4]) ? $excel->sheets[0]['cells'][$x][4] : '');
						$vData['summary'] = General::prepareStringForQuery(isset($excel->sheets[0]['cells'][$x][5]) ? $excel->sheets[0]['cells'][$x][5] : '');
						$vData['author'] = General::prepareStringForQuery(isset($excel->sheets[0]['cells'][$x][6]) ? $excel->sheets[0]['cells'][$x][6] : '');
						$vData['illustrator'] = General::prepareStringForQuery(isset($excel->sheets[0]['cells'][$x][7]) ? $excel->sheets[0]['cells'][$x][7] : '');
						$vData['translator'] = General::prepareStringForQuery(isset($excel->sheets[0]['cells'][$x][8]) ? $excel->sheets[0]['cells'][$x][8] : '');
						$vData['price'] = General::prepareStringForQuery(isset($excel->sheets[0]['cells'][$x][9]) ? round($excel->sheets[0]['cells'][$x][9],0, PHP_ROUND_HALF_EVEN) : '');
						$vData['date_publish'] = General::prepareStringForQuery(isset($excel->sheets[0]['cells'][$x][10]) ? $excel->sheets[0]['cells'][$x][10] : '');
						$vData['dimensions'] = General::prepareStringForQuery(isset($excel->sheets[0]['cells'][$x][11]) ? $excel->sheets[0]['cells'][$x][11] : 0);
						$vData['weight'] = General::prepareStringForQuery(isset($excel->sheets[0]['cells'][$x][12]) ? $excel->sheets[0]['cells'][$x][12] : 0);
						$vData['format'] = General::prepareStringForQuery(isset($excel->sheets[0]['cells'][$x][13]) ? $excel->sheets[0]['cells'][$x][13] : 0);
						$vData['pages'] = General::prepareStringForQuery(isset($excel->sheets[0]['cells'][$x][14]) ? (int)$excel->sheets[0]['cells'][$x][14] : 0);
						$vData['publisher'] = General::prepareStringForQuery(isset($excel->sheets[0]['cells'][$x][15]) ? $excel->sheets[0]['cells'][$x][15] : 0);
						$vData['language'] = General::prepareStringForQuery(isset($excel->sheets[0]['cells'][$x][16]) ? $excel->sheets[0]['cells'][$x][16] : '');
						$vData['date_loaded'] = $_SESSION['now_date'];
						$vData['default_discount'] = 0;
						$vData['in_stock'] = 0;
//						$vData['edit_by'] = $_SESSION['SessionGrafCmsUserId'];

						$vQueryResult = $vQuery->doInsert($conn, "books", $vData);

						if($vQueryResult > 0){
							$vDataS['id'] = $vQueryResult;
							$vDataS['title'] = General::prepareBooksSearchStringData($excel->sheets[0]['cells'][$x][4]);
							$vDataS['summary'] = General::prepareBooksSearchStringData($excel->sheets[0]['cells'][$x][5]);
							$vDataS['author'] = General::prepareBooksSearchStringData($excel->sheets[0]['cells'][$x][6]);
							$vDataS['illustrator'] = General::prepareBooksSearchStringData($excel->sheets[0]['cells'][$x][7]);
							$vDataS['translator'] = General::prepareBooksSearchStringData($excel->sheets[0]['cells'][$x][8]);
							$vDataS['language'] = $excel->sheets[0]['cells'][$x][16];
							$vDataS['isbn'] = trim($excel->sheets[0]['cells'][$x][1]);
							$vQuery::doInsert($conn, "books_search", $vDataS);

							$vBookData['search_idx'] = 1;
							$vQuery->doUpdate($conn, 'books', $vBookData, 'id = '.$vQueryResult);
						}

						$vStringA .="<tr>";
							$vStringA .= "<td class=\"bg-success dt-body-center\">".$x."</td>";
							$vStringA .= "<td class=\"bg-success dt-body-center\">".trim($vIsbn)."</td>";
							$vStringA .= "<td class=\"bg-success\">Sukses! Boek opgelaai</td>";
							$vStringA .= "<td class=\"dt-body-center bg-success\">0</td>";
						$vStringA .="</tr>";
					}
					$x++;
				}
		    }
			$vStringA .= "</tbody>";
		}
	//############################################################################################  In print per Publisher start
	else if($vType == "in_print_publisher"){
			$GLOBALS['date_min_one_month'] = date("Y-m-d", strtotime('-1 month'));
			$vStringA .= "<h1>Laai 'In Druk' per Uitgewer</h1>";
			$vStringA .= "<h2>'In Druk' lys opgelaai - Resultate:</h2>";

			$vStringA .= "<table id=\"stockTable\" class=\"cell-border dataTable hover\" cellspacing=\"0\">";
				$vStringA .= "<thead>";
					$vStringA .= "<tr class=\"red\">";
						$vStringA .= "<th class=\"dt-head-center\">Ry No</th>";
						$vStringA .= "<th class=\"dt-head-center\">ISBN</th>";
						$vStringA .= "<th class=\"dt-head-center\">Uitdruk</th>";
					$vStringA .= "</tr>";
			$vStringA .= "</thead>";
				$vStringA .= "<tfoot>";
					$vStringA .= "<tr class=\"red\">";
						$vStringA .= "<th class=\"dt-head-center\">Ry no</th>";
						$vStringA .= "<th class=\"dt-head-center\">ISBN</th>";
						$vStringA .= "<th class=\"dt-head-center\">Uitdruk</th>";
					$vStringA .= "</tr>";
			$vStringA .= "</tfoot>";
			$vStringA .= "<tbody>";
			$vPublisherId = RequestUtils::getParameter('publisher-id');
			$vFileType = substr($_FILES['in_print_file']['name'], strpos($_FILES['in_print_file']['name'], "."));

		    //Set all from publisher to out_of_print = 1;
    		$vData1["out_of_print"] = 1;
    		//$vData1['edit_by'] = $_SESSION['SessionGrafCmsUserId'];
    		if($vPublisherId == 5001){
    			$vQueryResult = $vQuery->doUpdate($conn, "books", $vData1, "publisher in (8000,3500,1100,1006,1023,2693,2305,7982) AND in_stock = 0 and date_publish <= '".$GLOBALS['date_min_one_month']."'");
    		}
    		else if($vPublisherId == 7500){
    			$vQueryResult = $vQuery->doUpdate($conn, "books", $vData1, "publisher in (2498,2574,1858,2490,1920,2453,1234) AND in_stock = 0 and date_publish <= '".$GLOBALS['date_min_one_month']."'");
    		}
    		else {
    			$vQueryResult = $vQuery->doUpdate($conn, "books", $vData1, "publisher = ".$vPublisherId." AND in_stock = 0 and date_publish <= '".$GLOBALS['date_min_one_month']."'");
    		}

			if($vFileType == ".xlsx"){
		    	include "application/classes/simplexlsx.class.php";
				$xlsx = new SimpleXLSX( $_FILES['in_print_file']['tmp_name'] );
				$rowNo = 2;

				foreach( $xlsx->rows() as $k => $r) {
					if ($k == 0) continue; // skip first row
					$vIsbnExists = $vQuery->checkExists($conn, "books", "id", "isbn = '".trim($r[0])."'");
					if($vIsbnExists >= 1){
						$vDataIP["out_of_print"] = 0;
						//$vDataIP['edit_by'] = $_SESSION['SessionGrafCmsUserId'];
						if($vPublisherId == 5001){
							$vQueryResult = $vQuery->doUpdate($conn, "books", $vDataIP, "isbn = '".trim($r[0])."' and publisher in (8000,3500,1100,1006,1023,2693,2305,7982)");
						}
						else if($vPublisherId == 7500){
							$vQueryResult = $vQuery->doUpdate($conn, "books", $vDataIP, "isbn = '".trim($r[0])."' and publisher in (2498,2574,1858,2490,1920,2453,1234)");
						}
						else {
							$vQueryResult = $vQuery->doUpdate($conn, "books", $vDataIP, "isbn = '".trim($r[0])."' and publisher = ".$vPublisherId);
						}
							$vStringA .="<tr>";
								$vStringA .= "<td class=\"dt-body-center bg-success\">".$rowNo."</td>";
								$vStringA .= "<td class=\"dt-body-center bg-success\">".trim($r[0])."</td>";
								$vStringA .= "<td class=\"dt-body-center bg-success\">Nee</td>";
							$vStringA .="</tr>";
					}
					else if($vIsbnExists == 0){
							$vStringA .="<tr>";
								$vStringA .= "<td class=\"bg-error dt-body-center\">".$rowNo."</td>";
								$vStringA .= "<td class=\"bg-error dt-body-center\">".trim($r[0])."</td>";
								$vStringA .= "<td class=\"bg-error dt-body-center\">ISBN nie gevind nie</td>";
							$vStringA .="</tr>";
					}
					$rowNo++;
				}
		    }
		    else if($vFileType == ".xls"){
				include "include/reader.php";
				$excel = new Spreadsheet_Excel_Reader();
				$excel->read($_FILES['in_print_file']["tmp_name"]);
				$x=2;
				while($x <= $excel->sheets[0]['numRows']) {
					$vIsbn = isset($excel->sheets[0]['cells'][$x][1]) ? trim($excel->sheets[0]['cells'][$x][1]) : '';
					$vIsbnExists = $vQuery->checkExists($conn, "books", "id", "isbn = '".trim($vIsbn)."'");
					if($vIsbnExists >= 1){
						//$vData["in_stock"] = $excel->sheets[0]['cells'][$x][4];
						$vDataIP["out_of_print"] = 0;
						//$vDataIP['edit_by'] = $_SESSION['SessionGrafCmsUserId'];
						if($vPublisherId == 5001){
							$vQueryResult = $vQuery->doUpdate($conn, "books", $vDataIP, "isbn = '".trim($r[0])."' and publisher in (8000,3500,1100,1006,1023,2693,2305,7982)");
						}
						else if($vPublisherId == 7500){
							$vQueryResult = $vQuery->doUpdate($conn, "books", $vDataIP, "isbn = '".trim($r[0])."' and publisher in (2498,2574,1858,2490,1920,2453,1234)");
						}
						else {
							$vQueryResult = $vQuery->doUpdate($conn, "books", $vDataIP, "isbn = '".trim($vIsbn)."' and publisher = ".$vPublisherId);
						}
								$vStringA .="<tr>";
									$vStringA .= "<td class=\"dt-body-center bg-success\">".$x."</td>";
									$vStringA .= "<td class=\"dt-body-center bg-success\">".trim($vIsbn)."</td>";
									$vStringA .= "<td class=\"dt-body-center bg-success\">Nee</td>";
								$vStringA .="</tr>";
					}
					else if($vIsbnExists == 0){
							$vStringA .="<tr>";
								$vStringA .= "<td class=\"bg-error dt-body-center\">".$x."</td>";
								$vStringA .= "<td class=\"bg-error dt-body-center\">".trim($vIsbn)."</td>";
								$vStringA .= "<td class=\"bg-error dt-body-center\">ISBN nie gevind nie</td>";
							$vStringA .="</tr>";
					}
					$x++;
				}
		    }
			$vStringA .= "</tbody>";
		}
	//############################################################################################  In print per Publisher start
	else if($vType == "load_price_list"){
			$vStringA .= "<h1>Laai Pryslys</h1>";
			$vStringA .= "<h2>Pryslys - Resultate:</h2>";

			$vStringA .= "<table id=\"stockTable\" class=\"cell-border dataTable hover\" cellspacing=\"0\">";
				$vStringA .= "<thead>";
					$vStringA .= "<tr class=\"red\">";
						$vStringA .= "<th class=\"dt-head-center\">Ry No</th>";
						$vStringA .= "<th class=\"dt-head-center\">ISBN</th>";
						$vStringA .= "<th class=\"dt-head-center\">Ou prys</th>";
						$vStringA .= "<th class=\"dt-head-center\">Nuwe prys</th>";
					$vStringA .= "</tr>";
			$vStringA .= "</thead>";
				$vStringA .= "<tfoot>";
					$vStringA .= "<tr class=\"red\">";
						$vStringA .= "<th class=\"dt-head-center\">Ry no</th>";
						$vStringA .= "<th class=\"dt-head-center\">ISBN</th>";
						$vStringA .= "<th class=\"dt-head-center\">Ou prys</th>";
						$vStringA .= "<th class=\"dt-head-center\">Nuwe prys</th>";
					$vStringA .= "</tr>";
			$vStringA .= "</tfoot>";
			$vStringA .= "<tbody>";
			$vFileType = substr($_FILES['load_price_list_file']['name'], strpos($_FILES['load_price_list_file']['name'], "."));

		    if($vFileType == ".xlsx"){
		    	include "application/classes/simplexlsx.class.php";
				$xlsx = new SimpleXLSX( $_FILES['load_price_list_file']['tmp_name'] );
				$rowNo = 2;
				foreach( $xlsx->rows() as $k => $r) {
					if ($k == 0) continue; // skip first row
					$vIsbnExists = $vQuery->checkExists($conn, "books", "id", "isbn = '".trim($r[0])."'");
					if($vIsbnExists >= 1){
						unset($vData["special_price"]);
						unset($vData["price"]);
//						$vIsSpecial = $vQuery->checkSpecial($conn, "isbn = '".$r[0]."'");
// 						if($vIsSpecial == 1){
// 							$vData["special_price"] = $r[1];
// 							$vText = "Winskopie prys";
// 						}
// 						else if($vIsSpecial == 0){
							$vData["price"] = $r[1];
							$vText = "Prys";
							$vOldPrice = $vQuery->getBookPrice($conn, $r[0]);
							($r[1] != $vOldPrice ? $vShowStyleStart = "<b><u>" : $vShowStyleStart = "");
							($r[1] != $vOldPrice ? $vShowStyleEnd = "</b></u>" : $vShowStyleEnd = "");
//						}
						//$vData['edit_by'] = $_SESSION['SessionGrafCmsUserId'];
						$vQueryResult = $vQuery->doUpdate($conn, "books", $vData, "isbn = '".trim($r[0])."'");
							$vStringA .="<tr>";
								$vStringA .= "<td class=\"dt-body-center bg-success\">".$rowNo."</td>";
								$vStringA .= "<td class=\"dt-body-center bg-success\">".trim($r[0])."</td>";
								$vStringA .= "<td class=\"dt-body-center bg-success\">".$vShowStyleStart.$vOldPrice.$vShowStyleEnd."</td>";
								$vStringA .= "<td class=\"dt-body-center bg-success\">".$vShowStyleStart.$r[1].$vShowStyleEnd."</td>";
							$vStringA .="</tr>";
					}
					else if($vIsbnExists == 0){
							$vStringA .="<tr>";
								$vStringA .= "<td class=\"bg-error dt-body-center\">".$rowNo."</td>";
								$vStringA .= "<td class=\"bg-error dt-body-center\">".trim($r[0])."</td>";
								$vStringA .= "<td class=\"bg-error dt-body-center\" colspan=\"2\">ISBN nie gevind</td>";
							$vStringA .="</tr>";
					}
					$rowNo++;
				}
		    }
		    else if($vFileType == ".xls"){
				include "include/reader.php";
				$excel = new Spreadsheet_Excel_Reader();
				$excel->read($_FILES['load_price_list_file']["tmp_name"]);
				$x=2;
				while($x <= $excel->sheets[0]['numRows']) {
					$vIsbn = isset($excel->sheets[0]['cells'][$x][1]) ? trim($excel->sheets[0]['cells'][$x][1]) : '';
					$vIsbnExists = $vQuery->checkExists($conn, "books", "id", "isbn = '".trim($vIsbn)."'");
					if($vIsbnExists >= 1){
						unset($vData["special_price"]);
						unset($vData["price"]);
// 						$vIsSpecial = $vQuery->checkSpecial($conn, "isbn = '".$vIsbn."'");
// 						if($vIsSpecial == 1){
// 							$vData['special_price'] = isset($excel->sheets[0]['cells'][$x][2]) ? $excel->sheets[0]['cells'][$x][2] : '';
// 							$vThePrice = $vData['special_price'];
// 							$vText = "Winskopie prys";
// 						}
// 						else if ($vIsSpecial == 0){
							$vData['price'] = isset($excel->sheets[0]['cells'][$x][2]) ? $excel->sheets[0]['cells'][$x][2] : '';
							$vThePrice = $vData['price'];
							$vText = "Prys";
							$vOldPrice = $vQuery->getBookPrice($conn, $vIsbn);
							($vThePrice != $vOldPrice ? $vShowStyleStart = "<b><u>" : $vShowStyleStart = "");
							($vThePrice != $vOldPrice ? $vShowStyleEnd = "</b></u>" : $vShowStyleEnd = "");
//						}
						$vQueryResult = $vQuery->doUpdate($conn, "books", $vData, "isbn = '".trim($vIsbn)."'");
								$vStringA .="<tr>";
									$vStringA .= "<td class=\"dt-body-center bg-success\">".$x."</td>";
									$vStringA .= "<td class=\"dt-body-center bg-success\">".trim($vIsbn)."</td>";
									$vStringA .= "<td class=\"dt-body-center bg-success\">".$vShowStyleStart.$vOldPrice.$vShowStyleEnd."</td>";
									$vStringA .= "<td class=\"dt-body-center bg-success\">".$vShowStyleStart.$vThePrice.$vShowStyleEnd."</td>";
								$vStringA .="</tr>";
					}
					else if($vIsbnExists == 0){
							$vStringA .="<tr>";
								$vStringA .= "<td class=\"bg-error dt-body-center\">".$x."</td>";
								$vStringA .= "<td class=\"bg-error dt-body-center\">".trim($vIsbn)."</td>";
								$vStringA .= "<td class=\"bg-error dt-body-center\" colspan=\"2\">ISBN nie gevind nie</td>";
							$vStringA .="</tr>";
					}
					$x++;
				}
		    }
			$vStringA .= "</tbody>";
		}

		//############################################################################################ Book images
		else if($vType == "load_images"){
			$vStringA .= "<h1>LAAI BOEKE VOORBLAAIE</h1>";

			$vStringA .= "<table id=\"imageTable\" class=\"cell-border dataTable hover\" cellspacing=\"0\">";
			$vStringA .= "<tbody><tr><td>";

			$vNum = 0;
			if(!empty($_FILES['images']['name'])){
				$vDirectory = "../images/books/";
				$vUnique = uniqid() . "/";
				$vUniqueDirectory = $vDirectory . $vUnique;
				if(!is_dir($vUniqueDirectory)) {
					mkdir($vUniqueDirectory, 0777);
				}
			    foreach ($_FILES['images']['name'] as $i => $name) {
			        if (strlen($_FILES['images']['name'][$i]) > 1) {
			        	$vIsbn = substr($name, 0 , strpos($name, "."));
						$vDataImages['blob_path'] = $vUnique.preg_replace('/\s+/', '', $name);
						move_uploaded_file($_FILES['images']['tmp_name'][$i], $vUniqueDirectory.preg_replace('/\s+/', '', $name));
						$vQueryResultImages = MysqlQuery::doUpdate($conn, 'books', $vDataImages, "isbn = '".trim($vIsbn)."'");
						$vNum++;
			        }
			    }

				if ($vQueryResultImages >= 1){
					$vStringA .= "<h4 class=\"success-message\"><i class=\"fa fa-check fa-lg space-right green\" aria-hidden=\"true\"></i>".$vNum." prente is suksesvol gelaai.</h4></td></tr>";
				}
				else if($vQueryResultImages == 0){
					$vStringA .= "<h4 class=\"error-message\"><i class=\"fa fa-times fa-lg space-right red\" aria-hidden=\"true\"></i>Geen prente is gelaai nie.</h4></td></tr>";
				}
			}
			else{
				$vStringA .= "<h4 class=\"error-message\"><i class=\"fa fa-times fa-lg space-right red\" aria-hidden=\"true\"></i>Daar is geen prente in die le&#234;r nie.</h4></td></tr>";
			}
		}
	//############################################################################################  Stock update - Music
	if($vType == "stock_update_music"){
			$vStringA .= "<h1>Laai voorraadlys op - Musiek</h1>";
			$vStringA .= "<h2>Voorraadlys opgelaai - Resultate:</h2>";

			$vStringA .= "<table id=\"stockTable\" class=\"cell-border dataTable hover\" cellspacing=\"0\">";
				$vStringA .= "<thead>";
					$vStringA .= "<tr class=\"red\">";
						$vStringA .= "<th class=\"dt-head-center\">Ry no</th>";
						$vStringA .= "<th class=\"dt-head-center\">ISBN</th>";
						$vStringA .= "<th class=\"dt-head-center\">Publikasie datum</th>";
						$vStringA .= "<th class=\"dt-head-center\">Voorraad</th>";
						$vStringA .= "<th class=\"dt-head-center\">Uitdruk</th>";
					$vStringA .= "</tr>";
			$vStringA .= "</thead>";
				$vStringA .= "<tfoot>";
					$vStringA .= "<tr class=\"red\">";
						$vStringA .= "<th class=\"dt-head-center\">Ry no</th>";
						$vStringA .= "<th class=\"dt-head-center\">ISBN</th>";
						$vStringA .= "<th class=\"dt-head-center\">Voorraad</th>";
						$vStringA .= "<th class=\"dt-head-center\">Uitdruk</th>";
					$vStringA .= "</tr>";
			$vStringA .= "</tfoot>";
			$vStringA .= "<tbody>";
			$vFileType = substr($_FILES['stock_file']['name'], strpos($_FILES['stock_file']['name'], "."));
		    if($vFileType == ".xlsx"){
		    	include "application/classes/simplexlsx.class.php";
				$xlsx = new SimpleXLSX( $_FILES['stock_file']['tmp_name'] );
				$rowNo = 2;

				//Set all stock = 0
				$vDataZ['in_stock'] = 0;
				$vQueryResultZ = $vQuery->doUpdate($conn, "books", $vDataZ, "id > 0 AND publisher = 3");

				foreach( $xlsx->rows() as $k => $r) {
					if ($k == 0) continue; // skip first row
					$vIsbnExists = $vQuery->checkExists($conn, "books", "id", "isbn = '".trim($r[0])."'");
					if($vIsbnExists >= 1){
						$vData["in_stock"] = $r[3];
						$vData["out_of_print"] = 0;
						$vQueryResult = $vQuery->doUpdate($conn, "books", $vData, "isbn = '".trim($r[0])."'");
							$vStringA .="<tr>";
								$vStringA .= "<td class=\"dt-body-center bg-success\">".$rowNo."</td>";
								$vStringA .= "<td class=\"dt-body-center bg-success\">".trim($r[0])."</td>";
								$vStringA .= "<td class=\"dt-body-center bg-success\">".$vData["in_stock"]."</td>";
								$vStringA .= "<td class=\"dt-body-center bg-success\">Nee</td>";
							$vStringA .="</tr>";
					}
					else if($vIsbnExists == 0){
							$vStringA .="<tr>";
								$vStringA .= "<td class=\"bg-error dt-body-center\">".$rowNo."</td>";
								$vStringA .= "<td class=\"bg-error dt-body-center\">".trim($r[0])."</td>";
								$vStringA .= "<td class=\"bg-error dt-body-center\">ISBN nie gevind nie</td>";
								$vStringA .= "<td class=\"bg-error dt-body-center\"></td>";
							$vStringA .="</tr>";
					}
					$rowNo++;
				}
		    }
		    else if($vFileType == ".xls"){
				include "include/reader.php";
				$excel = new Spreadsheet_Excel_Reader();
				$excel->read($_FILES['stock_file']["tmp_name"]);
				$x=2;

				//Set all stock = 0
				$vDataZ['in_stock'] = 0;
				$vQueryResultZ = $vQuery->doUpdate($conn, "books", $vDataZ, "id > 0 AND publisher = 3");

				while($x <= $excel->sheets[0]['numRows']) {
					$vIsbn = isset($excel->sheets[0]['cells'][$x][1]) ? $excel->sheets[0]['cells'][$x][1] : '';
					$vIsbnExists = $vQuery->checkExists($conn, "books", "id", "isbn = '".trim($vIsbn)."'");
					if($vIsbnExists >= 1){
						$vData["in_stock"] = $excel->sheets[0]['cells'][$x][4];
						$vData["out_of_print"] = 0;
						$vQueryResult = $vQuery->doUpdate($conn, "books", $vData, "isbn = '".trim($vIsbn)."'");
								$vStringA .="<tr>";
									$vStringA .= "<td class=\"dt-body-center bg-success\">".$x."</td>";
									$vStringA .= "<td class=\"dt-body-center bg-success\">".trim($vIsbn)."</td>";
									$vStringA .= "<td class=\"dt-body-center bg-success\">".$vData["in_stock"]."</td>";
									$vStringA .= "<td class=\"dt-body-center bg-success\">Nee</td>";
								$vStringA .="</tr>";
					}
					else if($vIsbnExists == 0){
							$vStringA .="<tr>";
								$vStringA .= "<td class=\"bg-error dt-body-center\">".$x."</td>";
								$vStringA .= "<td class=\"bg-error dt-body-center\">".trim($vIsbn)."</td>";
								$vStringA .= "<td class=\"bg-error dt-body-center\">ISBN nie gevind nie</td>";
								$vStringA .= "<td class=\"bg-error dt-body-center\"></td>";
							$vStringA .="</tr>";
					}
					$x++;
				}
		    }
			$vStringA .= "</tbody>";
		}

	$vStringA .= "</table>";

	echo $vStringA;

$vEnd = $vCmsParts->returnEndHtml($conn);
echo $vEnd;
include "../include/connect/CloseConnect.php";
