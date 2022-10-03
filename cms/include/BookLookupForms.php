<?php
	$vSubCategory = MysqlQuery::getAllActiveCategorySubCategories($pConn);//$vSubCategoryId, $vSubCategory
	$vSupplier = MysqlQuery::getStationarySuppliers($pConn);
		$vString .="<div class=\"row info-detail hidden-input book-lookup-border\" id=\"searchBookForm\">";
			$vString .= "<h4>Tik titel of ISBN in:</h4>";
			$vString .="<form name=\"bookSearchForm\" id=\"bookSearchForm\" action=\"index.php\" method=\"post\">";
				$vString .= "<div class=\"ui-widget\">";
					$vString .= General::returnInput($pConn, "text", "book-input", "book-input", "",40, 100, "", "", "required", "", "");
				$vString .= "</div>";
				$vString .= "<div class=\"message\">Minimum 9 karakters</div>";
			$vString .= "</form>";
		$vString .= "</div>";

		$vString .="<div class=\"row info-detail hidden-input book-lookup-border\" id=\"publisherBookForm\">";
				$vString .= "<h4>Tik die Uitgewer naam of Id in:</h4>";
				$vString .="<form name=\"publisherForm\" id=\"publisherForm\" action=\"index.php\" method=\"post\">";
					$vString .= "<div class=\"ui-widget\">";
						$vString .= General::returnInput($pConn, "text", "publisher-input", "publisher-input", "",40, 100, "", "", "required", "", "");
					$vString .= "</div>";
					$vString .= "<div class=\"message\">Minimum 3 karakters</div>";
				$vString .= "</form>";
		$vString .= "</div>";

		$vString .="<div class=\"row info-detail hidden-input book-lookup-border\" id=\"subCategoryBookForm\">";
				$vString .= "<h4>Kies die sub-kategorie:</h4>";
				$vString .="<form name=\"subcatForm\" id=\"subcatForm\" action=\"index.php\" method=\"post\">";
					$vString .= "<div>";
						$vString .= General::returnSelect($pConn, "", "sub-category", "sub-category", $vSubCategory[0], $vSubCategory[1], "", 3, "");
					$vString .= "</div>";
				$vString .= "</form>";
		$vString .= "</div>";

		$vString .="<div class=\"row info-detail hidden-input book-lookup-border\" id=\"authorBookForm\">";
				$vString .= "<h4>Tik die Outeur naam in:</h4>";
				$vString .="<form name=\"authorForm\" id=\"authorForm\" action=\"index.php\" method=\"post\">";
					$vString .= "<div class=\"ui-widget\">";
						$vString .= General::returnInput($pConn, "text", "author-input", "author-input", "",40, 100, "", "", "required", "", "");
					$vString .= "</div>";
					$vString .= "<div class=\"message\">Minimum 3 karakters</div>";
				$vString .= "</form>";
		$vString .= "</div>";

		$vString .="<div class=\"row info-detail hidden-input book-lookup-border\" id=\"searchStationaryForm\">";
				$vString .= "<h4>Select the supplier:</h4>";
				$vString .="<form name=\"supplierForm\" id=\"supplierForm\" action=\"index.php\" method=\"post\">";
					$vString .= "<div>";
						$vString .= General::returnSelect($pConn, "", "supplier_id", "supplier_id", $vSupplier[0], $vSupplier[1], "", 3, "");
					$vString .= "</div>";
				$vString .= "</form>";
		$vString .= "</div>";

		$vString .="<article><div class=\"row info-detail hidden-input book-lookup-border\" id=\"titleBookForm\">";
				$vString .= "<h4>Tik boek titel in:</h4>";
				$vString .="<form name=\"titleForm\" id=\"titleForm\" action=\"index.php\" method=\"post\">";
					$vString .= "<div>";
						$vString .= General::returnInput($pConn, "text", "id", "id", "", 40, 100, "", "", "", "", "");
					$vString .= "</div>";
					$vString .= "<input type=\"hidden\" name=\"type\" value=\"searchBookTitle\">";
					$vString .= "<input type=\"hidden\" name=\"page\" value=\"books\">";
					$vString .= "<input type=\"submit\" id=\"titleSubmit\" value=\"Lys boeke\">";
				$vString .= "</form>";
		$vString .= "</div></article>";

?>