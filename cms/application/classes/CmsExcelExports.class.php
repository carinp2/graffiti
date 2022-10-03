<?php
/**
 * @author Carin Pretorius - CEIT Development
 * Created on 2016-11-02
 */

class CmsExcelExports {

	public static function getBookExport($pConn, $pData){
		if($pData['type'] == "searchBookPublisher"){
			$vPublisher = MysqlQuery::getPublisherPerId($pConn, $pData['id']);//$vPubId, $vPub, $vPubSupplier
			$vPublisherId = $pData['id'];
			$vWhere = "WHERE b.publisher = ?";
			$vOrder = " ORDER BY b.title ASC";
			$vBindLetters .= "i";
			$vBindParams[] = & $vPublisherId;
			$vLimit = "";
			$vHeading = "Boeke per uitgewer: ".$vPublisher[1]." - ".$vPublisher[2];
		}
		else 	if($pData['type'] == "searchBookSubCategory"){
			//$vSubCategory = MysqlQuery::getSubCategorPerId($pConn, $pData['id']);
			$vCategory = MysqlQuery::getCategorySubCategoryFromSubCat($pConn, $pData['id']);//$vSubCategory, $vCategory
			$vSubCategoryId = $pData['id'];
			$vWhere = "WHERE b.sub_category = ?";
			$vOrder = " ORDER BY b.title ASC";
			$vBindLetters .= "i";
			$vBindParams[] = & $vSubCategoryId;
			$vLimit = "";
			$vHeading = "Boeke per sub-kategorie: ".$vCategory[1]." - ".$vCategory[0];
		}
		$vResults = MysqlQuery::getBooks($pConn, $vWhere, $vOrder, $vBindLetters, $vBindParams, $vLimit);

		$vString = "<h4>".$vHeading."</h4>";
			$vString .= "<table>";
				$vString .= "<thead>";
					$vString .= "<tr>";
						$vString .= "<th style=\"border: 0.05em solid #404040;\">Titel</th>";
						$vString .= "<th style=\"border: 0.05em solid #404040;\">ISBN</th>";
						$vString .= "<th style=\"border: 0.05em solid #404040;\">Kategorie</th>";
						$vString .= "<th style=\"border: 0.05em solid #404040;\">Sub-kategorie</th>";
						$vString .= "<th style=\"border: 0.05em solid #404040;\">Prys</th>";
						$vString .= "<th style=\"border: 0.05em solid #404040;\">Winskopie</th>";
						$vString .= "<th style=\"border: 0.05em solid #404040;\">Winskopie prys</th>";
						$vString .= "<th style=\"border: 0.05em solid #404040;\">Outomatiese afslag</th>";
						$vString .= "<th style=\"border: 0.05em solid #404040;\">Publikasie datum</th>";
						$vString .= "<th style=\"border: 0.05em solid #404040;\">Nuut</th>";
						$vString .= "<th style=\"border: 0.05em solid #404040;\">Topverkoper</th>";
						$vString .= "<th style=\"border: 0.05em solid #404040;\">Topverkoper posisie</th>";
						$vString .= "<th style=\"border: 0.05em solid #404040;\">Uit druk</th>";
						$vString .= "<th style=\"border: 0.05em solid #404040;\">In voorraad</th>";
						$vString .= "<th style=\"border: 0.05em solid #404040;\">Uitgewer</th>";
						$vString .= "<th style=\"border: 0.05em solid #404040;\">Taal</th>";
						$vString .= "<th style=\"border: 0.05em solid #404040;\">Outeur</span></th>";
						$vString .= "<th style=\"border: 0.05em solid #404040;\">Vertaler</th>";
						$vString .= "<th style=\"border: 0.05em solid #404040;\">Illustreerder</th>";
						$vString .= "<th style=\"border: 0.05em solid #404040;\">Dimensies (H x W x D)</th>";
						$vString .= "<th style=\"border: 0.05em solid #404040;\">Gewig (gram)</th>";
						$vString .= "<th style=\"border: 0.05em solid #404040;\">Bladsye</th>";
						$vString .= "<th style=\"border: 0.05em solid #404040;\">Formaat</th>";
						$vString .= "<th style=\"border: 0.05em solid #404040;\">Voorblad</th>";
					$vString .= "</tr>";
				$vString .= "</thead>";
				$vString .= "<tbody>";
				if(count($vResults[0]) > 0){
					for($x = 0; $x < count($vResults[0]); $x++){
						(strlen($vResults[14][$x]) == 1 ? $vTopRank = "0".$vResults[14][$x] : $vTopRank = $vResults[14][$x]);
						(strlen($vResults[6][$x]) > 0 ? $vCover = "Y" : $vCover = "N");
						$vString .= "<tr>";
							$vString .= "<td style=\"border: 0.05em solid #404040;\">".$vResults[4][$x]."</td>";//title
							$vString .= "<td style=\"border: 0.05em solid #404040;\">&nbsp;".$vResults[1][$x]."</td>";//isbn
							$vString .= "<td style=\"border: 0.05em solid #404040;\">".$vResults[19][$x]."</td>";//cat
							$vString .= "<td style=\"border: 0.05em solid #404040;\">".$vResults[20][$x]."</td>";// sub-cat
							$vString .= "<td style=\"border: 0.05em solid #404040;\">".$vResults[8][$x]."</td>";//price
							$vString .= "<td style=\"border: 0.05em solid #404040; text-align: center;\">".General::returnYesNo($vResults[12][$x])."</td>";//special
							$vString .= "<td style=\"border: 0.05em solid #404040;\">".$vResults[7][$x]."</td>";//special price
							$vString .= "<td style=\"border: 0.05em solid #404040;\">".$vResults[26][$x]."</td>";//default_discount
							$vString .= "<td style=\"border: 0.05em solid #404040;\">".$vResults[25][$x]."</td>";//publication date
							$vString .= "<td style=\"border: 0.05em solid #404040; text-align: center;\">".General::returnYesNo($vResults[11][$x])."</td>";//new
							$vString .= "<td style=\"border: 0.05em solid #404040; text-align: center;\">".General::returnYesNo($vResults[13][$x])."</span>";//topseller
							$vString .= "<td style=\"border: 0.05em solid #404040;\">".$vTopRank."</td>";//rank
							$vString .= "<td style=\"border: 0.05em solid #404040; text-align: center;\">".General::returnYesNo($vResults[15][$x])."</td>";//out of print
							$vString .= "<td style=\"border: 0.05em solid #404040; text-align: center;\">".$vResults[16][$x]."</td>";//in_stock
							$vString .= "<td style=\"border: 0.05em solid #404040;\">".$vPublisher[1]."</td>";//publisher
							$vString .= "<td style=\"border: 0.05em solid #404040;\">".$vResults[18][$x]."</td>";//language
							$vString .= "<td style=\"border: 0.05em solid #404040;\">".str_replace(",", ", ", $vResults[21][$x])."</td>";//author
							$vString .= "<td style=\"border: 0.05em solid #404040;\">".str_replace(",", ", ",$vResults[22][$x])."</td>";//translator
							$vString .= "<td style=\"border: 0.05em solid #404040;\">".str_replace(",", ", ",$vResults[23][$x])."</td>";// illustrator
							$vString .= "<td style=\"border: 0.05em solid #404040;\">".$vResults[27][$x]."</td>";//dimensions
							$vString .= "<td style=\"border: 0.05em solid #404040;\">".$vResults[28][$x]."</td>";//weight
							$vString .= "<td style=\"border: 0.05em solid #404040;\">".$vResults[30][$x]."</td>";//pages
							$vString .= "<td style=\"border: 0.05em solid #404040;\">".MysqlQuery::getLookupPerId($pConn, $vResults[29][$x])."</td>";//format
							$vString .= "<td style=\"border: 0.05em solid #404040;\">".$vCover."</td>";//blob
						$vString .= "</tr>";
					}
				}
				else {
					$vString .= "<tr>";
						$vString .= "<td colspan=\"23\">Geen data gevind</td>";
						$vString .= "</tr>";
				}
					$vString .= "</tbody>";
				$vString .= "</table>";

		   header("Content-Type: application/xls");
           header("Content-Disposition: attachment; filename=books_".$vPublisherId.".xls");
           header('Content-Description: File Transfer');
           header('Content-Transfer-Encoding: binary');
           header('Expires: 0');
           header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
           header('Pragma: public');
           echo "\xEF\xBB\xBF"; // UTF-8 BOM
           echo General::prepareStringForDisplay($vString);
	}

