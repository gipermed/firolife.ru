<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$sCurDir = str_replace('files/imgs/', '', $APPLICATION->GetCurDir());
$arLink = explode('/', $sCurDir);
$arSelected = array();
$lastLink = '/';
foreach ($arLink as $value) {
	if ($value != '') {
		$lastLink .= $value.'/';
		$arSelected[] = $lastLink;
	}
}
var_dump( $sCurDir);
foreach($arResult as $key => $arItem) {

	if (in_array($arItem['LINK'], $arSelected)) $arResult[$key]['SELECTED'] = true;
}?>