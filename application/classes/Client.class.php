<?php
/**
 *
 * @author Carin Pretorius - CEIT Development
 *         Created on 2017-06-08
 */

class Client {

	public static function getProfile($pConn, $pId, $pTemp){
		if($pId > 0 && $pId == $_SESSION['SessionGrafUserId']){
			$vOrder = "";
			$vBindParams = array();
			$vBindLetters = "i";
			$vBindParams[] = & $pId;
			$vLimit = "LIMIT 1";
			$vWhere = "WHERE c.id = ?";
			$vResults = MysqlQuery::getClients($pConn, $vWhere, $vOrder, $vBindLetters,  $vBindParams, $vLimit);
			$vHeading = MysqlQuery::getText($pConn, 273)/*Jou profiel*/;
			$vSubHeading = "";
		}
		else if($pId <= 0){
			$vHeading = MysqlQuery::getText($pConn, 96)/*Registreer*/;
			$vSubHeading = MysqlQuery::getText($pConn, 249)/*Voltooi die vorm om te registreer*/;
		}
		(isset($vResults[18][0]) && $vResults[18][0] == 1 ? $vNewsChecked = "checked" : $vNewsChecked = "");
		$vLanguageResults = MysqlQuery::getLookup($pConn, "language");

		$vString = "<div id='user-profile' class='tab-pane fade".($pTemp == 0 ? " in active" : "")."'>";
				$vString .= "<div class='form-header'>";
					$vString .="<div class='row'>";
						$vString .= "<div class='col-xs-12'>";
							$vString .= "<h1 class='red'>".$vHeading."</h1>";
							$vString .= "<small class='red'>".$vSubHeading."</small>";
						$vString .= "</div>";
					$vString .= "</div>";
				$vString .= "</div>";//Header
				$vString .= "<div class='form-body'>";
						$vString .="<div class='row'>";
						$vString .="<div class='form-group'>";
							$vString .= "<div class='col-xs-12'>";
								$vString .= "<label for='firstname' class='form-label'>".MysqlQuery::getText($pConn, 64)/*Naam*/.":</label>";
								$vString .= "<input type='text' name='firstname' id='firstname' value='".(isset($vResults[1][0]) ? $vResults[1][0] : '')."' required size='50' maxlength='50'><i class='fa fa-asterisk fa-required red' aria-hidden='true'></i>";
							$vString .= "</div>";
							$vString .= "</div>";
						$vString .="</div>";
						$vString .="<div class='row'>";
							$vString .="<div class='form-group'>";
								$vString .= "<div class='col-xs-12'>";
									$vString .= "<label for='surname' class='form-label'>".MysqlQuery::getText($pConn, 65)/*Van*/.":</label>";
									$vString .= "<input type='text' name='surname' id='surname' value='".(isset($vResults[2][0]) ? $vResults[2][0] : '')."' required size='50' maxlength='50'><i class='fa fa-asterisk fa-required red' aria-hidden='true'></i>";
								$vString .= "</div>";
							$vString .= "</div>";
						$vString .="</div>";
						$vString .="<div class='row'>";
							$vString .="<div class='form-group'>";
								$vString .= "<div class='col-xs-12'>";
									$vString .= "<label for='email' class='form-label'>".MysqlQuery::getText($pConn, 66)/*Eposadres*/.":</label>";
									$vString .= "<input type='text' name='email' id='email' value='".(isset($vResults[3][0]) ?$vResults[3][0] : '')."' pattern='[A-Za-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,6}$' required size='50' maxlength='80'><i class='fa fa-asterisk fa-required red' aria-hidden='true'></i>";
								$vString .= "</div>";
							$vString .= "</div>";
						$vString .="</div>";
						$vString .="<div class='row'>";
							$vString .="<div class='form-group'>";
								$vString .= "<div class='col-xs-12'>";
									$vString .= "<label for='phone' class='form-label'>".MysqlQuery::getText($pConn, 67)/*Kontak nommer*/.":</label>";
									$vString .= "<input type='text' name='phone' id='phone' value='".(isset($vResults[5][0]) ? $vResults[5][0] : '')."' size='20' maxlength='20' required><i class='fa fa-asterisk fa-required red' aria-hidden='true'></i>";
								$vString .= "</div>";
							$vString .= "</div>";
						$vString .="</div>";
//						$vString .="<div class='row'>";
//							$vString .="<div class='form-group'>";
//								$vString .= "<div class='col-xs-12'>";
//									$vString .= "<hr class='light-gray'>";
//									$vString .= "<h5 class='red'>".MysqlQuery::getText($pConn, 69)/*Posadres*/.":</h5>";
//								$vString .= "</div>";
//							$vString .= "</div>";
//						$vString .="</div>";
//						$vString .="<div class='row'>";
//							$vString .="<div class='form-group'>";
//								$vString .= "<div class='col-xs-12'>";
//									$vString .= "<label for='postal_address1' class='form-label'>".MysqlQuery::getText($pConn, 181)/*Adres*/.":</label>";
//									$vString .= "<input type='text' name='postal_address1' id='postal_address1' value='".(isset($vResults[6][0]) ? $vResults[6][0] : '')."' value='".$vResults[1][0]."' placeholder='".MysqlQuery::getText($pConn, 69)/*Posadres*/."' required size='45' maxlength='45'><i class='fa fa-asterisk fa-required red' aria-hidden='true'></i>";
//								$vString .= "</div>";
//							$vString .= "</div>";
//						$vString .="</div>";
//							$vString .="<div class='row'>";
//								$vString .="<div class='form-group'>";
//									$vString .= "<div class='col-xs-12'>";
//										$vString .= "<label for='postal_address2' class='form-label'></label>";
//										$vString .= "<input type='text' name='postal_address2'  id='postal_address2' value='".(isset($vResults[7][0]) ? $vResults[7][0] :'' )."' placeholder='' required size='45' maxlength='45'>";
//								$vString .= "</div>";
//							$vString .= "</div>";
//						$vString .="</div>";
//						$vString .="<div class='row'>";
//							$vString .="<div class='form-group'>";
//								$vString .= "<div class='col-xs-12'>";
//									$vString .= "<label for='postal_city' class='form-label'>".MysqlQuery::getText($pConn, 98)/*Stad*/.":</label>";
//									$vString .= "<input type='text' name='postal_city' id='postal_city' value='".(isset($vResults[8][0]) ? $vResults[8][0] : '')."' placeholder='".MysqlQuery::getText($pConn, 98)/*Stad*/."' required size='45' maxlength='45'><i class='fa fa-asterisk fa-required red' aria-hidden='true'></i>";
//								$vString .= "</div>";
//							$vString .= "</div>";
//						$vString .="</div>";
//						$vString .="<div class='row'>";
//							$vString .="<div class='form-group'>";
//								$vString .= "<div class='col-xs-12'>";
//									$vString .= "<label for='postal_province' class='form-label'>".MysqlQuery::getText($pConn, 248)/*Provinsie*/.":</label>";
//									$vString .= "<input type='text' name='postal_province' id='postal_province' value='".(isset($vResults[9][0]) ?$vResults[9][0] : '')."' placeholder='".MysqlQuery::getText($pConn, 248)/*Provinsie*/."'  size='45' maxlength='45'><i class='fa fa-asterisk fa-required red' aria-hidden='true'></i>";
//								$vString .= "</div>";
//							$vString .= "</div>";
//						$vString .="</div>";
//						$vString .="<div class='row'>";
//							$vString .="<div class='form-group'>";
//								$vString .= "<div class='col-xs-12'>";
//									$vString .= "<label for='postal_country' class='form-label'>".MysqlQuery::getText($pConn, 229)/*Land*/.":</label>";
//									$vString .= "<input type='text' name='postal_country' id='postal_country' value='".(isset($vResults[11][0]) ? $vResults[11][0] : '')."' placeholder='".MysqlQuery::getText($pConn, 229)/*Land*/."' required  size='45' maxlength='45'><i class='fa fa-asterisk fa-required red' aria-hidden='true'></i>";
//								$vString .= "</div>";
//							$vString .= "</div>";
//						$vString .="</div>";
//						$vString .="<div class='row'>";
//							$vString .="<div class='form-group'>";
//								$vString .= "<div class='col-xs-12'>";
//									$vString .= "<label for='postal_code' class='form-label'>".MysqlQuery::getText($pConn, 71)/*Poskode*/.":</label>";
//									$vString .= "<input type='text' name='postal_code' id='postal_code' value='".(isset($vResults[10][0]) ? $vResults[10][0] : '')."' placeholder='".MysqlQuery::getText($pConn, 71)/*Poskode*/."' required  size='10' maxlength='10'><i class='fa fa-asterisk fa-required red' aria-hidden='true'></i>";
//								$vString .= "</div>";
//							$vString .= "</div>";
//						$vString .="</div>";
						$vString .="<div class='row'>";
							$vString .="<div class='form-group'>";
								$vString .= "<div class='col-xs-12'>";
									$vString .= "<hr class='light-gray'>";
									$vString .= "<h5 class='red'>".MysqlQuery::getText($pConn, 70)/*Fisiese adres*/.":</h5>";
								$vString .= "</div>";
							$vString .= "</div>";
						$vString .="</div>";
						$vString .="<div class='row'>";
							$vString .="<div class='form-group'>";
								$vString .= "<div class='col-xs-12'>";
									$vString .= "<label for='physical_address1' class='form-label'>".MysqlQuery::getText($pConn, 181)/*Adres*/.":</label>";
									$vString .= "<input type='text' name='physical_address1' id='physical_address1' value='".(isset($vResults[12][0]) ? $vResults[12][0] : '')."' required size='45' maxlength='45'><i class='fa fa-asterisk fa-required red' aria-hidden='true'></i>";
								$vString .= "</div>";
							$vString .= "</div>";
						$vString .="</div>";
							$vString .="<div class='row'>";
								$vString .="<div class='form-group'>";
									$vString .= "<div class='col-xs-12'>";
										$vString .= "<label for='physical_address2' class='form-label'></label>";
										$vString .= "<input type='text' name='physical_address2'  id='physical_address2' value='".(isset($vResults[13][0]) ? $vResults[13][0] : '')."' placeholder='' size='45' maxlength='45'>";
								$vString .= "</div>";
							$vString .= "</div>";
						$vString .="</div>";
						$vString .="<div class='row'>";
							$vString .="<div class='form-group'>";
								$vString .= "<div class='col-xs-12'>";
									$vString .= "<label for='physical_city' class='form-label'>".MysqlQuery::getText($pConn, 98)/*Stad*/.":</label>";
									$vString .= "<input type='text' name='physical_city' id='physical_city' value='".(isset($vResults[14][0]) ?$vResults[14][0] : '')."' required size='45' maxlength='45'><i class='fa fa-asterisk fa-required red' aria-hidden='true'></i>";
								$vString .= "</div>";
							$vString .= "</div>";
						$vString .="</div>";
						$vString .="<div class='row'>";
							$vString .="<div class='form-group'>";
								$vString .= "<div class='col-xs-12'>";
									$vString .= "<label for='physical_province' class='form-label'>".MysqlQuery::getText($pConn, 248)/*Provinsie*/.":</label>";
									$vString .= "<input type='text' name='physical_province' id='physical_province' value='".(isset($vResults[15][0]) ? $vResults[15][0] : '')."' required size='45' maxlength='45'><i class='fa fa-asterisk fa-required red' aria-hidden='true'></i>";
								$vString .= "</div>";
							$vString .= "</div>";
						$vString .="</div>";
//                        $vCountryResults = MysqlQuery::getCountryCourierCost($pConn, 1);//$vId, $vCountry, $vCost
						$vString .="<div class='row'>";
							$vString .="<div class='form-group'>";
								$vString .= "<div class='col-xs-12'>";
                                    $vString .= "<div class='w-inline-50'>
									    <label for='physical_country' class='form-label'>".MysqlQuery::getText($pConn, 229)/*Land*/.":</label>
                                        <select name='physical_country' id='physical_country' class='form-control' required>
                                            <option value='1' ".($vResults[21][0] == 1 ? 'selected' : '').">Suid Afrika / South Africa</option>
                                        </select><i class='fa fa-asterisk fa-required red' aria-hidden='true'></i>
                                    </div>";
								$vString .= "</div>";
							$vString .= "</div>";
						$vString .="</div>";
						$vString .="<div class='row'>";
							$vString .="<div class='form-group'>";
								$vString .= "<div class='col-xs-12'>";
									$vString .= "<label for='physical_code' class='form-label'>".MysqlQuery::getText($pConn, 71)/*Poskode*/.":</label>";
									$vString .= "<input type='text' name='physical_code' id='physical_code' value='".(isset($vResults[17][0]) ? $vResults[17][0] : '')."' required size='10' maxlength='10'><i class='fa fa-asterisk fa-required red' aria-hidden='true'></i>";
								$vString .= "</div>";
							$vString .= "</div>";
						$vString .="</div>";
						if($pId <= 0){
							$vString .="<div class='row'>";
								$vString .="<div class='form-group'>";
									$vString .= "<div class='col-xs-12'>";
									$vString .= "<hr class='light-gray'>";
										$vString .= "<label for='password' class='form-label'>".MysqlQuery::getText($pConn, 99)/*Wagwoord*/.":</label>";
										$vString .= "<input type='password' name='password' id='password' placeholder='******' pattern='.{6,}' title='Must be 6 characters or longer' required size='45' maxlength='45' autocomplete='off'><i class='fa fa-asterisk fa-required red' aria-hidden='true'></i>";
									$vString .= "</div>";
								$vString .= "</div>";
							$vString .="</div>";
							$vString .="<div class='row'>";
								$vString .="<div class='form-group'>";
									$vString .= "<div class='col-xs-12'>";
										$vString .= "<label for='password' class='form-label'>".MysqlQuery::getText($pConn, 100)/*Herhaal wagwoord*/.":</label>";
										$vString .= "<input type='password' name='password2' id='password2' placeholder='******' pattern='.{6,}' title='Must be 6 characters or longer' required size='45' maxlength='45' autocomplete='off'><i class='fa fa-asterisk fa-required red' aria-hidden='true'></i>";
									$vString .= "</div>";
								$vString .= "</div>";
							$vString .="</div>";
						}
						$vString .="<div class='row'>";
							$vString .="<div class='form-group'>";
								$vString .= "<div class='col-xs-12'>";
									$vString .= "<hr class='light-gray'>";
                                    $vString .= "<div class='w-inline-50'>";
									$vString .= "<label for='language' class='form-label' >".MysqlQuery::getText($pConn, 361)/*Taal voorkeur*/.":</label>";
									$vString .= "<select name='client_language' id='client_language' class='form-control'>";
									for($l = 0; $l < count($vLanguageResults[0]); $l++){
										$vString .= "<option value='".substr(strtolower($vLanguageResults[1][$l]), 0,2)."'";
										if(!empty($vResults[19][0]) && $vResults[19][0] == substr(strtolower($vLanguageResults[1][$l]), 0,2)){
											$vString .= " selected";
										}
										$vString .= ">".$vLanguageResults[1][$l]."</option>";
									}
									$vString .= "</select>";
								$vString .= "</div></div>";
							$vString .= "</div>";
						$vString .="</div>";
// 						$vString .="<div class='row'>";
// 							$vString .="<div class='form-group'>";
// 								$vString .= "<div class='col-xs-12'>";
// 									$vString .= "<hr class='light-gray'>";
// 									$vString .= "<label class='checkbox green checkbox-inline' >";
// 										$vString .= "<input type='checkbox' name='organisation' value='1' ".$vNewsChecked.">".MysqlQuery::getText($pConn, 386)/*Doen jy aankope namens 'n Skool of Biblioteek?*/;
// 									$vString .= "</label>";
// 								$vString .= "</div>";
// 							$vString .= "</div>";
// 						$vString .="</div>";
						$vString .="<div class='row'>";
							$vString .="<div class='form-group'>";
								$vString .= "<div class='col-xs-12'>";
									$vString .= "<hr class='light-gray'>";
									$vString .= "<label class='checkbox green checkbox-inline' >";
										$vString .= "<input type='checkbox' name='newsletter' value='1' ".$vNewsChecked.">".MysqlQuery::getText($pConn, 101)/*Ek wil graag die Graffiti Nuusbrief ontvang*/;
									$vString .= "</label>";
									//$vString .= "<hr class='light-gray'>";
								$vString .= "</div>";
							$vString .= "</div>";
						$vString .="</div>";
						if($pId <= 0){
						$vString .="<div class='row'>";
							$vString .= "<div class='col-xs-12'>";
								$vString .= "<hr class='light-gray'>";
									$vString .= "<div class='g-recaptcha' data-sitekey='6LfpLBcUAAAAANSBQO29eMTncFXGx_i33taf1Kn-'></div>";
							$vString .= "</div>";
						$vString .="</div>";
						}
						$vString .="<div class='row'>";
		                    $vString .="<div class='col-xs-12'>";
		                    if($pId && $pId > 0){
								$vString .="<div id='profile_success' class='success' style='display:none;'>".MysqlQuery::getText($pConn, 271)/*Jou profiel is suksesvol verander!*/."</div>";
								$vString .="<div id='register_error' class='error' style='display:none;'>".MysqlQuery::getText($pConn, 274)/*Jou profiel is nie verander nie. Probeer asseblief weer.*/."</div>";
								$vString .="<div id='register_complete' class='complete' style='display:none;'>".MysqlQuery::getText($pConn, 243)/*Voltooi asseblief die verpligte velde*/."</div>";
		                    }
		                    else {
								$vString .="<div id='register_error' class='error' style='display:none;'>".MysqlQuery::getText($pConn, 251)/*Jou registrasie was nie suksesvol. Probeer asseblief weer.*/."</div>";
								$vString .="<div id='register_complete' class='complete' style='display:none;'>".MysqlQuery::getText($pConn, 243)/*Voltooi asseblief die verpligte velde*/."</div>";
								$vString .="<div id='register_password' class='error' style='display:none;'>".MysqlQuery::getText($pConn, 250)/*Die twee wagwoorde verskil.*/."</div>";
								$vString .="<div id='register_double' class='error' style='display:none;'>".MysqlQuery::getText($pConn, 254)/*Jou email bestaan reeds in ons databasis.*/."<br><a href='#login' role='button' data-toggle='modal' class='text-small green' title='".MysqlQuery::getText($pConn, 237)/*Teken aan*/."'>".MysqlQuery::getText($pConn, 237)/*Teken aan*/."</a></div>";
								$vString .="<div id='register_success' class='success' style='display:none;'>".MysqlQuery::getText($pConn, 261)/*Jou registrasie was suksesvol. Jy sal 'n epos met 'n skakel vir die bevestiging van die registrasie van Graffiti ontvang.*/."<br><br>".MysqlQuery::getText($pConn, 356)/*Verifieer asseblief die regsitrasie deur op die skakel te klik.*/."</div>";
		                    }
							$vString .="</div>";
						$vString .="</div>";
						$vString .="<div class='row'>";
							$vString .="<div class='form-group'>";
							$vString .= "<hr class='light-gray'>";
							$vString .="<div class='col-xs-12  red message' id='message'><i class='fa fa-asterisk fa-required red' aria-hidden='true'></i>&nbsp;".MysqlQuery::getText($pConn, 102)/*Verpligte velde*/."</div>";
							$vString .="</div>";
						$vString .="</div>";
					$vString .= "</div>";//Body
					$vString .= "<div class='form-footer'>";
						$vString .="<div class='row'>";
		                    $vString .="<div class='col-xs-12'>";
								if($pId > 0){
									$vString .= "<input type='hidden' name='client_id' id='client_id' value='".$pId."'>";
									$vString .= "<input type='hidden' name='type' id='type' value='profile-edit'>";
									$vString .= "<button type='submit' id='registerSubmit' class='btn btn-primary'>".MysqlQuery::getText($pConn, 72)/*Stoor*/."</button>";
									$vString .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='#password' role='button' data-toggle='modal' class='text-small red' title='".MysqlQuery::getText($pConn, 272)/*Verander Wagwoord*/."'><button type='button' id='changePasswordSubmit'  data-toggle='modal' data-src='".$pId."' class='btn btn-primary'>".MysqlQuery::getText($pConn, 272)/*Verander Wagwoord*/."</button></a>";
								}
								else {
									$vString .= "<input type='hidden' name='type' id='type' value='register'>";
									$vString .= "<button type='submit' id='registerSubmit' class='btn btn-primary'>".MysqlQuery::getText($pConn, 96)/*Registreer*/."</button>";
								}
								$vString .= "<input type='hidden' name='hc' id='hc' value='1'>";
							$vString .="</div>";
						$vString .="</div>";
				$vString .="</div>";//footer
		$vString .= "</div>";//profile
		return $vString;
	}

