<?php
/**
 * @author Carin Pretorius - CEIT Development
 * Created on 2016-11-02
 */

class Modal {

	public static function getLoginForm($pConn){
		$vPageUrl = General::curPageURL();

		$vString = "<div id=\"login\" class=\"modal fade\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">";
			$vString .= "<div class=\"modal-dialog\" role=\"document\">";
				$vString .= "<div class=\"modal-content\">";
					$vString .= "<form class=\"form-horizontal loginFrm form-no-space\" name=\"loginForm\" id=\"loginForm\" method=\"post\" action=\"process.php\">";
						$vString .= "<div class=\"modal-header\">";
							$vString .= "<i class=\"icon-window-close close\" data-dismiss=\"modal\"></i>";
							$vString .= "<h2 class=\"modal-title red\">".MysqlQuery::getText($pConn, 237)/*Teken aan*/."</h2>";
						$vString .= "</div>";//header
						$vString .= "<div class=\"modal-body\">";
							$vString .="<div class=\"row\">";
								$vString .= "<div class=\"col-xs-12\">";
									$vString .= "<label for=\"username\" class=\"modal-label\">".MysqlQuery::getText($pConn, 239)/*Gebruikersnaam / Epos*/.":</label>";
									$vString .= "<input type=\"text\" class=\"modal-input\" name=\"login_username\" id=\"login_username\" value=\"".($_COOKIE["cookie_graf_remun"] ?? '')."\" placeholder=\"".MysqlQuery::getText($pConn, 239)/*Gebruikersnaam / Epos*/."\" required>";
								$vString .= "</div>";
							$vString .= "</div>";
							$vString .="<div class=\"row\">";
								$vString .= "<div class=\"col-xs-12\">";
									$vString .= "<label for=\"password\" class=\"modal-label\">".MysqlQuery::getText($pConn, 99)/*Wagwoord*/.":</label>";
									$vString .= "<input type=\"password\" class=\"modal-input\" name=\"login_password\" id=\"login_password\" value=\"\" placeholder=\"".MysqlQuery::getText($pConn, 99)/*Wagwoord*/."\" required autocomplete=\"off\">";
									$vString .= "&nbsp;<span toggle=\"#login_password\" class=\"fa fa-fw fa-eye field-icon toggle-password\"></span>";
								$vString .= "</div>";
							$vString .= "</div>";
							$vString .="<div class=\"row\">";
								$vString .= "<div class=\"col-xs-12\">";
										$vString .= "<label for=\"language\" class=\"modal-label\">".MysqlQuery::getText($pConn, 307)/*Webwerf taal*/.":</label>";
										$vString .= "<select name=\"login_language\" id=\"login_language\">";
										if($_SESSION['SessionGrafLanguage'] && $_SESSION['SessionGrafLanguage'] == "af" || !isset($_SESSION['SessionGrafLanguage'])){
											$vString .= "<option value=\"af\" selected>Afrikaans</option>";
											$vString .= "<option value=\"en\">Engels</option>";
										}
										else if($_SESSION['SessionGrafLanguage'] && $_SESSION['SessionGrafLanguage'] == "en"){
											$vString .= "<option value=\"af\">Afrikaans</option>";
											$vString .= "<option value=\"en\" selected>English</option>";
										}
										$vString .= "</select>";
									$vString .= "</div>";
								$vString .= "</div>";
								$vString .="<div class=\"row\">";
									$vString .= "<div class=\"col-xs-12\">";
										$vString .= "<label class=\"checkbox green checkbox-inline\">";
											$vString .= "<input type=\"checkbox\" name=\"remember\" id=\"remember\" value=\"1\"";
												(isset($_COOKIE['cookie_graf_remme']) && $_COOKIE['cookie_graf_remme'] == 1 ? $vString .= "checked" : $vString .= "");
											$vString .= ">".MysqlQuery::getText($pConn, 241)/*Onthou my*/;
										$vString .= "</label>";
									$vString .= "</div>";
								$vString .= "</div>";
								$vString .="<div class=\"row\">";
									$vString .= "<div class=\"col-xs-12\">";
										$vString .="<div id=\"login_error\" class=\"error\" style=\"display:none;\">".MysqlQuery::getText($pConn, 244)/*Jou Gebruikersnaam / Epos of Wagwoord is verkeerd...*/."</div>";
										$vString .="<div id=\"login_complete\" class=\"complete\" style=\"display:none;\">".MysqlQuery::getText($pConn, 243)/*Voltooi asseblief die verpligte velde*/."</div>";
										$vString .="<div id=\"login_many\" class=\"error\" style=\"display:none;\">".MysqlQuery::getText($pConn, 245)/*Jammer, jy het te veel keer probeer inteken!*/."</div>";
									$vString .="</div>";
								$vString .= "</div>";
						$vString .="</div>";	//body
						$vString .= "<div class=\"modal-footer\">";
								$vString .="<div class=\"row\">";
									$vString .="<div class=\"col-xs-12 modal-cms\">";
										$vString .= "<input type=\"hidden\" name=\"type\" value=\"login\">";
										$vString .= "<input type=\"hidden\" name=\"redirect-url\" id=\"redirect-url\" value=\"".$vPageUrl."\">";
										$vString .= "<a data-target=\"#password_reset\" id=\"message\" role=\"button\" data-toggle=\"modal\" data-dismiss=\"modal\" class=\"text-xsmall space-right\" title=\"".MysqlQuery::getText($pConn, 433)/*Wagwoord vergeet?*/."\">".MysqlQuery::getText($pConn, 433)/*Wagwoord vergeet?*/."</a>";
										$vString .= "<button type=\"submit\" id=\"loginSubmit\" class=\"btn btn-primary\">".MysqlQuery::getText($pConn, 237)/*Teken aan*/."</button>";
										$vString .= "<button type=\"submit\" id=\"formClose\" class=\"btn btn-primary\" data-dismiss=\"modal\">".MysqlQuery::getText($pConn, 54)/*Maak toe*/."</button>";
									$vString .="</div>";
								$vString .="</div>";
						$vString .="</div>";//footer
						$vString .= "</form>";
					$vString .= "</div>";
				$vString .= "</div>";
			$vString .= "</div>";

			$vString .= "<Script>
                $('.toggle-password').click(function() {
                  $(this).toggleClass('fa-eye fa-eye-slash');
                  var input = $($(this).attr('toggle'));
                  if (input.attr('type') == 'password') {
                    input.attr('type', 'text');
                  } else {
                    input.attr('type', 'password');
                  }
                });
                </Script>
            ";
		return General::prepareStringForDisplay($vString);
	}

