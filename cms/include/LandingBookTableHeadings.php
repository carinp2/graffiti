<?php
if($pData['type'] == "new" || $pData['type']  == "nuut" || $pData['type']  == "nuut-c"){
		$vString .= "<th>Nuut Posisie</th>";
		$vString .= "<th>Nuut</th>";
		$vString .= "<th>Binnekort afslag<br>&amp; Posisie</th>";
		$vString .= "<th>Topverkoper<br>&amp; Posisie</th>";
		$vString .= "<th>Winskopie&nbsp;&nbsp;<br>Prys</th>";
		$vString .= "<th></th>";
		$vString .= "<th>Titel</th>";
		$vString .= "<th>ISBN</th>";
		$vString .= "<th><span class=\"green\">Outeur</span><br><span class=\"red\">Illustreerder</span><br><span class=\"dblue\">Vertaler</span></th>";
		$vString .= " <th>Kategorie<i class=\"fa fa-caret-right fa-lg red s-space-left s-space-right\" aria-hidden=\"true\"></i>Sub-kategorie</th>";
		$vString .= "<th>Voorblad&nbsp;&nbsp;&nbsp;</th>";
		$vString .= "<th>Prys<br>Kosprys<br><span class=\"green\">Auto&nbsp;Afslag</span></th>";
		$vString .= "<th>Pub datum</th>";
		$vString .= "<th>Uit druk&nbsp;&nbsp;</th>";
		$vString .= "<th>In voorraad&nbsp;&nbsp;</th>";
		$vString .= "<th>Uitgewer</th>";
		$vString .= "<th>Taal&nbsp;&nbsp;&nbsp;</th>";
		$vString .= "<th class=\"hidden-input\">Boek ID</th>";
}
else if($pData['type']  == "soon" || $pData['type']  == "soon_50"){
		$vString .= "<th>Binnekort Posisie</th>";
		$vString .= "<th>Binnekort</th>";
		$vString .= "<th>Binnekort Afslag</th>";
		$vString .= "<th>Nuut<br>&amp; Posisie</th>";
		$vString .= "<th>Topverkoper<br>&amp; Posisie</th>";
		$vString .= "<th>Winskopie&nbsp;&nbsp;<br>Prys</th>";
		$vString .= "<th></th>";
		$vString .= "<th>Titel</th>";
		$vString .= "<th>ISBN</th>";
		$vString .= "<th><span class=\"green\">Outeur</span><br><span class=\"red\">Illustreerder</span><br><span class=\"dblue\">Vertaler</span></th>";
		$vString .= " <th>Kategorie<i class=\"fa fa-caret-right fa-lg red s-space-left s-space-right\" aria-hidden=\"true\"></i>Sub-kategorie</th>";
		$vString .= "<th>Voorblad&nbsp;&nbsp;&nbsp;</th>";
		$vString .= "<th>Prys<br>Kosprys<br><span class=\"green\">Auto&nbsp;Afslag</span></th>";
		$vString .= "<th>Pub datum</th>";
		$vString .= "<th>Uit druk&nbsp;&nbsp;</th>";
		$vString .= "<th>In voorraad&nbsp;&nbsp;</th>";
		$vString .= "<th>Uitgewer</th>";
		$vString .= "<th>Taal&nbsp;&nbsp;&nbsp;</th>";
		$vString .= "<th class=\"hidden-input\">Boek ID</th>";
}
else if($pData['type'] == "top" || $pData['type'] == "best" || $pData['type'] == "top-c"){
		$vString .= "<th>Top Posisie</th>";
		$vString .= "<th>Topverkoper</th>";
		$vString .= "<th>Nuut &amp; Posisie</th>";
		$vString .= "<th>Binnekort afslag<br>&amp; Posisie</th>";
		$vString .= "<th>Winskopie&nbsp;&nbsp;<br>Prys</th>";
		$vString .= "<th></th>";
		$vString .= "<th>Titel</th>";
		$vString .= "<th>ISBN</th>";
		$vString .= "<th><span class=\"green\">Outeur</span><br><span class=\"red\">Illustreerder</span><br><span class=\"dblue\">Vertaler</span></th>";
		$vString .= " <th>Kategorie<i class=\"fa fa-caret-right fa-lg red s-space-left s-space-right\" aria-hidden=\"true\"></i>Sub-kategorie</th>";
		$vString .= "<th>Voorblad&nbsp;&nbsp;&nbsp;</th>";
		$vString .= "<th>Prys<br>Kosprys<br><span class=\"green\">Auto&nbsp;Afslag</span></th>";
		$vString .= "<th>Pub datum</th>";
		$vString .= "<th>Uit druk&nbsp;&nbsp;</th>";
		$vString .= "<th>In voorraad&nbsp;&nbsp;</th>";
		$vString .= "<th>Uitgewer</th>";
		$vString .= "<th>Taal&nbsp;&nbsp;&nbsp;</th>";
		$vString .= "<th class=\"hidden-input\">Boek ID</th>";
}
else if($pData['type'] == "specials"){
		$vString .= "<th>Winskopie<br>Posisie</th>";
		$vString .= "<th>Winskopie&nbsp;&nbsp;<br>Wins. Prys</th>";
		$vString .= "<th>Nuut &amp; Posisie</th>";
		$vString .= "<th>Binnekort afslag<br>&amp; Posisie</th>";
		$vString .= "<th>Topverkoper<br>&amp; Posisie</th>";
		$vString .= "<th></th>";
		$vString .= "<th>Titel</th>";
		$vString .= "<th>ISBN</th>";
		$vString .= "<th><span class=\"green\">Outeur</span><br><span class=\"red\">Illustreerder</span><br><span class=\"dblue\">Vertaler</span></th>";
		$vString .= " <th>Kategorie<i class=\"fa fa-caret-right fa-lg red s-space-left s-space-right\" aria-hidden=\"true\"></i>Sub-kategorie</th>";
		$vString .= "<th>Voorblad&nbsp;&nbsp;&nbsp;</th>";
		$vString .= "<th>Prys<br>Kosprys<br><span class=\"green\">Auto&nbsp;Afslag</span></th>";
		$vString .= "<th>Pub datum</th>";
		$vString .= "<th>Uit druk&nbsp;&nbsp;</th>";
		$vString .= "<th>In voorraad&nbsp;&nbsp;</th>";
		$vString .= "<th>Uitgewer</th>";
		$vString .= "<th>Taal&nbsp;&nbsp;&nbsp;</th>";
		$vString .= "<th class=\"hidden-input\">Boek ID</th>";
}