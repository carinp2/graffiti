<?php
/**
 * @author Carin Pretorius - CEIT Development
 * Created on 2016-11-02
 */

class Pages {

	public static function returnErrorResult($pConn, $pId){
		$vString = "<form class=\"form-horizontal\">";
		$vString .= "<div id=\"form-border\">";
			$vString .= "<div id=\"center\">";
				$vString .= "<div class=\"form-header\">";
					$vString .="<div class=\"row\">";
						$vString .= "<div class=\"col-xs-12\">";
							$vString .= "<h1 class=\"red\">".MysqlQuery::getText($pConn, 172)/*Fout*/."</h1>";
							$vString .= "<p class=\"red\">".MysqlQuery::getText($pConn, $pId)."</p>";
							$vString .= "<p><br><a href=\"\" class=\"email\" title=\"Graffiti\">orders at graffitibooks.co.za</a></p>";
						$vString .= "</div>";
					$vString .= "</div>";
				$vString .= "</div>";//Header
				$vString .= "</div>";//center
			$vString .= "</div>";//form-border
		$vString .= "</form>";
		return General::prepareStringForDisplay($vString);
	}

	public static function returnRegisterForm($pConn, $pId, $pTemp){
		if($pId > 0 && $pId == $_SESSION['SessionGrafUserId']){
			$vTab = MysqlQuery::getText($pConn, 273)/*Jou profiel*/;
		}
		else if($pId <= 0){
			$vTab = MysqlQuery::getText($pConn, 96)/*Registreer*/;
		}
        $vString = "<form class=\"form-horizontal\" name=\"registerForm\" id=\"registerForm\" role=\"form\" method=\"post\" action=\"process.php\">";
			$vString .= "<div id=\"form-border\">";
				$vString .= "<div id=\"center\" class=\"tab-content\">";
					if($pId > 0){
						  $vString .= "<ul class=\"nav nav-tabs\">";
						    $vString .= "<li";
						    	($pTemp == 0 ?  $vString .= " class=\"active\"" : $vString .= "");
						    $vString .="><a class=\"text-small red-menu\" data-toggle=\"tab\" href=\"#user-profile\" title=\"".$vTab."\">".$vTab."</a></li>";
						    $vString .= "<li";
						    	($pTemp == 1 ?  $vString .= " class=\"active\"" : $vString .= "");
						    $vString .="><a class=\"text-small red-menu\" data-toggle=\"tab\" href=\"#user-order-history\" title=\"".MysqlQuery::getText($pConn, 316)/*Bestel geskiedenis*/."\">".MysqlQuery::getText($pConn, 316)/*Bestel geskiedenis*/."</a></li>";
						    $vString .= "<li";
						    	($pTemp == 2 ?  $vString .= " class=\"active\"" : $vString .= "");
						    $vString .="><a class=\"text-small red-menu\" data-toggle=\"tab\" href=\"#user-wishlist\" title=\"".MysqlQuery::getText($pConn, 315)/*Wenslys*/."\">".MysqlQuery::getText($pConn, 315)/*Wenslys*/."</a></li>";
						 $vString .= "</ul>";
					}
					$vUserProfile = Client::getProfile($pConn, $pId, $pTemp);
					$vString .=  $vUserProfile;
					if($pId > 0){
						$vWishlist = Client::getWishlist($pConn, $pId, $pTemp);
						$vString .=  $vWishlist;
						$vOrderHistory = Client::getOrderHistory($pConn, $pId, $pTemp);
						$vString .=  $vOrderHistory;
					}
					$vString .= "</div>";//center
				$vString .= "</div>";//form-border
			$vString .= "</form>";

		return $vString;
	}

	public static function returnCarousel($pConn){
		$vWhere = "WHERE advert = 0 or (advert = 1 AND start_date <= '".$_SESSION['date_now']."' AND end_date > '".$_SESSION['date_now']."')";
 		$vCarouselImages = MysqlQuery::getCarouselImages($pConn, $vWhere);//$vId, $vUrl, $vAlt, $vBlobPath
 		if(count($vCarouselImages[0]) > 0){
			$vString = "<div id=\"carouselBlk\">";
					$vString .= "<div id=\"myCarousel\" class=\"carousel slide\">";
						$vString .= "<div class=\"carousel-inner\">";
							for($x = 0; $x < count($vCarouselImages[0]); $x++){
								 (stripos($vCarouselImages[1][$x],"http") !== false  ? $vTarget = "target=\"_blank\"" : $vTarget = "");
								 ($x == 0 ? $vClass = "active" : $vClass = "");
								$vString .="<div class=\"item ".$vClass."\"";
								$vString .= ">";
									  $vString .="<div class=\"container\">";
										  if(!empty($vCarouselImages[1][$x])){
										  	$vString .="<a href=\"".$vCarouselImages[1][$x]."\" ".$vTarget." title=\"".$vCarouselImages[2][$x]."\">";
										  }
										  $vString .= "<img style=\"width:100%\" src=\"images/uploads/".$vCarouselImages[3][$x]."\" alt=\"".$vCarouselImages[2][$x]."\" title=\"".$vCarouselImages[2][$x]."\"/>";
										  if(!empty($vCarouselImages[1][$x])){
										  	$vString .="</a>";
										  }
									  $vString .="</div>";
								$vString .= "</div>";
							}
						$vString .= "</div>";// carousel-inner
						$vString .= "<a class=\"left carousel-control\" href=\"#myCarousel\" data-slide=\"prev\" title=\"<\"><i class=\"fa fa-chevron-left\" aria-hidden=\"true\"></i></a>";
						$vString .= "<a class=\"right carousel-control\" href=\"#myCarousel\" data-slide=\"next\" title=\">\"><i class=\"fa fa-chevron-right\" aria-hidden=\"true\"></i></a>";
					  $vString .= "</div>";
				$vString .= "</div>";
			}
			else {
				$vString = "<div id=\"carousel-spacer\"></div>";
			}
			return General::prepareStringForDisplay($vString);
	}

	public static function returnBooks($pConn, $pTypeId, $pLanguage){
		//$vAutoDiscount = MysqlQuery::getAutoDiscount($pConn);
		$vString = "";
		if($pTypeId == 208 || $pTypeId == 206 || $pTypeId == 446 || $pTypeId == 447){
			$vHeading = MysqlQuery::getCmsText($pConn, $pTypeId, "af")." / ".MysqlQuery::getCmsText($pConn, $pTypeId, "en");
		}
		else {
			$vHeading = MysqlQuery::getCmsText($pConn, $pTypeId, $pLanguage);
		}

		$vUrl = str_replace("/", "-", str_replace(" ", "", ucwords($vHeading)));
		$vBindParams = array();
		$vBindLetters = "";
		$vLimit = "LIMIT 6";
		$per_page = 6;
		$vType = "general";
		if($pTypeId == 209 || $pTypeId == 447){
			$pSort = "top_seller_rank ASC, date_publish DESC";
		}
		else if($pTypeId == 204 || $pTypeId == 446){
			$pSort = "new_rank ASC, date_publish DESC";
		}
		else if($pTypeId == 206){
		    //Verander sort order 26/01/2021 - Leonie vra dit so
			$pSort = "soon_rank ASC, date_publish ASC";
		}
		else if($pTypeId == 208){
			$pSort = "special_rank ASC, date_publish ASC";
		}
		else{
			$pSort = "date_publish DESC";
		}

		include "include/BookQueries.php";

		$vString .= "<div class=\"thumb-container\">";
			if(isset($vResults[0]) && count($vResults[0]) > 0){
				$vString .= "<div class=\"thumb-header\">";
					$vString .= "<div class=\"row\">";
						$vString .= "<div class=\"col-xs-12\">";
							$vString .= "<h1 class=\"red\">".$vHeading."</h1>";
						$vString .= "</div>";
					$vString .= "</div>";
				$vString .= "</div>";//header
				$vString .= "<div class=\"thumb-body\">";
					$vString .= "<div class=\"row\" id=\"home-book-row-".$pTypeId."\">";
						$vString .= "<div class=\"col-xs-12\">";
							$vString .= "<ul class=\"thumbnails\">";
								for($x = 0; $x < count($vResults[0]); $x++){
									$vBookUrl = $vResults[21][$x]." ".$vResults[4][$x];
									$vViewUrl = $_SESSION['SessionGrafLanguage']."/".$vResults[0][$x]."/".MysqlQuery::getText($pConn, 157)/*Boeke*/."/".General::prepareStringForUrl($vBookUrl);
										$vString .= "<li itemscope itemtype=\"http://schema.org/Product\" itemref=\"header\" class=\"col-lg-2 col-md-3 col-sm-6 col-xs-12\">";
											$vString .= "<div class=\"thumbnail book-info\">";
													if(!empty($vResults[6][$x])){
														if(($pTypeId == 204 && $vResults[13][$x] == 1) && $vResults[15][$x] == 0){
															$vClass = "newSel";
														}
														else if(($pTypeId == 446 && $vResults[13][$x] == 1) && $vResults[15][$x] == 0){
															$vClass = "newSelC";
														}
														else if(($pTypeId == 206 && $vResults[13][$x] == 1) && $vResults[15][$x] == 0){
															 $vClass = "soonSel";
														}
														else if(($pTypeId == 208 && $vResults[13][$x] == 1) && $vResults[15][$x] == 0){
															 $vClass = "specialSel";
														}
														else if(($pTypeId == 209 && $vResults[13][$x] == 1) && $vResults[15][$x] == 0){
															 $vClass = "topSel";
														}
														else if(($pTypeId == 447 && $vResults[13][$x] == 1) && $vResults[15][$x] == 0){
															 $vClass = "topSelC";
														}
														else if($vResults[15][$x] == 1){
															$vClass = "outSel";
														}
														else {
															$vClass = "Im";
														}
														$vString .= "<div class=\"thumb-book-image\" id=\"".$vClass."_".$vResults[0][$x]."\" data-id=\"".$vResults[0][$x]."\">";
																$vString .= "<a href=\"".$vViewUrl."\" title=\"".MysqlQuery::getText($pConn, 40)/*Meer*/."\">";
																	$vString .= "<img itemprop=\"image\"  id=\"".$vResults[0][$x]."\" src=\"images/books/".$vResults[6][$x]."\" alt=\"".$vResults[4][$x]."\" title=\"".$vResults[4][$x]." - ".MysqlQuery::getText($pConn, 40)/*Meer*/."\" class=\"thumb\"/>";
																$vString .= "</a>";
																if(($pTypeId == 204 && $vResults[13][$x] == 1) && $vResults[15][$x] == 0){
																	$vString .= "<h3 id=\"newSelCircle_".$vResults[0][$x]."\"  title=\"".MysqlQuery::getText($pConn, 33)/*Topverkoper*/."\">".$vResults[14][$x]."</h3>";
																}
																else if(($pTypeId == 446 && $vResults[13][$x] == 1) && $vResults[15][$x] == 0){
																	$vString .= "<h3 id=\"newSelCCircle_".$vResults[0][$x]."\"  title=\"".MysqlQuery::getText($pConn, 33)/*Topverkoper*/."\">".$vResults[14][$x]."</h3>";
																}
																else if(($pTypeId == 206 && $vResults[13][$x] == 1) && $vResults[15][$x] == 0){
																	$vString .= "<h3 id=\"soonSelCircle_".$vResults[0][$x]."\" title=\"".MysqlQuery::getText($pConn, 33)/*Topverkoper*/."\">".$vResults[14][$x]."</h3>";
																}
																else if(($pTypeId == 208 && $vResults[13][$x] == 1) && $vResults[15][$x] == 0){
																	$vString .= "<h3 id=\"specialSelCircle_".$vResults[0][$x]."\"  title=\"".MysqlQuery::getText($pConn, 33)/*Topverkoper*/."\">".$vResults[14][$x]."</h3>";
																}
																else if(($pTypeId == 209 && $vResults[13][$x] == 1) && $vResults[15][$x] == 0){
																	$vString .= "<h3 id=\"topSelCircle_".$vResults[0][$x]."\"  title=\"".MysqlQuery::getText($pConn, 33)/*Topverkoper*/."\">".$vResults[14][$x]."</h3>";
																}
																else if(($pTypeId == 447 && $vResults[13][$x] == 1) && $vResults[15][$x] == 0){
																	$vString .= "<h3 id=\"topSelCCircle_".$vResults[0][$x]."\"  title=\"".MysqlQuery::getText($pConn, 33)/*Topverkoper*/."\">".$vResults[14][$x]."</h3>";
																}
																else if($vResults[15][$x] == 1){
																	$vString .= "<h2 id=\"bookOutBanner_".$vResults[0][$x]."\">".MysqlQuery::getText($pConn, 354)/*Uit druk*/."</h2>";
																}

															$vString .= "</div>";
													}
													else {
														$vString .= "<div class=\"thumb-book-image\"><a href=\"".$vViewUrl."\" title=\"".MysqlQuery::getText($pConn, 40)/*Meer*/."\"><img id=\"".$vResults[0][$x]."\" src=\"images/no_image.png\" alt=\"".$vResults[4][$x]."\" title=\"".$vResults[4][$x]." - ".MysqlQuery::getText($pConn, 40)/*Meer*/."\" class=\"thumb\"/></a></div>";
													}

								                	$vString .= "<div class=\"thumb-book-heading\"><h2 class=\"no-display\">".$vResults[4][$x]."</h2><h5><a class=\"heading\" href=\"".$vViewUrl."\" title=\"".$vResults[4][$x]."\"><span itemprop=\"name\">".$vResults[4][$x]."</span></a></h5></div>";
								                    $vString .= "<div class=\"thumb-book-author text-xsmall\">".$vResults[21][$x]."</div>";


								                    //Price start
													$vNewTopDiscountPrice =  round($vResults[8][$x]-($vResults[8][$x]*$vResults[26][$x]));
													(!empty($vResults[7][$x]) && $vResults[7][$x] > 0  ? $vSpecialDiscountPrice = $vResults[7][$x] : $vSpecialDiscountPrice = $vResults[8][$x]);
													$vClientDiscountPrice = round($vResults[8][$x]-($vResults[8][$x]*$_SESSION['SessionGrafSpecialDiscount']));
													$vSoonDiscountPrice = round($vResults[8][$x]-($vResults[8][$x]*$vResults[26][$x]));
													$vNormalPrice = $vResults[8][$x];
													$vPriceDisplayType = "home";
													include "include/BookPriceDisplay.php";

								                    $vString .= "<div class=\"thumb-book-shop\">";
//                                                    Login changes - Remove ln226 * ln233 - 236 - Login not required to add to cart - 13-10-2022
//									                    if(isset($_SESSION['SessionGrafUserId']) && $_SESSION['SessionGrafUserId'] != ''){
//									                    	if(strtotime($_SESSION['now_date']) >= strtotime($vResults[25][$x])){//Not published yet
									                    		$vString .= "<a class=\"btn btn-primary my-cart-btn\" role=\"button\" data-id=\"".$vResults[0][$x]."\" data-image=\"images/books/".$vResults[6][$x]."\" title=\"".MysqlQuery::getText($pConn, 24)/*Laai in mandjie*/."\">".MysqlQuery::getText($pConn, 24)/*Laai in mandjie*/."<i class=\"fa fa-shopping-basket top-margin\"></i></a>";
// 									                    	}
// 									                    	else {
// 									                    		$vString .= "<a id=\"add-to-wishlist".$vResults[0][$x]."\" class=\"btn btn-primary\" role=\"button\" data-book=\"".$vResults[0][$x]."\">".MysqlQuery::getText($pConn, 312)/*Laai in Wenslys*/."</a>";
// 									                    	}
//									                    }
//									                    else {
//									                    	$vString .= "<a class=\"btn btn-primary\" href=\"#login\" role=\"button\" data-toggle=\"modal\" title=\"".MysqlQuery::getText($pConn, 266)/*Teken aan om te koop*/."\">".MysqlQuery::getText($pConn, 266)/*Teken aan om te koop*/."<i class=\"fa fa-shopping-basket top-margin\"></i></a>";
//									                    }

														$vString .="<div id=\"wishlist_double".$vResults[0][$x]."\" class=\"home-error\" style=\"display:none;\">".MysqlQuery::getText($pConn, 313)/*Die boek is reeds in jou Wenslys gelaai*/."</div>";
														$vString .="<div id=\"wishlist_success".$vResults[0][$x]."\" class=\"home-success\" style=\"display:none;\">".MysqlQuery::getText($pConn, 314)/*Die boek is in jou Wenslys gelaai*/."</div>";

								                    $vString .= "</div>";
											$vString .= "</div>";//book-info
										$vString .= "</li>";
								}
							$vString .= "</ul>";
						$vString .= "</div>";//col-xs-12
					$vString .= "</div>";//row
				$vString .= "</div>";//body
				$vString .= "<div class=\"thum-footer\">";
					$vString .= "<div class=\"row\">";
						$vString .= "<div class=\"col-xs-12\">";
                            $pSort = ($pTypeId == 208 ? "" : $pSort);
							$vString .= "<h5 class=\"pull-right green\"><a href=\"".$_SESSION['SessionGrafLanguage']."/".$pTypeId."/".$vUrl."/".$pLanguage."/".$pSort."\" title=\"".MysqlQuery::getText($pConn, 40)/*Meer*/."\">".MysqlQuery::getText($pConn, 40)/*Meer*/." ".$vHeading." <i class=\"fa fa-arrow-right\" aria-hidden=\"true\"></i></a></h5>";
						$vString .= "</div>";
					$vString .= "</div>";
				$vString .= "</div>";//footer
			}
		$vString .= "</div>";//thumb-container
		return General::prepareStringForDisplay($vString);
	}

