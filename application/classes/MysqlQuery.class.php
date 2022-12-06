<?php
/**
 * Queries
 * @author Carin Pretorius - CEIT Development Namibia -
 * Created on 2016-09-21
 */

class MysqlQuery {

	/**
	 * Escapes characters to be postgresql ready
	 *
	 * @param string $pString
	 * @param object $pConn Database connection
	 * @return string
	 */
	static function escape($string, $pConn) {
//		if(get_magic_quotes_gpc()) $string = stripslashes($string);
//		return mysqli_escape_string($pConn, MysqlQuery::fixEncoding($string));
	}

	/**
	 * Fixes the encoding to uf8
	 *
	 * @param string
	 * @return string
	 */
	static function fixEncoding($in_str) {
		$cur_encoding = mb_detect_encoding($in_str);
		if($cur_encoding == "UTF-8" && mb_check_encoding($in_str, "UTF-8"))
			return $in_str;
		else
			return utf8_encode($in_str);
	}

	/**
	 * Return number of records in table
	 *
	 * @param object $pConn Database connection
	 * @param string $pTable Table to use
	 * @param string $pField Field to use
	 * @param string $pWhere Where string without 'where'
	 * @param string int $pValue bind_param value string
	 * @param string $pBindString bind_param string
	 * @return int
	 */
	public static function getCount($pConn, $pTable, $pField, $pWhere, $pBindLetters, $pBindParams) {
		$sqlString = "SELECT count(" . $pField . ") as number FROM " . $pTable ." ". $pWhere;
		//error_log("getCount: ".$sqlString."--".$pBindParams[0], 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($sqlString);
		array_unshift($pBindParams, $pBindLetters);
		call_user_func_array(array($stmt, 'bind_param'), $pBindParams);
        $number = 0;
		if($stmt->execute() == true) {
			$stmt->bind_result($number);
			$stmt->fetch();
			$vCount = $number;
		}
		$stmt->close();
		return $vCount;
	}

	public static function searchCount($pConn, $pField, $pTable, $pWhere, $pBindLetters, $pBindParams) {
		$vSqlString = "SELECT count(distinct(".$pField.")) as total from ".$pTable." ".$pWhere;
 		//error_log("searchCount: ".$vSqlString."--".$pBindParams[0]."-//-".$pBindParams[1]."//", 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($vSqlString);
		array_unshift($pBindParams, $pBindLetters);
		call_user_func_array(array($stmt, 'bind_param'), $pBindParams);
        $total = 0;
		if($stmt->execute() == true) {
			$stmt->bind_result($total);
			$stmt->fetch();
		}
		$stmt->close();
		return $total;
	}

	/**
	 * Generic insert query
	 *
	 * @param object $pConn Database connection
	 * @param string $pTable Table to update
	 * @param [] $pData Field, value array
	 * @return number
	 */
	public static function doInsert($pConn, $pTable, $pData) {
		$q = "INSERT into " . $pTable . " ";
		$v = '';
		$n = '';
		foreach($pData as $key=>$val) {
			$n .= "$key, ";
            if($val == 0)
                $v .= "0, ";
            elseif($val == 'null' || empty($val))
				$v .= "NULL, ";
			elseif(strtolower($val) == 'now()')
				$v .= "NOW(), ";
			else
				$v .= "'" . $val . "', ";
		}
		$q .= "(" . rtrim($n, ', ') . ") VALUES (" . rtrim($v, ', ') . ");";
//        error_log('Insert: ' . $q, 3, '../error.log');
		if(mysqli_query($pConn, $q)){
			$vResult = mysqli_insert_id($pConn);
		}
		else {
			$vResult = 0;
		}
		return $vResult;
		//return $q;
	}

	/**
	 * Generic update
	 *
	 * @param object $pConn Database connection
	 * @param string $pTable Table to update
	 * @param [] $pData Field, value array
	 * @param string $pWhere Where clause
	 */
	public static function doUpdate($pConn, $pTable, $pData, $pWhere) {
		$q = "UPDATE " . $pTable . " SET ";
		foreach($pData as $key=>$val) {
			if(strtolower($val) == 'null')
				$q .= "$key = NULL, ";
			elseif(strtolower($val) == 'now()')
				$q .= "$key = NOW(), ";
			else
				$q .= "$key=\"" . $val . "\", ";
		}

		if(strlen($pWhere) > 0) {
			$sqlString = rtrim($q, ', ') . ' WHERE ' . $pWhere . ';';
		}
		else {
			$sqlString = rtrim($q, ', ') . ';';
		}
		//error_log("Update: ".$sqlString, 3, 'C:/a_Server/wamp64/logs/php_error.log');
		if(mysqli_query($pConn, $sqlString)){
			$vResult = 1;
		}
		else {
			$vResult = 0;
		}
		return $vResult;
	}

	public static function doDelete($pConn, $pTable, $pWhere) {
		$sqlString = "DELETE from " . $pTable . " WHERE " . $pWhere;
		//error_log("SQL: ".$sqlString, 0, "C:/Temp/php_errors.log");
		if(mysqli_query($pConn, $sqlString)){
			$vResult = 1;
		}
		else {
			$vResult = 0;
		}
		return $vResult;
	}

	/**
	 * Return new serial id from table
	 *
	 * @param object $pConn Database connection
	 * @param string $pTable Table to get id from
	 * @return int
	 */
	public static function getNewId($pConn, $pTable) {
		$sqlString = "SELECT max(id) as new_id FROM " . $pTable;
		$stmt = $pConn->prepare($sqlString);
        $new_id = 0;
		if($stmt->execute() == true) {
			$stmt->bind_result($new_id);
			while ($stmt->fetch()) {
				if($new_id && $new_id > 0) {
					$newId = $new_id;
				}
			}
		}
		$stmt->close();
		return $newId;
	}

	public static function getMax($pConn, $pTable, $pField) {
		$sqlString = "SELECT max(".$pField.") as max_id FROM " . $pTable;
		//error_log("getCount: ".$sqlString, 0, "C:/Temp/php_errors.log");
        $max_id = 0;
		$stmt = $pConn->prepare($sqlString);
		if($stmt->execute() == true) {
			$stmt->bind_result($max_id);
			while ($stmt->fetch()) {
				if($max_id && $max_id > 0) {
					$maxId = $max_id;
				}
			}
		}
		$stmt->close();
		return $maxId;
	}

