<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)die();

if($arResult['ITEMS']){
    foreach($arResult['ITEMS'] as $key=>$arItem){
        if(!in_array($arItem['ID'],DELIVERIES_IDS)){
            unset($arResult['ITEMS'][$key]);
        }
    }
}