	public static function getRegisterSuccess($pConn){
		$vString = "<div id=\"registrationsuccess\" class=\"modal fade\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">";
			$vString .= "<div class=\"modal-dialog\" role=\"document\">";
				$vString .= "<div class=\"modal-content\">";
					$vString .= "<div class=\"modal-header\">";
						$vString .="<div class=\"row\">";
							$vString .="<div class=\"col-xs-12 green\">";
								$vString .= "<i class=\"icon-window-close close\" data-dismiss=\"modal\"></i>";
								$vString .= "<h2 class=\"modal-title red\">".MysqlQuery::getText($pConn, 255)/*Sukses!.*/."</h2>";
							$vString .="</div>";
						$vString .="</div>";
					$vString .= "</div>";//header
					$vString .= "<div class=\"modal-body\">";
						$vString .="<div class=\"row\">";
							$vString .="<div class=\"col-xs-12 green\">";
								$vString .= MysqlQuery::getText($pConn, 261);//*Jou registrasie was suksesvol. Jy sal 'n epos met 'n skakel vir die bevestiging van die registrasie van Graffiti ontvang. Verifieer asseblief die regsitrasie deur op die skakel te klik.
							$vString .="</div>";
						$vString .="</div>";
					$vString .= "</div>";//body
						$vString .= "<div class=\"modal-footer\">";
								$vString .="<div class=\"row\">";
									$vString .="<div class=\"col-xs-12\">";
										$vString .= "<button type=\"submit\" id=\"passwordClose\" class=\"btn btn-primary\" data-dismiss=\"modal\">".MysqlQuery::getText($pConn, 54)/*Maak toe*/."</button>";
									$vString .="</div>";
								$vString .="</div>";
						$vString .="</div>";//footer
				$vString .= "</div>";//content
			$vString .= "</div>";//dialog
		$vString .= "</div>";
		return General::prepareStringForDisplay($vString);
	}

	public static function getValidateSuccess($pConn){
		$vString = "<div id=\"validatesuccess\" class=\"modal fade\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">";
			$vString .= "<div class=\"modal-dialog\" role=\"document\">";
				$vString .= "<div class=\"modal-content\">";
					$vString .= "<div class=\"modal-header\">";
						$vString .="<div class=\"row\">";
							$vString .="<div class=\"col-xs-12 green\">";
								$vString .= "<i class=\"icon-window-close close\" data-dismiss=\"modal\"></i>";
								$vString .= "<h2 class=\"modal-title red\">".MysqlQuery::getText($pConn, 255)/*Sukses!.*/."</h2>";
							$vString .="</div>";
						$vString .="</div>";
					$vString .= "</div>";//header
					$vString .= "<div class=\"modal-body\">";
						$vString .="<div class=\"row\">";
							$vString .="<div class=\"col-xs-12 green\">";
								$vString .= MysqlQuery::getText($pConn, 268);//*Jou registrasie is geverifieer. Teken aan om voort te gaan met jou aankope!
							$vString .="</div>";
						$vString .="</div>";
					$vString .= "</div>";//body
						$vString .= "<div class=\"modal-footer\">";
								$vString .="<div class=\"row\">";
									$vString .="<div class=\"col-xs-12\">";
										$vString .= "<button type=\"submit\" id=\"passwordClose\" class=\"btn btn-primary\" data-dismiss=\"modal\">".MysqlQuery::getText($pConn, 54)/*Maak toe*/."</button>";
									$vString .="</div>";
								$vString .="</div>";
						$vString .="</div>";//footer
				$vString .= "</div>";//content
			$vString .= "</div>";//dialog
		$vString .= "</div>";
		return General::prepareStringForDisplay($vString);
	}

