<?php
/**
 *
 * @author Carin Pretorius - CEIT Development
 *         Created on 2010-10-09
 */

class RequestUtils {

	static public function getParameter($pName) {
		$vValue = StringUtils::makeProperString($_REQUEST[$pName]);
		return self::convert_type($vValue);
	}

	static public function isEmptyString($pName) {
		$vValue = StringUtils::makeProperString($_REQUEST[$pName]);
		$vAnswer = (!isset($vValue) || strlen(trim($vValue)) == 0);
		// Logger::debug("RequestUtils.class.php","isEmptyString('".$pString."') = ".$vAnswer);
		return $vAnswer;
	}

	static public function getParameterWithDefault($pName, $pDefaultValue) {
		$vValue = StringUtils::makeProperString($_REQUEST[$pName]);
		if(empty($vValue)) {
			$vValue = $pDefaultValue;
		}
		// Logger::debug("RequestUtils.class.php","getParameterWithDefault('".$pName."', '".$pDefaultValue."') = '".$vValue."'");
		return self::convert_type($vValue);
	}

	static public function getParameters($pName) {
		return $_REQUEST[$pName];
	}

	// This function converts an input string into bool, int or float depending on its content.
	static private function convert_type($pValue) {
		if(is_numeric($pValue)) {
			if((float)$pValue != (int)$pValue) {
				return (float)$pValue;
			}
			else {
				return (int)$pValue;
			}
		}

		if($pValue == "true") return true;
		if($pValue == "false") return false;

		return $pValue;
	}

}
?>