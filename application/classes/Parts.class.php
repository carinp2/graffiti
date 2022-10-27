<?php
/**
 * @author Carin Pretorius - CEIT Development
 * Created on 2016-11-02
 */

class Parts {

	public function getHtmlBegin($pConn, $pType, $pValue, $pParam, $pSubCatId){
		$vString = "";
		if(is_string($pValue) && $pValue == "a"){
			$vMetaResults = MysqlQuery::getBooksMetaInfo($pConn, $pValue, str_replace("~", ".", $pParam));//$vId, $vTitle, $vAuthor, $vSummary, $vCategory, $vSubCategory, $vBlobPath
			if($_SESSION['SessionGrafLanguage'] == 'af'){
				 $vTitle = $vMetaResults[1].": ".$vMetaResults[2]." Graffiti Boeke";
				 $vDescription = $vMetaResults[1]." [".$vMetaResults[2]."] ".General::substr_word(General::prepareStringForMeta($vMetaResults[3]), 320);
				 $vKeywords = $vMetaResults[2].", ".$vMetaResults[1].", ".$vMetaResults[4].", ".$vMetaResults[5];
				 $vMetaString ="\n	<meta property=\"og:site_name\" content=\"Graffiti Boeke\">";
			}
			else {
				 $vTitle = $vMetaResults[1].": ".$vMetaResults[2]." Graffiti Books";
				 $vDescription = $vMetaResults[1]." [".$vMetaResults[2]."] ".General::substr_word(General::prepareStringForMeta($vMetaResults[3]), 320);
				 $vKeywords = $vMetaResults[2].", ".$vMetaResults[1].", ".$vMetaResults[4].", ".$vMetaResults[5];
				 $vMetaString ="\n	<meta property=\"og:site_name\" content=\"Graffiti Books\">";
			}
			$vMetaString .="\n	<meta property=\"fb:app_id\" content=\"701264160060226\" />";
			$vMetaString .="\n	<meta property=\"og:url\" content=\"".$_SESSION['SessionGrafFullServerUrl']."\" />";
			$vMetaString .="\n	<meta property=\"og:type\" content=\"book\" />";
			$vMetaString .="\n	<meta property=\"og:title\" content=\"".$vMetaResults[1].": ".$vMetaResults[2]."\" />";
			$vMetaString .="\n	<meta property=\"og:description\" content=\"".General::substr_word(General::prepareStringForMeta($vMetaResults[3]), 300)."\" />";
			$vMetaString .="\n	<meta property=\"og:image\" content=\"".$_SESSION['SessionGrafFullServerUrl']."images/books/".$vMetaResults[6]."\" />";
			$vMetaString .="\n	<meta property=\"og:site_name\" content=\"\">";

			$vMetaString .="\n	<meta name=\"twitter:card\" content=\"summary\" />";
			$vMetaString .="\n	<meta name=\"twitter:site\" content=\"@Graffiti_Boeke\" />";
			$vMetaString .="\n	<meta name=\"twitter:title\" content=\"".$vMetaResults[1].": ".$vMetaResults[2]."\" />";
			$vMetaString .="\n	<meta name=\"twitter:description\" content=\"".General::substr_word(General::prepareStringForMeta($vMetaResults[3]), 280)."\" />";
			$vMetaString .="\n	<meta name=\"twitter:image\" content=\"".$_SESSION['SessionGrafFullServerUrl']."images/books/".$vMetaResults[6]."\" />";
		}
		else if(is_string($pValue) && $pValue == "m"){
			$vMetaResults = MysqlQuery::getCategorySubCategoryFromSubCat($pConn, $pSubCatId);//$vSubCategory, $vCategory
			if($_SESSION['SessionGrafLanguage'] == 'af'){
				 $vTitle = $vMetaResults[1]." - ".$vMetaResults[0].": Graffiti Boeke";
				 $vDescription = $vMetaResults[1]." - ".$vMetaResults[0].": Koop aanlyn en spaar tot 20% op Nuwe Vrystellings, Topverkopers en Engelse algemene publikasies. Graffiti vir nuwe boeke, topverkopers, opvoedkundige boeke, Christelike boeke en winskopies. Kry ook jou Moleskine Joernaal hier teen 20% afslag.";
				$vKeywords = $vMetaResults[1].", ".$vMetaResults[0].", Graffiti, Graffiti Boeke, Boeke, Aanlyn, Koop Aanlyn, Boekwinkel, Afrikaans, Afrikaanse, Suid Afrika, Afrikaanse Boeke, Studiegidse, Leermiddels, Kinderboeke, Skryfbehoeftes, Dagboeke, Legkaarte, Woordeboeke, Atlasse";
				$vMetaString ="\n	<meta property=\"og:site_name\" content=\"Graffiti Boeke\">";
			}
			else {
				$vMetaString .="\n	<meta property=\"og:site_name\" content=\"Graffiti Books\">";
				 $vTitle = $vMetaResults[1]." - ".$vMetaResults[0].": Graffiti Books";
				 $vDescription = $vMetaResults[1]." - ".$vMetaResults[0].": Buy online and save up to 20% on Afrikaans New Releases and Bestsellers, as well as on English general publications. Graffiti for new releases, bestsellers, Christian books, educational books and bargains. Stockist of Moleskine Journals.";
				 $vKeywords = $vMetaResults[1].", ".$vMetaResults[0].", Graffiti, Graffiti Books, Books, Online, Online Shopping, Bookshop, Afrikaans, South Africa, Afrikaans Books, Study Guides, Children, Stationery, Diaries, Puzzles, Dictionaries, Atlasses";
				 $vMetaString ="\n	<meta property=\"og:site_name\" content=\"Graffiti Books\">";
			}
			$vMetaString .="\n	<meta property=\"fb:app_id\" content=\"701264160060226\" />";//af/m/Soek/1/date_publish+DESC/Fiksie/Kortverhale
			$vMetaString .="\n	<meta property=\"og:url\" content=\"".$_SESSION['SessionGrafFullServerUrl']."\" />";
			$vMetaString .="\n	<meta property=\"og:type\" content=\"book\" />";
			$vMetaString .="\n	<meta property=\"og:title\" content=\"".$vMetaResults[1].": ".$vMetaResults[0]."\" />";
			$vMetaString .="\n	<meta property=\"og:description\" content=\"".$vMetaResults[1].": ".$vMetaResults[0]."\" />";
			$vMetaString .="\n	<meta property=\"og:image\" content=\"".$_SESSION['SessionGrafFullServerUrl']."images/graflogo.png\" />";

			$vMetaString .="\n	<meta name=\"twitter:card\" content=\"summary\" />";
			$vMetaString .="\n	<meta name=\"twitter:site\" content=\"@Graffiti_Boeke\" />";
			$vMetaString .="\n	<meta name=\"twitter:title\" content=\"".$vMetaResults[1].": ".$vMetaResults[0]."\" />";
			$vMetaString .="\n	<meta name=\"twitter:description\" content=\"".$vMetaResults[1].": ".$vMetaResults[0]."\" />";
			$vMetaString .="\n	<meta name=\"twitter:image\" content=\"".$_SESSION['SessionGrafFullServerUrl']."images/graflogo.png\" />";
		}
		else if(!is_string($pValue) && ($pValue > 210 && $pValue != 446 & $pValue != 447)){//Not Homepage books
			$vMetaResults = MysqlQuery::getBooksMetaInfo($pConn, $pValue, $pParam);
			if($_SESSION['SessionGrafLanguage'] == 'af'){
				 $vTitle = $vMetaResults[1]." ".$vMetaResults[2].": Graffiti Boeke";
				 $vDescription = $vMetaResults[1]." [".$vMetaResults[2]."] ".General::substr_word(General::prepareStringForMeta($vMetaResults[3]), 320);
				 $vKeywords = $vMetaResults[2].", ".$vMetaResults[1].", ".$vMetaResults[4].", ".$vMetaResults[5];
				 $vMetaString ="\n	<meta property=\"og:site_name\" content=\"Graffiti Boeke\">";
			}
			else {
				 $vTitle = $vMetaResults[1]." ".$vMetaResults[2].": Graffiti Books";
				 $vDescription = $vMetaResults[1]." [".$vMetaResults[2]."] ".General::substr_word(General::prepareStringForMeta($vMetaResults[3]), 320);
				 $vKeywords = $vMetaResults[2].", ".$vMetaResults[1].", ".$vMetaResults[4].", ".$vMetaResults[5];
				 $vMetaString ="\n	<meta property=\"og:site_name\" content=\"Graffiti Books\">";
			}
			$vMetaString .="\n	<meta property=\"fb:app_id\" content=\"701264160060226\" />";
			$vMetaString .="\n	<meta property=\"og:url\" content=\"".$_SESSION['SessionGrafFullServerUrl'].$_SESSION['SessionGrafLanguage']."/".$vMetaResults[0]."/Boek\" />";
			$vMetaString .="\n	<meta property=\"og:type\" content=\"book\" />";
			$vMetaString .="\n	<meta property=\"og:title\" content=\"".$vMetaResults[1]."\" />";
			$vMetaString .="\n	<meta property=\"og:description\" content=\"".General::substr_word(General::prepareStringForMeta($vMetaResults[3]), 300)."\" />";
			$vMetaString .="\n	<meta property=\"og:image\" content=\"".$_SESSION['SessionGrafFullServerUrl']."images/books/".$vMetaResults[6]."\" />";

			$vMetaString .="\n	<meta name=\"twitter:card\" content=\"summary\" />";
			$vMetaString .="\n	<meta name=\"twitter:site\" content=\"@Graffiti_Boeke\" />";
			$vMetaString .="\n	<meta name=\"twitter:title\" content=\"".$vMetaResults[1]."\" />";
			$vMetaString .="\n	<meta name=\"twitter:description\" content=\"".General::substr_word(General::prepareStringForMeta($vMetaResults[3]), 280)."\" />";
			$vMetaString .="\n	<meta name=\"twitter:image\" content=\"".$_SESSION['SessionGrafFullServerUrl']."images/books/".$vMetaResults[6]."\" />";
		}
		else if(!is_string($pValue) && ($pValue == 204 || $pValue == 206 || $pValue == 208 || $pValue == 209 || $pValue == 446 || $pValue == 447)){
			if($_SESSION['SessionGrafLanguage'] == 'af'){
				$vMetaString = MysqlQuery::getCmsText($pConn, $pValue."/", 'af');
				$vTitle = $vMetaString.": Graffiti Boeke";
				$vDescription = $vMetaString.": Koop boeke aanlyn en spaar tot 20% op Nuwe Vrystellings, Topverkopers en Engelse algemene publikasies. Graffiti vir nuwe boeke, topverkopers, opvoedkundige boeke, Christelike boeke en winskopies. Kry ook jou Moleskine Joernaal hier teen 20% afslag.";
				$vKeywords = $vMetaString.", Graffiti, Graffiti Boeke, Boeke, Aanlyn, Koop Aanlyn, Boekwinkel, Afrikaans, Afrikaanse, Suid Afrika, Afrikaanse Boeke, Studiegidse, Leermiddels, Kinderboeke, Skryfbehoeftes, Dagboeke, Legkaarte, Woordeboeke, Atlasse";
				$vMetaString ="\n	<meta property=\"og:site_name\" content=\"Graffiti Boeke\">";
			}
			else {
				$vMetaString = MysqlQuery::getCmsText($pConn, $pValue."/", 'en');
				 $vTitle = $vMetaString.": Graffiti Books";
				 $vDescription = $vMetaString.": Buy books online and save up to 20% on Afrikaans New Releases and Bestsellers, as well as on English general publications. Graffiti for new releases, bestsellers, Christian books, educational books and bargains. Stockist of Moleskine Journals.";
				 $vKeywords = $vMetaString.", Graffiti, Graffiti Books, Books, Online, Online Shopping, Bookshop, Afrikaans, South Africa, Afrikaans Books, Study Guides, Children, Stationery, Diaries, Puzzles, Dictionaries, Atlasses";
				 $vMetaString ="\n	<meta property=\"og:site_name\" content=\"Graffiti Books\">";
			}
			$vMetaString .="\n	<meta property=\"fb:app_id\" content=\"701264160060226\" />";
			$vMetaString .="\n	<meta property=\"og:url\" content=\"https://www.graffitibooks.co.za\" />";
			$vMetaString .="\n	<meta property=\"og:type\" content=\"book\" />";
			$vMetaString .="\n	<meta property=\"og:title\" content=\"".$vTitle."\" />";
			$vMetaString .="\n	<meta property=\"og:description\" content=\"".$vDescription."\" />";
			$vMetaString .="\n	<meta property=\"og:image\" content=\"".$_SESSION['SessionGrafFullServerUrl']."images/graflogo.png\" />";

			$vMetaString .="\n	<meta name=\"twitter:card\" content=\"summary\" />";
			$vMetaString .="\n	<meta name=\"twitter:site\" content=\"@Graffiti_Boeke\" />";
			$vMetaString .="\n	<meta name=\"twitter:title\" content=\"".$vTitle."\" />";
			$vMetaString .="\n	<meta name=\"twitter:description\" content=\"".$vDescription."\" />";
			$vMetaString .="\n	<meta name=\"twitter:image\" content=\"".$_SESSION['SessionGrafFullServerUrl']."images/graflogo.png\" />";
		}
		else if($pType == "Grootontbyt"){
			$vTitle = "Die Groot Ontbyt Boeke : Graffiti Boeke";
			$vTvBooks = MysqlQuery::getTvBooks($pConn);
			if($_SESSION['SessionGrafLanguage'] == 'af'){
				$vDescription = "Leonie van Rensburg boekbespreking op Die Groot Ontbyt. Boeke bespreek: ".implode(", ", $vTvBooks[0]);
				$vKeywords = implode(", ", $vTvBooks[0]).", Graffiti, Graffiti Boeke, Boeke, Aanlyn, Koop Aanlyn, Boekwinkel, Afrikaans, Afrikaanse, Suid Afrika, Afrikaanse Boeke, Studiegidse, Leermiddels, Kinderboeke, Skryfbehoeftes, Dagboeke, Legkaarte, Woordeboeke, Atlasse";
				$vMetaString ="\n	<meta property=\"og:site_name\" content=\"Graffiti Boeke\">";
			}
			else {
				 $vDescription = "Leonie van Rensburg book discussion on Die Groot Ontbyt. Books discussed: ".implode(", ", $vTvBooks[0]);
				 $vKeywords = implode(", ", $vTvBooks[0]).", Graffiti, Graffiti Books, Books, Online, Online Shopping, Bookshop, Afrikaans, South Africa, Afrikaans Books, Study Guides, Children, Stationery, Diaries, Puzzles, Dictionaries, Atlasses";
				 $vMetaString ="\n	<meta property=\"og:site_name\" content=\"Graffiti Books\">";
			}
			$vMetaString .="\n	<meta property=\"fb:app_id\" content=\"701264160060226\" />";
			$vMetaString .="\n	<meta property=\"og:url\" content=\"https://www.graffitibooks.co.za\" />";
			$vMetaString .="\n	<meta property=\"og:type\" content=\"book\" />";
			$vMetaString .="\n	<meta property=\"og:title\" content=\"".$vTitle."\" />";
			$vMetaString .="\n	<meta property=\"og:description\" content=\"".$vDescription."\" />";
			$vMetaString .="\n	<meta property=\"og:image\" content=\"".$_SESSION['SessionGrafFullServerUrl']."images/graflogo.png\" />";

			$vMetaString .="\n	<meta name=\"twitter:card\" content=\"summary\" />";
			$vMetaString .="\n	<meta name=\"twitter:site\" content=\"@Graffiti_Boeke\" />";
			$vMetaString .="\n	<meta name=\"twitter:title\" content=\"".$vTitle."\" />";
			$vMetaString .="\n	<meta name=\"twitter:description\" content=\"".$vDescription."\" />";
			$vMetaString .="\n	<meta name=\"twitter:image\" content=\"".$_SESSION['SessionGrafFullServerUrl']."images/graflogo.png\" />";
		}
		else {
			if($_SESSION['SessionGrafLanguage'] == 'af'){
				$vTitle = "Graffiti Boeke - Koop Afrikaanse en Engelse boeke aanlyn";
				$vDescription = "Koop boeke aanlyn en spaar tot 20% op Nuwe Vrystellings, Topverkopers en Engelse algemene publikasies. Graffiti vir nuwe boeke, topverkopers, opvoedkundige boeke, Christelike boeke en winskopies. Kry ook jou Moleskine Joernaal hier teen 20% afslag.";
				$vKeywords = "Graffiti, Graffiti Boeke, Boeke, Aanlyn, Koop Aanlyn, Boekwinkel, Afrikaans, Afrikaanse, Suid Afrika, Afrikaanse Boeke, Studiegidse, Leermiddels, Kinderboeke, Skryfbehoeftes, Dagboeke, Legkaarte, Woordeboeke, Atlasse";
				$vMetaString ="\n	<meta property=\"og:site_name\" content=\"Graffiti Boeke\">";
			}
			else {
				 $vTitle = "Graffiti Books - Buy Afrikaans and English books online";
				 $vDescription = "Buy books online and save up to 20% on Afrikaans New Releases and Bestsellers, as well as on English general publications. Graffiti for new releases, bestsellers, Christian books, educational books and bargains. Stockist of Moleskine Journals.";
				 $vKeywords = "Graffiti, Graffiti Books, Books, Online, Online Shopping, Bookshop, Afrikaans, South Africa, Afrikaans Books, Study Guides, Children, Stationery, Diaries, Puzzles, Dictionaries, Atlasses";
				 $vMetaString ="\n	<meta property=\"og:site_name\" content=\"Graffiti Books\">";
			}
			$vMetaString .="\n	<meta property=\"fb:app_id\" content=\"701264160060226\" />";
			$vMetaString .="\n	<meta property=\"og:url\" content=\"https://www.graffitibooks.co.za\" />";
			$vMetaString .="\n	<meta property=\"og:type\" content=\"book\" />";
			$vMetaString .="\n	<meta property=\"og:title\" content=\"".$vTitle."\" />";
			$vMetaString .="\n	<meta property=\"og:description\" content=\"".$vDescription."\" />";
			$vMetaString .="\n	<meta property=\"og:image\" content=\"".$_SESSION['SessionGrafFullServerUrl']."images/graflogo.png\" />";

			$vMetaString .="\n	<meta name=\"twitter:card\" content=\"summary\" />";
			$vMetaString .="\n	<meta name=\"twitter:site\" content=\"@Graffiti_Boeke\" />";
			$vMetaString .="\n	<meta name=\"twitter:title\" content=\"".$vTitle."\" />";
			$vMetaString .="\n	<meta name=\"twitter:description\" content=\"".$vDescription."\" />";
			$vMetaString .="\n	<meta name=\"twitter:image\" content=\"".$_SESSION['SessionGrafFullServerUrl']."images/graflogo.png\" />";
	}

		$vString .= "<!DOCTYPE html>";
			$vString .= "\n<html lang=\"en\">";
			$vString .= "\n<head>";
				$vString .= "\n<meta charset=\"utf-8\">";
				$vString .= "\n<base href=\"".$_SESSION['SessionGrafFullServerUrl']."\" />";
				$vString .= "\n<title>".$vTitle."</title>";
				$vString .= "\n<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">";
				$vString .= "\n<meta name=\"description\" content=\"".$vDescription."\">";
				$vString .= "\n<meta name=\"keywords\" content=\"".$vKeywords."\">";
				$vString .= "\n<meta name=\"author\" content=\"Graffiti\">";

				$vString .= $vMetaString;

				$vString .= "\n<link href=\"css/bootstrap.css\" media=\"screen\" id=\"callCss\" rel=\"stylesheet\" />";
				$vString .= "\n<link href=\"".$_SESSION['SessionGrafStyle']."\" rel=\"stylesheet\" media=\"screen\"/>";
				$vString .= "\n<link href=\"css/font-awesome.css\" rel=\"stylesheet\" type=\"text/css\">";
				$vString .= "\n<link href=\"css/menu.css\" rel=\"stylesheet\" type=\"text/css\" />";
				$vString .= "\n<link href=\"css/lightbox.min.css\" rel=\"stylesheet\" type=\"text/css\">";
				$vString .= "\n<link href=\"css/jquery-ui.css\" rel=\"stylesheet\" type=\"text/css\">";
				$vString .= "\n<style type=\"text/css\" id=\"enject\"></style>";
				$vString .= "\n<link href=\"images/icon.ico\" rel=\"shortcut icon\" >";

				$vCanonical = $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
				($_SESSION['SessionGrafLanguage'] == "af" ? $vCanonicalAltLang = "en" : $vCanonicalAltLang = $_SESSION['SessionGrafLanguage']);
				if (strpos($vCanonical, '/af/') === false && strpos($vCanonical, '/en/') === false) {
 					$vString .= "\n<link rel=\"canonical\" href=\"https://".$vCanonical."\" />";
 					$vString .= "\n<link rel=\"alternate\" href=\"https://".$vCanonical.$_SESSION['SessionGrafLanguage']."\" hreflang=\"x-default\" />";
 					$vString .= "\n<link rel=\"alternate\" href=\"https://".$vCanonical.$vCanonicalAltLang."\" hreflang=\"".$vCanonicalAltLang."\" />";
				}
				else {
					if($_SESSION['SessionGrafLanguage'] == $vCanonicalAltLang && $_SESSION['SessionGrafLanguage'] == "af"){
						$vAltCanonicalString = str_replace("/".$_SESSION['SessionGrafLanguage']."/", "/en/", $vCanonical);
						$vCanonicalAltLang = "en";
					}
					else if($_SESSION['SessionGrafLanguage'] == $vCanonicalAltLang && $_SESSION['SessionGrafLanguage'] == "en"){
						$vAltCanonicalString = str_replace("/".$_SESSION['SessionGrafLanguage']."/", "/af/", $vCanonical);
						$vCanonicalAltLang = "af";
					}
					else {
						$vAltCanonicalString = str_replace("/".$_SESSION['SessionGrafLanguage']."/", "/".$vCanonicalAltLang."/", $vCanonical);
					}
					$vString .= "\n<link rel=\"canonical\" href=\"https://".$vCanonical."\" />";
 					$vString .= "\n<link rel=\"alternate\" href=\"https://".$vCanonical."\" hreflang=\"x-default\" />";
 					$vString .= "\n<link rel=\"alternate\" href=\"https://".$vAltCanonicalString."\" hreflang=\"".$vCanonicalAltLang."\" />";
				}

//				if($_SESSION['SessionGrafLanguage'] == 'af' && strpos($_SESSION['SessionGrafFullServerUrl'], 'graffitiboeke') !== false){
//					$vString .= "\n<link rel=\"canonical\" href=\"https://www.graffitiboeke.co.za\" />";
//					$vString .= "\n<link rel=\"alternate\" href=\"https://www.graffitiboeke.co.za/af\" hreflang=\"x-default\" />";
//					$vString .= "\n<link rel=\"alternate\" href=\"https://www.graffitiboeke.co.za/en\" hreflang=\"en\" />";
//				}
//				else if($_SESSION['SessionGrafLanguage'] == 'en' && strpos($_SESSION['SessionGrafFullServerUrl'], 'graffitiboeke') !== false){
//					$vString .= "\n<link rel=\"canonical\" href=\"https://www.graffitiboeke.co.za\" />";
//					$vString .= "\n<link rel=\"alternate\" href=\"https://www.graffitiboeke.co.za/en\" hreflang=\"x-default\" />";
//					$vString .= "\n<link rel=\"alternate\" href=\"https://www.graffitiboeke.co.za/af\" hreflang=\"af\" />";
//				}
//				else if($_SESSION['SessionGrafLanguage'] == 'af' && strpos($_SESSION['SessionGrafFullServerUrl'], 'graffitibooks') !== false){
//					$vString .= "\n<link rel=\"canonical\" href=\"https://www.graffitibooks.co.za\" />";
//					$vString .= "\n<link rel=\"alternate\" href=\"https://www.graffitibooks.co.za/af\" hreflang=\"x-default\" />";
//					$vString .= "\n<link rel=\"alternate\" href=\"https://www.graffitibooks.co.za/en\" hreflang=\"en\" />";
//				}
//				else if($_SESSION['SessionGrafLanguage'] == 'en' && strpos($_SESSION['SessionGrafFullServerUrl'], 'graffitibooks') !== false){
//					$vString .= "\n<link rel=\"canonical\" href=\"https://www.graffitibooks.co.za\" />";
//					$vString .= "\n<link rel=\"alternate\" href=\"https://www.graffitibooks.co.za/en\" hreflang=\"x-default\" />";
//					$vString .= "\n<link rel=\"alternate\" href=\"https://www.graffitibooks.co.za/af\" hreflang=\"af\" />";
//				}
				$vString .= "\n<script>window.twttr = (function(d, s, id) {";
						$vString .= "\nvar js, fjs = d.getElementsByTagName(s)[0],";
						$vString .= "\nt = window.twttr || {};";
						$vString .= "\nif (d.getElementById(id)) return t;";
						$vString .= "\njs = d.createElement(s);";
						$vString .= "\njs.id = id;";
						$vString .= "\njs.src = \"https://platform.twitter.com/widgets.js\";";
						$vString .= "\nfjs.parentNode.insertBefore(js, fjs);";

						$vString .= "\nt._e = [];";
						$vString .= "\nt.ready = function(f) {";
						$vString .= "\nt._e.push(f);";
				  	$vString .= "\n};";
					$vString .= "\nreturn t;";
					$vString .= "\n}(document, \"script\", \"twitter-wjs\"));";
				$vString .= "\n</script>";

				$vString .= "<script src=\"js/jquery-3.1.1.min.js\" type=\"text/javascript\"></script>";

				$vString .= "\n<script src=\"https://www.google.com/recaptcha/api.js\"></script>";

				// <!-- Global site tag (gtag.js) - Google Analytics - IEDM -->
				$vString .= '<script async src="https://www.googletagmanager.com/gtag/js?id=UA-34467494-1">';
				$vString .= '</script>';
				$vString .= '<script type="text/javascript">';
				$vString .= 'window.dataLayer = window.dataLayer || [];';
				$vString .= 'function gtag(){dataLayer.push(arguments);}';
				$vString .= 'gtag("js", new Date());';
				$vString .= 'gtag("config", "UA-34467494-1");';
				$vString .= '</script>';

				//<!-- Bing -->
				$vString .= "<meta name=\"msvalidate.01\" content=\"847E6CCFA78BF5BF0508E9082DDABB4E\" />";

				//Google Structured data
				$vString .= "<script type=\"application/ld+json\">{
				  \"@context\" : \"http://schema.org\",
				  \"@type\" : \"LocalBusiness\",
                  \"image\" : \"https://www.graffitibooks.co.za/images/no_image.png\",
				  \"name\" : \"Graffiti Books & Stationery\",
				  \"telephone\" : \"+27 (0)12 548 2356\",
				  \"email\" : \"webmaster@graffitibooks.co.za\",
				  \"address\" : {
				    \"@type\" : \"PostalAddress\",
				    \"streetAddress\" : \"Shop no 10, Zambezi Junction, Corner of Breed Street and Sefako Makgatho Drive (previously Zambezi Drive), Montana\"
				  },
				  \"openingHoursSpecification\" : {
				    \"@type\" : \"OpeningHoursSpecification\",
				    \"dayOfWeek\" : {
				      \"@type\" : \"DayOfWeek\",
				      \"name\" : \"Monday to Sunday\"
				    }
				  },
				  \"url\" : \"https://www.graffitibooks.co.za/\",
                  \"priceRange\" : \"R10 - R3500\",
                  \"description\" : \"".$vDescription."\"
				}
				</script>";
            $vString .= "<meta name='p:domain_verify' content='4f6dde49769394b3854dc9f82436d520'/>";
			$vString .= "\n</head>";
			$vString .= "\n<body>";

			$vString .= "\n<div id=\"fb-root\"></div>";
			$vString .= "\n<script>(function(d, s, id) {";
				$vString .= "\nvar js, fjs = d.getElementsByTagName(s)[0];";
				$vString .= "\nif (d.getElementById(id)) return;";
				$vString .= "\njs = d.createElement(s); js.id = id;";
				$vString .= "\njs.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.11&appId=701264160060226';";
				$vString .= "\nfjs.parentNode.insertBefore(js, fjs);";
			$vString .= "\n}(document, 'script', 'facebook-jssdk'));</script>";

