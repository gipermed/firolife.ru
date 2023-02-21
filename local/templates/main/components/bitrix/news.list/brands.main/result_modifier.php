<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if ($arResult["ITEMS"]){
    foreach($arResult["ITEMS"] as $key=>$arItem){
        if($arItem['PREVIEW_PICTURE']){
            $file = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'], array('width'=>155, 'height'=>88), BX_RESIZE_IMAGE_PROPORTIONAL, true);
            $arResult["ITEMS"][$key]['PREVIEW_PICTURE'] = $file;
        }
    }
}