	public static function getLookup($pConn, $pType) {
		$sqlString = "SELECT id, ".$_SESSION['SessionGrafLanguage']." as text, sort_order FROM lk_text where type = ? ORDER BY sort_order";
		//error_log("getLookup: ".$sqlString."--".$pType, 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($sqlString);
		$stmt->bind_param("s", $pType);
        $id=0;
        $text=$sort_order = "";
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $text, $sort_order);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vId[] = $id;
					$vText[] = $text;
					$vSortOrder[] = $sort_order;
				}
			}
		}
		$stmt->close();
		return array($vId, $vText, $vSortOrder);
	}

	public static function getCmsLookup($pConn, $pType) {
		$sqlString = "SELECT id, af as text, sort_order FROM lk_text where type = ? ORDER BY sort_order";
		//error_log("getLookup: ".$sqlString."--".$pType, 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($sqlString);
		$stmt->bind_param("s", $pType);
        $id=0;
        $text=$sort_order = "";
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $text, $sort_order);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vId[] = $id;
					$vText[] = $text;
					$vSortOrder[] = $sort_order;
				}
			}
		}
		$stmt->close();
		return array($vId, $vText, $vSortOrder);
	}

	public static function getLookupPerId($pConn, $pId) {
		$sqlString = "SELECT ".$_SESSION['SessionGrafLanguage']." as text FROM lk_text where id = ?";
		//error_log("Lookup: ".$sqlString."--".$pId, 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($sqlString);
		$stmt->bind_param("i", $pId);
        $text = "";
		if($stmt->execute()) {
			$stmt->bind_result($text);
			$stmt->fetch();
			if(!empty($text)) {
				$vText = $text;
			}
		}
		$stmt->close();
		return $vText;
	}

	public static function getCmsLookupPerId($pConn, $pId) {
		$sqlString = "SELECT af as text FROM lk_text where id = ?";
		//error_log("getCart: ".$vSqlString."--".$pBindParams[0], 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($sqlString);
		$stmt->bind_param("i", $pId);
        $text = "";
		if($stmt->execute() == true) {
			$stmt->bind_result($text);
			$stmt->fetch();
			if(!empty($text)) {
				$vText = $text;
			}
		}
		$stmt->close();
		return $vText;
	}

	/**
	 * Check for existing email in clients table
	 *
	 * @param object $pConn Database connection
	 * @param string $pUsername Client email
	 * @return int
	 */
	public static function checkClient($pConn, $pEmail) {
		$sqlString = "select count(id) as count from clients where upper(email) = ?";
//		$vEmail = strtoupper($pUsername);
		$stmt = $pConn->prepare($sqlString);
		$stmt->bind_param("s", $pEmail);
        $count = 0;
		if($stmt->execute() == true) {
			$stmt->bind_result($count);
			while ($stmt->fetch()) {
				$countNum = $count;
			}
		}
		$stmt->close();
		return $countNum;
	}

	public static function checkExists($pConn, $pTable, $pColumn, $pWhere) {
		$countNum = 0;
		$sqlString = "select count(" . $pColumn . ") as count from " . $pTable . " WHERE " . $pWhere;
		//error_log($vSqlString, 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($sqlString);
        $count = 0;
		if($stmt->execute() == true) {
			$stmt->bind_result($count);
			$stmt->fetch();
			$countNum = $count;
		}
		$stmt->close();
		return $countNum;
	}

	public static function getBookPrice($pConn, $pIsbn) {
		$sqlString = "select price from books WHERE isbn = ?";
		$stmt = $pConn->prepare($sqlString);
		$stmt->bind_param("s", $pIsbn);
        $price = 0;
		if($stmt->execute() == true) {
			$stmt->bind_result($price);
			while ($stmt->fetch()) {
				if(!empty($price)) {
					$vPrice = $price;
				}
			}
		}
		$stmt->close();
		return $vPrice;
	}

	public static function checkSpecial($pConn, $pWhere) {
		$sqlString = "select special from books WHERE " . $pWhere;
		//error_log($sqlString, 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($sqlString);
        $special = 0;
		if($stmt->execute() == true) {
			$stmt->bind_result($special);
			$stmt->fetch();
			$vSpecial = $special;
		}
		$stmt->close();
		return $vSpecial;
	}

	public static function checkPublicationDate($pConn, $pValue) {
		$sqlString = "select date_publish from books WHERE isbn = ?";
		//error_log("checkPublicationDate: ".$sqlString."--".$pValue, 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($sqlString);
		$stmt->bind_param("s", $pValue);
        $date_publish = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($date_publish);
			while ($stmt->fetch()) {
				$vDatePublish = $date_publish;
			}
		}
		$stmt->close();
		return $vDatePublish;
	}

	public static function checkBookExistsCart($pConn, $pWhere) {
		$bookNum = 0;
		$sqlString = "select number from cart WHERE " . $pWhere;
		//error_log("checkBookExistsCart: ".$sqlString, 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($sqlString);
        $number = 0;
		if($stmt->execute() == true) {
			$stmt->bind_result($number);
			$stmt->fetch();
			$bookNum = $number;
		}
		$stmt->close();
		return $bookNum;
	}

	public static function doQuery($pConn, $pSqlString){
		$sqlString = $pSqlString;
		$stmt = $pConn->prepare($sqlString);
		if($stmt->execute() == true) {
			$vResult = 1;
		}
		else {
			$vResult = 2;
		}
		$stmt->close();
		return $vResult;
	}

	/**
	 * Return sections for main menu
	 *
	 * @param object $pConn Database connection
	 *  @param string $pWhere Where clause
	 *   @param string $pSortOrder Sort order
	 *    @param int $pValue Where clause value
	 * @return (int|string|string|string|int)[]
	 */
	public static function getSections($pConn, $pWhere, $pSortOrder, $pValue) {
		$sqlString = "SELECT id, ".$_SESSION['SessionGrafLanguage']."_section as section, ".$_SESSION['SessionGrafLanguage']."_url as url, ".$_SESSION['SessionGrafLanguage']."_description as description, sort_order FROM sections ".$pWhere." ".$pSortOrder;
		//echo $sqlString;
		$stmt = $pConn->prepare($sqlString);
		if($pValue > 0){
			$stmt->bind_param("i", $pValue);
		}
        $id=0;
        $section=$url=$description=$sort_order = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $section, $url, $description, $sort_order);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vId[] = $id;
					$vSection[] = $section;
					$vUrl[] = $url;
					$vDescription[] = $description;
					$vSortOrder[] = $sort_order;
				}
			}
		}
		$stmt->close();
		return array($vId, $vSection, $vUrl, $vDescription, $vSortOrder);
	}

	public static function getCategories($pConn, $pSection, $pActive){
		if($pSection < 7){
			$vExisting = ($pSection == 1 ? implode(",", $_SESSION['SessionBookCategories']) : implode(",", $_SESSION['SessionStationaryCategories']));
			$vSqlString = "select id, category, sort_order from categories where section_id = ? and activex = ? and id in (0,".$vExisting.") order by sort_order";
			//error_log($vSqlString, 0, "C:/Temp/php_errors.log");
			$stmt = $pConn->prepare($vSqlString);
			$stmt->bind_param("ii", $pSection, $pActive);
            $id=0;
            $category=$sort_order = '';
			if($stmt->execute() == true) {
				$stmt->bind_result($id, $category, $sort_order);
				while ($stmt->fetch()) {
					if($id && $id > 0) {
						$vCategoryId[] = $id;
						$vCategory[] = $category;
					}
				}
			}
			$stmt->close();
			return array($vCategoryId, $vCategory);
		}
	}

	public static function getExistingCategories($pConn, $pActive, $pSection){
		//$vSqlString = "select id from categories where id in(select distinct(category) from books where language = '".$_SESSION['SessionGrafLanguage']."') and activex = ?";
		$vSqlString = "select id from categories where id in(select distinct(category) from books where out_of_print = 0 AND section = ?) and activex = ?";
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("ii", $pSection, $pActive);
        $id = 0;
        $vCategoryId = array();
		if($stmt->execute() == true) {
			$stmt->bind_result($id);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vCategoryId[] = $id;
				}
			}
		}
		$stmt->close();
		return $vCategoryId;
	}

	public static function getAllCategoriesPerSection($pConn, $pSection, $pActive){
		$vSqlString = "select id, category, sort_order from categories where section_id = ? and activex = ? order by sort_order";
		//error_log($vSqlString."//".$pSection."//".$pActive);
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("ii", $pSection, $pActive);
        $id=0;
        $category=$sort_order = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $category, $sort_order);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vCategoryId[] = $id;
					$vCategory[] = $category;
				}
			}
		}
		$stmt->close();
		return array($vCategoryId, $vCategory);
	}

	public static function getAllCategories($pConn, $pActive){
		$vSqlString = "select id, category, sort_order, section_id from categories where activex = ? order by section_id, sort_order";
		//error_log($vSqlString."//".$pActive);
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("i", $pActive);
        $id=0;
        $category=$sort_order=$section_id = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $category, $sort_order, $section_id);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vCategoryId[] = $id;
					$vCategory[] = $category;
				}
			}
		}
		$stmt->close();
		return array($vCategoryId, $vCategory);
	}

	public static function getCategoryPerId($pConn, $pId){
		$vSqlString = "select  category from categories where id = ?";
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("i", $pId);
        $category = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($category);
			while ($stmt->fetch()) {
				if(!empty($category)) {
					$vCategory = $category;
				}
			}
		}
		$stmt->close();
		return $vCategory;
	}

	public static function getSubCategories($pConn, $pCategoryId, $pActive, $pSection){
		$vExisting = ($pSection == 1 ? implode(",", $_SESSION['SessionBookSubCategories']) : implode(",", $_SESSION['SessionStationarySubCategories']));
		(!isset($_SESSION['SessionGrafLanguage']) || $_SESSION['SessionGrafLanguage'] == '' || $_SESSION['SessionGrafLanguage'] == 'af' ? $vSessionLanguage = 'af' : $vSessionLanguage = 'en');
		$vSqlString = "select id, category_id, sub_category_".$vSessionLanguage." AS sub_category, sort_order_".$vSessionLanguage." AS sort_order from sub_categories where category_id = ? and activex = ? and id in (".$vExisting.") order by sort_order_".$vSessionLanguage;
		//error_log("getSubCategories: ".$vSqlString, 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("ii", $pCategoryId, $pActive);
        $id=0;
        $category_id=$sub_category=$sort_order ='';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $category_id, $sub_category, $sort_order);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vSubCategoryId[] = $id;
					$vSubCategory[] = $sub_category;
				}
			}
		}
		$stmt->close();
		return array($vSubCategoryId, $vSubCategory);
	}

	public static function getAllActiveCategorySubCategories($pConn){
		(!isset($_SESSION['SessionGrafLanguage']) || $_SESSION['SessionGrafLanguage'] == '' || $_SESSION['SessionGrafLanguage'] == 'af' ? $vSessionLanguage = 'af' : $vSessionLanguage = 'en');
		$vValue = 1;
		$vSqlString = "select s.id, s.category_id, s.sub_category_".$vSessionLanguage." AS sub_category, c.category from sub_categories s LEFT JOIN categories as c on c.id = s.category_id where s.activex = ? order by c.category ASC, s.sub_category_".$vSessionLanguage." ASC";
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("i", $vValue);
        $id=0;
        $category_id=$sub_category=$category ='';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $category_id, $sub_category, $category);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vSubCategoryId[] = $id;
					$vSubCategory[] = $category." | ".$sub_category;
				}
			}
		}
		$stmt->close();
		return array($vSubCategoryId, $vSubCategory);
	}

	public static function getAllSubCategoriesPerCategory($pConn, $pCategoryId, $pActive){
		(!isset($_SESSION['SessionGrafLanguage']) || $_SESSION['SessionGrafLanguage'] == '' || $_SESSION['SessionGrafLanguage'] == 'af' ? $vSessionLanguage = 'af' : $vSessionLanguage = 'en');
		$vSqlString = "select id, category_id, sub_category_".$vSessionLanguage." AS sub_category, sort_order_".$vSessionLanguage." AS sort_order from sub_categories where category_id = ? and activex = ? order by sort_order_".$vSessionLanguage;
//		error_log($vSqlString." - ".$vSessionLanguage." - ".$pCategoryId, 3, '../errors.log');
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("ii", $pCategoryId, $pActive);
        $id=0;
        $category_id=$sub_category=$sort_order = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $category_id, $sub_category, $sort_order);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vSubCategoryId[] = $id;
					$vSubCategory[] = $sub_category;
				}
			}
		}
		$stmt->close();

        if(isset($id)){
            return array($vSubCategoryId, $vSubCategory);
        }
        else {
            return array();
        }
	}

	public static function getCategorySubCategoryFromSubCat($pConn, $pSubCategoryId){
		(!isset($_SESSION['SessionGrafLanguage']) || $_SESSION['SessionGrafLanguage'] == '' || $_SESSION['SessionGrafLanguage'] == 'af' ? $vSessionLanguage = 'af' : $vSessionLanguage = 'en');
		$vSqlString = "select sc.sub_category_".$vSessionLanguage." AS sub_category, c.category from sub_categories sc LEFT JOIN categories AS c ON c.id = sc.category_id where sc.id = ?";
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("i", $pSubCategoryId);
        $sub_category=$category = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($sub_category, $category);
			while ($stmt->fetch()) {
				if(!empty($sub_category)) {
					$vSubCategory= $sub_category;
					$vCategory = $category;
				}
			}
		}
		$stmt->close();
		return array($vSubCategory, $vCategory);
	}

	public static function getExistingSubCategories($pConn, $pActive, $pSection){
		$vSqlString = "select id from sub_categories where id in(select distinct(sub_category) from books where out_of_print = 0 AND section = ?) and activex = ?";
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("ii", $pSection, $pActive);
        $id = 0;
        $vSubCategoryId = array();
		if($stmt->execute() == true) {
			$stmt->bind_result($id);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vSubCategoryId[] = $id;
				}
			}
		}
		$stmt->close();
		return $vSubCategoryId;
	}

	public static function getSubCategorPerId($pConn, $pId){
		(!isset($_SESSION['SessionGrafLanguage']) || $_SESSION['SessionGrafLanguage'] == '' || $_SESSION['SessionGrafLanguage'] == 'af' ? $vSessionLanguage = 'af' : $vSessionLanguage = 'en');
		$vSqlString = "select sub_category_".$vSessionLanguage." AS sub_category from sub_categories where id = ?";
		//echo $vSqlString."//".$pCategoryId;
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("i", $pId);
        $sub_category = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($sub_category);
			while ($stmt->fetch()) {
				if(!empty($sub_category)) {
					$vSubCategory = $sub_category;
				}
			}
		}
		$stmt->close();
		return $vSubCategory;
	}

	public static function getText($pConn, $vId){
	$vSqlString = "select ".$_SESSION['SessionGrafLanguage']." as language from lk_language_text where id = ?";
	//error_log("SQL: ".$vSqlString." - ".$vId, 0, "C:/Temp/php_errors.log");
	$stmt = $pConn->prepare($vSqlString);
	$stmt->bind_param("i", $vId);
    $language = "";
	if($stmt->execute() == true) {
		$stmt->bind_result($language);
		while ($stmt->fetch()) {
			if(!empty($language)) {
				$vLanguage = $language;
			}
		}
	}
	$stmt->close();
	return General::prepareStringForDisplay($vLanguage);
	}

	public static function getCmsText($pConn, $vId, $pLanguage){
	$vSqlString = "select ".$pLanguage." as language from lk_language_text where id = ?";
	//error_log("SQL: ".$vSqlString." - ".$vId, 0, "C:/Temp/php_errors.log");
	$stmt = $pConn->prepare($vSqlString);
	$stmt->bind_param("i", $vId);
    $language = '';
	if($stmt->execute() == true) {
		$stmt->bind_result($language);
		while ($stmt->fetch()) {
			if(!empty($language)) {
				$vLanguage = $language;
			}
		}
	}
	$stmt->close();
	return $vLanguage;
	}

	public static function getCarouselImages($pConn, $pWhere){
		$vSqlString = "select id, url, alt, blob_path, sort_order, advert, start_date, end_date from carousel_images ".$pWhere." order by sort_order";
		//error_log("getCarouselImages: ".$vSqlString, 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($vSqlString);
        $id=0;
        $url=$alt=$blob_path=$sort_order=$advert=$start_date=$end_date = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $url, $alt, $blob_path, $sort_order, $advert, $start_date, $end_date);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vId[] = $id;
					$vUrl[] = $url;
					$vAlt[] = $alt;
					$vBlobPath[] = $blob_path;
					$vSortOrder[] = $sort_order;
					$vAdvert[] = $advert;
					$vStartDate[] = $start_date;
					$vEndDate[] = $end_date;
				}
			}
		}
		$stmt->close();
		return array($vId, $vUrl, $vAlt, $vBlobPath, $vSortOrder, $vAdvert, $vStartDate, $vEndDate);
	}

	public static function getBooks($pConn, $pWhere, $pOrder, $pBindLetters,  $pBindParams, $pLimit){
        $pOrder = (!empty($pOrder) && strpos($pOrder, "price") !== false ? str_replace("price", "SortPrice", $pOrder): $pOrder);
        $pOrder = (!empty($pOrder) && strpos($pOrder, "special_SortPrice") !== false ? str_replace("special_SortPrice", "SortPrice", $pOrder): $pOrder);

		(strpos($pOrder, 'date_publish') == false && !empty($pOrder) ? $pOrder = $pOrder.", b.date_publish DESC" : $pOrder = $pOrder);
		(!isset($_SESSION['SessionGrafLanguage']) || $_SESSION['SessionGrafLanguage'] == '' || $_SESSION['SessionGrafLanguage'] == 'af' ? $vSessionLanguage = 'af' : $vSessionLanguage = 'en');
		$vSqlString = "select b.id, b.isbn, b.category, b.sub_category, b.title, b.summary, b.blob_path, b.special_price, b.price, b.date_publish, b.date_loaded, b.new, b.special, b.top_seller, b.top_seller_rank, b.out_of_print, b.in_stock, ";
		$vSqlString .= "b.publisher, b.language, c.category AS category_string, sc.sub_category_".$vSessionLanguage." AS sub_category_string, b.author, b.illustrator, b.translator, b.edit_by, b.default_discount, b.dimensions, b.weight, ";
		$vSqlString .= "b.format, b.pages, b.new_rank, b.soon_discount, b.soon_rank, b.soon, b.special_rank as special_rank, b.tv, b.tv_date, b.cost_price, b.rr, b.rr_date, b.section, ";
		$vSqlString .= "b.e_isbn, b.e_url, b.e_price ";
//Leonie request 26-04-2022 - Sort on special price if special price smaller than price
		$vSqlString .= ",
		    CASE
                WHEN (b.special_price < b.price AND b.special_price > 0) THEN b.special_price
                WHEN (b.special_price >= b.price OR b.special_price = 0) THEN b.price
                ELSE b.price
            END AS SortPrice ";
		$vSqlString .= "from books b ";
		$vSqlString .= "LEFT JOIN categories AS c ON c.id = b.category ";
		$vSqlString .= "LEFT JOIN sub_categories AS sc ON sc.id = b.sub_category ";
		$vSqlString .= $pWhere." ".$pOrder." ".$pLimit;
        
//		error_log("getBooks.......: ".$vSqlString."--".$pBindParams[0]."--".$pBindParams[1]."--".$pBindParams[2], 3, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($vSqlString);
		array_unshift($pBindParams, $pBindLetters);
		call_user_func_array(array($stmt, 'bind_param'), $pBindParams);
        $id=$in_stock=0;
        $isbn=$category=$sub_category=$title=$summary=$blob_path=$special_price=$price=$date_publish=$date_loaded=$new=$special=$top_seller=$top_seller_rank=$out_of_print=$publisher=$language=$category_string=$sub_category_string=$author=$illustrator=$translator=$edit_by=$default_discount=$dimensions=$weight=$format=$pages=$new_rank=$soon_discount=$soon_rank=$soon=$special_rank=$tv=$tv_date=$cost_price=$rr=$rr_date=$section=$e_isbn=$e_url=$e_price=$SortPrice = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $isbn, $category, $sub_category, $title, $summary, $blob_path, $special_price, $price, $date_publish, $date_loaded, $new, $special, $top_seller, $top_seller_rank, $out_of_print, $in_stock, $publisher, $language, $category_string, $sub_category_string, $author, $illustrator, $translator, $edit_by, $default_discount, $dimensions, $weight, $format, $pages, $new_rank, $soon_discount, $soon_rank, $soon, $special_rank, $tv, $tv_date, $cost_price, $rr, $rr_date, $section, $e_isbn, $e_url, $e_price, $SortPrice);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vId[] = $id;
					$vIsbn[] = $isbn;
					$vCategory[] = $category;
					$vSub_category[] = $sub_category;
					$vTitle[] = $title;
					$vSummary[] = $summary;
					$vBlob_path[] = $blob_path;
					$vSpecial_price[] = $special_price;
					$vPrice[] = $price;
					$vDate_publish[] = date('m/Y', strtotime($date_publish));
					$vDate_loaded[] = $date_loaded;
					$vNew[] = $new;
					$vSpecial[] = $special;
					$vTop_seller[] = $top_seller;
					$vTop_seller_rank[] = $top_seller_rank;
					$vOut_of_print[] = $out_of_print;
					$vIn_stock[] = $in_stock;
					$vPublisher[] = $publisher;
					$vLanguage[] = $language;
					$vCategoryString[] = $category_string;
					$vSubCategoryString[] = $sub_category_string;
					$vAuthor[] = $author;
					$vIllustrator[] = $illustrator;
					$vTranslator[] = $translator;
					$vEdit[] = $edit_by;
					$vNormalDate[] = $date_publish;
					$vDefault_discount[] = $default_discount;
					$vDimensions[] = $dimensions;
					$vWeight[] = $weight;
					$vFormat[] = $format;
					$vNoPages[] = $pages;
					$vNewRank[] = $new_rank;
					$vSoonDiscount[] = $soon_discount;
					$vSoonRank[] = $soon_rank;
					$vSoon[] = $soon;
					$vSpecialRank[] = $special_rank;
					$vTv[] = $tv;
					$vTvDate[] = $tv_date;
					$vCostPrice[] = $cost_price;
					$vRr[] = $rr;
					$vRrDate[] = $rr_date;
					$vSection[] = $section;
					$vRrDate[] = $rr_date;
					$vSection[] = $section;
					$vE_isbn[] = $e_isbn;
					$vE_url[] = $e_url;
					$vE_price[] = $e_price;
				}
			}
		}
		$stmt->close();

        if(isset($vId)){
            return array($vId, $vIsbn, $vCategory, $vSub_category, $vTitle, $vSummary, $vBlob_path, $vSpecial_price, $vPrice, $vDate_publish, $vDate_loaded, $vNew, $vSpecial, $vTop_seller, $vTop_seller_rank, $vOut_of_print, $vIn_stock, $vPublisher, $vLanguage, $vCategoryString, $vSubCategoryString, $vAuthor, $vIllustrator, $vTranslator, $vEdit, $vNormalDate, $vDefault_discount, $vDimensions, $vWeight, $vFormat, $vNoPages, $vNewRank, $vSoonDiscount, $vSoonRank, $vSoon, $vSpecialRank, $vTv, $vTvDate, $vCostPrice, $vRr, $vRrDate, $vSection, $vE_isbn, $vE_url, $vE_price);
        }
        else {
            return array();
        }
	}

	public static function getBooksNonprepared($pConn, $pIdResults, $pOrder, $pLimit){
		(strpos($pOrder, 'date_publish') == false ? $pOrder = $pOrder.", b.date_publish DESC" : $pOrder = $pOrder);
		(!isset($_SESSION['SessionGrafLanguage']) || $_SESSION['SessionGrafLanguage'] == '' || $_SESSION['SessionGrafLanguage'] == 'af' ? $vSessionLanguage = 'af' : $vSessionLanguage = 'en');
		$vValueString = implode(",", $pIdResults);
		$vSqlString = "select b.id, b.isbn, b.category, b.sub_category, b.title, b.summary, b.blob_path, b.special_price, b.price, b.date_publish, b.date_loaded, b.new, b.special, b.top_seller, b.top_seller_rank, b.out_of_print, b.in_stock, ";
		$vSqlString .= "b.publisher, b.language, c.category as category_string, sc.sub_category_".$vSessionLanguage." as sub_category_string, b.author, b.illustrator, b.translator, b.edit_by, ";
		$vSqlString .= "b.default_discount, b.dimensions, b.weight, b.format, b.pages from books b ";
		$vSqlString .= "LEFT JOIN categories AS c ON c.id = b.category ";
		$vSqlString .= "LEFT JOIN sub_categories AS sc ON sc.id = b.sub_category ";

		$vSqlString .= "WHERE b.id in(".$vValueString.") ".$pOrder. " ".$pLimit;
		//error_log("getBooksNonprepared: ".$vSqlString, 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($vSqlString);
        $id=0;
        $isbn=$category=$sub_category=$title=$summary=$blob_path=$special_price=$price=$date_publish=$date_loaded=$new=$special=$top_seller=$top_seller_rank=$out_of_print=$in_stock=$publisher=$language=$category_string=$sub_category_string=$author=$illustrator=$translator=$edit_by=$default_discount=$dimensions=$weight=$format=$pages = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $isbn, $category, $sub_category, $title, $summary, $blob_path, $special_price, $price, $date_publish, $date_loaded, $new, $special, $top_seller, $top_seller_rank, $out_of_print, $in_stock, $publisher, $language, $category_string, $sub_category_string, $author, $illustrator, $translator, $edit_by, $default_discount, $dimensions, $weight, $format, $pages);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vId[] = $id;
					$vIsbn[] = $isbn;
					$vCategory[] = $category;
					$vSub_category[] = $sub_category;
					$vTitle[] = $title;
					$vSummary[] = $summary;
					$vBlob_path[] = $blob_path;
					$vSpecial_price[] = $special_price;
					$vPrice[] = $price;
					$vDate_publish[] = date('m/Y', strtotime($date_publish));
					$vDate_loaded[] = $date_loaded;
					$vNew[] = $new;
					$vSpecial[] = $special;
					$vTop_seller[] = $top_seller;
					$vTop_seller_rank[] = $top_seller_rank;
					$vOut_of_print[] = $out_of_print;
					$vIn_stock[] = $in_stock;
					$vPublisher[] = $publisher;
					$vLanguage[] = $language;
					$vCategoryString[] = $category_string;
					$vSubCategoryString[] = $sub_category_string;
					$vAuthor[] = $author;
					$vIllustrator[] = $illustrator;
					$vTranslator[] = $translator;
					$vEdit[] = $edit_by;
					$vNormalDate[] = $date_publish;
					$vDefault_discount[] = $default_discount;
					$vDimensions[] = $dimensions;
					$vWeight[] = $weight;
					$vFormat[] = $format;
					$vNoPages[] = $pages;
				}
			}
		}
		$stmt->close();
		return array($vId, $vIsbn, $vCategory, $vSub_category, $vTitle, $vSummary, $vBlob_path, $vSpecial_price, $vPrice, $vDate_publish, $vDate_loaded, $vNew, $vSpecial, $vTop_seller, $vTop_seller_rank, $vOut_of_print, $vIn_stock, $vPublisher, $vLanguage, $vCategoryString, $vSubCategoryString, $vAuthor, $vIllustrator, $vTranslator, $vEdit, $vNormalDate, $vDefault_discount, $vDimensions, $vWeight, $vFormat, $vNoPages);
	}

	public static function getBookIds($pConn, $pWhere, $pOrder, $pBindLetters,  $pBindParams, $pLimit){
		$vSqlString = "select distinct(b.id) from books_search b ";
		$vSqlString .= $pWhere." ".$pOrder." ".$pLimit;
		//error_log("getBooks: ".$vSqlString."--".$pBindParams[0]."--".$pBindParams[1], 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($vSqlString);
		array_unshift($pBindParams, $pBindLetters);
		call_user_func_array(array($stmt, 'bind_param'), $pBindParams);
        $id = 0;
		if($stmt->execute() == true) {
			$stmt->bind_result($id);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vId[] = $id;
				}
			}
		}
		$stmt->close();
		return array($vId);
	}

	public static function getBooksFull($pConn, $pWhere, $pOrder, $pBindLetters,  $pBindParams, $pLimit){
		(!isset($_SESSION['SessionGrafLanguage']) || $_SESSION['SessionGrafLanguage'] == '' || $_SESSION['SessionGrafLanguage'] == 'af' ? $vSessionLanguage = 'af' : $vSessionLanguage = 'en');
		$vSqlString = "select b.id, b.isbn, b.category, b.sub_category, b.title, b.summary, b.blob_path, b.special_price, b.price, b.date_publish, b.date_loaded, b.new, b.special, b.top_seller, b.top_seller_rank, b.out_of_print, b.in_stock, ";
		$vSqlString .= "b.publisher, b.language, c.category as category_string, sc.sub_category_".$vSessionLanguage." as sub_category_string, b.author, b.illustrator, b.translator, b.edit_by, b.default_discount, b.dimensions, b.weight, b.format, b.pages, b.new_rank, b.soon_discount, b.soon_rank, b.soon, ";
		$vSqlString .= "b.special_rank as special_rank, b.tv, b.tv_date, b.cost_price, b.rr, b.rr_date, b.section, b.e_isbn, b.e_url, b.e_price from books b ";
		$vSqlString .= "LEFT JOIN categories AS c ON c.id = b.category ";
		$vSqlString .= "LEFT JOIN sub_categories AS sc ON sc.id = b.sub_category ";
		$vSqlString .= "LEFT JOIN books_search as bs ON bs.id = b.id ";

		$vSqlString .= $pWhere." ".$pOrder. " ".$pLimit;
		//error_log("getBooksFull: ".$vSqlString." - ".$pBindParams[0], 0, "C:/Temp/php_errors.log");
		//echo $vSqlString."//".$pBindParams[0]."//".$pBindParams[1]."//";
		$stmt = $pConn->prepare($vSqlString);
		array_unshift($pBindParams, $pBindLetters);
		call_user_func_array(array($stmt, 'bind_param'), $pBindParams);
        $id=0;
        $isbn=$category=$sub_category=$title=$summary=$blob_path=$special_price=$price=$date_publish=$date_loaded=$new=$special=$top_seller=$top_seller_rank=$out_of_print=$in_stock=$publisher=$language=$category_string=$sub_category_string=$author=$illustrator=$translator=$edit_by=$default_discount=$dimensions=$weight=$format=$pages=$new_rank=$soon_discount=$soon_rank=$soon=$special_rank=$tv=$tv_date=$cost_price=$rr=$rr_date=$section=$e_isbn=$e_url=$e_price = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $isbn, $category, $sub_category, $title, $summary, $blob_path, $special_price, $price, $date_publish, $date_loaded, $new, $special, $top_seller, $top_seller_rank, $out_of_print, $in_stock, $publisher, $language, $category_string, $sub_category_string, $author, $illustrator, $translator, $edit_by, $default_discount, $dimensions, $weight, $format, $pages, $new_rank, $soon_discount, $soon_rank, $soon, $special_rank, $tv, $tv_date, $cost_price, $rr, $rr_date, $section, $e_isbn, $e_url, $e_price);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vId[] = $id;
					$vIsbn[] = $isbn;
					$vCategory[] = $category;
					$vSub_category[] = $sub_category;
					$vTitle[] = $title;
					$vSummary[] = $summary;
					$vBlob_path[] = $blob_path;
					$vSpecial_price[] = $special_price;
					$vPrice[] = $price;
					$vDate_publish[] = date('m/Y', strtotime($date_publish));
					$vDate_loaded[] = $date_loaded;
					$vNew[] = $new;
					$vSpecial[] = $special;
					$vTop_seller[] = $top_seller;
					$vTop_seller_rank[] = $top_seller_rank;
					$vOut_of_print[] = $out_of_print;
					$vIn_stock[] = $in_stock;
					$vPublisher[] = $publisher;
					$vLanguage[] = $language;
					$vCategoryString[] = $category_string;
					$vSubCategoryString[] = $sub_category_string;
					$vAuthor[] = $author;
					$vIllustrator[] = $illustrator;
					$vTranslator[] = $translator;
					$vEdit[] = $edit_by;
					$vNormalDate[] = $date_publish;
					$vDefault_discount[] = $default_discount;
					$vDimensions[] = $dimensions;
					$vWeight[] = $weight;
					$vFormat[] = $format;
					$vNoPages[] = $pages;
					$vNewRank[] = $new_rank;
					$vSoonDiscount[] = $soon_discount;
					$vSoonRank[] = $soon_rank;
					$vSoon[] = $soon;
					$vSpecialRank[] = $special_rank;
					$vTv[] = $tv;
					$vTvDate[] = $tv_date;
					$vCostPrice[] = $cost_price;
					$vRr[] = $rr;
					$vRrDate[] = $rr_date;
					$vSection[] = $section;
					$vE_isbn[] = $e_isbn;
					$vE_url[] = $e_url;
					$vE_price[] = $e_price;
				}
			}
		}
		$stmt->close();
		return array($vId, $vIsbn, $vCategory, $vSub_category, $vTitle, $vSummary, $vBlob_path, $vSpecial_price, $vPrice, $vDate_publish, $vDate_loaded, $vNew, $vSpecial, $vTop_seller, $vTop_seller_rank, $vOut_of_print, $vIn_stock, $vPublisher, $vLanguage, $vCategoryString, $vSubCategoryString, $vAuthor, $vIllustrator, $vTranslator, $vEdit, $vNormalDate, $vDefault_discount, $vDimensions, $vWeight, $vFormat, $vNoPages, $vNewRank, $vSoonDiscount, $vSoonRank, $vSoon, $vSpecialRank, $vTv, $vTvDate, $vCostPrice, $vRr, $vRrDate, $vSection, $vE_isbn, $vE_url, $vE_price);
	}

	public static function getBookMin($pConn, $pWhere, $pTitle, $pIsbn){
		$vSqlString = "select id,title from books WHERE ".$pWhere." order by title asc";
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("ss", $pTitle, $pIsbn);
        $id=0;
        $title= '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $title);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$row['id'] = $id;
					$row['value'] = $title;
					$row_set[] = $row;
				}
			}
		}
		$stmt->close();
		return $row_set;
	}

	public static function getTvBooks($pConn){
		$vValue = 1;
		$vSqlString = "select title from books WHERE tv = ? order by tv_date desc LIMIT 10";
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("i", $vValue);
        $title = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($title);
			while ($stmt->fetch()) {
				if(!empty($title)) {
					$vTitle[] = $title;
				}
			}
		}
		$stmt->close();
		return array($vTitle);
	}

	public static function getTvVideos($pConn, $pDates){
		$vSqlString = "select id, date, url, book_id from videos WHERE date in ('".$pDates."')";
		//error_log("getTvVideos: ".$vSqlString, 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($vSqlString);
        $id=0;
        $date=$url=$book_id = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $date, $url, $book_id);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vId[] = $id;
					$vDate[] = $date;
					$vUrl[] = $url;
					$vBookId[] = $book_id;
				}
			}
		}
		$stmt->close();
		return array($vId, $vDate, $vUrl, $vBookId);
	}

	public static function getRrImages($pConn, $pDates){
		$vSqlString = "select id, date, blob_path, book_id from rooirose WHERE date in ('".$pDates."')";
		//error_log("getTvVideos: ".$vSqlString, 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($vSqlString);
        $id=0;
        $date=$blob_path=$book_id = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $date, $blob_path, $book_id);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vId[] = $id;
					$vDate[] = $date;
					$vBlobPath[] = $blob_path;
					$vBookId[] = $book_id;
				}
			}
		}
		$stmt->close();
		return array($vId, $vDate, $vBlobPath, $vBookId);
	}

	public static function getBookSearchComplete($pConn, $pWhere, $pValue){
		$vSqlString = "SELECT t1.id, t1.value from (SELECT bs.id AS id, bs.title AS value FROM books_search bs WHERE lower(bs.title) LIKE lower('".$pValue."')
	    UNION SELECT bs1.id AS id, bs1.author AS value FROM books_search bs1 WHERE lower(bs1.author) LIKE lower('".$pValue."')
	    UNION SELECT bs2.id AS id, bs2.translator AS value FROM books_search bs2 WHERE lower(bs2.translator) LIKE lower('".$pValue."')
	    UNION SELECT bs3.id AS id, bs3.illustrator AS value FROM books_search bs3 WHERE lower(bs3.illustrator) LIKE lower('".$pValue."')
	    UNION SELECT bs4.id AS id, bs4.isbn AS value FROM books_search bs4 WHERE lower(bs4.isbn) LIKE lower('".$pValue."')) AS t1 GROUP BY t1.value ORDER BY t1.value ASC";

		//error_log("getBookSearchComplete: ".$vSqlString."--".$pValue);
		$stmt = $pConn->prepare($vSqlString);
		//$stmt->bind_param("s", $pValue);
        $id=0;
        $value = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $value);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$row['id'] = $id;
					$row['value'] = str_replace("  ", " ", str_replace(",", ", ", $value));
					$row_set[] = $row;
				}
			}
		}
		$stmt->close();
		return $row_set;
	}

	public static function getBooksSitemap($pConn){
		$vOut = 0;
		$vSqlString = "select id, title, author from books WHERE id > ?";
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("i", $vOut);
        $id=0;
        $title=$author = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $title, $author);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vId[] = $id;
					$vTitle[] = $title;
					$vAuthor[] = $author;
				}
			}
		}
		$stmt->close();
		return array($vId, $vTitle, $vAuthor);
	}

	public static function getBooksMetaInfo($pConn, $pId, $pParam){
		(!isset($_SESSION['SessionGrafLanguage']) || $_SESSION['SessionGrafLanguage'] == '' || $_SESSION['SessionGrafLanguage'] == 'af' ? $vSessionLanguage = 'af' : $vSessionLanguage = 'en');
		if(empty($pParam)){
			$vSqlString = "select b.id, b.title, b.author, b.summary, c.category, sc.sub_category_".$vSessionLanguage." AS sub_category, b.blob_path from books b ";
			$vSqlString .= "LEFT JOIN categories AS c ON c.id = b.category ";
			$vSqlString .= "LEFT JOIN sub_categories AS sc ON sc.id = b.sub_category ";
			$vSqlString .= "WHERE b.id = ?";
			$vValue = $pId;
			$vType = "i";
		}
		else if(!empty($pParam)){
			$vSqlString = "select b.id, b.title, b.author, b.summary, c.category, sc.sub_category_".$vSessionLanguage." AS sub_category, b.blob_path from books b ";
			$vSqlString .= "LEFT JOIN categories AS c ON c.id = b.category ";
			$vSqlString .= "LEFT JOIN sub_categories AS sc ON sc.id = b.sub_category ";
			$vSqlString .= "WHERE b.author LIKE ? ORDER BY date_publish DESC LIMIT 1";
			$vValue = "%{$pParam}%";
			$vType = "s";
		}
		//error_log("getBooks: ".$vSqlString."--".$pBindParams[0]."--".$pBindParams[1], 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param($vType, $vValue);
        $id=0;
        $title=$author=$summary=$category=$sub_category=$blob_path = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $title, $author, $summary, $category, $sub_category, $blob_path);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vId= $id;
					$vTitle = $title;
					$vAuthor = $author;
					$vSummary = $summary;
					$vCategory = $category;
					$vSubCategory = $sub_category;
					$vBlobPath = $blob_path;
				}
			}
		}
		$stmt->close();
		return array($vId, $vTitle, $vAuthor, $vSummary, $vCategory, $vSubCategory, $vBlobPath);
	}

	public static function getBooksNoIndex($pConn){
		$vValue = 0;
		$vSqlString = "select id, title, summary, author, illustrator, translator, language, isbn from books where search_idx = ? ";
		//error_log("getBooksNoIndex: ".$vSqlString."--".$vValue, 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("i", $vValue);
        $id=0;
        $title=$summary=$author=$illustrator=$translator=$language=$isbn = '';
		if($stmt->execute() == true) {
				$stmt->bind_result($id, $title, $summary, $author, $illustrator, $translator, $language, $isbn);
				while ($stmt->fetch()) {
					if($id && $id > 0) {
						$vId[] = $id;
						$vTitle[] = $title;
						$vSummary[] = $summary;
						$vAuthor[] = $author;
						$vIllustrator[] = $illustrator;
						$vTranslator[] = $translator;
						$vLanguage[] = $language;
						$vIsbn[] = $isbn;
					}
				}
			}
			$stmt->close();
			return array($vId, $vTitle, $vSummary, $vAuthor, $vIllustrator, $vTranslator, $vLanguage, $vIsbn);
	}

	public static function getBookAIT($pConn, $pId, $pType){
		$vSqlString = "select id, book_id, name, type from book_ait where book_id = ? and type = ?";
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("ii", $pId, $pType);
        $id=0;
        $book_id=$name=$type = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $book_id, $name, $type);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vId[] = $id;
					$vBookId[] = $book_id;
					$vName[] = $name;
					$vType[]  = $type;
				}
			}
		}
		$stmt->close();
		return array($vId, $vBookId, $vName, $vType);
	}

	public static function getAuthors($pConn, $pWhere, $pAuthor){
		$vSqlString = "select distinct(author) as author from books ".$pWhere." ORDER by author ASC";
		//error_log("getAuthors: ".$vSqlString."--".$pAuthor, 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("s", $pAuthor);
        $author ='';
		if($stmt->execute() == true) {
			$stmt->bind_result($author);
			while ($stmt->fetch()) {
				if(!empty($author)) {
					$row['id'] = $author;
					$row['value'] = $author;
					$row_set[] = $row;
				}
			}
		}
		$stmt->close();
		return $row_set;
	}

	public static function doLogin($pConn, $pUsername, $pPassword, $pRemember, $pLanguage){
		$pUpperUsername = strtoupper($pUsername);
		$vValidate = 1;
		if(isset($_SESSION['SessionGrafLoginNo'])) {
			$_SESSION['SessionGrafLoginNo'] = $_SESSION['SessionGrafLoginNo'] + 1;
			setcookie("cookie_graf_la", $_SESSION['SessionGrafLoginNo'], time() + +86400, "/", $_SESSION['SessionGrafServerUrl'], false, true);//1day
		}
		else {
			$_SESSION['SessionGrafLoginNo'] = 1;
            setcookie("cookie_graf_la", '1', time() + +86400, "/", $_SESSION['SessionGrafServerUrl'], false, true);//1 day
		}

		$vSqlString = "select id, firstname, surname, email, password, validated, salt,special_discount, phone from clients where upper(email) = ? and validated = ?";

		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("si", $pUpperUsername, $vValidate);
        $id=0;
        $firstname=$surname=$email=$password=$validated=$salt=$special_discount=$phone = "";
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $firstname, $surname, $email, $password, $validated, $salt, $special_discount, $phone);
			$stmt->fetch();
			if($id && $id > 0) {
				$hash = hash('sha256', $salt . hash('sha256', $pPassword));
				if($hash == $password) {
					unset($_SESSION['SessionGrafUserId']);
					unset($_SESSION['SessionGrafUserFirstname']);
					unset($_SESSION['SessionGrafUserSurname']);
					unset($_SESSION['SessionGrafUserEmail']);
					unset($_SESSION['SessionGrafLoginNo']);
					unset($_SESSION['SessionGrafSpecialDiscount']);
					unset($_SESSION['SessionGrafUserPhone']);

					$_SESSION['SessionGrafUserId'] = $id;
					$_SESSION['SessionGrafUserFirstname'] = $firstname;
					$_SESSION['SessionGrafUserSurname'] = $surname;
					$_SESSION['SessionGrafUserEmail'] = $email;
					$_SESSION['SessionGrafSpecialDiscount'] = $special_discount;
					$_SESSION['SessionGrafUserPhone'] = $phone;
					setcookie("cookie_graf_ui", $id, 0, '/', "", false, true);

					if($pRemember == 1) {
						setcookie ("cookie_graf_remun",$pUsername,time()+ (86400*365), '/', "", false, true);
						setcookie ("cookie_graf_remme", 1 ,time()+ (86400*365), '/', "", false, true);
					}
					else {
                        $past = time() - 100;
						setcookie ("cookie_graf_remun","", $past);
						setcookie ("cookie_graf_remme","", $past);
					}
					if(!empty($pLanguage)) {
						setcookie ("cookie_graf_language",$pLanguage,time()+ (86400*365), '/', "", false, false);
						unset($_SESSION['SessionGrafLanguage']);
						$_SESSION['SessionGrafLanguage'] = $pLanguage;
					}
					else {
						$past = time() - 100;
						setcookie ("cookie_graf_language", "", $past);
					}

					$stmt->close();

					$vResult = 1;
					//$vResult = $vSqlString."-".$pUsername."--".$vValidate;
				}
				else {
					$vResult = 0;
					//$vResult = $vSqlString."-".$pUsername."--".$vValidate;
				}
			}
		}
		return $vResult;
	}

	public static function getUsers($pConn){
		$vSqlString = "select id, name, surname, email, sections, rights, password, salt from users ORDER BY name ASC";
		$stmt = $pConn->prepare($vSqlString);
        $id=0;
        $name=$surname=$email=$sections=$rights=$password=$salt = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $name, $surname, $email, $sections, $rights, $password, $salt);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vId[] = $id;
					$vName[] = $name;
					$vSurname[] = $surname;
					$vEmail[] = $email;
					$vSections[] = explode(",", $sections);
					$vRights[] = $rights;
				}
			}
		}
		$stmt->close();
		return array($vId, $vName, $vSurname, $vEmail, $vSections, $vRights);
	}

	public static function getUserName($pConn, $pId){
		$vSqlString = "select name, surname from users where id = ?";
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("i", $pId);
        $name=$surname = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($name, $surname);
			while ($stmt->fetch()) {
				if(!empty($name)) {
					$vUserName = $name." ".$surname;
				}
			}
		}
		$stmt->close();
		return $vUserName;
	}

	public static function doRegister($pConn, $pName, $pSurname, $pPassword, $pEmail){
		$hash = hash('sha256', $pPassword);
		$salt = General::createSalt(15);
		$hash = hash('sha256', $salt . $hash);

		$vData['password'] = $hash;
		$vData['salt'] = $salt;
		$vData['name'] = $pName;
		$vData['surname'] = $pSurname;
		$vData['email'] = $pEmail;

		$vQueryResult = MysqlQuery::doInsert($pConn, "users", $vData);
		if($vQueryResult == 1){
			$vUrl = "index.php?page=register-return&type=success";
		}
		else if($vQueryResult == 0){
			$vUrl = "index.php?page=register-return&type=unsuccess";
		}
		General::echoRedirect($vUrl, "");
	}

	public static function getClients($pConn, $pWhere, $pOrder, $pBindLetters,  $pBindParams, $pLimit){
		$vSqlString = "select c.id, c.firstname, c.surname, c.email, c.validated, c.phone, c.postal_address1, c.postal_address2, c.postal_city, c.postal_province, c.postal_country, c.postal_code, c.physical_address1, c.physical_address2, c.physical_city, c.physical_province, c.physical_country, c.physical_code, c.newsletter, c.language, c.special_discount, c.physical_country_id, lc.".$_SESSION['SessionGrafLanguage']." AS country_string 
            from clients c 
            LEFT JOIN lk_country lc ON c.physical_country = lc.id ".$pWhere." ".$pOrder." ".$pLimit;
//		error_log($vSqlString."//".$pBindParams[0]."//".$pBindParams[1]."//".$pBindParams[2], 3, 'C:/a_Server/wamp64/logs/php_error.log');
		$stmt = $pConn->prepare($vSqlString);
		array_unshift($pBindParams, $pBindLetters);
		call_user_func_array(array($stmt, 'bind_param'), $pBindParams);
        $id=0;
        $firstname=$surname=$email=$validated=$phone=$postal_address1=$postal_address2=$postal_city=$postal_province=$postal_country=$postal_code=$physical_address1=$physical_address2=$physical_city=$physical_province=$physical_country=$physical_code=$newsletter=$language=$special_discount=$physical_country_id=$country_string = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $firstname, $surname, $email, $validated, $phone, $postal_address1, $postal_address2, $postal_city, $postal_province, $postal_country, $postal_code, $physical_address1, $physical_address2, $physical_city, $physical_province, $physical_country, $physical_code, $newsletter, $language, $special_discount, $physical_country_id, $country_string);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vId[] = $id;
					$vFirstname[] = $firstname;
					$vSurname[] = $surname;
					$vEmail[] = $email;
					$vValidated[] = $validated;
					$vPhone[] = $phone;
					$vPostal_address1[] = $postal_address1;
					$vPostal_address2[] = $postal_address2;
					$vPostal_city[] = $postal_city;
					$vPostal_province[] = $postal_province;
					$vPostal_code[] = $postal_code;
					$vPostal_country[] = $postal_country;
					$vPhysical_address1[] = $physical_address1;
					$vPhysical_address2[] = $physical_address2;
					$vPhysical_city[] = $physical_city;
					$vPhysical_province[] = $physical_province;
					$vPhysical_country[] = $physical_country;
					$vPhysical_code[] = $physical_code;
					$vNewsletter[] = $newsletter;
					$vLanguage[] = $language;
					$vSpecial_discount[] = $special_discount;
                    $vPhysical_country_id[] = $physical_country_id;
                    $vCountryString[] = $country_string;
				}
			}
		}
		$stmt->close();
		return array($vId, $vFirstname, $vSurname, $vEmail, $vValidated, $vPhone, $vPostal_address1, $vPostal_address2, $vPostal_city, $vPostal_province, $vPostal_code, $vPostal_country, $vPhysical_address1, $vPhysical_address2, $vPhysical_city, $vPhysical_province, $vPhysical_country, $vPhysical_code, $vNewsletter, $vLanguage, $vSpecial_discount,$vPhysical_country_id,$vCountryString);
	}

	public static function getOrderClient($pConn, $pId){
		$vSqlString = "select id, firstname, surname, email, phone, language from clients WHERE id = ?";
		//error_log("SQL: ".$vSqlString." ".$pId, 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("i", $pId);
        $id=0;
        $firstname=$surname=$email=$phone=$language ='';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $firstname, $surname, $email, $phone, $language);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vId = $id;
					$vFirstname = $firstname;
					$vSurname = $surname;
					$vEmail = $email;
					$vPhone = $phone;
					$vLanguage = $language;
				}
			}
		}
		$stmt->close();
		return array($vId, $vFirstname, $vSurname, $vEmail, $vPhone, $vLanguage);
	}

    public static function getOrderClientTemp($pConn, $pOrderId)
    {
        $vSqlString = 'select client_id, receiver_name, receiver_email, receiver_phone from orders WHERE id = ?';
        //error_log("SQL: ".$vSqlString." ".$pId, 0, "C:/Temp/php_errors.log");
        $stmt = $pConn->prepare($vSqlString);
        $stmt->bind_param('i', $pOrderId);
        $client_id=$receiver_name=$receiver_email=$receiver_phone = '';
        if ($stmt->execute() == true) {
            $stmt->bind_result($client_id, $receiver_name, $receiver_email, $receiver_phone);
            while ($stmt->fetch()) {
                if ($client_id && !empty($client_id)) {
                    $vId = $client_id;
                    $vFirstname = $receiver_name;
                    $vSurname = '';
                    $vEmail = $receiver_email;
                    $vPhone = $receiver_phone;
                    $vLanguage = 'en';
                }
            }
        }
        $stmt->close();
        return array($vId, $vFirstname, $vSurname, $vEmail, $vPhone, $vLanguage);
    }

	public static function getClientsMin($pConn, $pWhere, $vFirstname, $vSurname){
		$vSqlString = "select id, firstname, surname from clients WHERE ".$pWhere." order by surname asc";
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("ss", $vFirstname, $vSurname);
        $id=0;
        $firstname=$surname = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $firstname, $surname);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$row['id'] = $id;
					$row['value'] = $surname.", ".$firstname;
					$row_set[] = $row;
				}
			}
		}
		$stmt->close();
		return $row_set;
	}

	public static function getOrdersMin($pConn, $pWhere, $vRef){
		$vSqlString = "select id, CONCAT_WS('/', id, temp_salt) as reference from orders WHERE ".$pWhere." order by id asc";
		//error_log("SQL: ".$vSqlString." ".$vRef, 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("s", $vRef);
        $id=0;
        $reference = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $reference);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$row['id'] = $id;
					$row['value'] = $reference;
					$row_set[] = $row;
				}
			}
		}
		$stmt->close();
		return $row_set;
	}

    public static function getOrdersInfo($pConn, $vOrderId)
    {
        $vSqlString = "select client_id, temp_salt, total_price  from orders WHERE id = ?";
        //error_log("SQL: ".$vSqlString." ".$vRef, 0, "C:/Temp/php_errors.log");
        $stmt = $pConn->prepare($vSqlString);
        $stmt->bind_param('i', $vOrderId);
        $temp_salt=$client_id = '';
        $total_price = 0;
        if ($stmt->execute() == true) {
            $stmt->bind_result($client_id, $temp_salt, $total_price);
            while ($stmt->fetch()) {
                if (!empty($client_id)) {
                    $vClientId = $client_id;
                    $vTempSalt = $temp_salt;
                    $vTotalPrice = $total_price;
                }
            }
        }
        $stmt->close();
        if(!empty($client_id)){
            return array($vClientId, $vTempSalt, $vTotalPrice);
        }
        else {
            return array();
        }
    }

	public static function getOrdersIsbnMin($pConn, $pWhere, $pIsbn){
		$vSqlString = "select od.order_id as order_id, b.isbn as isbn from orders_detail od ";
		$vSqlString .= "LEFT JOIN books AS b ON b.id = od.book_id ";
		$vSqlString .= "WHERE ".$pWhere." GROUP BY b.isbn order by isbn asc";
		//error_log("SQL: ".$vSqlString." ".$pIsbn, 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("s", $pIsbn);
        $order_id=0;
        $isbn = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($order_id, $isbn);
			while ($stmt->fetch()) {
				if($order_id && $order_id > 0) {
					$row['id'] = $isbn;
					$row['value'] = $isbn;
					$row_set[] = $row;
				}
			}
		}
		$stmt->close();
		return $row_set;
	}

	public static function getCart($pConn, $pWhere, $pOrder, $pBindLetters,  $pBindParams, $pLimit){
//        include_once "BookPrice.php";
//        $vBookPrice = new BookPrice();

		//$vAutoDiscount = MysqlQuery::getAutoDiscount($pConn);
		$vSqlString = "select w.id, w.book_id, w.client_id, w.number, w.add_date, w.temp_salt, w.order_date, w.order_reference, w.order_id, b.title, b.price, b.new, b.top_seller, b.special, b.special_price, b.blob_path, ";
		$vSqlString .= "b.in_stock, b.default_discount, b.date_publish, b.soon_discount, b.language, b.category, b.sub_category, w.address1, w.address2, w.city, w.province, w.country, w.code, w.receiver_name, ";
		$vSqlString .= "w.receiver_phone, w.courier_type, w.courier_detail, w.courier_cost, w.price as order_price, w.total_price, w.message, w.delivery_address_type,w.receiver_email from cart w ";
		$vSqlString .= "LEFT JOIN books AS b ON b.id = w.book_id ";
		$vSqlString .= $pWhere." ".$pOrder." ".$pLimit;
		//error_log("getCart: ".$vSqlString."--".$pBindParams[0], 3, "error.log");
		$stmt = $pConn->prepare($vSqlString);
		array_unshift($pBindParams, $pBindLetters);
		call_user_func_array(array($stmt, 'bind_param'), $pBindParams);
        $id=0;
        $book_id=$client_id=$number=$add_date=$temp_salt=$order_date=$order_reference=$order_id=$title=$vFinalPrice=$price=$new=$top_seller=$special=$special_price=$blob_path=$in_stock=$default_discount=$date_publish=$soon_discount=$language=$category=$sub_category=$address1=$address2=$city=$province=$country=$code=$receiver_name=$receiver_phone=$courier_type=$courier_detail=$courier_cost=$order_price=$total_price=$message=$delivery_address_type=$receiver_email = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $book_id, $client_id, $number, $add_date, $temp_salt, $order_date, $order_reference, $order_id, $title, $price, $new, $top_seller, $special, $special_price, $blob_path, $in_stock, $default_discount, $date_publish, $soon_discount, $language, $category, $sub_category, $address1, $address2, $city, $province, $country, $code, $receiver_name, $receiver_phone, $courier_type, $courier_detail, $courier_cost, $order_price, $total_price, $message, $delivery_address_type, $receiver_email);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vId[] = $id;
					$vBookId[] = $book_id;
					$vClientId[] = $client_id;
					$vNumber[] = $number;
					$vAddDate[] = $add_date;
					$vTempSalt[] = $temp_salt;
					$vOrderDate[] = $order_date;
					$vOrderReference[] = $order_reference;
					$vOrderId[] = $order_id;
					$vTitle[] = $title;
					$vBlobPath[] = $blob_path;
					$vInStock[] = $in_stock;
					$vDatePublish[] = $date_publish;
					$vSoonDiscount[] = $soon_discount;