	public static function getWishlist($pConn, $pId, $pTemp){
		if($pId > 0 && $pId == $_SESSION['SessionGrafUserId']){
			$vOrder = "";
			$vBindParams = array();
			$vBindLetters = "";
			$vBindLetters .= "i";
			$vBindParams[] = & $pId;
			$vLimit = "";
			$vWhere = "WHERE client_id = ?";
			$vResults = MysqlQuery::getWishlist($pConn, $vWhere, $vOrder, $vBindLetters,  $vBindParams, $vLimit);
			//$vId, $vBookId, $vTitle, $vPrice, $vBlobPath, $vInStock
		}
		else {
			General::echoRedirect("Home", "");
		}

		$vString = "<div id='user-wishlist' class='tab-pane fade".($pTemp == 2 ? " in active" : "")."'>";
				$vString .= "<div class='form-header'>";
					$vString .="<div class='row'>";
						$vString .= "<div class='col-xs-12'>";
							$vString .= "<h1 class='red'>".MysqlQuery::getText($pConn, 315)/*Wenslys*/."</h1>";
						$vString .= "</div>";
					$vString .= "</div>";
				$vString .= "</div>";//Header
				$vString .= "<div class='form-body'>";
						$vString .="<div class='row'>";
							$vString .="<div class='form-group'>";
								$vString .= "<div class='col-xs-12'>";
									$vString .= "<h1 class='green'>".MysqlQuery::getText($pConn, 317)/*Boeke in jou wenslys*/."</h1>";
									$vString .= "<hr class='light-gray'>";
								$vString .="</div>";
							$vString .="</div>";
						$vString .="</div>";//row
						if(isset($vResults[0]) && count($vResults[0]) > 0){
								for($x = 0; $x < count($vResults[0]); $x++){
									//Books
									$vString .= "<div class='row row-grid line'>";
										$vString .= "<div class='form-group'>";
											$vString .= "<div class='col-xs-2 col-md-2 row-grid col-center'>";
											if(!empty($vResults[4][$x])){
												$vString .= "<a href='images/books/".$vResults[4][$x]."' data-lightbox='img_".$vResults[4][$x]."' data-title='".$vResults[2][$x]."'  title='".$vResults[2][$x]."'><img src='images/books/".$vResults[4][$x]."' class='img-responsive cart-thumb thumb' alt='".$vResults[2][$x]."'></a></div>";
											}
											else {
												$vString .= "<a href='images/no_image.png' data-lightbox='img_logo.png' data-title='".MysqlQuery::getText($pConn, 143)/*Geen voorblad*/."'  title='".MysqlQuery::getText($pConn, 143)/*Geen voorblad*/."'><img src='images/no_image.png' class='img-responsive cart-thumb thumb' alt='".$vResults[2][$x]."'></a></div>";
											}
											$vString .= "<div class='col-xs-4 col-md-5 row-grid'>".$vResults[2][$x]."</div>";
											$vString .= "<div class='col-xs-3 col-md-3 row-grid col-right' id='cart-total-price-".$vResults[0][$x]."' data-src='".$vResults[10][$x]."'>R ".$vResults[3][$x]."</div>";
											$vString .= "<div class='col-xs-3 col-md-2 row-grid'>";
													$vString .= "<a id='remove-wish-book-".$vResults[0][$x]."' class='btn btn-primary btn-xsmall' role='button' data-src='".$vResults[0][$x]."' data-url='".$_SESSION['SessionGrafLanguage']."/".$_SESSION['SessionGrafUserId']."/".MysqlQuery::getText($pConn, 319)/*Profiel*/."/2' title='".MysqlQuery::getText($pConn, 287)/*Verwyder boek*/."'>";
														$vString .= "<i class='fa fa-times' aria-hidden='true'></i>";
													$vString .= "</a>&nbsp;";
													$vString .= "<a id='move-to-cart-".$vResults[0][$x]."' class='btn btn-primary btn-xsmall' role='button' data-src='".$vResults[0][$x]."' data-id='".$vResults[1][$x]."' data-url='".$_SESSION['SessionGrafLanguage']."/".$_SESSION['SessionGrafUserId']."/".MysqlQuery::getText($pConn, 319)/*Profiel*/."/2'  title='".MysqlQuery::getText($pConn, 24)/*Laai in mandjie*/."'>";
														$vString .= "<i class='fa fa-shopping-basket' aria-hidden='true'></i>";
													$vString .= "</a>";
											$vString .= "</div>";
										$vString .="</div>";
									$vString .="</div>";
								}
						}
						else {
							$vString .="<div class='row'>";
								$vString .= "<div class='form-group'>";
									$vString .= "<div class='col-xs-12'>";
										$vString .= "<h5 class='gray'>".MysqlQuery::getText($pConn, 318)/*Jou wenslys is leeg*/."</h5>";
										$vString .= "<hr class='light-gray'>";
									$vString .="</div>";
								$vString .="</div>";
							$vString .="</div>";
						}
				$vString .= "</div>";//Body
		$vString .= "</div>";//wishlist
		return General::prepareStringForDisplay($vString);
	}

