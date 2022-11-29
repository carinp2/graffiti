<?php
/**
 *
 * @author Carin Pretorius - CEIT Development
 *         Created on 2015-12-07
 */
define('STR_HIGHLIGHT_SIMPLE', 1);
define('STR_HIGHLIGHT_WHOLEWD', 2);
define('STR_HIGHLIGHT_CASESENS', 4);
define('STR_HIGHLIGHT_STRIPLINKS', 8);

class General {

	/**
	 * Prepare string for display e.g.
	 * replace with &amp;#39; '
	 *
	 * @param string $pString String to prepare for display
	 * @return string
	 */
	public static function prepareStringForDisplay($pString) {
		$theString = StringUtils::urlDecodeQuotes($pString);
		$theString = StringUtils::urlDecodeAmpersands($theString);

		return $theString;
	}

	public static function prepareStringForMeta($pString) {
		$theString = preg_replace("/<br>/", " ", $pString);
		$theString = preg_replace("/<br\/>/", " ", $theString);
		return $theString;
	}

	/**
	 * Prepare string for query
	 *
	 * @param unknown $pString String to be prepared for query
	 * @return string
	 */
	public static function prepareStringForQuery($pString) {
		$theString = StringUtils::filterLimitedText($pString);
		$theString = StringUtils::makeProperString($theString);
		$theString = StringUtils::urlEncodeQuotes($theString);
		$theString = StringUtils::urlEncodeAmpersands($theString);
		$theString = StringUtils::newlinesToHtml($theString);
		$theString = StringUtils::emptyDates($theString);
		return $theString;
	}

	/**
	 * Prepare string for books_search table index
	 *
	 * @param unknown $pString String to be prepared for query
	 * @return string
	 */
	public static function prepareBooksSearchString($pString) {
		$theString = StringUtils::filterTextForSearch($pString);
		$theString =strip_tags($theString);
		$theString = StringUtils::makeProperString($theString);
		return $theString;
	}

	/**
	 * Prepare string for books_search table index
	 *
	 * @param unknown $pString String to be prepared for query
	 * @return string
	 */
	public static function prepareBooksSearchStringData($pString) {
		$theString = StringUtils::filterTextForSearchData($pString);
		$theString =strip_tags($theString);
		$theString = StringUtils::makeProperString($theString);
		return $theString;
	}

	/**
	 * Prepare string for input display e.g.'
	 *
	 * @param string $pString String to prepare for display
	 * @return string
	 */
	public static function prepareStringForInputDisplay($pString) {
		$theString = StringUtils::urlDecodeQuotes($pString);
		$theString = StringUtils::urlDecodeAmpersands($theString);
		$theString = StringUtils::htmlToNewLines($theString);

		return $theString;
	}

	/**
	 * Prepare string for Clean URL
	 *
	 * @param unknown $pString String to be prepared for URL
	 * @return string
	 */
	public static function prepareStringForUrl($pString) {
		$theString = StringUtils::makeProperString($pString);
		$theString = str_replace(" ", "-", $theString);
		$theString = str_replace("&amp;#39;", "", $theString);
		$theString = str_replace("&#39;", "", $theString);
		$theString = str_replace("&", "", $theString);
		$theString = str_replace("'", "", $theString);
		$theString = str_replace(":", "", $theString);
		$theString = str_replace(";", "", $theString);
		$theString = str_replace(".", "", $theString);
		$theString = str_replace(",", "", $theString);
		$theString = str_replace("?", "", $theString);
		$theString = str_replace("!", "", $theString);
		$theString = str_replace("`", "", $theString);
		$theString = str_replace("%", "pct", $theString);
		$theString = str_replace("#", "", $theString);
		$theString = str_replace("//", "", $theString);
		$theString = str_replace("/", "", $theString);
		$theString = str_replace("--", "-", $theString);
		return $theString;
	}

	public static function prepareUrlForDisplay($pString) {
		$theString = StringUtils::makeProperString($pString);
		$theString = str_replace("-", " ", $theString);
		$theString = str_replace("~", " - ", $theString);
		return $theString;
	}

