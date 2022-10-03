<?php
$vDisplayAll = "";
$vPageNo = "";
if($vType == "general"){
		$vOutPrintValue = 0;
		$vBindLetters .= "i";
		$vBindParams[] = & $vOutPrintValue;
		if($pTypeId == 204){//204 = Nuwe boeke
			$vWhere = "WHERE b.out_of_print = ? and b.new = ? and b.language = ? and b.new_rank > 0 and b.category != 4 and b.category != 5 and b.category != 8 and b.category != 9 and b.category != 7 and b.category != 6";
			$vOrder = " ORDER BY ".$pSort;
			$vValue = 1;
			$vBindLetters .= "i";
			$vBindLetters .= "s";
			$vBindParams[] = & $vValue;
			$vBindParams[] = & $pLanguage;
		}
		if($pTypeId == 446){//446 = Nuwe boeke Kinders
			$vWhere = "WHERE b.out_of_print = ? and b.new = ? and b.new_rank > 0 and (b.category = 4 or b.category = 5 or b.category = 8 or b.category = 9 or b.category = 7 or b.category = 6)";
			$vOrder = " ORDER BY ".$pSort;
			$vValue = 1;
			$vBindLetters .= "i";
			$vBindParams[] = & $vValue;
		}
		if($pTypeId == 209){//209 = Topverkopers
			$vWhere = "WHERE b.out_of_print = ? and b.top_seller = ? and b.language = ? and b.category != 4 and b.category != 5 and b.category != 8 and b.category != 9 and b.category != 7 AND b.category != 6";
			$vOrder = " ORDER BY ".$pSort;
			$vValue = 1;
			$vBindLetters .= "i";
			$vBindLetters .= "s";
			$vBindParams[] = & $vValue;
			$vBindParams[] = & $pLanguage;
		}
		if($pTypeId == 447){//447 = Topverkopers Kinders
			$vWhere = "WHERE b.out_of_print = ? and b.top_seller = ? and (b.category = 4 or b.category = 5 or b.category = 8 or b.category = 9 or b.category = 7 or b.category = 6)";
			$vOrder = " ORDER BY ".$pSort;
			$vValue = 1;
			$vBindLetters .= "i";
			$vBindParams[] = & $vValue;
		}
		if($pTypeId == 208){//208 = Winskopies
			$vWhere = "WHERE b.out_of_print = ? and b.special = ? and b.special_rank > ?";
			$vOrder = " ORDER BY ".$pSort;
			$vValue = 1;
			$vValue2 = ($pSort == 'in_stock DESC' ? -1 : 0);
			$vBindLetters .= "ii";
			$vBindParams[] = & $vValue;
			$vBindParams[] = & $vValue2;
		}
		if($pTypeId == 206){//206 = Binnekort
			if($vDisplayAll == 1){
				$vValue = $_SESSION['now_date'];
				$vBindLetters .= "s";
				$vBindParams[] = & $vValue;
				$vWhere = "WHERE b.out_of_print = ? and b.date_publish > ?";
			}
			else {
				$vValue = $_SESSION['now_date'];
				$vBindLetters .= "s";
				$vBindParams[] = & $vValue;
				$vValue2 = 1;
				$vBindLetters .= "i";
				$vBindParams[] = & $vValue2;
				$vWhere = "WHERE b.out_of_print = ? AND b.date_publish > ? and soon = ?";
			}
			$vOrder = " ORDER BY ".$pSort;
		}

		$vWindowValues = General::echoWalkingWindowTopSearch($pConn, $per_page, $vPageNo, $vUrl, "id", "books b", $vWhere, $vBindLetters, $vBindParams);
		$vResults = MysqlQuery::getBooks($pConn, $vWhere, $vOrder, $vBindLetters,  $vBindParams, $vWindowValues[4]);
}
else if($vType == "k"){
		//keyword
		$vOrder = " ORDER BY CASE ";
		$vKeyword = StringUtils::filterTextForSearch(trim(strtolower(strip_tags(stripslashes($pSearchData['cat'])))));

		$vWhere .= "WHERE (LOWER(bs.title) = ? OR ";
		$vBindLetters .= "s";
		$vKeyword1 = $vKeyword;
		$vBindParams[] = & $vKeyword1;
		$vOrder .= "WHEN LOWER(bs.title) = '".$vKeyword1."' THEN 1 ";

		$vWhere .= " LOWER(bs.title) LIKE ? OR ";
		$vBindLetters .= "s";
		($pSearchData['autocomplete'] && $pSearchData['autocomplete']  == 1 ? $vKeyword1 = $vKeyword : $vKeyword1 = "%{$vKeyword}%");
		$vBindParams[] = & $vKeyword1;
		$vOrder .= "WHEN LOWER(bs.title) LIKE '".$vKeyword1."' THEN 3 ";

		$vWhere .= "LOWER(bs.author) = ? OR ";
		$vBindLetters .= "s";
		$vCleanKeyword = str_replace(", ", ",", $vKeyword);
		$vBindParams[] = & $vCleanKeyword;
		$vOrder .= "WHEN LOWER(bs.author) = '".$vCleanKeyword."' THEN 2 ";

		$vWhere .= "LOWER(bs.author) LIKE ? OR ";
		$vBindLetters .= "s";
		$vCleanKeyword = str_replace(", ", ",", $vKeyword);
		($pSearchData['autocomplete'] && $pSearchData['autocomplete']  == 1 ? $vKeyword1 = $vCleanKeyword : $vKeyword1 = "%{$vCleanKeyword}%");
		$vBindParams[] = & $vKeyword1;
		$vOrder .= "WHEN LOWER(bs.author) LIKE '".$vKeyword1."' THEN 4 ";
// April 2020
		$vWhere .= "LOWER(bs.translator) = ? OR ";
		$vBindLetters .= "s";
		$vCleanKeyword = str_replace(", ", ",", $vKeyword);
		$vBindParams[] = & $vCleanKeyword;
		$vOrder .= "WHEN LOWER(bs.translator) = '".$vCleanKeyword."' THEN 2 ";

		$vWhere .= "LOWER(bs.translator) LIKE ? OR ";
		$vBindLetters .= "s";
		$vCleanKeyword = str_replace(", ", ",", $vKeyword);
		($pSearchData['autocomplete'] && $pSearchData['autocomplete']  == 1 ? $vKeyword1 = $vCleanKeyword : $vKeyword1 = "%{$vCleanKeyword}%");
		$vBindParams[] = & $vKeyword1;
		$vOrder .= "WHEN LOWER(bs.translator) LIKE '".$vKeyword1."' THEN 4 ";

		$vWhere .= "LOWER(bs.illustrator) = ? OR ";
		$vBindLetters .= "s";
		$vCleanKeyword = str_replace(", ", ",", $vKeyword);
		$vBindParams[] = & $vCleanKeyword;
		$vOrder .= "WHEN LOWER(bs.illustrator) = '".$vCleanKeyword."' THEN 2 ";

		$vWhere .= "LOWER(bs.illustrator) LIKE ? OR ";
		$vBindLetters .= "s";
		$vCleanKeyword = str_replace(", ", ",", $vKeyword);
		($pSearchData['autocomplete'] && $pSearchData['autocomplete']  == 1 ? $vKeyword1 = $vCleanKeyword : $vKeyword1 = "%{$vCleanKeyword}%");
		$vBindParams[] = & $vKeyword1;
		$vOrder .= "WHEN LOWER(bs.illustrator) LIKE '".$vKeyword1."' THEN 4 ";
//April 2020

		$vWhere .= "bs.isbn LIKE ?)";
		$vBindLetters .= "s";
		($pSearchData['autocomplete'] && $pSearchData['autocomplete']  == 1 ? $vKeyword1 = $vKeyword : $vKeyword1 = "%{$vKeyword}%");
		$vBindParams[] = & $vKeyword1;
		$vOrder .= "WHEN bs.isbn LIKE '".$vKeyword1."' THEN 5 ELSE 6 END";

		$vWindowValues = General::echoWalkingWindowTopSearch($pConn, $per_page, $vPageNo, $vUrl, "bs.id", "books_search bs", $vWhere, $vBindLetters, $vBindParams);
		$vResults = MysqlQuery::getBooksFull($pConn, $vWhere, $vOrder, $vBindLetters,  $vBindParams, $vWindowValues[4]);
}
else if($vType == "ks"){//keyword with sort
		$vOrder = " ORDER BY ".urldecode($pSearchData['sort']);
		$vKeyword = StringUtils::filterTextForSearch(trim(strtolower(strip_tags(stripslashes($pSearchData['cat'])))));

		$vWhere .= "WHERE (LOWER(bs.title) = ? OR ";
		$vBindLetters .= "s";
		$vKeyword1 = $vKeyword;
		$vBindParams[] = & $vKeyword1;

		$vWhere .= " LOWER(bs.title) LIKE ? OR ";
		$vBindLetters .= "s";
		($pSearchData['autocomplete'] && $pSearchData['autocomplete']  == 1 ? $vKeyword1 = $vKeyword : $vKeyword1 = "%{$vKeyword}%");
		$vBindParams[] = & $vKeyword1;

		$vWhere .= "LOWER(bs.author) = ? OR ";
		$vBindLetters .= "s";
		$vKeyword1 = $vKeyword;
		$vBindParams[] = & $vKeyword1;

		$vWhere .= "LOWER(bs.author) LIKE ? OR ";
		$vBindLetters .= "s";
		($pSearchData['autocomplete'] && $pSearchData['autocomplete']  == 1 ? $vKeyword1 = $vKeyword : $vKeyword1 = "%{$vKeyword}%");
		$vBindParams[] = & $vKeyword1;

		$vWhere .= "bs.isbn LIKE ?)";
		$vBindLetters .= "s";
		($pSearchData['autocomplete'] && $pSearchData['autocomplete']  == 1 ? $vKeyword1 = $vKeyword : $vKeyword1 = "%{$vKeyword}%");
		$vBindParams[] = & $vKeyword1;

		$vWindowValues = General::echoWalkingWindowTopSearch($pConn, $per_page, $vPageNo, $vUrl, "bs.id", "books_search bs", $vWhere, $vBindLetters, $vBindParams);
		$vResults = MysqlQuery::getBooksFull($pConn, $vWhere, $vOrder, $vBindLetters,  $vBindParams, $vWindowValues[4]);
}
else if($vType == "a"){// author
// 		$vOutPrintValue = 0;
// 		$vBindLetters .= "i";
// 		$vBindParams[] = & $vOutPrintValue;
// 		$vWhere = "WHERE  b.out_of_print = ? and ";

		$vOrder = " ORDER BY ".urldecode($pSearchData['sort']);
		$vAuthor = trim(strtolower(strip_tags(stripslashes($pSearchData['cat']))));

		$vWhere .= " WHERE (LOWER(b.author) LIKE ? OR ";
		$vBindLetters .= "s";
		$vKeyword1 = "%{$vAuthor}%";
		$vBindParams[] = & $vKeyword1;

		$vWhere .= "LOWER(b.illustrator) LIKE ? OR ";
		$vBindLetters .= "s";
		$vKeyword1 = "%{$vAuthor}%";
		$vBindParams[] = & $vKeyword1;

		$vWhere .= "LOWER(b.translator) LIKE ?)";
		$vBindLetters .= "s";
		$vKeyword1 = "%{$vAuthor}%";
		$vBindParams[] = & $vKeyword1;

// 		$vWhere .= " b.language = ?";
// 		$vBindLetters .= "s";
// 		$vBindParams[] = & $_SESSION['SessionGrafLanguage'];

		$vWindowValues = General::echoWalkingWindowTopSearch($pConn, $per_page, $vPageNo, $vUrl, "b.id", "books_search b", $vWhere, $vBindLetters, $vBindParams);
		$vResults = MysqlQuery::getBooks($pConn, $vWhere, $vOrder, $vBindLetters,  $vBindParams, $vWindowValues[4]);
}
else if($vType == "m"){//menu
		$vOutPrintValue = 0;
		$vBindLetters .= "i";
		$vBindParams[] = & $vOutPrintValue;
		$vWhere = "WHERE  b.out_of_print = ? and ";

		$vWhere .= " b.sub_category = ?";
		$vOrder = " ORDER BY ".urldecode($pSearchData['sort']);
		$vValue = $pSearchData['subcat_id'];
		$vBindLetters .= "i";
		$vBindParams[] = & $vValue;

		$vWindowValues = General::echoWalkingWindowTopSearch($pConn, $per_page, $vPageNo, $vUrl, "id", "books b", $vWhere, $vBindLetters, $vBindParams);
		$vResults = MysqlQuery::getBooks($pConn, $vWhere, $vOrder, $vBindLetters,  $vBindParams, $vWindowValues[4]);
}
else if($vType == "c"){//category
		$vOutPrintValue = 0;
		$vBindLetters .= "i";
		$vBindParams[] = & $vOutPrintValue;
		$vWhere = "WHERE  b.out_of_print = ? and ";

		$vWhere .= " b.category = ?";
		$vOrder = " ORDER BY ".urldecode($pSearchData['sort']);
		$vValue = $pSearchData['cat_id'];
		$vBindLetters .= "i";
		$vBindParams[] = & $vValue;

		$vWindowValues = General::echoWalkingWindowTopSearch($pConn, $per_page, $vPageNo, $vUrl, "id", "books b", $vWhere, $vBindLetters, $vBindParams);
		$vResults = MysqlQuery::getBooks($pConn, $vWhere, $vOrder, $vBindLetters,  $vBindParams, $vWindowValues[4]);
}
else if($vType == "b"){
		$vWhere = "WHERE b.id = ?";
		$vOrder = "";
		$vValue = $pSearchData['id'];
		$vBindParams[] = & $vValue;
		$vBindLetters .= "i";

		$vWindowValues = General::echoWalkingWindowTopSearch($pConn, $per_page, $vPageNo, $vUrl, "id", "books b", $vWhere, $vBindLetters, $vBindParams);
		$vResults = MysqlQuery::getBooks($pConn, $vWhere, $vOrder, $vBindLetters,  $vBindParams, $vWindowValues[4]);
}
else if ($vType == "Moleskine"){
		$vWhere = "WHERE b.id in (select id from books where author = ?) AND b.out_of_print = ?";
		$vOrder = " ORDER BY ".urldecode($pSearchData['sort']);
		$vValue = "Moleskine";
		$vBindParams[] = & $vValue;
		$vBindLetters .= "s";
		$vOutPrintValue = 0;
		$vBindLetters .= "i";
		$vBindParams[] = & $vOutPrintValue;

		$vWindowValues = General::echoWalkingWindowTopSearch($pConn, $per_page, $vPageNo, $vUrl, "id", "books b", $vWhere, $vBindLetters, $vBindParams);
		$vResults = MysqlQuery::getBooks($pConn, $vWhere, $vOrder, $vBindLetters,  $vBindParams, $vWindowValues[4]);
}
else if ($vType == "Skryfbehoeftes" || $vType == "Stationery"){
		$vWhere = "WHERE b.sub_category = ?";
		$vOrder = "ORDER BY b.title ASC";
		$vValue = 164;//Pens
		$vBindParams[] = & $vValue;
		$vBindLetters .= "i";

		$vWindowValues = General::echoWalkingWindowTopSearch($pConn, $per_page, $vPageNo, $vUrl, "id", "books b", $vWhere, $vBindLetters, $vBindParams);
		$vResults = MysqlQuery::getBooks($pConn, $vWhere, $vOrder, $vBindLetters,  $vBindParams, $vWindowValues[4]);
}
else if ($vType == "book-id"){
		$vWhere = "WHERE b.id = ?";
		$vOrder = "";
		$vValue = $pSearchData['id'];
		$vBindParams[] = & $vValue;
		$vBindLetters .= "i";

		$vWindowValues = General::echoWalkingWindowTopSearch($pConn, $per_page, $vPageNo, $vUrl, "id", "books b", $vWhere, $vBindLetters, $vBindParams);
		$vResults = MysqlQuery::getBooks($pConn, $vWhere, $vOrder, $vBindLetters,  $vBindParams, $vWindowValues[4]);
}
else if($vType == 'book-isbn'){
		$vWhere = "WHERE b.isbn = ?";
		$vOrder = "";
		$vValue = $pSearchData['isbn'];
		$vBindParams[] = & $vValue;
		$vBindLetters .= "s";

		$vWindowValues = General::echoWalkingWindowTopSearch($pConn, $per_page, $vPageNo, $vUrl, "id", "books b", $vWhere, $vBindLetters, $vBindParams);
		$vResults = MysqlQuery::getBooks($pConn, $vWhere, $vOrder, $vBindLetters,  $vBindParams, $vWindowValues[4]);
}