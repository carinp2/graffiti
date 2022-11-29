<?php
$headersClient  = "MIME-Version: 1.0" . "\r\n";
$headersClient .= "Content-type: text/html; charset=UTF-8" . "\r\n";
$headersClient .= "From: orders@graffitibooks.co.za". "\r\n";

$messageClient  = "<html><body>";
if($vType == "paid"){
	    //Client Email
	    $subjectClient = MysqlQuery::getCmsText($conn, 158, $vClientResult[5])/*Webwerf boeke bestelling - Verwysingsnommer:*/." GRAF/".$vOrderId."/".$vSalt;
	    $toClient = $vClientResult[3];

	    $messageClient  .= "<p style=\"font-family: arial; font-size: 14px; color: #404040; line-height: 10px;\">".$vClientResult[1]." ".$vClientResult[2].",<br><br>";
	    $messageClient .= MysqlQuery::getCmsText($conn, 362, $vClientResult[5])/*Ons het jou betaling van*/." R ".$vAmount." ".MysqlQuery::getCmsText($conn, 363, $vClientResult[5])/*vir bestelling nommer*/." GRAF/".$vOrderId."/".$vSalt." ".MysqlQuery::getCmsText($conn, 364, $vClientResult[5])/*ontvang*/.".<br><br>";
	    if($vInStock == 1 && $vCourierType == 4){//All in stock && collect at Graffiti
	    	$messageClient .= MysqlQuery::getCmsText($conn, 414, $vClientResult[5])/*Jou bestelling word verwerk. Ons sal jou kontak sodra jou bestelling gereed is vir afhaal by Graffiti Zambezi Junction*/.".<br><br>";
	    }
	    else if($vInStock == 1 && $vCourierType != 4){//All in stock && not collect at Graffiti
	    	$messageClient .= MysqlQuery::getCmsText($conn, 399, $vClientResult[5])/*Verwagte versending is 2 werksdae*/.".<br><br>";
	    }
	    else if($vInStock == 0 && $vCourierType == 4){//All not in stock && collect at Graffiti
	    	$messageClient .= MysqlQuery::getCmsText($conn, 415, $vClientResult[5])/*Let asseblief daarop dat jou bestelling verwerk sal word sodra al die boeke in voorraad is. Verwagte ontvangs van voorraad is 5 tot 14 werksdae*/.".<br><br>";
	    }
	    else if($vInStock == 0 && $vCourierType != 4){//All not in stock && not collect at Graffiti
	    	$messageClient .= MysqlQuery::getCmsText($conn, 400, $vClientResult[5])/*Let asseblief daarop dat jou bestelling versend sal word sodra al die boek...*/.".<br><br>";
	    }
	    $messageClient .= "<br>".MysqlQuery::getText($conn, 401)/*Groete*/."<br>";
	    $messageClient .= "Graffiti Books & Stationery<br>";
	    $messageClient .= MysqlQuery::getText($conn, 402)/*Winkel 10, Zambezi Junction*/."<br>";
	    $messageClient .= MysqlQuery::getText($conn, 403)/*522 Breed Street*/."<br>";
	    $messageClient .= MysqlQuery::getText($conn, 404)/*Montanapark*/."<br>";
	    $messageClient .= MysqlQuery::getText($conn, 405)/*Tel: 012 - 548 2356*/."</p>";
	    $messageClient  .= "<p style=\"font-family: arial; font-size: 12px; color: #202020; line-height: 20px;\"><a href=\"https://www.graffitiboeke.co.za\">www.graffitiboeke.co.za</a></p><br>";
	    $messageClient  .= "<img src=\"".$_SESSION['SessionGrafServerUrl']."/images/logo.png\" height=\"120\" width=\"245\">";
	    $messageClient .= "</body></html>";

	if (@mail($toClient, $subjectClient, $messageClient, $headersClient)){
		$vClient = 1;
		$vData['paid_email'] = 1;
	}
	else {
		$vClient = 2;
	}
}
else if($vType == "processed"){//$vId, $vFirstname, $vSurname, $vEmail, $vPhone, $vLanguage
	    //Client Email
	    $subjectClient = MysqlQuery::getCmsText($conn, 158, $vClientResult[5])/*Webwerf boeke bestelling - Verwysingsnommer:*/." GRAF/".$vOrderId."/".$vSalt;
	    $toClient = $vClientResult[3];

	    $messageClient  = "<p style=\"font-family: arial; font-size: 14px; color: #404040; line-height: 10px;\">".$vClientResult[1]." ".$vClientResult[2].",<br><br>";
	    if($vCourierType == 4){//Collect at Graffiti
	    	$messageClient .= MysqlQuery::getCmsText($conn, 366, $vClientResult[5])/*Jou bestelling*/." GRAF/".$vOrderId."/".$vSalt." ".MysqlQuery::getCmsText($conn, 416, $vClientResult[5])/*is verwerk en is gereed vir afhaal by Graffiti Zambezi Junction*/.".<br><br>";
	    }
	    else if($vCourierType != 4){//Not collect at Graffiti
	    	$messageClient .= MysqlQuery::getCmsText($conn, 366, $vClientResult[5])/*Jou bestelling*/." GRAF/".$vOrderId."/".$vSalt." ".MysqlQuery::getCmsText($conn, 367, $vClientResult[5])/*is verwerk en sal binnekort versend word*/."<br><br>";
	    }
	    $messageClient .= "<br>".MysqlQuery::getText($conn, 401)/*Groete*/."<br>";
	    $messageClient .= "Graffiti Books & Stationery<br>";
	    $messageClient .= MysqlQuery::getText($conn, 402)/*Winkel 10, Zambezi Junction*/."<br>";
	    $messageClient .= MysqlQuery::getText($conn, 403)/*522 Breed Street*/."<br>";
	    $messageClient .= MysqlQuery::getText($conn, 404)/*Montanapark*/."<br>";
	    $messageClient .= MysqlQuery::getText($conn, 405)/*Tel: 012 - 548 2356*/."</p>";
	    $messageClient  .= "<p style=\"font-family: arial; font-size: 12px; color: #202020; line-height: 20px;\"><a href=\"https://www.graffitiboeke.co.za\">www.graffitiboeke.co.za</a></p><br>";
	    $messageClient  .= "<img src=\"".$_SESSION['SessionGrafServerUrl']."/images/logo.png\" height=\"120\" width=\"245\">";
	    $messageClient .= "</body></html>";
	    $messageClient  .= "Graffiti<br>www.graffitiboeke.co.za<br><br>";
	    $messageClient  .= "<img src=\"https://www.graffitiboeke.co.za/images/logo.png\" height=\"120\" width=\"245\">";

	if (@mail($toClient, $subjectClient, $messageClient, $headersClient)){
		$vClient = 1;
		$vData['processed_email'] = 1;
	}
	else {
		$vClient = 2;
	}
}
else if($vType == "posted"){
	    //Client Email
	    $subjectClient = MysqlQuery::getCmsText($conn, 158, $vClientResult[5])/*Webwerf boeke bestelling - Verwysingsnommer:*/." GRAF/".$vOrderId."/".$vSalt;
	    $toClient = $vClientResult[3];

	    $messageClient  = "<p style=\"font-family: arial; font-size: 14px; color: #404040; line-height: 10px;\">".$vClientResult[1]." ".$vClientResult[2].",<br><br>";
	    $messageClient .= MysqlQuery::getCmsText($conn, 417, $vClientResult[5])/*Ons het jou bestelling*/." GRAF/".$vOrderId."/".$vSalt." ".MysqlQuery::getCmsText($conn, 418, $vClientResult[5])/*versend.*/.".<br><br>";
	    if($vCourierType == 1){//SA Postal services
	    	$messageClient .= MysqlQuery::getCmsText($conn, 424, $vClientResult[5])/*Die Poskantoor verwysing vir die aflewering is*/.":<b> ".$_POST['tracking']."</b><br><br>";
	    	$messageClient .= MysqlQuery::getCmsText($conn, 425, $vClientResult[5])/*Indien jy nie binne 1 week 'n skrywe van die poskantoor g...*/.".<br><br>";
	    	$messageClient .= MysqlQuery::getCmsText($conn, 426, $vClientResult[5])/*Jy kan ook jou pakkie opspoor op die Poskantoor se webwerf www.postoffice.co.za � Klik op �Track my Parcel� en kies �Domestic Parcel�. Tik ....*/.".<br><br>";
	    	$messageClient .= MysqlQuery::getCmsText($conn, 427, $vClientResult[5])/*Jy kan ook die pakkie opspoor deur die verwysingsnommer te SMS na 35277. Die poskantoor sal dan vir jou �n SMS stuur om te s� waar jo....*/.".<br><br>";
	    }
	    else if($vCourierType == 2 || $vCourierType == 6 || $vCourierType == 7 || $vCourierType == 204 || $vCourierType == 3){//Courier
	        if($vCourierSelected == 'aramex') {
                $messageClient .= MysqlQuery::getCmsText($conn, 419, $vClientResult[5])/*Die aflewering word gedoen deur CourierIT. Die verwysingsnommer vir die aflewering is */ . ":<b> " . $_POST['tracking'] . "</b><br><br>";
                $messageClient .= MysqlQuery::getCmsText($conn, 420, $vClientResult[5])/*Jy kan hulle kontak by 087 985 3051 of http://www.courierit.co.za � klik op TRACK IT */.".<br><br>";
            }
	        else if($vCourierSelected == 'courier_guy'){
	            $messageClient .= MysqlQuery::getCmsText($conn, 483, $vClientResult[5])/*Die aflewering word gedoen deur  */ . ":<b> " . $_POST['tracking'] . "</b><br><br>";
                $messageClient .= MysqlQuery::getCmsText($conn, 484, $vClientResult[5])/*Jy kan jou pakkie naspoor */ . ".<br><br>";
            }
	        else if($vCourierSelected == 'internet_express'){
	            $messageClient .= MysqlQuery::getCmsText($conn, 485, $vClientResult[5])/*Die aflewering word gedoen deur  */ . ":<b> " . $_POST['tracking'] . "</b><br><br>";
                $messageClient .= MysqlQuery::getCmsText($conn, 486, $vClientResult[5])/*Jy kan jou pakkie naspoor */ . ".<br><br>";
            }
            else if($vCourierSelected == 'pargo'){
                $messageClient .= MysqlQuery::getCmsText($conn, 428, $vClientResult[5])/*Die aflewering word gedoen deur PARGO koeriers. Die PARGO afleweringspunt sal jou kontak sodra die pakkie daar aankom*/.".<br><br>";
                $messageClient .= MysqlQuery::getCmsText($conn, 429, $vClientResult[5])/*Die verwysingsnommer vir die aflewering is*/.":<b> ".$_POST['tracking']."</b><br><br>";
                $messageClient .= MysqlQuery::getCmsText($conn, 430, $vClientResult[5])/*Jy kan jou pakkie naspoor by https://pargo.co.za/track-trace/ - klik op TRACK IT*/.".<br><br>";
                $messageClient .= "<b>".MysqlQuery::getCmsText($conn, 459, $vClientResult[5])/*BAIE BELANGRIK*/."</b><br>";
                $messageClient .= MysqlQuery::getCmsText($conn, 460, $vClientResult[5])/*Indien jy nie binne 7 dae jou pakkie...*/."<br><br>";
            }
	    }
	    else if($vCourierType == 5){//Other country
	    	$messageClient .= MysqlQuery::getCmsText($conn, 421, $vClientResult[5])/*Die aflewering word gedoen deur die Suid-Afrikaanse Poskantoor se koerierdiens EMS. Die verwysing vir die aflewering is*/.":<b> ".$_POST['tracking']."</b><br><br>";
	    	$messageClient .= MysqlQuery::getCmsText($conn, 422, $vClientResult[5])/*Jy kan jou pakkie naspoor by https://www.emssouthafrica.co.za/Tracking/domestic.html*/.".<br><br>";
	    	$messageClient .= MysqlQuery::getCmsText($conn, 423, $vClientResult[5])/*Die pakkie behoort binne 14 werksdae by jou te wees. Indien jy nie die pakkie binne 20 dae ontvang het nie, laat weet asseblief sodat ons kan opvolg*/.".<br><br>";
	    }
//	    else if($vCourierType == 3){//Pargo
//	    	$messageClient .= MysqlQuery::getCmsText($conn, 428, $vClientResult[5])/*Die aflewering word gedoen deur PARGO koeriers. Die PARGO afleweringspunt sal jou kontak sodra die pakkie daar aankom*/.".<br><br>";
//	    	$messageClient .= MysqlQuery::getCmsText($conn, 429, $vClientResult[5])/*Die verwysingsnommer vir die aflewering is*/.":<b> ".$_POST['tracking']."</b><br><br>";
//	    	$messageClient .= MysqlQuery::getCmsText($conn, 430, $vClientResult[5])/*Jy kan jou pakkie naspoor by https://pargo.co.za/track-trace/ - klik op TRACK IT*/.".<br><br>";
//	    	$messageClient .= "<b>".MysqlQuery::getCmsText($conn, 459, $vClientResult[5])/*BAIE BELANGRIK*/."</b><br>";
//			$messageClient .= MysqlQuery::getCmsText($conn, 460, $vClientResult[5])/*Indien jy nie binne 7 dae jou pakkie...*/."<br><br>";
//	    }

	    $messageClient .= "<br>".MysqlQuery::getCmsText($conn, 401, $vClientResult[5])/*Groete*/."<br><br>";
	    $messageClient .= "Graffiti Books & Stationery<br><br>";
	    $messageClient .= MysqlQuery::getCmsText($conn, 402, $vClientResult[5])/*Winkel 10, Zambezi Junction*/."<br><br>";
	    $messageClient .= MysqlQuery::getCmsText($conn, 403, $vClientResult[5])/*522 Breed Street*/."<br><br>";
	    $messageClient .= MysqlQuery::getCmsText($conn, 404, $vClientResult[5])/*Montanapark*/."<br><br>";
	    $messageClient .= MysqlQuery::getCmsText($conn, 405, $vClientResult[5])/*Tel: 012 - 548 2356*/."</p>";
	    $messageClient  .= "<p style=\"font-family: arial; font-size: 12px; color: #202020; line-height: 20px;\"><a href=\"https://www.graffitiboeke.co.za\">www.graffitiboeke.co.za</a></p><br>";
	    $messageClient  .= "<img src=\"".$_SESSION['SessionGrafServerUrl']."/images/logo.png\" height=\"120\" width=\"245\">";
	    $messageClient .= "</body></html>";

	if (@mail($toClient, $subjectClient, $messageClient, $headersClient)){
		$vClient = 1;
		$vData['posted_email'] = 1;
	}
	else {
		$vClient = 2;
	}
}