	public static function returnCheckoutForm($pConn, $pClientId){
		if($pClientId == $_SESSION['SessionGrafUserId']){
			$vOrder = " ORDER BY b.title ";
			$vBindParams = array();
			$vBindLetters .= "i";
			$vBindParams[] = & $pClientId;
			$vLimit = "";
			$vWhere = " WHERE client_id = ? and order_date is NULL and order_reference is NULL and order_id is NULL and temp_salt is not NULL";
			$vResults = MysqlQuery::getCart($pConn, $vWhere, $vOrder, $vBindLetters, $vBindParams, $vLimit);

			$vUrl = General::curPageURL();

			$vString .= "<form class=\"form-horizontal\" name=\"orderForm\" id=\"orderForm\" role=\"form\" method=\"post\" action=\"".$_SESSION['SessionGrafLanguage']."/".$pClientId."/".MysqlQuery::getText($pConn, 283)/*BestelNouKoerier*/."\">";
			$vString .= "<div id=\"form-border\">";
			$vString .= "<div id=\"center\">";
					$vString .= "<div class=\"form-header\">";
							$vString .= "<h1 class=\"red\">".MysqlQuery::getText($pConn, 17)/*Bestel nou*/."</h1>";
						$vString .="<div class=\"row\">";
							$vString .= "<div class=\"col-xs-12\">";
								$vString .= "<ul id=\"progress\">";
		    						$vString .= "<li class=\"steps active\">".MysqlQuery::getText($pConn, 280)/*Stap*/." 1.&nbsp;&nbsp;".MysqlQuery::getText($pConn, 16)/*Jou mandjie*/."</li>";
		    						$vString .= "<li class=\"steps\">".MysqlQuery::getText($pConn, 280)/*Stap*/." 2.&nbsp;&nbsp;".MysqlQuery::getText($pConn, 278)/*Aflewering*/."</li>";
		    						$vString .= "<li class=\"steps\">".MysqlQuery::getText($pConn, 280)/*Stap*/." 3.&nbsp;&nbsp;".MysqlQuery::getText($pConn, 279)/*Betaling*/."</li>";
								$vString .= "</ul>	";
							$vString .= "</div>";
						$vString .= "</div>";
					$vString .= "</div>";//header
					$vString .= "<div class=\"form-body\">";

							$vString .="<div class=\"row\">";
								$vString .= "<div class=\"col-xs-12\">";
									$vString .= "<h4 class=\"green\">".MysqlQuery::getText($pConn, 280)/*Stap*/." 1.&nbsp;&nbsp;".MysqlQuery::getText($pConn, 16)/*Jou mandjie*/."</h4>";
									//$vString .= " <h5 class=\"red\">".MysqlQuery::getText($pConn, 111)/*Die posgeld is gratis wanneer jou bestelling R400 oorskry en binne Suid-Afrika versend word.*/."</h5>";
									$vString .= "<hr class=\"light-gray\">";
								$vString .="</div>";
							$vString .="</div>";
					if(count($vResults[0]) > 0){
				//			$vBooksString = MysqlQuery::getText($pConn, 157)/*Boeke*/.":&nbsp;&nbsp;";
							for($x = 0; $x < count($vResults[0]); $x++){
								$vTotalBookPrice = $vResults[3][$x] * $vResults[10][$x];
								($vResults[3][$x] <= 2 ? $vNoDisplay = "no-display" : $vNoDisplay = "");
								//Books
								$vString .= "<div class=\"row row-grid line\">";
									$vString .= "<div class=\"form-group\">";
										$vString .= "<div class=\"col-xs-2 col-md-2 row-grid col-center\">";
										if(!empty($vResults[11][$x])){
											$vString .= "<img src=\"images/books/".$vResults[11][$x]."\" class=\"img-responsive cart-thumb thumb\" alt=\"".$vResults[9][$x]."\">";
										}
										else {
											$vString .= "<img src=\"images/no_image.png\" class=\"img-responsive cart-thumb-no-image thumb\" alt=\"Graffiti\">";
										}
										$vString .= "</div>";
										$vString .= "<div class=\"col-xs-4 col-md-6 row-grid\">".$vResults[9][$x];

										$vString .= "<div id=\"big-order-message\" class=\"text-xsmall red ".$vNoDisplay."\">".MysqlQuery::getText($pConn, 445)/*Let asseblief daarop dat Graffiti soms beperkte voorraad van.....*/."</div></div>";
										$vString .= "<div class=\"col-xs-2 col-md-1 row-grid col-right\"><input type=\"number\" name=\"number\" id=\"cart-number-".$vResults[0][$x]."\" class=\"input-number\" data-src=\"".$vResults[0][$x]."\" data-book=\"".$vResults[1][$x]."\" value=\"".$vResults[3][$x]."\" required size=\"50\"></div>";
										$vString .= "<div class=\"col-xs-2 col-md-2 row-grid col-right\" id=\"cart-total-price-".$vResults[0][$x]."\" data-src=\"".$vResults[10][$x]."\">R ".$vTotalBookPrice."</div>";
										$vString .= "<div class=\"col-xs-2 col-md-1 row-grid\">";
												//$vString .= "<span id=\"remove-book-".$vResults[0][$x]."\" class=\"btn btn-xs btn-danger\" data-src=\"".$vResults[0][$x]."\">X</span>";
												$vString .= "<a id=\"remove-book-".$vResults[0][$x]."\" class=\"btn btn-primary btn-xsmall\" role=\"button\" data-src=\"".$vResults[0][$x]."\" title=\"".MysqlQuery::getText($pConn, 287)/*Verwyder boek*/."\">";
													$vString .= "<i class=\"fa fa-times\" aria-hidden=\"true\"></i>";
												$vString .= "</a>&nbsp;";
												$vString .= "<a id=\"move-to-wishlist-".$vResults[0][$x]."\" class=\"btn btn-primary btn-xsmall\" role=\"button\" data-src=\"".$vResults[0][$x]."\" data-book=\"".$vResults[1][$x]."\" title=\"".MysqlQuery::getText($pConn, 286)/*Skuif na Wenslys*/."\">";
													$vString .= "<i class=\"fa fa-sign-out\" aria-hidden=\"true\"></i>";
												$vString .= "</a>";
										$vString .= "</div>";
									$vString .="</div>";
								$vString .="</div>";
							}

							//Total book cost
							$vString .= "<div class=\"row row-grid total-line\">";
								$vString .= "<div class=\"form-group\">";
									$vString .= "<div class=\"col-xs-2 col-md-2 row-grid\"></div>";
									$vString .= "<div class=\"col-xs-6 col-md-7 row-grid green\">".MysqlQuery::getText($pConn, 107)/*Totaal*/."</div>";
									$vString .= "<div class=\"col-xs-3 col-md-2 row-grid col-right green\" id=\"cart-total-all-books-price\"></div>";
									$vString .= "<div class=\"col-xs-1 col-md-1 row-grid\"></div>";
								$vString .="</div>";
							$vString .="</div>";

							$vString .= "<div class=\"row row-grid\">";
								$vString .= "<div class=\"form-group\">";
									$vString .= "<div class=\"col-xs-2 col-md-1 col-right\"><input type=\"checkbox\" id=\"tc\" data-src=\"tc\" name=\"tc\" value=\"1\"></div>";
									$vString .= "<div class=\"col-xs-9 col-md-10 row-grid red\">";
										$vString .= MysqlQuery::getText($pConn, 120)/*Ek bevestig dat ek die Bepalings en voorwaardes gelees het en dit aanvaar.*/;
										$vString .= "<a href=\"documents/".$_SESSION['SessionGrafLanguage']."TC2018.pdf\" target=\"_blank\" class=\"rank\" style=\"font-weight:normal;\" title=\"".MysqlQuery::getText($pConn, 119)/*Bepalings en voorwaardes*/."\">";
										$vString .= "<i class=\"fa fa-file-pdf-o red fa-lg space-left\" aria-hidden=\"true\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"".MysqlQuery::getText($pConn, 119)/*Bepalings en voorwaardes*/."\"></i></a>";
									$vString .= "</div>";
									$vString .= "<div class=\"col-xs-1 col-md-1 row-grid\"></div>";
								$vString .="</div>";
							$vString .="</div>";

// 								$vString .= "<div class=\"form-group\" id=\"bigOrder\">";
// 									$vString .= "<div class=\"col-xs-11 col-md-11 row-grid red\">";
// 										$vString .= MysqlQuery::getText($pConn, 443)/*Kontak asseblief Graffiti vir orders van meer as 2 boeke per title*/;
// 										$vString .= "<br><a href=\"mailto:orders@graffitibooks.co.za?subject=".MysqlQuery::getText($pConn, 444)/*Spesiale bestelling*/."&amp;body=".$vBooksString."\">orders@graffitibooks.co.za</a>";
// 									$vString .= "</div>";
// 									$vString .= "<div class=\"col-xs-1 col-md-1 row-grid\"></div>";
// 								$vString .="</div>";
// 							$vString .="</div>";

							$vString .= "</div>";//Body
							$vString .= "<div class=\"form-footer\">";
								$vString .="<div class=\"row\">";
				                    $vString .="<div class=\"col-xs-12\">";
										//$vString .= "<input type=\"hidden\" name=\"id\" id=\"id\" value=\"".$pClientId."\">";
										//$vString .= "<input type=\"hidden\" name=\"page\" id=\"page\" value=\"".MysqlQuery::getText($pConn, 283)/*BestelNouKoerier*/."\">";
										$vString .= "<button type=\"submit\" id=\"cartSubmitStep1\" class=\"btn btn-primary no-display\">".MysqlQuery::getText($pConn, 122)/*Gaan voort*/."</button>";
									$vString .="</div>";
								$vString .="</div>";
							$vString .="</div>";//footer
					}
					else {
							$vString .="<div class=\"row\">";
								$vString .= "<div class=\"col-xs-12\">";
									$vString .= "<h5 class=\"gray\">".MysqlQuery::getText($pConn, 123)/*Jou mandjie is leeg*/."</h5>";
									$vString .= "<hr class=\"light-gray\">";
								$vString .="</div>";
							$vString .="</div>";
					}
					$vString .= "</div>";//center
				$vString .= "</div>";//form-border
			$vString .= "</form>";

			$vString .="<Script>";
				$vString .= "$(document).ready(function(){";
					$vString .= "var sum = 0;";
					$vString .= "$('[id^=cart-total-price-]').each(function(){";
						$vString .= "var theValue = $(this).text().substring(2);";
					    $vString .= "sum += parseFloat(theValue);";
					    $vString .= "$('#cart-total-all-books-price').html('R '+sum+''); ";
					    $vString .= "$('#total-price').val(sum); ";
					$vString .= "});";
				$vString .= "});";
			$vString .="</Script>";
		}
		else {
			$vString .= "An error occurred with the order";//TODO ERROR
		}
		return General::prepareStringForDisplay($vString);
	}

