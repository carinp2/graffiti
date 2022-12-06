<?php
//		    $subject = "Webwerf bestelling";
//		    $to = "carin@ceit.cc";
//
		    $headersGraf  = "MIME-Version: 1.0" . "\r\n";
		    $headersGraf .= "Content-type: text/html; charset=UTF-8" . "\r\n";
		    $headersGraf .= "From: ".$_SESSION['SessionGrafUserFirstname']." ".$_SESSION['SessionGrafUserSurname']."<".$_SESSION['SessionGrafUserEmail'].">". "\r\n";
		    $message = "Nuwe boeke bestelling:<br><br>";
		    $message .= "Bestelling geplaas deur: ".$_SESSION['SessionGrafUserFirstname']." ".$_SESSION['SessionGrafUserSurname']."<br>";
		    $message .= "Boek bestelling verwysingsnommer: GRAF/".$vOrderResult[0][0]."/".$vOrderResult[3][0]."<br>";
		    $message .=  "Totale prys: R ".$vOrderResult[13][0]."<br>";
		    $message .= "Betalingsmetode: ".MysqlQuery::getLookupPerId($conn, $vOrderResult[14][0])."<br>";
		    (!empty($vOrderResult[16][0]) ? $message .= "Afleweringsboodskap: ".$vOrderResult[16][0]."<br>" : $message .= "");