	public static function getValidateError($pConn){
		$vString = "<div id=\"validateerror\" class=\"modal fade\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">";
			$vString .= "<div class=\"modal-dialog\" role=\"document\">";
				$vString .= "<div class=\"modal-content\">";
					$vString .= "<div class=\"modal-header\">";
						$vString .="<div class=\"row\">";
							$vString .="<div class=\"col-xs-12 green\">";
								$vString .= "<i class=\"icon-window-close close\" data-dismiss=\"modal\"></i>";
								$vString .= "<h2 class=\"modal-title red\">".MysqlQuery::getText($pConn, 172)/*Fout!.*/."</h2>";
							$vString .="</div>";
						$vString .="</div>";
					$vString .= "</div>";//header
					$vString .= "<div class=\"modal-body\">";
						$vString .="<div class=\"row\">";
							$vString .="<div class=\"col-xs-12 red\">";
								$vString .= MysqlQuery::getText($pConn, 269);//*Jou registrasie is nie geverifieer nie. Kontak asseblief Graffiti om jou te help daarmee.
								$vString .= "<p><br><a href=\"\" class=\"email\" title=\"Graffiti\">orders at graffitibooks.co.za</a></p>";
							$vString .="</div>";
						$vString .="</div>";
					$vString .= "</div>";//body
						$vString .= "<div class=\"modal-footer\">";
								$vString .="<div class=\"row\">";
									$vString .="<div class=\"col-xs-12\">";
										$vString .= "<button type=\"submit\" id=\"passwordClose\" class=\"btn btn-primary\" data-dismiss=\"modal\">".MysqlQuery::getText($pConn, 54)/*Maak toe*/."</button>";
									$vString .="</div>";
								$vString .="</div>";
						$vString .="</div>";//footer
				$vString .= "</div>";//content
			$vString .= "</div>";//dialog
		$vString .= "</div>";

		return General::prepareStringForDisplay($vString);
	}

	public static function getPasswordChange($pConn){
		$vString = "<div id=\"password\" class=\"modal fade\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">";
			$vString .= "<div class=\"modal-dialog\" role=\"document\">";
				$vString .= "<div class=\"modal-content\">";
					$vString .= "<form class=\"form-horizontal loginFrm form-no-space\" name=\"passwordForm\" id=\"passwordForm\" method=\"post\" action=\"process.php\">";
						$vString .= "<div class=\"modal-header\">";
							$vString .= "<i class=\"icon-window-close close\" data-dismiss=\"modal\"></i>";
							$vString .= "<h2 class=\"modal-title red\">".MysqlQuery::getText($pConn, 272)/*Verander wagwoord*/."</h2>";
						$vString .= "</div>";//header
						$vString .= "<div class=\"modal-body\">";
							$vString .="<div class=\"row\">";
								$vString .= "<div class=\"col-xs-12\">";
										$vString .= "<label for=\"username\" class=\"modal-label\">".MysqlQuery::getText($pConn, 99)/*Wagwoord*/.":</label>";
										$vString .= "<input type=\"password\" name=\"change_password\" id=\"change_password\" placeholder=\"******\" pattern=\".{6,}\" title=\"Must be 6 characters or longer\" required size=\"30\" maxlength=\"45\" autocomplete=\"off\"><i class=\"fa fa-asterisk fa-required red\" aria-hidden=\"true\"></i>";
									$vString .= "</div>";
								$vString .= "</div>";
								$vString .="<div class=\"row\">";
									$vString .= "<div class=\"col-xs-12\">";
										$vString .= "<label for=\"password\" class=\"modal-label\">".MysqlQuery::getText($pConn, 100)/*Herhaal wagwoord*/.":</label>";
										$vString .= "<input type=\"password\" name=\"change_password2\" id=\"change_password2\" placeholder=\"******\" pattern=\".{6,}\" title=\"Must be 6 characters or longer\" required size=\"30\" maxlength=\"45\" autocomplete=\"off\"><i class=\"fa fa-asterisk fa-required red\" aria-hidden=\"true\"></i>";
									$vString .= "</div>";
								$vString .= "</div>";
								$vString .="<div class=\"row\">";
									$vString .= "<div class=\"col-xs-12\">";
										$vString .="<div id=\"password_complete\" class=\"complete\" style=\"display:none;\">".MysqlQuery::getText($pConn, 243)/*Voltooi asseblief die verpligte velde*/."</div>";
										$vString .="<div id=\"password_password\" class=\"error\" style=\"display:none;\">".MysqlQuery::getText($pConn, 250)/*Die twee wagwoorde verskil.*/."</div>";
										$vString .="<div id=\"password_success\" class=\"success\" style=\"display:none;\">".MysqlQuery::getText($pConn, 275)/*Jou wagwoord is suksesvol verander.*/."</div>";
										$vString .="<div id=\"password_error\" class=\"error\" style=\"display:none;\">".MysqlQuery::getText($pConn, 276)/*Jou wagwoord is nie verander. Probeer asseblief weer.*/."</div>";
									$vString .="</div>";
								$vString .= "</div>";
						$vString .="</div>";	//body
						$vString .= "<div class=\"modal-footer\">";
								$vString .="<div class=\"row\">";
									$vString .="<div class=\"col-xs-12\">";
										$vString .= "<input type=\"hidden\" name=\"password_client_id\" id=\"password_client_id\" value=\"\">";
										$vString .= "<input type=\"hidden\" name=\"type\" value=\"password-edit\">";
										$vString .= "<button type=\"submit\" id=\"passwordSubmit\" class=\"btn btn-primary\">".MysqlQuery::getText($pConn, 72)/*Stoor*/."</button>";
										$vString .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"submit\" id=\"passwordClose\" class=\"btn btn-primary\" data-dismiss=\"modal\">".MysqlQuery::getText($pConn, 54)/*Maak toe*/."</button>";
									$vString .="</div>";
								$vString .="</div>";
						$vString .="</div>";//footer
						$vString .= "</form>";
					$vString .= "</div>";
				$vString .= "</div>";
			$vString .= "</div>";

		return General::prepareStringForDisplay($vString);
	}

