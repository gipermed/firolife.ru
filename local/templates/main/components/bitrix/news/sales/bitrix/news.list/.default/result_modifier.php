<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if ($arResult["ITEMS"]){
    $end_new_period = date("d.m.Y", strtotime("+1 month", strtotime(date('d.m.Y'))));
    $arResult['SECTION']['NEW'] = [];
    $arResult['SECTION']['ACTIVE'] = [];
    $arResult['SECTION']['END'] = [];
    foreach($arResult["ITEMS"] as $key=>$arItem){
//        if($arItem['PREVIEW_PICTURE']){
//            $file = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'], array('width'=>175, 'height'=>240), BX_RESIZE_IMAGE_PROPORTIONAL, true);
//            $arItem['PREVIEW_PICTURE'] = $file;
//        }

        if($arItem['ACTIVE_FROM'] && strtotime(date("d.m.Y", strtotime("+1 month", strtotime($arItem['ACTIVE_FROM'])))) > strtotime(date('d.m.Y')) && strtotime($arItem['PROPERTIES']['DATE']['VALUE']) > strtotime(date('d.m.Y'))){
            $arResult['SECTION']['NEW'][] = $arItem;
        }elseif($arItem['PROPERTIES']['DATE']['VALUE'] && strtotime($arItem['PROPERTIES']['DATE']['VALUE']) > strtotime(date('d.m.Y'))){
            $arResult['SECTION']['ACTIVE'][] = $arItem;
        }else{
            $arResult['SECTION']['END'][] = $arItem;
        }
    }
}