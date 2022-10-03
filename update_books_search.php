<?php
/**
 * @author Carin Pretorius - CEIT Development
 * Created on 2016-11_02
 */

session_start();

require_once ("application/classes/General.class.php");
$vGeneral = new General();

include "application/config/session_config.php";
include "include/connect/Connect.php";

require_once ("application/classes/RequestUtils.class.php");
$vRequest = new RequestUtils();
require_once ("application/classes/MysqlQuery.class.php");
$vQuery = new MysqlQuery();

$vResult = "";
$vTotalRows = 0;
$vResults = $vQuery::getBooksNoIndex($conn);//$vId, $vTitle, $vSummary, $vAuthor, $vIllustrator, $vTranslator
for($x = 0; $x < count($vResults[0]); $x++){
	if(!empty($vResults[1][$x])){
		$vData['id'] = $vResults[0][$x];
		$vData['title'] = General::prepareBooksSearchStringData($vResults[1][$x]);
		$vData['summary'] = General::prepareBooksSearchStringData($vResults[2][$x]);
		$vData['author'] = General::prepareBooksSearchStringData($vResults[3][$x]);
		$vData['illustrator'] = General::prepareBooksSearchStringData($vResults[4][$x]);
		$vData['translator'] = General::prepareBooksSearchStringData($vResults[5][$x]);
		$vData['language'] = General::prepareBooksSearchStringData($vResults[6][$x]);
		$vData['isbn'] = $vResults[7][$x];
		$vQuery::doInsert($conn, "books_search", $vData);

		$vBookData['search_idx'] = 1;
		$vQuery->doUpdate($conn, 'books', $vBookData, 'id = '.$vResults[0][$x]);
		$vTotalRows = $vTotalRows + $vRows[0];
		$vBooksRecords = $x+1;

	}
}
$vResult .= "<u>Books search updates:<br><br>";
$vResult .= "Total books indexed: ".$vBooksRecords."<br>";
$vResult .= "Total records added: ".$vTotalRows;

echo $vResult;
include "include/connect/CloseConnect.php";

?>