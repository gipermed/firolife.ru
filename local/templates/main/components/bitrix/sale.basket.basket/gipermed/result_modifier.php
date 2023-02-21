<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

if($arResult['BASKET_ITEM_RENDER_DATA']){
    foreach($arResult['BASKET_ITEM_RENDER_DATA'] as $key=>$item){
        $allProducts[] = $item['PRODUCT_ID'];
        $allKeys[$item['PRODUCT_ID']] = $key;
    }
    if($allProducts){
        $arSelect = Array("ID", "NAME", "PROPERTY_CML2_ARTICLE");
        $arFilter = Array("ID"=>$allProducts, "ACTIVE"=>"Y");
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
        while($ob = $res->Fetch()) {
            $arResult['BASKET_ITEM_RENDER_DATA'][$allKeys[$ob['ID']]]['PRODUCT_ARTICLE'] = $ob['PROPERTY_CML2_ARTICLE_VALUE'];
        }
    }
}
