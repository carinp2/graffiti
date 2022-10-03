<?php
session_start();
require_once ("../application/classes/General.class.php");
$vGeneral = new General();
require_once ("application/classes/CmsParts.class.php");
$vCmsParts = new CmsParts();
require_once ("../application/classes/MysqlQuery.class.php");
$vQuery = new MysqlQuery();
require_once ("../application/classes/RequestUtils.class.php");
$vRequest = new RequestUtils();
require_once ("../application/classes/StringUtils.class.php");
$vString = new StringUtils();
require_once ("application/classes/CmsModal.class.php");
$vCmsModal= new CmsModal();

include "../application/config/session_config.php";
include "../include/connect/Connect.php";
include "application/config/session_cms_config.php";

$vStartDate = $_GET['sd'];
$vEndDate = $_GET['ed'];

$vResult = $vQuery->getMonthEndStats($conn, $vStartDate, $vEndDate);
//$isbn, $book_id, $price, $sold_price, $original_price, $cost_price, $order_date, $publisher, $special, $cost, $number_books, $order_id, $cost_one
//	0		1	    	2		3				4				5			6			7			8		9			10      11          12

$vTotalCost = 0;

$vString = "<table border=\"1\" cellspacing=\"0\">";
	$vString .= "<thead>";
		$vString .= "<tr class=\"red\">";
			$vString .= "<th>ISBN</th>";
			$vString .= "<th>Datum</th>";
			$vString .= "<th>Prys vir 1</th>";
			$vString .= "<th>Aantal verkoop</th>";
			$vString .= "<th>Oorspronklike prys</th>";
			$vString .= "<th>Verkoopprys</th>";
			$vString .= "<th>Kosprys</th>";
			$vString .= "<th>Uitgewer</th>";
			$vString .= "<th>Cost %</th>";
			$vString .= "<th>Winskopie</th>";
		$vString .= "</tr>";
	$vString .= "</thead>";

for($x = 0; $x < count($vResult[0]); $x++){
	if($vResult[8][$x] == 1){
		$vCostPrice = $vResult[5][$x] * $vResult[10][$x];
		$vTotalCost = $vTotalCost+$vCostPrice;
	}
	else {
		$vPerc = (100-$vResult[9][$x])/100;
		$vCostPrice = round($vResult[4][$x]*$vPerc);
		$vTotalCost = $vTotalCost+$vCostPrice;
	}
	$vString .= "<tbody>";
		$vString .= "<tr class=\"red\">";
			$vString .= "<td align=\"center\">".$vResult[0][$x]."</td>";
			$vString .= "<td align=\"center\">".$vResult[6][$x]."</td>";
			$vString .= "<td align=\"right\">R".$vResult[2][$x]."</td>";
			$vString .= "<td align=\"center\">".$vResult[10][$x]."</td>";
			$vString .= "<td align=\"right\">R".$vResult[4][$x]."</td>";
			$vString .= "<td align=\"right\">R".$vResult[3][$x]."</td>";
			$vString .= "<td align=\"right\">R".$vCostPrice."</td>";
			$vString .= "<td align=\"center\">".$vResult[7][$x]."</td>";
			$vString .= "<td align=\"center\">".$vResult[9][$x]."%</td>";
			$vString .= "<td align=\"center\">".($vResult[8][$x] == 1 ? "J" : "N" )."</td>";
		$vString .= "</tr>";
	$vString .= "</tbody>";
}
	$vString .= "<tfoot>";
		$vString .= "<tr class=\"red\">";
			$vString .= "<th></th>";
			$vString .= "<th></th>";
			$vString .= "<th></th>";
			$vString .= "<th></th>";
			$vString .= "<th>".array_sum($vResult[4])."</th>";
			$vString .= "<th>".array_sum($vResult[3])."</th>";
			$vString .= "<th>".$vTotalCost."</th>";
			$vString .= "<th></th>";
			$vString .= "<th></th>";
			$vString .= "<th></th>";
		$vString .= "</tr>";
	$vString .= "</tfoot>";

echo $vString;

echo "</body></html>";