	public static function getPasswordReset($pConn){
		$vString = "<div id=\"password_reset\" class=\"modal fade\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">";
			$vString .= "<div class=\"modal-dialog\" role=\"document\">";
				$vString .= "<div class=\"modal-content\">";
					$vString .= "<form class=\"form-horizontal loginFrm form-no-space\" name=\"passwordResetForm\" id=\"passwordResetForm\" method=\"post\" action=\"process.php\">";
						$vString .= "<div class=\"modal-header\">";
							$vString .= "<i class=\"icon-window-close close\" data-dismiss=\"modal\"></i>";
							$vString .= "<h2 class=\"modal-title red\">".MysqlQuery::getText($pConn, 433)/*Wagwoord vergeet?*/."</h2>";
						$vString .= "</div>";//header
						$vString .= "<div class=\"modal-body\">";
							$vString .="<div class=\"row\">";
								$vString .= "<div class=\"col-xs-12\">";
									$vString .= "<label for=\"username\" class=\"modal-label\">".MysqlQuery::getText($pConn, 239)/*Gebruikersnaam / Epos*/.":</label>";
									$vString .= "<input type=\"text\" class=\"modal-input\" name=\"username\" id=\"username\" value=\"\" placeholder=\"".MysqlQuery::getText($pConn, 239)/*Gebruikersnaam / Epos*/."\" required>";
								$vString .= "</div>";
								$vString .= "<div class=\"col-xs-12\">";
									$vString .= "<p><small class=\"red\">".MysqlQuery::getText($pConn, 435)/*Jy sal 'n epos met tydelike ....*/."</small></p>";
								$vString .= "</div>";
							$vString .= "</div>";
							$vString .="<div class=\"row\">";
								$vString .= "<div class=\"col-xs-12\">";
									$vString .="<div id=\"reset_complete\" class=\"complete\" style=\"display:none;\">".MysqlQuery::getText($pConn, 243)/*Voltooi asseblief die verpligte velde*/."</div>";
									$vString .="<div id=\"reset_success\" class=\"success\" style=\"display:none;\">".MysqlQuery::getText($pConn, 440)/*Die epos met tydelike wagwoord is gestuur*/."</div>";
									$vString .="<div id=\"reset_error\" class=\"complete\" style=\"display:none;\">".MysqlQuery::getText($pConn, 441)/*Die epos met tydelike wagwoord is nie gestuur nie*/."</div>";
									$vString .="<div id=\"reset_not_exist\" class=\"complete\" style=\"display:none;\">".MysqlQuery::getText($pConn, 442)/*Jou epos is nie geregistreer op ons stelsel nie. Registreer asseblief om voort te gaan.*/."</div>";
								$vString .="</div>";
							$vString .= "</div>";
						$vString .="</div>";	//body
						$vString .= "<div class=\"modal-footer\">";
								$vString .="<div class=\"row\">";
									$vString .="<div class=\"col-xs-12\">";
										$vString .= "<input type=\"hidden\" name=\"type\" value=\"password-reset\">";
										$vString .= "<input type=\"hidden\" name=\"language\" value=\"".$_SESSION['SessionGrafLanguage']."\">";
										$vString .= "<button type=\"submit\" id=\"passwordResetSubmit\" class=\"btn btn-primary\">".MysqlQuery::getText($pConn, 436)/*Stuur epos*/."</button>";
										$vString .= "<button type=\"submit\" id=\"passwordResetClose\" class=\"btn btn-primary\" data-dismiss=\"modal\">".MysqlQuery::getText($pConn, 54)/*Maak toe*/."</button>";
									$vString .="</div>";
								$vString .="</div>";
						$vString .="</div>";//footer
						$vString .= "</form>";
					$vString .= "</div>";
				$vString .= "</div>";
			$vString .= "</div>";

		return General::prepareStringForDisplay($vString);
	}

	public static function getAddCartError($pConn){
		$vString = "<div id=\"carteerror\" class=\"modal fade\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">";
			$vString .= "<div class=\"modal-dialog\" role=\"document\">";
				$vString .= "<div class=\"modal-content\">";
					$vString .= "<div class=\"modal-header\">";
						$vString .="<div class=\"row\">";
							$vString .="<div class=\"col-xs-12 green\">";
								$vString .= "<i class=\"icon-window-close close\" data-dismiss=\"modal\"></i>";
								$vString .= "<h2 class=\"modal-title red\">".MysqlQuery::getText($pConn, 172)/*Fout!.*/."</h2>";
							$vString .="</div>";
						$vString .="</div>";
					$vString .= "</div>";//header
					$vString .= "<div class=\"modal-body\">";
						$vString .="<div class=\"row\">";
							$vString .="<div class=\"col-xs-12 red\">";
								$vString .= MysqlQuery::getText($pConn, 284);//*Jammer, die boek is nie in jou mandjie gelaai nie. Probeer assebief weer.
								$vString .= "<br><br>".MysqlQuery::getText($pConn, 359);//*Kontak asseblief Graffiti indien die fout herhaaldelik voorkom.
								$vString .= "<p><br><a href=\"\" class=\"email\" title=\"Graffiti\">orders at graffitibooks.co.za</a></p>";
							$vString .="</div>";
						$vString .="</div>";
					$vString .= "</div>";//body
						$vString .= "<div class=\"modal-footer\">";
								$vString .="<div class=\"row\">";
									$vString .="<div class=\"col-xs-12\">";
										$vString .= "<button type=\"submit\" id=\"passwordClose\" class=\"btn btn-primary\" data-dismiss=\"modal\">".MysqlQuery::getText($pConn, 54)/*Maak toe*/."</button>";
									$vString .="</div>";
								$vString .="</div>";
						$vString .="</div>";//footer
				$vString .= "</div>";//content
			$vString .= "</div>";//dialog
		$vString .= "</div>";

		return General::prepareStringForDisplay($vString);
	}