// 			$vString .= "<!-- Hotjar Tracking Code for https://www.graffitibooks.co.za -->";
// 			$vString .= "<script>";
// 			$vString .= "(function(h,o,t,j,a,r){";
// 			$vString .= "h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};";
// 			$vString .= "h._hjSettings={hjid:775530,hjsv:6};";
// 			$vString .= "a=o.getElementsByTagName('head')[0];";
// 			$vString .= "r=o.createElement('script');r.async=1;";
// 			$vString .= "r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;";
// 			$vString .= "a.appendChild(r);";
// 			$vString .= "})(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');";
// 			$vString .= "</script>";

// 			$vString .= '<!-- Google Code for Remarketing Tag -->';
// 			$vString .= '<!--------------------------------------------------';
// 			$vString .= 'Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. See more information and instructions on how to setup the tag on: http://google.com/ads/remarketingsetup';
// 			$vString .= '--------------------------------------------------->';
// 			$vString .= '<script type="text/javascript">';
// 			$vString .= '/* <![CDATA[ */ ';
// 			$vString .= 'var google_conversion_id = 819120782;';
// 			$vString .= 'var google_custom_params = window.google_tag_params;';
// 			$vString .= 'var google_remarketing_only = true;';
// 			$vString .= '/* ]]> */ ';
// 			$vString .= '</script>';
// 			$vString .= '<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">';
// 			$vString .= '</script>';
// 			$vString .= '<noscript>';
// 			$vString .= '<div style="display:inline;">';
// 			$vString .= '<img height="1" width="1" style="border-style:none;" alt="Google" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/819120782/?guid=ON&amp;script=0"/>';
// 			$vString .= '</div>';
// 			$vString .= '</noscript>';

			return General::prepareStringForDisplay($vString);
	}

	public static function getHeader($pConn, $vSections){
		$vUrl = General::getCleanUrlParameters();
		if(!empty($vUrl) && (strpos($vUrl, "Soek") == false && strpos($vUrl, "Search") == false)){
			$vAfUrl = preg_replace('/\ben\b/', "af", $vUrl);
			$vEnUrl = preg_replace('/\baf\b/', "en", $vUrl);
		}
		else if(empty($vUrl) && (strpos($vUrl, "Soek") !== false && strpos($vUrl, "Search") !== false)){
			$vAfUrl = "af/Tuisblad";
			$vEnUrl = "en/Home";
		}
		else {
			$vAfUrl = "af/Tuisblad";
			$vEnUrl = "en/Home";
		}

        $vTempClientId = (isset($_SESSION['SessionGrafUserId']) ? $_SESSION['SessionGrafUserId'] : $_SESSION['SessionGrafUserSessionId']);
		$vBindParams = array();
		$vBindLetters = "i";
		$vBindParams[] = & $vTempClientId;
        $vString = "";
		$vString .= "\n<div id=\"header\">";
			$vString .= "<div class=\"container\" id=\"static-header\">";
				$vString .= "\n<div id=\"welcomeLine\" class=\"row\">";
	      			$vString .= "<div class=\"col-xs-12 text-small\">";
	      				$vString .= "<ul class=\"welcome-menu\">";
		      				$vString .= "<li><a href=\"".$vAfUrl."\" class=\"text-small ";
		      					($_SESSION['SessionGrafLanguage'] == "af" ? $vString .= "gray-menu disabled" : $vString .= "red-menu");
                                  if($_SESSION['SessionGrafLanguage'] == "af"){
                                      $vAfTitle = MysqlQuery::getText($pConn, 334)/*Webwerf taal is*/." Afrikaans";
                                      $vEnTitle = MysqlQuery::getText($pConn, 308)/*Verander webwerf taal na*/." ".MysqlQuery::getText($pConn, 45);/*Engels*/
                                  }
                                  else if($_SESSION['SessionGrafLanguage'] == "en"){
                                      $vAfTitle = MysqlQuery::getText($pConn, 308)/*Verander webwerf taal na*/." ".MysqlQuery::getText($pConn, 11);/*Afrikaans*/
                                      $vEnTitle = MysqlQuery::getText($pConn, 334)/*Webwerf taal is*/." English";
                                  }
//		      					($_SESSION['SessionGrafLanguage'] == "af" ? $vAfTitle = MysqlQuery::getText($pConn, 334)/*Webwerf taal is*/." Afrikaans" : $vAfTitle = MysqlQuery::getText($pConn, 308)/*Verander webwerf taal na*/." ".MysqlQuery::getText($pConn, 11)/*Afrikaans*/);
//		      					($_SESSION['SessionGrafLanguage'] == "en" ? $vEnTitle = MysqlQuery::getText($pConn, 334)/*Webwerf taal is*/." English" : $vEnTitle = MysqlQuery::getText($pConn, 308)/*Verander webwerf taal na*/." ".MysqlQuery::getText($pConn, 45)/*Engels*/);
		      					$vString .= "\" data-toggle=\"tooltip\" data-placement=\"bottom\"  title=\"".$vAfTitle."\">".MysqlQuery::getText($pConn, 11)/*Afrikaans*/."</a></li>";
		      					$vString .= "<li><a href=\"".$vEnUrl."\" class=\"text-small ";
		      					($_SESSION['SessionGrafLanguage'] == "en" ? $vString .= "gray-menu" : $vString .= "red-menu");
		      				$vString .= "\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".$vEnTitle."\">".MysqlQuery::getText($pConn, 45)/*Engels*/."</a></li>";
		      			$vString .= "</ul>";
		      			$vString .= "<ul class=\"pull-right welcome-menu no-display\" id=\"admin-menu\">";
//                          Login changes - Add new sessionid checker for not logged-in users 17-10-2022 & remove cart section from if
                            $vOrderNumber = MysqlQuery::getCartSum($pConn, " WHERE client_id = ? and order_date is NULL and order_reference is NULL and order_id is NULL and temp_salt is not NULL", $vBindLetters, $vBindParams);
                            $vString .= "<li id=\"cart-anchor\"><a  href=\"".$_SESSION['SessionGrafLanguage']."/".$vTempClientId."/".MysqlQuery::getText($pConn, 285)/*BestelNou*/."\" class=\"red-menu\" title=\"".MysqlQuery::getText($pConn, 17)/*Bestel nou*/."\"><i class=\"fa fa-shopping-basket icon-shopping-cart glyphicon-shopping-cart my-cart-icon\" title=\"".MysqlQuery::getText($pConn, 17)/*Bestel nou*/."\"></i><span class=\"badge badge-notify\" id=\"cart-num\">".$vOrderNumber."</span></a></li>";
		      				if((!isset($_SESSION['SessionGrafUserId']) || $_SESSION['SessionGrafUserId'] == "") && isset($_SESSION['SessionGrafUserSessionId'])){
		      					$vString .= " <i class=\"my-cart-icon my-cart-invisible\" aria-hidden=\"true\"></i>";
		      					$vString .= " <li><a href=\"".$_SESSION['SessionGrafLanguage']."/0/".MysqlQuery::getText($pConn, 96)/*Registreer*/."\" class=\"text-small red\" title=\"".MysqlQuery::getText($pConn, 96)/*Registreer*/."\">".MysqlQuery::getText($pConn, 96)/*Registreer*/."</a></li>";
		      					$vString .= " <li><a data-target=\"#login\" role=\"button\" data-toggle=\"modal\" class=\"text-small red-menu\" title=\"".MysqlQuery::getText($pConn, 237)/*Teken aan*/."\">".MysqlQuery::getText($pConn, 237)/*Teken aan*/."</a></li>";
		      				}
		      				else {
		      					$vString .= "<li><a href=\"".$_SESSION['SessionGrafLanguage']."/Logout\" id=\"logoff\" class=\"text-small red-menu\" title=\"".MysqlQuery::getText($pConn, 270)/*Teken af*/."\"> ".MysqlQuery::getText($pConn, 270)/*Teken af*/."</a></li>";
		      					$vString .= "<li><a href=\"".$_SESSION['SessionGrafLanguage']."/".$_SESSION['SessionGrafUserId']."/".MysqlQuery::getText($pConn, 319)/*Profiel*/."/0\"id=\"profile\" class=\"text-small red-menu\" data-html=\"true\" data-toggle=\"tooltip\" data-placement=\"bottom\"  title=\"".MysqlQuery::getText($pConn, 216)/*Verander jou profiel*/."\"> ".$_SESSION['SessionGrafUserFirstname']."&nbsp;".$_SESSION['SessionGrafUserSurname']."</a></li>";
		      				}
		      				$vString .= "<li><a href=\"#\" id=\"searchtoggl\" class=\"red-menu\" title=\"".MysqlQuery::getText($pConn, 14)/*Soek*/."\"><i class=\"fa fa-search fa-lg\" aria-hidden=\"true\"></i>&nbsp;".MysqlQuery::getText($pConn, 14)/*Soek*/."</a></li>";
		      			$vString .= "</ul>";

			            	$vString .= "<div id=\"searchbar\" class=\"clearfix pull-right\">";
							    $vString .= "<form id=\"searchForm\" method=\"post\" action=\"".$_SESSION['SessionGrafLanguage']."/".MysqlQuery::getText($pConn, 14)/*Soek*/."\">";
							    	$vString .= "<span class=\"ui-widget\">";
				          				$vString .= "<input id=\"keyword\" name=\"keyword\" class=\"top-search keyword\" type=\"text\" autofocus/>";
// 				          			$vString .= "<select class=\"top-search top-search-select\" name=\"section\" id=\"section\">";
// 				            			if(count($vSections[0]) > 0){
// 				            				for($x = 0; $x < count($vSections[0]); $x++){
// 				            					if($vSections[0][$x] == 1 || $vSections[0][$x] == 3){
// 				            					$vString .= "<option value=\"".$vSections[0][$x]."\">".$vSections[1][$x]."&nbsp;</option>";
// 				            					}
// 				            				}
// 				            			}
// 				            		$vString .= "</select>";
				          			$vString .= "<input id=\"section\" name=\"section\" type=\"hidden\" value=\"1\"/>";
				          			$vString .= "<input id=\"autocomplete\" name=\"autocomplete\" type=\"hidden\"/>";
				            		$vString .= "<button type=\"submit\" id=\"searchButton\" class=\"btn btn-primary\">".MysqlQuery::getText($pConn, 14)."</button>";
				            		$vString .= "<input id=\"cat\" name=\"cat\" type=\"hidden\"/>";
				            		$vString .= "<input type=\"hidden\" value=\"".$_SESSION['SessionGrafLanguage']."\" id=\"language\" name=\"language\">";
				            		$vString .= "<input type=\"hidden\" value=\"k\" id=\"id\" name=\"id\">";
				            		$vString .= "<input type=\"hidden\" value=\"".MysqlQuery::getText($pConn, 14)/*Soek*/."\" id=\"page\" name=\"page\">";
				            		$vString .= "<input type=\"hidden\" value=\"date_publish DESC\" id=\"sort\" name=\"sort\">";
							    $vString .= "</form>";
								$vString .= "</span>";
			            	$vString .= "</div>";//clearfix

	           		$vString .= "</div>";//col-xs-12
	      		$vString .= "\n</div>";//welcomeLine
//		return General::prepareStringForDisplay($vString);
        return $vString;
	}

	public function getTopMenu($pConn, $pPage, $vSections){
		//$vSections = MysqlQuery::getSections($pConn, "", "ORDER BY sort_order", 0);//$vId, $vSection, $vUrl, $vDescription, $vSortOrder
		$vPageUrl = MysqlQuery::getText($pConn, 14);//Soek

		$vString = "\n\n	<nav id=\"cbp-hrmenu\" class=\"cbp-hrmenu\">";
		    	$vString .= "<a href=\"".$_SESSION['SessionGrafLanguage']."/".MysqlQuery::getText($pConn, 203)/*Tuisblad*/."\" title=\"".MysqlQuery::getText($pConn, 1)/*Tuisblad*/."\"><span itemprop=\"brand\" itemscope itemtype=\"http://schema.org/Brand\"><img itemprop=\"logo\" src=\"images/logo.png\" id=\"topLogo\" alt=\"".MysqlQuery::getText($pConn, 1)."\" class=\"top-logo\"/><meta itemprop=\"name\" content=\"Graffiti\"></span></span></a>";
		        $vString .= "<ul class=\"noborder\" >";
		        	$vString .= "<li id=\"top\"><a href=\"".$_SESSION['SessionGrafLanguage']."/".MysqlQuery::getText($pConn, 203)/*Tuisblad*/."\" class=\"menu normal\" title=\"".MysqlQuery::getText($pConn, 1)/*Tuisblad*/."\">".MysqlQuery::getText($pConn, 203)/*Tuisblad*/."</a></li>";
		        	if(isset($vSections[0]) && count($vSections[0]) > 0){
		    			for($i = 0; $i < count($vSections[0]); $i++){
		    				$vCategoryResults = MysqlQuery::getCategories($pConn, $vSections[0][$i], 1);
		    				(isset($vCategoryResults[0]) && count($vCategoryResults[0]) > 0 ? $vUrl = "#" : $vUrl = $_SESSION['SessionGrafLanguage']."/0/".$vSections[2][$i]."/1");
		    				(isset($vCategoryResults[0]) && count($vCategoryResults[0]) > 0 ? $vId = "top" : $vId = "top");
		    				//Covid == 7 || CDs == 9
		    				if($vSections[0][$i] != 7 && $vSections[0][$i] != 9){
		    					$vString .= "<li id=\"".$vId."\"><a href=\"".$vUrl."\" class=\"menu normal\" id=\"menu".$vSections[2][$i]."\" title=\"".$vSections[1][$i]."\">".$vSections[1][$i]."</a>";
		    				}
		    				else if($vSections[0][$i] == 7 || $vSections[0][$i] == 9){
		    					$vString .= "<li id=\"".$vId."\"><a href=\"".$vSections[2][$i]."\" target=\"_blank\" class=\"menu normal\" id=\"menu".$vSections[2][$i]."\" title=\"".$vSections[1][$i]."\">".$vSections[1][$i]."</a>";
		    				}
 							if(isset($vCategoryResults[0]) && count($vCategoryResults[0]) > 0){
 				                $vString .= "<div class=\"cbp-hrsub\">";
 				                    $vString .= "<div class=\"cbp-hrsub-inner\">";
 				                    if(isset($vCategoryResults[0]) && count($vCategoryResults[0]) > 0){
 										for($c = 0; $c < count($vCategoryResults[0]); $c++){
 											$vSubCategoryResults = MysqlQuery::getSubCategories($pConn, $vCategoryResults[0][$c], 1, $vSections[0][$i]);//$vSubCategoryId, $vSubCategory
 											$vString .= "<div>";
 												$vString .= "<h4>".$vCategoryResults[1][$c]."</h4>";
 								                $vString .= "<ul>";
 								                if(isset($vSubCategoryResults[0]) && count($vSubCategoryResults[0]) > 0){
	 								                for($s = 0; $s < count($vSubCategoryResults[0]); $s++){
	 								                	if($vSubCategoryResults[0][$s] <> 164){//Exclude pens
		 								                	$vUrl = $_SESSION['SessionGrafLanguage']."/m/".$vPageUrl."/".$vSubCategoryResults[0][$s]."/title+ASC/".General::prepareStringForUrl($vCategoryResults[1][$c])."/".General::prepareStringForUrl($vSubCategoryResults[1][$s]);
		 								                	$vString .= "<li><a href=\"".$vUrl."\" title=\"".$vSubCategoryResults[1][$s]."\">".$vSubCategoryResults[1][$s]."</a></li>";
	 								                	}
	 								                }
 								                }
 								                $vString .= " </ul>";
 											$vString .= "</div>";
 										}
 				                    }
 									$vString .= "</div>";//cbp-hrsub-inner -->
 				                $vString .= "</div>";//cbp-hrsub -->
 							}
				            $vString .= "</li>";
		    			}
					}
		        $vString .= "</ul>";
			$vString .= "</nav>";
			$vString .= "</div>";//container-->
			$vString .= "\n	</div>";
			$vString .= "\n\n<Script>var size = $('#cbp-hrmenu').height()-26; $('#topLogo').height(size);</Script>";

		return General::prepareStringForDisplay($vString);
	}

	public static function getMainBodyTop($pConn){
		$vString = "<div id=\"mainBody\">";
			    $vString .= "<div class=\"container\">";
					$vString .= "<div class=\"row\">";
						$vString .= "<div class=\"col-xs-12 red saleMessage\">".MysqlQuery::getText($pConn, 471)/*Afslag slegs op aanlynbestellings*/."</div>";
					$vString .= "</div>";
		return $vString;
	}

	public static function getMainBodyBottom(){
		$vString = "</div>";
			    $vString .= "</div>";
		return $vString;
	}

	public static function getFooter($pConn, $pPage){
		//$vLink1 = MysqlQuery::getLookup($pConn, "footer_link1");//$vId, $vText
		$vLink2 = MysqlQuery::getLookup($pConn, "footer_link2");
		$vLink3 = MysqlQuery::getCategories($pConn, 1, 1);//$vCategoryId, $vCategory
		$vCPageUrl = MysqlQuery::getText($pConn, 14);//Soek
		$vString = "<div id=\"footerSection\">";
			$vString .= "<div class=\"container\">";
				$vString .= "<div class=\"row\">";
					$vString .= "<div class=\"col-xs-12 col-md-4\">";
						$vString .= "<a href=\"#\" id=\"booksSubMenu\" title=\"".MysqlQuery::getText($pConn, 157)/*Boeke*/."\">".MysqlQuery::getText($pConn, 157)/*Boeke*/."</a>";
						$vString .= "<a href=\"".$_SESSION['SessionGrafLanguage']."/204/NuweVrystellings/af/new_rank ASC, date_publish DESC\" title=\"Nuwe vrystellings\">Nuwe vrystellings</a>";
						$vString .= "<a href=\"".$_SESSION['SessionGrafLanguage']."/209/Topverkopers/af/top_seller_rank ASC, date_publish DESC\" title=\"Topverkopers\">Topverkopers</a>";
						$vString .= "<a href=\"".$_SESSION['SessionGrafLanguage']."/204/NewReleases/en/new_rank ASC, date_publish DESC\" title=\"New releases\">New releases</a>";
						$vString .= "<a href=\"".$_SESSION['SessionGrafLanguage']."/209/Bestsellers/en/top_seller_rank ASC, date_publish DESC\" title=\"Bestsellers\">Bestsellers</a>";
						$vString .= "<a href=\"".$_SESSION['SessionGrafLanguage']."/446/NuutKinders-NewChildren/all/new_rank ASC, date_publish DESC\" title=\"Nuut Kinders / New Children\">Nuut Kinders / New Children</a>";
						$vString .= "<a href=\"".$_SESSION['SessionGrafLanguage']."/447/TopverkopersKinders-BestsellersChildren/all/top_seller_rank ASC, date_publish DESC\" title=\"Topverkopers Kinders / Bestsellers Children\">Topverkopers Kinders / Bestsellers Children</a>";
						$vString .= "<a href=\"".$_SESSION['SessionGrafLanguage']."/208/Winskopies-Specials/all/date_publish DESC\" title=\"Winskopies / Specials\">Winskopies / Specials</a>";
						$vString .= "<a href=\"".$_SESSION['SessionGrafLanguage']."/206/Binnekort-ComingSoon/all/date_publish DESC\" title=\"Binnekort / Coming soon\">Binnekort / Coming soon</a>";
					$vString .= "</div>";
					$vString .= " <div class=\"col-xs-12 col-md-4\">";//index.php?page=$3&id=$2&temp=$4&lang=$1
						for($y = 0; $y < count($vLink2[0]); $y++){
							$vLink2Url = General::prepareStringForUrl(str_replace(" ", "", ucwords($vLink2[1][$y])));
							if($vLink2[0][$y] == 56){//Boekbekendstellings
								$vString .= "<a href=\"".$_SESSION['SessionGrafLanguage']."/".$vLink2[0][$y]."/".$vLink2Url."/1\" title=\"".$vLink2[1][$y]."\">".$vLink2[1][$y]."</a>";
							}
							else if($vLink2[0][$y] == 58){//Covid
							    $vString .= "<a href=\"https://sacoronavirus.co.za\" title=\"COVID 19 Info\" target='_blank'>".$vLink2[1][$y]."</a>";
                            }
							else {
								($vLink2[0][$y] == 30 ? $vTitle = $vLink2[1][$y]." - ".MysqlQuery::getText($pConn, 473) : $vTitle = $vLink2[1][$y]);
								$vString .= "<a href=\"".$_SESSION['SessionGrafLanguage']."/".$vLink2[0][$y]."/Info/".$vLink2Url."\" title=\"".$vTitle."\">".$vLink2[1][$y]."</a>";
							}
						}
					$vString .= "</div>";
					$vString .= "<div id=\"socialMedia\" class=\"col-xs-12 col-md-4 text-xsmall\" itemprop=\"brand\" itemscope itemtype=\"http://schema.org/Brand\" itemref=\"topLogo\">";
		                $vString .= "<h5><span itemprop=\"name\">GRAFFITI</span> ZAMBEZI JUNCTION MONTANA</h5>";
		                $vString .= "<div><i class=\"fa fa-phone-square fa-2x\" aria-hidden=\"true\"></i><a href=\"tel:+27 12 548 2356\" title=\"+27 (0)12 548 2356\" class=\"space-left\"> +27 (0)12 548 2356</a></div>";
		                $vString .= "<div><i class=\"fa fa-envelope-o fa-2x\" aria-hidden=\"true\"></i><a href=\"mailto:\" class=\"email lower space-left\" title=\"Graffiti\">info at graffitibooks.co.za</a></div>";
		                $vString .= "<div class=\"small-spacing-top\">";
			                $vString .= "<a href=\"https://www.facebook.com/profile.php?id=182840481768825\" target=\"_blank\" title=\"Facebook\"><i class=\"fa fa-facebook fa-2x\" aria-hidden=\"true\"></i></a>";
			                $vString .= "<a href=\"https://twitter.com/Graffiti_Boeke\" target=\"_blank\" title=\"Twitter\"><i class=\"fa fa-twitter fa-2x icon-spacing\" aria-hidden=\"true\"></i></a>";
			                $vString .= "<a href=\"https://www.instagram.com/graffitiboeke/\" target=\"_blank\" title=\"Instagram\"><i class=\"fa fa-instagram fa-2x icon-spacing\" aria-hidden=\"true\"></i></a>";
			                $vString .= "<a href=\"https://api.whatsapp.com/send?phone=+27761166933\" target=\"_blank\" title=\"WhatsApp\"><i class=\"fa fa-whatsapp fa-2x icon-spacing\" aria-hidden=\"true\"></i></a>";
			                $vString .= "<a href=\"https://rss.com/podcasts/graffitibooks\" target=\"_blank\" title=\"Podcasts\"><i class=\"fa fa-spotify fa-2x icon-spacing\" aria-hidden=\"true\"></i></a>";
		                $vString .= "</div>";
					$vString .= "</div>";
				$vString .= "</div>";//row
				$vString .= "<hr class=\"light-green\">";
				$vString .= "<div class=\"cntr text-xsmall\">&copy; All Rights Reserved 2018</div>";
				$vString .= "<div><a href=\"https://www.ceit.cc\" class=\"ceit\" target=\"_blank\" title=\"CEIT Development\">A Product of CEIT Development</a></div>";
				$vString .= "<span class=\"no-display\">Koop Afrikaanse en Engelse boeke aanlyn en spaar tot 20% op Nuwe Vrystellings, Topverkopers en Engelse algemene publikasies. Graffiti vir nuwe boeke, topverkopers, opvoedkundige boeke, Christelike boeke en winskopies. Kry ook jou Moleskine Joernaal hier teen 20% afslag.</span>";
				$vString .= "<span class=\"no-display\">Buy Afrikaans and English books online and save up to 20% on Afrikaans New Releases and Bestsellers, as well as on English general publications. Graffiti for new releases, bestsellers, Christian books, educational books and bargains. Stockist of Moleskine Journals.</span>";
			$vString .= "</div>";//container
		$vString .= "</div>";//footerSection
		return General::prepareStringForDisplay($vString);
	}

	public static function getPageBottom($pConn){
        $vString = "<a id=\"scrollToTop\" href=\"#header\" title=\"Top\"><i class=\"fa fa-chevron-up\" aria-hidden=\"true\"></i></a>";

			$vString .= "<script type=\"text/javascript\" src=\"js/modernizr.js\"></script>";
			$vString .= "<script src=\"js/lightbox.min.js\"></script>";
			$vString .= "<script src=\"js/cbpHorizontalMenu.min.js\"></script>";
			$vString .= "<script src=\"js/jquery.showmore.min.js\"></script>";
			$vString .= "<script src=\"js/jquery-ui.min.js\"></script>";
			$vString .= "<script src=\"js/modernizr.custom.js\"></script>";
			$vString .= "<script src=\"js/bootstrap.min.js\" type=\"text/javascript\"></script>";
			$vString .= "<script src=\"".$_SESSION['SessionGrafScript'] ."\" type=\"text/javascript\"></script>";
			$vString .= "<script>";
					$vString .= "$(function() {";
						$vString .= "cbpHorizontalMenu.init();";
					$vString .= "});";
 					$vString .="$(window).on('load', function() {";
 						//$vString .="$(\".se-pre-con\").fadeOut(\"slow\");";
 						$vString .="$(\"#admin-menu\").fadeIn(\"slow\");";
 					$vString .="});";
			$vString .= "</script>";
			return General::prepareStringForDisplay($vString);
	}

	public static function getHtmlEnd(){
        $vString =  "<script type='text/javascript'>
            (function() {
            var s = document.createElement('script');s.type='text/javascript';s.async=true;s.id='lsInitScript';
            s.src='https://livesupporti.com/Scripts/clientAsync.js?acc=4c89d3a0-de77-4b82-b461-ad69f6dc8114&skin=Modern';
            var scr=document.getElementsByTagName('script')[0];scr.parentNode.appendChild(s, scr);
            })();
        </script>";
		$vString .=  "</html>";
		return $vString;
	}

	public static function getPagesPageTop($pConn){
		$vString = "<div id=\"mainBodyPages\">";
			$vString .= "<div class=\"container\">";
					$vString .= "<div class=\"row\">";
						$vString .= "<div class=\"col-xs-12 red saleMessage\">".MysqlQuery::getText($pConn, 471)/*Afslag slegs op aanlynbestellings*/."</div>";
					$vString .= "</div>";
				$vString .= "<div class=\"row\">";
		return $vString;
	}

	public static function getPagesPageBottom(){
					$vString = "</div>";//row
			$vString .= "</div>";//container
		$vString .= "</div>";//mainBody
		return $vString;
	}


}
?>