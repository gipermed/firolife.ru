<?php check_prolog();
$this->setFrameMode(true);
?>
<?php $elementId = $APPLICATION->IncludeComponent(
    "bitrix:news.detail",
    "",
    array(
        "DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
        "DISPLAY_NAME" => $arParams["DISPLAY_NAME"],
        "DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
        "DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "FIELD_CODE" => $arParams["DETAIL_FIELD_CODE"],
        "PROPERTY_CODE" => $arParams["DETAIL_PROPERTY_CODE"],
        "DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["detail"],
        "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
        "META_KEYWORDS" => $arParams["META_KEYWORDS"],
        "META_DESCRIPTION" => $arParams["META_DESCRIPTION"],
        "BROWSER_TITLE" => $arParams["BROWSER_TITLE"],
        "SET_CANONICAL_URL" => $arParams["DETAIL_SET_CANONICAL_URL"],
        "DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
        "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
        "SET_TITLE" => $arParams["SET_TITLE"],
        "MESSAGE_404" => $arParams["MESSAGE_404"],
        "SET_STATUS_404" => $arParams["SET_STATUS_404"],
        "SHOW_404" => $arParams["SHOW_404"],
        "FILE_404" => $arParams["FILE_404"],
        "INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
        "ADD_SECTIONS_CHAIN" => $arParams["ADD_SECTIONS_CHAIN"],
        "ACTIVE_DATE_FORMAT" => $arParams["DETAIL_ACTIVE_DATE_FORMAT"],
        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
        "CACHE_TIME" => $arParams["CACHE_TIME"],
        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
        "USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
        "GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
        "DISPLAY_TOP_PAGER" => $arParams["DETAIL_DISPLAY_TOP_PAGER"],
        "DISPLAY_BOTTOM_PAGER" => $arParams["DETAIL_DISPLAY_BOTTOM_PAGER"],
        "PAGER_TITLE" => $arParams["DETAIL_PAGER_TITLE"],
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => $arParams["DETAIL_PAGER_TEMPLATE"],
        "PAGER_SHOW_ALL" => $arParams["DETAIL_PAGER_SHOW_ALL"],
        "CHECK_DATES" => $arParams["CHECK_DATES"],
        "ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
        "ELEMENT_CODE" => $arResult["VARIABLES"]["ELEMENT_CODE"],
        "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
        "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
        "IBLOCK_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["news"],
        "USE_SHARE" => $arParams["USE_SHARE"],
        "SHARE_HIDE" => $arParams["SHARE_HIDE"],
        "SHARE_TEMPLATE" => $arParams["SHARE_TEMPLATE"],
        "SHARE_HANDLERS" => $arParams["SHARE_HANDLERS"],
        "SHARE_SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
        "SHARE_SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
        "ADD_ELEMENT_CHAIN" => ($arParams["ADD_ELEMENT_CHAIN"] ?? ''),
        'STRICT_SECTION_CHECK' => ($arParams['STRICT_SECTION_CHECK'] ?? ''),
    ),
    $component
); ?>
<?if($elementId):
    $arSelect = Array("ID", "NAME");
    $arFilter = Array("ID"=>$elementId, "ACTIVE"=>"Y");
    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
    while($ob = $res->Fetch()) {
        $brandName = $ob['NAME'];
    }
    if($brandName){
        $arSelect = Array("ID", "NAME", "IBLOCK_SECTION_ID", "DETAIL_PAGE_URL", "PROPERTY_NAIMENOVANIE_DLYA_SAYTA", "PROPERTY_PROIZVODITEL");
        $arFilter = Array("IBLOCK_ID"=>IBLOCK_CATALOG_ID, "ACTIVE"=>"Y", "PROPERTY_PROIZVODITEL_VALUE"=>$brandName);
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array('nPageSize'=>1000), $arSelect);
        while($ob = $res->GetNext()) {
            if($ob['PROPERTY_PROIZVODITEL_VALUE']){
                $property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>IBLOCK_CATALOG_ID, "CODE"=>"PROIZVODITEL", "VALUE"=>$ob['PROPERTY_PROIZVODITEL_VALUE']));
                while($enum_fields = $property_enums->GetNext()) {
                    $ob['PROIZVODITEL_XML_ID'] = $enum_fields['XML_ID'];
                }
            }

            if($ob['IBLOCK_SECTION_ID']){
                $list = CIBlockSection::GetNavChain(false, $ob['IBLOCK_SECTION_ID'], ['ID', 'NAME', 'DEPTH_LEVEL', 'SECTION_PAGE_URL'], true);
                foreach ($list as $v){
                    $v['PROIZVODITEL_XML_ID'] = $ob['PROIZVODITEL_XML_ID'];
                    $v['SECTION_PAGE_URL'] = CIBlock::ReplaceDetailUrl($v['SECTION_PAGE_URL'], $v, true, 'S');
                    if($v['DEPTH_LEVEL'] > 1){
                        if($v['DEPTH_LEVEL'] == 2){
                            $first_lvl = $v['ID'];
                            $allSections[$v['ID']]['INFO'] = $v;
                        }elseif($v['DEPTH_LEVEL'] == 3){
                            $second_lvl = $v['ID'];
                            $allSections[$v['IBLOCK_SECTION_ID']]['SUB'][$v['ID']]['INFO'] = $v;
                        }elseif($v['DEPTH_LEVEL'] == 4){
                            $allSections[$first_lvl]['SUB'][$v['IBLOCK_SECTION_ID']]['SUB'][$v['ID']]['INFO'] = $v;
                        }elseif($v['DEPTH_LEVEL'] == 5){
                            $allSections[$first_lvl]['SUB'][$second_lvl]['SUB'][$v['IBLOCK_SECTION_ID']]['SUB'][$v['ID']]['INFO'] = $v;
                        }
                    }
                }
            }
            $brandsProduct[] = $ob;
        }
    }
    if($brandsProduct):?>
        <div class="brands-tabs">
            <div class="mobile-brand-title">Продукция данного производителя</div>
            <div class="brands-tabs-toggle">
                <div class="brands-tabs__item active" data-type="tiles">Карточки товаров</div>
                <div class="brands-tabs__item" data-type="list">Перечень товаров</div>
            </div>
            <div class="brands-tabs-content">
                <div class="brands-tabs-block active" data-type="tiles" style="display: block">

                    <div class="catalog">
                        <div class="catalog-sidebar">
                            <?/*div class="catalog-head">
                                <div class="catalog-sort">
                                    <div class="catalog-sort-title">Сортировать:</div>
                                    <ul class="catalog-sort-links">
                                        <li>
                                            <a href="/catalog/vse-tovary/krasota-i-fitnes/?sort=price&amp;order=desc" class="catalog-sort-link catalog-sort-link-arrow active">
                                                <span>Цена</span>
                                                <i>
                                                    <svg width="24" height="24"><use xlink:href="#icon-arrow-down"></use></svg>
                                                </i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/catalog/vse-tovary/krasota-i-fitnes/?sort=name&amp;order=desc" class="catalog-sort-link catalog-sort-link-letter">
                                                <span>Название</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/catalog/vse-tovary/krasota-i-fitnes/?sort=rating&amp;order=desc" class="catalog-sort-link catalog-sort-link-arrow">
                                                <span>Рейтинг</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div*/?>
                            <div class="catalog-filter-open-wrapp visible-tablet">
                                <a href="#" class="catalog-filter-open btn">Фильтр</a>
                            </div>
                            <div class="catalog-filter">
                                <div class="catalog-filter-head visible-tablet">
                                    <div class="container">
                                        <div class="catalog-filter-head-title">Фильтр</div>
                                        <a href="#" class="catalog-filter-close" aria-label="Закрыть">
                                            <svg width="24" height="24"><use xlink:href="#icon-close"></use></svg>
                                        </a>
                                    </div>
                                </div>
                                <div class="container">
                                    <form method="get" action="#" class="smart-filter-form">
                                        <div class="row">
                                            <?/*div class="col-lg-12 smart-filter-parameters-box bx-active">
                                                <div class="smart-filter-block" data-role="bx_filter_block">
                                                    <div class="smart-filter-parameters-box-container">
                                                        <div class="smart-filter-input-group-checkbox-list">
                                                            <?foreach($allSections as $section):?>
                                                                <a href="<?if($_REQUEST['section'] == $section['INFO']['ID']):?><?=$APPLICATION->GetCurPage();?><?else:?><?=$APPLICATION->GetCurPage();?>?section=<?=$section['INFO']['ID']?><?endif;?>" class="form-group form-check mb-1">
                                                                    <input<?if($_REQUEST['section'] == $section['INFO']['ID']):?> checked<?endif;?> type="checkbox" value="Y" name="brands-fil[]" id="brands-fil-<?=$section['INFO']['ID']?>" class="form-check-input">
                                                                    <span class="smart-filter-checkbox-text form-check-label" for="brands-fil-<?=$section['INFO']['ID']?>">
                                                                        <?=$section['INFO']['NAME']?>
                                                                    </span>
                                                                </a>
                                                            <?endforeach;?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 smart-filter-parameters-box bx-active">
                                                <div class="smart-filter-parameters-box-title">
                                                    <span class="smart-filter-parameters-box-title-text">Разделы категории</span>
                                                </div>
                                                <div class="smart-filter-block" data-role="bx_filter_block">
                                                    <div class="smart-filter-parameters-box-container">
                                                        <div class="smart-filter-input-group-checkbox-list">
                                                            <?foreach($allSections as $section):?>
                                                                <?foreach($section['SUB'] as $sub):?>
                                                                    <a href="<?if($_REQUEST['section'] == $sub['INFO']['ID']):?><?=$APPLICATION->GetCurPage();?><?else:?><?=$APPLICATION->GetCurPage();?>?section=<?=$sub['INFO']['ID']?><?endif;?>" class="form-group form-check mb-1">
                                                                        <input<?if($_REQUEST['section'] == $sub['INFO']['ID']):?> checked<?endif;?> type="checkbox" value="Y" name="brands-fil[]" id="brands-fil-<?=$sub['INFO']['ID']?>" class="form-check-input">
                                                                        <span class="smart-filter-checkbox-text form-check-label" for="brands-fil-<?=$sub['INFO']['ID']?>">
                                                                            <?=$sub['INFO']['NAME']?>
                                                                        </span>
                                                                    </a>
                                                                <?endforeach;?>
                                                            <?endforeach;?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div*/?>

                                            <div class="col-lg-12 smart-filter-parameters-box bx-active">
                                                <div class="smart-filter-parameters-box-title">
                                                    <span class="smart-filter-parameters-box-title-text">Товары</span>
                                                </div>
                                                <div class="smart-filter-block" data-role="bx_filter_block">
                                                    <div class="smart-filter-parameters-box-container">
                                                        <div class="smart-filter-input-group-checkbox-list">
                                                            <?foreach($allSections as $section):?>
                                                                <?foreach($section['SUB'] as $sub):?>
                                                                    <?foreach($sub['SUB'] as $sub2):?>
                                                                        <a href="<?=$sub2['INFO']['SECTION_PAGE_URL']?>filter/proizvoditel-is-<?=$sub2['INFO']['PROIZVODITEL_XML_ID']?>/apply/" class="form-group mb-1">
                                                                            <span class="smart-filter-checkbox-text form-check-label" for="brands-fil-<?=$sub2['INFO']['ID']?>">
                                                                                <?=$sub2['INFO']['NAME']?>
                                                                            </span>
                                                                        </a>
                                                                    <?endforeach;?>
                                                                <?endforeach;?>
                                                            <?endforeach;?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?
                        global $productFilter;
            //            $productFilter['PROPERTY_CML2_MANUFACTURER_VALUE'] = $brandName;
                        $productFilter['PROPERTY_PROIZVODITEL_VALUE'] = $brandName;