	public static function getBookMoreInfo($pConn){
		$vString = "<div id=\"bookinfo\" class=\"modal fade\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">";
			$vString .= "<div class=\"modal-dialog\" role=\"document\">";
				$vString .= "<div class=\"modal-content\">";
					$vString .= "<div class=\"modal-header\">";
						$vString .="<div class=\"row\">";
							$vString .="<div class=\"col-xs-12 green\">";
								$vString .= "<i class=\"icon-window-close close\" data-dismiss=\"modal\"></i>";
								$vString .= "<h2 class=\"modal-title red\" id=\"heading\"></h2>";
							$vString .="</div>";
						$vString .="</div>";
					$vString .= "</div>";//header
					$vString .= "<div class=\"modal-body\">";
						$vString .="<div class=\"row info-detail\">";
							$vString .="<div class=\"col-xs-12 green\">";
								$vString .= "<b class=\"red\">".MysqlQuery::getText($pConn, 377)/*Dimensies*/.":</b>&nbsp;&nbsp;<span  id=\"dimensions\"></span>&nbsp;&nbsp;(".MysqlQuery::getText($pConn, 378).")<br>";/*Hoogte x Wydte x Dikte*/
							$vString .="</div>";
						$vString .="</div>";
						$vString .="<div class=\"row info-detail\">";
							$vString .="<div class=\"col-xs-12 green\">";
								$vString .= "<b class=\"red\">".MysqlQuery::getText($pConn, 379)/*Gewig*/.":</b>&nbsp;&nbsp;<span  id=\"weight\"></span><br>";
							$vString .="</div>";
						$vString .="</div>";
						$vString .="<div class=\"row info-detail\">";
							$vString .="<div class=\"col-xs-12 green\">";
								$vString .= "<b class=\"red\">".MysqlQuery::getText($pConn, 380)/*Aantal bladsye*/.":</b>&nbsp;&nbsp;<span  id=\"no-pages\"></span><br>";
							$vString .="</div>";
						$vString .="</div>";
						$vString .="<div class=\"row info-detail\">";
							$vString .="<div class=\"col-xs-12 green\">";
								$vString .= "<b class=\"red\">".MysqlQuery::getText($pConn, 381)/*Formaat*/.":</b>&nbsp;&nbsp;<span  id=\"format\"></span><br>";
							$vString .="</div>";
						$vString .="</div>";
					$vString .= "</div>";//body
						$vString .= "<div class=\"modal-footer\">";
								$vString .="<div class=\"row\">";
									$vString .="<div class=\"col-xs-12\">";
										$vString .= "<button type=\"submit\" id=\"passwordClose\" class=\"btn btn-primary\" data-dismiss=\"modal\">".MysqlQuery::getText($pConn, 54)/*Maak toe*/."</button>";
									$vString .="</div>";
								$vString .="</div>";
						$vString .="</div>";//footer
				$vString .= "</div>";//content
			$vString .= "</div>";//dialog
		$vString .= "</div>";
		return General::prepareStringForDisplay($vString);
	}

	public static function getCourierInfo($pConn){
		$vString = "<div id=\"coureirinfo\" class=\"modal fade\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">";
			$vString .= "<div class=\"modal-dialog\" role=\"document\">";
				$vString .= "<div class=\"modal-content\">";
					$vString .= "<div class=\"modal-header\">";
						$vString .="<div class=\"row\">";
							$vString .="<div class=\"col-xs-12 green\">";
								$vString .= "<i class=\"icon-window-close close\" data-dismiss=\"modal\"></i>";
								$vString .= "<h2 class=\"modal-title red\">".MysqlQuery::getText($pConn, 371)/*Versendingsopsies*/."</h2>";
							$vString .="</div>";
						$vString .="</div>";
					$vString .= "</div>";//header
					$vString .= "<div class=\"modal-body\">";
						$vString .="<div class=\"row info-detail\">";
							$vString .="<div class=\"col-xs-12 green\">";
								$vString .= "<b class=\"dgreen\">".MysqlQuery::getLookupPerId($pConn, 1)/*Suid Afrika: Normale Pos*/."</b>:&nbsp;&nbsp;".MysqlQuery::getText($pConn, 372)."<br><br>";/*Normale Poskantoor posdiens binne Suid Afrika. Aflewering by 'n Poskantoor binne 10 - 21 dae.*/
							$vString .="</div>";
						$vString .="</div>";
						$vString .="<div class=\"row info-detail\">";
							$vString .="<div class=\"col-xs-12 green\">";
								$vString .= "<b class=\"dgreen\">".MysqlQuery::getLookupPerId($pConn, 2)/*Suid Afrika: Koerier - CourierIT*/."</b>:&nbsp;&nbsp;".MysqlQuery::getText($pConn, 373)."<br>";/*Courierit aflewering na 'n fisiese adres binne 10 dae.*/
								$vString .= "<a href=\"http://www.courierit.co.za/\" class=\"text-small red-menu space-top\" target=\"_blank\" title=\"CourierIT\"><img src=\"images/courierit.png\" alt=\"CourierIT\"></a><br><br>";
							$vString .="</div>";
						$vString .="</div>";
						$vString .="<div class=\"row info-detail\">";
							$vString .="<div class=\"col-xs-12 green\">";
								$vString .= "<b class=\"dgreen\">".MysqlQuery::getLookupPerId($pConn, 3)/*Suid Afrika: Koerier - Pargo*/."</b>:&nbsp;&nbsp;".MysqlQuery::getText($pConn, 374)."<br>";/*Pargo lewer jou pakkie af by 'n besigheid naby jou.*/
								$vString .= "<a href=\"https://pargo.co.za/\" class=\"text-small red-menu space-top\" target=\"_blank\" title=\"Pargo\"><img src=\"images/pargo.png\" alt=\"Pargo\"></a><br><br>";
							$vString .="</div>";
						$vString .="</div>";
						$vString .="<div class=\"row info-detail\">";
							$vString .="<div class=\"col-xs-12 green\">";
								$vString .= "<b class=\"dgreen\">".MysqlQuery::getLookupPerId($pConn, 4)/*Afhaal by Graffiti*/."</b>:&nbsp;&nbsp;".MysqlQuery::getText($pConn, 375)."<br><br>";/*Kom haal jou pakkie af by Winkel no 16, Zambezi Junction, Hoek van*/
							$vString .="</div>";
						$vString .="</div>";
						$vString .="<div class=\"row info-detail\">";
							$vString .="<div class=\"col-xs-12 green\">";
								$vString .= "<b class=\"dgreen\">".MysqlQuery::getLookupPerId($pConn, 5)/*Ander Land*/."</b>:&nbsp;&nbsp;".MysqlQuery::getText($pConn, 376)."<br><br>";/*Kies jou land en ons pos die pakkie met normale pos vir jou.*/
							$vString .="</div>";
						$vString .="</div>";
					$vString .= "</div>";//body
						$vString .= "<div class=\"modal-footer\">";
								$vString .="<div class=\"row\">";
									$vString .="<div class=\"col-xs-12\">";
										$vString .= "<button type=\"submit\" id=\"passwordClose\" class=\"btn btn-primary\" data-dismiss=\"modal\">".MysqlQuery::getText($pConn, 54)/*Maak toe*/."</button>";
									$vString .="</div>";
								$vString .="</div>";
						$vString .="</div>";//footer
				$vString .= "</div>";//content
			$vString .= "</div>";//dialog
		$vString .= "</div>";
		return General::prepareStringForDisplay($vString);
	}