	public static function returnCheckoutCourierForm($pConn, $pClientId){
		$vPargo = Modal::openPargo($pConn);
		$vString = $vPargo;

		if($pClientId == $_SESSION['SessionGrafUserId']){
			$vOrder = " ORDER BY b.title ";
			$vBindParams = array();
			$vBindLetters = "i";
			$vBindParams[] = & $pClientId;
			$vLimit = "";
			$vWhere = " WHERE client_id = ? and order_date is NULL and order_reference is NULL and order_id is NULL and temp_salt is not NULL";
			$vResults = MysqlQuery::getCart($pConn, $vWhere, $vOrder, $vBindLetters, $vBindParams, $vLimit);

			$vCOrder = "";
			$vCBindParams = array();
			$vCBindLetters = "i";
			$vCBindParams[] = & $pClientId;
			$vCLimit = "";
			$vCWhere = " WHERE id = ?";
			$vClientResults = MysqlQuery::getClients($pConn, $vCWhere, $vCOrder, $vCBindLetters, $vCBindParams, $vCLimit);

			//$vCourierResults = MysqlQuery::getLookup($pConn, "courier");//id, text, sort
			$vCourierResults = MysqlQuery::getCourierSelection($pConn, 9999);//$vId, $vCourier_type

			$vString .= "<form class=\"form-horizontal\" name=\"orderCourierForm\" id=\"orderCourierForm\" role=\"form\" method=\"post\" action=\"".$_SESSION['SessionGrafLanguage']."/".$pClientId."/".MysqlQuery::getText($pConn, 279)/*Betaling*/."\">";
				$vString .= "<div id=\"form-border\">";
					$vString .= "<div id=\"center\">";

						$vString .= "<div class=\"form-header\">";
								$vString .= "<h1 class=\"red\">".MysqlQuery::getText($pConn, 17)/*Bestel nou*/."</h1>";
							$vString .="<div class=\"row\">";
								$vString .= "<div class=\"col-xs-12\">";
									$vString .= "<ul id=\"progress\">";
			    						$vString .= "<li class=\"steps\">".MysqlQuery::getText($pConn, 280)/*Stap*/." 1.&nbsp;&nbsp;".MysqlQuery::getText($pConn, 16)/*Jou mandjie*/."</li>";
			    						$vString .= "<li class=\"steps active\">".MysqlQuery::getText($pConn, 280)/*Stap*/." 2.&nbsp;&nbsp;".MysqlQuery::getText($pConn, 278)/*Aflewering*/."</li>";
			    						$vString .= "<li class=\"steps\">".MysqlQuery::getText($pConn, 280)/*Stap*/." 3.&nbsp;&nbsp;".MysqlQuery::getText($pConn, 279)/*Betaling*/."</li>";
									$vString .= "</ul>	";
								$vString .= "</div>";
							$vString .= "</div>";
						$vString .= "</div>";//header

						$vString .= "<div class=\"form-body\">";

								$vString .="<div class=\"row\">";
									$vString .= "<div class=\"col-xs-12\">";
										$vString .= "<h4 class=\"green\">".MysqlQuery::getText($pConn, 280)/*Stap*/." 2.&nbsp;&nbsp;".MysqlQuery::getText($pConn, 278)/*Aflewering*/."</h4>";
										$vString .= "<hr class=\"light-gray\">";
									$vString .="</div>";
								$vString .="</div>";//row

									$vString .="<div class=\"row\">";
									$vString .= "<div class=\"col-xs-12\">";
										$vString .= "<h5 class=\"gray\"><i class=\"fa fa-angle-double-right fa-lg\" aria-hidden=\"true\"></i>&nbsp;&nbsp;".MysqlQuery::getText($pConn, 281)/*Jou boeke*/."</h5>";
									$vString .="</div>";
								$vString .="</div>";//row
						if(count($vResults[0]) > 0){
								for($x = 0; $x < count($vResults[0]); $x++){
									$vTotalBookPrice = $vResults[3][$x] * $vResults[10][$x];
										($vResults[12][$x] == 0 && $vResults[13][$x] <= $_SESSION['now_date'] ? $vInStockMesssage = "<span class=\"text-small-normal red\">&nbsp;&nbsp;(".MysqlQuery::getText($pConn, 293)/*Nie in voorraad - sal versending vertraag*/.")</span>" : $vInStockMesssage = "");
										($vResults[13][$x] > $_SESSION['now_date'] ? $vPublicationMesssage = "<span class=\"text-small-normal red\">&nbsp;&nbsp;(".MysqlQuery::getText($pConn, 412)/*Let asseblief op die publikasie datum. Versending sodra boek gepubliseer is.*/." - ".$vResults[13][$x].")</span>" : $vPublicationMesssage = "");
									//Books
									$vString .= "<div class=\"row row-grid\">";
											$vString .= "<div class=\"col-xs-6 col-md-6 row-grid\">".$vResults[9][$x].$vInStockMesssage."".$vPublicationMesssage."</div>";
											$vString .= "<div class=\"col-xs-3 col-md-3 row-grid col-right\">".$vResults[3][$x]."</div>";
											$vString .= "<div class=\"col-xs-3 col-md-2 row-grid col-right\" id=\"cart-total-price-".$vResults[0][$x]."\">R ".$vTotalBookPrice."</div>";
											$vString .= "<div class=\"col-md-1 row-grid col-right\"></div>";
									$vString .="</div>";//row
								}
								//Total book cost
								$vString .= "<div class=\"row row-grid space-bottom\">";
										$vString .= "<div class=\"col-xs-6 col-md-6 row-grid gray\">".MysqlQuery::getText($pConn, 107)/*Totaal*/."</div>";
										$vString .= "<div class=\"col-xs-6 col-md-5 row-grid col-right gray\" id=\"cart-total-all-books-price\"></div>";
										$vString .= "<div class=\"col-md-1 row-grid col-right\"></div>";
								$vString .="</div>";//row

// 								//Country select
// 								$vString .="<div class=\"row\">";
// 									//$vString .="<hr class=\"light-gray\">";
// 									$vString .= "<div class=\"col-xs-12\">";
// 										$vString .= "<h5 class=\"red\"><i class=\"fa fa-angle-double-right fa-lg\" aria-hidden=\"true\"></i>&nbsp;&nbsp;".MysqlQuery::getText($pConn, 195)/*Kies die land waarheen die bestelling versend moet word*/."";
// 										$vString .= "</h5>";
// 									$vString .= "</div>";
// 								$vString .="</div>";//row

// 								$vString .= "<div class=\"row row-grid\">";
// 										$vString .= "<div class=\"col-xs-12 col-md-12 row-grid green checkbox-inline\">";
// 											$vString .= "<select name=\"pre-country-select\" id=\"pre-country-select\">";
// 												$vString .= "<option value=\"0\">".MysqlQuery::getText($pConn, 110)/*Kies jou land*/."</option>";
// 						            			if(count($vCountryResults[0]) > 0){
// 						            				for($cc = 0; $cc < count($vCountryResults[0]); $cc++){
// 						            					$vString .= "<option value=\"".$vCountryResults[2][$cc]."\" data=\"".$vCountryResults[0][$cc]."\"";
// 						            						if($vResults[23][0] == $vCountryResults[0][$cc]){
// 						            							$vString .= " selected";
// 						            						}
// 						            					$vString .= ">".$vCountryResults[1][$cc]."</option>";
// 						            				}
// 						            			}
// 						            		$vString .= "</select>";
// 										$vString .= "</div>";
// 								$vString .="</div><br>";//row

								//Courier option
								$vString .="<div class=\"row\">";
									$vString .="<hr class=\"light-gray\">";
									$vString .= "<div class=\"col-xs-12\">";
										$vString .= "<h5 class=\"red\"><i class=\"fa fa-angle-double-right fa-lg\" aria-hidden=\"true\"></i>&nbsp;&nbsp;".MysqlQuery::getText($pConn, 282)/*Kies 'n versendingsopsie*/."";
											$vString .= "<a href=\"#coureirinfo\" class=\"green\" data-toggle=\"modal\" title=\"".MysqlQuery::getText($pConn, 370)/*Klik vir meer oor die verskillende versendingsopsie*/."><i class=\"fa fa-info-circle fa-lg space-left green\" aria-hidden=\"true\" data-html=\"true\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"".MysqlQuery::getText($pConn, 370)/*Klik vir meer oor die verskillende versendingsopsie*/."\"></i></a>";
										$vString .= "</h5>";
									$vString .= "</div>";
								$vString .="</div>";//row

								$vString .= "<div class=\"row row-grid\">";
										$vString .= "<div class=\"col-xs-12 col-md-12 row-grid green checkbox-inline\">";
											$vString .= "<select name=\"courier-type\" id=\"courier-type\" size='4'>";
												//$vString .= "<option value=\"\">".MysqlQuery::getText($pConn, 291)/*Kies 'n opsie*/."</option>";
						            			if(count($vCourierResults[0]) > 0){
						            				for($c = 0; $c < count($vCourierResults[0]); $c++){
						            					$vString .= "<option value=\"".$vCourierResults[0][$c]."\"";
						            					//Set default courier selection
						            						if($vResults[22][0] == $vCourierResults[0][$c]){
						            							$vString .= " selected";
						            						}
						            						else if($vCourierResults[0][$c] == 7){
                                                                $vString .= " selected";
                                                            }
						            					$vString .= ">".$vCourierResults[1][$c]."</option>";
						            				}
						            			}
						            		$vString .= "</select>";
										$vString .= "</div>";
								$vString .="</div>";//row

//								$vString .= "<div class=\"row row-grid\">";
//                                    $vString .= "<div class=\"col-xs-12 col-md-12 row-grid green checkbox-inline\">";
//                                        if(count($vCourierResults[0]) > 0) {
//                                            for ($c = 0; $c < count($vCourierResults[0]); $c++) {
//                                                $vString .= "<input type='radio' id='courier-type".$vCourierResults[0][$c]."' name='courier-type' value='" . $vCourierResults[0][$c] . "'";
//                                                if ($vResults[22][0] == $vCourierResults[0][$c]) {
//                                                    $vString .= " checked";
//                                                } else if ($vCourierResults[0][$c] == 7) {
//                                                    $vString .= " checked";
//                                                }
//                                                $vString .= ">";
//                                                $vString .= "<label class='space-left' for='" . $vCourierResults[1][$c] . "'>" . $vCourierResults[1][$c] . "</label><br>";
//                                            }
//                                        }
//                                    $vString .= "</div>";
//								$vString .="</div>";//row

								//Country selection
								$vCountryResults = MysqlQuery::getCountryCourierCost($pConn, array_sum($vResults[3]));//$vId, $vCountry, $vCost
								$vString .= "<div class=\"row row-grid space-bottom no-display\" id=\"country-cart-courier-select\">";
										$vString .= "<div class=\"col-xs-12 col-md-12 row-grid green checkbox-inline\">";
											$vString .= "<select name=\"country-select\" id=\"country-select\">";
												$vString .= "<option value=\"0\">".MysqlQuery::getText($pConn, 110)/*Kies jou land*/."</option>";
						            			if(count($vCountryResults[0]) > 0){
						            				for($cc = 0; $cc < count($vCountryResults[0]); $cc++){
						            					$vString .= "<option value=\"".$vCountryResults[2][$cc]."\" data=\"".$vCountryResults[0][$cc]."\"";
						            						if($vResults[23][0] == $vCountryResults[0][$cc]){
						            							$vString .= " selected";
						            						}
						            					$vString .= ">".$vCountryResults[1][$cc]."</option>";
						            				}
						            			}
						            		$vString .= "</select>";
										$vString .= "</div>";
								$vString .="</div>";//row

								//Pargo iframe
								$vString .="<div class=\"row row-grid space-bottom no-display\" id=\"country-cart-pargo-select\">";
									$vString .= "<div class=\"col-xs-12 col-md-12 row-grid green checkbox-inline\">";
										$vString .="<iframe src=\"https://map.pargo.co.za/?token=YQw7kd9fQAdkxKefS3GW8PNCRXBuqg\" id=\"pargo-iframe\"></iframe>";
									$vString .="</div>";
								$vString .="</div>";

								$vNormalCourierCostResults = MysqlQuery::getCourierCostPerId($pConn, array_sum($vResults[3]), 1);//South Africa: Normal postage
								$vCourierITMainCourierCostResults = MysqlQuery::getCourierCostPerId($pConn, array_sum($vResults[3]), 2);//South Africa: Courier - CourierIT Main cities
								$vPargoCourierCostResults = MysqlQuery::getCourierCostPerId($pConn, array_sum($vResults[3]), 3);//South Africa: Courier - Pargo
								$vCourierITRegionalCourierCostResults = MysqlQuery::getCourierCostPerId($pConn, array_sum($vResults[3]), 6);//South Africa: Courier - CourierIT Regional
								$vCourierITJhbPtaCourierCostResults = MysqlQuery::getCourierCostPerId($pConn, array_sum($vResults[3]), 7);//South Africa: Courier - CourierIT Jhb, Pta
								$vNearDeliverResults = MysqlQuery::getCourierCostPerId($pConn, array_sum($vResults[3]), 204);//Montana, Doornpoort, Magalieskruin, Sinoville | R35
                                $vString .= "<div class=\"row row-grid space-bottom\">";
										$vString .= "<div class=\"col-xs-6 col-md-6 row-grid green checkbox-inline no-display\" id=\"text-cart-courier-cost\"><b>".MysqlQuery::getText($pConn, 108)/*Versendingskoste*/."</b></div>";
										$vString .= "<div class=\"col-xs-6 col-md-5 row-grid col-right green\">";
											$vString .= "<div class=\"no-display\" id=\"normal-cart-courier-cost\">".$vNormalCourierCostResults[1]."</div>";
											$vString .= "<div class=\"no-display\" id=\"courierit-main-cart-courier-cost\">".$vCourierITMainCourierCostResults[1]."</div>";
											$vString .= "<div class=\"no-display\" id=\"pargo-cart-courier-cost\">".$vPargoCourierCostResults[1]."</div>";
											$vString .= "<div class=\"no-display\" id=\"courierit-regional-cart-courier-cost\">".$vCourierITRegionalCourierCostResults[1]."</div>";
											$vString .= "<div class=\"no-display\" id=\"courierit-jhbpta-cart-courier-cost\">".$vCourierITJhbPtaCourierCostResults[1]."</div>";
											$vString .= "<div class=\"no-display\" id=\"deliver-near-cart-courier-cost\">".$vNearDeliverResults[1]."</div>";
											$vString .= "<div class=\"col-right green\" id=\"cart-courier-cost\"></div>";
										$vString .= "</div>";
										$vString .= "<div class=\"col-md-1 row-grid col-right\"></div>";
								$vString .="</div>";//row

								$vString .= "<div class=\"row row-grid\">";
										$vString .= "<div class=\"col-xs-12 col-md-12 row-grid red text-xsmall no-display\" id=\"normal-cart-message\">".MysqlQuery::getText($pConn, 132)/*<b><u>BELANGRIK: Bestellings sal binne....*/."</div>";
										$vString .= "<div class=\"col-xs-12 col-md-12 row-grid red text-xsmall no-display\" id=\"courier-cart-message\">".MysqlQuery::getText($pConn, 112)/*<b><u>BELANGRIK: Posgeld is..... */."</div>";
								$vString .="</div>";//row

								//Total order cost
								$vString .= "<div class=\"row row-grid total-line no-display\" id=\"total-cart-cost\">";
									$vString .= "<div class=\"form-group\">";
										$vString .= "<div class=\"col-xs-6 col-md-6 row-grid green\">".MysqlQuery::getText($pConn, 292)/*Totale bestelling koste*/."</div>";
										$vString .= "<div class=\"col-xs-6 col-md-5 row-grid col-right green\" id=\"cart-total-order-cost\"></div>";
										$vString .= "<div class=\"col-md-1 row-grid col-right\"></div>";
									$vString .="</div>";
								$vString .="</div>";

								//Message
								$vString .="<div class=\"row\">";
									$vString .= "<div class=\"col-xs-12\">";
										$vString .= "<h1 class=\"red blink\">&nbsp;&nbsp;".MysqlQuery::getText($pConn, 452)/*MAAK ASSEBLIEF SEKER DAT JY...*/."</h1>";
									$vString .="</div>";
								$vString .="</div>";//row

								//Delivery address
								$vString .="<div class=\"row\">";
									$vString .= "<div class=\"col-xs-12\">";
										$vString .= "<h5 class=\"red\"><i class=\"fa fa-angle-double-right fa-lg\" aria-hidden=\"true\"></i>&nbsp;&nbsp;".MysqlQuery::getText($pConn, 289)/*Kies 'n afleweringsadres*/."</h5>";
									$vString .="</div>";
								$vString .="</div>";//row

								$vString .= "<div class=\"row row-grid\">";
									($vResults[28][0] == 1 ? $vPostalChecked = " checked" : $vPostalChecked = "");
									($vResults[28][0] == 1 ? $vPostalDiv = " selected-div" : $vPostalDiv = "");
										$vString .= "<div class=\"col-xs-2 col-md-1 col-right checkbox-inline\"><input type=\"checkbox\" id=\"delivery-postal\" data-src=\"postal\" name=\"delivery\" value=\"postal\" ".$vPostalChecked."></div>";
										$vString .= "<div class=\"col-xs-10 col-md-2 line text-small-normal".$vPostalDiv."\" id=\"postal-check\" data-address1=\"".$vClientResults[6][0]."\"  data-address2=\"".$vClientResults[7][0]."\" data-city=\"".$vClientResults[8][0]."\" data-province=\"".$vClientResults[9][0]."\" data-code=\"".$vClientResults[10][0]."\" data-country=\"".$vClientResults[11][0]."\">";
											(!empty($vClientResults[6][0]) ? $vString .= $vClientResults[6][0]."<br>" : $vString .= "");
											(!empty($vClientResults[7][0]) ? $vString .= $vClientResults[7][0]."<br>" : $vString .= "");
											(!empty($vClientResults[8][0]) ? $vString .= $vClientResults[8][0]."<br>" : $vString .= "");
											(!empty($vClientResults[9][0]) ? $vString .= $vClientResults[9][0]."<br>" : $vString .= "");
											(!empty($vClientResults[10][0]) ? $vString .= $vClientResults[10][0]."<br>" : $vString .= "");
											(!empty($vClientResults[11][0]) ? $vString .= $vClientResults[11][0] : $vString .= "");
										$vString .= "</div>";
										if(!empty($vClientResults[12][0]) || !empty($vClientResults[13][0])){
											($vResults[28][0] == 2 ? $vPhysicalChecked = " checked" : $vPhysicalChecked = "");
											($vResults[28][0] == 2 ? $vPhysicalDiv = " selected-div" : $vPhysicalDiv = "");
											$vString .= "<div class=\"col-xs-2 col-md-1 col-right checkbox-inline\"><input type=\"checkbox\" id=\"delivery-physical\" data-src=\"physical\" name=\"delivery\" value=\"physical\" ".$vPhysicalChecked."></div>";
											$vString .= "<div class=\"col-xs-10 col-md-2 line text-small-normal".$vPhysicalDiv."\" id=\"physical-check\" data-address1=\"".$vClientResults[12][0]."\"  data-address2=\"".$vClientResults[13][0]."\" data-city=\"".$vClientResults[14][0]."\" data-province=\"".$vClientResults[15][0]."\" data-code=\"".$vClientResults[17][0]."\" data-country=\"".$vClientResults[16][0]."\">";
												(!empty($vClientResults[12][0]) ? $vString .= $vClientResults[12][0]."<br>" : $vString .= "");
												(!empty($vClientResults[13][0]) ? $vString .= $vClientResults[13][0]."<br>" : $vString .= "");
												(!empty($vClientResults[14][0]) ? $vString .= $vClientResults[14][0]."<br>" : $vString .= "");
												(!empty($vClientResults[15][0]) ? $vString .= $vClientResults[15][0]."<br>" : $vString .= "");
												(!empty($vClientResults[16][0]) ? $vString .= $vClientResults[16][0]."<br>" : $vString .= "");
												(!empty($vClientResults[17][0]) ? $vString .= $vClientResults[17][0] : $vString .= "");
											$vString .= "</div>";
										}
										else {
											$vString .= "<div class=\"col-xs-2 col-md-1 col-right checkbox-inline\"></div>";
											$vString .= "<div class=\"col-xs-10 col-md-2 line text-small-normal\" id=\"physical-check\"></div>";
										}
										if($vResults[28][0] == 3){
											$vNewChecked = " checked";
											$vNewDiv = " selected-div";
											//$vNName = $vResults[20][0];
											$vN1 = $vResults[14][0];
											$vN2 = $vResults[15][0];
											$vNCity = $vResults[16][0];
											$vNProvince = $vResults[17][0];
											$vNCountry = $vResults[18][0];
											$vNCode = $vResults[19][0];
											$vNPhone = $vResults[21][0];
											$vPargoPoint = $vResults[23][0];
										}
										(empty($vResults[20][0]) ? $vNName = $vClientResults[1][0]." ".$vClientResults[2][0] : $vNName = $vResults[20][0]);
										(empty($vResults[21][0]) ? $vNPhone = $vClientResults[5][0] : $vNPhone = $vResults[21][0]);

										$vString .= "<div class=\"col-xs-2 col-md-1 col-right checkbox-inline\"><input type=\"checkbox\" id=\"delivery-new\" data-src=\"new\" name=\"delivery\" value=\"new\"".$vNewChecked."></div>";
										$vString .= "<div class=\"col-xs-10 col-md-2 line text-small-normal".$vNewDiv."\"  id=\"new-check\">";
											$vString .= "<div><input type=\"text\" name=\"new_1\" id=\"new_1\" value=\"".$vN1."\" placeholder=\"".MysqlQuery::getText($pConn, 181)/*Adres*/."\" size=\"25\" maxlength=\"45\" class=\"text-small-normal\" disabled=\"true\"></div>";
											$vString .= "<div><input type=\"text\" name=\"new_2\" id=\"new_2\" value=\"".$vN2."\" placeholder=\"\" size=\"25\" maxlength=\"50\" class=\"text-small-normal\" disabled=\"true\"></div>";
											$vString .= "<div><input type=\"text\" name=\"new_city\" id=\"new_city\" value=\"".$vNCity."\" placeholder=\"".MysqlQuery::getText($pConn, 98)/*Stad / Dorp*/."\" size=\"25\" maxlength=\"45\" class=\"text-small-normal\" disabled=\"true\"></div>";
											$vString .= "<div><input type=\"text\" name=\"new_province\" id=\"new_province\" value=\"".$vNProvince."\" placeholder=\"".MysqlQuery::getText($pConn, 248)/*Provinsie*/."\" size=\"25\" maxlength=\"45\" class=\"text-small-normal\" disabled=\"true\"></div>";
											$vString .= "<div><input type=\"text\" name=\"new_country\" id=\"new_country\" value=\"".$vNCountry."\" placeholder=\"".MysqlQuery::getText($pConn, 229)/*Land*/."\" size=\"25\" maxlength=\"45\" class=\"text-small-normal\" disabled=\"true\"></div>";
											$vString .= "<div><input type=\"text\" name=\"new_code\" id=\"new_code\" value=\"".$vNCode."\" placeholder=\"".MysqlQuery::getText($pConn, 71)/*Poskode*/."\" size=\"10\" maxlength=\"6\" class=\"text-small-normal\" disabled=\"true\"></div>";
											$vString .= "<input type=\"hidden\" name=\"pargo_point_code\" id=\"pargo_point_code\" value=\"".$vPargoPoint."\">";
											$vString .= "<div class=\"text-small red\"><i class=\"fa fa-question fa-lg\" aria-hidden=\"true\" data-html=\"true\" data-toggle=\"tooltip\" data-placement=\"top\"  title=\"".MysqlQuery::getText($pConn, 290)/*Tik 'n posadres vir hierdie...*/."  ".MysqlQuery::getText($pConn, 360)/*Hierdie tydelike adres sal nie jou gestoorde profiel adres vervang nie.*/."\"></i></div>";
										$vString .= "</div>";
								$vString .="</div>";//row

								//Reciever name & no
								$vString .="<div class=\"row space-bottom\">";
									$vString .= "<div class=\"col-xs-12\">";
										$vString .= "<h5 class=\"red\"><i class=\"fa fa-angle-double-right fa-lg\" aria-hidden=\"true\"></i>&nbsp;&nbsp;".MysqlQuery::getText($pConn, 454)/*Ontvanger naam en kontaknommer*/."</h5>";
											$vString .= "<div class=\"green\"><input type=\"text\" name=\"new_name\" id=\"new_name\" value=\"".$vNName."\" placeholder=\"".MysqlQuery::getText($pConn, 383)/*Ontvanger naam*/."\" size=\"25\" maxlength=\"50\" class=\"text-small-normal space-left\"></div>";
											$vString .= "<div class=\"green\"><input type=\"text\" name=\"new_phone\" id=\"new_phone\" value=\"".$vNPhone."\" placeholder=\"".MysqlQuery::getText($pConn, 384)/*Ontvanger kontaknommer*/."\" size=\"25\" maxlength=\"25\" class=\"text-small-normal space-left\"></div>";
										$vString .= "</div>";
								$vString .="</div>";//row

								//Special message
								$vString .="<div class=\"row\">";
									$vString .= "<div class=\"col-xs-12\">";
										$vString .= "<h5 class=\"red\"><i class=\"fa fa-angle-double-right fa-lg\" aria-hidden=\"true\"></i>&nbsp;&nbsp;".MysqlQuery::getText($pConn, 153)/*Aflewerings boodskap*/."</h5>";
									$vString .="</div>";
								$vString .="</div>";//row

								$vString .= "<div class=\"row row-grid\">";
										$vString .= "<div class=\"col-xs-12 col-md-12 row-grid green checkbox-inline\">";
											$vString .= "<textarea name=\"message\" id=\"message\" wrap=\"soft\" cols=\"120\" rows=\"2\" maxlength=\"255\">".$vResults[27][0]."</textarea>";
										$vString .= "</div>";
								$vString .="</div>";//row

								//Form error
								$vString .="<div class=\"row space-bottom\">";
									$vString .= "<div class=\"col-xs-12\">";
										$vString .="<div id=\"delivery_courier_error\" class=\"error\" style=\"display:none;\">".MysqlQuery::getText($pConn, 282)/*Kies 'n versendingsopsie*/."</div>";
										$vString .="<div id=\"delivery_address_error\" class=\"error\" style=\"display:none;\">".MysqlQuery::getText($pConn, 294)/*Kies 'n afleweringsadres of tik 'n adres in*/."</div>";
										$vString .="<div id=\"pargo_address_error\" class=\"error\" style=\"display:none;\">".MysqlQuery::getText($pConn, 449)/*Kies asseblief 'n Pargo afleweringsadres*/."</div>";
									$vString .="</div>";
								$vString .="</div>";//row

						$vString .= "</div>";//Body

							$vString .= "<div class=\"form-footer\">";
								$vString .="<div class=\"row\">";
				                    $vString .="<div class=\"col-xs-12\">";
										$vString .= "<a href=\"".$_SESSION['SessionGrafLanguage']."/".$_SESSION['SessionGrafUserId']."/".MysqlQuery::getText($pConn, 285)/*BestelNou*/."\" title=\"".MysqlQuery::getText($pConn, 56)/*Terug*/."\"><button type=\"button\" id=\"backCButton\" class=\"btn btn-primary\">".MysqlQuery::getText($pConn, 56)/*Terug*/."</button></a>";
										$vString .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"submit\" id=\"cartSubmitStep2\" class=\"btn btn-primary no-display\" title=\"".MysqlQuery::getText($pConn, 122)/*Gaan voort*/."\">".MysqlQuery::getText($pConn, 122)/*Gaan voort*/."</button>";
									$vString .="</div>";
								$vString .="</div>";
							$vString .="</div>";//footer
					}
					else {
							$vString .="<div class=\"row\">";
								$vString .= "<div class=\"col-xs-12\">";
									$vString .= "<h5 class=\"gray\">".MysqlQuery::getText($pConn, 123)/*Jou mandjie is leeg*/."</h5>";
									$vString .= "<hr class=\"light-gray\">";
								$vString .="</div>";
							$vString .="</div>";
					}
					$vString .= "</div>";//center
				$vString .= "</div>";//form-border
				$vString .= "<input type=\"hidden\" name=\"deliver_name\" id=\"deliver_name\" value=\"".$vResults[20][0]."\">";
				$vString .= "<input type=\"hidden\" name=\"deliver_address1\" id=\"deliver_address1\" value=\"".$vResults[14][0]."\">";
				$vString .= "<input type=\"hidden\" name=\"deliver_address2\" id=\"deliver_address2\" value=\"".$vResults[15][0]."\">";
				$vString .= "<input type=\"hidden\" name=\"deliver_city\" id=\"deliver_city\" value=\"".$vResults[16][0]."\">";
				$vString .= "<input type=\"hidden\" name=\"deliver_province\" id=\"deliver_province\" value=\"".$vResults[17][0]."\">";
				$vString .= "<input type=\"hidden\" name=\"deliver_country\" id=\"deliver_country\" value=\"".$vResults[18][0]."\">";
				$vString .= "<input type=\"hidden\" name=\"deliver_code\" id=\"deliver_code\" value=\"".$vResults[19][0]."\">";
				$vString .= "<input type=\"hidden\" name=\"deliver_phone\" id=\"deliver_phone\" value=\"".$vResults[21][0]."\">";
				$vString .= "<input type=\"hidden\" name=\"courier_type\" id=\"courier_type\" value=\"".$vResults[22][0]."\">";
				$vString .= "<input type=\"hidden\" name=\"courier_detail\" id=\"courier_detail\" value=\"".$vResults[23][0]."\">";
				$vString .= "<input type=\"hidden\" name=\"courier_cost\" id=\"courier_cost\" value=\"".$vResults[24][0]."\">";
				$vString .= "<input type=\"hidden\" name=\"price\" id=\"price\" value=\"".$vResults[25][0]."\">";
				$vString .= "<input type=\"hidden\" name=\"total_price\" id=\"total_price\" value=\"".$vResults[26][0]."\">";
				$vString .= "<input type=\"hidden\" name=\"delivery_address_type\" id=\"delivery_address_type\" value=\"".$vResults[28][0]."\">";
			$vString .= "</form>";
?>
			<Script>
				$(document).ready(function(){
					var sum = 0;
					$('[id^=cart-total-price-]').each(function(){
						var theValue = $(this).text().substring(2);
					    sum += parseFloat(theValue);
					    $('#cart-total-all-books-price').html('R '+sum+'');
					    $('#total-price').val(sum);
					});

					var v_deliver_type = $("#delivery_address_type").val();
					if(v_deliver_type.length == 0){
				    	$("#cartSubmitStep1").addClass("no-display");
					} else {
						$("#cartSubmitStep1").removeClass("no-display");
					}

				});

				if (window.addEventListener) {
				    window.addEventListener("message", selectPargoPoint, false);
				} else {
				    window.attachEvent("onmessage", selectPargoPoint);
				}

				function selectPargoPoint(item){
					$('#pargo_address_error').fadeOut(500);
					if(typeof item.data["storeName"] != "undefined"){
				    	$("#delivery-postal").prop('checked', false);
				    	$("#delivery-physical").prop('checked', false);
				    	$("#delivery-new").prop('checked', false);

				    	$("#postal-check").removeClass( "selected-div" );
		    			$("#physical-check").removeClass( "selected-div" );
		    			$("#new-check").removeClass( "selected-div" );

// 						 if((item.data["address2"] && item.data["address2"].length > 0) && (item.data["suburb"] && item.data["suburb"].length > 0)){
// 							var stringDiv = ", ";
// 						 }
// 						 else {
// 							 var stringDiv = "";
// 						 }
						 //$("#new_name").val(item.data["storeName"]);
						 $("#new_1").val(item.data["storeName"]);
						 $("#new_2").val(item.data["address1"]);
						 $("#new_city").val( item.data["city"]);
						 $("#new_province").val( item.data["province"]);
						 $("#new_country").val("RSA");
						 $("#new_code").val(item.data["postalcode"]);
						 $("#pargo_point_code").val(item.data["pargoPointCode"]);

						 $("#country-cart-pargo-select").addClass( "no-display");
					     $("#delivery-new").prop('checked', true);
					     $("#new-check").addClass( "selected-div" );
						 $('#delivery_address_error').fadeOut(500);
						 $('#cartSubmitStep2').fadeIn(500);
				        return false;
					}
				}
			</Script>
<?php
		}
		else {
				//$vErrorResult = $vPages->returnErrorResult($pConn, 279);//*Jou bestelling is nie gelaai nie. Probeer asseblief weer. Kontak Graffititi indien die fout herhaaldelik voorkom.
				//echo $vErrorResult;
		}
		return General::prepareStringForDisplay($vString);
	}

