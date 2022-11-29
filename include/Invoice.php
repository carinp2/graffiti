<?php

// Include the main TCPDF library (search for installation path).
require_once('tcpdf/tcpdf.php');

// create new PDF document
    $vReceiverFullname = (isset($_SESSION['SessionGrafUserFirstname']) ? $_SESSION['SessionGrafUserFirstname'] : $vOrderResult[27][0]).(isset($_SESSION['SessionGrafUserSurname']) ? ' '.$_SESSION['SessionGrafUserSurname'] : '');
//    $vCountryString = MysqlQuery::getCourierTextPerId($conn, $vOrderResult[8][0],);
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(true);
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	$pdf->SetMargins(15, 15, 15);
	$pdf->SetHeaderMargin(15);
	$pdf->SetFooterMargin(15);
	$pdf->SetAutoPageBreak(TRUE, 20);

	$pdf->SetFont('helvetica', '', 11, '', true);
	$pdf->AddPage();
	$vDate = date("j F Y");
	$vRef = "GRAF/".$vOrderResult[0][0]."/".$vOrderResult[3][0];

	 $pdf->SetFont('helvetica', 'B', 13, '', true);
	 $pdf->Image("images/logo.jpg", 15,15,40,0);
	 $pdf->Cell(80);
	 $pdf->Cell(45,20,'BELASTINGFAKTUUR / TAX INVOICE',0,0,'C');
	 $pdf->Ln(20);

  	$pdf->SetFont('helvetica', '', 11, '', true);
	$pdf->Cell(0,6,'',0,1);
	$pdf->Cell(0,5,'Posbus / PO Box 3356',0,1);
	$pdf->Cell(0,5,'Montanapark, 0159',0,1);
	$pdf->Cell(0,5,'Tel / Phone:  012 - 548 2356',0,1);
	$pdf->Cell(0,5,'VAT no: 4510138193',0,1);
	$pdf->Cell(0,5,'orders@graffitibooks.co.za',0,1, "mailto:orders@graffitibooks.co.za");
	$pdf->Cell(0,5,'www.graffitiboeke.co.za',0,1, "www.graffitiboeke.co.za");
	$pdf->Cell(0,6,'',0,1);
	$pdf->Cell(0,5,$vDate,0,1);
	$pdf->Cell(0,6,'',0,1);

	$pdf->SetFont('Courier','',12);
	$pdf->Cell(0,6,'Verwysings / Reference #: '.$vRef,0,1);
	$pdf->Cell(0,6,'',0,1);
	$pdf->SetFont('helvetica', 'B', 12, '', true);
	$pdf->Cell(0,7,$vReceiverFullname,0,1);
	$pdf->SetFont('helvetica', '', 11, '', true);
	(!empty($vOrderResult[4][0]) ? $pdf->Cell(0,6,$vGeneral->prepareStringForDisplay($vOrderResult[4][0]),0,1) : "");//Address1
	(!empty($vOrderResult[5][0]) ? $pdf->Cell(0,6,$vGeneral->prepareStringForDisplay($vOrderResult[5][0]),0,1) : "");//Address2
	(!empty($vOrderResult[6][0]) ? $pdf->Cell(0,6,$vGeneral->prepareStringForDisplay($vOrderResult[6][0]),0,1) : "");//City
	(!empty($vOrderResult[7][0]) ? $pdf->Cell(0,6,$vGeneral->prepareStringForDisplay($vOrderResult[7][0]),0,1) : "");//Province
	(!empty($vOrderResult[8][0]) ? $pdf->Cell(0,6,'Suid Afrika / South Africa',0,1) : "");//Country
	(!empty($vOrderResult[9][0]) ? $pdf->Cell(0,6,$vOrderResult[9][0],0,1) : "");//Code

	$pdf->Cell(0,5,(isset($_SESSION['SessionGrafUserPhone']) ?$_SESSION['SessionGrafUserPhone'] : $vOrderResult[28][0]),0,1);
	$pdf->Cell(0,5,(isset($_SESSION['SessionGrafUserEmail']) ? $_SESSION['SessionGrafUserEmail'] : $vOrderResult[32][0]),0,1);
	$pdf->Cell(0,6,'',0,1);

	if(!empty($vOrderResult[27][0]) || !empty($vOrderResult[28][0])){
		$pdf->Cell(0,5,"Ontvanger / Receiver:",0,1);
		if(!empty($vOrderResult[27][0])){
			$pdf->Cell(0,5,$vGeneral->prepareStringForDisplay($vOrderResult[27][0]),0,1);
		}
		if(!empty($vOrderResult[28][0])){
			$pdf->Cell(0,5,$vGeneral->prepareStringForDisplay($vOrderResult[28][0]),0,1);
		}
	}
	$pdf->Cell(0,6,'',0,1);


	$pdf->SetFillColor(235, 235, 235);
	$pdf->SetTextColor(0);
	$pdf->SetDrawColor(0);
	$pdf->SetLineWidth(.2);

		$pdf->SetFont('helvetica', '', 8, '', true);
	    $w = array(25, 8, 80, 50, 20);
	    $pdf->Cell($w[0],7,"ISBN",1,0,'C',true);
	    $pdf->Cell($w[1],7,"NO",1,0,'C',true);
	    $pdf->Cell($w[2],7,"TITEL/TITLE",1,0,'C',true);
	    $pdf->Cell($w[3],7,"OUTEUR/AUTHOR",1,0,'C',true);
	    $pdf->Cell($w[4],7,"PRYS/PRICE",1,0,'C',true);
	    $pdf->Ln();
	    $pdf->SetFillColor(255);
	    $pdf->SetTextColor(0);
	    // Data
	    for($b = 0; $b < count($vOrderDetailResult['id']); $b++){
	    	$pdf->MultiCell($w[0],	6, $vOrderDetailResult['isbn'][$b], 'LR', 'L',false,0,'','',true);
	        $pdf->MultiCell($w[1],6,$vOrderDetailResult['number_books'][$b],'LR', 'L', false, 0, '', '', true);
	        $pdf->MultiCell($w[2],6,$vOrderDetailResult['title'][$b],'LR', 'L', false, 0, '', '', true);
	        $pdf->MultiCell($w[3],6,$vOrderDetailResult['author'][$b],'LR', 'L', false, 0, '', '', true);
	        $pdf->MultiCell($w[4],6,"R ".$vOrderDetailResult['price'][$b],'LR', 'R', false, 0, '', '', true);
	        $pdf->Ln();
	            if($b == 17 || $b == 64 || $b == 109 || $b == 154 || $b == 199 || $b == 244 || $b == 289){
	        		$pdf->AddPage();
		        	$pdf->SetFillColor(235, 235, 235);
					$pdf->SetTextColor(0);
					$pdf->SetDrawColor(0);
					$pdf->SetLineWidth(.2);
	        		$pdf->SetFont('dejavusans', '', 7);
				    $w = array(25, 8, 80, 50, 20);
				    $pdf->Cell($w[0],7,"ISBN",1,0,'C',true);
				    $pdf->Cell($w[1],7,"NO",1,0,'C',true);
				    $pdf->Cell($w[2],7,"TITEL/TITLE",1,0,'C',true);
				    $pdf->Cell($w[3],7,"OUTEUR/AUTHOR",1,0,'C',true);
				    $pdf->Cell($w[4],7,"PRYS/PRICE",1,0,'C',true);
				    $pdf->Ln();
				    $pdf->SetFillColor(255);
				    $pdf->SetTextColor(0);
	            }
	    }