	public static function echoRedirect($pUrl, $pAlert) {
		echo "<Script>";
		if(strlen($pAlert) > 0) {
			echo "alert('",$pAlert,"');";
		}
		//error_log("URL: ".$pUrl, 0, "C:/Temp/php_errors.log");
		echo 'document.location.href="',$pUrl,'";</Script>';
	}

	/**
	 * Return highlighted search string
	 *
	 * @param string $text Result String to search
	 * @param string $needle String to be highlighted
	 * @param string $options Empty string
	 * @param string $highlight Empty string
	 * @return string
	 */
public static function str_highlight($text, $needle, $options = null, $highlight = null){
    // Default highlighting
    if ($highlight === null) {
        $highlight = '<span id="highlight">\1</span>';
    }

    // Select pattern to use
    if ($options & STR_HIGHLIGHT_SIMPLE) {
        $pattern = '#(%s)#';
        $sl_pattern = '#(%s)#';
    } else {
        $pattern = '#(?!<.*?)(%s)(?![^<>]*?>)#';
        $sl_pattern = '#<a\s(?:.*?)>(%s)</a>#';
    }

    // Case sensitivity
    if (!($options & STR_HIGHLIGHT_CASESENS)) {
        $pattern .= 'i';
        $sl_pattern .= 'i';
    }
$needle = (array) $needle;
foreach ($needle as $needle_s) {
        $needle_s = preg_quote($needle_s);

        // Escape needle with optional whole word check
        if ($options & STR_HIGHLIGHT_WHOLEWD) {
            $needle_s = '\b' . $needle_s . '\b';
        }

        // Strip links
        if ($options & STR_HIGHLIGHT_STRIPLINKS) {
            $sl_regex = sprintf($sl_pattern, $needle_s);
            $text = preg_replace($sl_regex, '\1', $text);
        }

        $regex = sprintf($pattern, $needle_s);
$text = preg_replace($regex, $highlight, $text);
}

    return $text;
}

	/**
	 * Return number links for results pagination
	 *
	 * @param int $pTotalRows Total number of results
	 * @param int $pLimit Results per page
	 * @param int $pPage Current page number
	 * @param int $pTotalPages Total number of pages
	 * @param string $pUrl URL for numbers and next links
	 * @return string
	 */
	public static function echoWalkingWindowPages($pTotalRows, $pLimit, $pPage, $pTotalPages, $pUrl) {
		$theUrl = $pUrl . "&amp;limit=" . $pLimit;
		$vWwEnd = "<nav><ul class=\"pagination\">";
		if($pTotalRows > $pLimit) {
			//error_log("pPage:::: ".$pPage, 0, "C:/Temp/php_errors.log");
			if(($pPage) || (is_numeric($pPage)) || ($pPage > 0) || ($pPage > $total_rows)) {
				$prev_page = $pPage - 1;
				if($prev_page >= 1) {
					$vWwEnd .= "<li><a href=\"" . $theUrl . "&amp;pageno=" . $prev_page . "\" aria-label=\"Previous\" title=\"".$prev_page."\"><span aria-hidden=\"true\">&laquo;</span></a></li>";
				}
			}
			for($a = 1; $a <= $pTotalPages; $a++) {
				if($a == $pPage || (empty($pPage) && $a == 1)) {
					$vWwEnd .= "<li><a href=\"#\" class=\"active\" id=\"pageSelf\" title=\"".$a."\">".$a."</a></li>";
				}
				else {
					$vWwEnd .= "<li><a href=\"".$theUrl."&amp;pageno=".$a."\" title=\"".$a."\">".$a."</a></li>";
				}
			}
			(empty($pPage) ? $pPage = 1 : $pPage = $pPage);
			$next_page = $pPage + 1;
			if($next_page <= $pTotalPages) {
				$vWwEnd .= "<li><a href=\"".$theUrl."&amp;pageno=".$next_page."\" aria-label=\"Next\" title=\"".$next_page."\"><span aria-hidden=\"true\">&raquo;</span></a></li>";
			}
		}
		$vWwEnd .= "</ul></nav>";
		return $vWwEnd;
	}

