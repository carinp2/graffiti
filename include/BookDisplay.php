<?php
	$vPage = MysqlQuery::getText($pConn, 14);/*Soek*/
	$vString = "";
	if(count($vResults[0]) > 0){
		$vString .= "<form class=\"form-horizontal\" name=\"booksForm\" id=\"booksForm\">";
		$vString .= "<input type=\"hidden\" id=\"current-url\" name=\"current-url\" value=\"".$vCurrentUrl."\">";
		$vString .= "<div id=\"form-border\">";
			$vString .= "<div id=\"center\">";

			if($pSearchData['type'] != "b"){
				$vString .= "<div class=\"form-header\">";
					$vString .="<div class=\"row\">";
						$vString .= "<div class=\"col-xs-6 col-md-7\">";
							$vString .= "<h1 class=\"red\">".$vHeading."</h1>";
								if(!empty($pSort)){
									$vString .= "<span class=\"text-small green no-space\">Results ".$vWindowValues[6]." of ".$vWindowValues[5]."</span><br>";
									if(count($vResults[0]) > 1){
										$vString .= "<span class=\"text-small-normal green no-space\">".MysqlQuery::getText($pConn, 333)/*Gesorteer volgens*/.": ".General::returnSortOrderDescription($pConn, $pSort)."</span>";
									}
								}
						$vString .= "</div>";
						$vString .= "<div class=\"col-xs-6 col-md-5\">";
						if($pSearchData['type'] != "tv" && $pSearchData['type'] != "rr"){
							$vString .= "<span class=\"pull-right\">";
							if(count($vResults[0]) > 1 && !empty($pSort)){
								$vString .= General::echoSortOrderSelect($pConn, $pSort, $vUrlData, $vType);
							}
							$vString .= "</span>";
						}
						$vString .= "</div>";
						$vString .= "<div class=\"col-xs-1\"></div>";
					$vString .= "</div>";
				$vString .= "</div>";//Header
			}

				$vString .= "<div class=\"form-body\">";
					for($x = 0; $x < count($vResults[0]); $x++){
						if($vResults[41][$x] == 1){
							$vAuthorResult = MysqlQuery::getBookAIT($pConn, $vResults[0][$x], 262);//262 = outeur | 263 = Vertaler| 264 = Illustreerder
							$vTranslatorResult = MysqlQuery::getBookAIT($pConn, $vResults[0][$x], 263);
							$vIllustratorResult = MysqlQuery::getBookAIT($pConn, $vResults[0][$x], 264);
						}

						//$vId, $vBookId, $vName, $vType
						if(($vResults[13][$x] == 1) && $vResults[15][$x] == 0){
							$vClass = "bookSel";
						}
						else if($vResults[15][$x] == 1){
							$vClass = "outSel";
						}

						if($pSearchData['type'] == "tv"){
							for($v=0; $v < count($vVideoResults[0]); $v++){//$vId, $vDate, $vUrl, $vBookId
								if($vVideoResults[1][$v] == $vResults[37][$x] && $vVideoResults[3][$v] == $vResults[0][$x]){
									$vString .="<div class=\"row\">";
										$vString .= "<div class=\"col-xs-2 col-md-2\"></div>";
										$vString .= "<div class=\"col-xs-10 col-md-10 row-grid\">";
											$vString .= "<iframe width=\"450\" height=\"300\" src=\"https://www.youtube.com/embed/".$vVideoResults[2][$v]."\" frameborder=\"0\" allowfullscreen></iframe>";
										$vString .="</div>";
									$vString .="</div>";//row
									$vString .="<div class=\"row\"><div class=\"col-xs-12\"></div></div>";
								}
							}
						}
						if($pSearchData['type'] == "rr"){
							for($v=0; $v < count($vRrResults[0]); $v++){//$vId, $vDate, $vBlobPath, $vBookId
								if($vRrResults[1][$v] == $vResults[40][$x] && $vRrResults[3][$v] == $vResults[0][$x]){
									$vString .="<div class=\"row\">";
										$vString .= "<div class=\"col-xs-2 col-md-2\"></div>";
										$vString .= "<div class=\"col-xs-10 col-md-8 row-grid\">";
											$vString .= "<img class=\"img-responsive thumb\" src=\"images/rooirose/".$vRrResults[2][$v]."\" id=\"rooirose\" tile=\"rooi rose\" alt=\"rooi rose\">";
										$vString .="</div>";
									$vString .="</div>";//row
									$vString .="<div class=\"row\"><div class=\"col-xs-12 col-md-2\">&nbsp;</div></div>";
								}
							}
						}

						$vString .="<div class=\"row\">";
						$vString .="<div itemscope itemtype=\"http://schema.org/Product\" class=\"form-group\">";

						if($vResults[41][$x] == 1){
							$vString .= "<div class=\"col-xs-4 col-md-2 row-grid col-center thumb-book-image\" id=\"".$vClass."_".$vResults[0][$x]."\" data-id=\"".$vResults[0][$x]."\">";
						}
						else {
							$vString .= "<div class=\"col-xs-4 col-md-3 row-grid col-center thumb-book-image\" id=\"".$vClass."_".$vResults[0][$x]."\" data-id=\"".$vResults[0][$x]."\">";
						}
								if(!empty($vResults[6][$x])){
									$vString .= "<a href=\"images/books/".$vResults[6][$x]."\" data-lightbox=\"img_".$vResults[6][$x]."\" data-title=\"".$vResults[4][$x]."\" title=\"".$vResults[4][$x]."\">";
										$vString .= "<img itemprop=\"image\" id=\"".$vResults[0][$x]."\" src=\"images/books/".$vResults[6][$x]."\" class=\"img-responsive thumb\" alt=\"".MysqlQuery::getText($pConn, 311)/*Klik om te vergroot*/."\" title=\"".MysqlQuery::getText($pConn, 311)/*Klik om te vergroot*/."\">";
									$vString .= "</a>";
									$vString .= "<div class=\"text-xsmall\">".MysqlQuery::getText($pConn, 311)/*Klik om te vergroot*/."</div>";
									if($vResults[13][$x] == 1 && $vResults[15][$x] == 0){
										$vString .= "<h2 id=\"bookSelCircle_".$vResults[0][$x]."\" data-toggle=\"tooltip\" data-placement=\"bottom\"  title=\"".MysqlQuery::getText($pConn, 33)/*Topverkoper*/."\">".$vResults[14][$x]."</h2>";
									}
									else if($vResults[15][$x] ==1){
										$vString .= "<h2 id=\"bookOutBanner_".$vResults[0][$x]."\">".MysqlQuery::getText($pConn, 354)/*Uit druk*/."</h2>";
									}
								}
								else {
									$vString .= "<a href=\"images/no_image.png\" data-lightbox=\"img_logo.png\" data-title=\"".MysqlQuery::getText($pConn, 143)/*Geen voorblad*/."\" title=\"".MysqlQuery::getText($pConn, 143)/*Geen voorblad*/."\">";
										$vString .= "<img id=\"".$vResults[0][$x]."\" src=\"images/no_image.png\" class=\"img-responsive cart-thumb thumb\" alt=\"".MysqlQuery::getText($pConn, 143)/*Geen voorblad*/."\" title=\"".MysqlQuery::getText($pConn, 143)/*Geen voorblad*/."\">";
									$vString .= "</a>";
								}
								$vString .= "<div class=\"white\">".$vResults[1][$x]."</div>";

							$vString .= "</div>";//col
						if($vResults[41][$x] == 1){
							$vString .= "<div class=\"col-xs-8 col-md-10\">";
						}
						else {
							$vString .= "<div class=\"col-xs-8 col-md-9\">";
						}
								$vString .= "<div><h1 class=\"green\"><a href=\"".$_SESSION['SessionGrafFullServerUrl'].$_SESSION['SessionGrafLanguage']."/".$vResults[0][$x]."/".MysqlQuery::getText($pConn, 157)/*Boeke*/."\" itemprop=\"name\" title=\"".$vResults[4][$x]."\">".General::str_highlight($vResults[4][$x], $pSearchData['cat'])."</a>
                                    <i class='fa fa-copy fa-xs gray space-left' onClick=\"copyToClipboard('".$_SESSION['SessionGrafFullServerUrl'].$_SESSION['SessionGrafLanguage']."/".$vResults[0][$x]."', '".MysqlQuery::getText($pConn, 498)."');\" data-url='".$_SESSION['SessionGrafFullServerUrl'].$_SESSION['SessionGrafLanguage']."/".$vResults[0][$x]."' data-toggle='tooltip' data-placement='top' data-original-title='".MysqlQuery::getText($pConn, 497)."'></i>
                                    <span class='copied-toast text-xsmall'></span>                                    
                                    </h1></div>";//title
								($vResults[20][$x] == "Penne / Pens" ? $vSubHead = "" : $vSubHead = $vResults[19][$x].": ");
								$vString .= "<h2 class=\"no-display\">".$vSubHead.$vResults[20][$x]."</h2>";

								if(!empty($vResults[21][$x]) && $vResults[41][$x] == 1){
									$vAuthorResult = explode(",", $vResults[21][$x]);
									$vString .= "<div class=\"text-small-normal blue no-space\">";
										for($a = 0; $a < count($vAuthorResult); $a++){
											($a < count($vAuthorResult)-1 ? $vASep = ", " : $vASep = "");
											$vString .= "<a class=\"red-menu\"href=\"".$_SESSION['SessionGrafLanguage']."/a/".$vPage."/0/date_publish DESC/".str_replace(".", "~", $vAuthorResult[$a])."\" title=\"".$vAuthorResult[$a]."\" title=\"".$vAuthorResult[$a]."\">".General::str_highlight($vAuthorResult[$a].$vASep, $pSearchData['cat'])."</a>";
										}
									$vString .= "</div>";
								}

// 							$vAuthorResult = $vResults[21][$x];
// 							$vTranslatorResult = $vResults[22][$x];
// 							$vIllustratorResult = $vResults[23][$x];

								if(!empty($vResults[23][$x]) && $vResults[41][$x] == 1){
									$vTranslatorResult = explode(",", $vResults[23][$x]);
									$vString .= "<div class=\"text-small-normal blue no-space\">".MysqlQuery::getText($pConn, 263)/*Vertaler*/.": ";
										for($t = 0; $t < count($vTranslatorResult); $t++){
											($t < count($vTranslatorResult)-1 ? $vTSep = ", " : $vTSep = "");
											$vString .= "<a class=\"red-menu\"href=\"".$_SESSION['SessionGrafLanguage']."/a/".$vPage."/0/date_publish DESC/".str_replace(".", "~", $vTranslatorResult[$t])."\" title=\"".$vTranslatorResult[$t]."\">".General::str_highlight($vTranslatorResult[$t].$vTSep, $pSearchData['cat'])."</a>";
										}
									$vString .= "</div>";
								}
								else if(!empty($vResults[23][$x]) && $vResults[41][$x] == 3){
									$vString .= "<div class=\"text-small-normal blue no-space\">";
										$vString .= "<a class=\"green\"href=\"".$_SESSION['SessionGrafLanguage']."/a/".$vPage."/0/date_publish DESC/".$vResults[23][$x]."\" title=\"".$vResults[23][$x]."\">".General::str_highlight($vResults[23][$x], $pSearchData['cat'])."</a>";
									$vString .= "</div>";
								}

								if(!empty($vResults[22][$x]) && $vResults[41][$x] == 1){
									$vIllustratorResult = explode(",", $vResults[22][$x]);
									$vString .= "<div class=\"text-small-normal blue no-space\">".MysqlQuery::getText($pConn, 264)/*Illustreerder*/.": ";
										for($i = 0; $i < count($vIllustratorResult); $i++){
											($i < count($vIllustratorResult)-1 ? $vISep = ", " : $vISep = "");
											$vString .= "<a class=\"red-menu\"href=\"".$_SESSION['SessionGrafLanguage']."/a/".$vPage."/0/date_publish DESC/".str_replace(".", "~", $vIllustratorResult[$i])."\" title=\"".$vIllustratorResult[$i]."\">".General::str_highlight($vIllustratorResult[$i].$vISep, $pSearchData['cat'])."</a>";
										}
									$vString .= "</div>";
								}
								else if(!empty($vResults[27][$x]) && $vResults[41][$x] == 3){
									$vString .= "<div class=\"text-small-normal blue no-space\">";
										$vString .= "<a class=\"green\"href=\"".$_SESSION['SessionGrafLanguage']."/a/".$vPage."/0/date_publish DESC/".$vResults[27][$x]."\" title=\"".$vResults[27][$x]."\">".General::str_highlight($vResults[27][$x], $pSearchData['cat'])."</a>";
									$vString .= "</div>";
								}

								//Cat & sub-cat
								if($vResults[41][$x] == 1 && $vResults[20][$x] != "Penne / Pens"){
									$vString .= "<div class=\"text-small-normal blue no-space\">".$vResults[19][$x]."&nbsp;&nbsp;-&nbsp;&nbsp;".$vResults[20][$x]."</div>";
								}

			                    //Price start
								if($vResults[41][$x] == 1){
									$vNewTopDiscountPrice =  round($vResults[8][$x]-($vResults[8][$x]*$vResults[26][$x]));
									(!empty($vResults[7][$x]) && $vResults[7][$x] > 0  ? $vSpecialDiscountPrice = $vResults[7][$x] : $vSpecialDiscountPrice = $vResults[8][$x]);
									$vClientDiscountPrice = round($vResults[8][$x]-($vResults[8][$x]*$_SESSION['SessionGrafSpecialDiscount']));
									$vSoonDiscountPrice = round($vResults[8][$x]-($vResults[8][$x]*$vResults[26][$x]));
									$vNormalPrice = $vResults[8][$x];
									$vPriceDisplayType = "book";
								}
								else if($vResults[41][$x] == 3){
									//7 - special_price
									//8 = retail_price
									$vNewTopDiscountPrice =  round($vResults[7][$x]);
									(!empty($vResults[7][$x]) && $vResults[7][$x] < $vResults[8][$x] ? $vSpecialDiscountPrice = $vResults[7][$x] : $vSpecialDiscountPrice = $vResults[8][$x]);
									$vClientDiscountPrice = round($vResults[8][$x]-($vResults[8][$x]*$_SESSION['SessionGrafSpecialDiscount']));
									$vSoonDiscountPrice = round($vResults[8][$x]);
									$vNormalPrice = $vResults[8][$x];
									$vPriceDisplayType = "book";
								}
								include "include/BookPriceDisplay.php";

								if($pSearchData['type'] != "b"){//book
									$vString .= "<div id=\"showmore_".$vResults[0][$x]."\" data-src=\"".$vResults[0][$x]."\" class=\"showmore_".$vResults[0][$x]." dgreen\" itemprop=\"description\">".General::str_highlight(General::str_highlight($vResults[5][$x], $pSearchData['cat']), $vKeyword)."</div>";//Summary
								}
								else {
									$vString .= "<div class=\"dgreen\" itemprop=\"description\">".$vResults[5][$x]."</div>";//Summary
								}

								if(((!empty( $vResults[27][$x]) && $vResults[27][$x] > 0) || (!empty($vResults[28][$x]) && $vResults[28][$x] > 0) || (!empty($vResults[29][$x]) && $vResults[29][$x] > 0) || (!empty($vResults[30][$x]) && $vResults[30][$x] > 0)) && $vResults[41][$x] == 1){
									$vFormat = MysqlQuery::getLookupPerId($pConn, $vResults[29][$x]);
									$vString .= "<div class=\"green\"><span id=\"bookinfoIcon_".$vResults[27][$x]."\" class=\"green info\" title=\"".$vResults[4][$x]."\" data-toggle=\"modal\" data-title=\"".$vResults[4][$x]."\" data-dimensions=\"".$vResults[27][$x]."\" data-weight=\"".$vResults[28][$x]."\" data-format=\"".$vFormat."\" data-pages=\"".$vResults[30][$x]."\"><i class=\"fa fa-info-circle fa-lg green\" aria-hidden=\"true\" data-html=\"true\" data-toggle=\"tooltip\" data-placement=\"top\"  title=\"".MysqlQuery::getText($pConn, 38)/*Meer inligting*/."\"></i></span></div>";
								}

								if($vResults[3][$x] <> 164 && $vResults[41][$x] == 1){//Exclude pens && stationary
									$vString .= "<div class=\"text-xsmall gray space-top-small\">".MysqlQuery::getText($pConn, 25)/*Publikasiedatum*/.": ".$vResults[25][$x]."</div>";
								}
								else if ($vResults[3][$x] == 164 || $vResults[41][$x] == 3){//Pens & Stationary
									$vString .= "<div class=\"text-xsmall gray space-top-small\">&nbsp;</div>";
								}

			                    $vString .= "<div class=\"thumb-book-shop\">";
				                    if(isset($_SESSION['SessionGrafUserId']) && $_SESSION['SessionGrafUserId'] != ''){//Logged in
                                        if($vResults[41][$x] != 3) {
                                            if (strtotime($_SESSION['now_date']) >= strtotime($vResults[25][$x])) {//Published
                                                if ($vResults[15][$x] == 0) {//out_print = No
                                                    $vString .= "<a class=\"btn btn-primary my-cart-btn-s\" role=\"button\" data-id=\"" . $vResults[0][$x] . "\" data-image=\"images/books/" . $vResults[6][$x] . "\" title=\"" . MysqlQuery::getText($pConn, 24)/*Laai in mandjie*/ . "\">" . MysqlQuery::getText($pConn, 24)/*Laai in mandjie*/ . "<i class=\"fa fa-shopping-basket top-margin\"></i></a>";
                                                    $vString .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a id=\"add-to-wishlist" . $vResults[0][$x] . "\" class=\"btn btn-primary\" role=\"button\" data-book=\"" . $vResults[0][$x] . "\" title=\"" . MysqlQuery::getText($pConn, 312)/*Laai in Wenslys*/ . "\">" . MysqlQuery::getText($pConn, 312)/*Laai in Wenslys*/ . "</a>";
                                                    //E-book start
                                                    if (isset($vResults[42][$x]) && !empty($vResults[42][$x])) {
                                                        $vString .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class=\"btn btn-primary my-cart-btn-s\" href=\"" . $vResults[43][$x] . "?acc=24611a00cd5703876097b06abc12643b\" target=\"_blank\" data-placement=\"top\" data-toggle=\"tooltip\" data-html=\"true\" title=\"" . MysqlQuery::getText($pConn, 480)/*Beskikbaar as e-Boek<br>e-Boeke word direk by LAPA*/ . "\">" . MysqlQuery::getText($pConn, 481)/*Bestel e-Boek*/ . "</a>";
                                                    }
                                                    //E-book end
                                                }
                                                if ($vResults[16][$x] == 0 && $vResults[15][$x] == 0) {//in_stock = 0 && out_of_print = No
                                                    $vString .= "<div class=\"text-small-normal red\">" . MysqlQuery::getText($pConn, 293)/*Nie in voorraad - sal versending vertraag*/ . "</div>";
                                                } else if ($vResults[15][$x] == 1) {//out_print = Yes
                                                    $vString .= "<div class=\"text-small-normal red\">" . MysqlQuery::getText($pConn, 28)/*Uit druk uit. Geen bstellings kan aanvaar word nie.*/ . "</div>";
                                                } else {
                                                    $vString .= "<div class=\"text-small-normal green\">" . MysqlQuery::getText($pConn, 431)/*In voorraad - versending binne 48 uur*/ . "</div>";
                                                }
                                            } else {//Not published yet
                                                $vString .= "<a class=\"btn btn-primary my-cart-btn-s\" role=\"button\" data-id=\"" . $vResults[0][$x] . "\" data-image=\"images/books/" . $vResults[6][$x] . "\" title=\'" . MysqlQuery::getText($pConn, 24)/*Laai in mandjie*/ . "\">" . MysqlQuery::getText($pConn, 24)/*Laai in mandjie*/ . "<i class=\"fa fa-shopping-basket top-margin\"></i></a>";
                                                $vString .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a id=\"add-to-wishlist" . $vResults[0][$x] . "\" class=\"btn btn-primary\" role=\"button\" data-book=\"" . $vResults[0][$x] . "\" title=\'" . MysqlQuery::getText($pConn, 312)/*Laai in Wenslys*/ . "\">" . MysqlQuery::getText($pConn, 312)/*Laai in Wenslys*/ . "</a>";
                                                $vString .= "<div class=\"text-small-normal red\">" . MysqlQuery::getText($pConn, 412)/*Let asseblief op die publikasie datum - versending sodra boek gepubliseer is*/ . "</div>";
                                                //$vString .= "<a id=\"add-to-wishlist".$vResults[0][$x]."\" class=\"btn btn-primary\" role=\"button\" data-book=\"".$vResults[0][$x]."\">".MysqlQuery::getText($pConn, 312)/*Laai in Wenslys*/."</a>";
                                            }
                                        }
                                        else if($vResults[41][$x] == 3){
                                            $vString .= "<div class=\"text-small-normal red\">" . MysqlQuery::getText($pConn, 389)/*Nie in voorraad*/ . "</div>";;
                                        }
				                    }
				                    //else if(strtotime($_SESSION['now_date']) < strtotime($vResults[25][$x])){//Not logged in
				                    else {//Not logged in
				                    	$vString .= "<a class=\"btn btn-primary\" href=\"#login\" role=\"button\" data-toggle=\"modal\" title=\"".MysqlQuery::getText($pConn, 266)/*Teken aan om te koop*/."\">".MysqlQuery::getText($pConn, 266)/*Teken aan om te koop*/."<i class=\"fa fa-shopping-basket top-margin\"></i></a>";
					                    //E-book start
										if(isset($vResults[42][$x]) && !empty($vResults[42][$x])){
											$vString .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class=\"btn btn-primary my-cart-btn-s\" href=\"".$vResults[43][$x]."?acc=24611a00cd5703876097b06abc12643b\" target=\"_blank\" data-placement=\"top\" data-toggle=\"tooltip\" data-html=\"true\" title=\"".MysqlQuery::getText($pConn, 480)/*Beskikbaar as e-Boek<br>e-Boeke word direk by LAPA*/."\">".MysqlQuery::getText($pConn, 481)/*Bestel e-Boek*/."</a>";
										}
				                    }
			                    $vString .= "</div>";
							$vString .= "</div>";//col
							$vString .= "</div>";//form-group
						$vString .="</div>";//row

						$vString .="<div class=\"row\">";
							$vString .= "<div class=\"col-xs-2 col-md-2\"></div>";
							$vString .= "<div class=\"col-xs-10 col-md-10\">";
								$vString .="<div id=\"wishlist_double".$vResults[0][$x]."\" class=\"error\" style=\"display:none;\">".MysqlQuery::getText($pConn, 313)/*Die boek is reeds in jou Wenslys gelaai*/."</div>";
								$vString .="<div id=\"wishlist_success".$vResults[0][$x]."\" class=\"success\" style=\"display:none;\">".MysqlQuery::getText($pConn, 314)/*Die boek is in jou Wenslys gelaai*/."</div>";
							$vString .="</div>";
						$vString .="</div>";//row
						$vString .="<div class=\"row info-detail\"><div class=\"col-xs-12\"></div></div>";
					}
				$vString .= "</div>";//Body

				if($per_page < $vWindowValues[5]){
					$vString .= "<div class=\"form-footer\">";
						$vString .="<div class=\"row\">";
		                    $vString .="<div class=\"col-xs-12\">";
		                    	$vString .= General::echoWalkingWindowPages($vWindowValues[5], $per_page, $vPageNo, $vWindowValues[2], $vUrl);
							$vString .="</div>";//col
						$vString .="</div>";//row
					$vString .="</div>";//footer
				}

			$vString .= "</div>";//center
		$vString .= "</div>";//form-border
		$vString .= "</form>";
	}
	else {
		$vString .= "<form class=\"form-horizontal\" name=\"booksForm\" id=\"booksForm\">";
		$vString .= "<input type=\"hidden\" id=\"current-url\" name=\"current-url\" value=\"".$vCurrentUrl."\">";
		$vString .= "<div id=\"form-border\">";
			$vString .= "<div id=\"center\">";

				$vString .= "<div class=\"form-header\">";
					$vString .="<div class=\"row\">";
						$vString .= "<div class=\"col-xs-12 col-md-12\">";
							$vString .= "<h1 class=\"red\">".$vHeading."</h1>";
						$vString .= "</div>";
					$vString .= "</div>";
				$vString .= "</div>";//Header

				$vString .= "<div class=\"form-body\">";
						$vString .="<div class=\"row\">";
						$vString .="<div class=\"form-group\">";
							$vString .= "<div class=\"col-xs-12 col-md-12 row-grid\">";
								$vString .= MysqlQuery::getText($pConn, 21);/*Jammer, geen resultate is gevind nie!*/
							$vString .= "</div>";//col
							$vString .= "</div>";//form-group
						$vString .="</div>";//row
				$vString .= "</div>";//Body
			$vString .= "</div>";//center
		$vString .= "</div>";//form-border
		$vString .= "</form>";
	}