//		    mail($to, $subject, $message, $headersGraf);

		    //##################################################################################### Client email start
            $vReceiverFullname = (isset($_SESSION['SessionGrafUserFirstname']) ? $_SESSION['SessionGrafUserFirstname'] : $vOrderResult[27][0]).(isset($_SESSION['SessionGrafUserSurname']) ? ' '.$_SESSION['SessionGrafUserSurname'] : '');
		    $messageClient = "";
		    $messageClient  .= "<p style='font-family: arial; font-size: 14px; color: #404040; line-height: 13px;'>".$vReceiverFullname.",<br><br>";
		    if($vOrderResult[14][0] == 16 && $vOrderResult[17][0] == 0){//EFT && not paid
		    	$messageClient .= MysqlQuery::getText($conn, 306)/*Baie dankie vir jou bestelling*/." <b>GRAF/".$vOrderResult[0][0]."/".$vOrderResult[3][0]."</b>. ";
	    		$messageClient .= MysqlQuery::getText($conn, 406)/*Ons prosesseer die bestelling sodra die betaling in ons rekening reflekteer.*/."<br><br>";
	    		$messageClient .= MysqlQuery::getText($conn, 407)/*Gebruik asseblief ABSA rekening hieronder en Bestel # as verwysing.*/."<br><br>";
		    }
		    else if($vOrderResult[14][0] != 16 && $vOrderResult[17][0] == 0){//Credit or Instant EFT && not paid
		    	$messageClient .= MysqlQuery::getText($conn, 456)/*Ons sien dat jou bestelling op Graffiti se webwerf nie....*/."<br><br>";
	    		//$messageClient .= MysqlQuery::getText($conn, 457)/*Die faktuur vir jou bestelling is aangeheg.*/."<br><br>";
	    		$messageClient .= MysqlQuery::getText($conn, 407)/*Gebruik asseblief ABSA rekening hieronder en Bestel # as verwysing.*/."<br><br>";
	    		$messageClient .= MysqlQuery::getText($conn, 156)/*Bestelnommer*/.": <b>GRAF/".$vOrderResult[0][0]."/".$vOrderResult[3][0]."</b><br><br>";
		    }
		    if(($vOrderResult[14][0] == 16 && $vOrderResult[17][0] == 0) || ($vOrderResult[14][0] != 16 && $vOrderResult[17][0] == 0)){
	    		$messageClient .= "ABSA<br>";
	    		$messageClient .= "BROOKLYN<br>";
	    		$messageClient .= MysqlQuery::getText($conn, 408)/*REK #: 407 02 55 861*/."<br>";
	    		$messageClient .= MysqlQuery::getText($conn, 409)/*TAK:  632 005*/."<br><br>";
	    		$messageClient .= MysqlQuery::getText($conn, 410)/*Indien betaling nie binne sewe dae ontvang is nie, sal die bestelling gekanselleer word.*/."<br><br>";
		    }
		    else if($vOrderResult[14][0] != 16){//MyGATE
		    	$messageClient .= MysqlQuery::getText($conn, 306)/*Baie dankie vir jou bestelling*/." <b>GRAF/".$vOrderResult[0][0]."/".$vOrderResult[3][0]."</b>. ";
		    	if(min($vOrderDetailResult['in_stock']) > 0 && $vOrderResult[10][0] != 4){//all in stock && Not Collect
		    		$messageClient .= MysqlQuery::getText($conn, 399)/*Verwagte versending 2 werksdae.*/.".<br><br>";
		    	}
		    	else if(min($vOrderDetailResult['in_stock']) > 0 && $vOrderResult[10][0] == 4){//all in stock && Collect
		    		$messageClient .= MysqlQuery::getText($conn, 352)/*Jou bestelling word verwerk.*/.".<br><br>";
		    	}
		    	else if(min($vOrderDetailResult['in_stock']) > 0 && $vOrderResult[10][0] != 4){//not all in stock && Not Collect
		    		$messageClient .= MysqlQuery::getText($conn, 400)/*Let asseblief daarop dat jou bestelling versend sal word sodra al .....*/.".<br><br>";
		    	}
		    	else if(min($vOrderDetailResult['in_stock']) > 0 && $vOrderResult[10][0] == 4){//not all in stock && Collect
		    		$messageClient .= MysqlQuery::getText($conn, 413)/*Let asseblief daarop dat al die boeke nie in voorraad is nie. Verwagte ontvangs van voorraad is 5 tot 14 werksdae .....*/.".<br><br>";
		    	}
		    }
		    $messageClient .= "<table border='0' cellspacing='0' cellpadding='4' style='font-family: arial; font-size: 14px; color: #404040;'>";
		        $messageClient .= "<tr>";
		        	$messageClient .= "<th style='border: 1px solid #999;text-align: center;'>ISBN</th>";
		        	$messageClient .= "<th style='border: 1px solid #999;text-align: center;'>".MysqlQuery::getText($conn, 140)/*Aantal*/."</th>";
		        	$messageClient .= "<th style='border: 1px solid #999;text-align: center;'>".MysqlQuery::getText($conn, 332)/*Titel.*/."</th>";
		        	$messageClient .= "<th style='border: 1px solid #999;text-align: center;'>".MysqlQuery::getText($conn, 262)/*Outeur*/."</th>";
		        	$messageClient .= "<th style='border: 1px solid #999;text-align: center;' width='120'>".MysqlQuery::getText($conn, 141)/*Prys.*/."</th>";
		        $messageClient .= "</tr>";
			    for($b = 0; $b < count($vOrderDetailResult['id']); $b++){
			        $messageClient .= "<tr>";
			        	$messageClient .= "<td style='border: 1px solid #999;'>".$vOrderDetailResult['isbn'][$b]."</td>";
			        	$messageClient .= "<td style='border: 1px solid #999;text-align: center;'>".$vOrderDetailResult['number_books'][$b]."</td>";
			        	$messageClient .= "<td style='border: 1px solid #999;'>".utf8_decode($vOrderDetailResult['title'][$b])."</td>";
			        	$messageClient .= "<td style='border: 1px solid #999;'>".utf8_decode($vOrderDetailResult['author'][$b])."</td>";
			        	$messageClient .= "<td style='border: 1px solid #999;text-align: right;'>R ".$vOrderDetailResult['price'][$b]."</td>";
			        $messageClient .= "</tr>";
			    }
		        $messageClient .= "<tr>";
		        	$messageClient .= "<td colspan='4' align='right' style='border: 1px solid #999; font-weight:600;'>".MysqlQuery::getText($conn, 107)/*Sub Totaal*/."</td>";
		        	$messageClient .= "<td style='border: 1px solid #999; font-weight:600;text-align: right;'>R ".$vOrderResult[12][0]."</td>";
		        $messageClient .= "</tr>";
		        $messageClient .= "<tr>";
		        	$messageClient .= "<td colspan='4' align='right' style='border: 1px solid #999; font-weight:600;'>".$vShortDeliveryCostText."</td>";
		        	$messageClient .= "<td style='border: 1px solid #999; font-weight:600;text-align: right;'>R ".$vOrderResult[11][0]."</td>";
		        $messageClient .= "</tr>";
		        $messageClient .= "<tr>";
		        	$messageClient .= "<td colspan='4' align='right' style='border: 1px solid #999; font-weight:600;'>".MysqlQuery::getText($conn, 292)/*Totaal*/."</td>";
		        	$messageClient .= "<td style='border: 1px solid #999; font-weight:600;text-align: right;'>R ".$vOrderResult[13][0]."</td>";
		        $messageClient .= "</tr>";
		    $messageClient .= "</table><br><br>";
		    $messageClient .= "<p style='font-family: arial; font-size: 14px; color: #404040; line-height: 20px;'>".MysqlQuery::getText($conn, 398)/*Jou belastingfaktuur is aangeheg.*/.".<br><br>";
		    $messageClient .= MysqlQuery::getText($conn, 401)/*Groete*/."<br>";
		    $messageClient .= "Graffiti Books & Stationery<br>";
		    $messageClient .= MysqlQuery::getText($conn, 402)/*Winkel 10, Zambezi Junction*/."<br>";
		    $messageClient .= MysqlQuery::getText($conn, 403)/*522 Breed Street*/."<br>";
		    $messageClient .= MysqlQuery::getText($conn, 404)/*Montanapark*/."<br>";
		    $messageClient .= MysqlQuery::getText($conn, 405)/*Tel: 012 - 548 2356*/."</p>";
		    $messageClient  .= "<p style='font-family: arial; font-size: 12px; color: #202020; line-height: 20px;'><a href='https://www.graffitiboeke.co.za' title='Graffiti'>www.graffitiboeke.co.za</a></p><br>";
		    $messageClient  .= "<img src='".$_SESSION['SessionGrafFullServerUrl']."images/logo.png' height='120' width='245' alt='Graffiti'>";
