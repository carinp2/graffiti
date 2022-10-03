<?php
/**
 * @author Carin Pretorius - CEIT Development
 * Created on 2017-11_22
 */

require_once ("application/classes/General.class.php");
$vGeneral = new General();
include "application/config/session_config.php";
include "include/connect/Connect.php";

require_once ("application/classes/MysqlQuery.class.php");
$vQuery = new MysqlQuery();

$vQuery->cleanCart($conn);

include "include/connect/CloseConnect.php";