//                    //Price start
//					$vNewTopDiscountPrice =  round($price-($price*$default_discount));
//					$vSpecialDiscountPrice = (!empty($special) && $special > 0  ? $special_price : $price);
//					$vClientDiscountPrice = round($price-($price*$_SESSION['SessionGrafSpecialDiscount']));
//					$vSoonDiscountPrice = round($price-($price*$default_discount));
//					$vNormalPrice = $price;
//					$vPriceDisplayType = "query";
//                    //$vPriceDisplayType, $new, $top_seller, $vNewTopDiscountPrice, $vSpecialDiscountPrice, $vClientDiscountPrice, $special, $price, $soon_discount, $vSoonDiscountPrice, $vNormalPrice, $language
//
////                    include "include/BookPriceDisplay.php";


					$vAddress1[] = $address1;
					$vAddress2[] = $address2;
					$vCity[] = $city;
					$vProvince[] = $province;
					$vCountry[] = $country;
					$vCode[] = $code;
					$vReceiverName[] = $receiver_name;
					$vReceiverPhone[] = $receiver_phone;
					$vCourierType[] = $courier_type;
					$vCourierDetail[] = $courier_detail;
					$vCourierCost[] = $courier_cost;
					$vOrderPrice[] = $order_price;
					$vTotalPrice[] = $total_price;
					$vMessage[] = $message;
					$vDeliveryAddressType[] = $delivery_address_type;

                    $vPrice[] = $price;
                    $vDefaultDiscount[] = $default_discount;
                    $vSpecial[] = $special;
                    $vSpecialPrice[] = $special_price;
                    $vNew[] = $new;
                    $vTopSeller[] = $top_seller;
                    $vLanguage[] = $language;
                    $vReceiver_email[] = $receiver_email;
				}
			}
		}
		$stmt->close();
		if(isset($vId)){
            return array($vId, $vBookId, $vClientId, $vNumber, $vAddDate, $vTempSalt, $vOrderDate, $vOrderReference, $vOrderId, $vTitle, $vFinalPrice, $vBlobPath, $vInStock, $vDatePublish, $vAddress1, $vAddress2, $vCity, $vProvince, $vCountry, $vCode, $vReceiverName, $vReceiverPhone, $vCourierType, $vCourierDetail, $vCourierCost, $vOrderPrice, $vTotalPrice, $vMessage, $vDeliveryAddressType, $vPrice, $vDefaultDiscount, $vSpecial, $vSpecialPrice, $vNew, $vTopSeller, $vSoonDiscount, $vLanguage, $vReceiver_email);
        }
        else {
            return array();
        }
	}

	public static function cleanCart($pConn){
		$vDate = date("Y-m-d", strtotime('-20 days'));
		$sqlString = "delete from cart WHERE add_date < '".$vDate."'";
		//error_log("cleanCart: ".$sqlString, 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($sqlString);
		$stmt->execute();
		$stmt->close();
	}

	public static function getWishlist($pConn, $pWhere, $pOrder, $pBindLetters,  $pBindParams, $pLimit){
		//$vAutoDiscount = MysqlQuery::getAutoDiscount($pConn);
		$vSqlString = "select w.id, w.book_id, b.title, b.price, b.new, b.top_seller, b.special, b.special_price, b.blob_path, b.in_stock, b.default_discount from wishlist w ";
		$vSqlString .= "LEFT JOIN books AS b ON b.id = w.book_id ";
		$vSqlString .= $pWhere." ".$pOrder." ".$pLimit;
		error_log("getCart: ".$vSqlString."--".$pBindParams[0], 3, 'C:/a_Server/wamp64/logs/php_error.log');
		$stmt = $pConn->prepare($vSqlString);
		array_unshift($pBindParams, $pBindLetters);
		call_user_func_array(array($stmt, 'bind_param'), $pBindParams);
        $id=0;
        $book_id=$title=$price=$new=$top_seller=$special=$special_price=$blob_path=$in_stock=$default_discount = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $book_id, $title, $price, $new, $top_seller, $special, $special_price, $blob_path, $in_stock, $default_discount);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vId[] = $id;
					$vBookId[] = $book_id;
					$vTitle[] = $title;
					($new == 1 || $top_seller == 1 ? $vPrice[] =  round($price-($price*$default_discount)) : (($special == 1 && $price > $special && $special > 0 ? $vPrice[] = $special_price : $vPrice[] = $price)));
					$vBlobPath[] = $blob_path;
					$vInStock[] = $in_stock;
				}
			}
		}
		$stmt->close();

        if(isset($vId)){
            return array($vId, $vBookId, $vTitle, $vPrice, $vBlobPath, $vInStock);
        }
        else {
            return array();
        }
	}

	public static function updateCart($pConn, $pWhere, $pBindLetters, $pBindParams, $pNumber){
		$vSqlString = "update cart set number = ".$pNumber." ".$pWhere;
		//error_log($vSqlString, 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($vSqlString);
		array_unshift($pBindParams, $pBindLetters);
		call_user_func_array(array($stmt, 'bind_param'), $pBindParams);
		if($stmt->execute() == true) {
			$vResult = 1;
		}
		else {
			$vResult = 0;
		}
		$stmt->close();
		return $vResult;
	}

	public static function getCartSum($pConn, $pWhere, $pBindLetters, $pBindParams){
		$sqlString = "SELECT sum(number) as total FROM cart ".$pWhere;
		$stmt = $pConn->prepare($sqlString);
		array_unshift($pBindParams, $pBindLetters);
		call_user_func_array(array($stmt, 'bind_param'), $pBindParams);
        $number = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($number);
			$stmt->fetch();
			$vCount = $number;
		}
		$stmt->close();
		return $vCount;
	}

    public static function updateCartClient($pConn, $pWhere, $pBindLetters, $pBindParams)
    {
        $vSqlString = 'update cart set client_id = ? '.$pWhere;
        //error_log($vSqlString, 0);
        $stmt = $pConn->prepare($vSqlString);
        array_unshift($pBindParams, $pBindLetters);
        call_user_func_array(array($stmt, 'bind_param'), $pBindParams);
        if ($stmt->execute() == true) {
            $vResult = 1;
        } else {
            $vResult = 0;
        }
        $stmt->close();
        return $vResult;
    }

	public static function getCountryCourierCost($pConn, $pNum){
		$vValue = 8;
		($pNum > 7 ? $vNumberBooks = 7 : $vNumberBooks = $pNum);
		$vSqlString = "select id, ".$_SESSION['SessionGrafLanguage']." as country, rate_".$vNumberBooks." as cost from courier_cost where id > ? ORDER BY 2";
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("i", $vValue);
        $id=0;
        $country=$cost = '';
		//error_log("getCart: ".$vSqlString."--".$vValue, 0, "C:/Temp/php_errors.log");
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $country, $cost);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vId[] = $id;
					$vCountry[] = $country;
					$vCost[] = $cost;
				}
			}
		}
		$stmt->close();
		return array($vId, $vCountry, $vCost);
	}

	public static function getCourierCountry($pConn, $pId){
		$vSqlString = "select id, ".$_SESSION['SessionGrafLanguage']." as country from courier_cost where id = ?";
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("i", $pId);
        $id=0;
        $country = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $country);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vId = $id;
					$vCountry = $country;
				}
			}
		}
		$stmt->close();
		return array($vId, $vCountry);
	}

    public static function getCountry($pConn, $pId)
    {
        $vSqlString = 'select id, ' . $_SESSION['SessionGrafLanguage'] . ' as country from lk_country where id = ?';
        $stmt = $pConn->prepare($vSqlString);
        $stmt->bind_param('i', $pId);
        $id = 0;
        $country = '';
        if ($stmt->execute() == true) {
            $stmt->bind_result($id, $country);
            while ($stmt->fetch()) {
                if ($id && $id > 0) {
                    $vId = $id;
                    $vCountry = $country;
                }
            }
        }
        $stmt->close();
        return array($vId, $vCountry);
    }

	public static function getCourierSelection($pConn, $pId){
		$vSqlString = "select id, ".$_SESSION['SessionGrafLanguage']." as courier_type from courier_cost where id < ? and id in(3,7,4,5,204) order by 2 DESC";
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("i", $pId);
        $id=0;
        $courier_type = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $courier_type);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vId[] = $id;
					$vCourier_type[] = $courier_type;
				}
			}
		}
		$stmt->close();
		return array($vId, $vCourier_type);
	}

	public static function getCmsCourierSelection($pConn, $pId){
		$vSqlString = "select id, af as courier_type from courier_cost where id < ? order by 2 DESC";
		//error_log("SQL: ".$vSqlString."--".$pId, 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("i", $pId);
        $id=0;
        $courier_type = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $courier_type);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vId[] = $id;
					$vCourier_type[] = $courier_type;
				}
			}
		}
		$stmt->close();
		return array($vId, $vCourier_type);
	}

	public static function getCmsCourierCountry($pConn, $pId){
		$vSqlString = "select id, af as country from courier_cost where id = ?";
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("i", $pId);
        $id=0;
        $country = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $country);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vId = $id;
					$vCountry = $country;
				}
			}
		}
		$stmt->close();
		return array($vId, $vCountry);
	}

	public static function getCourierCostPerId($pConn, $pNum, $pId){
		($pNum > 7 ? $vNumberBooks = 7 : $vNumberBooks = $pNum);
		$vSqlString = "select id, rate_".$vNumberBooks." as cost from courier_cost where id = ?";
		//error_log("SQL: ".$vSqlString."--".$pId, 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("i", $pId);
        $id=0;
        $cost = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $cost);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vId = $id;
					$vCost = $cost;
				}
			}
		}
		$stmt->close();
		return array($vId, $vCost);
	}

	public static function getCourierTextPerId($pConn, $pId){
		(!isset($_SESSION['SessionGrafLanguage'])  ? $vLang = 'af' : $vLang = $_SESSION['SessionGrafLanguage']);
		$vSqlString = "select id, ".$vLang." as courier from courier_cost where id = ?";
		//error_log("SQL: ".$vSqlString."--".$pId, 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("i", $pId);
        $id=$courier = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $courier);
			$stmt->fetch();
				if(!empty($courier)) {
					$vText = $courier;
				}
		}
		$stmt->close();
		return $vText;
	}

	public static function getCourierTextPerIdBilingual($pConn, $pId, $vTrimYN){
		$vSqlString = "select id, af, en from courier_cost where id = ?";
		//error_log("SQL: ".$vSqlString."--".$pId, 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("i", $pId);
        $id=0;
        $af=$en = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $af, $en);
			$stmt->fetch();
				if($id && $id > 0) {
					$vAf = $af;
					$vEn = $en;
				}
		}
		$stmt->close();
		if($vTrimYN == 1 && (str_contains ($vAf, '|') || str_contains ($vEn, '|'))){
			$vText =  substr($vAf, 0, strpos($vAf, "|"))."/".substr($vEn, 0, strpos($vEn, "|"));
		}
		else {
			$vText = $vAf."/".$vEn;
		}
		return $vText;
	}

	public static function getCmsAllCourierCosts($pConn){
		$vSqlString = "select id, af, en, rate_1, rate_2, rate_3, rate_4, rate_5, rate_6, rate_7 from courier_cost ORDER BY af";
		$stmt = $pConn->prepare($vSqlString);
        $id=$af=$en=$rate_1=$rate_2=$rate_3=$rate_4=$rate_5=$rate_6=$rate_7 = 0;
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $af, $en, $rate_1, $rate_2, $rate_3, $rate_4, $rate_5, $rate_6, $rate_7);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vId[] = $id;
					$vAf[] = $af;
					$vEn[] = $en;
					$vRate1[] = $rate_1;
					$vRate2[] = $rate_2;
					$vRate3[] = $rate_3;
					$vRate4[] = $rate_4;
					$vRate5[] = $rate_5;
					$vRate6[] = $rate_6;
					$vRate7[] = $rate_7;
				}
			}
		}
		$stmt->close();
		return array($vId, $vAf, $vEn, $vRate1, $vRate2, $vRate3, $vRate4, $vRate5, $vRate6, $vRate7);
	}

	public static function getOrder($pConn, $pWhere, $pOrder, $pBindLetters,  $pBindParams, $pLimit){
		$vSqlString = "select id, client_id, order_date, temp_salt, address1, address2, city, province, country, code, courier_type, courier_cost, price, total_price, payment_type, submitted, message, paid, processed, posted, tracking_no, completed, note, 
            courier_detail, paid_email, processed_email, posted_email, receiver_name, receiver_phone, settled, posted_date, courier_comp, receiver_email 
        from orders ".$pWhere." ".$pOrder." ".$pLimit;
//		error_log("SQL: ".$vSqlString."--".$pBindParams[0]."--".$pBindParams[1]."--".$pBindParams[2], 3, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($vSqlString);
		array_unshift($pBindParams, $pBindLetters);
		call_user_func_array(array($stmt, 'bind_param'), $pBindParams);
        $id = 0;
        $client_id=$order_date=$temp_salt=$address1=$address2=$city=$province=$country=$code=$courier_type=$courier_cost=$price=$total_price=$payment_type=$submitted=$message=$paid=$processed=$posted=$tracking_no=$completed=$note=$courier_detail=$paid_email=$processed_email=$posted_email=$receiver_name=$receiver_phone=$settled=$posted_date=$courier_comp=$receiver_email = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $client_id, $order_date, $temp_salt, $address1, $address2, $city, $province, $country, $code, $courier_type, $courier_cost, $price, $total_price, $payment_type, $submitted, $message, $paid, $processed, $posted, $tracking_no, $completed, $note, $courier_detail, $paid_email, $processed_email, $posted_email, $receiver_name, $receiver_phone, $settled, $posted_date, $courier_comp, $receiver_email);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vId[] = $id;
					$vClient_id[] = $client_id;
					$vOrder_date[] = $order_date;
					$vTemp_salt[] = $temp_salt;
					$vAddress1[] = $address1;
					$vAddress2[] = $address2;
					$vCity[] = $city;
					$vProvince[] = $province;
					$vCountry[] = $country;
					$vCode[] = $code;
					$vCourier_type[] = $courier_type;
					$vCourier_cost[] = $courier_cost;
					$vPrice[] = $price;
					$vTotal_price[] = $total_price;
					$vPayment_type[] = $payment_type;
					$vSubmitted[] = $submitted;
					$vMessage[] = $message;
					$vPaid[] = $paid;
					$vProcessed[] = $processed;
					$vPosted[] = $posted;
					$vTracking_no[] = $tracking_no;
					$vCompleted[] = $completed;
					$vNote[] = $note;
					$vCourier_detail[] = $courier_detail;
					$vPaidEmail[] = $paid_email;
					$vProcessedEmail[] = $processed_email;
					$vPostedEmail[] = $posted_email;
					$vReceiverName[] = $receiver_name;
					$vReceiverPhone[] = $receiver_phone;
					$vSettled[] = $settled;
					$vPostedDate[] = $posted_date;
					$vCourierComp[] = $courier_comp;
                    $vReceiver_email[] = $receiver_email;
				}
			}
		}
		$stmt->close();
		return array($vId, $vClient_id, $vOrder_date, $vTemp_salt, $vAddress1, $vAddress2, $vCity, $vProvince, $vCountry, $vCode, $vCourier_type, $vCourier_cost, $vPrice, $vTotal_price, $vPayment_type ,$vSubmitted, $vMessage, $vPaid, $vProcessed ,$vPosted, $vTracking_no ,$vCompleted, $vNote, $vCourier_detail, $vPaidEmail, $vProcessedEmail, $vPostedEmail, $vReceiverName, $vReceiverPhone, $vSettled, $vPostedDate, $vCourierComp, $vReceiver_email);
	}

	public static function getOrderDetail($pConn, $pWhere, $pId){
		// 		$vSqlString = "select o.id, od.isbn, od.number_books, od.price, b.title from order_detail od ";
// 		$vSqlString .= "LEFT JOIN orders AS o ON o.id = od.order_id ";
// 		$vSqlString .= "LEFT JOIN books AS b ON b.id = od.book_id ";
// 		$vSqlString .= "WHERE ".$pWhere." order by isbn asc";
		$vSqlString = "select od.id, od.order_id, od.book_id, od.price, od.number_books, od.temp_salt, b.title, b.in_stock, b.author, b.isbn, b.price as original_price from orders_detail od ";
		$vSqlString .= "LEFT JOIN books AS b ON b.id = od.book_id ";
		$vSqlString .= "where ".$pWhere;
		//error_log("SQL: ".$vSqlString." - ".$pId,  3, 'C:/a_Server/wamp64/logs/php_error.log');
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("i", $pId);
        $vResult = array();
        $id = 0;
        $order_id=$book_id=$price=$number_books=$temp_salt=$title=$in_stock=$author=$isbn=$original_price = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $order_id, $book_id, $price, $number_books, $temp_salt, $title, $in_stock, $author, $isbn, $original_price);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
                    $vResult['id'][] = $id;
                    $vResult['order_id'][] = $order_id;
                    $vResult['book_id'][] = $book_id;
                    $vResult['price'][] = $price;
                    $vResult['number_books'][] = $number_books;
                    $vResult['temp_salt'][] = $temp_salt;
                    $vResult['title'][] = $title;
                    $vResult['in_stock'][] = $in_stock;
                    $vResult['author'][] = $author;
                    $vResult['isbn'][] = $isbn;
                    $vResult['original_price'][] = $original_price;
				}
			}
		}
        $stmt->close();
        return $vResult;
	}

	public static function getEvents($pConn, $pWhere, $pOrder, $pBindLetters,  $pBindParams, $pLimit){
		$vSqlString = "select id, name, detail, date, time, rsvp, price, location, poster_path from events  ".$pWhere." ".$pOrder." ".$pLimit;
		//error_log("SQL: ".$vSqlString."--".$pBindParams[0], 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($vSqlString);
		array_unshift($pBindParams, $pBindLetters);
		call_user_func_array(array($stmt, 'bind_param'), $pBindParams);
        $id = 0;
        $name=$detail=$date=$time=$rsvp=$price=$location=$poster_path = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $name, $detail, $date, $time, $rsvp, $price, $location, $poster_path);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vId[] = $id;
					$vName[] = $name;
					$vDetail[] = $detail;
					$vDate[] = $date;
					$vTime[] = $time;
					$vRsvp[] = $rsvp;
					$vPrice[] = $price;
					$vLocation[] = $location;
					$vPosterPath[] = $poster_path;
				}
			}
		}
		$stmt->close();
		return array($vId, $vName, $vDetail, $vDate, $vTime, $vRsvp, $vPrice, $vLocation, $vPosterPath);
	}

	public static function getEventImages($pConn, $pId){
		$vSqlString = "select id, event_id, blob_path, description from event_images  WHERE event_id = ?";
		//error_log("SQL: ".$vSqlString."--".$pId, 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($vSqlString);
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("i", $pId);
        $id = 0;
        $event_id=$blob_path=$description = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $event_id, $blob_path, $description);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vId[] = $id;
					$vEventId[] = $event_id;
					$vBlobPath[] = $blob_path;
					$vDescription[] = $description;
				}
			}
		}
		$stmt->close();
		return array($vId, $vEventId, $vBlobPath, $vDescription);
	}

	/**
	 * Validate client from email link
	 *
	 * @param object $pConn Database connection
	 * @param int $pId Client id
	 * @param string $pToken Temp client token
	 */
	public static function doValidateClient($pConn, $pId, $pToken) {
		$vSqlString = "UPDATE clients SET validated = 1 where id = ? and temp_token = ? and validated = 0";
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("is", $pId, $pToken);
		$stmt->execute() == true;
		$stmt->close();
	}

	/**
	 * Check client validation value
	 *
	 * @param object $pConn Database connection
	 * @param int $pId Client id
	 * @param string $pToken Temp token auto generated
	 * @return int
	 */
	public static function checkValidation($pConn, $pId, $pToken) {
		$sqlString = "select validated from clients where id = ? and temp_token = ?";
		$stmt = $pConn->prepare($sqlString);
		$stmt->bind_param("is", $pId, $pToken);
        $validated = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($validated);
			$stmt->fetch();
			if($validated && !empty($validated)) {
				$vValidated = $validated;
			}
		}
		$stmt->close();
		return $vValidated;
	}

