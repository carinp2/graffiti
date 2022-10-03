<?php
$vKeyword = str_replace($_SESSION['SessionNamCharactersToReplace'], $_SESSION['SessionNamReplaceCharacters'], strip_tags(stripslashes($pSearchText)));
$vKeywordWild = str_replace($_SESSION['SessionNamCharactersToReplace'], $_SESSION['SessionNamReplaceCharacters'], strip_tags(str_replace(" ", "%", $pSearchText)));

$the_keyword = trim(strtolower($vKeyword));
$the_keyword_wild = trim(strtolower($vKeywordWild));

// Article
$vWhere .= "LOWER(a.heading) LIKE ? OR ";
$bindLetter .= "s";
$vKeyword1 = "%{$the_keyword}%";
$bindParams[] = & $vKeyword1;
$vWhere .= "LOWER(a.heading) LIKE ? OR ";
$bindLetter .= "s";
$vKeyword2 = "%{$the_keyword_wild}%";
$bindParams[] = & $vKeyword2;

$vWhere .= "LOWER(a.introduction) LIKE ? OR ";
$bindLetter .= "s";
$vKeyword3 = "%{$the_keyword}%";
$bindParams[] = & $vKeyword3;
$vWhere .= "LOWER(a.introduction) LIKE ? OR ";
$bindLetter .= "s";
$vKeyword4 = "%{$the_keyword_wild}%";
$bindParams[] = & $vKeyword4;

$vWhere .= "LOWER(a.content) LIKE ? OR ";
$bindLetter .= "s";
$vKeyword5 = "%{$the_keyword}%";
$bindParams[] = & $vKeyword5;
$vWhere .= "LOWER(a.content) LIKE ? OR ";
$bindLetter .= "s";
$vKeyword6 = "%{$the_keyword_wild}%";
$bindParams[] = & $vKeyword6;

$vWhere .= "LOWER(p.firstname) LIKE ? OR ";
$bindLetter .= "s";
$vKeyword7 = "%{$the_keyword}%";
$bindParams[] = & $vKeyword7;
$vWhere .= "LOWER(p.firstname) LIKE ? OR ";
$bindLetter .= "s";
$vKeyword8 = "%{$the_keyword_wild}%";
$bindParams[] = & $vKeyword8;

$vWhere .= "LOWER(p.lastname) LIKE ? OR ";
$bindLetter .= "s";
$vKeyword9 = "%{$the_keyword}%";
$bindParams[] = & $vKeyword9;
$vWhere .= "LOWER(p.lastname) LIKE ? OR ";
$bindLetter .= "s";
$vKeyword10 = "%{$the_keyword_wild}%";
$bindParams[] = & $vKeyword10;

$vWhere .= "LOWER(concat(p.firstname, p.lastname)) LIKE ? OR ";
$bindLetter .= "s";
$vKeyword11 = "%{$the_keyword}%";
$bindParams[] = & $vKeyword11;
$vWhere .= "LOWER(concat(p.firstname, p.lastname)) LIKE ? ";
$bindLetter .= "s";
$vKeyword12 = "%{$the_keyword_wild}%";
$bindParams[] = & $vKeyword12;

// Image
$vImagesWhere = "LOWER(pi.description) LIKE ? OR ";
$bindLetter .= "s";
$vKeyword13 = "%{$the_keyword}%";
$bindParams[] = & $vKeyword13;
$vImagesWhere .= "LOWER(pi.description) LIKE ? OR ";
$bindLetter .= "s";
$vKeyword14 = "%{$the_keyword_wild}%";
$bindParams[] = & $vKeyword14;

$vImagesWhere .= "LOWER(pi.heading) LIKE ? OR ";
$bindLetter .= "s";
$vKeyword15 = "%{$the_keyword}%";
$bindParams[] = & $vKeyword15;
$vImagesWhere .= "LOWER(pi.heading) LIKE ?";
$bindLetter .= "s";
$vKeyword16 = "%{$the_keyword_wild}%";
$bindParams[] = & $vKeyword16;

$vOrderBy = "ORDER BY datetime DESC";
?>