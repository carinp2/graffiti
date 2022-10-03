<?php
/**
 * @author Carin Pretorius - CEIT Development
 * Created on 2016-11-02
 */

class Export {

    public static function getFullXML($pConn){
    	//784	Media	Books
    	$vWhere = "WHERE b.out_of_print = ?";
    	$vValue = 0;
		$vBindParams = array();
		$vBindLetters = "";
		$vBindLetters .= "i";
		$vBindParams[] = & $vValue;
		$vResults = MysqlQuery::getBooks($pConn, $vWhere, "", $vBindLetters, $vBindParams, "");

	    $vDoc  = new DOMDocument('1.0', 'UTF-8');
	    $vDoc->formatOutput = true;

	    $rootNode = $vDoc->appendChild($vDoc->createElement('rss'));
	    $rootNode->setAttribute('version', '2.0');
	    $rootNode->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:g', 'http://base.google.com/ns/1.0');

	    $channelNode = $rootNode->appendChild($vDoc->createElement('channel'));
	    $channelNode->appendChild($vDoc->createElement('title', 'Graffiti Books'));
	    $channelNode->appendChild($vDoc->createElement('description', 'https://www.graffitibooks.co.za'));
	    $channelNode->appendChild($vDoc->createElement('link', 'Buy Afrikaans and English books online'));

		for($x = 0; $x < count($vResults[0]); $x++){
	      	//Price start
			$vNewTopDiscountPrice =  round($vResults[8][$x]-($vResults[8][$x]*$vResults[26][$x]));
			(!empty($vResults[7][$x]) && $vResults[7][$x] > 0  ? $vSpecialDiscountPrice = $vResults[7][$x] : $vSpecialDiscountPrice = $vResults[8][$x]);
			$vClientDiscountPrice = $vResults[8][$x];
			$vSoonDiscountPrice = round($vResults[8][$x]-($vResults[8][$x]*$vResults[26][$x]));
			$vNormalPrice = $vResults[8][$x];
			$vPriceDisplayType = "export";
			include "include/BookPriceDisplay.php";//$vFinalPrice

	        $itemNode = $channelNode->appendChild($vDoc->createElement('item'));
	        $itemNode->appendChild($vDoc->createElement('g:id'))->appendChild($vDoc->createTextNode($vResults[0][$x]));
	        $itemNode->appendChild($vDoc->createElement('g:title'))->appendChild($vDoc->createTextNode($vResults[4][$x]));
	        if(!empty($vResults[5][$x])){
	        	$itemNode->appendChild($vDoc->createElement('g:description'))->appendChild($vDoc->createTextNode($vResults[5][$x]));
	        }
	        else {
	        	$itemNode->appendChild($vDoc->createElement('g:description'))->appendChild($vDoc->createTextNode($vResults[4][$x]));
	        }
	        $itemNode->appendChild($vDoc->createElement('g:link'))->appendChild($vDoc->createTextNode('https://www.graffitibooks.co.za/en/'.$vResults[0][$x].'/Books'));
	        $itemNode->appendChild($vDoc->createElement('g:image_link'))->appendChild($vDoc->createTextNode('https://www.graffitibooks.co.za/images/books/'.$vResults[6][$x]));
	        $itemNode->appendChild($vDoc->createElement('g:availability'))->appendChild($vDoc->createTextNode('in stock'));
	        $itemNode->appendChild($vDoc->createElement('g:price'))->appendChild($vDoc->createTextNode('R '.$vFinalPrice));
	        $itemNode->appendChild($vDoc->createElement('g:google_product_category'))->appendChild($vDoc->createTextNode(784));
	        $itemNode->appendChild($vDoc->createElement('g:product_type'))->appendChild($vDoc->createTextNode($vResults[19][$x].", ".$vResults[20][$x]));
	        $itemNode->appendChild($vDoc->createElement('g:gtin'))->appendChild($vDoc->createTextNode($vResults[1][$x]));
	        $itemNode->appendChild($vDoc->createElement('g:mpn'))->appendChild($vDoc->createTextNode($vResults[1][$x]));
	        $itemNode->appendChild($vDoc->createElement('g:condition'))->appendChild($vDoc->createTextNode('new'));
	        $itemNode->appendChild($vDoc->createElement('g:adult'))->appendChild($vDoc->createTextNode('no'));
	      }

	    $xmlOutput = $vDoc->saveXML();

	    header("Content-disposition: inline; filename=graffiti.xml");
	    header("Content-Type: text/xml");

	    echo $xmlOutput;
    }

    public static function getXMLPerPublisher($pConn, $pId){
    	$vWhere = "WHERE b.out_of_print = ? AND publisher = ?";
    	$vValue = 0;
		$vBindParams = array();
		$vBindLetters = "";
		$vBindLetters .= "i";
		$vBindParams[] = & $vValue;
		$vBindLetters .= "i";
		$vBindParams[] = & $pId;
		$vResults = MysqlQuery::getBooks($pConn, $vWhere, "", $vBindLetters, $vBindParams, "");

	    $vDoc  = new DOMDocument('1.0', 'UTF-8');
	    $vDoc->formatOutput = true;

	    $rootNode = $vDoc->appendChild($vDoc->createElement('graffiti-books'));
	    $rootNode->setAttribute('version', '1.0');

	    $booksNode = $rootNode->appendChild($vDoc->createElement('books'));

		for($x = 0; $x < count($vResults[0]); $x++){
	      	//Price start
			$vNewTopDiscountPrice =  round($vResults[8][$x]-($vResults[8][$x]*$vResults[26][$x]));
			(!empty($vResults[7][$x]) && $vResults[7][$x] > 0  ? $vSpecialDiscountPrice = $vResults[7][$x] : $vSpecialDiscountPrice = $vResults[8][$x]);
			$vClientDiscountPrice = $vResults[8][$x];
			$vSoonDiscountPrice = round($vResults[8][$x]-($vResults[8][$x]*$vResults[26][$x]));
			$vNormalPrice = $vResults[8][$x];
			$vPriceDisplayType = "export";
			include "include/BookPriceDisplay.php";//$vFinalPrice

	        $itemNode = $booksNode->appendChild($vDoc->createElement('book'));
	        $itemNode->appendChild($vDoc->createElement('isbn'))->appendChild($vDoc->createTextNode($vResults[1][$x]));
	        $itemNode->appendChild($vDoc->createElement('title'))->appendChild($vDoc->createTextNode($vResults[4][$x]));
	        $itemNode->appendChild($vDoc->createElement('url'))->appendChild($vDoc->createTextNode('https://www.graffitibooks.co.za/en/'.$vResults[0][$x].'/Books'));
	        $itemNode->appendChild($vDoc->createElement('price'))->appendChild($vDoc->createTextNode($vFinalPrice));
	      }

	    $xmlOutput = $vDoc->saveXML();

	    header("Content-disposition: inline; filename=graffiti.xml");
	    header("Content-Type: text/xml");

	    echo $xmlOutput;
    }

}
?>