// 	    //Totals
	    $pdf->SetFillColor(235, 235, 235);
	    $pdf->SetTextColor(0);
	    $pdf->SetDrawColor(0);
	    $pdf->SetLineWidth(.2);
	    $pdf->SetFont('helvetica', 'B', 8, '', true);
// 	    // Header
	    $f = array(163, 20);
	    $pdf->Cell($f[0],7,"Sub Totaal / Sub Total",1,0,'R',true);
	    $pdf->Cell($f[1],7,"R ".$vOrderResult[12][0],1,0,'R',true);
	    $pdf->Ln();

	    $pdf->Cell($f[0],7,$vShortDeliveryCostText,1,0,'R',true);
	    $pdf->Cell($f[1],7,"R ".$vOrderResult[11][0],1,0,'R',true);
	    $pdf->Ln();

	    $pdf->Cell($f[0],7,"Totaal / Total",1,0,'R',true);
	    $pdf->Cell($f[1],7,"R ".$vOrderResult[13][0],1,0,'R',true);
	    $pdf->Ln();

	    // Closing line
	    $pdf->Cell(array_sum($w),0,'','T');
	$pdf->Cell(0,6,'',0,1);

	if(!empty($vOrderResult[16][0])){
		$pdf->SetFont('helvetica','B',9);
		$pdf->Cell(0,5,'Boodskap / Message: ',0,1);
		$pdf->SetFont('helvetica','',9);
		$pdf->Cell(0,5,$vOrderResult[16][0],0,1);
		$pdf->Cell(0,6,'',0,1);
	}

	if($vOrderResult[14][0] == 16){
		$pdf->Cell(0,6,'',0,1);
		$pdf->SetFont('helvetica','B',9);
		$pdf->Cell(0,5,'Bestelling sal verwerk word sodra betaling ontvang is / Order will be processed when payment is received.',0,1);
		$pdf->SetFont('helvetica','',8);
		$pdf->Cell(0,5,'Elektroniese betalings (EFT): Gebruik asseblief ABSA rekening hieronder en Verwysingsnommer '.$vRef.' as verwysing',0,1);
		$pdf->Cell(0,5,'Electronic payments (EFT): Please use ABSA account below and Reference number '.$vRef.' as reference',0,1);
		$pdf->Cell(0,6,'',0,1);
		$pdf->Cell(0,5,'ABSA',0,1);
		$pdf->Cell(0,5,'BROOKLYN',0,1);
		$pdf->Cell(0,5,'Rekening / Account #: 407 02 55 861',0,1);
		$pdf->Cell(0,5,'Tak / Branch: 632 005',0,1);
		$pdf->Cell(0,6,'',0,1);
	}

	$pdf->SetFont('helvetica', 'B', 11, '', true);
	$pdf->Cell(0,20,'BAIE DANKIE VIR U BESTELLING / THANK YOU FOR YOUR ORDER',0,1,'C');

?>