//                        if($_REQUEST['section']){
//                            $productFilter['SECTION_ID'] = $_REQUEST['section'];
//                            $productFilter['INCLUDE_SUBSECTIONS'] = 'Y';
//                        }
                        $APPLICATION->IncludeComponent(
                            "bitrix:catalog.section",
                            "brands",
                            array(
                                "ACTION_VARIABLE" => "action",
                                "ADD_PICT_PROP" => "MORE_PHOTO",
                                "ADD_PROPERTIES_TO_BASKET" => "Y",
                                "ADD_SECTIONS_CHAIN" => "N",
                                "ADD_TO_BASKET_ACTION" => "ADD",
                                "AJAX_MODE" => "N",
                                "AJAX_OPTION_ADDITIONAL" => "",
                                "AJAX_OPTION_HISTORY" => "N",
                                "AJAX_OPTION_JUMP" => "N",
                                "AJAX_OPTION_STYLE" => "Y",
                                "BACKGROUND_IMAGE" => "UF_BACKGROUND_IMAGE",
                                "BASKET_URL" => "/personal/basket.php",
                                "BRAND_PROPERTY" => "BRAND_REF",
                                "BROWSER_TITLE" => "-",
                                "CACHE_FILTER" => "N",
                                "CACHE_GROUPS" => "N",
                                "CACHE_TIME" => "36000000",
                                "CACHE_TYPE" => "A",
                                "COMPATIBLE_MODE" => "Y",
                                "CONVERT_CURRENCY" => "N",
                                "CURRENCY_ID" => "RUB",
                                "CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[]}",
                                "DATA_LAYER_NAME" => "dataLayer",
                                "DETAIL_URL" => "",
                                "DISABLE_INIT_JS_IN_COMPONENT" => "N",
                                "DISCOUNT_PERCENT_POSITION" => "bottom-right",
                                "DISPLAY_BOTTOM_PAGER" => "N",
                                "DISPLAY_TOP_PAGER" => "N",
                                "ELEMENT_SORT_FIELD" => "sort",
                                "ELEMENT_SORT_FIELD2" => "id",
                                "ELEMENT_SORT_ORDER" => "asc",
                                "ELEMENT_SORT_ORDER2" => "desc",
                                "ENLARGE_PRODUCT" => "PROP",
                                "ENLARGE_PROP" => "-",
                                "FILTER_NAME" => "productFilter",
                                "HIDE_NOT_AVAILABLE" => "N",
                                "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                                "IBLOCK_ID" => IBLOCK_CATALOG_ID,
                                "IBLOCK_TYPE" => "1c_catalog",
                                "INCLUDE_SUBSECTIONS" => "Y",
                                "LABEL_PROP" => array(
                                ),
                                "LABEL_PROP_MOBILE" => "",
                                "LABEL_PROP_POSITION" => "top-left",
                                "LAZY_LOAD" => "Y",
                                "LINE_ELEMENT_COUNT" => "3",
                                "LOAD_ON_SCROLL" => "N",
                                "MESSAGE_404" => "",
                                "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                                "MESS_BTN_BUY" => "Купить",
                                "MESS_BTN_DETAIL" => "Подробнее",
                                "MESS_BTN_LAZY_LOAD" => "Показать ещё",
                                "MESS_BTN_SUBSCRIBE" => "Подписаться",
                                "MESS_NOT_AVAILABLE" => "Нет в наличии",
                                "META_DESCRIPTION" => "-",
                                "META_KEYWORDS" => "-",
                                "OFFERS_CART_PROPERTIES" => array(
                                    0 => "ARTNUMBER",
                                    1 => "COLOR_REF",
                                    2 => "SIZES_SHOES",
                                    3 => "SIZES_CLOTHES",
                                ),
                                "OFFERS_FIELD_CODE" => array(
                                    0 => "",
                                    1 => "",
                                ),
                                "OFFERS_LIMIT" => "5",
                                "OFFERS_PROPERTY_CODE" => array(
                                    0 => "COLOR_REF",
                                    1 => "SIZES_SHOES",
                                    2 => "SIZES_CLOTHES",
                                    3 => "",
                                ),
                                "OFFERS_SORT_FIELD" => "sort",
                                "OFFERS_SORT_FIELD2" => "id",
                                "OFFERS_SORT_ORDER" => "asc",
                                "OFFERS_SORT_ORDER2" => "desc",
                                "OFFER_ADD_PICT_PROP" => "MORE_PHOTO",
                                "OFFER_TREE_PROPS" => array(
                                    0 => "COLOR_REF",
                                    1 => "SIZES_SHOES",
                                    2 => "SIZES_CLOTHES",
                                ),
                                "PAGER_BASE_LINK_ENABLE" => "N",
                                "PAGER_DESC_NUMBERING" => "N",
                                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                                "PAGER_SHOW_ALL" => "N",
                                "PAGER_SHOW_ALWAYS" => "N",
                                "PAGER_TEMPLATE" => ".default",
                                "PAGER_TITLE" => "Товары",
                                "PAGE_ELEMENT_COUNT" => "100",
                                "PARTIAL_PRODUCT_PROPERTIES" => "N",
                                "PRICE_CODE" => array(
                                    0 => "Договор эквайринга",
                                ),
                                "PRICE_VAT_INCLUDE" => "N",
                                "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
                                "PRODUCT_DISPLAY_MODE" => "Y",
                                "PRODUCT_ID_VARIABLE" => "id",
                                "PRODUCT_PROPERTIES" => array(
                                    0 => "NEWPRODUCT",
                                    1 => "MATERIAL",
                                ),
                                "PRODUCT_PROPS_VARIABLE" => "prop",
                                "PRODUCT_QUANTITY_VARIABLE" => "",
                                "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'6','BIG_DATA':false}]",
                                "PRODUCT_SUBSCRIPTION" => "N",
                                "PROPERTY_CODE" => array(
                                    0 => "NEWPRODUCT",
                                    1 => "",
                                ),
                                "PROPERTY_CODE_MOBILE" => "",
                                "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
                                "RCM_TYPE" => "personal",
                                "SECTION_CODE" => "",
                                "SECTION_ID" => "",
                                "SECTION_ID_VARIABLE" => "SECTION_ID",
                                "SECTION_URL" => "",
                                "SECTION_USER_FIELDS" => array(
                                    0 => "",
                                    1 => "",
                                ),
                                "SEF_MODE" => "N",
                                "SET_BROWSER_TITLE" => "N",
                                "SET_LAST_MODIFIED" => "N",
                                "SET_META_DESCRIPTION" => "N",
                                "SET_META_KEYWORDS" => "N",
                                "SET_STATUS_404" => "N",
                                "SET_TITLE" => "N",
                                "SHOW_404" => "N",
                                "SHOW_ALL_WO_SECTION" => "Y",
                                "SHOW_CLOSE_POPUP" => "N",
                                "SHOW_DISCOUNT_PERCENT" => "N",
                                "SHOW_FROM_SECTION" => "N",
                                "SHOW_MAX_QUANTITY" => "N",
                                "SHOW_OLD_PRICE" => "N",
                                "SHOW_PRICE_COUNT" => "1",
                                "SHOW_SLIDER" => "N",
                                "SLIDER_INTERVAL" => "3000",
                                "SLIDER_PROGRESS" => "N",
                                "TEMPLATE_THEME" => "blue",
                                "USE_ENHANCED_ECOMMERCE" => "N",
                                "USE_MAIN_ELEMENT_SECTION" => "N",
                                "USE_PRICE_COUNT" => "N",
                                "USE_PRODUCT_QUANTITY" => "N",
                                "COMPONENT_TEMPLATE" => "main",
                                "DISPLAY_COMPARE" => "N"
                            ),
                            false
                        );?>
                    </div>
                </div>
                <div class="brands-tabs-block" style="display: none" data-type="list">
                    <div class="brands-tabs-block__title">
                        Перечень товаров данного производителя
                    </div>
                    <ul>
                        <?foreach($brandsProduct as $item):
                            if(!$item['PROPERTY_NAIMENOVANIE_DLYA_SAYTA_VALUE']){$item['PROPERTY_NAIMENOVANIE_DLYA_SAYTA_VALUE'] = $item['NAME'];}?>
                            <li>
                                <a href="<?=$item['DETAIL_PAGE_URL']?>"><?=$item['PROPERTY_NAIMENOVANIE_DLYA_SAYTA_VALUE']?></a>
                            </li>
                        <?endforeach;?>
                    </ul>
                </div>
            </div>
        </div>
    <?endif;?>
<?endif;?>