	/**
	 * Return page URL with http://
	 *
	 * @return string
	 */
	public static function curPageURL() {
		$pageURL = '';
		if(isset($_SERVER['HTTPS']) && $_SERVER["HTTPS"] != 0) {
			$pageURL .= "https";
		}
        else {
            $pageURL .= 'http';
        }
		if($_SERVER["SERVER_NAME"] == 'graffiti') {
			$pageURL .= "://";
		}
		else {
			$pageURL .= "://www.";
		}
		if($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
		}
		else {
			$pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
		}

		return $pageURL;
	}

	/**
	 * Return only URL parameters
	 *
	 * @return string
	 */
	public static function getUrlParameters() {
		$vUrl = $_SERVER['QUERY_STRING'];
		return $vUrl;
	}

	/**
	 * Return only Clean URL parameters
	 *
	 * @return string
	 */
	public static function getCleanUrlParameters() {
		$vReturnUrl = "";
		$vUrl = parse_url($_SERVER["QUERY_STRING"]);
        if(!empty(($vUrl))) {
            (!empty($lang) ? $vReturnUrl .= $lang : $vReturnUrl .= "");//$1
            (!empty($id) ? $vReturnUrl .= "/" . $id : $vReturnUrl .= "");//$2
            (!empty($page) ? $vReturnUrl .= "/" . $page : $vReturnUrl .= "");//$3
            (!empty($temp) ? $vReturnUrl .= "/" . $temp : $vReturnUrl .= "");//$4
            (!empty($c_id) ? $vReturnUrl .= "/" . $c_id : $vReturnUrl .= "");//$4
            (!empty($rand) ? $vReturnUrl .= "/" . $rand : $vReturnUrl .= "");//$5
            (!empty($sort) ? $vReturnUrl .= "/" . $sort : $vReturnUrl .= "");//$5
            (!empty($cat) ? $vReturnUrl .= "/" . $cat : $vReturnUrl .= "");//$6
            (!empty($subcat) ? $vReturnUrl .= "/" . $subcat : $vReturnUrl .= "");//$7
        }
		return $vReturnUrl;
	}

	/**
	 * Return short page URL without parameters
	 *
	 * @return string
	 */
	static function curPageShortURL() {
		$pageURL = 'http';
		if($_SERVER["HTTPS"] == "on") {
			$pageURL .= "s";
		}
		if($_SERVER["SERVER_NAME"] == '127.0.0.1') {
			$pageURL .= "://";
		}
		else {
			$pageURL .= "://www.";
		}
		if($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"];
		}
		else {
			$pageURL .= $_SERVER["SERVER_NAME"];
		}
		if($_SERVER["SERVER_NAME"] == '127.0.0.1') {
			// $pageURL .= "/thenamibian";
		}
		return $pageURL;
	}

	/**
	 * Return a substring of string of x characters, only ending on a space
	 *
	 * @param string $body String to substr
	 * @param int $maxlength Length of return string
	 * @return string
	 */
	public static function substr_word($body, $maxlength) {
		if(strlen($body) < $maxlength) return $body;
		$body = substr($body, 0, $maxlength);
		$rpos = strrpos($body, ' ');
		if($rpos > 0) $body = substr($body, 0, $rpos);
		return $body."...";
	}

	/**
	 * Create random salt string for client login
	 *
	 * @return string
	 */
	public static function createSalt($pNum) {
		$string = md5(uniqid(rand(), true));
		return substr($string, 0, $pNum);
	}

