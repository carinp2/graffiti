<?php
/**
 *
 * @author Carin Pretorius - CEIT Development
 *         Created on 2017-06-08
 */

class Events {

	public static function getFutureEvents($pConn, $pTemp, $pType){
		if($pType == 1){//Future
		$vFOrder = "";
		$vFBindParams = array();
		$vFBindLetters = "s";
		$vFBindParams[] = & $_SESSION['now_date'];
		$vFLimit = "LIMIT 15";
		$vFWhere = "WHERE date >= ?";
		$vFResults = MysqlQuery::getEvents($pConn, $vFWhere, $vFOrder, $vFBindLetters,  $vFBindParams, $vFLimit);

		$vString .= "<div id=\"future-book\" class=\"tab-pane fade";
		}
		else if ($pType == 2){//2 = Past
			$vPOrder = "";
			$vPBindParams = array();
			$vPBindLetters = "s";
			$vPBindParams[] = & $_SESSION['now_date'];
			$vPLimit = "LIMIT 15";
			$vPWhere = "WHERE date < ?";
			$vPResults = MysqlQuery::getEvents($pConn, $vPWhere, $vPOrder, $vPBindLetters,  $vPBindParams, $vPLimit);

			$vString .= "<div id=\"past-book\" class=\"tab-pane fade";
		}
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
									$vString .="<div class=\"row\">";
										$vString .="<div class=\"form-group\">";
											$vString .= "<div class=\"col-xs-12\">";
												$vString .= "<h5 class=\"green\">".$vFResults[3][$x]." - ".$vFResults[1][$x]."</h5>";
												$vString .= "<hr class=\"light-gray\">";
											$vString .="</div>";
										$vString .="</div>";
									$vString .="</div>";//row
									//$vId, $vName, $vDetail, $vDate, $vTime, $vRsvp, $vPrice, $vLocation, $vPosterPath
									$vString .= "<div class=\"row row-grid line\">";
										$vString .= "<div class=\"form-group\">";
											$vString .= "<div class=\"col-xs-12  row-grid\">".$vFResults[2][$x]."</div>";
										$vString .="</div>";//form-group
									$vString .="</div>";//row
									$vString .= "<div class=\"row row-grid line\">";
										$vString .= "<div class=\"form-group\">";
											$vString .= "<div class=\"col-xs-4  row-grid\">".MysqlQuery::getText($pConn, 346)/*Tyd*/."</div>";
											$vString .= "<div class=\"col-xs-8  row-grid\">".$vFResults[4][$x]."</div>";
										$vString .="</div>";//form-group
									$vString .="</div>";//row
									$vString .= "<div class=\"row row-grid line\">";
										$vString .= "<div class=\"form-group\">";
											$vString .= "<div class=\"col-xs-4  row-grid\">".MysqlQuery::getText($pConn, 141)/*Prys*/."</div>";
											$vString .= "<div class=\"col-xs-8  row-grid\">".$vFResults[6][$x]."</div>";
										$vString .="</div>";//form-group
									$vString .="</div>";//row
									$vString .= "<div class=\"row row-grid line\">";
										$vString .= "<div class=\"form-group\">";
											$vString .= "<div class=\"col-xs-4  row-grid\">".MysqlQuery::getText($pConn, 347)/*Plek*/."</div>";
											$vString .= "<div class=\"col-xs-8  row-grid\">".$vFResults[6][$x]."</div>";
										$vString .="</div>";//form-group
									$vString .="</div>";//row
									$vString .= "<div class=\"row row-grid line\">";
										$vString .= "<div class=\"form-group\">";
											$vString .= "<div class=\"col-xs-4  row-grid\">".MysqlQuery::getText($pConn, 347)/*RSVP voor*/."</div>";
											$vString .= "<div class=\"col-xs-8  row-grid\">".$vFResults[5][$x]."</div>";
										$vString .="</div>";//form-group
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

		return General::prepareStringForDisplay($vString);
	}

