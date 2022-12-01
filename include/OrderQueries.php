<?php
if($vPage == "Betaling" || $vPage == "Payment"){
    $vClientId = $_GET['id'];
    if(!empty($_POST['price']) || !empty($_POST['courier_type']) || !empty($_POST['total_price'])){

        if(isset($_POST['save_info']) && $_POST['save_info'] == 1){
            $vGraf = 0;
            $vClient = 0;
            $vQueryResult = 0;

            $hasher = new PasswordHashClass(8, FALSE);
            $alfa = '1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
            $temp_token = '';
            for ($i = 0; $i < 20; $i++) {
                $temp_token .= $alfa[rand(0, strlen($alfa))];
            }
            $random_token = '';
            for ($i = 0; $i < 30; $i++) {
                $random_token .= $alfa[rand(0, strlen($alfa))];
            }

            $vIsUniqueUser = MysqlQuery::checkClient($conn, strtoupper($_POST['cart_email']));
            if ($vIsUniqueUser == 0) {
                $hash = hash('sha256', $_POST['cart_password']);
                $salt = General::createSalt(15);
                $hash = hash('sha256', $salt . $hash);
                $vData['firstname'] = filter_var($_POST['deliver_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $vData['email'] = filter_var($_POST['cart_email'], FILTER_SANITIZE_EMAIL);
                $vData['phone'] = filter_var($_POST['deliver_phone'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $vData['password'] = $hash;
                $vData['validated'] = 1;
                $vData['salt'] = $salt;
                $vData['physical_address1'] = filter_var($_POST['deliver_address1'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $vData['physical_address2'] = filter_var($_POST['deliver_address2'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $vData['physical_city'] = filter_var($_POST['deliver_city'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $vData['physical_province'] = filter_var($_POST['deliver_province'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $vData['physical_country'] = filter_var($_POST['deliver_country'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $vData['physical_code'] = filter_var($_POST['deliver_code'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $vData['temp_token'] = $temp_token;
                $vData['newsletter'] = 1;
                $vData['language'] = $_SESSION['SessionGrafLanguage'];
                $vData['special_discount'] = 0.00;
                $vClientId = MysqlQuery::doInsert($conn, 'clients', $vData);

                if(isset($vClientId) && $vClientId > 0){
                    $vQueryResult = 0;
                    $_SESSION['SessionGrafUserId'] = $vClientId;
                    $_SESSION['SessionGrafUserFirstname'] = $vData['firstname'];
                    $_SESSION['SessionGrafUserSurname'] = "";
                    $_SESSION['SessionGrafUserEmail'] = $vData['email'];
                    $_SESSION['SessionGrafSpecialDiscount'] = $vData['special_discount'];
                    $_SESSION['SessionGrafUserPhone'] = $vData['phone'];
                    setcookie('cookie_graf_ui', $vClientId, 0, '/', '', false, true);

                    if (isset($_SESSION['SessionGrafUserSessionId']) && isset($_SESSION['SessionGrafUserId'])) {
                        $vDataC['client_id'] = $_SESSION['SessionGrafUserId'];

                        $vQueryCartResult = MysqlQuery::doUpdate($conn, 'cart', $vDataC, "client_id = '" . $_SESSION['SessionGrafUserSessionId'] . "' AND order_id IS NULL");
                        if ($vQueryCartResult == 1) {
                            unset($_SESSION['SessionGrafUserSessionId']);
                        }
                    }
                }
            }
        }

        $vDataCart['receiver_name'] = filter_var($_POST['deliver_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $vDataCart['receiver_email'] = filter_var($_POST['cart_email'], FILTER_SANITIZE_EMAIL);
        $vDataCart['address1'] = filter_var($_POST['deliver_address1'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $vDataCart['address2'] = filter_var($_POST['deliver_address2'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $vDataCart['city'] = filter_var($_POST['deliver_city'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $vDataCart['province'] = filter_var($_POST['deliver_province'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $vDataCart['country'] = filter_var($_POST['deliver_country'], FILTER_SANITIZE_NUMBER_INT);
        $vDataCart['code'] = filter_var($_POST['deliver_code'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);//Stop leading 0 to be removed
        $vDataCart['receiver_phone'] = filter_var($_POST['deliver_phone'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $vDataCart['courier_type'] = filter_var($_POST['courier_type'], FILTER_SANITIZE_NUMBER_INT);
        $vDataCart['courier_detail'] = filter_var($_POST['courier_detail'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $vDataCart['courier_cost'] = filter_var($_POST['courier_cost'], FILTER_SANITIZE_NUMBER_INT);
        $vDataCart['price'] = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT);
        $vDataCart['total_price'] = filter_var($_POST['total_price'], FILTER_SANITIZE_NUMBER_FLOAT);
        $vDataCart['message'] = filter_var($_POST['message'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $vQueryResult = MysqlQuery::doUpdate($conn, "cart", $vDataCart, " client_id = '".$vClientId."' and order_date is NULL and order_reference is NULL and order_id is NULL and temp_salt is not NULL");

        $vData['client_id'] = $vClientId;
    }
    else {
        $vData['client_id'] = $vClientId;
    }
}
else if($vPage == "BestelFinaal" || $vPage == "OrderFinal"){
    $vData['order_date'] = $_SESSION['now_date'];
    $vData['temp_salt'] = filter_var($_POST['temp_salt'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $vData['client_id'] = $_GET['id'];
    $vData['receiver_name'] = filter_var($_POST['deliver_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $vData['receiver_email'] = filter_var($_POST['cart_email'], FILTER_SANITIZE_EMAIL);
    $vData['address1'] = filter_var($_POST['deliver_address1'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $vData['address2'] = filter_var($_POST['deliver_address2'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $vData['city'] = filter_var($_POST['deliver_city'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $vData['province'] = filter_var($_POST['deliver_province'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $vData['country'] = filter_var($_POST['deliver_country'], FILTER_SANITIZE_NUMBER_INT);
    $vData['code'] = filter_var($_POST['deliver_code'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);//Stop leading 0 to be removed
    $vData['receiver_phone'] = filter_var($_POST['deliver_phone'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $vData['courier_type'] = filter_var($_POST['courier_type'], FILTER_SANITIZE_NUMBER_INT);
    $vData['courier_detail'] = filter_var($_POST['courier_detail'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $vData['courier_cost'] = filter_var($_POST['courier_cost'], FILTER_SANITIZE_NUMBER_INT);
    $vData['price'] = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT);
    $vData['total_price'] = filter_var($_POST['total_price'], FILTER_SANITIZE_NUMBER_FLOAT);
    $vData['message'] = filter_var($_POST['message'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $vData['payment_type'] = filter_var($_POST['payment_type'], FILTER_SANITIZE_NUMBER_INT);
    $vData['submitted'] = 1;

    $vOrder = " ORDER BY b.title ";
    $vBindParams = array();
    $vBindLetters = (isset($_SESSION['SessionGrafUserId']) ? 'i' : 's');
    $vBindParams[] = & $vData['client_id'];
    $vLimit = "";
    $vWhere = " WHERE w.client_id = ? and order_date is NULL and w.order_reference is NULL and w.order_id is NULL and w.temp_salt is not NULL";
    $vCartResults = MysqlQuery::getCart($conn, $vWhere, $vOrder, $vBindLetters, $vBindParams, $vLimit);

	if(strlen($vData['temp_salt']) == 5){
		$vQueryResult = MysqlQuery::doInsert($conn, 'orders', $vData);
		$vOrderId = $vQueryResult;
		for($od = 0; $od < count($vCartResults[0]); $od++){
			$vDataDetail['order_id'] = $vOrderId;
			$vDataDetail['book_id'] = $vCartResults[1][$od];
//			$vDataDetail['price'] = $vCartResults[10][$od];
			$vDataDetail['number_books'] = $vCartResults[3][$od];
			$vDataDetail['temp_salt'] = $vData['temp_salt'];

            //Final Price start
            $vNewTopDiscountPrice = round($vCartResults[29][$od] - ($vCartResults[29][$od] * $vCartResults[30][$od]));
            $vSpecialDiscountPrice = (!empty($vCartResults[31][$od]) && $vCartResults[31][$od] > 0 ? $vCartResults[32][$od] : $vCartResults[29][$od]);
            $vClientDiscountPrice = round($vCartResults[29][$od] - ($vCartResults[29][$od] * $_SESSION['SessionGrafSpecialDiscount']));
            $vSoonDiscountPrice = round($vCartResults[29][$od] - ($vCartResults[29][$od] * $vCartResults[30][$od]));
            $vNormalPrice = $vCartResults[29][$od];
            $vPriceDisplayType = 'query';
            $price = $vCartResults[29][$od];
            $new = $vCartResults[33][$od];
            $top_seller = $vCartResults[34][$od];
            $special = $vCartResults[31][$od];
            $soon_discount = $vCartResults[35][$od];
            include 'include/BookPriceDisplay.php';
            //Final Price end

            $vDataDetail['price'] = $vCartResults[3][$od] * $vFinalPrice;
			$vQueryResult = MysqlQuery::doInsert($conn, "orders_detail", $vDataDetail);

			$vCartUData['order_id'] = $vOrderId;
			$vQueryResult = MysqlQuery::doUpdate($conn, "cart", $vCartUData, " id = ".$vCartResults[0][$od]);
		}
	}
	else {
		$vQueryResult = 0;
		$vEmailDetail = "Temp salt != 5 op OrderQueries ln 48/63 Client Id: ".$vData['client_id'];
	}

	if($vQueryResult > 0){
        //Direct payment
		if($vData['payment_type'] == 16){
			$vSuccessUrl = $_SESSION['SessionGrafFullServerUrl'].$_SESSION['SessionGrafLanguage']."/".$vData['payment_type']."/".MysqlQuery::getText($conn, 298)/*BestellingSukses*/;
			$vFormString = "";
				$vFormString .= "\n\n<form name=\"GraffitiForm\" id=\"GraffitiForm\" action=\"".$_SESSION['SessionGrafLanguage']."/".$vData['payment_type']."/".MysqlQuery::getText($conn, 298)/*BestellingSukses*/."\" method=\"post\">";
                    $vFormString .= "\n<input type=\"hidden\" name=\"temp_salt\" value=\"".$vData['temp_salt']."\">";
                    $vFormString .= "\n<input type=\"hidden\" name=\"client_id\" value=\"".$vData['client_id']."\">";
                    $vFormString .= "\n<input type=\"hidden\" name=\"reference\" value=\"".$vOrderId."\">";
                $vFormString .= "</form>";
                echo $vFormString;

                echo "<Script>";
                echo "$(document).ready(function(){";
                 	echo "$('#GraffitiForm').submit();";
                echo "});";
                echo "</Script>";
		}
        //Zapper
		else if($vData['payment_type'] == 57){
			$vFormString = "";
			$vFormString .= "<script src=\"//zapper-ecommerce.s3-eu-west-1.amazonaws.com/releases/zapper.ecommerce-2.0.0.min.js\"></script>";
			$vFormString .= "<form class=\"form-horizontal\" name=\"zapperForm\" id=\"zapperForm\">";
				$vFormString .= "<div id=\"form-border\">";
					$vFormString .= "<div id=\"center\">";

						$vFormString .= "<div class=\"form-header\">";
								$vFormString .= "<h1 class=\"red\">".MysqlQuery::getText($conn, 17)/*Bestel nou*/."</h1>";
							$vFormString .="<div class=\"row\">";
								$vFormString .= "<div class=\"col-xs-12\">";
									$vFormString .= "<ul id=\"progress\">";
			    						$vFormString .= "<li class=\"steps\">".MysqlQuery::getText($conn, 280)/*Stap*/." 1.&nbsp;&nbsp;".MysqlQuery::getText($conn, 16)/*Jou mandjie*/."</li>";
			    						$vFormString .= "<li class=\"steps\">".MysqlQuery::getText($conn, 280)/*Stap*/." 2.&nbsp;&nbsp;".MysqlQuery::getText($conn, 278)/*Aflewering*/."</li>";
			    						$vFormString .= "<li class=\"steps active\">".MysqlQuery::getText($conn, 280)/*Stap*/." 3.&nbsp;&nbsp;".MysqlQuery::getText($conn, 279)/*Betaling*/."</li>";
									$vFormString .= "</ul>	";
								$vFormString .= "</div>";
							$vFormString .= "</div>";
						$vFormString .= "</div>";//header

						$vFormString .= "<div class=\"form-body\">";
							$vFormString .="<div class=\"row\">";
								$vFormString .= "<div class=\"col-xs-12\">";
									$vFormString .= "<h4 class=\"green\">".MysqlQuery::getText($conn, 280)/*Stap*/." 3.&nbsp;&nbsp;".MysqlQuery::getText($conn, 279)/*Betaling*/."</h4>";
									$vFormString .= "<hr class=\"light-gray\">";
								$vFormString .="</div>";
							$vFormString .="</div>";//row

								$vFormString .="<div class=\"row\">";
								$vFormString .= "<div class=\"col-xs-12\">";
									$vFormString .= "<h5 class=\"gray\"><i class=\"fa fa-angle-double-right fa-lg\" aria-hidden=\"true\"></i>&nbsp;&nbsp;".MysqlQuery::getText($conn, 478)/*Zapper betaling*/."</h5>";
								$vFormString .="</div>";
							$vFormString .="</div>";//row

							$vFormString .= "<div class=\"col-12 space-left\">";
								$vFormString .= "<div id=\"zapper-wrapper\"></div>";
								$vFormString .="<div id=\"z_payment_error\" class=\"error\" style=\"display:none;\">".MysqlQuery::getText($conn, 479)/*Jou betaling was nie suksesvol...*/."</div>";
							$vFormString .= "</div>";

						$vFormString .= "</div>";//Body

					$vFormString .= "</div>";//center
				$vFormString .= "</div>";//form-border
			$vFormString .= "</form>";

			$vFormString .= "\n\n<form name=\"GraffitiFormZ\" id=\"GraffitiFormZ\" action=\"".$_SESSION['SessionGrafLanguage']."/".$vData['payment_type']."/".MysqlQuery::getText($conn, 298)/*BestellingSukses*/."\" method=\"post\">";
				$vFormString .= "\n<input type=\"hidden\" name=\"temp_salt\" value=\"".$vData['temp_salt']."\">";
				$vFormString .= "\n<input type=\"hidden\" name=\"client_id\" value=\"".$vData['client_id']."\">";
				$vFormString .= "\n<input type=\"hidden\" name=\"reference\" value=\"".$vOrderId."\">";
			$vFormString .= "</form>";
			$vFormString .= "<Script>
						const paymentWidget = new zapper.payments.PaymentWidget(
							'#zapper-wrapper',{
								merchantId: 45623,
						        siteId: 57234,
//								merchantId: 45898,
//						        siteId: 57850,
						        amount: ".$vData['total_price'].",
						        reference: ".$vOrderId."}
						)

					paymentWidget.on('payment', ({ status, paidAmount, zapperId, reference }) => {
					    if(status == 2){
					    	$('#z_payment_error').fadeOut(500);
					    	$('#GraffitiFormZ').submit();
						}
						else if (status == 5){
						    $.post('order_email.php', {payment_result: 1, order_id: ".$vOrderId."},function(){
						    		$('#z_payment_error').fadeIn(500);
							});
						}
					})</Script>";

			echo $vFormString;
		}
        //15 = CCard | 17 = Instant EFT
		else {
			//$vSuccessUrl = $_SESSION['SessionGrafFullServerUrl'].$_SESSION['SessionGrafLanguage']."/".$vData['payment_type']."/".MysqlQuery::getText($conn, 298)/*BestellingSukses*/;
			//$vErrorUrl = $_SESSION['SessionGrafFullServerUrl'].$_SESSION['SessionGrafLanguage']."/".$vData['payment_type']."/".MysqlQuery::getText($conn, 299)/*BestellingFout*/;
			
            $vSuccessUrl = $_SESSION['SessionGrafFullServerUrl'] . $_SESSION['SessionGrafLanguage'] . '/' . $vData['payment_type'] . '/' . MysqlQuery::getText($conn, 298)/*BestellingSukses*/.'/'.$vOrderId;
            $vErrorUrl = $_SESSION['SessionGrafFullServerUrl'] . $_SESSION['SessionGrafLanguage'] . '/' . $vData['payment_type'] . '/' . MysqlQuery::getText($conn, 299)/*BestellingFout*/.'/'.$vOrderId;			
			
			($vData['payment_type'] == 15 ? $vAppId = "DCD90073-9B52-4C3E-B113-957B84559661" : $vAppId = "3A353F1C-4852-44AE-BBFD-3FA6FE326AE8");
            //Change on 28/01/2021
			//($vData['payment_type'] == 15 ? $vAppId = "DCD90073-9B52-4C3E-B113-957B84559661" : $vAppId = "3A353F1C-4852-44AE-BBFD-3FA6FE326AE8");
			 
			$vFormString = "";
			$vFormString .= "\n\n<form name=\"MyGateForm\" id=\"MyGateForm\" action=\"https://virtual.mygateglobal.com/PaymentPage.cfm\" method=\"post\">";
                    $vFormString .= "\n<input type=\"hidden\" name=\"Mode\" value=\"1\">";
                    $vFormString .= "\n<input type=\"hidden\" name=\"MerchantID\" value=\"420ee23e-93e6-4775-88a0-633fb58c2c42\">";
                    $vFormString .= "\n<input type=\"hidden\" name=\"ApplicationID\" value=\"".$vAppId."\">";//Non secure
                    $vFormString .= "\n<input type=\"hidden\" name=\"MerchantReference\" value=\"".$vOrderId."\">";
                    $vFormString .= "\n<input type=\"hidden\" name=\"Amount\" value=\"".$vData['total_price'].".00\">";
                    $vFormString .= "\n<input type=\"hidden\" name=\"txtCurrencyCode\" value=\"ZAR\">";
                    $vFormString .= "\n<input type=\"hidden\" name=\"RedirectSuccessfulURL\" value=\"".$vSuccessUrl."\">";
                    $vFormString .= "\n<input type=\"hidden\" name=\"RedirectFailedURL\" value=\"".$vErrorUrl."\">";
                    $vFormString .= "\n<input type=\"hidden\" name=\"Variable1\" value=\"".$vData['temp_salt']."\">";//temp_salt
                    $vFormString .= "\n<input type=\"hidden\" name=\"Variable2\" value=\"".$vData['client_id']."\">";//client_id
                    $vFormString .= "\n<input type=\"hidden\" name=\"Variable3\" value=\"".$vData['payment_type']."\">";//payment_type
	                $vFormString .= "\n<input type=\"hidden\" name=\"ItemDescr1\" value=\"".MysqlQuery::getText($conn, 157)."\">";//Boeke|Books
                    //$vId, $vBookId, $vClientId, $vNumber, $vAddDate, $vTempSalt, $vOrderDate, $vOrderReference, $vOrderId, $vTitle, $vPrice, $vBlobPath, $vInStock
                    for($od = 0; $od < count($vCartResults[0]); $od++){
						//Final Price start
						$vNewTopDiscountPrice = round($vCartResults[29][$od] - ($vCartResults[29][$od] * $vCartResults[30][$od]));
						$vSpecialDiscountPrice = (!empty($vCartResults[31][$od]) && $vCartResults[31][$od] > 0 ? $vCartResults[32][$od] : $vCartResults[29][$od]);
						$vClientDiscountPrice = round($vCartResults[29][$od] - ($vCartResults[29][$od] * $_SESSION['SessionGrafSpecialDiscount']));
						$vSoonDiscountPrice = round($vCartResults[29][$od] - ($vCartResults[29][$od] * $vCartResults[30][$od]));
						$vNormalPrice = $vCartResults[29][$od];
						$vPriceDisplayType = 'query';
						$price = $vCartResults[29][$od];
						$new = $vCartResults[33][$od];
						$top_seller = $vCartResults[34][$od];
						$special = $vCartResults[31][$od];
						$soon_discount = $vCartResults[35][$od];
						include 'include/BookPriceDisplay.php';
						//Final Price end
												  

						$vTotalBookPrice = $vCartResults[3][$od] * $vFinalPrice;
								//$vTotalBookPrice = $vCartResults[3][$od] * $vCartResults[10][$od];
	                    $vFormString .= "\n<input type=\"hidden\" name=\"Qty".$od."\" value=\"".$vCartResults[3][$od]."\">";//number
	                    $vFormString .= "\n<input type=\"hidden\" name=\"ItemRef".$od."\" value=\"".$vCartResults[1][$od]."\">";//id
	                    $vFormString .= "\n<input type=\"hidden\" name=\"ItemAmount".$od."\" value=\"".$vTotalBookPrice.".00\">";//price
                    }
                    (!empty($vData['address2'])? $vAddress1 = $vData['address1'].", ".$vData['address2'] : $vAddress1 = $vData['address1']);
                    $vFormString .= "\n<input type=\"hidden\" name=\"ShippingCost\" value=\"".$vData['courier_cost'].".00\">";
                    $vFormString .= "\n<input type=\"hidden\" name=\"Recipient\" value=\"".$_SESSION['SessionGrafUserFirstname']." ".$_SESSION['SessionGrafUserSurname']."\">";
                    $vFormString .= "\n<input type=\"hidden\" name=\"ShippingAddress1\" value=\"". $vAddress1."\">";
                    $vFormString .= "\n<input type=\"hidden\" name=\"ShippingAddress2\" value=\"". $vData['city']."\">";
                   	$vFormString .= "\n<input type=\"hidden\" name=\"ShippingAddress3\" value=\"". $vData['province']."\">";
                    $vFormString .= "\n<input type=\"hidden\" name=\"ShippingAddress4\" value=\"".$vData['code']."\">";
                    $vFormString .= "\n<input type=\"hidden\" name=\"ShippingAddress5\" value=\"". $vData['country']."\">";
                $vFormString .= "</form>";

                echo $vFormString;
//                error_log($vFormString);

                echo "<Script>";
                echo "$(document).ready(function(){";
                 	echo "$('#MyGateForm').submit();";
                echo "});";
                echo "</Script>";
		}
	}
	else {
		mail("webmaster@graffitibooks.co.za", "Bestellingsfout", $vEmailDetail, "From: server");
		$vErrorResult = $vPages->returnErrorResult($conn, 295);//*Jou bestelling is nie gelaai nie. Probeer asseblief weer. Kontak Graffititi indien die fout herhaaldelik voorkom.
		echo $vErrorResult;
	}
}
else if($vPage == "BestellingSukses" || $vPage == "OrderSuccess"){
	if($vPaymentType != 16){//Set paid = 1 for all except direct payments
		$vDataO['paid'] = 1;
		MysqlQuery::doUpdate($conn, "orders", $vDataO, "id = ".$vData['reference']." AND client_id = '".$vData['client_id']."' AND temp_salt = '".$vData['temp_salt']."'");
	}
	$vCartData['order_date'] = $_SESSION['now_date'];
	$vCartData['order_reference'] = "GRAF/".$vData['reference']."/".$vData['temp_salt'];
	//$vCartData['order_id'] = $vData['reference'];
	MysqlQuery::doUpdate($conn, "cart", $vCartData, "order_id = ".$vData['reference']);
}
else if($vPage == "BestellingFout" || $vPage == "OrderError"){
    $threedsecure = $_POST["_3DSTATUS"];
    $acquirerDateTime = $_POST["_ACQUIRERDATETIME"];
    $price = $_POST["_AMOUNT"];
    $cardCountry = $_POST["_CARDCOUNTRY"];
    $countryCode = $_POST["_COUNTRYCODE"];
    $currencyCode = $_POST["_CURRENCYCODE"];
    $merchantReference = $_POST["_MERCHANTREFERENCE"];
    $transactionIndex = $_POST["_TRANSACTIONINDEX"];
    $payMethod = $_POST["_PAYMETHOD"];

    $errorCode = $_POST['_ERROR_CODE'];
    $errorMessage = $_POST['_ERROR_MESSAGE'];
    $errorDetail = $_POST['_ERROR_DETAIL'];
    $errorSource = $_POST['_ERROR_SOURCE'];

    $bankErrorCode = $_POST["_BANK_ERROR_CODE"];
    $bankErrorMessage = $_POST["_BANK_ERROR_MESSAGE"];

    $vErrorString = "Failed Transaction<br />";
    $vErrorString .= "Result: " . $result."<br />";
    $vErrorString .= "Error Code: " . $errorCode."<br />";
    $vErrorString .= "Error Message: " . $errorMessage."<br />";
    $vErrorString .= "Error Details: " . $errorDetail."<br />";
    $vErrorString .= "Error Source: " . $errorSource."<br />";
    $vErrorString .= "Bank Error Code: " . $bankErrorCode."<br />";
    $vErrorString .= "Bank Error Message: " . $bankErrorMessage;

    echo $vErrorString;
    $vEmailDetail2 = "vPage = BestellingFout op OrderQueries ln 145.  ".$vErrorString;
    mail("webmaster@graffitibooks.co.za", "Bestellingsfout", $vEmailDetail2, "From: Server");
}
?>