	public static function getBookMarketExport($pConn){
    	$vWhere = "WHERE b.out_of_print = ?";
    	$vValue = 0;
		$vBindParams = array();
		$vBindLetters = "";
		$vBindLetters .= "i";
		$vBindParams[] = & $vValue;
		$vResults = MysqlQuery::getBooks($pConn, $vWhere, "ORDER BY b.date_publish DESC", $vBindLetters, $vBindParams, '');

			$vString .= "<table>";
				$vString .= "<thead>";
					$vString .= "<tr>";
						$vString .= "<th style=\"border: 0.1pt solid #DDDDDD;\">ID</th>";
						$vString .= "<th style=\"border: 0.1pt solid #DDDDDD;\">ID2</th>";
						$vString .= " <th style=\"border: 0.1pt solid #DDDDDD;\">Item title</th>";
						$vString .= " <th style=\"border: 0.1pt solid #DDDDDD;\">Final URL</th>";
						$vString .= "<th style=\"border: 0.1pt solid #DDDDDD;\">Image URL</th>";
						$vString .= "<th style=\"border: 0.1pt solid #DDDDDD;\">Item subtitle</th>";
						$vString .= "<th style=\"border: 0.1pt solid #DDDDDD;\">Item description</th>";
						$vString .= "<th style=\"border: 0.1pt solid #DDDDDD;\">Item category</th>";
						$vString .= "<th style=\"border: 0.1pt solid #DDDDDD;\">Price</th>";
						$vString .= "<th style=\"border: 0.1pt solid #DDDDDD;\">Sale price</th>";
						$vString .= "<th style=\"border: 0.1pt solid #DDDDDD;\">Contextual keywords</th>";
						$vString .= "<th style=\"border: 0.1pt solid #DDDDDD;\">Item address</th>";
					$vString .= "</tr>";
				$vString .= "</thead>";
				$vString .= "<tbody>";
				if(count($vResults[0]) > 0){
					for($x = 0; $x < count($vResults[0]); $x++){
						($vResults[12][$x] == 1 ? $vSpecialPrice = "0".$vResults[7][$x] : $vSpecialPrice = $vResults[8][$x]);
						$vKeywords = $vResults[4][$x]."; ".$vResults[19][$x]."; ".$vResults[20][$x];
						$vString .= "<tr>";
							$vString .= "<td style=\"border: 0.1pt solid #DDDDDD;\">&nbsp;".$vResults[1][$x]."</td>";//isbn
							$vString .= "<td style=\"border: 0.1pt solid #DDDDDD;\">&nbsp;".$vResults[0][$x]."</td>";//id
							$vString .= "<td style=\"border: 0.1pt solid #DDDDDD;\">".substr($vResults[4][$x], 0, 25)."</td>";//title
							$vString .= "<td style=\"border: 0.1pt solid #DDDDDD;\">https://www.graffitibooks.co.za/en/".$vResults[0][$x]."/Books</td>";//url
							$vString .= "<td style=\"border: 0.1pt solid #DDDDDD;\">https://www.graffitibooks.co.za/images/books/".$vResults[6][$x]."</td>";//image url
							$vString .= "<td style=\"border: 0.1pt solid #DDDDDD;\">".str_replace(",", ", ", $vResults[21][$x])."</td>";////subtitle - author
							$vString .= "<td style=\"border: 0.1pt solid #DDDDDD;\">".substr($vResults[5][$x], 0, 255)."</td>";//description
							$vString .= "<td style=\"border: 0.1pt solid #DDDDDD;\">".$vResults[19][$x]." - ".$vResults[20][$x]."</td>";//cat
							$vString .= "<td style=\"border: 0.1pt solid #DDDDDD;\">R ".$vResults[8][$x]."</td>";//price
							$vString .= "<td style=\"border: 0.1pt solid #DDDDDD;\">R ".$vSpecialPrice."</td>";//sale price
							$vString .= "<td style=\"border: 0.1pt solid #DDDDDD; \">".$vKeywords."</td>";//keywords
							$vString .= "<td style=\"border: 0.1pt solid #DDDDDD;\">Graffiti Zambezi Junction, Shop no 10, Zambezi Junction, Corner of Breed Street &amp; Sefako Makgatho Drive, Montana, Pretoria, Gauteng, South Africa, 0182</td>";//Address
						$vString .= "</tr>";
					}
				}
				else {
					$vString .= "<tr>";
						$vString .= "<td colspan=\"23\">No data found</td>";
						$vString .= "</tr>";
				}
					$vString .= "</tbody>";
				$vString .= "</table>";

		   header("Content-Type: application/xls");
           header("Content-Disposition: attachment; filename=books_all.xls");
           header('Content-Description: File Transfer');
           header('Content-Transfer-Encoding: binary');
           header('Expires: 0');
           header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
           header('Pragma: public');
           echo "\xEF\xBB\xBF"; // UTF-8 BOM
           echo General::prepareStringForDisplay($vString);
	}

