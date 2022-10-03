<?php
/**
 * @author Carin Pretorius - CEIT Development
 * Created on 2016-11_02
 */

session_start();
//session_cache_limiter( 'nocache' );
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
require_once ("application/resources/PasswordHashClass.php");

$vType =  $_REQUEST['type'];

if($vType == "register"){
	$vGraf = 0;
    $vClient = 0;
    $vQueryResult = 0;

	$hasher = new PasswordHashClass(8, FALSE);
	$alfa = "1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
	$temp_token = "";
	for($i = 0; $i < 20; $i++) {
		$temp_token .= $alfa[rand(0, strlen($alfa))];
	}

	$random_token = "";
	for($i = 0; $i < 30; $i++) {
		$random_token .= $alfa[rand(0, strlen($alfa))];
	}

	$vIsUniqueUser = MysqlQuery::checkClient($conn, strtoupper($_POST['email']));
	if($vIsUniqueUser == 0) {
		$hash = hash('sha256', $_POST['password']);
		$salt = General::createSalt(15);
		$hash = hash('sha256', $salt . $hash);
		$vData['firstname'] = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$vData['surname'] = filter_var($_POST['surname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$vData['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
		$vData['phone'] = filter_var($_POST['phone'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$vData['password'] = $hash;
		$vData['validated'] = 0;
		$vData['salt'] = $salt;
		$vData['postal_address1'] = filter_var($_POST['postal_address1'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$vData['postal_address2'] = filter_var($_POST['postal_address2'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$vData['postal_city'] = filter_var($_POST['postal_city'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$vData['postal_province'] = filter_var($_POST['postal_province'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$vData['postal_code'] = filter_var($_POST['postal_code'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$vData['postal_country'] = filter_var($_POST['postal_country'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$vData['physical_address1'] = filter_var($_POST['physical_address1'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$vData['physical_address2'] = filter_var($_POST['physical_address2'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$vData['physical_city'] = filter_var($_POST['physical_city'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$vData['physical_province'] = filter_var($_POST['physical_province'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$vData['physical_country'] = filter_var($_POST['physical_country'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$vData['physical_code'] = filter_var($_POST['physical_code'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$vData['temp_token'] = $temp_token;
		($_POST['newsletter'] == "" ?   : $vData['newsletter'] = $_POST['newsletter']);
		$vData['language'] = filter_var($_POST['client_language'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$_SESSION['SessionGrafLanguage'] = $vData['language'];

		$vData['special_discount'] = 0;

		$pos = strpos($vData['postal_country'], "file");
		$pos2 = strpos($vData['firstname'], "http");
		$pos3 = strpos($vData['postal_city'], "file");
		$pos4 = strpos($vData['surname'], "FR");
		if($pos === false && $pos2 === false && $pos3 === false && $pos4 === false){
			$vQueryResult = MysqlQuery::doInsert($conn, 'clients', $vData);
			if($vQueryResult > 5000) {
				$vNewId = $vQueryResult;

				//Graffiti email
			    $subject = "Website - Client registration";
			    $to = "carin@ceit.cc";

			    $headers  = "MIME-Version: 1.0" . "\r\n";
			    $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
			    $headers .= "From: ".$_POST['firstname']." ".$_POST['surname']."<".$_POST['email'].">". "\r\n";
			    //$headers .= "CC: dirk@smc-synergy.co.za\r\n";
			    $message  = "'n Nuwe registrasie via die webwerf: <br><br>";

			    $message .= "Naam: " . $_POST['firstname'] . " ". $_POST['surname'] ."<br>";
			    $message .= "Kontaknommer: " . $_POST['phone'] . "<br>";
			    $message .= "Epos: " . $_POST['email'] . "<br>";
			    //TODO Change for Live
			    $message .= "<br>Gebruik die  <a href=\"https://www.graffitiboeke.co.za/cms\" target=\"_blank\" title=\"CMS\">CMS</a> vir meer detail<br>";

			    //Client Email
			    $subjectClient = MysqlQuery::getText($conn, 252)/*Graffiti - Webwerf registrasie*/;
			    $toClient = $_POST['email'];

			    $headersClient  = "MIME-Version: 1.0" . "\r\n";
			    $headersClient .= "Content-type: text/html; charset=UTF-8" . "\r\n";
			    $headersClient .= "From: Graffiti". "\r\n";

			    $messageClient  = $_POST['firstname']." ".$_POST['surname'].",<br><br>";
			    $messageClient  .= MysqlQuery::getText($conn, 253)/*Dankie vir jou registrasie op Graffiti.*/."<br><br>";
			    //TODO Change for Live
			    $messageClient .= "<a href=\"https://www.graffitiboeke.co.za/".$_SESSION['SessionGrafLanguage']."/".$vNewId."/".MysqlQuery::getText($conn, 260)/*Verifieer*/."/".$temp_token."/".$random_token."\" title=\"".MysqlQuery::getText($conn, 259)/*Maak asseblief die skakel oop om jou registrasie te verifieer.*/."\">".MysqlQuery::getText($conn, 259)/*Maak asseblief die skakel oop om jou registrasie te verifieer.*/."</a>";

			    $messageClient  .= "<br><br>Graffiti<br>www.graffitiboeke.co.za<br><br>";
			     //TODO Change for Live
			    $messageClient  .= "<img src=\"https://www.graffitiboeke.co.za/images/logo.png\" height=\"120\" width=\"245\" alt=\"Graffiti\">";
			}

	// 		if (@mail($to, $subject, $message, $headers)){
	// 			$vGraf = 1;
	// 		}
	// 		else {
	// 			$vGraf = 2;
	// 		}
			if (@mail($toClient, $subjectClient, $messageClient, $headersClient)){
				$vClient = 1;
			}
			else {
				$vClient = 2;
			}

	//		if ($vClient == 2 || $vGraf == 2 || $vQueryResult == 0){
			if ($vClient == 2 || $vQueryResult == 0){
				echo 'error';
			}
			else if ($vClient == 1 && $vQueryResult > 0){
				echo 'send';
			}
		}
	}
	else {
		echo 'double';
	}
}
//######################################## Profile edit
else if($vType == "profile-edit"){
    $vQueryResult = 0;
    $vId = $_POST['client_id'];
	$vDataC['firstname'] = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$vDataC['surname'] = filter_var($_POST['surname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$vDataC['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	$vDataC['phone'] = filter_var($_POST['phone'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$vDataC['postal_address1'] = filter_var($_POST['postal_address1'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$vDataC['postal_address2'] = filter_var($_POST['postal_address2'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$vDataC['postal_city'] = filter_var($_POST['postal_city'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$vDataC['postal_province'] = filter_var($_POST['postal_province'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$vDataC['postal_code'] = filter_var($_POST['postal_code'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$vDataC['postal_country'] = filter_var($_POST['postal_country'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$vDataC['physical_address1'] = filter_var($_POST['physical_address1'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$vDataC['physical_address2'] = filter_var($_POST['physical_address2'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$vDataC['physical_city'] = filter_var($_POST['physical_city'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$vDataC['physical_province'] = filter_var($_POST['physical_province'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$vDataC['physical_country'] = filter_var($_POST['physical_country'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$vDataC['physical_code'] = filter_var($_POST['physical_code'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$vDataC['newsletter'] = filter_var($_POST['newsletter'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$vDataC['language'] = filter_var($_POST['client_language'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		$vQueryResult = MysqlQuery::doUpdate($conn, 'clients', $vDataC, "id = ".$vId);
		if ($vQueryResult == 1){
			echo 'profile-success';
		}
		else if ($vQueryResult == 0){
			echo 'profile-error';
		}
}
//######################################## Password change
else if($vType == "password-edit"){
	$vQueryResult = 0;
	$vId = $_POST['password_client_id'];

	$hash = hash('sha256', $_POST['change_password']);
	$salt = General::createSalt(15);
	$hash = hash('sha256', $salt . $hash);

	$vData['password'] = $hash;
	$vData['salt'] = $salt;

		$vQueryResult = MysqlQuery::doUpdate($conn, 'clients', $vData, "id = ".$vId);
		if ($vQueryResult == 1){
			echo 'password-success';
		}
		else if ($vQueryResult == 0){
			echo 'password-error';
		}

}
//######################################## Login
else if($vType == "login"){
    $vQueryResult = 0;
	$vUsername = $_POST['login_username'];
	$vPassword = $_POST['login_password'];
	$vLanguage = $_POST['login_language'];
	$vRemember = $_POST['remember'];

	$vQueryResult = $vQuery->doLogin($conn, $vUsername, $vPassword, $vRemember, $vLanguage);

	if ($vQueryResult == 1){
		echo 'success';
	}
	else if($vQueryResult == 0 && ($_SESSION['SessionGrafLoginNo'] < 4 && $_COOKIE['cookie_graf_la'] < 4)){
		echo 'error';
	}
	else if($vQueryResult == 0 && ($_SESSION['SessionGrafLoginNo'] >= 4 || $_COOKIE['cookie_graf_la'] >= 4)){
		echo 'attempts';
	}
	else {
		echo $_SESSION['SessionGrafLoginNo'];
	}
}
//######################################## Password reset
else if($vType == "password-reset"){
	$_SESSION['SessionGrafLanguage'] = $_POST['language'];
    $vClient = 0;
    $vQueryResult = 0;
    $vEmail = General::prepareStringForQuery($_POST['username']);

	$alfa = "1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
	$password = "";
	for($i = 0; $i < 9; $i++) {
		$password .= $alfa[rand(0, strlen($alfa))];
	}
	$vUrl = General::curPageShortURL();

	$hash = hash('sha256', $password);
	$salt = General::createSalt(15);
	$hash = hash('sha256', $salt . $hash);

	$vData['password'] = $hash;
	$vData['salt'] = $salt;

	$vUserExists = MysqlQuery::checkClient($conn, strtoupper($vEmail));
	if($vUserExists > 0){
		$vQueryResult = MysqlQuery::doUpdate($conn, 'clients', $vData, "upper(email) = '".strtoupper($vEmail)."'");
		if($vQueryResult > 0) {
			$vNewId = $vQueryResult;

		    //Client Email
		    $subjectClient = "Graffiti - ".MysqlQuery::getText($conn, 434)/*Wagwoord herstel*/;
		    $toClient = $vEmail;

		    $headersClient  = "MIME-Version: 1.0" . "\r\n";
		    $headersClient .= "Content-type: text/html; charset=UTF-8" . "\r\n";
		    $headersClient .= "From: Graffiti". "\r\n";

		    $messageClient  = MysqlQuery::getText($conn, 437)/*Jou wagwoord is herstel.*/;". <br><br>";
		    $messageClient  .= MysqlQuery::getText($conn, 438)/*Gebruik die wagwoord om in te teken om die Graffiti webwerf:*/."<br>";
		    $messageClient  .= "<b>".$password."</b><br><br>";
		    $messageClient  .= MysqlQuery::getText($conn, 439)/*Jy kan die tydelike wagwoord verander nadat jy ...*/."<br>";

		    $messageClient  .= "<br><br>Graffiti<br>www.graffitiboeke.co.za<br><br>";
		    $messageClient  .= "<img src=\"https://www.graffitiboeke.co.za/images/logo.png\" height=\"120\" width=\"245\" alt=\"Graffiti\">";
		}
		if (@mail($toClient, $subjectClient, $messageClient, $headersClient)){
			$vClient = 1;
		}
		else {
			$vClient = 2;
		}

		if ($vClient == 2 || $vQueryResult == 0){
			echo 'reset_error';
		}
		else if ($vClient == 1 && $vQueryResult > 0){
			echo 'reset_success';
		}
	}
	else if($vUserExists == 0){
		echo 'not_exist';
	}
}
else if($vType == "competition_entry"){
    $vIsUniqueUser = MysqlQuery::checkExists($conn, 'competition_entry', 'id', "UPPER(email) = '".strtoupper($_REQUEST['email']."' AND competition_id = ".$_REQUEST['comp_id']));
    if ($vIsUniqueUser == 0) {
        if ($_REQUEST['agree'] == 1) {
            $vQueryResult = 0;
            $vData['competition_id'] = filter_var($_REQUEST['comp_id'], FILTER_SANITIZE_NUMBER_INT);
            $vData['name'] = filter_var($_REQUEST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $vData['surname'] = filter_var($_REQUEST['surname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $vData['email'] = filter_var($_REQUEST['email'], FILTER_SANITIZE_EMAIL);
            $vData['confirmation'] = 1;
            $vHoneyName = filter_var($_REQUEST['vname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $vHoneyId = filter_var($_REQUEST['vid'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if(empty($vHoneyName) && empty($vHoneyId)) {
                $vQueryResult = MysqlQuery::doInsert($conn, 'competition_entry', $vData);
            }
            else {
                echo 1;
                exit();
            }

            if ($vQueryResult > 0) {
                echo 1;
            }
            else {
                echo 0;
            }
        }
        else {
            echo 1;
        }
    } else {
        echo 2;
    }
}

include "include/connect/CloseConnect.php";
