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

$arrSections = [];
foreach($arResult['SECTIONS'] as $key => $arItem) {
	$arrSections[$arItem['ID']]=$arItem;
	if (in_array($arItem['SECTION_PAGE_URL'], $arSelected))
	{
		$arResult['SELECTED_SECTION'] = $key;
	}
}
$nav=[];
$selected_id=$arResult["SECTIONS"][$arResult['SELECTED_SECTION']]['ID'];
if($selected_id)
{
	$section_id=$arResult["SECTIONS"][$arResult['SELECTED_SECTION']]['ID'];
	$max_level = $arResult["SECTIONS"][$arResult['SELECTED_SECTION']]["DEPTH_LEVEL"];
	for ($i = 1; $i <= $max_level; $i++)
	{
		array_unshift($nav,$arrSections[$section_id]);
		//$nav[$section_id]=$arrSections[$section_id];
		$section_id=$arrSections[$section_id]['IBLOCK_SECTION_ID'];
	}
	$arResult["CATALOGS_CHAIN"]=$nav;
}

?>