	public static function returnCheckoutPaymentForm($pConn, $pData){
		if($pData['client_id'] == $_SESSION['SessionGrafUserId']){
			$vOrder = " ORDER BY b.title ";
			$vBindParams = array();
			$vBindLetters = "i";
			$vBindParams[] = & $pData['client_id'];
			$vLimit = "";
			$vWhere = " WHERE client_id = ? and order_date is NULL and order_reference is NULL and order_id is NULL and temp_salt is not NULL";
			$vResults = MysqlQuery::getCart($pConn, $vWhere, $vOrder, $vBindLetters, $vBindParams, $vLimit);

			$vCourierType = MysqlQuery::getLookupPerId($pConn, $vResults[22][0]);
			if($vResults[22][0] == 5){
				$vCourierDetail = MysqlQuery::getCourierCountry($pConn, $vResults[23][0]);//$vId, $vCountry
			}
			else if (($vResults[22][0] == 2 || $vResults[22][0] == 3 || $vResults[22][0] == 6) && !empty($vResults[23][0])){
				$vCourierDetail = $vResults[23][0];
			}
			$vPaymentResults = MysqlQuery::getLookup($pConn, "payment");
			$vDeliveryCostText = MysqlQuery::getCourierTextPerId($pConn, $vResults[22][0]);
			$vShortDeliveryCostText = substr($vDeliveryCostText, 0, strpos($vDeliveryCostText, "|"));
			$vString = "";

			$vString .= "<form class=\"form-horizontal\" name=\"orderPaymentForm\" id=\"orderPaymentForm\" role=\"form\" method=\"post\" action=\"".$_SESSION['SessionGrafLanguage']."/".$vResults[2][0]."/".MysqlQuery::getText($pConn, 297)/*BestelFinaal*/."\">";
				$vString .= "<div id=\"form-border\">";
					$vString .= "<div id=\"center\">";

						$vString .= "<div class=\"form-header\">";
								$vString .= "<h1 class=\"red\">".MysqlQuery::getText($pConn, 17)/*Bestel nou*/."</h1>";
							$vString .="<div class=\"row\">";
								$vString .= "<div class=\"col-xs-12\">";
									$vString .= "<ul id=\"progress\">";
			    						$vString .= "<li class=\"steps\">".MysqlQuery::getText($pConn, 280)/*Stap*/." 1.&nbsp;&nbsp;".MysqlQuery::getText($pConn, 16)/*Jou mandjie*/."</li>";
			    						$vString .= "<li class=\"steps\">".MysqlQuery::getText($pConn, 280)/*Stap*/." 2.&nbsp;&nbsp;".MysqlQuery::getText($pConn, 278)/*Aflewering*/."</li>";
			    						$vString .= "<li class=\"steps active\">".MysqlQuery::getText($pConn, 280)/*Stap*/." 3.&nbsp;&nbsp;".MysqlQuery::getText($pConn, 279)/*Betaling*/."</li>";
									$vString .= "</ul>	";
								$vString .= "</div>";
							$vString .= "</div>";
						$vString .= "</div>";//header

						$vString .= "<div class=\"form-body\">";

								$vString .="<div class=\"row\">";
									$vString .= "<div class=\"col-xs-12\">";
										$vString .= "<h4 class=\"green\">".MysqlQuery::getText($pConn, 280)/*Stap*/." 3.&nbsp;&nbsp;".MysqlQuery::getText($pConn, 279)/*Betaling*/."</h4>";
										$vString .= "<hr class=\"light-gray\">";
									$vString .="</div>";
								$vString .="</div>";//row

									$vString .="<div class=\"row\">";
									$vString .= "<div class=\"col-xs-12\">";
										$vString .= "<h5 class=\"gray\"><i class=\"fa fa-angle-double-right fa-lg\" aria-hidden=\"true\"></i>&nbsp;&nbsp;".MysqlQuery::getText($pConn, 281)/*Jou boeke*/."</h5>";
									$vString .="</div>";
								$vString .="</div>";//row
						if(count($vResults[0]) > 0){
								for($x = 0; $x < count($vResults[0]); $x++){
									$vTotalBookPrice = $vResults[3][$x] * $vResults[10][$x];
										($vResults[12][$x] == 0 && $vResults[13][$x] <= $_SESSION['now_date'] ? $vInStockMesssage = "<span class=\"text-small-normal red blink\"><b>&nbsp;&nbsp;(".MysqlQuery::getText($pConn, 293)/*Nie in voorraad - sal versending vertraag*/.")</b></span>" : $vInStockMesssage = "");
										($vResults[13][$x] > $_SESSION['now_date'] ? $vPublicationMesssage = "<span class=\"text-small-normal red blink\"><b>&nbsp;&nbsp;(".MysqlQuery::getText($pConn, 412)/*Let asseblief op die publikasie datum. Versending sodra boek gepubliseer is.*/." - ".$vResults[13][$x].")</b></span>" : $vPublicationMesssage = "");
										//($vResults[12][$x] == 0 ? $vInStockMesssage = "<span class=\"text-small-normal red\">&nbsp;&nbsp;(".MysqlQuery::getText($pConn, 293)/*Nie in voorraad - sal versending vertraag*/.")</span>" : $vInStockMesssage = "");
									//Books
									$vString .= "<div class=\"row row-grid\">";
											$vString .= "<div class=\"col-xs-6 col-md-6 row-grid\">".$vResults[9][$x].$vInStockMesssage."".$vPublicationMesssage."</div>";
											$vString .= "<div class=\"col-xs-3 col-md-3 row-grid col-right\">".$vResults[3][$x]."</div>";
											$vString .= "<div class=\"col-xs-3 col-md-2 row-grid col-right\" id=\"cart-total-price-".$vResults[0][$x]."\">R ".$vTotalBookPrice."</div>";
											$vString .= "<div class=\"col-md-1 row-grid col-right\"></div>";
									$vString .="</div>";//row
								}
								//Total book cost
								$vString .= "<div class=\"row row-grid space-bottom\">";
										$vString .= "<div class=\"col-xs-6 col-md-6 row-grid gray\">".MysqlQuery::getText($pConn, 107)/*Totaal*/."</div>";
										$vString .= "<div class=\"col-xs-6 col-md-5 row-grid col-right gray\" id=\"cart-total-all-books-price\"></div>";
										$vString .= "<div class=\"col-md-1 row-grid col-right\"></div>";
								$vString .="</div>";//row

								//Dispatch
								$vString .="<div class=\"row\">";
									$vString .="<hr class=\"light-gray\">";
									$vString .= "<div class=\"col-xs-12\">";
										$vString .= "<h5 class=\"gray\"><i class=\"fa fa-angle-double-right fa-lg\" aria-hidden=\"true\"></i>&nbsp;&nbsp;".$vShortDeliveryCostText."</h5>";
									$vString .="</div>";
								$vString .="</div>";//row

								$vString .= "<div class=\"row row-grid\">";
										$vString .= "<div class=\"col-xs-6 col-md-6 row-grid\">".$vCourierType;
										if($vResults[22][0] == 5){//Other country
											$vString .= " - ".$vCourierDetail[1];
										}
										else if(!empty($vCourierDetail)){

										}
										$vString .= "</div>";
										$vString .= "<div class=\"col-xs-6 col-md-5 row-grid col-right\">R ".$vResults[24][0]."</div>";
										$vString .= "<div class=\"col-md-1 row-grid col-right\"></div>";
								$vString .="</div>";//row

								//Total order cost
								$vString .= "<div class=\"row row-grid space-bottom total-line gray\">";
									$vString .= "<div class=\"form-group\">";
											$vString .= "<div class=\"col-xs-6 col-md-6 row-grid\">".MysqlQuery::getText($pConn, 292)/*Totale bestelling koste*/."</div>";
											$vString .= "<div class=\"col-xs-6 col-md-5 row-grid col-right\">R ".$vResults[26][0]."</div>";
											$vString .= "<div class=\"col-md-1 row-grid col-right\"></div>";
											$vString .="</div>";
								$vString .="</div>";//row

								if($vResults[22][0] != 4){//Not collect
									//Delivery address
										$vString .="<div class=\"row\">";
										$vString .= "<div class=\"col-xs-12\">";
											$vString .= "<h5 class=\"gray\"><i class=\"fa fa-angle-double-right fa-lg\" aria-hidden=\"true\"></i>&nbsp;&nbsp;".MysqlQuery::getText($pConn, 278)/*Aflewering*/."</h5>";
										$vString .="</div>";
									$vString .="</div>";//row

									$vString .= "<div class=\"row row-grid\">";
											$vString .= "<div class=\"col-xs-12 col-md-12 row-grid\">";
												(!empty($vResults[20][0]) ? $vString .= $vResults[20][0]."<br>" : $vString .= "");
												(!empty($vResults[21][0]) ? $vString .= $vResults[21][0]."<br>" : $vString .= "");
												(!empty($vResults[14][0]) ? $vString .= $vResults[14][0] : $vString .= "");
												(!empty($vResults[15][0]) ? $vString .= ", ".$vResults[15][0] : $vString .= "");
												(!empty($vResults[16][0]) ? $vString .= ", ".$vResults[16][0] : $vString .= "");
												(!empty($vResults[17][0]) ? $vString .= ", ".$vResults[17][0] : $vString .= "");
												(!empty($vResults[18][0]) ? $vString .= ", ".$vResults[18][0] : $vString .= "");
												(!empty($vResults[19][0]) ? $vString .= ", ".$vResults[19][0]."<br>"  : $vString .= "");
												(!empty($vResults[27][0]) ? $vString .= "<br>".MysqlQuery::getText($pConn, 153)/*Aflewerings boodskap*/.": ".$vResults[27][0] : $vString .= "");
											$vString .="</div>";
									$vString .="</div>";//row
								}

								//Payment option
								$vString .="<div class=\"row\">";
									$vString .="<hr class=\"light-gray\">";
									$vString .= "<div class=\"col-xs-12\">";
										$vString .= "<h5 class=\"red\"><i class=\"fa fa-angle-double-right fa-lg\" aria-hidden=\"true\"></i>&nbsp;&nbsp;".MysqlQuery::getText($pConn, 196)/*Kies 'n betalingsmetode*/."</h5>";
									$vString .="</div>";
								$vString .="</div>";//row

									for($p = 0; $p < count($vPaymentResults[0]); $p++){
										$vString .= "<div class=\"row row-grid space-bottom-light\">";
												$vString .= "<div class=\"col-xs-1 col-md-1 col-right checkbox-inline green\"><input type=\"checkbox\" id=\"payment-".$vPaymentResults[0][$p]."\" name=\"payment_type\" value=\"".$vPaymentResults[0][$p]."\"></div>";
					            				$vString .= "<div class=\"col-xs-1 col-md-1 row-grid col-center green\" id=\"payment-check-".$vPaymentResults[0][$p]."\"><img src=\"images/payment_".$vPaymentResults[0][$p].".png\" class=\"img-responsive cart-thumb thumb\" alt=\"".$vPaymentResults[1][$p]."\"></div>";
												$vString .= "<div class=\"col-xs-10 col-md-10 green checkbox-inline\">".$vPaymentResults[1][$p];
												if($vPaymentResults[0][$p] == 57){
													$vString .= "&nbsp;&nbsp;<a href=\"https://www.zapper.com/users\" target=\"_blank\"><i class=\"fa fa-info-circle fa-lg green \" aria-hidden=\"true\" data-html=\"true\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"".MysqlQuery::getText($pConn, 477)/*Wat is Zapper? Klik hier vir meer oor Zapper!*/."\"></i></a></div>";
												}
												else {
													$vString .= "</div>";
												}
										$vString .="</div>";//row
									}

								//Form error
									$vString .="<div class=\"row row-grid space-bottom\">";
									$vString .= "<div class=\"col-xs-12\">";
										$vString .="<div id=\"payment_type_error\" class=\"error no-display\">".MysqlQuery::getText($pConn, 196)/*Kies 'n betalingsmetode*/."</div>";
										$vString .="<div id=\"delivery_error\" class=\"error\">".MysqlQuery::getText($pConn, 448)/*Daar is 'n fout met die bestelling. Klik asseblief op 'Terug' en maak seker jy he...*/."</div>";
									$vString .="</div>";
								$vString .="</div>";//row

						$vString .= "</div>";//Body

							$vString .= "<div class=\"form-footer\">";
								$vString .="<div class=\"row\">";
				                    $vString .="<div class=\"col-xs-12\">";
										$vString .= "<a href=\"".$_SESSION['SessionGrafLanguage']."/".$pData['client_id']."/".MysqlQuery::getText($pConn, 283)/*BestelNouKoerier*/."\" title=\"".MysqlQuery::getText($pConn, 56)/*Terug*/."\"><button type=\"button\" id=\"backCButton\" class=\"btn btn-primary\">".MysqlQuery::getText($pConn, 56)/*Terug*/."</button></a>";
										$vString .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"submit\" id=\"paymentSubmit\" class=\"btn btn-primary no-display\">".MysqlQuery::getText($pConn, 7)/*Bestel*/."</button>";
									$vString .="</div>";
								$vString .="</div>";
							$vString .="</div>";//footer
					}
					else {
							$vString .="<div class=\"row\">";
								$vString .= "<div class=\"col-xs-12\">";
									$vString .= "<h5 class=\"gray\">".MysqlQuery::getText($pConn, 123)/*Jou mandjie is leeg*/."</h5>";
									$vString .= "<hr class=\"light-gray\">";
								$vString .="</div>";
							$vString .="</div>";
					}
					$vString .= "</div>";//center
				$vString .= "</div>";//form-border

				$vTempSalt = General::createSalt(5);
				$vString .= "<input type=\"hidden\" name=\"deliver_name\" id=\"deliver_name\" value=\"".$vResults[20][0]."\">";
				$vString .= "<input type=\"hidden\" name=\"deliver_address1\" id=\"deliver_address1\" value=\"".$vResults[14][0]."\">";
				$vString .= "<input type=\"hidden\" name=\"deliver_address2\" id=\"deliver_address2\" value=\"".$vResults[15][0]."\">";
				$vString .= "<input type=\"hidden\" name=\"deliver_city\" id=\"deliver_city\" value=\"".$vResults[16][0]."\">";
				$vString .= "<input type=\"hidden\" name=\"deliver_province\" id=\"deliver_province\" value=\"".$vResults[17][0]."\">";
				$vString .= "<input type=\"hidden\" name=\"deliver_country\" id=\"deliver_country\" value=\"".$vResults[18][0]."\">";
				$vString .= "<input type=\"hidden\" name=\"deliver_code\" id=\"deliver_code\" value=\"".$vResults[19][0]."\">";
				$vString .= "<input type=\"hidden\" name=\"deliver_phone\" id=\"deliver_phone\" value=\"".$vResults[21][0]."\">";
				$vString .= "<input type=\"hidden\" name=\"courier_type\" id=\"courier_type\" value=\"".$vResults[22][0]."\">";
				$vString .= "<input type=\"hidden\" name=\"courier_detail\" id=\"courier_detail\" value=\"".$vResults[23][0]."\">";
				$vString .= "<input type=\"hidden\" name=\"courier_cost\" id=\"courier_cost\" value=\"".$vResults[24][0]."\">";
				$vString .= "<input type=\"hidden\" name=\"price\" id=\"price\" value=\"".$vResults[25][0]."\">";
				$vString .= "<input type=\"hidden\" name=\"total_price\" id=\"total_price\" value=\"".$vResults[26][0]."\">";
				$vString .= "<input type=\"hidden\" name=\"message\" id=\"message\" value=\"".General::prepareStringForQuery($vResults[27][0])."\">";
				$vString .= "<input type=\"hidden\" name=\"temp_salt\" id=\"temp_salt\" value=\"".$vTempSalt."\">";
			$vString .= "</form>";

			$vString .="<Script>";
				$vString .= "$(document).ready(function(){";
					$vString .= "var sum = 0;";
					$vString .= "$('[id^=cart-total-price-]').each(function(){";
						$vString .= "var theValue = $(this).text().substring(2);";
					    $vString .= "sum += parseFloat(theValue);";
					    $vString .= "$('#cart-total-all-books-price').html('R '+sum+''); ";
					    $vString .= "$('#total-price').val(sum); ";
					$vString .= "});";
				$vString .= "});";
			$vString .= "</Script>";
		}
		else {
				$vErrorResult = Pages::returnErrorResult($pConn, 295);//*Jou bestelling is nie gelaai nie. Probeer asseblief weer. Kontak Graffititi indien die fout herhaaldelik voorkom.
				echo $vErrorResult;
		}
		return General::prepareStringForDisplay($vString);
	}