	/**
	 * Return Select list
	 *
	 * @param object $pConn Database connection
	 * @param string|int $pValue Selected value
	 * @param string $pName Select list name
	 * @param string $pId Select list id
	 * @param array $pValueArray Array of option values
	 * @param array $pDisplayArray Array of option text
	 * @param string $pOnChange OnChange script function
	 * @param int|string $pDefault Default selected index
	 * @param string $pRequired Required
	 * @return string
	 */
	public static function returnSelect($pConn, $pValue, $pName, $pId, $pValueArray, $pDisplayArray, $pOnChange, $pDefault, $pRequired) {
		$vSelect = "<select id='".$pId."' name='".$pName."' size='1' onChange='" . $pOnChange . "' ".$pRequired."  class=\"small\">";
		if($pDefault == 1) {
			$vSelect .= "<option value=''>Kies 'n waarde</option>";
		}
		if($pDefault == 2) {
			$vSelect .= "<option value=''>Kies</option>";
		}
		if($pDefault == 3) {
			$vSelect .= "<option value='0'>Kies 'n waarde</option>";
		}
		if(count($pValueArray) > 0) {
			for($x = 0; $x < count($pValueArray); $x++) {
				$vSelect .= "<option value=\"" . $pValueArray[$x] . "\"";
				if($pValue == $pValueArray[$x]) {
					$vSelect .= " selected ";
				}
				$vSelect .= ">" . $pDisplayArray[$x] . "</option>";
			}
		}
		$vSelect .= "</select>";
		return General::prepareStringForDisplay($vSelect, $pConn);
	}

	/**
	 * Return input box
	 *
	 * @param object $pConn Database connection
	 * @param string $pType Type of input (text|password|file)
	 * @param string $pName Input name
	 * @param int|string $pValue Value of input
	 * @param int $pSize Input size in %
	 * @param int $pMaxLength Input maxlength
	 * @param string $pPlaceholder Input placeholder
	 * @param string $vRequired Required parameter
	 * @param string $pPattern Input pattern
	 * @param string $pTitle Input title popup
	 * @return string
	 */
	public static function returnInput($pConn, $pType, $pName, $pId, $pValue, $pSize, $pMaxLength, $pPlaceholder, $pPattern, $vRequired, $pTitle, $pScript) {
		$vInput = "<input class=\"small\" size=\"".$pSize."\" title=\"".$pTitle."\" type='".$pType."' ".$vRequired." name='".$pName."' id='".$pId."' value=\"". General::prepareStringForDisplay($pValue)."\" maxlength='".$pMaxLength."'";
		if(!empty($pPlaceholder)){
			$vInput .= " placeholder=\"".$pPlaceholder."\"";
		}
		if(!empty($pPattern)){
			$vInput .= " pattern=\"".$pPattern."\"";
		}
		if(!empty($pScript)){
			$vInput .= " ".$pScript;
		}
		$vInput .= ">";
		return General::prepareStringForDisplay($vInput);
	}

	public static function returnTextarea($pConn, $pName, $pId, $pValue, $pCols, $pRows, $pMaxLength, $pPlaceholder, $vRequired){
		$vTextarea = "<textarea  class=\"small\" name=\"".$pName."\" id=\"".$pId."\" cols=\"".$pCols."\" rows=\"".$pRows."\" maxlength=\"".$pMaxLength."\" placeholder=\"".$pPlaceholder."\" ".$vRequired." wrap=\"soft\">".General::prepareStringForDisplay($pValue)."</textarea>";
		return $vTextarea;
	}

