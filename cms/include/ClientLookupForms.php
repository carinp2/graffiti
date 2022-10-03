<?php

		$vString .="<div class=\"row info-detail hidden-input book-lookup-border\" id=\"clientSearchDiv\">";
			$vString .= "<h4>Tik kli&#235;nt naam, van of epos in:</h4>";
				$vString .="<form name=\"clientForm2\" id=\"clientForm2\" action=\"index.php\" method=\"post\">";
					$vString .= "<div>";
						$vString .= General::returnInput($pConn, "text", "client", "client", "", 40, 100, "", "", "", "", "");
					$vString .= "</div>";
					$vString .= "<input type=\"hidden\" name=\"type\" value=\"searchClient\">";
					$vString .= "<input type=\"hidden\" name=\"client_id\" value=\"-1\">";
					$vString .= "<input type=\"hidden\" name=\"page\" value=\"clients\">";
					$vString .= "<input type=\"submit\" id=\"clientSubmit2\" value=\"Lys kli&#235;nte\">";
				$vString .= "</form>";
		$vString .= "</div>";

?>