	public static function returnOrderCondfirmation($pConn, $pPaymentType, $pPaymentResult, $pData){
		$vString = "";
//		if($pData['client_id'] == $_SESSION['SessionGrafUserId']){
			if($pPaymentResult == 0){//Success
				$vClass = "green";
				$vHeading = MysqlQuery::getText($pConn, 255);/*Sukses!*/
				$vEmail = "";

				$vOrderBindParams = array();
				$vOrderBindLetters = "s";
				$vOrderBindParams[] = & $pData['reference'];
				$vOrderLimit = "LIMIT 1";
				$vOrderWhere = " WHERE id = ?";
				$vOrderResult = MysqlQuery::getOrder($pConn, $vOrderWhere, "", $vOrderBindLetters, $vOrderBindParams, $vOrderLimit);

				$vDeliveryAddress = "";
				(!empty($vOrderResult[27][0]) ? $vDeliveryAddress .= "&nbsp;".$vOrderResult[27][0]."<br>" : $vDeliveryAddress .= "");
				(!empty($vOrderResult[28][0]) ? $vDeliveryAddress .= "&nbsp;".$vOrderResult[28][0]."<br>" : $vDeliveryAddress .= "");
				(!empty($vOrderResult[4][0]) ? $vDeliveryAddress .= "&nbsp;".$vOrderResult[4][0] : $vDeliveryAddress .= "");
				(!empty($vOrderResult[5][0]) ? $vDeliveryAddress .= ", ".$vOrderResult[5][0] : $vDeliveryAddress .= "");
				(!empty($vOrderResult[6][0]) ? $vDeliveryAddress .= ", ".$vOrderResult[6][0] : $vDeliveryAddress .= "");
				(!empty($vOrderResult[7][0]) ? $vDeliveryAddress .= ", ".$vOrderResult[7][0] : $vDeliveryAddress .= "");
				(!empty($vOrderResult[8][0]) ? $vDeliveryAddress .= ", ".$vOrderResult[8][0] : $vDeliveryAddress .= "");
				(!empty($vOrderResult[9][0]) ? $vDeliveryAddress .= ", ".$vOrderResult[9][0] : $vDeliveryAddress .= "");

				$vDelivery = MysqlQuery::getLookupPerId($pConn, $vOrderResult[10][0]);

				$vDeliveryCostText = MysqlQuery::getCourierTextPerId($pConn, $vOrderResult[10][0]);
				$vShortDeliveryCostText = substr($vDeliveryCostText, 0, strpos($vDeliveryCostText, "|"));

				$vOrderDetailResult = MysqlQuery::getOrderDetail($pConn, "order_id = ?", $vOrderResult[0][0]);
				//$vId, $vOrder_id, $vBook_id, $vPrice, $vNumber_books, $vTemp_salt, $vTitle, $vInStock, $vAuthor

				$vBooks = "&nbsp;<b>".MysqlQuery::getText($pConn, 281)/*Jou boeke*/."</b>:<br>";
				$vBooks .= "<ul>";
					for($b = 0; $b < count($vOrderDetailResult[0]); $b++){
						$vBooks .= "<li>".$vOrderDetailResult[4][$b]." x ".$vOrderDetailResult[6][$b]." - ".$vOrderDetailResult[8][$b]." @ R ".$vOrderDetailResult[3][$b]."</li>";
					}
				$vBooks .= "</ul>";

				$vMessageTop = MysqlQuery::getText($pConn, 301);/*Jou bestelling detail is as volg:*/
				$vMessage = "&nbsp;<b>".MysqlQuery::getText($pConn, 156)/*Verwysingsnommer*/."</b>: GRAF/".$pData['reference']."/".$pData['temp_salt']."<br>";
				$vMessage .= "&nbsp;<b>".MysqlQuery::getText($pConn, 147)/*Totale prys*/."</b>: R ".$vOrderResult[13][0]."<br>";
				$vMessage .= "&nbsp;<b>".$vShortDeliveryCostText."</b>: R ".$vOrderResult[11][0]."<br>";
				$vMessage .= "&nbsp;<b>".MysqlQuery::getText($pConn, 113)/*Betalingsmetode*/."</b>: ".MysqlQuery::getLookupPerId($pConn, $pPaymentType)."<br>";
				if($pPaymentType == 16){
					$vMessage .= "<br><div class=\"green\"><b>&nbsp;".MysqlQuery::getText($pConn, 407)/*Gebruik asseblief ABSA rekening hieronder en Bestel # as verwysing.*/."</b></div>";
					$vMessage .= "&nbsp;&nbsp;ABSA<br>";
		    		$vMessage .= "&nbsp;&nbsp;BROOKLYN<br>";
		    		$vMessage .= "&nbsp;&nbsp;".MysqlQuery::getText($pConn, 408)/*REK #: 407 02 55 861*/."<br>";
		    		$vMessage .= "&nbsp;&nbsp;".MysqlQuery::getText($pConn, 409)/*TAK:  632 005*/."<br><br>";
				}
				if($vOrderResult[10][0] != 4){//Not collect
					$vMessage .= "<br><b>".MysqlQuery::getText($pConn, 288)/*Afleweringsadres*/."</b>:<br>".$vDeliveryAddress."<br>";
				}
				(!empty($vOrderResult[16][0]) ? $vMessage .= "<br>&nbsp;<b>".MysqlQuery::getText($pConn, 153)/*Aflewerings boodskap*/."</b>: ".$vOrderResult[16][0]."<br>" : $vMessage .= "");

				if($pPaymentType == 16){
					$vHeadingText = "&nbsp;".MysqlQuery::getText($pConn, 161);/*'n Bewys van die bestelling is per epos aan jou gestuur.*/
				}
				else{
					$vHeadingText = MysqlQuery::getText($pConn, 171);/*Jou bestelling en betaling is suksesvol.*/
				}
			}
			else {//Error
// 				$vClass = "red";
// 				$vHeading = MysqlQuery::getText($pConn, 172);/*Fout!*/
// 				$vHeadingText = MysqlQuery::getText($pConn, 300);/*Jou bestelling was nie suksesvol nie. Probeer asseblief weer. Kontak Graffititi indien die fout herhaaldelik voorkom.*/
// 				$vEmail = "support at graffitibooks.co.za";
// 				$vMessageTop = MysqlQuery::getText($pConn, 176).": ";/*Beskrywing rakende fout*/
// 				$vMessage = MysqlQuery::getText($pConn, 173)/*Foutkode*/.": ".$pData['error_code']."<br>";
// 				$vMessage .= MysqlQuery::getText($pConn, 175)/*Foutboodskap*/.": ".$pData['error_message']."<br>";
// 				$vMessage .= MysqlQuery::getText($pConn, 176)/*Fout beskrywing*/.": ".$pData['error_detail']."<br>";
// 				$vMessage .= MysqlQuery::getText($pConn, 174)/*Fout oorsprong*/.": ".$pData['error_source']."<br>";
// 				$vMessage .= MysqlQuery::getText($pConn, 303)/*Bank fout kode*/.": ".$pData['bank_error_code']."<br>";
// 				$vMessage .= MysqlQuery::getText($pConn, 304)/*Bank fout boodskap*/.": ".$pData['bank_error_message'];
			}
			$vEmailType = "order_success";

//			include_once "include/Invoice.php";
//			include_once "include/Email.php";

			$vString .= "<form class=\"form-horizontal\" role=\"form\" id=\"orderConfirmation\">";
			$vString .= "<div id=\"form-border\">";
				$vString .= "<div id=\"center\">";
					$vString .= "<div class=\"form-header\">";
						$vString .="<div class=\"row\">";
							$vString .= "<div class=\"col-xs-12\">";
								$vString .= "<h1 class=\"red\">".$vHeading."</h1>";
								$vString .= "<h5 class=\"".$vClass."\">".$vHeadingText."</h5>";
								(!empty($vEmail) ? $vString .= "<a href=\"\" class=\"email\" title=\"Graffiti\">".$vEmail."</a><br>" : $vString .= "");
							$vString .= "</div>";
						$vString .= "</div>";
					$vString .= "</div>";//Header

					$vString .= "<div class=\"form-body\">";
							$vString .="<div class=\"row space-bottom-light\">";
								$vString .= "<div class=\"col-xs-12\">";
									(!empty($vMessageTop) ? $vString .= "<br><b class=\"green\">".$vMessageTop."</b>" : $vString .= "");
									(!empty($vBooks) ? $vString .= "<br>".$vBooks : $vString .= "");
									(!empty($vMessage) ? $vString .= "<br>".$vMessage : $vString .= "");
								$vString .= "<br></div>";
							$vString .="</div>";//row
					$vString .="</div>";//body

					if($pPaymentResult == 0){
						$vString .= "<div class=\"form-footer\">";
							$vString .="<div class=\"row\">";
			                    $vString .="<div class=\"col-xs-12\">";
										$vString .= "<button type=\"button\" id=\"printForm\" data-src=\"orderConfirmation\" class=\"btn btn-primary\">".MysqlQuery::getText($pConn, 309)/*Druk bestelling info*/."</button>";
								$vString .="</div>";
							$vString .="</div>";
						$vString .="</div>";//footer
					}

				$vString .= "</div>";//center
			$vString .= "</div>";//form-border
			$vString .= "</form>";

			// Google Adwords Conversion
//			$vString .= '<!-- Google Code for Purchase Successful - Succesful Conversion Page -->';
//			$vString .= '<script type="text/javascript">';
//			$vString .= '/* <![CDATA[ */ ';
//			$vString .= 'var google_conversion_id = 819120782;';
//			$vString .= 'var google_conversion_label = "IvlPCNuaonwQjpXLhgM";';
//			$vString .= 'var google_remarketing_only = false;';
//			$vString .= '/* ]]> */ ';
//			$vString .= '</script>';
//			$vString .= '<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">';
//			$vString .= '</script>';
//			$vString .= '<noscript>';
//			$vString .= '<div style="display:inline;">';
//			$vString .= '<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/819120782/?label=IvlPCNuaonwQjpXLhgM&amp;guid=ON&amp;script=0"/>';
//			$vString .= '</div>';
//			$vString .= '</noscript>';

			// Google Analytics 'ORder Placed' Event Tracking
			 $vString .= '<script type="text/javascript">';
      $vString .= "if( typeof ga === 'function' ) {";
      $vString .= "	ga('send', { hitType: 'event', eventCategory: 'Sale', eventAction: 'Order', eventLabel: 'Order_Completed' });";
      $vString .= "} else if ( typeof _gaq === 'object' ) {";
      $vString .= "	_gaq.push(['_trackEvent', 'Sale', 'Order', 'Order_Completed']);";
      $vString .= "}";
      $vString .= "</script>";
			if($pPaymentResult == 0){
				$json = "undefined";
				$arr = array(
					'payment_result' => $pPaymentResult,
					'payment_type' => $pPaymentType,
					'order_id' => $pData['reference'],
					'lang' => $pData['lang']
				);
				$json = json_encode($arr);

				$vString .="<Script>$(document).ready(function(){";
					$vString .="$.post('order_email.php', ".$json.", function(data){});";
					$vString .="});";
				$vString .="</Script>";
			}

			return General::prepareStringForDisplay($vString);
// 		}
// 		else {
// 				$vErrorResult = Pages::returnErrorResult($pConn, 295);//*Jou bestelling is nie gelaai nie. Probeer asseblief weer. Kontak Graffititi indien die fout herhaaldelik voorkom.
// 				echo $vErrorResult;
// 		}
	}

