<?php
date_default_timezone_set('Africa/Johannesburg');
$vGeneral = new General();
$vPageUrl = $vGeneral->curPageURL();

$_SESSION['date_min_one_month'] = date("Y-m-d", strtotime('-1 month'));
$_SESSION['date_min_two_month'] = date("Y-m-d", strtotime('-2 month'));
$_SESSION['date_now'] = date("Y-m-d");

//Declare all session vars
$_SESSION['SessionGrafSpecialDiscount'] = "";
$_SESSION['SessionGrafServerUrl'] = "";
$_SESSION['SessionGrafSpecialDiscount'] = 0;

$_SESSION['now_date'] = date("Y-m-d");
$_SESSION['now_month_year'] = date("m/Y");
$_SESSION['SessionGrafStyle'] = "css/style1.14.css";
$_SESSION['SessionGrafScript'] = "js/general1.27.js";

unset($_SESSION['SessionGrafServerPrefix']);
if(strpos($vPageUrl, 'graffiti') !== false){
	$_SESSION['SessionGrafServerPrefix'] = "/";
	$_SESSION['SessionGrafFullServerUrl'] = "http://graffiti/";
	$_SESSION['SessionGrafServerUrl'] = "graffiti";
}
else if(strpos($vPageUrl, 'graffitibooks') !== false){
	$_SESSION['SessionGrafServerPrefix'] = "/";
	$_SESSION['SessionGrafFullServerUrl'] = 'https://www.graffitibooks.co.za/';
	$_SESSION['SessionGrafServerUrl'] = 'www.graffitibooks.co.za/';
}
else {
	$_SESSION['SessionGrafServerPrefix'] = "/";
	$_SESSION['SessionGrafFullServerUrl'] = 'https://www.graffitiboeke.co.za/';
	$_SESSION['SessionGrafServerUrl'] = 'www.graffitiboeke.co.za/';
}

//if((!isset($_COOKIE['cookie_graf_language']) || $_COOKIE['cookie_graf_language'] == '') ||  $_COOKIE['cookie_graf_language'] != $_SESSION['SessionGrafLanguage']){
if(!isset($_COOKIE['cookie_graf_language']) || $_COOKIE['cookie_graf_language'] == '' || ($_COOKIE['cookie_graf_language'] != "af" || $_COOKIE['cookie_graf_language'] != "en")){
    $past = time() - 100;
    setcookie("cookie_graf_language", 'af', $past, "/", $_SESSION['SessionGrafServerUrl'], false, true);//1 year
    setcookie("cookie_graf_language", 'af', time() + (86400*365), "/", $_SESSION['SessionGrafServerUrl'], false, true);//1 year
}
if(!isset($_SESSION['SessionGrafLanguage']) || $_SESSION['SessionGrafLanguage'] == '' || ($_SESSION['SessionGrafLanguage'] != "af" || $_SESSION['SessionGrafLanguage'] != "en")){
    unset($_SESSION['SessionGrafLanguage']);
    $_SESSION['SessionGrafLanguage'] = 'af';
}

if(!isset($_COOKIE['cookie_graf_remun']) || $_COOKIE['cookie_graf_remun'] == '' ||  !isset($_COOKIE['cookie_graf_remme']) || $_COOKIE['cookie_graf_remme'] == '') {
    $past = time() - 100;
    setcookie("cookie_graf_remun", "0", $past, "/", $_SESSION['SessionGrafServerUrl'], false, true);
    setcookie("cookie_graf_remme", "0", $past, "/", $_SESSION['SessionGrafServerUrl'], false, true);
}

//Login changes - Login not required to add to cart - 13-10-2022
$_SESSION['SessionGrafUserSessionId'] = session_id();

/* Local */
$_SESSION['SessionGrafHost'] = "127.0.0.1";
$_SESSION['SessionGrafDbName'] = "graffiti";
$_SESSION['SessionGrafUName'] = "root";
$_SESSION['SessionGrafPass'] = "mysql";

/* DEV Server */
//  $_SESSION['SessionGrafHost'] = "dedi51.cpt4.host-h.net";
//  $_SESSION['SessionGrafDbName'] = "graffiti_dev_2020";
//  $_SESSION['SessionGrafUName'] = "graffjgnnd_3";
//  $_SESSION['SessionGrafPass'] = "5CS65aBPuOVbaRmn6yt0";

/* Server */
//  $_SESSION['SessionGrafHost'] = "dedi51.cpt4.host-h.net";
//  $_SESSION['SessionGrafDbName'] = "graffiti_2017";
//  $_SESSION['SessionGrafUName'] = "graffjgnnd_1";
//  $_SESSION['SessionGrafPass'] = "kkgY3gtHMZ8";
?>