	public static function getPastEvents($pConn, $pId, $pTemp){
		$vPOrder = "";
		$vPBindParams = array();
		$vPBindLetters = "s";
		$vPBindParams[] = & $_SESSION['now_date'];
		$vPLimit = "LIMIT 15";
		$vPWhere = "WHERE date < ?";
		$vPResults = MysqlQuery::getEvents($pConn, $vPWhere, $vPOrder, $vPBindLetters,  $vPBindParams, $vPLimit);


		$vString .= "<div id=\"past-book\" class=\"tab-pane fade";
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
									$vString .="<div class=\"row\">";
										$vString .="<div class=\"form-group\">";
											$vString .= "<div class=\"col-xs-12\">";
												$vString .= "<h5 class=\"green\">".$vFResults[3][$x]." - ".$vFResults[1][$x]."</h5>";
												$vString .= "<hr class=\"light-gray\">";
											$vString .="</div>";
										$vString .="</div>";
									$vString .="</div>";//row
									//$vId, $vName, $vDetail, $vDate, $vTime, $vRsvp, $vPrice, $vLocation, $vPosterPath
									$vString .= "<div class=\"row row-grid line\">";
										$vString .= "<div class=\"form-group\">";
											$vString .= "<div class=\"col-xs-12  row-grid\">".$vFResults[2][$x]."</div>";
										$vString .="</div>";//form-group
									$vString .="</div>";//row
									$vString .= "<div class=\"row row-grid line\">";
										$vString .= "<div class=\"form-group\">";
											$vString .= "<div class=\"col-xs-4  row-grid\">".MysqlQuery::getText($pConn, 346)/*Tyd*/."</div>";
											$vString .= "<div class=\"col-xs-8  row-grid\">".$vFResults[4][$x]."</div>";
										$vString .="</div>";//form-group
									$vString .="</div>";//row
									$vString .= "<div class=\"row row-grid line\">";
										$vString .= "<div class=\"form-group\">";
											$vString .= "<div class=\"col-xs-4  row-grid\">".MysqlQuery::getText($pConn, 141)/*Prys*/."</div>";
											$vString .= "<div class=\"col-xs-8  row-grid\">".$vFResults[6][$x]."</div>";
										$vString .="</div>";//form-group
									$vString .="</div>";//row
									$vString .= "<div class=\"row row-grid line\">";
										$vString .= "<div class=\"form-group\">";
											$vString .= "<div class=\"col-xs-4  row-grid\">".MysqlQuery::getText($pConn, 347)/*Plek*/."</div>";
											$vString .= "<div class=\"col-xs-8  row-grid\">".$vFResults[6][$x]."</div>";
										$vString .="</div>";//form-group
									$vString .="</div>";//row
									$vString .= "<div class=\"row row-grid line\">";
										$vString .= "<div class=\"form-group\">";
											$vString .= "<div class=\"col-xs-4  row-grid\">".MysqlQuery::getText($pConn, 347)/*RSVP voor*/."</div>";
											$vString .= "<div class=\"col-xs-8  row-grid\">".$vFResults[5][$x]."</div>";
										$vString .="</div>";//form-group
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


		return General::prepareStringForDisplay($vString);
	}