	public static function returnOrderError($pConn, $pPaymentType, $pPaymentResult, $pData){
		$vString = "";
		$vMessagePay = "";

		$vClass = "red";
		$vHeading = MysqlQuery::getText($pConn, 172);/*Fout!*/
		$vHeadingText = MysqlQuery::getText($pConn, 300);/*Jou bestelling was nie suksesvol nie. Probeer asseblief weer. Kontak Graffititi indien die fout herhaaldelik voorkom.*/
		$vEmail = "orders at graffitibooks.co.za";

		//Bank message
		$vMessageTop = MysqlQuery::getText($pConn, 176).": ";/*Beskrywing rakende fout*/
		$vMessage = MysqlQuery::getText($pConn, 173)/*Foutkode*/.": ".$pData['error_code']."<br>";
		$vMessage .= MysqlQuery::getText($pConn, 175)/*Foutboodskap*/.": ".$pData['error_message']."<br>";
		$vMessage .= MysqlQuery::getText($pConn, 176)/*Fout beskrywing*/.": ".$pData['error_detail']."<br>";
		$vMessage .= MysqlQuery::getText($pConn, 174)/*Fout oorsprong*/.": ".$pData['error_source']."<br>";
		$vMessage .= MysqlQuery::getText($pConn, 303)/*Bank fout kode*/.": ".$pData['bank_error_code']."<br>";
		$vMessage .= MysqlQuery::getText($pConn, 304)/*Bank fout boodskap*/.": ".$pData['bank_error_message'];

		//Email to webmaster
		$vEmailDetail = "BestellingFout in function returnOrderError vanaf index ln 190.  Klient no ".$pData['client_id']." en prys: ".$vData['price']."\n".$vMessage.".  Nuwe Error page is vertoon!";
		mail("webmaster@graffitibooks.co.za", "Bestellingsfout", $vEmailDetail, "From: Server");

		//________________________________________________________________________
		$vOrderBindParams = array();
		$vOrderBindLetters = "s";
		$vOrderBindParams[] = & $pData['reference'];
		$vOrderLimit = "LIMIT 1";
		$vOrderWhere = " WHERE id = ?";
		$vOrderResult = MysqlQuery::getOrder($pConn, $vOrderWhere, "", $vOrderBindLetters, $vOrderBindParams, $vOrderLimit);

		$vDeliveryAddress = "";
		(!empty($vOrderResult[27][0]) ? $vDeliveryAddress .= "&nbsp;".$vOrderResult[27][0]."<br>" : $vDeliveryAddress .= "");
		(!empty($vOrderResult[28][0]) ? $vDeliveryAddress .= "&nbsp;".$vOrderResult[28][0]."<br>" : $vDeliveryAddress .= "");
		(!empty($vOrderResult[4][0]) ? $vDeliveryAddress .= "&nbsp;".$vOrderResult[4][0] : $vDeliveryAddress .= "");
		(!empty($vOrderResult[5][0]) ? $vDeliveryAddress .= ", ".$vOrderResult[5][0] : $vDeliveryAddress .= "");
		(!empty($vOrderResult[6][0]) ? $vDeliveryAddress .= ", ".$vOrderResult[6][0] : $vDeliveryAddress .= "");
		(!empty($vOrderResult[7][0]) ? $vDeliveryAddress .= ", ".$vOrderResult[7][0] : $vDeliveryAddress .= "");
		(!empty($vOrderResult[8][0]) ? $vDeliveryAddress .= ", ".$vOrderResult[8][0] : $vDeliveryAddress .= "");
		(!empty($vOrderResult[9][0]) ? $vDeliveryAddress .= ", ".$vOrderResult[9][0] : $vDeliveryAddress .= "");

		$vDeliveryCostText = MysqlQuery::getCourierTextPerId($pConn, $vOrderResult[10][0]);
		$vShortDeliveryCostText = substr($vDeliveryCostText, 0, strpos($vDeliveryCostText, "|"));

		$vOrderDetailResult = MysqlQuery::getOrderDetail($pConn, "order_id = ?", $vOrderResult[0][0]);
		//$vId, $vOrder_id, $vBook_id, $vPrice, $vNumber_books, $vTemp_salt, $vTitle, $vInStock, $vAuthor

		$vBooks = "&nbsp;<b>".MysqlQuery::getText($pConn, 281)/*Jou boeke*/."</b>:<br>";
		$vBooks .= "<ul>";
			for($b = 0; $b < count($vOrderDetailResult[0]); $b++){
				$vBooks .= "<li>".$vOrderDetailResult[4][$b]." x ".$vOrderDetailResult[6][$b]." - ".$vOrderDetailResult[8][$b]." @ R ".$vOrderDetailResult[3][$b]."</li>";
			}
		$vBooks .= "</ul>";

				$vMessageTop = MysqlQuery::getText($pConn, 301);/*Jou bestelling detail is as volg:*/
				$vMessage = "&nbsp;<b>".MysqlQuery::getText($pConn, 156)/*Verwysingsnommer*/."</b>: GRAF/".$pData['reference']."/".$pData['temp_salt']."<br>";
				$vMessage .= "&nbsp;<b>".MysqlQuery::getText($pConn, 147)/*Totale prys*/."</b>: R ".$vOrderResult[13][0]."<br>";
				$vMessage .= "&nbsp;<b>".$vShortDeliveryCostText."</b>: R ".$vOrderResult[11][0]."<br>";
				$vMessage .= "&nbsp;<b>".MysqlQuery::getText($pConn, 113)/*Betalingsmetode*/."</b>: ".MysqlQuery::getLookupPerId($pConn, $pPaymentType)."<br>";

				$vMessagePay .= "<br><div class=\"green\"><b><span class=\"blink red\">&nbsp;NB!</span>&nbsp;&nbsp;".MysqlQuery::getText($pConn, 455)/*Jy kan vir die bestelling betaal deur 'n Direkte oorbetaling (EFT) te doen.*/." ".MysqlQuery::getText($pConn, 407)/*Gebruik asseblief ABSA rekening hieronder en Bestel # as verwysing.*/."</b></div>";
				$vMessagePay .= "&nbsp;&nbsp;Graffiti Books &amp; Stationery<br>";
				$vMessagePay .= "&nbsp;&nbsp;ABSA<br>";
	    		$vMessagePay .= "&nbsp;&nbsp;BROOKLYN<br>";
	    		$vMessagePay .= "&nbsp;&nbsp;".MysqlQuery::getText($pConn, 408)/*REK #: 407 02 55 861*/."<br>";
	    		$vMessagePay .= "&nbsp;&nbsp;".MysqlQuery::getText($pConn, 409)/*TAK:  632 005*/."<br><hr>";

				if($vOrderResult[10][0] != 4){//Not collect
					$vMessage .= "<br><b>".MysqlQuery::getText($pConn, 288)/*Afleweringsadres*/."</b>:<br>".$vDeliveryAddress."<br>";
				}

			$vString .= "<form class=\"form-horizontal\" role=\"form\" id=\"orderConfirmation\">";
			$vString .= "<div id=\"form-border\">";
				$vString .= "<div id=\"center\">";
					$vString .= "<div class=\"form-header\">";
						$vString .="<div class=\"row\">";
							$vString .= "<div class=\"col-xs-12\">";
								$vString .= "<h1 class=\"red\">".$vHeading."</h1>";
								$vString .= "<h5 class=\"".$vClass."\">".$vHeadingText."</h5>";
								(!empty($vEmail) ? $vString .= "<a href=\"\" class=\"email\" title=\"Graffiti\">".$vEmail."</a><br>" : $vString .= "");
							$vString .= "</div>";
						$vString .= "</div>";
					$vString .= "</div>";//Header

					$vString .= "<div class=\"form-body\">";
							$vString .="<div class=\"row space-bottom-light\">";
								$vString .= "<div class=\"col-xs-12\">";
									(!empty($vMessagePay) ? $vString .= $vMessagePay : $vString .= "");
									(!empty($vMessageTop) ? $vString .= "<br><b class=\"green\">".$vMessageTop."</b>" : $vString .= "");
									(!empty($vBooks) ? $vString .= "<br>".$vBooks : $vString .= "");
									(!empty($vMessage) ? $vString .= "<br>".$vMessage : $vString .= "");
								$vString .= "<br></div>";
							$vString .="</div>";//row
					$vString .="</div>";//body

					$vString .= "<div class=\"form-footer\">";
						$vString .="<div class=\"row\">";
		                    $vString .="<div class=\"col-xs-12\">";
									$vString .= "<button type=\"button\" id=\"printForm\" data-src=\"orderConfirmation\" class=\"btn btn-primary\">".MysqlQuery::getText($pConn, 309)/*Druk bestelling info*/."</button>";
							$vString .="</div>";
						$vString .="</div>";
					$vString .="</div>";//footer

				$vString .= "</div>";//center
			$vString .= "</div>";//form-border
			$vString .= "</form>";
		//_________________________________________________________________________

      $vString .= "</script>";
				$json = "undefined";
				$arr = array(
					'payment_result' => 1,
					'payment_type' => $pPaymentType,
					'order_id' => $pData['reference'],
					'lang' => $pData['lang']
				);
				$json = json_encode($arr);

				$vString .="<Script>$(document).ready(function(){";
					$vString .="$.post('order_email.php', ".$json.", function(data){});";
					$vString .="});";
				$vString .="</Script>";

		return General::prepareStringForDisplay($vString);

	}

	public static function returnMorePages($pConn, $pTypeId, $pSort, $pLanguage){
		$vUrlData['page'] = RequestUtils::getParameter('page');
		$vUrlData['id'] = $pTypeId;
		$vUrlData['language'] = RequestUtils::getParameter('temp');
		$vUrlData['lang'] = RequestUtils::getParameter('temp');
		//$vUrlData['sort'] = $pSort;
		$vSort = $pSort;
		$vPageNo = RequestUtils::getParameter('pageno');

		//$vAutoDiscount = MysqlQuery::getAutoDiscount($pConn);
		//$vHeading = MysqlQuery::getText($pConn, $pTypeId);

		if($pTypeId == 208 || $pTypeId == 206 || $pTypeId == 446 || $pTypeId == 447){
			$vHeading = MysqlQuery::getCmsText($pConn, $pTypeId, "af")." / ".MysqlQuery::getCmsText($pConn, $pTypeId, "en");
			($pTypeId == 206 ? $vDisplayAll = 1 : $vDisplayAll = 0);
		}
		else {
			$vHeading = MysqlQuery::getCmsText($pConn, $pTypeId, $pLanguage);
		}

		$vUrl = "index.php?lang=".$_SESSION['SessionGrafLanguage']."&amp;page=".$vUrlData['page']."&amp;id=".$vUrlData['id']."&amp;temp=".urlencode($pLanguage)."&amp;rand=".urlencode($pSort);

		$vBindParams = array();
		$vBindLetters = "";
		$vType = "general";
		$per_page = 15;

		include_once "include/BookQueries.php";
		include_once "include/BookDisplay.php";

		return General::prepareStringForDisplay($vString);
	}

	public static function returnResultPages($pConn, $pSearchData){
		$vUrlData['page'] = $pSearchData['page'];
		$vUrlData['lang'] = $pSearchData['lang'];
		$vUrlData['cat'] = $pSearchData['cat'];
		$vUrlData['subcat'] = $pSearchData['subcat'];

		$pSort = $pSearchData['sort'];
		$vPageNo = RequestUtils::getParameter('pageno');
		//$vAutoDiscount = MysqlQuery::getAutoDiscount($pConn);

		if($pSearchData['type'] == "k" || $pSearchData['type'] == "ks"){
			$vHeading = MysqlQuery::getText($pConn, 207)/*Soekresultate*/.": ".General::str_highlight($vUrlData['cat'], $pSearchData['cat']);
			$vUrl = "index.php?lang=".$pSearchData['lang']."&amp;id=".$pSearchData['type']."&amp;page=".$pSearchData['page']."&amp;c_id=0&amp;sort=".$pSearchData['sort']."&amp;cat=".$pSearchData['cat'];
		}
		else if($pSearchData['type'] == "a"){
			$vHeading = MysqlQuery::getText($pConn, 207)/*Soekresultate*/.": ".General::str_highlight($vUrlData['cat'], $pSearchData['cat']);
			$vUrl = "index.php?lang=".$pSearchData['lang']."&amp;id=".$pSearchData['type']."&amp;page=".$pSearchData['page']."&amp;c_id=0&amp;sort=".$pSearchData['sort']."&amp;cat=".$pSearchData['cat'];
		}
		else if($pSearchData['type'] == "m"){
			$vUrlData['subcat_id'] = $pSearchData['subcat_id'];
			$vHeadingArray = MysqlQuery::getCategorySubCategoryFromSubCat($pConn, $pSearchData['subcat_id']);//$vSubCategory, $vCategory
			if($pSearchData['subcat_id'] == 164){//164 = Pens
				$vHeading = $vHeadingArray[0];
			}
			else {
				$vHeading = $vHeadingArray[1]."<br>".$vHeadingArray[0];
			}
			//index.php?page=$3&lang=$1&id=$2&c_id=$4&sort=$5&cat=$6&subcat=$7
			$vUrl = "index.php?lang=".$pSearchData['lang']."&amp;id=".$pSearchData['type']."&amp;page=".$pSearchData['page']."&amp;c_id=".$pSearchData['subcat_id']."&amp;sort=".$pSearchData['sort']."&amp;cat=".$pSearchData['cat']."&amp;subcat=".$pSearchData['subcat'];
		}
		else if ($pSearchData['type'] == "c"){
			$vUrlData['cat_id'] = $pSearchData['cat_id'];
			$vHeading = MysqlQuery::getCategoryPerId($pConn, $pSearchData['cat_id']);
			$vUrl = "index.php?lang=".$pSearchData['lang']."&amp;id=".$pSearchData['type']."&amp;page=".$pSearchData['page']."&amp;c_id=".$pSearchData['cat_id']."&amp;sort=".$pSearchData['sort']."&amp;cat=".$pSearchData['cat'];
		}
		else if ($pSearchData['type'] == "Moleskine"){
			$vHeading = MysqlQuery::getCategoryPerId($pConn, $pSearchData['cat_id'])."<br>". MysqlQuery::getSubCategorPerId($pConn, $pSearchData['subcat_id']);
			$vUrl = "index.php?lang=".$pSearchData['lang']."&amp;id=0&amp;page=".$pSearchData['page']."&amp;c_id=1&amp;sort=".$pSearchData['sort']."&amp;cat=".$pSearchData['cat'];
		}
		else if ($pSearchData['type'] == "Skryfbehoeftes" || $pSearchData['type'] == "Stationery"){
			$vHeading = MysqlQuery::getSubCategorPerId($pConn, $pSearchData['subcat_id']);
			$vUrl = "index.php?lang=".$pSearchData['lang']."&amp;id=".$pSearchData['type']."&amp;page=".$pSearchData['page']."&amp;c_id=".$pSearchData['cat_id']."&amp;cat=".$pSearchData['cat'];
		}
		if($pSearchData['type'] == "book-id"){
			$vHeading = General::prepareUrlForDisplay($pSearchData['title']);
		}
		if($pSearchData['type'] == "book-isbn"){
			$vHeading = General::prepareUrlForDisplay($pSearchData['title']);
		}
		$vBindParams = array();
		$vBindLetters = "";
		$vType = $pSearchData['type'];
		$per_page = 15;

		include_once "include/BookQueries.php";
		include_once "include/BookDisplay.php";

		return General::prepareStringForDisplay($vString);
	}

	public static function returnInfo($pConn, $pType, $pId){
		$vString = "";
		$vString .= "<form class=\"form-horizontal\" name=\"Form\" id=\"Form\" role=\"form\">";
			$vString .= "<div id=\"form-border\">";
				$vString .= "<div id=\"center\" class=\"tab-content\">";
					$vString .= "<div id=\"info\">";
							$vString .= "<div class=\"form-header\">";
								$vString .="<div class=\"row\">";
									$vString .= "<div class=\"col-xs-12\">";
										$vString .= "<h1 class=\"red\">".MysqlQuery::getLookupPerId($pConn, $pId)."</h1>";
									$vString .= "</div>";
								$vString .= "</div>";
							$vString .= "</div>";//Header
							$vString .= "<div class=\"form-body\">";
									$vString .="<div class=\"row\">";
										$vString .="<div class=\"form-group\">";
											$vString .= "<div class=\"col-xs-12\">";
												if($pId == 28){
													$vString .= "<h5 class=\"green\">Graffiti Zambezi Junction, Montana</h5>";
													$vString .= "<h6 class=\"blue\">".MysqlQuery::getText($pConn, 336)/*Adres: Winkel no 16, ...*/."</h6>";
													$vString .= "<h6 class=\"blue\">".MysqlQuery::getText($pConn, 337)/*Telefoonnommer: (012) 548 2356*/."</h6>";
													$vString .= "<h6 class=\"blue\">".MysqlQuery::getText($pConn, 338)/* Faksnommer: 086 590 4855*/."</h6>";
													$vString .= "<h6 class=\"blue\">".MysqlQuery::getText($pConn, 339)/*Navrae rakende bestellings:*/."&nbsp;<a href=\"mailto:\" class=\"email lower\" title=\"Graffiti\">orders at graffitibooks.co.za</a></h6>";
													$vString .= "<h6 class=\"blue\">".MysqlQuery::getText($pConn, 340)/*Webnavrae:/a>*/."&nbsp;<a href=\"mailto:\" class=\"email lower\" title=\"Graffiti\">orders at graffitibooks.co.za</a></h6>";
													$vString .= "<h6 class=\"blue\">".MysqlQuery::getText($pConn, 341)/*Algemene navrae:*/."&nbsp; <a href=\"mailto:\" class=\"email lower\" title=\"Graffiti\">info at graffitibooks.co.za</a></h6>";
													$vString .= "<br><iframe src=\"https://www.google.com/maps/d/embed?mid=1fXWYhrccvo87ALw0XhWeZ2wKv1E\" width=\"100%\" height=\"480\"></iframe>";
												}
												else if($pId == 29){
													$vString .= "<h5 class=\"green\">TODO</h5>";
												}
												else if($pId == 31){
													$vString .= "<h5 class=\"green\">TODO</h5>";
												}
												else if($pId == 32){
													$vString .= "<h6 class=\"blue\">".MysqlQuery::getText($pConn, 342)/* Maandae tot Vrydae: 09:00 - 18:00*/."</h6>";
													$vString .= "<h6 class=\"blue\">".MysqlQuery::getText($pConn, 357)/* Saterdae: 09:00 - 15:00*/."</h6>";
													$vString .= "<h6 class=\"blue\">".MysqlQuery::getText($pConn, 358)/* Sondae en Vakansiedae: 09:00 - 13:00*/."</h6>";
												}
												$vString .= "<hr class=\"light-gray\">";
											$vString .="</div>";
										$vString .="</div>";
									$vString .="</div>";//row
							$vString .= "</div>";//Body
					$vString .= "</div>";//info
				$vString .= "</div>";//center
			$vString .= "</div>";//form-border
		$vString .= "</form>";
		return General::prepareStringForDisplay($vString);
	}

	public static function returnLoadingPage($pConn){
		$vString = "";
		$vString .= "<form class=\"form-horizontal\" name=\"Load\" id=\"Load\" role=\"form\">";
			$vString .= "<div id=\"form-border\">";
				$vString .= "<div id=\"center\" class=\"tab-content\">";
					$vString .= "<div id=\"info\">";
							$vString .= "<div class=\"form-header\">";
								$vString .="<div class=\"row\">";
									$vString .= "<div class=\"col-xs-12\">";
										$vString .= "<h1 class=\"red\">".MysqlQuery::getText($pConn, 352)/* Jou bestelling word verwerk. */.".</h1>";
									$vString .= "</div>";
								$vString .= "</div>";
							$vString .= "</div>";//Header
							$vString .= "<div class=\"form-body\">";
									$vString .="<div class=\"row\">";
										$vString .="<div class=\"form-group\">";
											$vString .= "<div class=\"col-xs-12\">";
												$vString .= "<div class=\"blue\">".MysqlQuery::getText($pConn, 353)/*Wees asseblief geduldig. Moet nie die blad herlaai nie... */."</div>";
												$vString .= "<br><br>";
												$vString .= "<div class=\"col-center\"><img src=\"images/preloader.gif\" height=\"64\" width=\"64\" alt=\"load\"></div>";
											$vString .="</div>";
										$vString .="</div>";
									$vString .="</div>";//row
							$vString .= "</div>";//Body
					$vString .= "</div>";//info
				$vString .= "</div>";//center
			$vString .= "</div>";//form-border
		$vString .= "</form>";
		return General::prepareStringForDisplay($vString);
	}

