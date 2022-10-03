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

		$vSqlString = "select id, date_published from books";//2014/05
		$stmt = $pConn->prepare($vSqlString);
		if($stmt->execute() == true) {
				$stmt->bind_result($id, $date_published);
				while ($stmt->fetch()) {
					if($id && $id > 0) {
						$vDay = "01";
						$vMonth = substr($date_published, 5, 2);
						$vYear = substr($date_published, 0, 4);
						$vValue = $vYear."-".$vMonth."-".$vDay;

						$vSqlString = "update books_new set date_publish = '".$vValue."' where id = ".$id;//2017-06-15
						$stmt = $pConn->prepare($vSqlString);
						$stmt->execute();
					}
				}
			}
			$stmt->close();

include "include/connect/CloseConnect.php";

?>