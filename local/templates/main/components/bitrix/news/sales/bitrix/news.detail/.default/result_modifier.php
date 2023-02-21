<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if($arResult){
    if($arResult['DETAIL_PICTURE']){
//        $arResult['DETAIL_PICTURE'] = CFile::ResizeImageGet($arResult['DETAIL_PICTURE'], array('width'=>440, 'height'=>435), BX_RESIZE_IMAGE_PROPORTIONAL, true);
        $arResult['DETAIL_PICTURE'] = CFile::ResizeImageGet($arResult['DETAIL_PICTURE'], array('width'=>1440, 'height'=>435), BX_RESIZE_IMAGE_PROPORTIONAL, true);
    }

    global $APPLICATION;
    $cp = $this->__component;
    if (is_object($cp)) {
        $cp->arResult['ID'] = $arResult["ID"];
        $cp->arResult['RECOMMEND'] = $arResult["PROPERTIES"]["RECOMMEND"]["VALUE"];
        $cp->arResult['SALE_ID'] = $arResult["PROPERTIES"]["SALE_ID"]["VALUE"];
        $cp->SetResultCacheKeys(array('ID','RECOMMEND','SALE_ID'));
    }
}