	public static function openPargo($pConn){
		$vString = "<div id=\"pargo\" class=\"modal fade\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">";
			$vString .= "<div class=\"modal-dialog\" role=\"document\" id=\"pargo-modal\">";
				$vString .= "<div class=\"modal-content\">";
					$vString .= "<div class=\"modal-header\">";
						$vString .="<div class=\"row\">";
							$vString .="<div class=\"col-xs-12 green\">";
								$vString .= "<i class=\"icon-window-close close\" data-dismiss=\"modal\"></i>";
								$vString .= "<h2 class=\"modal-title red\">".MysqlQuery::getText($pConn,382)/*Kies 'n afleweringspunt*/."</h2>";
							$vString .="</div>";
						$vString .="</div>";
					$vString .= "</div>";//header
					$vString .= "<div class=\"modal-body\">";
						$vString .="<div class=\"row\">";
							$vString .="<iframe src=\"https://map.pargo.co.za/?token=YQw7kd9fQAdkxKefS3GW8PNCRXBuqg\" width=\"100%\" height=\"500\"></iframe>";
							$vString .="</div>";
						$vString .="</div>";
					$vString .= "</div>";//body
						$vString .= "<div class=\"modal-footer\">";
								$vString .="<div class=\"row\">";
									$vString .="<div class=\"col-xs-12\">";
										$vString .= "<button type=\"submit\" id=\"passwordClose\" class=\"btn btn-primary\" data-dismiss=\"modal\">".MysqlQuery::getText($pConn, 54)/*Maak toe*/."</button>";
									$vString .="</div>";
								$vString .="</div>";
						$vString .="</div>";//footer
				$vString .= "</div>";//content
			$vString .= "</div>";//dialog
		$vString .= "</div>";

		return General::prepareStringForDisplay($vString);
	}

	public static function getOrderHistoryPayment($pConn){
		$vString = "<div id=\"orderhistorypay\" class=\"modal fade\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">";
			$vString .= "<div class=\"modal-dialog\" role=\"document\">";
				$vString .= "<div class=\"modal-content\">";
					$vString .= "<div class=\"modal-header\">";
						$vString .="<div class=\"row\">";
							$vString .="<div class=\"col-xs-12 green\">";
								$vString .= "<i class=\"icon-window-close close\" data-dismiss=\"modal\"></i>";
								$vString .= "<h2 class=\"modal-title red\" id=\"heading\">".MysqlQuery::getText($pConn, 393)/*Betalingsbesonderhede*/."</h2>";
							$vString .="</div>";
						$vString .="</div>";
					$vString .= "</div>";//header
					$vString .= "<div class=\"modal-body\">";
						$vString .="<div class=\"row info-detail\">";
							$vString .="<div class=\"col-xs-12 green\">";
								$vString .= "<b class=\"red\">".MysqlQuery::getText($pConn, 323)/*Betaal*/.":</b>&nbsp;&nbsp;<span  id=\"paid\"></span><br>";
							$vString .="</div>";
						$vString .="</div>";
						$vString .="<div class=\"row info-detail\">";
							$vString .="<div class=\"col-xs-12 green\">";
								$vString .= "<b class=\"red\">".MysqlQuery::getText($pConn, 113)/*Betalingsmetode*/.":</b>&nbsp;&nbsp;<span  id=\"method\"></span><br>";
							$vString .="</div>";
						$vString .="</div>";
						$vString .="<div class=\"row info-detail\">";
							$vString .="<div class=\"col-xs-12 green\">";
								$vString .= "<b class=\"red\">".MysqlQuery::getText($pConn, 302)/*Bedrag*/.":</b>&nbsp;&nbsp;R <span  id=\"price\"></span><br>";
							$vString .="</div>";
						$vString .="</div>";
						$vString .="<div class=\"row info-detail\">";
							$vString .="<div class=\"col-xs-12 green\">";
								$vString .= "<b class=\"red\">".MysqlQuery::getText($pConn, 310)/*Afleweringskoste*/.":</b>&nbsp;&nbsp;R <span  id=\"delivery\"></span><br>";
							$vString .="</div>";
						$vString .="</div>";
						$vString .="<div class=\"row info-detail\">";
							$vString .="<div class=\"col-xs-12 green\">";
								$vString .= "<b class=\"red\">".MysqlQuery::getText($pConn, 292)/*Totale bestelling koste*/.":</b>&nbsp;&nbsp;R <span  id=\"total\"></span><br>";
							$vString .="</div>";
						$vString .="</div>";

					$vString .= "</div>";//body
						$vString .= "<div class=\"modal-footer\">";
								$vString .="<div class=\"row\">";
									$vString .="<div class=\"col-xs-12\">";
										$vString .= "<button type=\"submit\" id=\"payClose\" class=\"btn btn-primary\" data-dismiss=\"modal\">".MysqlQuery::getText($pConn, 54)/*Maak toe*/."</button>";
									$vString .="</div>";
								$vString .="</div>";
						$vString .="</div>";//footer
				$vString .= "</div>";//content
			$vString .= "</div>";//dialog
		$vString .= "</div>";
		return General::prepareStringForDisplay($vString);
	}