	public static function echoWalkingWindowTopSearch($pConn, $pLimit, $pPage, $pUrl, $pField, $pTable, $pWhere, $pBindLetters, $pBindParams) {
        //error_log("Hier in walking", 3, "C:/Temp/php_errors.log");
		$total_rows = MysqlQuery::searchCount($pConn, $pField, $pTable, $pWhere, $pBindLetters, $pBindParams);
		if((!isset($limit)) || (is_numeric($limit) == false) || ($limit < $pLimit) || ($limit > 1000)) {
			$limit = $pLimit;
		}
		if((!$pPage) || (is_numeric($pPage) == false) || ($pPage < 0) || ($pPage > $total_rows)) {
		//if(is_numeric($pPage) && $pPage > 0 && $pPage == round($pPage, 0)){}else {
			$pPage = 1;
		}
		$total_pages = ceil($total_rows / $limit);
		$set_limit = $pPage * $limit - ($limit);
		$theLimitString = "LIMIT ".$set_limit . ", " . $limit;
		($total_rows > 0 ? $vResultCountDisplay = $set_limit + 1 : $vResultCountDisplay = $set_limit);
		$vRecordsShown = $limit * $pPage;
		($vRecordsShown >= $total_rows ? $vResultCountDisplay .= " to " . $total_rows : $vResultCountDisplay .= " to " . $vRecordsShown);

		return array($limit, $pPage, $total_pages, $set_limit, $theLimitString, $total_rows, $vResultCountDisplay);
	}

	/**
	 * Calculate file size from bytes
	 *
	 * @param int $bytes Bytes
	 * @param int $precision
	 * @return string
	 */
	public static function bytesToSize($bytes, $precision = 2) {
		$kilobyte = 1024;
		$megabyte = $kilobyte * 1024;
		$gigabyte = $megabyte * 1024;
		$terabyte = $gigabyte * 1024;

		if(($bytes >= 0) && ($bytes < $kilobyte)) {
			return $bytes . ' B';
		}
		elseif(($bytes >= $kilobyte) && ($bytes < $megabyte)) {
			return round($bytes / $kilobyte, $precision) . 'KB';
		}
		elseif(($bytes >= $megabyte) && ($bytes < $gigabyte)) {
			return round($bytes / $megabyte, $precision) . 'MB';
		}
		elseif(($bytes >= $gigabyte) && ($bytes < $terabyte)) {
			return round($bytes / $gigabyte, $precision) . 'GB';
		}
		elseif($bytes >= $terabyte) {
			return round($bytes / $terabyte, $precision) . 'TB';
		}
		else {
			return $bytes . 'B';
		}
	}