	public static function returnEvents($pConn, $pTemp){
		$vFOrder = "ORDER BY date ASC";
		$vFBindParams = array();
		$vFBindLetters = "s";
		$vFBindParams[] = & $_SESSION['now_date'];
		$vFLimit = "LIMIT 10";
		$vFWhere = "WHERE date >= ?";
		$vFResults = MysqlQuery::getEvents($pConn, $vFWhere, $vFOrder, $vFBindLetters,  $vFBindParams, $vFLimit);

		$vPOrder = "ORDER BY date DESC";
		$vPBindParams = array();
		$vPBindLetters = "s";
		$vPBindParams[] = & $_SESSION['now_date'];
		$vPLimit = "LIMIT 10";
		$vPWhere = "WHERE date < ?";
		$vPResults = MysqlQuery::getEvents($pConn, $vPWhere, $vPOrder, $vPBindLetters,  $vPBindParams, $vPLimit);

		$vString = "";
		$vString .= "<form class=\"form-horizontal\" name=\"eventsForm\" id=\"eventsForm\" role=\"form\">";
			$vString .= "<div id=\"form-border\">";
				$vString .= "<div id=\"center\" class=\"tab-content\">";
					  $vString .= "<ul class=\"nav nav-tabs\">";
					    $vString .= "<li";
					    	($pTemp == 1 ?  $vString .= " class=\"active\"" : $vString .= "");
					    $vString .="><a class=\"text-small red-menu\" data-toggle=\"tab\" href=\"#future-book\" title=\"".MysqlQuery::getText($pConn, 343)/*Toekomstige bekendstellings*/."\">".MysqlQuery::getText($pConn, 343)/*Toekomstige bekendstellings*/."</a></li>";
					    $vString .= "<li";
					    	($pTemp == 2 ?  $vString .= " class=\"active\"" : $vString .= "");
					    $vString .="><a class=\"text-small red-menu\" data-toggle=\"tab\" href=\"#past-book\" title=\"".MysqlQuery::getText($pConn, 344)/*Vorige bekendstellings*/."\">".MysqlQuery::getText($pConn, 344)/*Vorige bekendstellings*/."</a></li>";
					 $vString .= "</ul>";

					$vString .= "<div id=\"future-book\" class=\"tab-pane fade";
						($pTemp == 1 ? $vString .= " in active" : $vString .= "");
					$vString .= "\" >";
							$vString .= "<div class=\"form-header\">";
								$vString .="<div class=\"row\">";
									$vString .= "<div class=\"col-xs-12\">";
										$vString .= "<h1 class=\"red\">".MysqlQuery::getText($pConn, 345)/*Boekbekendstellings*/."</h1>";
									$vString .= "</div>";
								$vString .= "</div>";
							$vString .= "</div>";//Header
							$vString .= "<div class=\"form-body\">";
									if(count($vFResults[0]) > 0){
											for($x = 0; $x < count($vFResults[0]); $x++){
												$vString .= Modal::loadEventInfo($pConn, $vFResults[0][$x] , $vFResults[1][$x], $vFResults[2][$x], $vFResults[3][$x], $vFResults[4][$x], $vFResults[5][$x], $vFResults[6][$x], $vFResults[7][$x], $vFResults[8][$x]);
												$vString .="<div class=\"row\">";
													$vString .="<div class=\"form-group\">";
														$vString .= "<div class=\"col-xs-3 row-grid col-center\">";
															if(!empty($vFResults[8][$x])){
																$vString .= "<a href=\"images/posters/".$vFResults[8][$x]."\" data-lightbox=\"img_".$vFResults[8][$x]."\" data-title=\"".$vFResults[1][$x]."\" title=\"".$vFResults[1][$x]."\">";
																	$vString .= "<img id=\"".$vFResults[0][$x]."\" src=\"images/posters/".$vFResults[8][$x]."\" class=\"img-responsive cart-thumb thumb special-border \" alt=\"".MysqlQuery::getText($pConn, 311)/*Klik om te vergroot*/."\" title=\"".MysqlQuery::getText($pConn, 311)/*Klik om te vergroot*/."\">";
																$vString .= "</a>";
															}
															//$vString .= "<hr class=\"light-gray\">";
														$vString .="</div>";
														$vString .= "<div class=\"col-xs-9\">";
															$vString .= "<h5 class=\"green\">".date('d M Y', strtotime($vFResults[3][$x]))." - ".$vFResults[1][$x]."</h5>";
															$vString .= "<a href=\"#event_".$vFResults[0][$x]."\" role=\"button\" data-toggle=\"modal\" class=\"text-small red\" title=\"".MysqlQuery::getText($pConn, 38)/*Meer inligting*/."\"><button type=\"button\"  data-toggle=\"modal\" data-src=\"".$vFResults[0][$x]."\" class=\"btn btn-primary\">".MysqlQuery::getText($pConn, 38)/*Meer inligting*/."</button></a>";
															//$vString .= "<hr class=\"light-gray\">";
														$vString .="</div>";
													$vString .="</div>";
												$vString .="</div>";//row
											}
									}
									else {
										$vString .="<div class=\"row\">";
											$vString .= "<div class=\"form-group\">";
												$vString .= "<div class=\"col-xs-12\">";
													$vString .= "<h5 class=\"gray\">".MysqlQuery::getText($pConn, 21)/*Jammer, geen resultate is gevind nie!*/."</h5>";
													$vString .= "<hr class=\"light-gray\">";
												$vString .="</div>";
											$vString .="</div>";
										$vString .="</div>";
									}
							$vString .= "</div>";//Body
					$vString .= "</div>";//future

					$vString .= "<div id=\"past-book\" class=\"tab-pane fade";
						($pTemp == 2 ? $vString .= " in active" : $vString .= "");
					$vString .= "\" >";
							$vString .= "<div class=\"form-header\">";
								$vString .="<div class=\"row\">";
									$vString .= "<div class=\"col-xs-12\">";
										$vString .= "<h1 class=\"red\">".MysqlQuery::getText($pConn, 345)/*Boekbekendstellings*/."</h1>";
									$vString .= "</div>";
								$vString .= "</div>";
							$vString .= "</div>";//Header
							$vString .= "<div class=\"form-body\">";
										if(count($vPResults[0]) > 0){
											for($x = 0; $x < count($vPResults[0]); $x++){
												$vImageResults = MysqlQuery::getEventImages($pConn, $vPResults[0][$x]);//$vId, $vEventId, $vBlobPath
												$vString .= Modal::loadEventInfo($pConn, $vPResults[0][$x] , $vPResults[1][$x], $vPResults[2][$x], $vPResults[3][$x], $vPResults[4][$x], $vPResults[5][$x], $vPResults[6][$x], $vPResults[7][$x], $vPResults[8][$x]);
												$vString .="<div class=\"row\">";
													$vString .="<div class=\"form-group\">";
													(count($vImageResults[0]) > 0 || !empty($vPResults[8][$x]) ? $vBanner = "imageEvent_".$vPResults[0][$x] : $vBanner = "");
														$vString .= "<div class=\"col-xs-3 row-grid col-center\"  id=\"".$vBanner."\">";
															if(!empty($vPResults[8][$x]) && count($vImageResults[0]) > 0){
																for($i = 0; $i < count($vImageResults[0]); $i++){
																	($i >= 1 ? $vClass = "no-display"  : $vClass = "");
									                        		$vString .= "<a href=\"images/events/".$vImageResults[2][$i]."\" data-lightbox=\"event".$vPResults[0][$x]."\" data-title=\"".$vImageResults[3][$i]."\" title=\"".$vImageResults[3][$i]."\">";
									                        			$vString .= "<img id=\"photo_".$vPResults[0][$x]."\" src=\"images/events/".$vImageResults[2][$i]."\" class=\"img-responsive cart-thumb thumb special-border ".$vClass."\" alt=\"".$vImageResults[3][$i]."\">";
									                                $vString .= "</a>";
																}
																if(!empty($vPResults[8][$x])){
									                        		$vString .= "<a href=\"images/posters/".$vPResults[8][$x]."\" data-lightbox=\"event".$vPResults[0][$x]."\" title=\"".$vPResults[1][$x]."\">";
									                        			$vString .= "<img id=\"poster_".$vPResults[0][$x]."\" src=\"images/posters/".$vPResults[8][$x]."\" title=\"".$vPResults[1][$x]."\" alt=\"".$vPResults[1][$x]."\" class=\"img-responsive cart-thumb thumb no-display special-border\">";
									                                $vString .= "</a>";
																}
																$vString .= "<h2 id=\"photoBanner_".$vPResults[0][$x]."\">".MysqlQuery::getText($pConn, 397)/*Klik om meer foto's te sien*/."</h2>";
															}
														$vString .="</div>";
														$vString .= "<div class=\"col-xs-9\">";
															$vString .= "<h5 class=\"green\">".date('d M Y', strtotime($vPResults[3][$x]))." - ".$vPResults[1][$x]."</h5>";
															$vString .= "<a href=\"#event_".$vPResults[0][$x]."\" role=\"button\" data-toggle=\"modal\" class=\"text-small red\" title=\"".MysqlQuery::getText($pConn, 38)/*Meer inligting*/."\"><button type=\"button\"  data-toggle=\"modal\" data-src=\"".$vPResults[0][$x]."\" class=\"btn btn-primary\">".MysqlQuery::getText($pConn, 38)/*Meer inligting*/."</button></a>";
															//$vString .= "<hr class=\"light-gray\">";
														$vString .="</div>";
													$vString .="</div>";
												$vString .="</div>";//row
											}
									}
									else {
										$vString .="<div class=\"row\">";
											$vString .= "<div class=\"form-group\">";
												$vString .= "<div class=\"col-xs-12\">";
													$vString .= "<h5 class=\"gray\">".MysqlQuery::getText($pConn, 21)/*Jammer, geen resultate is gevind nie!*/."</h5>";
													$vString .= "<hr class=\"light-gray\">";
												$vString .="</div>";
											$vString .="</div>";
										$vString .="</div>";
									}
							$vString .= "</div>";//Body
					$vString .= "</div>";//past

					$vString .= "</div>";//center
				$vString .= "</div>";//form-border
			$vString .= "</form>";

		return General::prepareStringForDisplay($vString);
	}

	public static function returnNewsletters($pConn, $pData){
		if(empty($pData['dir'])){
			$vDirectory = "documents/newsletters";
		}
		else {
			$vDirectory = $pData['dir'];
		}

		$vFiles = General::listDirectoryFiles($vDirectory);
		// $vFileSize, $vFileName, $vFileUrl

		$vString = "";
		$vString .= "<form class=\"form-horizontal\" name=\"newsletterForm\" id=\"newsletterForm\">";
			$vString .= "<div id=\"form-border\">";
				$vString .= "<div id=\"center\">";
					$vString .= "<div id=\"info\">";
							$vString .= "<div class=\"form-header\">";
								$vString .="<div class=\"row\">";
									$vString .= "<div class=\"col-xs-12\">";
										$vString .= "<h1 class=\"red\">".MysqlQuery::getText($pConn, 351)/*Nuusbriewe*/."</h1>";
									$vString .= "</div>";
								$vString .= "</div>";
							$vString .= "</div>";//Header
							$vString .= "<div class=\"form-body\">";

								if(count($vFiles[0]) > 0){
									for($x = 0; $x < count($vFiles[0]); $x++){
									$vString .="<div class=\"row\">";
										$vString .="<div class=\"form-group\">";
											$vString .= "<div class=\"col-xs-12  thumb-book-image\">";
												$vString .= "<a href=\"".$_SESSION['SessionGrafFullServerUrl'].$vDirectory."/".$vFiles[2][$x]."\" target=\"_blank\"><i class=\"fa fa-file-pdf-o red fa-lg space-right\" aria-hidden=\"true\"></i></a>";
												$vString .= "<a href=\"".$_SESSION['SessionGrafFullServerUrl'].$vDirectory."/".$vFiles[2][$x]."\" target=\"_blank\">".MysqlQuery::getText($pConn, 215)/*Nuusbriewe*/." ".$vFiles[1][$x]."</a> (".$vFiles[0][$x].")";
											$vString .= "</div>";
										$vString .="</div>";
									$vString .="</div>";//row
									}
								}
								else {
									$vString .="<div class=\"row\">";
										$vString .= "<div class=\"form-group\">";
											$vString .= "<div class=\"col-xs-12\">";
												$vString .= "<h5 class=\"gray\">".MysqlQuery::getText($pConn, 21)/*Jammer, geen resultate is gevind nie!*/."</h5>";
												$vString .= "<hr class=\"light-gray\">";
											$vString .="</div>";
										$vString .="</div>";
									$vString .="</div>";
								}

							$vString .= "</div>";//body
					$vString .= "</div>";//info
				$vString .= "</div>";//center
			$vString .= "</div>";//form-border
		$vString .= "</form>";

		return General::prepareStringForDisplay($vString);
	}