	public static function getOrderHistoryDispatch($pConn){
		$vString = "<div id=\"orderhistorydispatch\" class=\"modal fade\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">";
			$vString .= "<div class=\"modal-dialog\" role=\"document\">";
				$vString .= "<div class=\"modal-content\">";
					$vString .= "<div class=\"modal-header\">";
						$vString .="<div class=\"row\">";
							$vString .="<div class=\"col-xs-12 green\">";
								$vString .= "<i class=\"icon-window-close close\" data-dismiss=\"modal\"></i>";
								$vString .= "<h2 class=\"modal-title red\" id=\"heading\">".MysqlQuery::getText($pConn, 296)/*Versending*/."</h2>";
							$vString .="</div>";
						$vString .="</div>";
					$vString .= "</div>";//header
					$vString .= "<div class=\"modal-body\">";
						$vString .="<div class=\"row info-detail\">";
							$vString .="<div class=\"col-xs-12 green\">";
								$vString .= "<b class=\"red\">".MysqlQuery::getText($pConn, 324)/*Versend*/.":</b>&nbsp;&nbsp;<span  id=\"dispatch\"></span><br>";
							$vString .="</div>";
						$vString .="</div>";
						$vString .="<div class=\"row info-detail\">";
							$vString .="<div class=\"col-xs-12 green\">";
								$vString .= "<b class=\"red\">".MysqlQuery::getText($pConn, 394)/*Versendingsopsie*/.":</b>&nbsp;&nbsp;<span  id=\"method\"></span><br>";
							$vString .="</div>";
						$vString .="</div>";
						$vString .="<div class=\"row info-detail\">";
							$vString .="<div class=\"col-xs-12 green\">";
								$vString .= "<b class=\"red\">".MysqlQuery::getText($pConn, 108)/*Versendingskoste*/.":</b>&nbsp;&nbsp;R <span  id=\"cost\"></span><br>";
							$vString .="</div>";
						$vString .="</div>";
						$vString .="<div class=\"row info-detail\">";
							$vString .="<div class=\"col-xs-12 green\">";
								$vString .= "<b class=\"red\">".MysqlQuery::getText($pConn, 325)/*Naspoorno.*/.":</b>&nbsp;&nbsp;<span  id=\"tracking\"></span><br>";
							$vString .="</div>";
						$vString .="</div>";
						$vString .="<div class=\"row info-detail\">";
							$vString .="<div class=\"col-xs-12 green\">";
								$vString .= "<b class=\"red\">".MysqlQuery::getText($pConn, 288)/*Afleweringsadres*/.":</b>&nbsp;&nbsp;<span  id=\"detail\"></span><br>";
							$vString .="</div>";
						$vString .="</div>";
						$vString .="<div class=\"row info-detail\">";
							$vString .="<div class=\"col-xs-12 green\">";
								$vString .= "<b class=\"red\">".MysqlQuery::getText($pConn, 153)/*Aflewerings boodskap*/.":</b>&nbsp;&nbsp;<span  id=\"message\"></span><br>";
							$vString .="</div>";
						$vString .="</div>";

					$vString .= "</div>";//body
						$vString .= "<div class=\"modal-footer\">";
								$vString .="<div class=\"row\">";
									$vString .="<div class=\"col-xs-12\">";
										$vString .= "<button type=\"submit\" id=\"dispatchClose\" class=\"btn btn-primary\" data-dismiss=\"modal\">".MysqlQuery::getText($pConn, 54)/*Maak toe*/."</button>";
									$vString .="</div>";
								$vString .="</div>";
						$vString .="</div>";//footer
				$vString .= "</div>";//content
			$vString .= "</div>";//dialog
		$vString .= "</div>";
		return General::prepareStringForDisplay($vString);
	}