// 		    //#####################################################################################Client email content end
		    $subjectClient = MysqlQuery::getText($conn, 305)/*Graffiti - Webwerf bestelling*/;
 		    $toClient = (isset($_SESSION['SessionGrafUserEmail']) ? $_SESSION['SessionGrafUserEmail'] : $vOrderResult[32][0]);
 		    $clientName = $vReceiverFullname;
 		    $fromClient = "Graffiti";
 		    $filename = "Invoice.pdf";
 		    $pdfdoc = $pdf->Output($filename, "S");

//			require 'mail/PHPMailerAutoload.php';
//			$mail = new PHPMailer(true);
//            $mail->setFrom('orders@graffitibooks.co.za', $fromClient);
//			$mail->addAddress($toClient, $clientName);
////			$mail->addBCC("webmaster@graffitibooks.co.za");
//			$mail->Subject = $subjectClient;
//			$mail->isHTML(true);
//            $mail->CharSet = 'utf-8';
//			$mail->MsgHTML = $messageClient;
//			$mail->AddStringAttachment($pdfdoc, $filename);
//		    $mail->send();


            use PHPMailer\PHPMailer\PHPMailer;
            use PHPMailer\PHPMailer\SMTP;
            use PHPMailer\PHPMailer\Exception;

            require 'vendor/autoload.php';
            $mail = new PHPMailer(true);
            try {
                //Server settings
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host = 'smtp.graffitibooks.co.za';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username = 'orders@graffitibooks.co.za';                     //SMTP username
                $mail->Password = 'Lizette@136792';                               //SMTP password
                //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port = 587;

                $mail->setFrom('orders@graffitibooks.co.za', $fromClient);
                $mail->addAddress($toClient, $clientName);     //Add a recipient
                $mail->AddStringAttachment($pdfdoc, $filename);    //Optional name

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = $subjectClient;
                $mail->Body    = $messageClient;

                $mail->send();
//                echo 'Message has been sent';
            } catch (Exception $e) {
                error_log($mail->ErrorInfo, 3, 'errors.log');
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

//}