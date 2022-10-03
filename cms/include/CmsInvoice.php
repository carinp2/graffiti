<?php

// Include the main TCPDF library (search for installation path).
require_once('../tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, false, 'ISO-8859-1', false);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(true);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(15, 10, 15);
$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(5);
$pdf->SetAutoPageBreak(TRUE, 20);

$pdf->SetFont('helvetica', '', 11, '', true);
$pdf->AddPage();
$vDate = date("j F Y");
$vRef = "GRAF/".$vOrderResult[0][0]."/".$vOrderResult[3][0];

 $pdf->SetFont('helvetica', 'B', 13, '', true);
 $pdf->Image("../images/logo.jpg", 15,15,40,0);
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
//Stel hier vir spasie indien dit nie inpas nie										   
//$pdf->Cell(0,1,'',0,1);
$pdf->Cell(0,12,$vDate,0,1);
//$pdf->Cell(0,1,'',0,1);

(!empty($vOrderResult[23][0]) ? $vPubString = " | ".$vOrderResult[23][0] : $vPubString = "");
(!empty($vOrderResult[23][0]) ? $vPubString2 = "(".$vOrderResult[23][0].")" : $vPubString2 = "");

if($vType == "invoice_print"){
//$pdf->SetFont('Courier','',12);
$pdf->Cell(0,10,'Verwysings / Reference #: '.$vRef.' ('.$vPaymentType.$vPubString.')',0,1);
//$pdf->Cell(0,1,'',0,1);
$pdf->SetFont('dejavusans', 'B', 12);
$pdf->Cell(0,7,$vGeneral->prepareStringForDisplay($vClientResult[1])." ".$vGeneral->prepareStringForDisplay($vClientResult[2])." (".$vGeneral->prepareStringForDisplay($vClientResult[0]).")",0,1);
$pdf->SetFont('helvetica', '', 11, '', true);
(!empty($vOrderResult[4][0]) ? $pdf->Cell(0,6,$vGeneral->prepareStringForDisplay($vOrderResult[4][0]),0,1) : "");
(!empty($vOrderResult[5][0]) ? $pdf->Cell(0,6,$vGeneral->prepareStringForDisplay($vOrderResult[5][0]),0,1) : "");
(!empty($vOrderResult[6][0]) ? $pdf->Cell(0,6,$vGeneral->prepareStringForDisplay($vOrderResult[6][0]),0,1) : "");
(!empty($vOrderResult[7][0]) ? $pdf->Cell(0,6,$vOrderResult[7][0],0,1) : "");
(!empty($vOrderResult[8][0]) ? $pdf->Cell(0,6,$vOrderResult[8][0],0,1) : "");
(!empty($vOrderResult[9][0]) ? $pdf->Cell(0,6,$vOrderResult[9][0],0,1) : "");

$pdf->Cell(0,5,$vClientResult[4],0,1);
$pdf->Cell(0,5,$vClientResult[3],0,1);
$pdf->Cell(0,1,'',0,1);

	if(!empty($vOrderResult[27][0]) || !empty($vOrderResult[28][0])){
		$pdf->Cell(0,5,"Ontvanger / Receiver:",0,1);
		if(!empty($vOrderResult[27][0])){
			$pdf->Cell(0,5,$vGeneral->prepareStringForDisplay($vOrderResult[27][0]),0,1);
		}
		if(!empty($vOrderResult[28][0])){
			$pdf->Cell(0,5,$vGeneral->prepareStringForDisplay($vOrderResult[28][0]),0,1);
		}
	}
	$pdf->Cell(0,2,'',0,1);
}
else if($vType == "invoice_print_wr"){
	$pdf->SetFont('dejavusans', 'B', 12);
	$pdf->Cell(0,5,$vGeneral->prepareStringForDisplay($vOrderResult[27][0]),0,1);
	$pdf->SetFont('helvetica', '', 11, '', true);
	(!empty($vOrderResult[4][0]) ? $pdf->Cell(0,6,$vGeneral->prepareStringForDisplay($vOrderResult[4][0]),0,1) : "");
	(!empty($vOrderResult[5][0]) ? $pdf->Cell(0,6,$vGeneral->prepareStringForDisplay($vOrderResult[5][0]),0,1) : "");
	(!empty($vOrderResult[6][0]) ? $pdf->Cell(0,6,$vGeneral->prepareStringForDisplay($vOrderResult[6][0]),0,1) : "");
	(!empty($vOrderResult[7][0]) ? $pdf->Cell(0,6,$vOrderResult[7][0],0,1) : "");
	(!empty($vOrderResult[8][0]) ? $pdf->Cell(0,6,$vOrderResult[8][0],0,1) : "");
	(!empty($vOrderResult[9][0]) ? $pdf->Cell(0,6,$vOrderResult[9][0],0,1) : "");

	(!empty($vOrderResult[9][0]) ? $pdf->Cell(0,6,$vOrderResult[28][0],0,1) : "");
	$pdf->Cell(0,6,$vPubString2,0,1);
	$pdf->Cell(0,6,'',0,1);
}

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
    // Data
    for($b = 0; $b < count($vOrderDetailResult['id']); $b++){
    	$pdf->MultiCell($w[0],6, $vOrderDetailResult['isbn'][$b], 'LR', 'L', 1, 0, '', '', true);
        $pdf->MultiCell($w[1],6,$vOrderDetailResult['number_books'][$b],'LR', 'L', 1, 0, '', '', true);
        $pdf->MultiCell($w[2],6,$vOrderDetailResult['title'][$b],'LR', 'L', 1, 0, '', '', true);
        $pdf->MultiCell($w[3],6,$vOrderDetailResult['author'][$b],'LR', 'L', 1, 0, '', '', true);
        $pdf->MultiCell($w[4],6,"R ".$vOrderDetailResult['price'][$b] ." (".$vOrderDetailResult['original_price'][$b].")",'LR', 'R', 1, 0, '', '', true);
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
    //Totals
    $pdf->SetFillColor(235, 235, 235);
    $pdf->SetTextColor(0);
    $pdf->SetDrawColor(0);
    $pdf->SetLineWidth(.2);
    $pdf->SetFont('helvetica', 'B', 8, '', true);
    // Header
    $f = array(163, 20);
    $pdf->Cell($f[0],7,"Sub Totaal / Sub Total",1,0,'R',true);
    $pdf->Cell($f[1],7,"R ".$vOrderResult[12][0],1,0,'R',true);
    $pdf->Ln();

    $pdf->Cell($f[0],7,$vCourierType,1,0,'R',true);
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
	$pdf->Cell(0,5,General::prepareStringForDisplay($vOrderResult[16][0]),0,1);
	$pdf->Cell(0,6,'',0,1);
}
	$pdf->SetFont('helvetica','',9);
	$pdf->Cell(0,5,'Graffiti Books & Stationery',0,1);
	$pdf->Cell(0,5,'ABSA, Brooklyn',0,1);
	$pdf->Cell(0,5,'Rek # / Account #: 4070255861',0,1);
	$pdf->Cell(0,5,'Tak / Branch: 632005',0,1);

$pdf->SetFont('helvetica', 'B', 11, '', true);
$pdf->Cell(0,20,'BAIE DANKIE VIR U BESTELLING / THANK YOU FOR YOUR ORDER',0,1,'C');

//$pdf->SetFont('helvetica', '', 9, '', true);
//$pdf->Cell(0,20,$vPaymentType,0,1,'C');

$pdf->Output();
?>