	public static function getOrderHistory($pConn, $pId, $pTemp){
		if($pId > 0 && $pId == $_SESSION['SessionGrafUserId']){
			$vOrder = "ORDER BY order_date DESC";
			$vBindParams = array();
            $vBindLetters = "i";
			$vBindParams[] = & $pId;
			$vLimit = "";
			$vWhere = "WHERE client_id = ?";
			$vResults = MysqlQuery::getOrder($pConn, $vWhere, $vOrder, $vBindLetters,  $vBindParams, $vLimit);
		}
		else {
			General::echoRedirect("Home", "");
		}
		$vString = "<div id='user-order-history' class='tab-pane fade".($pTemp == 3 ? " in active" : "")."'>";
				$vString .= "<div class='form-header'>";
					$vString .="<div class='row'>";
						$vString .= "<div class='col-xs-12'>";
							$vString .= "<h1 class='red'>".MysqlQuery::getText($pConn, 316)/*Bestel geskiedenis*/."</h1>";
						$vString .= "</div>";
					$vString .= "</div>";
					$vString .="<div class='row'>";
						$vString .= "<div class='col-xs-12'>";
							$vString .= "<div class='col-xs-3 col-md-3 row-grid col-center text-col-small'><span class='red'>".MysqlQuery::getText($pConn, 321)/*Bestellingsdatum*/."</span></div>";
							$vString .= "<div class='col-xs-3 col-md-3 row-grid col-center text-col-small'><span class='red'>".MysqlQuery::getText($pConn, 396)/*Verwysingsno.*/."</span></div>";
							$vString .= "<div class='col-xs-2 col-md-2 row-grid col-center text-col-small'><span class='red'>".MysqlQuery::getText($pConn, 323)/*Betaal*/."<br><span class='right'>".MysqlQuery::getText($pConn, 147)/*Totale prys*/."</span></span></div>";
							$vString .= "<div class='col-xs-2 col-md-2 row-grid col-center text-col-small'><span class='red'>".MysqlQuery::getText($pConn, 324)/*Versend*/."</span></div>";
							$vString .= "<div class='col-xs-2 col-md-2 row-grid col-center text-col-small'><span class='red'>".MysqlQuery::getText($pConn, 390)/*Afgehandel*/."</span></div>";
						$vString .= "</div>";
					$vString .= "</div>";
				$vString .= "</div>";//Header
				$vString .= "<div class='form-body'>";
						if(isset($vResults[0]) && count($vResults[0]) > 0){
								for($x = 0; $x < count($vResults[0]); $x++){
									$vResultsBooks = MysqlQuery::getOrderDetail($pConn, "order_id = ?", $vResults[0][$x]);//$vId, $vOrder_id, $vBook_id, $vPrice, $vNumber_books, $vTemp_salt, $vTitle, $vInStock
									$vReferenceNo = "GRAF/".$vResults[0][$x]."/".$vResults[3][$x];
									($vResults[17][$x] == 1 ? $vColorMoney = "green" : $vColorMoney = "red");
									($vResults[19][$x] == 51 ? $vColorDispatch = "green" : ($vResults[19][$x] == 52 ? $vColorDispatch = "red" : $vColorDispatch = "gray"));
									($vResults[17][$x] == 1 ? $vTextMoney= MysqlQuery::getText($pConn, 326)/*DIe bestelling is betaal*/ : $vTextMoney = MysqlQuery::getText($pConn, 327)/*Die bestelling is nie betaal nie*/);
									($vResults[19][$x] == 51 ? $vTextDispatch = MysqlQuery::getText($pConn, 328)/*Die bestelling is versend*/ : ($vResults[19][$x] == 52 ? $vTextDispatch = MysqlQuery::getText($pConn, 329)/*Die bestelling is nog nie versend nie*/ : $vTextDispatch = MysqlQuery::getText($pConn, 451)/*Die bestelling is gedeeltelik versend*/));
									$vString .= "<div class='row row-grid line'>";
										$vString .= "<div class='form-group'>";
											$vString .= "<div class='col-xs-3 col-md-3 row-grid col-center text-col-small col-border'>".date('d M Y', strtotime($vResults[2][$x]))."</div>";
											$vString .= "<div class='col-xs-3 col-md-3 row-grid col-center text-col-small col-border'>";
												$vString .= $vReferenceNo;
												$vString .= "<i class='fa fa-chevron-down green space-left' id='orderhistoryshowbooks_".$vResults[0][$x]."' data-id='".$vResults[0][$x]."' aria-hidden='true' data-html='true' data-toggle='tooltip' data-original-title='".MysqlQuery::getText($pConn, 395)/*Klik vir boekelys*/."'></i>";
												$vString .= "<i class='no-display fa-chevron-up green space-left' id='orderhistoryhidebooks_".$vResults[0][$x]."' data-id='".$vResults[0][$x]."' aria-hidden='true' data-html='true' data-toggle='tooltip' data-original-title='".MysqlQuery::getText($pConn, 54)/*Maak toe*/."'></i>";
											$vString .="</div>";//col

											$vString .= "<div class='col-xs-2 col-md-2 row-grid text-col-small col-center col-border'>";
												$vPayType = MysqlQuery::getLookupPerId($pConn, $vResults[14][$x]);
												if($vResults[17][$x] == 1){
													$vPaidString = MysqlQuery::getText($pConn, 391)/*Ja*/;
													$vString .= $vPaidString;
												}
												else {
													$vPaidString = MysqlQuery::getText($pConn, 392)/*Nee*/;
													$vString .= $vPaidString;
												}
												$vString .= "<a href='#orderhistorypay'  id='orderhistorypayicon_".$vResults[0][$x]."' class='".$vColorMoney."' title='".MysqlQuery::getText($pConn, 387)/*Klik vir meer informasie*/."' data-toggle='modal' data-id='".$vResults[0][$x]."' data-pay-books='".$vResults[12][$x]."' data-pay-postal='".$vResults[11][$x]."' data-pay-total='".$vResults[13][$x]."' data-pay-paid='".$vPaidString."' data-pay-type='".$vPayType."'>";
													$vString .= "<i class='fa fa-plus ".$vColorMoney." space-left' aria-hidden='true' data-html='true' data-toggle='tooltip' data-original-title='".$vTextMoney."<br>-".MysqlQuery::getText($pConn, 387)/*Klik vir meer informasie*/."-'></i>";
												$vString .= "</a>";
												$vString .= "<br><span class='right'>R ".$vResults[13][$x]."</span>";
											$vString .="</div>";//betaal

											$vString .= "<div class='col-xs-2 col-md-2 row-grid text-col-small col-center col-border'>";
												$vSend = MysqlQuery::getLookupPerId($pConn, $vResults[19][$x]);
												$vString .= $vSend;
// 												if($vResults[19][$x] == 1){
// 													$vDispatchString = MysqlQuery::getText($pConn, 391)/*Ja*/;
// 													$vString .= $vDispatchString;
// 												}
// 												else if ($vResults[19][$x] == 2){
// 													$vString .= MysqlQuery::getText($pConn, 450)/*Gedeeltelik*/;
// 												}
// 												else {
// 													$vDispatchString = MysqlQuery::getText($pConn, 392)/*Nee*/;
// 													$vString .= $vDispatchString;
// 												}

												$vCourierType = MysqlQuery::getLookupPerId($pConn, $vResults[10][$x]);
                                                $vCountryString = (!empty($vResults[8][$x]) && $vResults[8][$x] > 0 && $vResults[10][$x] <> 4 ? MysqlQuery::getCountry($pConn, $vResults[8][$x]) : '');
												$vDispatchDetail = "";
												(!empty($vResults[27][$x]) ? $vDispatchDetail .= $vResults[27][$x]."<br>" : $vDispatchDetail .= "");
												(!empty($vResults[4][$x]) ? $vDispatchDetail .= $vResults[4][$x] : $vDispatchDetail .= "");
												(!empty($vResults[5][$x]) ? $vDispatchDetail .= ", ".$vResults[5][$x] : $vDispatchDetail .= "");
												(!empty($vResults[6][$x]) ? $vDispatchDetail .= ", ".$vResults[6][$x] : $vString .= "");
												(!empty($vResults[7][$x]) ? $vDispatchDetail .= ", ".$vResults[7][$x] : $vDispatchDetail .= "");
												(!empty($vResults[8][$x]) ? $vDispatchDetail .= ", ".$vResults[8][$x] : $vDispatchDetail .= "");
                                                (!empty($vCountryString[1]) ? $vDispatchDetail .= ', ' . $vCountryString[1] : '');//Country
												(!empty($vResults[9][$x]) ? $vDispatchDetail .= ", ".$vResults[9][$x]."<br>"  : $vDispatchDetail .= "");
												(!empty($vResults[28][$x]) ? $vDispatchDetail .= $vResults[28][$x] : $vDispatchDetail .= "");
												$vString .= "<a href='#orderhistorydispatch'  id='orderhistorydispatchicon_".$vResults[0][$x]."' class='".$vColorDispatch."' title='".MysqlQuery::getText($pConn, 387)/*Klik vir meer informasie*/."' data-toggle='modal' data-id='".$vResults[0][$x]."' data-dispatch='".$vSend."' data-dispatch-method='".$vCourierType."' data-dispatch-cost='".$vResults[11][$x]."' data-dispatch-tracking='".$vResults[20][$x]."' data-dispatch-detail='".$vDispatchDetail."' data-dispatch-message='".$vResults[16][$x]."'>";
													$vString .= "<i class='fa fa-plus ".$vColorDispatch." space-left' aria-hidden='true' data-html='true' data-toggle='tooltip' data-original-title='".$vTextDispatch."<br>-".MysqlQuery::getText($pConn, 387)/*Klik vir meer informasie*/."-'></i>";
												$vString .= "</a>";
											$vString .="</div>";//versend

											$vString .= "<div class='col-xs-2 col-md-2 row-grid text-col-small col-center'>";
												if($vResults[21][$x] == 1){
													$vString .= MysqlQuery::getText($pConn, 391)/*Ja*/;
												}
												else if ($vResults[21][$x] == 2){
													$vString .= MysqlQuery::getText($pConn, 450)/*Gedeeltelik*/;
												}
												else {
													$vString .= MysqlQuery::getText($pConn, 392)/*Nee*/;
												}
											$vString .="</div>";//afgehandel


										$vString .="</div>";//form-group
									$vString .="</div>";//row
									$vString .= "<div class='row row-grid line no-display' id='orderhistorybooksdetail_".$vResults[0][$x]."'>";
										$vString .= "<div class='col-xs-12 col-md-12 row-grid'>";
                                        if(isset($vResultsBooks['id']) && count($vResultsBooks['id']) > 0) {
                                            for ($b = 0; $b < count($vResultsBooks['id']); $b++) {
                                                $vString .= "<div class='row row-grid line'>";
                                                $vString .= "<div class='col-xs-0  col-md-1 row-grid text-col-small'></div>";
                                                $vString .= "<div class='col-xs-9  col-md-7 text-col-small'>";
                                                $vString .= $vResultsBooks['number_books'][$b] . " x " . $vResultsBooks['title'][$b];
                                                if ($vResults[19][$x] == 0 && $vResultsBooks['in_stock'][$b] > 0) {
                                                    $vString .= " <span class='text-small-normal red'>(" . MysqlQuery::getText($pConn, 388)/*Gereed vir versending*/ . ")</span>";
                                                } else if ($vResults[19][$x] == 0 && $vResultsBooks['in_stock'][$b] == 0) {
                                                    $vString .= " <span class='text-small-normal red'>(" . MysqlQuery::getText($pConn, 389)/*Nie in voorraad*/ . ")</span>";
                                                }
                                                $vString .= "</div>";
                                                $vString .= "<div class='col-xs-2  col-md-2 col-right text-col-small'>";
                                                $vString .= "R " . $vResultsBooks['price'][$b];
                                                $vString .= "</div>";
                                                $vString .= "<div class='col-xs-1  col-md-2 col-right text-col-small'>";
                                                $vString .= "</div>";

                                                $vString .= "</div>";//row
                                            }
                                        }
											$vString .="<hr class='light-green'>";
										$vString .="</div>";//col
									$vString .="</div>";//row
								}
						}
						else {
							$vString .="<div class='row'>";
								$vString .= "<div class='col-xs-12'>";
									$vString .= "<h5 class='gray'>".MysqlQuery::getText($pConn, 320)/*Jou bestel geskiedenis is leeg*/."</h5>";
									$vString .= "<hr class='light-gray'>";
								$vString .="</div>";
							$vString .="</div>";
						}
				$vString .= "</div>";//Body
		$vString .= "</div>";//profile
		return General::prepareStringForDisplay($vString);
	}
}