	public static function getMonthEndExport($pConn, $pStartDate, $pEndDate) {
		$vResult = MysqlQuery::getMonthEndStats($pConn, $pStartDate, $pEndDate);
		//$vIsbn, $vBookId, $vPriceOne, $vSoldPrice, $vOriginalPrice, $vCostPrice, $vOrderDate, $vPublisher, $vSpecial, $vCostPercentage, $vNumberBooks, $vOrderId, $vCostOne
		//	0		1				2		3				4				5			6			7			8				9				10			11           12
		$vTotalCost = 0;

		$vString = "<table>";
			$vString .= "<thead>";
				$vString .= "<tr>";
					$vString .= "<th style=\"border: 0.1pt solid #DDDDDD;\">ISBN</th>";
					$vString .= "<th style=\"border: 0.1pt solid #DDDDDD;\">Datum</th>";
					$vString .= "<th style=\"border: 0.1pt solid #DDDDDD;\">Prys vir 1</th>";
					$vString .= "<th style=\"border: 0.1pt solid #DDDDDD;\">Aantal verkoop</th>";
					$vString .= "<th style=\"border: 0.1pt solid #DDDDDD;\">Oorspronklike prys</th>";
					$vString .= "<th style=\"border: 0.1pt solid #DDDDDD;\">Verkoopprys</th>";
					$vString .= "<th style=\"border: 0.1pt solid #DDDDDD;\">Kosprys Calculated</th>";
					$vString .= "<th style=\"border: 0.1pt solid #DDDDDD;\">Uitgewer</th>";
					$vString .= "<th style=\"border: 0.1pt solid #DDDDDD;\">Cost %</th>";
					$vString .= "<th style=\"border: 0.1pt solid #DDDDDD;\">Winskopie</th>";
					$vString .= "<th style=\"border: 0.1pt solid #DDDDDD;\">Kosprys</th>";
					$vString .= "<th style=\"border: 0.1pt solid #DDDDDD;\">Kosprys 1</th>";
				$vString .= "</tr>";
			$vString .= "</thead>";

		for($x = 0; $x < count($vResult[0]); $x++){
			$vData['me'] = 1;
			MysqlQuery::doUpdate($pConn, "orders", $vData, "id = ".$vResult[11][$x]);
			if($vResult[8][$x] == 1){
				$vCostPrice = $vResult[5][$x];
				$vTotalCost = $vTotalCost+$vCostPrice;
			}
			else {
				$vPerc = (100-$vResult[9][$x])/100;
				$vCostPrice = round($vResult[4][$x]*$vPerc);
				$vTotalCost = $vTotalCost+$vCostPrice;
			}
			$vString .= "<tbody>";
				$vString .= "<tr class=\"red\">";
					$vString .= "<td align=\"center\" style=\"border: 0.1pt solid #DDDDDD;\">'".$vResult[0][$x]."'</td>";
					$vString .= "<td align=\"center\" style=\"border: 0.1pt solid #DDDDDD;\">".$vResult[6][$x]."</td>";
					$vString .= "<td align=\"right\" style=\"border: 0.1pt solid #DDDDDD;\">R".$vResult[2][$x]."</td>";
					$vString .= "<td align=\"center\" style=\"border: 0.1pt solid #DDDDDD;\">".$vResult[10][$x]."</td>";
					$vString .= "<td align=\"right\" style=\"border: 0.1pt solid #DDDDDD;\">R".$vResult[4][$x]."</td>";
					$vString .= "<td align=\"right\" style=\"border: 0.1pt solid #DDDDDD;\">R".$vResult[3][$x]."</td>";
					$vString .= "<td align=\"right\" style=\"border: 0.1pt solid #DDDDDD;\">R".$vCostPrice."</td>";
					$vString .= "<td align=\"center\" style=\"border: 0.1pt solid #DDDDDD;\">".$vResult[7][$x]."</td>";
					$vString .= "<td align=\"center\" style=\"border: 0.1pt solid #DDDDDD;\">".$vResult[9][$x]."%</td>";
					$vString .= "<td align=\"center\" style=\"border: 0.1pt solid #DDDDDD;\">".($vResult[8][$x] == 1 ? "J" : "N" )."</td>";
					$vString .= "<td align=\"right\" style=\"border: 0.1pt solid #DDDDDD;\">R".$vResult[5][$x]."</td>";
					$vString .= "<td align=\"right\" style=\"border: 0.1pt solid #DDDDDD;\">R".$vResult[12][$x]."</td>";
				$vString .= "</tr>";
			$vString .= "</tbody>";

		}
			$vString .= "<tfoot>";
				$vString .= "<tr class=\"red\">";
					$vString .= "<th style=\"border: 0.1pt solid #DDDDDD;\"></th>";
					$vString .= "<th style=\"border: 0.1pt solid #DDDDDD;\"></th>";
					$vString .= "<th style=\"border: 0.1pt solid #DDDDDD;\"></th>";
					$vString .= "<th style=\"border: 0.1pt solid #DDDDDD;\"></th>";
					$vString .= "<th align=\"right\" style=\"border: 0.1pt solid #DDDDDD;\">R".array_sum($vResult[4])."</th>";
					$vString .= "<th align=\"right\" style=\"border: 0.1pt solid #DDDDDD;\">R".array_sum($vResult[3])."</th>";
					$vString .= "<th align=\"right\" style=\"border: 0.1pt solid #DDDDDD;\">R".$vTotalCost."</th>";
					$vString .= "<th style=\"border: 0.1pt solid #DDDDDD;\"></th>";
					$vString .= "<th style=\"border: 0.1pt solid #DDDDDD;\"></th>";
					$vString .= "<th style=\"border: 0.1pt solid #DDDDDD;\"></th>";
					$vString .= "<th style=\"border: 0.1pt solid #DDDDDD;\"></th>";
					$vString .= "<th style=\"border: 0.1pt solid #DDDDDD;\"></th>";
				$vString .= "</tr>";
			$vString .= "</tfoot>";

			header("Content-Type: application/xls");
		    header("Content-Disposition: attachment; filename=month_end.xls");
		    header('Content-Description: File Transfer');
		    header('Content-Transfer-Encoding: binary');
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		    header('Pragma: public');
		    echo "\xEF\xBB\xBF"; // UTF-8 BOM
		    echo General::prepareStringForDisplay($vString);
	}

}
?>