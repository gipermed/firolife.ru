<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

//delayed function must return a string
if (empty($arResult))
    return "";

$content = '<ul class="breadcrumbs">';
foreach ($arResult as $index => $item) {
//	$content.=$item['TITLE'];
    if (!empty($item['LINK']) && $index !== count($arResult) - 1) {
        $content .= "<li><a href=\"{$item['LINK']}\">{$item['TITLE']}</a></li>";
    } else {
        $content .= "<li>{$item['TITLE']}</li>";
    }
}
$content .= '</ul>';

return $content;