	public static function echoSortOrderSelect($pConn, $pSort, $pUrlData, $pType){
		$vResults = MysqlQuery::getLookup($pConn, "sort_by");
		$vValueArray = array();
		$vTextArray = array();
		$vIconArray = array();
		array_push($vValueArray, "date_publish DESC");
		array_push($vTextArray, MysqlQuery::getText($pConn, 25));//Publikasiedatum
		array_push($vIconArray, "fa fa-sort-numeric-desc");
		array_push($vValueArray, "date_publish ASC");
		array_push($vTextArray, MysqlQuery::getText($pConn, 25));//Publikasiedatum
		array_push($vIconArray, "fa fa-sort-numeric-asc");
		array_push($vValueArray, "title ASC");
		array_push($vTextArray, MysqlQuery::getText($pConn, 332));//Titel
		array_push($vIconArray, "fa fa-sort-alpha-asc");
		array_push($vValueArray, "title DESC");
		array_push($vTextArray, MysqlQuery::getText($pConn, 332));//Titel
		array_push($vIconArray, "fa fa-sort-alpha-desc");
		array_push($vValueArray, "author ASC");
		array_push($vTextArray, MysqlQuery::getText($pConn, 262));//Outeur
		array_push($vIconArray, "fa fa-sort-alpha-asc");
		array_push($vValueArray, "author DESC");
		array_push($vTextArray, MysqlQuery::getText($pConn, 262));//Outeur
		array_push($vIconArray, "fa fa-sort-alpha-desc");
		array_push($vValueArray, "language ASC");
		array_push($vTextArray, MysqlQuery::getText($pConn, 385));//Taal
		array_push($vIconArray, "fa fa-sort-alpha-asc");
		array_push($vValueArray, "language DESC");
		array_push($vTextArray, MysqlQuery::getText($pConn, 385));//Taal
		array_push($vIconArray, "fa fa-sort-alpha-desc");
		array_push($vValueArray, "category_string ASC, sub_category_string ASC");
		array_push($vTextArray, MysqlQuery::getText($pConn, 482));//Kategorie
		array_push($vIconArray, "fa fa-sort-alpha-asc");
		array_push($vValueArray, "category_string DESC, sub_category_string DESC");
		array_push($vTextArray, MysqlQuery::getText($pConn, 482));//Kategorie
		array_push($vIconArray, "fa fa-sort-alpha-desc");

		if($pType == "general" && $pUrlData['id'] == 208){
			array_push($vValueArray, "special_price DESC");
			array_push($vTextArray, MysqlQuery::getText($pConn, 141));//Prys
			array_push($vIconArray, "fa fa-sort-numeric-desc");
			array_push($vValueArray, "special_price ASC");
			array_push($vTextArray, MysqlQuery::getText($pConn, 141));//Prys
			array_push($vIconArray, "fa fa-sort-numeric-asc");
		} else {
			array_push($vValueArray, "price DESC");
			array_push($vTextArray, MysqlQuery::getText($pConn, 141));//Prys
			array_push($vIconArray, "fa fa-sort-numeric-desc");
			array_push($vValueArray, "price ASC");
			array_push($vTextArray, MysqlQuery::getText($pConn, 141));//Prys
			array_push($vIconArray, "fa fa-sort-numeric-asc");
		}

		$vString = "<div class=\"btn-group space-top\">";
			$vString .= "<a class=\"btn btn-primary dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\" title=\"".MysqlQuery::getText($pConn, 330)/* Sorteer volgens*/."\">".MysqlQuery::getText($pConn, 330)/* Sorteer volgens*/."</a>";
			$vString .= "<a class=\"btn btn-primary dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\" title=\"".MysqlQuery::getText($pConn, 330)/* Sorteer volgens*/."\">";
				$vString .= " <span class=\"fa fa-caret-down\"></span>";
			$vString .= "</a>";
			$vString .= "<ul class=\"dropdown-menu\">";
			for($x = 0; $x < count($vValueArray); $x++){
				if($pType == "general"){//More pages
					$vString .= "<li><a href=\"".$_SESSION['SessionGrafLanguage']."/".$pUrlData['id']."/".$pUrlData['page']."/".$pUrlData['language']."/".urlencode($vValueArray[$x])."\" title=\"".MysqlQuery::getText($pConn, 330)/* Sorteer volgens*/."\"><i class=\"".$vIconArray[$x]."\"></i> ".$vTextArray[$x]."</a></li>";
				}
				else if ($pType == "k" || $pType == "ks"){//keywords
					$vString .= "<li><a href=\"".$pUrlData['lang']."/ks/".$pUrlData['page']."/0/".urlencode($vValueArray[$x])."/".$pUrlData['cat']."\" title=\"".MysqlQuery::getText($pConn, 330)/* Sorteer volgens*/."\"><i class=\"".$vIconArray[$x]."\"></i> ".$vTextArray[$x]."</a></li>";
					//af/m/Soek/12/date_publish+DESC/Nie-fiksie-Non-fiction/Aktuele-Sake-Current-Affairs
				}
				else if ($pType == "m"){//menu
					$vString .= "<li><a href=\"".$pUrlData['lang']."/m/".$pUrlData['page']."/".$pUrlData['subcat_id']."/".urlencode($vValueArray[$x])."/".$pUrlData['cat']."/".$pUrlData['subcat']."\" title=\"".MysqlQuery::getText($pConn, 330)/* Sorteer volgens*/."\"><i class=\"".$vIconArray[$x]."\"></i> ".$vTextArray[$x]."</a></li>";
					//af/m/Soek/12/date_publish+DESC/Nie-fiksie-Non-fiction/Aktuele-Sake-Current-Affairs
				}
				else if ($pType == "c"){//category
					$vString .= "<li><a href=\"".$pUrlData['lang']."/c/".$pUrlData['page']."/".$pUrlData['cat_id']."/".urlencode($vValueArray[$x])."/".$pUrlData['cat']."\" title=\"".MysqlQuery::getText($pConn, 330)/* Sorteer volgens*/."\"><i class=\"".$vIconArray[$x]."\"></i> ".$vTextArray[$x]."</a></li>";
					//af/c/Soek/6/date_publish+DESC/Leermiddels
					//page=$3&lang=$1&id=$2&c_id=$4&sort=$5&cat=$6
				}
				else if ($pType == "a"){//author
					$vString .= "<li><a href=\"".$pUrlData['lang']."/a/".$pUrlData['page']."/0/".urlencode($vValueArray[$x])."/".str_replace(".", "~", $pUrlData['cat'])."\" title=\"".MysqlQuery::getText($pConn, 330)/* Sorteer volgens*/."\"><i class=\"".$vIconArray[$x]."\"></i> ".$vTextArray[$x]."</a></li>";
					//af/a/Soek//date_publish+DESC/Christine Barkhuizen-le Roux
				}
				else if ($pType == "Moleskine"){
					$vString .= "<li><a href=\"".$pUrlData['lang']."/0/".$pUrlData['page']."/1/".urlencode($vValueArray[$x])."/".$pUrlData['cat']."\" title=\"".MysqlQuery::getText($pConn, 330)/* Sorteer volgens*/."\"><i class=\"".$vIconArray[$x]."\"></i> ".$vTextArray[$x]."</a></li>";
					///af/0/Moleskine/1
				}
				else if ($pType == "tv"){
					$vString .= "<li><a href=\"".$pUrlData['lang']."/0/".$pUrlData['page']."/1/".urlencode($vValueArray[$x])."/".$pUrlData['cat']."\" title=\"".MysqlQuery::getText($pConn, 330)/* Sorteer volgens*/."\"><i class=\"".$vIconArray[$x]."\"></i> ".$vTextArray[$x]."</a></li>";
					//af/0/GrootOntbyt/1
				}

			}
			$vString .= " </ul>";
		$vString .= "</div>";

		return $vString;
	}