	public static function getOrderHistory($pConn, $pId, $pTemp){
		if($pId > 0 && $pId == $_SESSION['SessionGrafUserId']){
			$vOrder = "";
			$vBindParams = array();
			$vBindLetters = "";
			$vBindLetters .= "i";
			$vBindParams[] = & $pId;
			$vLimit = "";
			$vWhere = "WHERE client_id = ?";
			$vResults = MysqlQuery::getOrder($pConn, $vWhere, $vOrder, $vBindLetters,  $vBindParams, $vLimit);
		}
		else {
			General::echoRedirect("Home", "");
		}
		$vString = "<div id=\"user-order-history\" class=\"tab-pane fade".($pTemp == 3 ? $vString .= " in active" : $vString .= "")."\">";
				$vString .= "<div class=\"form-header\">";
					$vString .="<div class=\"row\">";
						$vString .= "<div class=\"col-xs-12\">";
							$vString .= "<h1 class=\"red\">".MysqlQuery::getText($pConn, 316)/*Bestel geskiedenis*/."</h1>";
						$vString .= "</div>";
					$vString .= "</div>";
				$vString .= "</div>";//Header
				$vString .= "<div class=\"form-body\">";
						if(count($vResults[0]) > 0){
								for($x = 0; $x < count($vResults[0]); $x++){
									($vResults[17][$x] == 1 ? $vColorMoney = "green" : $vColorMoney = "red");
									($vResults[19][$x] == 1 ? $vColorDispatch = "green" : $vColorDispatch = "red");
									($vResults[17][$x] == 1 ? $vTextMoney= MysqlQuery::getText($pConn, 326)/*DIe bestelling is betaal*/ : $vTextMoney = MysqlQuery::getText($pConn, 327)/*Die bestelling is nie betaal nie*/);
									($vResults[19][$x] == 1 ? $vTextDispatch = MysqlQuery::getText($pConn, 328)/*Die bestelling is versend*/ : $vTextDispatch = MysqlQuery::getText($pConn, 329)/*Die bestelling is nog nie versend nie*/);
									$vString .= "<div class=\"row row-grid line\">";
										$vString .= "<div class=\"form-group\">";
											$vString .= "<div class=\"col-xs-2 col-md-2 row-grid col-center text-small-normal green\">".$vResults[2][$x]."</div>";
											$vString .= "<div class=\"col-xs-6 col-md-5 row-grid text-small-normal\">";
												$vString .= MysqlQuery::getText($pConn, 296)/*Versending*/.": <span class=\"green\">".MysqlQuery::getLookupPerId($pConn, $vResults[10][$x])."</span><br>";
												$vString .= MysqlQuery::getText($pConn, 108)/*Versendingskoste*/.": <span class=\"green\">R ".$vResults[11][$x]."</span><br>";
												$vString .= MysqlQuery::getText($pConn, 292)/*Totale bestelling koste*/.": <span class=\"green\">R ".$vResults[12][$x]."</span><br>";
												$vString .= MysqlQuery::getText($pConn, 113)/*Betalingsmetode*/.": <span class=\"green\">".MysqlQuery::getLookupPerId($pConn, $vResults[14][$x])."</span><br>";
												(!empty($vResults[20][$x]) ? $vString .= MysqlQuery::getText($pConn, 325)/*Naspoorno.*/.": <span class=\"green\">".$vResults[20][$x]."</span>" : $vString .= "");
											$vString .= "</div>";
											$vString .= "<div class=\"col-xs-4 col-md-5 row-grid text-small-normal\">";
												$vString .= "<div class=\"col-xs-6 col-md-6 row-grid\">";
													$vString .= "<i class=\"fa fa-money fa-2x ".$vColorMoney."\" aria-hidden=\"true\" data-html=\"true\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"".$vTextMoney."\"></i>";
												$vString .= "</div>";//Paid
												$vString .= "<div class=\"col-xs-6 col-md-6 row-grid\">";
													$vString .= "<i class=\"fa fa-truck fa-2x ".$vColorDispatch."\" aria-hidden=\"true\" data-html=\"true\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"".$vTextDispatch."\"></i>";
												$vString .= "</div>";//Posted
											$vString .= "</div>";
										$vString .="</div>";//form-group
									$vString .="</div>";//row
								}
						}
						else {
							$vString .="<div class=\"row\">";
								$vString .= "<div class=\"col-xs-12\">";
									$vString .= "<h5 class=\"gray\">".MysqlQuery::getText($pConn, 320)/*Jou bestel geskiedenis is leeg*/."</h5>";
									$vString .= "<hr class=\"light-gray\">";
								$vString .="</div>";
							$vString .="</div>";
						}
				$vString .= "</div>";//Body
		$vString .= "</div>";//profile
		return General::prepareStringForDisplay($vString);
	}
}