   public static function getSitemapXML($pConn){
   		$vDate = date('c',time());
	    $domtree  = new DOMDocument('1.0', 'UTF-8');

		$xmlRoot = $domtree->createElement("urlset");
		$xmlRoot -> appendChild(new DomAttr('xmlns',  'http://www.sitemaps.org/schemas/sitemap/0.9'));
		$xmlRoot -> appendChild(new DomAttr('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance'));
		$xmlRoot -> appendChild(new DomAttr('xsi:schemaLocation', 'http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd'));

		$xmlRoot = $domtree->appendChild($xmlRoot);

	    $domtree->formatOutput = true;

	    $newUrl= $domtree->createElement("url");
	    $newUrl = $xmlRoot->appendChild($newUrl);
	    $newUrl->appendChild($domtree->createElement('loc','https://www.graffitibooks.co.za/'));
	    $newUrl->appendChild($domtree->createElement('lastmod',$vDate));
	    $newUrl->appendChild($domtree->createElement('changefreq','daily'));
	    $newUrl->appendChild($domtree->createElement('priority','1.0'));

	    $newUrl= $domtree->createElement("url");
	    $newUrl = $xmlRoot->appendChild($newUrl);
	    $newUrl->appendChild($domtree->createElement('loc','https://www.graffitibooks.co.za/en/Home'));
	    $newUrl->appendChild($domtree->createElement('lastmod',$vDate));
	    $newUrl->appendChild($domtree->createElement('changefreq','daily'));
	    $newUrl->appendChild($domtree->createElement('priority','1.0'));
	    $newUrl= $domtree->createElement("url");
	    $newUrl = $xmlRoot->appendChild($newUrl);
	    $newUrl->appendChild($domtree->createElement('loc','https://www.graffitibooks.co.za/af/Tuis'));
	    $newUrl->appendChild($domtree->createElement('lastmod',$vDate));
	    $newUrl->appendChild($domtree->createElement('changefreq','daily'));
	    $newUrl->appendChild($domtree->createElement('priority','1.0'));

	    $newUrl= $domtree->createElement("url");
	    $newUrl = $xmlRoot->appendChild($newUrl);
	    $newUrl->appendChild($domtree->createElement('loc','https://www.graffitibooks.co.za/en/0/BookLaunches/1'));
	    $newUrl->appendChild($domtree->createElement('lastmod',$vDate));
	    $newUrl->appendChild($domtree->createElement('changefreq','monthly'));
	    $newUrl->appendChild($domtree->createElement('priority','1.0'));
	    $newUrl= $domtree->createElement("url");

	    $newUrl = $xmlRoot->appendChild($newUrl);
	    $newUrl->appendChild($domtree->createElement('loc','https://www.graffitibooks.co.za/af/0/Boekbekendstellings/1'));
	    $newUrl->appendChild($domtree->createElement('lastmod',$vDate));
	    $newUrl->appendChild($domtree->createElement('changefreq','monthly'));
	    $newUrl->appendChild($domtree->createElement('priority','1.0'));

	    $newUrl= $domtree->createElement("url");
	    $newUrl = $xmlRoot->appendChild($newUrl);
	    $newUrl->appendChild($domtree->createElement('loc','https://www.graffitibooks.co.za/af/204/NuweVrystellings/af/new_rank ASC, date_publish DESC'));
	    $newUrl->appendChild($domtree->createElement('lastmod',$vDate));
	    $newUrl->appendChild($domtree->createElement('changefreq','daily'));
	    $newUrl->appendChild($domtree->createElement('priority','1.0'));
	    $newUrl= $domtree->createElement("url");

	    $newUrl = $xmlRoot->appendChild($newUrl);
	    $newUrl->appendChild($domtree->createElement('loc','https://www.graffitibooks.co.za/af/209/Topverkopers/af/top_seller_rank ASC, date_publish DESC'));
	    $newUrl->appendChild($domtree->createElement('lastmod',$vDate));
	    $newUrl->appendChild($domtree->createElement('changefreq','daily'));
	    $newUrl->appendChild($domtree->createElement('priority','1.0'));

	    $newUrl= $domtree->createElement("url");
	    $newUrl = $xmlRoot->appendChild($newUrl);
	    $newUrl->appendChild($domtree->createElement('loc','https://www.graffitibooks.co.za/af/204/NewReleases/en/new_rank ASC, date_publish DESC'));
	    $newUrl->appendChild($domtree->createElement('lastmod',$vDate));
	    $newUrl->appendChild($domtree->createElement('changefreq','daily'));
	    $newUrl->appendChild($domtree->createElement('priority','1.0'));

	    $newUrl= $domtree->createElement("url");
	    $newUrl = $xmlRoot->appendChild($newUrl);
	    $newUrl->appendChild($domtree->createElement('loc','https://www.graffitibooks.co.za/af/209/Bestsellers/en/top_seller_rank ASC, date_publish DESC'));
	    $newUrl->appendChild($domtree->createElement('lastmod',$vDate));
	    $newUrl->appendChild($domtree->createElement('changefreq','daily'));
	    $newUrl->appendChild($domtree->createElement('priority','1.0'));

	    $newUrl= $domtree->createElement("url");
	    $newUrl = $xmlRoot->appendChild($newUrl);
	    $newUrl->appendChild($domtree->createElement('loc','https://www.graffitibooks.co.za/af/446/NuutKinders-NewChildren/all/new_rank ASC, date_publish DESC'));
	    $newUrl->appendChild($domtree->createElement('lastmod',$vDate));
	    $newUrl->appendChild($domtree->createElement('changefreq','daily'));
	    $newUrl->appendChild($domtree->createElement('priority','1.0'));

	    $newUrl= $domtree->createElement("url");
	    $newUrl = $xmlRoot->appendChild($newUrl);
	    $newUrl->appendChild($domtree->createElement('loc','https://www.graffitibooks.co.za/af/447/TopverkopersKinders-BestsellersChildren/all/top_seller_rank ASC, date_publish DESC'));
	    $newUrl->appendChild($domtree->createElement('lastmod',$vDate));
	    $newUrl->appendChild($domtree->createElement('changefreq','daily'));
	    $newUrl->appendChild($domtree->createElement('priority','1.0'));


	    $newUrl= $domtree->createElement("url");
	    $newUrl = $xmlRoot->appendChild($newUrl);
	    $newUrl->appendChild($domtree->createElement('loc','https://www.graffitibooks.co.za/af/208/Winskopies-Specials/all/date_publish DESC'));
	    $newUrl->appendChild($domtree->createElement('lastmod',$vDate));
	    $newUrl->appendChild($domtree->createElement('changefreq','daily'));
	    $newUrl->appendChild($domtree->createElement('priority','1.0'));

	    $newUrl= $domtree->createElement("url");
	    $newUrl = $xmlRoot->appendChild($newUrl);
	    $newUrl->appendChild($domtree->createElement('loc','https://www.graffitibooks.co.za/af/206/Binnekort-ComingSoon/all/soon_rank ASC, date_publish ASC'));
	    $newUrl->appendChild($domtree->createElement('lastmod',$vDate));
	    $newUrl->appendChild($domtree->createElement('changefreq','daily'));
	    $newUrl->appendChild($domtree->createElement('priority','1.0'));

	    $newUrl= $domtree->createElement("url");
	    $newUrl = $xmlRoot->appendChild($newUrl);
	    $newUrl->appendChild($domtree->createElement('loc','https://www.graffitibooks.co.za/en/28/Info/ContactUs'));
	    $newUrl->appendChild($domtree->createElement('lastmod',$vDate));
	    $newUrl->appendChild($domtree->createElement('changefreq','yearly'));
	    $newUrl->appendChild($domtree->createElement('priority','1.0'));

	    $newUrl= $domtree->createElement("url");
	    $newUrl = $xmlRoot->appendChild($newUrl);
	    $newUrl->appendChild($domtree->createElement('loc','https://www.graffitibooks.co.za/af/28/Info/KontakOns'));
	    $newUrl->appendChild($domtree->createElement('lastmod',$vDate));
	    $newUrl->appendChild($domtree->createElement('changefreq','yearly'));
	    $newUrl->appendChild($domtree->createElement('priority','1.0'));

	    $newUrl= $domtree->createElement("url");
	    $newUrl = $xmlRoot->appendChild($newUrl);
	    $newUrl->appendChild($domtree->createElement('loc','https://www.graffitibooks.co.za/en/30/Info/TermsConditions'));
	    $newUrl->appendChild($domtree->createElement('lastmod',$vDate));
	    $newUrl->appendChild($domtree->createElement('changefreq','yearly'));
	    $newUrl->appendChild($domtree->createElement('priority','1.0'));
	    $newUrl= $domtree->createElement("url");
	    $newUrl = $xmlRoot->appendChild($newUrl);
	    $newUrl->appendChild($domtree->createElement('loc','https://www.graffitibooks.co.za/af/30/Info/BepalingsVoorwaardes'));
	    $newUrl->appendChild($domtree->createElement('lastmod',$vDate));
	    $newUrl->appendChild($domtree->createElement('changefreq','yearly'));
	    $newUrl->appendChild($domtree->createElement('priority','1.0'));

	    $newUrl= $domtree->createElement("url");
	    $newUrl = $xmlRoot->appendChild($newUrl);
	    $newUrl->appendChild($domtree->createElement('loc','https://www.graffitibooks.co.za/en/32/Info/ShoppingHours'));
	    $newUrl->appendChild($domtree->createElement('lastmod',$vDate));
	    $newUrl->appendChild($domtree->createElement('changefreq','yearly'));
	    $newUrl->appendChild($domtree->createElement('priority','1.0'));
	    $newUrl= $domtree->createElement("url");
	    $newUrl = $xmlRoot->appendChild($newUrl);
	    $newUrl->appendChild($domtree->createElement('loc','https://www.graffitibooks.co.za/af/32/Info/WinkelUre'));
	    $newUrl->appendChild($domtree->createElement('lastmod',$vDate));
	    $newUrl->appendChild($domtree->createElement('changefreq','yearly'));
	    $newUrl->appendChild($domtree->createElement('priority','1.0'));

    	$vCategories = MysqlQuery::getCategories($pConn, 1, 1);//$vCategoryId, $vCategory
    	for($c = 0; $c < count($vCategories[0]); $c++){
    		$vSubCategories = MysqlQuery::getSubCategories($pConn, $vCategories[0][$c], 1, 1);//$vSubCategoryId, $vSubCategory
    		for($s = 0; $s < count($vSubCategories[0]); $s++){
		    	$newUrl= $domtree->createElement("url");
			    $newUrl = $xmlRoot->appendChild($newUrl);
			    $newUrl->appendChild($domtree->createElement('loc',"https://www.graffitibooks.co.za/en/m/Search/".$vSubCategories[0][$s]."/date_publish+DESC/".General::prepareStringForUrl($vCategories[1][$c])."/".General::prepareStringForUrl($vSubCategories[1][$s]).""));
			    $newUrl->appendChild($domtree->createElement('lastmod',$vDate));
			    $newUrl->appendChild($domtree->createElement('changefreq','daily'));
			    $newUrl->appendChild($domtree->createElement('priority','1.0'));
			    $newUrl= $domtree->createElement("url");
			    $newUrl = $xmlRoot->appendChild($newUrl);
			    $newUrl->appendChild($domtree->createElement('loc',"https://www.graffitibooks.co.za/af/m/Soek/".$vSubCategories[0][$s]."/date_publish+DESC/".General::prepareStringForUrl($vCategories[1][$c])."/".General::prepareStringForUrl($vSubCategories[1][$s]).""));
			    $newUrl->appendChild($domtree->createElement('lastmod',$vDate));
			    $newUrl->appendChild($domtree->createElement('changefreq','daily'));
			    $newUrl->appendChild($domtree->createElement('priority','1.0'));
    		}
    	}
       	$vBooks = MysqlQuery::getBooksSitemap($pConn);//$vId, $vTitle, $vAuthor
    	for($x = 0; $x < count($vBooks[0]); $x++){
	    	$newUrl= $domtree->createElement("url");
		    $newUrl = $xmlRoot->appendChild($newUrl);
		    $newUrl->appendChild($domtree->createElement('loc',"https://www.graffitibooks.co.za/en/".$vBooks[0][$x]."/Book/".General::prepareStringForUrl($vBooks[1][$x]).""));
		    $newUrl->appendChild($domtree->createElement('lastmod',$vDate));
		    $newUrl->appendChild($domtree->createElement('changefreq','daily'));
		    $newUrl->appendChild($domtree->createElement('priority','1.0'));
		    $newUrl= $domtree->createElement("url");
		    $newUrl = $xmlRoot->appendChild($newUrl);
		    $newUrl->appendChild($domtree->createElement('loc',"https://www.graffitibooks.co.za/af/".$vBooks[0][$x]."/Boek/".General::prepareStringForUrl($vBooks[1][$x]).""));
		    $newUrl->appendChild($domtree->createElement('lastmod',$vDate));
		    $newUrl->appendChild($domtree->createElement('changefreq','daily'));
		    $newUrl->appendChild($domtree->createElement('priority','1.0'));
    	}

	    $xmlOutput = $domtree->saveXML();
	    $domtree->save("sitemap.xml");

	    echo "Done";
    }

	public static function returnTv($pConn, $pPage, $pSearchData){
		$vPageNo = RequestUtils::getParameter('pageno');
		$vDate = $_SESSION['date_min_one_month'];
		$vValue = 1;
		$vUrl = "index.php?lang=".$_SESSION['SessionGrafLanguage']."&amp;page=".$pPage;
		$per_page = 15;
		$vBindParams = array();
		$vBindLetters = "";

		$vBindLetters .= "i";
		$vBindParams[] = & $vValue;
		$vBindLetters .= "s";
		$vBindParams[] = & $vDate;
		$vWhere = "WHERE b.tv = ? AND b.tv_date > ?";
		$vOrder = "ORDER BY b.tv_date desc";
		$pSort = "b.tv_date desc";

		$vHeading = "Die Groot Ontbyt Boeke";

		$vWindowValues = General::echoWalkingWindowTopSearch($pConn, $per_page, $vPageNo, $vUrl, "id", "books b", $vWhere, $vBindLetters, $vBindParams);
		$vResults = MysqlQuery::getBooks($pConn, $vWhere, $vOrder, $vBindLetters,  $vBindParams, $vWindowValues[4]);
		$vVideoDates = implode("','", array_unique($vResults[37]));
		$vVideoResults = MysqlQuery::getTvVideos($pConn, $vVideoDates);//$vId, $vDate, $vUrl

		include_once "include/BookDisplay.php";

		return General::prepareStringForDisplay($vString);
	}

	public static function returnRr($pConn, $pPage, $pSearchData){
		$vPageNo = RequestUtils::getParameter('pageno');
		$vDate = $_SESSION['date_min_two_month'];
		$vValue = 1;
		$vUrl = "index.php?lang=".$_SESSION['SessionGrafLanguage']."&amp;page=".$pPage;
		$per_page = 30;
		$vBindParams = array();
		$vBindLetters = "";

		$vBindLetters .= "i";
		$vBindParams[] = & $vValue;
		$vBindLetters .= "s";
		$vBindParams[] = & $vDate;
		$vWhere = "WHERE b.rr = ? AND b.rr_date > ?";
		$vOrder = "ORDER BY title ASC";
		$pSort = "title ASC";

		//$vHeading = "rooi rose";
		$vHeading = "30 VIR 30";

		$vWindowValues = General::echoWalkingWindowTopSearch($pConn, $per_page, $vPageNo, $vUrl, "id", "books b", $vWhere, $vBindLetters, $vBindParams);
		$vResults = MysqlQuery::getBooks($pConn, $vWhere, $vOrder, $vBindLetters,  $vBindParams, $vWindowValues[4]);
		$vRrDates = implode("','", array_unique($vResults[40]));
		$vRrResults = MysqlQuery::getRrImages($pConn, $vRrDates);//$vId, $vDate, $vBlobPath, $vBookId

		include_once "include/BookDisplay.php";

		return General::prepareStringForDisplay($vString);
	}

    public static function returnCompetitions($pConn){
        $vOrder = "ORDER BY date_end desc";
//        $vValue = $_SESSION['date_min_one_month'];
        $vValue2 = 1;
        $vBindParams = array();
//        $vBindLetters = "si";
        $vBindLetters = "i";
//        $vBindParams[] =& $vValue;
        $vBindParams[] =& $vValue2;
        $vLimit = " LIMIT 10";
//        $vWhere = " WHERE date_end > ? AND valid = ?";
        $vWhere = " WHERE valid = ?";
        $vResults = MysqlQuery::getCompetitions($pConn, $vWhere, $vOrder, $vBindLetters, $vBindParams, $vLimit);
        $vString = "";
//		$vString = "<form class='form-horizontal' name='compForm' id='compForm' role='form'>";
			$vString .= "<div id='form-border'>";
                $vString .="<div class='row'>";
                    $vString .= "<div class='col-xs-12 col-md-10'>";
                        $vString .= "<h1 class='red'>".MysqlQuery::getText($pConn, 487)/*Kompetisies*/."</h1>";
                    $vString .= "</div>";
                $vString .= "</div>";
                if(isset($vResults['id']) && count($vResults['id']) > 0){
                    for($x = 0; $x < count($vResults['id']); $x++){
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
                            $vWinners = implode("<br>-&nbsp;", $vResultsWinner['winner_display']);
                        }
                        else{
                            $vWinners = "";
                        }
                        //$id, $name, $date_created, $date_end, $description, $blob_path, $winner, $valid
                        $vString .= "";
                        $vString .="<div class='row space-top'>";
                            $vString .= "<div class='col-xs-12 col-md-10'>";
                                $vString .= "<h5 class='green'>".$vResults['name'][$x]."</h5>";
                            $vString .="</div>";
                        $vString .="</div>";
                        $vString .="<div class='row'>";
                            $vString .= "<div class='col-xs-12 col-md-10 space-left'>";
                            if($vResults['date_end'][$x] > $_SESSION['date_now']) {
                                $vString .= "<h5 class='text-small-normal green'>" . MysqlQuery::getText($pConn, 488)/*Sluitingsdatum*/ . ": " . $vResults['date_end'][$x] . "</h5>";
                            }
                            else if($vResults['date_end'][$x] <= $_SESSION['date_now']){
                                $vString .= "<h5 class='text-small-normal red'>" . MysqlQuery::getText($pConn, 488)/*Sluitingsdatum*/ . ": " . $vResults['date_end'][$x] . "</h5>";
                            }
                            $vString .="</div>";
                        $vString .="</div>";
                        $vString .="<div class='row info-detail' style='border-bottom: #d6d6d6 1px solid; padding-bottom: 20px;'>";
                            $vString .= "<div class='col-xs-10 col-md-5'>";
                                if(!empty($vResults['blob_path'][$x])){
                                    $vString .= "<a href='images/competitions/".$vResults['blob_path'][$x]."' data-lightbox='img_".$vResults['blob_path'][$x]."' data-title='Graffiti'>";
                                        $vString .= "<img id='".$vResults['id'][$x]."' src='images/competitions/".$vResults['blob_path'][$x]."' class='img-responsive thumb special-border ' alt='".MysqlQuery::getText($pConn, 311)/*Klik om te vergroot*/."' title='".MysqlQuery::getText($pConn, 311)/*Klik om te vergroot*/."'>";
                                    $vString .= "</a>";
                                }
                            $vString .="</div>";
                            $vString .= "<div class='col-xs-10 col-md-7 dgreen text-left space-top'>";
                                $vString .= $vResults['description'][$x];
                                if($vResults['date_end'][$x] > $_SESSION['date_now']){
                                    $vString .= "<br><a id='enter_comp_".$vResults['id'][$x]."' data-id='".$vResults['id'][$x]."' class='btn btn-primary space-top' role='button' title='".MysqlQuery::getText($pConn, 489)/*Skryf in*/."'>".MysqlQuery::getText($pConn, 489)/*Skryf in*/."</a>";
                                    $vString .= "<div class='no-display' id='comp_entry_".$vResults['id'][$x]."'>";
                                        $vString .="<div class='row space-top'>";
                                            $vString .= "<div class='col-xs-6 col-md-10 space-bottom'>";
                                                $vString .= "<label class='gray required' style='width:80px;'>".MysqlQuery::getText($pConn, 64)/*Naam*/.": </label><input type='text' name='comp_name' id='comp_name".$vResults['id'][$x]."' size='25' value='' placeholder='' maxlength='50' class='text-small-normal'>";
                                                $vString .= "<br><label class='gray required' style='width:80px;'>".MysqlQuery::getText($pConn, 65)/*Van*/.": </label><input type='text' name='comp_surname' id='comp_surname".$vResults['id'][$x]."' size='25' value='' placeholder='' maxlength='50' class='text-small-normal'>";
                                                $vString .= "<br><label class='gray required' style='width:80px;'>".MysqlQuery::getText($pConn, 490)/*E-pos*/.": </label><input type='email' name='comp_email' id='comp_email".$vResults['id'][$x]."' size='25' value='' placeholder='' maxlength='50' class='text-small-normal'>";
                                                $vString .= "<br><input type='checkbox' value='1' name='comp_agree' id='comp_agree".$vResults['id'][$x]."' checked><label class='green required'>&nbsp;&nbsp;&nbsp;".MysqlQuery::getText($pConn, 101)/*Ek wil graag die Graffiti Nuusbrief ontvang*/."</label>";
                                                $vString .= "<span>";
                                                    $vString .= "<div id='entrySuccess".$vResults['id'][$x]."' class='success'>".MysqlQuery::getText($pConn, 492)/*Inskrywing suksesvol gelaai!*/."</div>";
                                                    $vString .= "<div id='entryError".$vResults['id'][$x]."' class='error'>".MysqlQuery::getText($pConn, 493)/*Inskrywing nie suksesvol!*/."</div>";
                                                    $vString .= "<div id='entryDouble".$vResults['id'][$x]."' class='error'>".MysqlQuery::getText($pConn, 494)/*Jy het reeds ingeskryf*/."</div>";
                                                    $vString .= "<div id='entryComplete".$vResults['id'][$x]."' class='error'>".MysqlQuery::getText($pConn, 243)/*Voltooi asseblief die verpligte velde.*/."</div>";
                                                $vString .= "</span>";
                                                $vString .= "<input type='hidden' id='name" . $vResults['id'][$x] . "' name='name' value=''>";
                                                $vString .= "<input type='hidden' id='id" . $vResults['id'][$x] . "' name='id' value=''>";
                                                $vString .= "<br><input type='button' class='btn btn-success btn-xsmall' data-id='".$vResults['id'][$x]."' id='comp_submit_".$vResults['id'][$x]."' name='comp_submit_".$vResults['id'][$x]."' value='".MysqlQuery::getText($pConn, 122)/*Gaan voort*/."'>";
                                            $vString .="</div>";
                                        $vString .="</div>";
                                    $vString .= "</div>";
                                }
                                else if($vResults['date_end'][$x] < $_SESSION['date_now'] && empty($vWinners)){
                                    $vString .= "<p class='text-small-normal red'>" . MysqlQuery::getText($pConn, 495)/*n Wenner sal binnekort aangekondig word.*/ . "</p>";
                                }
                                else if(($vResults['date_end'][$x] < $_SESSION['date_now']) && !empty($vWinners)){
                                    $vString .= "<hr class='xlight-gray'><p class='text-small-normal green space-top'><u>".MysqlQuery::getText($pConn, 496)/*Wenner/s*/."</u><br>-&nbsp;".$vWinners."</p>";
                                }

                            $vString .="</div>";
                        $vString .="</div>";//row
                    }
                }
                else {
                    $vString .="<div class='row'>";
                        $vString .= "<div class='form-group'>";
                            $vString .= "<div class='col-xs-12'>";
                                $vString .= "<h5 class='gray'>".MysqlQuery::getText($pConn, 21)/*Jammer, geen resultate is gevind nie!*/."</h5>";
                                $vString .= "<hr class='light-gray'>";
                            $vString .="</div>";
                        $vString .="</div>";
                    $vString .="</div>";
                }
                $vString .= "</div>";//center
            $vString .= "</div>";//form-border

		return General::prepareStringForDisplay($vString);
	}
}
?>