	public static function loadModals($pConn){
		$vString = "";
			if(!isset($_SESSION['SessionGrafUserId']) || $_SESSION['SessionGrafUserId'] == '' || !is_int($_SESSION['SessionGrafUserId'])){
				$vLoginForm = Modal::getLoginForm($pConn);
				$vString .= $vLoginForm;
			}

			//$vShoppingCart = Modal::getShoppingCart($pConn);
			//$vString .= $vShoppingCart;

			$vRegistrationSuccess = Modal::getRegisterSuccess($pConn);
			$vString .= $vRegistrationSuccess;

			$vValidateSuccess = Modal::getValidateSuccess($pConn);
			$vString .= $vValidateSuccess;

			$vValidateError = Modal::getValidateError($pConn);
			$vString .=  $vValidateError;

			$vPasswordChange = Modal::getPasswordChange($pConn);
			$vString .= $vPasswordChange;

			$vPasswordReset = Modal::getPasswordReset($pConn);
			$vString .= $vPasswordReset;

			$vCartError = Modal::getAddCartError($pConn);
			$vString .= $vCartError;

			$vCourierInfo = Modal::getCourierInfo($pConn);
			$vString .= $vCourierInfo;

			$vBookMoreInfo = Modal::getBookMoreInfo($pConn);
			$vString .= $vBookMoreInfo;

			$vOrderHistory = Modal::getOrderHistoryPayment($pConn);
			$vOrderHistory .= Modal::getOrderHistoryDispatch($pConn);
			$vString .= $vOrderHistory;

			return $vString;
	}

	public static function loadEventInfo($pConn, $pId, $pName, $pDetail, $pDate, $pTime, $pRsvp, $pPrice, $pLocation, $pPosterPath){
				//$vId, $vName, $vDetail, $vDate, $vTime, $vRsvp, $vPrice, $vLocation, $vPosterPath

		$vString = "<div id=\"event_".$pId."\" class=\"modal fade\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">";
			$vString .= "<div class=\"modal-dialog\" role=\"document\">";
				$vString .= "<div class=\"modal-content\">";
						$vString .= "<div class=\"modal-header\">";
							$vString .= "<i class=\"icon-window-close close\" data-dismiss=\"modal\"></i>";
							$vString .= "<h2 class=\"modal-title red\">".MysqlQuery::getText($pConn, 345)/*Boekbekendstellings*/."</h2>";
						$vString .= "</div>";//header
						$vString .= "<div class=\"modal-body\">";
							$vString .="<div class=\"row\">";
								$vString .= "<div class=\"col-xs-12\">";
									$vString .= "<h5 class=\"green\">".date('d M Y', strtotime($pDate))." - ".$pName."</h5>";
								$vString .= "</div>";
							$vString .= "</div>";
							$vString .="<div class=\"row\">";
								$vString .= "<div class=\"col-xs-12\">";
									$vString .= "<div class=\"blue\">".$pDetail."</div>";
								$vString .= "</div>";
							$vString .= "</div>";
							$vString .="<div class=\"row\">";
								$vString .= "<div class=\"col-xs-12\">";
									$vString .= "<div class=\"blue space-top\"><b>".MysqlQuery::getText($pConn, 346)/*Tyd*/."</b>: ".$pTime."</div>";
								$vString .= "</div>";
							$vString .= "</div>";
							$vString .="<div class=\"row\">";
								$vString .= "<div class=\"col-xs-12\">";
									$vString .= "<div class=\"blue\"><b>".MysqlQuery::getText($pConn, 348)/*RSVP teen*/."</b>: ".date('d M Y', strtotime($pRsvp))."</div>";
								$vString .= "</div>";
							$vString .= "</div>";
							$vString .="<div class=\"row\">";
								$vString .= "<div class=\"col-xs-12\">";
									$vString .= "<div class=\"blue\"><b>".MysqlQuery::getText($pConn, 349)/*Prys per persoon*/."</b>: R".$pPrice."</div>";
								$vString .= "</div>";
							$vString .= "</div>";
							$vString .="<div class=\"row\">";
								$vString .= "<div class=\"col-xs-12\">";
									$vString .= "<div class=\"blue\"><b>".MysqlQuery::getText($pConn, 347)/*Plek*/."</b>: ".$pLocation."</div>";
								$vString .= "</div>";
							$vString .= "</div>";
								if($pRsvp >= $_SESSION['now_date']){
									$vString .="<div class=\"row\">";
										$vString .= "<div class=\"col-xs-12\">";
											$vString .= "<div class=\"blue text-small space-top\"><b>".MysqlQuery::getText($pConn, 350)/*Bespreek by*/."</b> <a href=\"tel:+27 12 548 2356\" title=\"+27 12 548 2356\">+27 (0)12 548 2356</a>&nbsp;&nbsp;of&nbsp;&nbsp;<a href=\"mailto:\" title=\"Graffiti\" data-type=\"Webwerf bespreking\" data-date=\"".$pDate."\" class=\"email-event lower\">shop at graffitibooks.co.za</a></div>";
										$vString .= "</div>";
									$vString .= "</div>";
								}
						$vString .="</div>";	//body
						$vString .= "<div class=\"modal-footer\">";
								$vString .="<div class=\"row\">";
									$vString .="<div class=\"col-xs-12\">";
										//$vString .= "<input type=\"hidden\" name=\"id\" id=\"id\" value=\"\">";
										//$vString .= "<input type=\"hidden\" name=\"type\" value=\"password-edit\">";
										$vString .= "<button type=\"submit\" id=\"eventClose\" class=\"btn btn-primary\" data-dismiss=\"modal\">".MysqlQuery::getText($pConn, 54)/*Maak toe*/."</button>";
									$vString .="</div>";
								$vString .="</div>";
						$vString .="</div>";//footer
					$vString .= "</div>";
				$vString .= "</div>";
			$vString .= "</div>";

		return General::prepareStringForDisplay($vString);
	}

}
?>