	public static function returnSortOrderDescription($pConn, $pSort){
		if($pSort == "date_publish DESC"){
			$vString = "<i class=\"fa fa-sort-numeric-desc green\"></i> <span class=\"nowrap\">&nbsp;".MysqlQuery::getText($pConn, 25)."</span>";//Publikasiedatum;
		}
		else if($pSort == "date_publish ASC"){
			$vString = "<i class=\"fa fa-sort-numeric-asc green\"></i> <span class=\"nowrap\">&nbsp;".MysqlQuery::getText($pConn, 25)."</span>";//Publikasiedatum;
		}
		else if($pSort == "title ASC"){
			$vString = "<i class=\"fa fa-sort-alpha-asc green\"></i> <span class=\"nowrap\">&nbsp;".MysqlQuery::getText($pConn, 332)."</span>";//Titel
		}
		else if($pSort == "title DESC"){
			$vString = "<i class=\"fa fa-sort-alpha-desc green\"></i> <span class=\"nowrap\">&nbsp;".MysqlQuery::getText($pConn, 332)."</span>";//Titel
		}
		else if($pSort == "author ASC"){
			$vString = "<i class=\"fa fa-sort-alpha-asc green\"></i> <span class=\"nowrap\">&nbsp;".MysqlQuery::getText($pConn, 262)."</span>";//Outeur
		}
		else if($pSort == "author DESC"){
			$vString = "<i class=\"fa fa-sort-alpha-desc green\"></i> <span class=\"nowrap\">&nbsp;".MysqlQuery::getText($pConn, 262)."</span>";//Outeur
		}
		else if($pSort == "top_seller_rank ASC"){
			$vString = "<i class=\"fa fa-sort-numeric-asc green\"></i> <span class=\"nowrap\">&nbsp;".MysqlQuery::getText($pConn, 331)."</span>";//Topverkoper posisie
		}
		else if($pSort == "top_seller_rank DESC"){
			$vString = "<i class=\"fa fa-sort-numeric-desc green\"></i> <span class=\"nowrap\">&nbsp;".MysqlQuery::getText($pConn, 331)."</span>";//Topverkoper posisie
		}
		else if($pSort == "language DESC"){
			$vString = "<i class=\"fa fa-sort-alpha-desc green\"></i> <span class=\"nowrap\">&nbsp;".MysqlQuery::getText($pConn, 385)."</span>";//Language
		}
		else if($pSort == "language ASC"){
			$vString = "<i class=\"fa fa-sort-alpha-asc green\"></i> <span class=\"nowrap\">&nbsp;".MysqlQuery::getText($pConn, 385)."</span>";//Language
		}
		else if($pSort == "b.tv_date desc"){
			$vString = "<i class=\"fa fa-sort-numeric-desc green\"></i> <span class=\"nowrap\">&nbsp;".MysqlQuery::getText($pConn, 458)."</span>";//Datum van uitsending
		}
		else if($pSort == "b.rr_date desc"){
			$vString = "<i class=\"fa fa-sort-numeric-desc green\"></i> <span class=\"nowrap\">&nbsp;".MysqlQuery::getText($pConn, 474)."</span>";//Tydskrif uitgawe
		}
		else if($pSort == "price ASC"){
			$vString = "<i class=\"fa fa-sort-numeric-asc green\"></i> <span class=\"nowrap\">&nbsp;".MysqlQuery::getText($pConn, 141)."</span>";//Price
		}
		else if($pSort == "price DESC"){
			$vString = "<i class=\"fa fa-sort-numeric-desc green\"></i> <span class=\"nowrap\">&nbsp;".MysqlQuery::getText($pConn, 141)."</span>";//Price
		}
		else if($pSort == "category_string ASC, sub_category_string ASC"){
			$vString = "<i class=\"fa fa fa-sort-alpha-asc green\"></i> <span class=\"nowrap\">&nbsp;".MysqlQuery::getText($pConn, 482)."</span>";//Kategorie
		}
		else if($pSort == "category_string DESC, sub_category_string DESC"){
			$vString = "<i class=\"fa fa fa-sort-alpha-desc green\"></i> <span class=\"nowrap\">&nbsp;".MysqlQuery::getText($pConn, 482)."</span>";//Kategorie
		}
		else {
			$vString = "<i class=\"fa fa-sort-numeric-asc green\"></i> <span class=\"nowrap\">&nbsp;".MysqlQuery::getText($pConn, 472)."</span>";//Posisie
		}

		return $vString;
	}