//########################################################################### CMS start
	public static function doCmsLogin($pConn, $pUsername, $pPassword, $pDateMinTwoMonths){
		$pUsername = strtoupper($pUsername);
		if(isset($_SESSION['SessionGrafCmsLoginNo'])) {
			$_SESSION['SessionGrafCmsLoginNo'] = $_SESSION['SessionGrafCmsLoginNo'] + 1;
		}
		else {
			$_SESSION['SessionGrafCmsLoginNo'] = 1;
		}

		$vSqlString = "select id, name, surname, email, rights, password, salt, sections from users where upper(email) = ?";
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("s", $pUsername);
        $id = 0;
        $name=$surname=$email=$rights=$password=$salt=$sections = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $name, $surname, $email, $rights, $password, $salt, $sections);
			$stmt->fetch();
			if($id && $id > 0) {
				$hash = hash('sha256', $salt . hash('sha256', $pPassword));
				if($hash == $password) {
					unset($_SESSION['SessionGrafCmsUserId']);
					unset($_SESSION['SessionGrafCmsUserName']);
					unset($_SESSION['SessionGrafCmsUserSurname']);
					unset($_SESSION['SessionGrafCmsUserEmail']);
					unset($_SESSION['SessionGrafCmsUserRights']);
					unset($_SESSION['SessionGrafCmsLoginNo']);
					unset($_SESSION['SessionGrafCmsUserSections']);

					$_SESSION['SessionGrafCmsUserId'] = $id;
					$_SESSION['SessionGrafCmsUserName'] = $name;
					$_SESSION['SessionGrafCmsUserSurname'] = $surname;
					$_SESSION['SessionGrafCmsUserRights'] = explode(",",$rights); //1 = Add | 4 = Admin
					$_SESSION['SessionGrafCmsUserEmail'] = $email;
					$_SESSION['SessionGrafCmsUserSections'] = explode(",",$sections);

					$vNewUrl = "#welcome_form";
					if(isset($_SESSION['SessionGrafCmsUserId'])) {
						$vUrl = "index.php?page=home";
						General::echoRedirect($vUrl, "");
					}
				}
				else {
					$vUrl = "index.php?page=home";
					General::echoRedirect($vUrl, "");
				}
				$stmt->close();
			}
			else {
				$vUrl = "index.php?page=home";
				General::echoRedirect($vUrl, "");
			}
		}
	}

	public static function getSubMenu($pConn, $pPage){
		$vSqlString = "select id, page, text, type, sort_order from cms_sub_menu where page = ? order by sort_order";
		//error_log($vSqlString);
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("s", $pPage);
        $id= 0;
        $page=$text=$type=$sort_order = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $page, $text, $type, $sort_order);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vMenuId[] = $id;
					$vMenuPage[] = $page;
					$vMenuText[] = $text;
					$vMenuType[] = $type;
				}
			}
		}
		$stmt->close();
		return array($vMenuId, $vMenuPage, $vMenuText, $vMenuType);
	}

	public static function getPublisher($pConn, $pWhere, $pId, $pPublisher, $pSupplier){
		$vSqlString = "select id, publisher, supplier from publishers where ".$pWhere;
		//error_log("SQL: ".$vSqlString, 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("sss", $pId, $pPublisher, $pSupplier);
        $id = 0;
        $publisher=$supplier = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $publisher, $supplier);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
						$row['id'] = $id;
						$row['value'] = $publisher." - ".$supplier;
						$row_set[] = $row;
				}
			}
		}
		$stmt->close();
		return $row_set;
	}

	public static function getPublishers($pConn){
		$vId = 0;
		$vSqlString = "select id, publisher, supplier from publishers where id > ? order by publisher ASC";
		//error_log("SQL: ".$vSqlString, 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("i", $vId);
        $id=0;
        $publisher=$supplier = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $publisher, $supplier);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vPubId[] = $id;
					$vPub[] = $publisher;
					$vPubSupplier[] = $supplier;
					$vIdPub[] = $id." - ".$publisher;
				}
			}
		}
		$stmt->close();
		return array($vPubId, $vPub, $vPubSupplier, $vIdPub);
	}

	public static function getStationarySuppliers($pConn){
		$vSqlString = "select id, name from lk_st_suppliers order by name ASC";
		//error_log("SQL: ".$vSqlString, 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($vSqlString);
        $id = 0;
        $name = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $name);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vId[] = $id;
					$vName[] = $name;
				}
			}
		}
		$stmt->close();
		return array($vId, $vName);
	}

	public static function getPublisherPerId($pConn, $vId){
		$vSqlString = "select id, publisher, supplier from publishers where id = ?";
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("i", $vId);
        $id= 0;
        $publisher=$supplier = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($id, $publisher, $supplier);
			while ($stmt->fetch()) {
				if($id && $id > 0) {
					$vPubId = $id;
					$vPub = $publisher;
					$vPubSupplier = $supplier;
				}
			}
		}
		$stmt->close();
		return array($vPubId, $vPub, $vPubSupplier);
	}

	public static function getIsbn($pConn, $pSection, $pActive){
		$vSqlString = "select isbn from books";
		//error_log($vSqlString, 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($vSqlString);
        $isbn = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($isbn);
			while ($stmt->fetch()) {
				if(!empty($isbn)) {
					$vIsbn[] = $isbn;
				}
			}
		}
		$stmt->close();
		return $vIsbn;
	}

	public static function getBlobPath($pConn, $pId, $pTable){
		if($pTable == "books"){
			$vSqlString = "select blob_path as blob_path from books where id = ?";
		}
		else if($pTable == "events"){
			$vSqlString = "select poster_path as blob_path from events where id = ?";
		}
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("i", $pId);
        $blob_path = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($blob_path);
			while ($stmt->fetch()) {
				if(!empty($blob_path)) {
					$vBlobPath = $blob_path;
				}
			}
		}
		$stmt->close();
		return $vBlobPath;
	}

	public static function checkBookInStock($pConn, $pId){
		$vSqlString = "select in_stock from books where id = ?";
		//error_log($vSqlString." - ".$pId, 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("i", $pId);
        $in_stock = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($in_stock);
			while ($stmt->fetch()) {
					$vInStock = $in_stock;
			}
		}
		$stmt->close();
		return $vInStock;
	}

	public static function getAllText($pConn){
        $vSqlString = "select id, af, en from lk_language_text order by af asc";
        //error_log("SQL: ".$vSqlString, 0, "C:/Temp/php_errors.log");
        $stmt = $pConn->prepare($vSqlString);
            $id= 0;
            $af=$en = '';
        if($stmt->execute() == true) {
            $stmt->bind_result($id, $af, $en);
            while ($stmt->fetch()) {
                if(!empty($af)) {
                    $vId[] = $id;
                    $vAfrikaans[] = $af;
                    $vEnglish[] = $en;
                }
            }
        }
        $stmt->close();
        return array($vId, $vAfrikaans, $vEnglish);
	}

	public static function getBookCurrentRank($pConn, $pField, $pId){
		$vSqlString = "select ".$pField." as rank from books WHERE id = ?";
		//error_log("getCount: ".$vSqlString." //".$pId, 0, "C:/Temp/php_errors.log");
		$stmt = $pConn->prepare($vSqlString);
		$stmt->bind_param("i", $pId);
        $rank = 0;
		if($stmt->execute() == true) {
			$stmt->bind_result($rank);
			while ($stmt->fetch()) {
				$vRank = $rank;
			}
		}
		$stmt->close();
		return $vRank;
	}

	public static function getMonthEndStats($pConn, $pStartDate, $pEndDate) {
		$vSqlString = "SELECT b.isbn, d.book_id, d.price, round(d.price * d.number_books) as sold_price, round(b.price * d.number_books) as original_price,round(b.cost_price * d.number_books) as cost_price, ";
		$vSqlString .= "o.order_date, b.publisher, b.special, p.cost, d.number_books, d.order_id, b.section, b.cost_price AS cost_one FROM orders_detail d ";
		$vSqlString .= "LEFT JOIN books AS b ON b.id = d.book_id ";
		$vSqlString .= "LEFT JOIN orders AS o ON o.id = d.order_id ";
		$vSqlString .= "LEFT JOIN publishers AS p ON p.id = b.publisher ";
		$vSqlString .= "WHERE o.paid = 1 and order_id in (select id from orders where order_date >= '".$pStartDate."' and order_date <= '".$pEndDate."' and me = 0 and paid = 1) ORDER BY o.order_date ASC";
		//error_log($vSqlString, 0, "C:/Temp/php_errors.log");
		//echo "//".$vSqlString."//";
		$stmt = $pConn->prepare($vSqlString);
        $isbn=$book_id=$price=$sold_price=$original_price=$cost_price=$order_date=$publisher=$special=$cost=$number_books=$order_id=$cost_one = '';
		if($stmt->execute() == true) {
			$stmt->bind_result($isbn, $book_id, $price, $sold_price, $original_price, $cost_price, $order_date, $publisher, $special, $cost, $number_books, $order_id, $cost_one);
			while ($stmt->fetch()) {
				if(!empty($isbn)) {
					$vIsbn[] = $isbn;
					$vBookId[] = $book_id;
					$vPriceOne[] = $price;
					$vSoldPrice[] = $sold_price;
					$vOriginalPrice[] = $original_price;
					$vCostPrice[] = $cost_price;
					$vOrderDate[] = $order_date;
					$vPublisher[] = $publisher;
					$vSpecial[] = $special;
					$vCostPercentage[] = $cost;
					$vNumberBooks[] = $number_books;
					$vOrderId[] = $order_id;
					$vCostOne[] = $cost_one;
				}
			}
		}
		$stmt->close();
		return array($vIsbn, $vBookId, $vPriceOne, $vSoldPrice, $vOriginalPrice, $vCostPrice, $vOrderDate, $vPublisher, $vSpecial, $vCostPercentage, $vNumberBooks, $vOrderId, $vCostOne);
	}

    public static function getCompetitions($pConn, $pWhere, $pOrderBy, $pBindLetters,  $pBindParams, $pLimit){
        $sqlString = "SELECT id, name, date_created, date_end, description, blob_path, winner, valid FROM competitions ".$pWhere." ".$pOrderBy." ".$pLimit;
//		error_log("getServices: ".$sqlString."//".$pBindParams[0]."//Letter: ".$pBindLetter[0], 3, "error_log.txt");
        $stmt = $pConn->prepare($sqlString);
        array_unshift($pBindParams, $pBindLetters);
        call_user_func_array(array($stmt, 'bind_param'), $pBindParams);
        $vResult = array();
        $id=$valid = 0;
        $name=$date_created=$date_end=$description=$blob_path=$winner = '';
        if($stmt->execute() == true) {
            $stmt->bind_result($id, $name, $date_created, $date_end, $description, $blob_path, $winner, $valid);
            while ($stmt->fetch()) {
                if($id && $id > 0) {
                    $vResult['id'][] = $id;
                    $vResult['name'][] = $name;
                    $vResult['date_created'][] = $date_created;
                    $vResult['date_end'][] = $date_end;
                    $vResult['description'][] = $description;
                    $vResult['blob_path'][] = $blob_path;
                    $vResult['winner'][] = $winner;
                    $vResult['valid'][] = $valid;
                }
            }
        }
        $stmt->close();
        return $vResult;
    }

    public static function getCompetitionEntries($pConn, $pWhere, $pOrderBy, $pBindLetters,  $pBindParams, $pLimit){
        $sqlString = "SELECT id, name, surname, email, confirmation, competition_id FROM competition_entry ".$pWhere." ".$pOrderBy." ".$pLimit;
        $stmt = $pConn->prepare($sqlString);
        array_unshift($pBindParams, $pBindLetters);
        call_user_func_array(array($stmt, 'bind_param'), $pBindParams);
        $vResult = array();
        $id = 0;
        $name=$surname=$email=$confirmation=$competition_id = '';
        if($stmt->execute() == true) {
            $stmt->bind_result($id, $name, $surname, $email, $confirmation, $competition_id);
            while ($stmt->fetch()) {
                if($id && $id > 0) {
                    $vResult['id'][] = $id;
                    $vResult['name'][] = $name;
                    $vResult['surname'][] = $surname;
                    $vResult['email'][] = $email;
                    $vResult['confirmation'][] = $confirmation;
                    $vResult['competition_id'][] = $competition_id;
                }
            }
        }
        $stmt->close();
        return $vResult;
    }

    public static function getCompetitionWinners($pConn, $pWhere, $pOrderBy, $pBindLetters,  $pBindParams, $pLimit){
        $sqlString = "SELECT id, name, surname, email FROM competition_entry ".$pWhere." ".$pOrderBy." ".$pLimit;
        $stmt = $pConn->prepare($sqlString);
        array_unshift($pBindParams, $pBindLetters);
        call_user_func_array(array($stmt, 'bind_param'), $pBindParams);
        $vResult = array();
        $id = 0;
        $name=$surname=$email = '';
        if($stmt->execute() == true) {
            $stmt->bind_result($id, $name, $surname, $email);
            while ($stmt->fetch()) {
                if($id && $id > 0) {
                    $vResult['id'][] = $id;
                    $vResult['winner'][] = $name." ".$surname ." (". $email.")";
                    $vResult['winner_display'][] = $name . " " . $surname;
                    $vResult['email'][] = $email;
                }
            }
        }
        $stmt->close();
        return $vResult;
    }
}
