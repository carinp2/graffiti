<?php

		$vString .="<div class=\"row info-detail hidden-input book-lookup-border\" id=\"clientSearchForm\">";
			$vString .= "<h4>Tik kli&#235;nt naam of van in:</h4>";
			$vString .="<form name=\"clientSearchForm\" id=\"clientSearchForm\" action=\"index.php\" method=\"post\">";
				$vString .= "<div class=\"ui-widget\">";
					$vString .= General::returnInput($pConn, "text", "client-input", "client-input", "",40, 100, "", "", "required", "", "");
				$vString .= "</div>";
				$vString .= "<div class=\"message\">Minimum 3 karakters</div>";
			$vString .= "</form>";
		$vString .= "</div>";

		$vString .="<div class=\"row info-detail hidden-input book-lookup-border\" id=\"referenceSearchForm\">";
			$vString .= "<h4>Tik Verwysingsnommer in:</h4>";
			$vString .="<form name=\"referenceSearchForm\" id=\"referenceSearchForm\" action=\"index.php\" method=\"post\">";
				$vString .= "<div class=\"ui-widget\">";
					$vString .= General::returnInput($pConn, "text", "ref-input", "ref-input", "",40, 100, "", "", "required", "", "");
				$vString .= "</div>";
				$vString .= "<div class=\"message\">Minimum 3 karakters</div>";
			$vString .= "</form>";
		$vString .= "</div>";

		$vString .="<div class=\"row info-detail hidden-input book-lookup-border\" id=\"isbnSearchForm\">";
			$vString .= "<h4>Tik ISBN in:</h4>";
			$vString .="<form name=\"isbnSearchForm\" id=\"isbnSearchForm\" action=\"index.php\" method=\"post\">";
				$vString .= "<div class=\"ui-widget\">";
					$vString .= General::returnInput($pConn, "text", "isbn-input", "isbn-input", "", 20, 20, "", "", "required", "", "");
				$vString .= "</div>";
				$vString .= "<div class=\"message\">Minimum 3 karakters</div>";
			$vString .= "</form>";
		$vString .= "</div>";

?>