	/**
	 * Return directory listing for all directories
	 *
	 * @param string $pDirectory Directory to list
	 * @return ()[string|string]
	 */
	public static function listDirectoryFiles($pDirectory) {
		$ffs = scandir($pDirectory, 0);
		foreach($ffs as $ff) {
			if($ff != '.' && $ff != '..' && $ff != '.htaccess') {
				$vFile = str_replace(".pdf", "", $ff);
				$vFile = str_replace(".PDF", " ", $vFile);
				$vFile = str_replace(".Pdf", " ", $vFile);
				//$vFile = str_replace("_", " ", $vFile);
				$vFileSize[] = General::bytesToSize(filesize($pDirectory . "/" . $ff));
				$vFileName[] = date("d M Y", strtotime(str_replace("_", "-", $vFile)));
				$vFileUrl[] = $ff;
			}
		}
// 		if(count($vFileName) > 0) {
// 			array_multisort($vFileSize, $vFileName, $vFileUrl, SORT_ASC);
// 		}
		return array($vFileSize, $vFileName, $vFileUrl);
	}

	public static function echoTooltip($vPosition, $vText){
		$vString = "data-toggle=\"tooltip\" data-placement=\"".$vPosition."\" data-html=\"true\" title=\"".$vText."\"";
		return $vString;
	}

	public static function returnYesNo($pValue){
		if($pValue == 0){
			return "Nee";
		}
		else if($pValue == 1){
			return "Ja";
		}
	}
}