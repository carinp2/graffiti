<?php

class BookPrice
{

    public function getBookPrice($vPriceDisplayType, $new, $top_seller, $vNewTopDiscountPrice, $vSpecialDiscountPrice, $vClientDiscountPrice, $special, $price, $soon_discount, $vSoonDiscountPrice, $vNormalPrice, $language){

        if ($vPriceDisplayType == "query") {
            //New or Topseller
            if ($new == 1 || $top_seller == 1 && ($vNewTopDiscountPrice < $vSpecialDiscountPrice) && $vNewTopDiscountPrice < $vClientDiscountPrice) {
                $vFinalPrice[] = $vNewTopDiscountPrice;
            } //on special and special price smaller than price and special price bigger than 0
            else if ($special == 1 && ($vSpecialDiscountPrice < $price && $vSpecialDiscountPrice < $vClientDiscountPrice)) {
                $vFinalPrice[] = $vSpecialDiscountPrice;
            }
            //Soon & soon discount and soon discount smaller than price and soon discount smaller than client discount
            //else if(($soon_discount == 1 && ($vSoonDiscountPrice < $price && $vSoonDiscountPrice < $vClientDiscountPrice)) || ($language == 'en' && $category != 7 && ($vSoonDiscountPrice < $price && $vSoonDiscountPrice < $vClientDiscountPrice)) || ($language == 'af' && $category != 6 && ($vSoonDiscountPrice < $price && $vSoonDiscountPrice < $vClientDiscountPrice))){
            else if (($soon_discount == 1 && ($vSoonDiscountPrice < $price && $vSoonDiscountPrice < $vClientDiscountPrice)) || ($language == 'en' && ($vSoonDiscountPrice < $price && $vSoonDiscountPrice < $vClientDiscountPrice)) || ($language == 'af' && ($vSoonDiscountPrice < $price && $vSoonDiscountPrice < $vClientDiscountPrice))) {
                $vFinalPrice[] = $vSoonDiscountPrice;
            } //Price bigger client discount price and special price bigger client special price
            else if ($vClientDiscountPrice < $price && $vClientDiscountPrice < $vSpecialDiscountPrice) {
                $vFinalPrice[] = $vClientDiscountPrice;
            } else {
                $vFinalPrice[] = $vNormalPrice;
            }
            //Price end
        } else if ($vPriceDisplayType == "home") {
            //New or Topseller
            if ($vResults[11][$x] == 1 || $vResults[13][$x] == 1 && ($vNewTopDiscountPrice < $vSpecialDiscountPrice) && $vNewTopDiscountPrice < $vClientDiscountPrice) {
                $vString .= "<span itemprop=\"offers\" itemscope itemtype=\"http://schema.org/Offer\">";
                $vString .= "<div class=\"thumb-book-discount discount-home\">R " . round($vResults[8][$x]) . "</div>";
                $vString .= "<div class=\"thumb-book-price price-home\">R <span  itemprop=\"price\">" . $vNewTopDiscountPrice . "</span></div><meta itemprop=\"priceCurrency\" content=\"ZAR\">";
                $vString .= "</span>";
            } //on special and special price smaller than price and special price bigger than 0
            else if ($vResults[12][$x] == 1 && ($vSpecialDiscountPrice < $vResults[8][$x] && $vSpecialDiscountPrice < $vClientDiscountPrice)) {
                $vString .= "<span itemprop=\"offers\" itemscope itemtype=\"http://schema.org/Offer\">";
                $vString .= "<div class=\"thumb-book-discount discount-home\">R " . round($vResults[8][$x]) . "</div>";
                $vString .= "<div class=\"thumb-book-price price-home\">R <span itemprop=\"price\">" . $vSpecialDiscountPrice . "</span></div><meta itemprop=\"priceCurrency\" content=\"ZAR\">";
                $vString .= "</span>";
            }
            //Soon & soon discount and soon discount smaller than price and soon discount smaller than client discount
            //else if(($vResults[32][$x] == 1 && ($vSoonDiscountPrice < $vResults[8][$x] && $vSoonDiscountPrice < $vClientDiscountPrice)) || ($vResults[18][$x] == 'en' && $vResults[2][$x] != 7 && ($vSoonDiscountPrice < $vResults[8][$x] && $vSoonDiscountPrice < $vClientDiscountPrice)) || ($vResults[18][$x] == 'af' && $vResults[2][$x] != 6 && ($vSoonDiscountPrice < $vResults[8][$x] && $vSoonDiscountPrice < $vClientDiscountPrice))){
            else if (($vResults[32][$x] == 1 && ($vSoonDiscountPrice < $vResults[8][$x] && $vSoonDiscountPrice < $vClientDiscountPrice)) || ($vResults[18][$x] == 'en' && ($vSoonDiscountPrice < $vResults[8][$x] && $vSoonDiscountPrice < $vClientDiscountPrice)) || ($vResults[18][$x] == 'af' && ($vSoonDiscountPrice < $vResults[8][$x] && $vSoonDiscountPrice < $vClientDiscountPrice))) {
                $vString .= "<span itemprop=\"offers\" itemscope itemtype=\"http://schema.org/Offer\">";
                $vString .= "<div class=\"thumb-book-discount discount-home\">R " . round($vResults[8][$x]) . "</div>";
                $vString .= "<div class=\"thumb-book-price price-home\">R <span itemprop=\"price\">" . $vSoonDiscountPrice . "</span></div><meta itemprop=\"priceCurrency\" content=\"ZAR\">";
                $vString .= "</span>";
            } //Price bigger client discount price and special price bigger client special price
            else if ($vClientDiscountPrice < $vResults[8][$x] && $vClientDiscountPrice < $vSpecialDiscountPrice) {
                $vString .= "<span itemprop=\"offers\" itemscope itemtype=\"http://schema.org/Offer\">";
                $vString .= "<div class=\"thumb-book-discount discount-home\">R " . round($vResults[8][$x]) . "</div>";
                $vString .= "<div class=\"thumb-book-price price-home\">R <span itemprop=\"price\">" . $vClientDiscountPrice . "</span></div><meta itemprop=\"priceCurrency\" content=\"ZAR\">";
                $vString .= "</span>";
            } else {
                $vString .= "<span itemprop=\"offers\" itemscope itemtype=\"http://schema.org/Offer\">";
                $vSring .= "<div class=\"thumb-book-price price-home\">R <span itemprop=\"price\">" . round($vResults[8][$x]) . "</span></div>";
                $vString .= "<div class=\"thumb-book-price price-home\"></div><meta itemprop=\"priceCurrency\" content=\"ZAR\">";
                $vString .= "</span>";
            }
        } else if ($vPriceDisplayType == "book") {
            //New or Topseller
            if ($vResults[11][$x] == 1 || $vResults[13][$x] == 1 && ($vNewTopDiscountPrice < $vSpecialDiscountPrice) && $vNewTopDiscountPrice < $vClientDiscountPrice) {
                $vString .= "<span  itemprop=\"offers\" itemscope itemtype=\"http://schema.org/Offer\">";
                $vString .= "<div class=\"thumb-book-discount discount\">R " . round($vResults[8][$x]) . "</div>";
                $vString .= "<div class=\"thumb-book-price price\">R <span itemprop=\"price\">" . $vNewTopDiscountPrice . "</span>";
                $vString .= "<span class=\"green text-small-normal\"><i class=\"fa fa-check fa-lg icon-spacing\" aria-hidden=\"true\"></i>" . MysqlQuery::getText($pConn, 32)/*Jy spaar*/ . " R " . round($vResults[8][$x] - $vNewTopDiscountPrice) . "</span></div><meta itemprop=\"priceCurrency\" content=\"ZAR\">";
                $vString .= "</span>";
            } //on special and special price smaller than price and special price bigger than 0
            else if ($vResults[12][$x] == 1 && ($vSpecialDiscountPrice < $vResults[8][$x] && $vSpecialDiscountPrice < $vClientDiscountPrice)) {
                $vString .= "<span  itemprop=\"offers\" itemscope itemtype=\"http://schema.org/Offer\">";
                $vString .= "<div class=\"thumb-book-discount discount\">R " . round($vResults[8][$x]) . "</div>";
                $vString .= "<div class=\"thumb-book-price price\">R <span itemprop=\"price\">" . $vSpecialDiscountPrice . "</span>";
                $vString .= "<span class=\"green text-small-normal\"><i class=\"fa fa-check fa-lg icon-spacing\" aria-hidden=\"true\"></i>" . MysqlQuery::getText($pConn, 32)/*Jy spaar*/ . " R " . round($vResults[8][$x] - $vSpecialDiscountPrice) . "</span></div><meta itemprop=\"priceCurrency\" content=\"ZAR\">";
                $vString .= "</span>";
            }
            //Soon & soon discount and soon discount smaller than price and soon discount smaller than client discount || All en books except Novels & Educational
            //else if(($vResults[32][$x] == 1 && ($vSoonDiscountPrice < $vResults[8][$x] && $vSoonDiscountPrice < $vClientDiscountPrice)) || ($vResults[18][$x] == 'en' && $vResults[2][$x] != 7 && ($vSoonDiscountPrice < $vResults[8][$x] && $vSoonDiscountPrice < $vClientDiscountPrice)) || ($vResults[18][$x] == 'af' && $vResults[2][$x] != 6 && ($vSoonDiscountPrice < $vResults[8][$x] && $vSoonDiscountPrice < $vClientDiscountPrice))){
            else if (($vResults[32][$x] == 1 && ($vSoonDiscountPrice < $vResults[8][$x] && $vSoonDiscountPrice < $vClientDiscountPrice)) || ($vResults[18][$x] == 'en' && ($vSoonDiscountPrice < $vResults[8][$x] && $vSoonDiscountPrice < $vClientDiscountPrice)) || ($vResults[18][$x] == 'af' && ($vSoonDiscountPrice < $vResults[8][$x] && $vSoonDiscountPrice < $vClientDiscountPrice))) {
                $vString .= "<span  itemprop=\"offers\" itemscope itemtype=\"http://schema.org/Offer\">";
                $vString .= "<div class=\"thumb-book-discount discount\">R " . round($vResults[8][$x]) . "</div>";
                $vString .= "<div class=\"thumb-book-price price\">R <span itemprop=\"price\">" . $vSoonDiscountPrice . "</span>";
                $vString .= "<span class=\"green text-small-normal\"><i class=\"fa fa-check fa-lg icon-spacing\" aria-hidden=\"true\"></i>" . MysqlQuery::getText($pConn, 32)/*Jy spaar*/ . " R " . round($vResults[8][$x] - $vSoonDiscountPrice) . "</span></div><meta itemprop=\"priceCurrency\" content=\"ZAR\">";
                $vString .= "</span>";
            } //Price bigger client discount price and special price bigger client special price
            else if ($vClientDiscountPrice < $vResults[8][$x] && $vClientDiscountPrice < $vSpecialDiscountPrice) {
                $vString .= "<span  itemprop=\"offers\" itemscope itemtype=\"http://schema.org/Offer\">";
                $vString .= "<div class=\"thumb-book-discount discount\">R " . round($vResults[8][$x]) . "</div>";
                $vString .= "<div class=\"thumb-book-price price\">R <span itemprop=\"price\">" . $vClientDiscountPrice . "</span>";
                $vString .= "<span class=\"green text-small-normal\"><i class=\"fa fa-check fa-lg icon-spacing\" aria-hidden=\"true\"></i>" . MysqlQuery::getText($pConn, 32)/*Jy spaar*/ . " R " . round($vResults[8][$x] - $vClientDiscountPrice) . "</span></div><meta itemprop=\"priceCurrency\" content=\"ZAR\">";
                $vString .= "</span>";
            } else {
                $vString .= "<span itemprop=\"offers\" itemscope itemtype=\"http://schema.org/Offer\">";
                $vString .= "<div class=\"thumb-book-price price\">R <span itemprop=\"price\">" . round($vResults[8][$x]) . "</span></div>";
                $vString .= "<div class=\"thumb-book-price price\"></div><meta itemprop=\"priceCurrency\" content=\"ZAR\">";
                $vString .= "</span>";
            }
            //Price end
        } else if ($vPriceDisplayType == "export") {
            //New or Topseller
            if ($vResults[11][$x] == 1 || $vResults[13][$x] == 1 && ($vNewTopDiscountPrice < $vSpecialDiscountPrice) && $vNewTopDiscountPrice < $vClientDiscountPrice) {
                $vFinalPrice = $vNewTopDiscountPrice;
            } //on special and special price smaller than price and special price bigger than 0
            else if ($vResults[12][$x] == 1 && ($vSpecialDiscountPrice < $vResults[8][$x] && $vSpecialDiscountPrice < $vClientDiscountPrice)) {
                $vFinalPrice = $vSpecialDiscountPrice;
            }
            //Soon & soon discount and soon discount smaller than price and soon discount smaller than client discount
            //else if(($vResults[32][$x] == 1 && ($vSoonDiscountPrice < $vResults[8][$x] && $vSoonDiscountPrice < $vClientDiscountPrice)) || ($vResults[18][$x] == 'en' && $vResults[2][$x] != 7 && ($vSoonDiscountPrice < $vResults[8][$x] && $vSoonDiscountPrice < $vClientDiscountPrice)) || ($vResults[18][$x] == 'af' && $vResults[2][$x] != 6 && ($vSoonDiscountPrice < $vResults[8][$x] && $vSoonDiscountPrice < $vClientDiscountPrice))){
            else if (($vResults[32][$x] == 1 && ($vSoonDiscountPrice < $vResults[8][$x] && $vSoonDiscountPrice < $vClientDiscountPrice)) || ($vResults[18][$x] == 'en' && ($vSoonDiscountPrice < $vResults[8][$x] && $vSoonDiscountPrice < $vClientDiscountPrice)) || ($vResults[18][$x] == 'af' && ($vSoonDiscountPrice < $vResults[8][$x] && $vSoonDiscountPrice < $vClientDiscountPrice))) {
                $vFinalPrice = $vSoonDiscountPrice;
            } //Price bigger client discount price and special price bigger client special price
            else if ($vClientDiscountPrice < $vResults[8][$x] && $vClientDiscountPrice < $vSpecialDiscountPrice) {
                $vFinalPrice = $vClientDiscountPrice;
            } else {
                $vFinalPrice = $vNormalPrice;
            }
            //Price end
        }

    }

}