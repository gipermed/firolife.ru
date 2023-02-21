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
CModule::IncludeModule('iblock');

$arrSections = [];
foreach($arResult['SECTIONS'] as $key => $arItem) {
	$arrSections[$arItem['ID']]=$arItem;
	if (in_array($arItem['SECTION_PAGE_URL'], $arSelected)) {
		$arResult['SELECTED_SECTION'] = $key;
	}

//    $arFilter = Array('IBLOCK_ID'=>IBLOCK_CATALOG_ID, 'GLOBAL_ACTIVE'=>'Y', 'ELEMENT_SUBSECTIONS'=>'Y', 'PROPERTY'=>Array('SRC'=>'https://%'));
//    $db_list = CIBlockSection::GetList(Array(), $arFilter, true, array('ID','NAME','CODE','SECTION_PAGE_URL'));
//    while($ar_result = $db_list->GetNext()) {

//    }

}
//pre($allSections);
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
$depth_level=$arResult["SECTIONS"][$arResult['SELECTED_SECTION']]["DEPTH_LEVEL"]+1;
if($arResult["SECTIONS"]){
    foreach($arResult["SECTIONS"] as $section){
        if($section['DEPTH_LEVEL'] == $depth_level){
            $arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM");
            $arFilter = Array("IBLOCK_ID"=>IBLOCK_CATALOG_ID, "SECTION_ID"=>$section['ID'], "INCLUDE_SUBSECTIONS"=>"Y", "ACTIVE"=>"Y", ">CATALOG_QUANTITY"=>0);
            $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), $arSelect);
            while($ob = $res->Fetch()) {
                if($ob){
                    $arResult['ELEMENTS_CNT'][str_replace('/','',$section['SECTION_PAGE_URL'])] = $section['ELEMENT_CNT'];
                }
            }
        }
    }
}
//pre($allSections);
?>