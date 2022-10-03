<?php
if($vPage == "Verifieer" || $vPage == "Verify"){
	($vLanguage == 'af' ? $vNewPage =  "Tuisblad" : $vNewPage = "Home");
	if($vPage == "Verifieer" || $vPage == "Verify"){

		$vTempToken = $vRequest->getParameter('temp');
		$vId = $vRequest->getParameter('id');
		$vLanguage = $vRequest->getParameter('lang');

		MysqlQuery::doValidateClient($conn, $vId, $vTempToken);
		$vValidateSuccess = MysqlQuery::checkValidation($conn, $vId, $vTempToken);

		if($vValidateSuccess == 1) {//Validated
			$vNewUrl = $_SESSION['SessionGrafFullServerUrl']."/".$vLanguage."/".$vNewPage."#validatesuccess";

		}
		else {//Error
			$vNewUrl = $_SESSION['SessionGrafFullServerUrl']."/".$vLanguage."/".$vNewPage."#validateerror";
		}
		$vString = "<Script>";
			$vString .= "document.location.href=\"".$vNewUrl."\"";
		$vString .= "</Script>";

		echo $vString;
	}
}
else if($vPage == "Logout"){
	$past = time() - 100;
	unset($_SESSION['SessionGrafUserId']);
	unset($_SESSION['SessionGrafUserFirstname']);
	unset($_SESSION['SessionGrafUserSurname']);
	unset($_SESSION['SessionGrafUserEmail']);
	unset($_SESSION['SessionGrafLoginNo']);
	unset($_SESSION['SessionGrafSpecialDiscount']);
	setcookie ("cookie_graf_ui", "" ,$past, '/', "", false, true);
	setcookie ("cookie_graf_la", 0 ,time()+ (86400*365), '/', "", false, true);

	$vNewUrl = "Tuisblad";
	$vGeneral->echoRedirect($vNewUrl, "");
}

	?>