<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

//$APPLICATION->SetPageProperty("title", "".$arResult['PROPERTIES']['NAIMENOVANIE_DLYA_SAYTA']['VALUE']."");



/**
* @global CMain $APPLICATION
* @var array $arParams
* @var array $arResult
* @var CatalogSectionComponent $component
* @var CBitrixComponentTemplate $this
* @var string $templateName
* @var string $componentPath
* @var string $templateFolder
*/


$this->setFrameMode(true);
$oid = intval($_REQUEST["oid"]);
if ($oid > 0) {
	foreach ($arResult['JS_OFFERS'] as $key => $jsOffer) {
		if ($jsOffer["ID"] == $oid) {
			$arResult['OFFERS_SELECTED'] = $key;
			break;
		}
	}
}
$templateLibrary = array('popup', 'fx');
$currencyList = '';
use Palladiumlab\Catalog\CharacteristicsToPhoto;
use Palladiumlab\Catalog\ManufactersToPhoto;
use Palladiumlab\Catalog\CountriesToPhoto;
use Palladiumlab\Catalog\Element;
$element = new Element($arResult);
$coll=CharacteristicsToPhoto::find();
$manufacters=ManufactersToPhoto::find();
$countries=CountriesToPhoto::find();
if (!empty($arResult['CURRENCIES']))
{
	$templateLibrary[] = 'currency';
	$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$templateData = array(
	'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
	'TEMPLATE_LIBRARY' => $templateLibrary,
	'CURRENCIES' => $currencyList,
	'ITEM' => array(
		'ID' => $arResult['ID'],
		'IBLOCK_ID' => $arResult['IBLOCK_ID'],
		'OFFERS_SELECTED' => $arResult['OFFERS_SELECTED'],
		'JS_OFFERS' => $arResult['JS_OFFERS']
	)
);
unset($currencyList, $templateLibrary);

$mainId = $this->GetEditAreaId($arResult['ID']);
$itemIds = array(
	'ID' => $mainId,
	'DISCOUNT_PERCENT_ID' => $mainId.'_dsc_pict',
	'STICKER_ID' => $mainId.'_sticker',
	'BIG_SLIDER_ID' => $mainId.'_big_slider',
	'BIG_IMG_CONT_ID' => $mainId.'_bigimg_cont',
	'SLIDER_CONT_ID' => $mainId.'_slider_cont',
	'OLD_PRICE_ID' => $mainId.'_old_price',
	'PRICE_ID' => $mainId.'_price',
	'DISCOUNT_PRICE_ID' => $mainId.'_price_discount',
	'PRICE_TOTAL' => $mainId.'_price_total',
	'SLIDER_CONT_OF_ID' => $mainId.'_slider_cont_',
	'QUANTITY_ID' => $mainId.'_quantity',
	'QUANTITY_DOWN_ID' => $mainId.'_quant_down',
	'QUANTITY_UP_ID' => $mainId.'_quant_up',
	'QUANTITY_MEASURE' => $mainId.'_quant_measure',
	'QUANTITY_LIMIT' => $mainId.'_quant_limit',
	'BUY_LINK' => $mainId.'_buy_link',
	'ADD_BASKET_LINK' => $mainId.'_add_basket_link',
	'BASKET_ACTIONS_ID' => $mainId.'_basket_actions',
	'NOT_AVAILABLE_MESS' => $mainId.'_not_avail',
	'COMPARE_LINK' => $mainId.'_compare_link',
	'TREE_ID' => $mainId.'_skudiv',
	'DISPLAY_PROP_DIV' => $mainId.'_sku_prop',
	'DISPLAY_MAIN_PROP_DIV' => $mainId.'_main_sku_prop',
	'OFFER_GROUP' => $mainId.'_set_group_',
	'BASKET_PROP_DIV' => $mainId.'_basket_prop',
	'SUBSCRIBE_LINK' => $mainId.'_subscribe',
	'TABS_ID' => $mainId.'_tabs',
	'TAB_CONTAINERS_ID' => $mainId.'_tab_containers',
	'SMALL_CARD_PANEL_ID' => $mainId.'_small_card_panel',
	'TABS_PANEL_ID' => $mainId.'_tabs_panel'
);
$obName = $templateData['JS_OBJ'] = 'ob'.preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);
$name = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
	: $arResult['NAME'];
$title = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE']
	: $arResult['NAME'];
$alt = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']
	: $arResult['NAME'];

$haveOffers = !empty($arResult['OFFERS']);
if ($haveOffers)
{
	$actualItem = isset($arResult['OFFERS'][$arResult['OFFERS_SELECTED']])
		? $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]
		: reset($arResult['OFFERS']);
	$showSliderControls = false;

	foreach ($arResult['OFFERS'] as $offer)
	{
		if ($offer['MORE_PHOTO_COUNT'] > 1)
		{
			$showSliderControls = true;
			break;
		}
	}
}
else
{
	$actualItem = $arResult;
	$showSliderControls = $arResult['MORE_PHOTO_COUNT'] > 1;
}
$skuProps = array();
$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];
$measureRatio = $actualItem['ITEM_MEASURE_RATIOS'][$actualItem['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'];
$showDiscount = $price['PERCENT'] > 0;

$showDescription = !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
$buyButtonClassName = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-primary' : 'btn-link';
$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);
$showButtonClassName = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-primary' : 'btn-link';
$showSubscribe = $arParams['PRODUCT_SUBSCRIPTION'] === 'Y' && ($arResult['PRODUCT']['SUBSCRIBE'] === 'Y' || $haveOffers);

$arParams['MESS_BTN_BUY'] = $arParams['MESS_BTN_BUY'] ?: Loc::getMessage('CT_BCE_CATALOG_BUY');
$arParams['MESS_BTN_ADD_TO_BASKET'] = $arParams['MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_BCE_CATALOG_ADD');
$arParams['MESS_NOT_AVAILABLE'] = $arParams['MESS_NOT_AVAILABLE'] ?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE');
$arParams['MESS_BTN_COMPARE'] = $arParams['MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_BCE_CATALOG_COMPARE');
$arParams['MESS_PRICE_RANGES_TITLE'] = $arParams['MESS_PRICE_RANGES_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_PRICE_RANGES_TITLE');
$arParams['MESS_DESCRIPTION_TAB'] = $arParams['MESS_DESCRIPTION_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_DESCRIPTION_TAB');
$arParams['MESS_PROPERTIES_TAB'] = $arParams['MESS_PROPERTIES_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_PROPERTIES_TAB');
$arParams['MESS_COMMENTS_TAB'] = $arParams['MESS_COMMENTS_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_COMMENTS_TAB');
$arParams['MESS_SHOW_MAX_QUANTITY'] = $arParams['MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_BCE_CATALOG_SHOW_MAX_QUANTITY');
$arParams['MESS_RELATIVE_QUANTITY_MANY'] = $arParams['MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['MESS_RELATIVE_QUANTITY_FEW'] = $arParams['MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_FEW');

$positionClassMap = array(
	'left' => 'product-item-label-left',
	'center' => 'product-item-label-center',
	'right' => 'product-item-label-right',
	'bottom' => 'product-item-label-bottom',
	'middle' => 'product-item-label-middle',
	'top' => 'product-item-label-top'
);

$discountPositionClass = 'product-item-label-big';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION']))
{
	foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos)
	{
		$discountPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

$labelPositionClass = 'product-item-label-big';
if (!empty($arParams['LABEL_PROP_POSITION']))
{
	foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos)
	{
		$labelPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

$themeClass = isset($arParams['TEMPLATE_THEME']) ? ' bx-'.$arParams['TEMPLATE_THEME'] : '';
?>
    <div class="product " id="<?=$itemIds['ID']?>">
        <div class="product-head" >
            <div class="product-head-content">
                <h1 class="product-title section-title">
                    <?if($arResult['PROPERTIES']['NAIMENOVANIE_DLYA_SAYTA']['VALUE']):?>
                        <?=$arResult['PROPERTIES']['NAIMENOVANIE_DLYA_SAYTA']['VALUE']?>
                    <?else:?>
                        <?=$arResult["NAME"]?>
                    <?endif;?>
                </h1>
                <div class="product-head-info desktop-view">
                    <div class="product-code">Артикул:
                        <span><?=$arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]?></span></div>
                    <div class="product-reviews">
                        <?/*i class="visible-mobile">
                            <svg width="16" height="16"><use xlink:href="#icon-star-fill"/></svg>
                        </i*/?>
                        <?php
                        $rating = rand(3,5);
                        ?>
                        <div class="review-main__stars product-head__stars">
                            <!--<div class="rating"><div class="rating-state" style="width:<?=(($arResult['AVG_RATING']/5)*100);?>%;"></div></div>-->
                            <div class="rating"><div class="rating-state" style="width:<?=(($rating/5)*100);?>%;"></div></div>
                        </div>

							<?
							/*$APPLICATION->IncludeComponent(
								'bitrix:iblock.vote',
								'bootstrap_v4',
								array(
									'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
									'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
									'IBLOCK_ID' => $arParams['IBLOCK_ID'],
									'ELEMENT_ID' => $arResult['ID'],
									'ELEMENT_CODE' => '',
									'MAX_VOTE' => '5',
									'VOTE_NAMES' => array('1', '2', '3', '4', '5'),
									'SET_STATUS_404' => 'N',
									'DISPLAY_AS_RATING' => "vote_avg",
									"SHOW_RATING" => "Y",
									'CACHE_TYPE' => $arParams['CACHE_TYPE'],
									'CACHE_TIME' => $arParams['CACHE_TIME']
								),
								$component,
								array('HIDE_ICONS' => 'Y')
							);*/
							?>


                        <?
                        if(!$arResult['REVIEWS']){$arResult['REVIEWS'] = [];}
                        $all_count = count($arResult['REVIEWS']);
                        ?>
                        <a href="javascript:void(0)" class="product-reviews-count"><?=$all_count;?> <?=endingsForm($all_count,'отзыв','отзыва','отзывов');?></a>
                    </div>
                    <a href="javascript:void(0)" data-product="<?=$arResult['ID']?>" class="js-add-favorites add-to-favorites-btn product-favorites">
                        <svg width="24" height="24"><use xlink:href="#icon-like"/></svg>
                        <span>В избранное</span>
                    </a>
                </div>
            </div>
            <div class="product-programm hidden-tablet">
				<?if($element->getIPRA()):?>
                    <div class="product-programm-icon">
                        <img src="<?=SITE_TEMPLATE_PATH?>assets/img/product-programm-icon.svg" alt="">
                    </div>
                    <div class="product-programm-body">
                        <div class="product-programm-desc">Данный товар участвует в индивидуальной программе реабилитации</div>
                        <a href="/ipra/" class="product-programm-link">Подробнее&nbsp;&#62;</a>
                    </div>
				<?endif?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="product-item-detail-slider-container" id="<?=$itemIds['BIG_SLIDER_ID']?>">
                    <div class="product-gallery-body">
                        <div class="product-item-stikers">
                            <? $element->echoStickers(); ?>
                        </div>
                    </div>
                    <span class="product-item-detail-slider-close" data-entity="close-popup"></span>
                    <div  class="product-item-detail-slider-block
                                <?=($arParams['IMAGE_RESOLUTION'] === '1by1' ? 'product-item-detail-slider-block-square' : '')?>"
                         data-entity="images-slider-block" >
                        <span class="product-item-detail-slider-left" data-entity="slider-control-left" style="display: none;"></span>
                        <span class="product-item-detail-slider-right" data-entity="slider-control-right" style="display: none;"></span>
                        <div class="product-item-label-text <?=$labelPositionClass?>" id="<?=$itemIds['STICKER_ID']?>"
                            <?=(!$arResult['LABEL'] ? 'style="display: none;"' : '' )?>>
                            <?php
                            if ($arResult['LABEL'] && !empty($arResult['LABEL_ARRAY_VALUE']))
                            {
                                if ($arResult['LABEL_ARRAY_VALUE'][KHIT])
                                {
                                    ?>
                                    <div class="product-gallery-body">
                                        <div class="product-item-stikers">
                                            <div class='product-item-stiker product-item-stiker-hit'><?=$arResult['LABEL_ARRAY_VALUE'][KHIT]?></div>
                                        </div>
                                    </div>
                                    <?php
                                }

                            }
                            ?>
                        </div>
                        <?php
                        if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y')
                        {
                            if ($haveOffers)
                            {
                                ?>
                                <div class="product-detail-discount-label <?=$discountPositionClass?>" id="<?=$itemIds['DISCOUNT_PERCENT_ID']?>" style="display: none;">
                                </div>
                                <?php
                            }
                            else
                            {
                                if ($price['DISCOUNT'] > 0)
                                {
                                    ?>
                                    <div class="product-item-label-ring <?=$discountPositionClass?>" id="<?=$itemIds['DISCOUNT_PERCENT_ID']?>"
                                         title="<?=-$price['PERCENT']?>%">
                                        <span><?=-$price['PERCENT']?>%</span>
                                    </div>
                                    <?php
                                }
                            }
                        }
                        ?>
                        <div class="product-item-detail-slider-images-container" data-entity="images-container">
                            <?php
                            if (!empty($actualItem['MORE_PHOTO']))
                            {
                                foreach ($actualItem['MORE_PHOTO'] as $key => $photo)
                                {
                                    unset($explode_name2);
//                                    $explode_name2 = explode('YM_',$actualItem['PROPERTIES']['MORE_PHOTO']['DESCRIPTION'][$key]);
//                                    if($explode_name2[1]){
//                                        continue;
//                                    }
                                    ?>
                                    <div class="product-item-detail-slider-image<?=($key == 0 ? ' active' : '')?>" data-entity="image" data-id="<?=$photo['ID']?>">
                                        <img src="<?=$photo['SRC']?>" alt="<?=$alt?>" title="<?=$title?>"<?=($key == 0 ? ' itemprop="image"' : '')?>>
                                    </div>
                                    <?php
                                }
                            }

                            if ($arParams['SLIDER_PROGRESS'] === 'Y')
                            {
                                ?>
                                <div class="product-item-detail-slider-progress-bar" data-entity="slider-progress-bar" style="width: 0;"></div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                    if ($showSliderControls)
                    {
                        if ($haveOffers)
                        {
                            foreach ($arResult['OFFERS'] as $keyOffer => $offer)
                            {
                                if (!isset($offer['MORE_PHOTO_COUNT']) || $offer['MORE_PHOTO_COUNT'] <= 0)
                                    continue;

                                $strVisible = $arResult['OFFERS_SELECTED'] == $keyOffer ? '' : 'none';
                                ?>
                                <div class="product-item-detail-slider-controls-block" id="<?=$itemIds['SLIDER_CONT_OF_ID'].$offer['ID']?>" style="display: <?=$strVisible?>;">
                                    <?php
                                    foreach ($offer['MORE_PHOTO'] as $keyPhoto => $photo)
                                    {
                                        unset($explode_name2);
                                        if(count($offer['MORE_PHOTO']) > count($offer['PROPERTIES']['MORE_PHOTO']['VALUE'])){
                                            $explode_name2 = explode('YM_',$offer['PROPERTIES']['MORE_PHOTO']['DESCRIPTION'][$keyPhoto-1]);
                                            if($explode_name2[1]){
                                                continue;
                                            }
                                        }else{
                                            $explode_name2 = explode('YM_',$offer['PROPERTIES']['MORE_PHOTO']['DESCRIPTION'][$keyPhoto]);
                                            if($explode_name2[1]){
                                                continue;
                                            }
                                        }
                                        ?>
                                        <div class="product-item-detail-slider-controls-image<?=($keyPhoto == 0 ? ' active' : '')?>"
                                             data-entity="slider-control" data-value="<?=$offer['ID'].'_'.$photo['ID']?>" data-desc="<?=$offer['PROPERTIES']['MORE_PHOTO']['DESCRIPTION'][$keyPhoto]?>">
                                            <img src="<?=$photo['SRC']?>">
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                            }
                        }
                        else
                        {
                            ?>
                            <div class="product-item-detail-slider-controls-block" id="<?=$itemIds['SLIDER_CONT_ID']?>">
                                <?php
                                if (!empty($actualItem['MORE_PHOTO']))
                                {
                                    foreach ($actualItem['MORE_PHOTO'] as $key => $photo)
                                    {
                                        unset($explode_name2);
                                        if(count($actualItem['MORE_PHOTO']) > $arResult['MORE_PHOTO_COUNT2']){
                                            $explode_name2 = explode('YM_',$actualItem['PROPERTIES']['MORE_PHOTO']['DESCRIPTION'][$key-1]);
                                            if($explode_name2[1]){
                                                continue;
                                            }
                                        }else{
                                            $explode_name2 = explode('YM_',$actualItem['PROPERTIES']['MORE_PHOTO']['DESCRIPTION'][$key]);
                                            if($explode_name2[1]){
                                                continue;
                                            }
                                        }

                                        ?>
                                        <div class="product-item-detail-slider-controls-image<?=($key == 0 ? ' active' : '')?>"
                                             data-entity="slider-control" data-value="<?=$photo['ID']?>">
                                            <img src="<?=$photo['SRC']?>">
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>

            <?/*div class="product-gallery">
                <div class="product-item-detail-slider-container" id="<?=$itemIds['BIG_SLIDER_ID']?>">
                    <span class="product-item-detail-slider-close" data-entity="close-popup"></span>
                    <div class="product-gallery">
                        <div class="product-gallery-nav">
                            <?php
                            $count_photos = 0;
                            if ($showSliderControls)
                            {
                                if ($haveOffers)
                                {
                                    foreach ($arResult['OFFERS'] as $keyOffer => $offer)
                                    {
                                        if (!isset($offer['MORE_PHOTO_COUNT']) || $offer['MORE_PHOTO_COUNT'] <= 0)
                                            continue;

                                        $strVisible = $arResult['OFFERS_SELECTED'] == $keyOffer ? '' : 'none';
                                        ?>
                                        <div class="product-gallery-nav-slider swiper-container hidden-mobile product-item-detail-slider-controls-block" id="<?=$itemIds['SLIDER_CONT_OF_ID'].$offer['ID']?>" style="display: <?=$strVisible?>;">
                                            <div class="swiper-wrapper">
                                                <?php
                                                foreach ($offer['MORE_PHOTO'] as $keyPhoto => $photo)
                                                {$count_photos++;
                                                    ?>
                                                    <div class="product-gallery-nav-slide swiper-slide">
                                                        <span class="!product-item-detail-slider-controls-image<?=($keyPhoto == 0 ? ' active' : '')?>"
                                                             data-entity="slider-control" data-value="<?=$offer['ID'].'_'.$photo['ID']?>">
                                                            <img src="<?=$photo['SRC']?>">
                                                        </span>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                else
                                {
                                    ?>
                                    <div class="product-gallery-nav-slider swiper-container hidden-mobile product-item-detail-slider-controls-block" id="<?=$itemIds['SLIDER_CONT_ID']?>">
                                        <div class="swiper-wrapper">
                                            <?php
                                            if (!empty($actualItem['MORE_PHOTO']))
                                            {
                                                foreach ($actualItem['MORE_PHOTO'] as $key => $photo)
                                                {$count_photos++;
                                                    ?>
                                                    <div class="product-gallery-nav-slide swiper-slide">
                                                        <span class="!product-item-detail-slider-controls-image<?=($key == 0 ? ' active' : '')?>"
                                                             data-entity="slider-control" data-value="<?=$photo['ID']?>">
                                                            <img src="<?=$photo['SRC']?>">
                                                        </span>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                            <?if($count_photos>15):?>
                                <button class="slider-arrow slider-arrow-prev" aria-label="Назад">
                                    <svg width="30" height="30"><use xlink:href="#icon-arrow-down"/></svg>
                                </button>
                                <button class="slider-arrow slider-arrow-next" aria-label="Вперед">
                                    <svg width="30" height="30"><use xlink:href="#icon-arrow-down"/></svg>
                                </button>
                            <?endif;?>
                        </div>
                        <div class="product-gallery-body">
                            <div class="product-gallery-body product-item-detail-slider-block <?=($arParams['IMAGE_RESOLUTION'] === '1by1' ? 'product-item-detail-slider-block-square' : '')?>" data-entity="images-slider-block">
                                <span class="product-item-detail-slider-left" data-entity="slider-control-left" style="display: none;"></span>
                                <span class="product-item-detail-slider-right" data-entity="slider-control-right" style="display: none;"></span>
                                <div class="product-item-stikers">
                                    <? $element->echoStickers(); ?>
                                </div>
                                <?php
                                if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y')
                                {
                                    if ($haveOffers)
                                    {
                                        ?>
                                        <div class="product-item-label-ring <?=$discountPositionClass?>" id="<?=$itemIds['DISCOUNT_PERCENT_ID']?>"
                                             style="display: none; width: 128px;
                                                    height: 40px;
                                                    line-height: 40px;
                                                    top: 20px;

                                                    background: linear-gradient(90deg, #FF5858 0%, #F09819 100%);
                                                    border-radius: 3px;">
                                        </div>
                                        <?php
                                    }
                                    else
                                    {
                                        if ($price['DISCOUNT'] > 0)
                                        {
                                            ?>
                                            <div class="product-item-label-ring <?=$discountPositionClass?>" id="<?=$itemIds['DISCOUNT_PERCENT_ID']?>"
                                                 title="<?=-$price['PERCENT']?>%">
                                                <span><?=-$price['PERCENT']?>%</span>
                                            </div>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                                <div class="product-item-detail-slider-images-container" data-entity="images-container">
                                    <?php
                                    if (!empty($actualItem['MORE_PHOTO']))
                                    {
                                        foreach ($actualItem['MORE_PHOTO'] as $key => $photo)
                                        {
                                            ?>
                                            <div class="product-item-detail-slider-image<?=($key == 0 ? ' active' : '')?>" data-entity="image" data-id="<?=$photo['ID']?>">
                                                <img src="<?=$photo['SRC']?>" alt="<?=$alt?>" title="<?=$title?>"<?=($key == 0 ? ' itemprop="image"' : '')?>>
                                            </div>
                                            <?php
                                        }
                                    }

                                    if ($arParams['SLIDER_PROGRESS'] === 'Y')
                                    {
                                        ?>
                                        <div class="product-item-detail-slider-progress-bar" data-entity="slider-progress-bar" style="width: 0;"></div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>




                <?/*div class="product-gallery-nav">
                    <button class="slider-arrow slider-arrow-prev" aria-label="Назад">
                        <svg width="30" height="30"><use xlink:href="#icon-arrow-down"/></svg>
                    </button>
                    <button class="slider-arrow slider-arrow-next" aria-label="Вперед">
                        <svg width="30" height="30"><use xlink:href="#icon-arrow-down"/></svg>
                    </button>

                    <div class="product-gallery-nav-slider swiper-container hidden-mobile">
                        <div class="swiper-wrapper">
                            <?if(isset($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"]) && is_array($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"])):?>
                                <?foreach($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $k=>$PHOTO):?>
                                    <?$fileImg=CFile::GetFileArray($PHOTO); ?>

                                    <div class="product-gallery-nav-slide swiper-slide">
                                        <span>
                                            <img src="<?=$fileImg['SRC']?>"
                                                 srcset="<?=$arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE2X"][$k]["src"]?> 2x"
                                                 data-desc="<?=$fileImg['DESCRIPTION'];?>"
                                                 alt="">
                                        </span>
                                    </div>
                                <? endforeach ?>
                            <? endif ?>

                        </div>
                    </div>
                </div>
                <div class="product-gallery-body">
                    <div class="product-item-stikers">
                        <? $element->echoStickers(); ?>
                    </div>
                    <div class="product-gallery-zoom hidden-mobile">
                        <img src="<?= SITE_TEMPLATE_PATH ?>/assets/img/product-zoom.svg" alt="">
                    </div>
                    <div class="product-gallery-slider swiper-container">
                        <div class="swiper-wrapper">
                            <? if (count($arResult["MORE_PHOTO"]) > 0): ?>
                                <?foreach($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $key=>$PHOTO):?>
                                    <?$fileImg=CFile::GetFileArray($PHOTO); ?>
                                    <div class="product-gallery-slide swiper-slide">
                                        <a href="<?=$fileImg['SRC']?>" class="product-img" data-fancybox="product">
                                            <img class="image-main-element" src="<?=$fileImg['SRC']?>"
                                                 srcset="<?=$arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE2X"][$key]["src"]?> 2x"
                                                 alt="">
                                        </a>
                                    </div>

                                <?endforeach?>
                            <?endif?>
                        </div>
                    </div>
                </div/?>





                </div>
            </div*/?>
            <div class="col-md-6 col-sm-12">
                <div class="product-info__flex">
                    <div class="product-head-info mobile-view">
                        <div class="product-code">Артикул:
                            <span><?=$arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]?></span></div>
                        <div class="product-reviews">
                            <?/*i class="visible-mobile">
                                <svg width="16" height="16"><use xlink:href="#icon-star-fill"/></svg>
                            </i*/?>
                             <?php
                        //$rating = rand(3,5);
                        ?>
                        <div class="review-main__stars product-head__stars">
                            <!--<div class="rating"><div class="rating-state" style="width:<?=(($arResult['AVG_RATING']/5)*100);?>%;"></div></div>-->
                            <div class="rating"><div class="rating-state" style="width:<?=(($rating/5)*100);?>%;"></div></div>
                        </div>

                            <?
                            /*$APPLICATION->IncludeComponent(
                                'bitrix:iblock.vote',
                                'bootstrap_v4',
                                array(
                                    'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
                                    'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
                                    'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                                    'ELEMENT_ID' => $arResult['ID'],
                                    'ELEMENT_CODE' => '',
                                    'MAX_VOTE' => '5',
                                    'VOTE_NAMES' => array('1', '2', '3', '4', '5'),
                                    'SET_STATUS_404' => 'N',
                                    'DISPLAY_AS_RATING' => "vote_avg",
                                    "SHOW_RATING" => "Y",
                                    'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                                    'CACHE_TIME' => $arParams['CACHE_TIME']
                                ),
                                $component,
                                array('HIDE_ICONS' => 'Y')
                            );*/
                            ?>


                            <?
                            $all_count = count($arResult['REVIEWS']);
                            ?>
                            <a href="javascript:void(0)" class="product-reviews-count"><?=$all_count;?> <?=endingsForm($all_count,'отзыв','отзыва','отзывов');?></a>
                        </div>
                        <a href="javascript:void(0)" data-product="<?=$arResult['ID']?>" class="js-add-favorites add-to-favorites-btn product-favorites">
                            <svg width="24" height="24"><use xlink:href="#icon-like"/></svg>
                            <span>В избранное</span>
                        </a>
                    </div>
                    <div class="product-body">
                    <?  foreach ($arResult['SKU_PROPS'] as $key=>$skuProperty)
                        {
                            if (!isset($arResult['OFFERS_PROP'][$skuProperty['CODE']])) continue;

                            $propertyId = $skuProperty['ID'];
                            $skuProps[] = array(
                                'ID'           => $propertyId,
                                'SHOW_MODE'    => $skuProperty['SHOW_MODE'],
                                'VALUES'       => $skuProperty['VALUES'],
                                'VALUES_COUNT' => $skuProperty['VALUES_COUNT']
                            );
                            switch($skuProperty['CODE'])
                            {
                                case 'TSVET':
                                    $tsvet=$key;
                                    break;
                                case 'RAZMER':
                                    $razmer=$key;
                                    break;
                            }

                        }

                        ?>
                        <div class="product-item-detail-info-section">
                            <div id="<?=$itemIds['TREE_ID']?>">
                            <?php
                            foreach ($arParams['PRODUCT_INFO_BLOCK_ORDER'] as $blockName)
                            {
                            switch ($blockName)
                            {
                            case 'sku':
                            if ($haveOffers && !empty($arResult['OFFERS_PROP']))
                            {
                            ?>

                                <?php
                                foreach ($arResult['SKU_PROPS'] as $skuProperty)
                                {
                                if (!isset($arResult['OFFERS_PROP'][$skuProperty['CODE']]))
                                    continue;

                                $propertyId = $skuProperty['ID'];
                                $skuProps[] = array(
                                    'ID' => $propertyId,
                                    'SHOW_MODE' => $skuProperty['SHOW_MODE'],
                                    'VALUES' => $skuProperty['VALUES'],
                                    'VALUES_COUNT' => $skuProperty['VALUES_COUNT']
                                );
                                ?>
                                <div class="product-item-detail-info-container" data-entity="sku-line-block">
                                    <div class="product-item-detail-info-container-title"><?=htmlspecialcharsEx($skuProperty['NAME'])?></div>
                                    <div class="product-item-scu-container">
                                        <div class="product-item-scu-block">
                                            <div class="product-item-scu-list">
                                                <ul class="product-item-scu-item-list">
                                                    <?php
                                                    foreach ($skuProperty['VALUES'] as &$value)
                                                    {
                                                        $value['NAME'] = htmlspecialcharsbx($value['NAME']);
                                                        if ($skuProperty['SHOW_MODE'] === 'PICT')
                                                        {
                                                            ?>
                                                            <li class="product-item-scu-item-color-container" title="<?=$value['NAME']?>"
                                                                data-treevalue="<?=$propertyId?>_<?=$value['ID']?>"
                                                                data-onevalue="<?=$value['ID']?>">
                                                                <div class="product-item-scu-item-color-block">
                                                                    <div class="product-item-scu-item-color" title="<?=$value['NAME']?>"
                                                                         style="background-image: url('<?=$value['PICT']['SRC']?>');">
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            //echo $$skuProperty['NAME'];
                                                            if ($skuProperty['NAME'] == "Цвет")
                                                            {

                                                                $color=null;
                                                                $color_name=null;

                                                                $dd=$coll->where("name",$value['NAME'])->first();
                                                                $color=$dd->color_html;
                                                                $color_name=$dd->code;
                                                                ?>
                                                                <li class="product-item-scu-item-color-container" title="<?=$value['NAME']?>"
                                                                    data-treevalue="<?=$propertyId?>_<?=$value['ID']?>"
                                                                    data-onevalue="<?=$value['ID']?>">
                                                                    <div class="product-item-scu-item-color-block" style=" border-radius: 50%">
                                                                        <div class="product-item-scu-item-color" title="<?=$value['NAME']?>"
                                                                             style="background-color: <?=$color?>; border-radius: 50%">
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <?php
                                                            } else {?>
                                                                <li class="product-item-scu-item-text-container<?if ($skuProperty['NAME'] != "Размер"):?> sizeSmall<?endif;?>" title="<?=$value['NAME']?>"
                                                                    data-treevalue="<?=$propertyId?>_<?=$value['ID']?>"
                                                                    data-onevalue="<?=$value['ID']?>">
                                                                    <div class="product-item-scu-item-text-block" >
                                                                        <div class="product-item-scu-item-text "><?=$value['NAME']?></div>
                                                                    </div>
                                                                </li>
                                                            <?php
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                    </ul>
                                                    <div style="clear: both;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <?php
                                }

                                break;

                                case 'props':
                                    if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS'])
                                    {
                                        ?>
                                        <div class="product-item-detail-info-container">
                                            <?php
                                            if (!empty($arResult['DISPLAY_PROPERTIES']))
                                            {
                                                ?>
                                                <dl class="product-item-detail-properties">
                                                    <?php
                                                    foreach ($arResult['DISPLAY_PROPERTIES'] as $property)
                                                    {
                                                        if (isset($arParams['MAIN_BLOCK_PROPERTY_CODE'][$property['CODE']]))
                                                        {
                                                            ?>
                                                            <dt><?=$property['NAME']?></dt>
                                                            <dd><?=(is_array($property['DISPLAY_VALUE'])
                                                                    ? implode(' / ', $property['DISPLAY_VALUE'])
                                                                    : $property['DISPLAY_VALUE'])?>
                                                            </dd>
                                                            <?php
                                                        }
                                                    }
                                                    unset($property);
                                                    ?>
                                                </dl>
                                                <?php
                                            }

                                            if ($arResult['SHOW_OFFERS_PROPS'])
                                            {
                                                ?>
                                                <dl class="product-item-detail-properties" id="<?=$itemIds['DISPLAY_MAIN_PROP_DIV']?>"></dl>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <?php
                                    }

                                    break;
                                }?>
                            <?}?>
                            </div>
                        </div>

                        <?/*div  id="<?=$itemIds['TREE_ID']?>">
                            <? if(isset($razmer)):?>
                                <div data-entity="sku-line-block" class="product-info product-size">
                                    <div class="product-info-title">Размер:</div>
                                    <ul class="product-size-list">
                                        <?

                                        foreach ($arResult['SKU_PROPS'][$razmer]['VALUES'] as &$value)
                                        {
                                            $value['NAME'] = htmlspecialcharsbx($value['NAME']);

                                            $color=null;
                                            $dd=$coll->where("name",$value['NAME'])->first();
                                            $razmer_name= $dd->code!="" ? $dd->code:$value['NAME'];
                                            ?>

                                            <li class="product-item-scu-item-text-container" title="<?=$value['NAME']?>"
                                                 data-treevalue="<?=$arResult['SKU_PROPS'][$razmer]['ID'];
                                                ?>_<?=$value['ID']?>"
                                                data-onevalue="<?=$value['ID']?>">
                                                <a href="#" data-name="<?=$razmer_name?>"><?=$value['NAME']?></a>
                                            </li>
                                            <?

                                        }
                                        ?>
                                    </ul>
                                    <div style="clear: both;"></div>
                                </div>
                            <?endif?>
                            <? if(isset($tsvet)):?>
                                <div data-entity="sku-line-block" class="product-info product-color">
                                    <div class="product-info-title">Цвет: <span class="product-color-selected"></span></div>
                                    <ul class="product-color-list">
                                        <? foreach ($arResult['SKU_PROPS'][$tsvet]['VALUES'] as $value):?>
                                            <li class="product-item-scu-item-text-container" title="<?=$value['NAME']?>"
                                                data-treevalue="<?=$arResult['SKU_PROPS'][$tsvet]['ID'];?>_<?=$value['ID']?>"
                                                data-onevalue="<?=$value['ID']?>">
                                                <?
                                                    $color=null;
                                                    $color_name=null;

                                                $dd=$coll->where("name",$value['NAME'])->first();
                                                $color=$dd->color_html;
                                                $color_name=$dd->code;


                                                ?>
                                                <a href="#" data-name="<?=$color_name?>" data-color="<?=$value['NAME']?>"
                                                   aria-label="<?=$value['NAME']?>"
                                                   style="color:<?=$color?>;"></a>

                                            </li>

                                        <?endforeach;?>

                                    </ul>
                                </div>
                            <?endif?>
                        </div*/?>


                        <div class="product-info product-number">
                            <div class="product-info-title">Количество:</div>
                            <div class="select-number">

                                <button id="<?=$itemIds['QUANTITY_DOWN_ID']?>" type="button" class="select-number-btn select-number-btn-minus disabled"
                                         aria-label="Убавить"></button>
                                <input id="<?=$itemIds['QUANTITY_ID']?>" type="text" class="select-number-input" data-min="1"
                                       data-max="2000" value="1">



                                <button id="<?=$itemIds['QUANTITY_UP_ID']?>" type="button" class="select-number-btn select-number-btn-plus"
                                         aria-label="Прибавить"></button>

                            </div>
                        </div>
                        <div class="product-info product-price">
                            <div class="product-info-title">Цена:</div>
                            <?if($price['UNROUND_BASE_PRICE'] != $price['UNROUND_PRICE']):?>
                                <div class="product-price-old" id="<?=$itemIds['OLD_PRICE_ID']?>">
                                    <?=$price['PRINT_BASE_PRICE'];?>
                                </div>
                            <?endif;?>
                            <div class="product-price-body">
                                <div class="product-cost"><span id="<?=$itemIds['PRICE_TOTAL']?>"></span></div>
                                <div class="product-cost-unit" id="<?=$itemIds['PRICE_ID']?>"><?=$price['PRINT_RATIO_PRICE']?> за
                                <?/*span id="<?=$itemIds['QUANTITY_MEASURE']?>"> / <?=$actualItem['ITEM_MEASURE']['TITLE']?></span*/?></div>
                                <span> / </span><span id="<?=$itemIds['QUANTITY_MEASURE']?>"><?=$actualItem['ITEM_MEASURE']['TITLE']?></span>
                                <span id="<?=$itemIds['PRICE_TOTAL']?>"></span>
                            </div>
                        </div>

                        <div data-entity="main-button-container" class="mb-3">

                        </div>
                        <div class="product-info product-btns" data-entity="main-button-container">
                            <?
                            $APPLICATION->IncludeComponent('bitrix:catalog.product.subscribe', '', array(
                                    'CUSTOM_SITE_ID'     => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
                                    'PRODUCT_ID'         => $arResult['ID'],
                                    'BUTTON_ID'          => $itemIds['SUBSCRIBE_LINK'],
                                    'BUTTON_CLASS'       => 'btn u-btn-outline-primary product-item-detail-buy-button',
                                    'DEFAULT_DISPLAY'    => !$actualItem['CAN_BUY'],
                                    'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
                                ), $component, array('HIDE_ICONS' => 'Y'));
                            ?>
                            <div id="<?= $itemIds['BASKET_ACTIONS_ID'] ?>" style="display: <?= ($actualItem['CAN_BUY'] ? '' : 'none') ?>;">
                                <ul class="product-btns-list">
                                    <li>
                                        <a href="javascript:void(0);"
                                           id="<?= $itemIds['ADD_BASKET_LINK'] ?>"
                                           class="<?= $showButtonClassName ?> btn btn-large btn-bask product-cart-btn add-to-cart-btn"
                                           data-text="Добавить в корзину"
                                           data-text-active="В корзине">Добавить
                                            в
                                            корзину</a>
                                    </li>
                                    <?/*li>
                                        <a class="<?= $buyButtonClassName ?> btn btn-large btn-full btn-border btn-border-alt product-fast-buy-btn"
                                           id="<?= $itemIds['BUY_LINK'] ?>"
                                           href="javascript:void(0);">
                                            Купить в один клик
                                        </a>
                                    </li*/?>
                                    <?/*li>
                                        <a href="#modal-registration" class="btn btn-large btn-full btn-border btn-border-alt product-registration-btn modal-open-btn">Зарегистистрируйтесь и получите скидку на первую покупку</a>
                                    </li*/?>
                                </ul>
                            </div>
                        </div>

                        <?/*div class="product-info product-state product-state-available">В наличии</div*/?>
                        <?
                        $frame = new \Bitrix\Main\Page\FrameHelper("store_".$arResult['ID']);
                            $frame->begin();
                            $APPLICATION->IncludeComponent('bitrix:catalog.store.amount', 'detail', array(
                                'ELEMENT_ID' => $arResult['ID'],
                                'STORE_PATH' => $arParams['STORE_PATH'],
                                'CACHE_TYPE' => 'A',
                                'CACHE_TIME' => '36000',
                                'MAIN_TITLE' => $arParams['MAIN_TITLE'],
                                'USE_MIN_AMOUNT' =>  $arParams['USE_MIN_AMOUNT'],
                                'MIN_AMOUNT' => $arParams['MIN_AMOUNT'],
                                'STORES' => $arParams['STORES'],
                                'SHOW_EMPTY_STORE' => $arParams['SHOW_EMPTY_STORE'],
                                'SHOW_GENERAL_STORE_INFORMATION' => $arParams['SHOW_GENERAL_STORE_INFORMATION'],
                                'USER_FIELDS' => $arParams['USER_FIELDS'],
                                'FIELDS' => $arParams['FIELDS']
                            ),
                                $component,
                                array('HIDE_ICONS' => 'Y')
                            );
                        $frame->end();
                        ?>



                        <div class="product-info product-delivery">
                            <div class="product-info-title">Доставка:</div>
                            <div class="product-info-desc">
                                <?

                                    $APPLICATION->IncludeComponent( "bxmaker:geoip.delivery",
                                        "detail",
                                        array(
                                            "COMPONENT_TEMPLATE" => ".default",
                                            "CACHE_TYPE" => "A",
                                            "CACHE_TIME" => "3600",
                                            "COMPOSITE_FRAME_MODE" => "A",
                                            "COMPOSITE_FRAME_TYPE" => "AUTO",
                                            "PRODUCT_ID" => $arResult['ID'],
                                            "IMG_SHOW" => "Y",
                                            "PROLOG" => "Способы доставки в ваш город - #CITY#",
                                            //                                    "EPILOG" => "Бесплатная доставка от 5000 руб."
                                        ),
                                        $component
                                    );
                                ?>
                            </div>
                        </div>
                        <div class="product-info product-short-desc">
                            <div class="product-info-title">Кратко о товаре:</div>
                            <div class="product-info-desc">
                                <?=$arResult['PROPERTIES']['KRATKOE_OPISANIE']['~VALUE']?>
                            </div>
                        </div>
                        <div class="product-info product-brand">
                            <div class="product-info-title">Бренд:</div>                            
                                <?
                                $dd=$manufacters->where("name",$arResult['PROPERTIES']['PROIZVODITEL']['VALUE'])->first();
                                $fileImg=CFile::GetFileArray($dd->detail_picture);

                                ?>

  							<?php
                            if($dd->active == 1)
                            {
                                ?>
                            <a href="\brands\<?print_r($dd->code)?>\" class="product-brand-logo">
                            <?php
                            }
                            else
                            {
                            ?>
                                <div class="product-brand-logo"></div>
                            <?php
                            }
                            ?>

                                <?if($fileImg['SRC']!=""):?>
                                    <img src="<?=$fileImg['SRC']?>" style="width: 114px;height: 37px" alt="">
                                <?else:?>
                                    <?=$arResult['PROPERTIES']['PROIZVODITEL']['VALUE']?>
                                <?endif;?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?
        $showOffersBlock = $haveOffers && !empty($arResult['OFFERS_PROP']);
        $mainBlockProperties = array_intersect_key($arResult['DISPLAY_PROPERTIES'], $arParams['MAIN_BLOCK_PROPERTY_CODE']);
        $showPropsBlock = !empty($mainBlockProperties) || $arResult['SHOW_OFFERS_PROPS'];
        $showBlockWithOffersAndProps = $showOffersBlock || $showPropsBlock;
        ?>
        <meta itemprop="name" content="<?=$name?>" />
        <meta itemprop="category" content="<?=$arResult['CATEGORY_PATH']?>" />
		<?
		if ($haveOffers)
		{
			foreach ($arResult['JS_OFFERS'] as $offer)
			{
				$currentOffersList = array();

				if (!empty($offer['TREE']) && is_array($offer['TREE']))
				{
					foreach ($offer['TREE'] as $propName => $skuId)
					{
						$propId = (int)substr($propName, 5);

						foreach ($skuProps as $prop)
						{
							if ($prop['ID'] == $propId)
							{
								foreach ($prop['VALUES'] as $propId => $propValue)
								{
									if ($propId == $skuId)
									{
										$currentOffersList[] = $propValue['NAME'];
										break;
									}
								}
							}
						}
					}
				}

				$offerPrice = $offer['ITEM_PRICES'][$offer['ITEM_PRICE_SELECTED']];
				?>
                <span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
			<meta itemprop="sku" content="<?=htmlspecialcharsbx(implode('/', $currentOffersList))?>" />
			<meta itemprop="price" content="<?=$offerPrice['RATIO_PRICE']?>" />
			<meta itemprop="priceCurrency" content="<?=$offerPrice['CURRENCY']?>" />
			<link itemprop="availability" href="http://schema.org/<?=($offer['CAN_BUY'] ? 'InStock' : 'OutOfStock')?>" />
		</span>
				<?
			}

			unset($offerPrice, $currentOffersList);
		}
		else
		{
			?>
            <span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
		<meta itemprop="price" content="<?=$price['RATIO_PRICE']?>" />
		<meta itemprop="priceCurrency" content="<?=$price['CURRENCY']?>" />
		<link itemprop="availability" href="http://schema.org/<?=($actualItem['CAN_BUY'] ? 'InStock' : 'OutOfStock')?>" />
	</span>
			<?
		}
		?>
		<?
		if ($haveOffers)
		{
			$offerIds = array();
			$offerCodes = array();

			$useRatio = $arParams['USE_RATIO_IN_RANGES'] === 'Y';

			foreach ($arResult['JS_OFFERS'] as $ind => &$jsOffer)
			{
				$offerIds[] = (int)$jsOffer['ID'];
				$offerCodes[] = $jsOffer['CODE'];

				$fullOffer = $arResult['OFFERS'][$ind];
				$measureName = $fullOffer['ITEM_MEASURE']['TITLE'];

				$strAllProps = '';
				$strMainProps = '';
				$strPriceRangesRatio = '';
				$strPriceRanges = '';

				if ($arResult['SHOW_OFFERS_PROPS'])
				{
					if (!empty($jsOffer['DISPLAY_PROPERTIES']))
					{
						foreach ($jsOffer['DISPLAY_PROPERTIES'] as $property)
						{
							$current = '<li class="product-item-detail-properties-item">
					<span class="product-item-detail-properties-name">'.$property['NAME'].'</span>
					<span class="product-item-detail-properties-dots"></span>
					<span class="product-item-detail-properties-value">'.(
								is_array($property['VALUE'])
									? implode(' / ', $property['VALUE'])
									: $property['VALUE']
								).'</span></li>';
							$strAllProps .= $current;

							if (isset($arParams['MAIN_BLOCK_OFFERS_PROPERTY_CODE'][$property['CODE']]))
							{
								$strMainProps .= $current;
							}
						}

						unset($current);
					}
				}

				if ($arParams['USE_PRICE_COUNT'] && count($jsOffer['ITEM_QUANTITY_RANGES']) > 1)
				{
					$strPriceRangesRatio = '('.Loc::getMessage(
							'CT_BCE_CATALOG_RATIO_PRICE',
							array('#RATIO#' => ($useRatio
									? $fullOffer['ITEM_MEASURE_RATIOS'][$fullOffer['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']
									: '1'
								).' '.$measureName)
						).')';

					foreach ($jsOffer['ITEM_QUANTITY_RANGES'] as $range)
					{
						if ($range['HASH'] !== 'ZERO-INF')
						{
							$itemPrice = false;

							foreach ($jsOffer['ITEM_PRICES'] as $itemPrice)
							{
								if ($itemPrice['QUANTITY_HASH'] === $range['HASH'])
								{
									break;
								}
							}

							if ($itemPrice)
							{
								$strPriceRanges .= '<dt>'.Loc::getMessage(
										'CT_BCE_CATALOG_RANGE_FROM',
										array('#FROM#' => $range['SORT_FROM'].' '.$measureName)
									).' ';

								if (is_infinite($range['SORT_TO']))
								{
									$strPriceRanges .= Loc::getMessage('CT_BCE_CATALOG_RANGE_MORE');
								}
								else
								{
									$strPriceRanges .= Loc::getMessage(
										'CT_BCE_CATALOG_RANGE_TO',
										array('#TO#' => $range['SORT_TO'].' '.$measureName)
									);
								}

								$strPriceRanges .= '</dt><dd>'.($useRatio ? $itemPrice['PRINT_RATIO_PRICE'] : $itemPrice['PRINT_PRICE']).'</dd>';
							}
						}
					}

					unset($range, $itemPrice);
				}

				$jsOffer['DISPLAY_PROPERTIES'] = $strAllProps;
				$jsOffer['DISPLAY_PROPERTIES_MAIN_BLOCK'] = $strMainProps;
				$jsOffer['PRICE_RANGES_RATIO_HTML'] = $strPriceRangesRatio;
				$jsOffer['PRICE_RANGES_HTML'] = $strPriceRanges;
			}

			$templateData['OFFER_IDS'] = $offerIds;
			$templateData['OFFER_CODES'] = $offerCodes;
			unset($jsOffer, $strAllProps, $strMainProps, $strPriceRanges, $strPriceRangesRatio, $useRatio);

			$jsParams = array(
				'CONFIG' => array(
					'USE_CATALOG' => $arResult['CATALOG'],
					'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
					'SHOW_PRICE' => true,
					'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
					'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
					'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
					'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
					'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
					'OFFER_GROUP' => $arResult['OFFER_GROUP'],
					'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
					'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
					'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
					'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
					'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
					'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
					'USE_STICKERS' => true,
					'USE_SUBSCRIBE' => $showSubscribe,
					'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
					'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
					'ALT' => $alt,
					'TITLE' => $title,
					'MAGNIFIER_ZOOM_PERCENT' => 200,
					'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
					'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
					'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
						? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
						: null
				),
				'PRODUCT_TYPE' => $arResult['PRODUCT']['TYPE'],
				'VISUAL' => $itemIds,
				'DEFAULT_PICTURE' => array(
					'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],
					'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']
				),
				'PRODUCT' => array(
					'ID' => $arResult['ID'],
					'ACTIVE' => $arResult['ACTIVE'],
					'NAME' => $arResult['~NAME'],
					'CATEGORY' => $arResult['CATEGORY_PATH']
				),
				'BASKET' => array(
					'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
					'BASKET_URL' => $arParams['BASKET_URL'],
					'SKU_PROPS' => $arResult['OFFERS_PROP_CODES'],
					'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
					'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
				),
				'OFFERS' => $arResult['JS_OFFERS'],
				'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
				'TREE_PROPS' => $skuProps
			);
		}
		else
		{
			$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
			if ($arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y' && !$emptyProductProperties)
			{
				?>
                <div id="<?=$itemIds['BASKET_PROP_DIV']?>" style="display: none;">
					<?
					if (!empty($arResult['PRODUCT_PROPERTIES_FILL']))
					{
						foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propId => $propInfo)
						{
							?>
                            <input type="hidden" name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]" value="<?=htmlspecialcharsbx($propInfo['ID'])?>">
							<?
							unset($arResult['PRODUCT_PROPERTIES'][$propId]);
						}
					}

					$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
					if (!$emptyProductProperties)
					{
						?>
                        <table>
							<?
							foreach ($arResult['PRODUCT_PROPERTIES'] as $propId => $propInfo)
							{
								?>
                                <tr>
                                    <td><?=$arResult['PROPERTIES'][$propId]['NAME']?></td>
                                    <td>
										<?
										if (
											$arResult['PROPERTIES'][$propId]['PROPERTY_TYPE'] === 'L'
											&& $arResult['PROPERTIES'][$propId]['LIST_TYPE'] === 'C'
										)
										{
											foreach ($propInfo['VALUES'] as $valueId => $value)
											{
												?>
                                                <label>
                                                    <input type="radio" name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]"
                                                           value="<?=$valueId?>" <?=($valueId == $propInfo['SELECTED'] ? '"checked"' : '')?>>
													<?=$value?>
                                                </label>
                                                <br>
												<?
											}
										}
										else
										{
											?>
                                            <select name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]">
												<?
												foreach ($propInfo['VALUES'] as $valueId => $value)
												{
													?>
                                                    <option value="<?=$valueId?>" <?=($valueId == $propInfo['SELECTED'] ? '"selected"' : '')?>>
														<?=$value?>
                                                    </option>
													<?
												}
												?>
                                            </select>
											<?
										}
										?>
                                    </td>
                                </tr>
								<?
							}
							?>
                        </table>
						<?
					}
					?>
                </div>
				<?
			}

			$jsParams = array(
				'CONFIG' => array(
					'USE_CATALOG' => $arResult['CATALOG'],
					'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
					'SHOW_PRICE' => !empty($arResult['ITEM_PRICES']),
					'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
					'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
					'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
					'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
					'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
					'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
					'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
					'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
					'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
					'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
					'USE_STICKERS' => true,
					'USE_SUBSCRIBE' => $showSubscribe,
					'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
					'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
					'ALT' => $alt,
					'TITLE' => $title,
					'MAGNIFIER_ZOOM_PERCENT' => 200,
					'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
					'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
					'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
						? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
						: null
				),
				'VISUAL' => $itemIds,
				'PRODUCT_TYPE' => $arResult['PRODUCT']['TYPE'],
				'PRODUCT' => array(
					'ID' => $arResult['ID'],
					'ACTIVE' => $arResult['ACTIVE'],
					'PICT' => reset($arResult['MORE_PHOTO']),
					'NAME' => $arResult['~NAME'],
					'SUBSCRIPTION' => true,
					'ITEM_PRICE_MODE' => $arResult['ITEM_PRICE_MODE'],
					'ITEM_PRICES' => $arResult['ITEM_PRICES'],
					'ITEM_PRICE_SELECTED' => $arResult['ITEM_PRICE_SELECTED'],
					'ITEM_QUANTITY_RANGES' => $arResult['ITEM_QUANTITY_RANGES'],
					'ITEM_QUANTITY_RANGE_SELECTED' => $arResult['ITEM_QUANTITY_RANGE_SELECTED'],
					'ITEM_MEASURE_RATIOS' => $arResult['ITEM_MEASURE_RATIOS'],
					'ITEM_MEASURE_RATIO_SELECTED' => $arResult['ITEM_MEASURE_RATIO_SELECTED'],
					'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
					'SLIDER' => $arResult['MORE_PHOTO'],
					'CAN_BUY' => $arResult['CAN_BUY'],
					'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
					'QUANTITY_FLOAT' => is_float($arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']),
					'MAX_QUANTITY' => $arResult['PRODUCT']['QUANTITY'],
					'STEP_QUANTITY' => $arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'],
					'CATEGORY' => $arResult['CATEGORY_PATH']
				),
				'BASKET' => array(
					'ADD_PROPS' => $arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y',
					'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
					'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
					'EMPTY_PROPS' => $emptyProductProperties,
					'BASKET_URL' => $arParams['BASKET_URL'],
					'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
					'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
				)
			);
			unset($emptyProductProperties);
		}

		if ($arParams['DISPLAY_COMPARE'])
		{
			$jsParams['COMPARE'] = array(
				'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
				'COMPARE_DELETE_URL_TEMPLATE' => $arResult['~COMPARE_DELETE_URL_TEMPLATE'],
				'COMPARE_PATH' => $arParams['COMPARE_PATH']
			);
		}
		?>
    </div>

    <?
    if(!$arResult['REVIEWS']){$arResult['REVIEWS'] = [];}
    $all_count = count($arResult['REVIEWS']);
    ?>
    <div class="section product-tabs-section">
        <div class="container">
            <div class="product-tabs-nav-wrapp">
                <ul class="product-tabs-nav tabs-nav" data-tabs="#product-tabs">
                    <li class="active"><a href="#product-tab-1">Описание товара</a></li>
                    <li><a href="#product-tab-2">Отзывы (<?=$all_count;?>)</a></li>
                    <?if($arResult["PROPERTIES"]["VIDEO"]["~VALUE"]):?>
                        <li><a href="#product-tab-3">Видеообзор</a></li>
                    <?endif;?>
                    <?if($arResult['ARTICLES']):?>
                        <li><a href="#product-tab-4">Статьи</a></li>
                    <?endif;?>
                </ul>
            </div>
            <div id="product-tabs" class="tabs-wrapp">
                <div id="product-tab-1" class="tab-block active">
                    <div class="product-tab-info-row flex-row">
                        <div class="product-tab-info-col flex-row-item">
                            <div class="product-tab-section toggle-mobile-wrapp">
                                <div class="product-tab-title">Описание:</div>
                                <div class="product-desc toggle-mobile-block content-text">
									<? $element->echoDescription() ?>
                                </div>
                                <a href="#" class="toggle-mobile-link" data-text="Развернуть описание"
                                   data-text-active="Свернуть описание">
                                    <span>Развернуть описание</span>
                                    <i>
                                        <svg width="24" height="24">
                                            <use xlink:href="#icon-chevron-down"/>
                                        </svg>
                                    </i>
                                </a>
                            </div>
                        </div>
                        <div class="product-tab-info-col flex-row-item">
                            <div class="product-tab-section">
                                <div class="product-tab-title">Технические характеристики:</div>
                                <div class="product-characteristics">
                                    <table class="product-characteristics-table">
										<? $element->echoSpecification(); ?>
                                    </table>
                                </div>
                            </div>
                            <?if($arResult['FILES']):?>
                                <div class="product-tab-section">
                                    <div class="product-tab-title">Документация:</div>
                                    <ul class="product-docs">
                                        <?foreach($arResult['FILES'] as $doc):?>
                                            <li>
                                                <a href="<?= $doc['SRC'] ?>" class="doc-link" download target="_blank">
                                                    <svg width="34" height="34">
                                                        <use xlink:href="#icon-doc"/>
                                                    </svg>
                                                    <span class="doc-link-body">
                                                        <span class="doc-link-title"><?=$doc['NAME']?></span>
                                                        <span class="doc-link-size">Скачать: <?=$doc['FILE_SIZE']?></span>
                                                    </span>
                                                </a>
                                            </li>
                                        <?endforeach;?>
                                    </ul>
                                </div>
                            <?endif;?>
                            <div class="product-tab-section">
                                <div class="product-tab-title">Производство:</div>
                                <div class="product-made-in">
                                    <?
                                    $dd=$countries->where("name",$arResult['PROPERTIES']['STRANA']['VALUE'])->first();
									$fileImg=CFile::GetFileArray($dd->detail_picture);
                                    ?>
                                    <i><img src="<?=$fileImg['SRC']?>" alt=""></i>
                                    <span><?=$dd->name?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="product-tab-2" class="tab-block">

                    <div class="product-tab-section">
                        <div class="tab-product-reviews__head">
                            <div class="tab-product-reviews__title">
                                <div class="product-tab-title product-tab-review-title">Все отзывы <span>(<?=$all_count?>)</span></div>
                                <?global $USER;
                                if(!$USER->IsAuthorized()):?>
                                    <div class="custom-modal modal-user-enter">
                                        <div class="custom-modal__content">
                                            <div class="custom-modal__close"><svg class="icon"><use xlink:href="#icon-close"></use></svg></div>
                                            <div class="custom-modal__description">
                                                Для того, чтобы написать отзыв вам необходимо войти в свой аккаунт или зарегистрироваться на сайте
                                            </div>
                                            <div class="custom-modal__footer">
                                                <a href="javascript:void(0)" onclick="$('.modal-open-btn:first').click()">Регистрация</a> <span>|</span> <a onclick="$('.modal-open-btn:first').click()" href="javascript:void(0)">Вход</a>
                                            </div>
                                        </div>
                                        <div class="custom-modal__bg"></div>
                                    </div>
                                <?endif;?>
                                <a href="#" class="<?if(!$USER->IsAuthorized()):?>js-open-user-enter <?endif;?>btn btn-review-toggle desktop"><span>Написать отзыв</span><span>Закрыть отзыв</span></a>
                            </div>
                            <div class="tab-product-reviews__main">
                                <div class="reviews-main">
                                    <div class="reviews-main__head">
                                        <div class="review-main__val"><?=$arResult['AVG_RATING']?></div>
                                        <div class="review-main__description">На основании<br> <?=$all_count;?> <?=endingsForm($all_count,'отзыва','отзывов','отзывов');?></div>
                                        <div class="review-main__stars">
                                            <!--<div class="rating"><div class="rating-state" style="width:<?=(($arResult['AVG_RATING']/5)*100);?>%;"></div></div>-->
                                            <div class="rating"><div class="rating-state" style="width:<?=(($rating/5)*100);?>%;"></div></div>
                                        </div>
                                    </div>
                                    <div class="reviews-main__values">
                                        <?
                                        if($arResult['REVIEWS_GROUP'][5]){
                                            $percent_5 = round((count($arResult['REVIEWS_GROUP'][5])*100)/$all_count);
                                        }
                                        if($arResult['REVIEWS_GROUP'][4]){
                                            $percent_4 = round((count($arResult['REVIEWS_GROUP'][4])*100)/$all_count);
                                        }
                                        if($arResult['REVIEWS_GROUP'][3]){
                                            $percent_3 = round((count($arResult['REVIEWS_GROUP'][3])*100)/$all_count);
                                        }
                                        if($arResult['REVIEWS_GROUP'][2]){
                                            $percent_2 = round((count($arResult['REVIEWS_GROUP'][2])*100)/$all_count);
                                        }
                                        if($arResult['REVIEWS_GROUP'][1]){
                                            $percent_1 = round((count($arResult['REVIEWS_GROUP'][1])*100)/$all_count);
                                        }
                                        ?>
                                        <div class="review-main__value">
                                            <div class="review-main__grade">5</div>
                                            <div class="review-main__slider"><div class="review-main__slider-track" style="width: <?=$percent_5;?>%"></div></div>
                                            <div class="review-main__percentage"><?=$percent_5;?><?if($percent_5):?>%<?endif;?></div>
                                        </div>
                                        <div class="review-main__value">
                                            <div class="review-main__grade">4</div>
                                            <div class="review-main__slider"><div class="review-main__slider-track" style="width: <?=$percent_4;?>%"></div></div>
                                            <div class="review-main__percentage"><?=$percent_4;?><?if($percent_4):?>%<?endif;?></div>
                                        </div>
                                        <div class="review-main__value">
                                            <div class="review-main__grade">3</div>
                                            <div class="review-main__slider"><div class="review-main__slider-track" style="width: <?=$percent_3;?>%"></div></div>
                                            <div class="review-main__percentage"><?=$percent_3;?><?if($percent_3):?>%<?endif;?></div>
                                        </div>
                                        <div class="review-main__value">
                                            <div class="review-main__grade">2</div>
                                            <div class="review-main__slider"><div class="review-main__slider-track" style="width: <?=$percent_2;?>%"></div></div>
                                            <div class="review-main__percentage"><?=$percent_2;?><?if($percent_2):?>%<?endif;?></div>
                                        </div>
                                        <div class="review-main__value">
                                            <div class="review-main__grade">1</div>
                                            <div class="review-main__slider"><div class="review-main__slider-track" style="width: <?=$percent_1;?>%"></div></div>
                                            <div class="review-main__percentage"><?=$percent_1;?><?if($percent_1):?>%<?endif;?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="javascript:void(0)" class="btn btn-review-toggle mobile"><span>Написать отзыв</span><span>Закрыть отзыв</span></a>
                        </div>
                        <?
                        global $USER;
                        if($USER->IsAuthorized()):?>
                            <?$APPLICATION->IncludeComponent(
                                "prymery:feedback.form",
                                "add-reviews",
                                array(
                                    "ARFIELDS" => array(
                                        0 => "RATING",
                                        1 => "MESSAGE",
                                        2 => "FILES",
                                        2 => "USER_ID",
                                    ),
                                    "REQUEST_ARFIELDS" => array(
                                        0 => "MESSAGE",
                                        1 => "RATING",
                                    ),
                                    "COMPONENT_TEMPLATE" => ".default",
                                    "EMAIL_TO" => "apdnnb@mail.ru",
                                    "SUCCESS_MESSAGE_TITLE" => "Ваш отзыв отправлен!",
                                    "SUCCESS_MESSAGE" => "Отзыв будет опубликован после проверки модератором.",
                                    "GOAL_METRIKA" => "",
                                    "GOAL_ANALITICS" => "",
                                    "USE_CAPTCHA" => "N",
                                    "SAVE" => "Y",
                                    "ELEMENT_ID" => $arResult['ID'],
                                    "BUTTON" => "Отправить",
                                    "TITLE" => "Написать отзыв",
                                    "SUBTITLE" => "",
                                    "PERSONAL_DATA" => "Y",
                                    "PERSONAL_DATA_PAGE" => "/policy/",
                                    "LEAD_IBLOCK" => 77,
                                    "LINK_ELEMENT_IBLOCK" => IBLOCK_CATALOG_ID
                                ),
                                false
                            ); ?>
                        <?endif;?>
                        <div class="product-tab-reviews">
                            <?foreach($arResult['REVIEWS'] as $item):?>
                                <div class="product-review">
                                    <div class="product-review-name"><?=$item['NAME']?></div>
                                    <div class="product-review-info">
                                        <div class="rating">
                                            <div class="rating-state" style="width:<?=(($item['PROPERTY_RATING_VALUE']/5)*100);?>%;"></div>
                                        </div>
                                        <div class="product-review-date">
                                            <?=FormatDate(array("" => 'j F Y'), MakeTimeStamp($item["DATE_CREATE"]), time());?>
                                        </div>
                                    </div>
                                    <div class="product-review-text">
                                        <p><?=$item['PREVIEW_TEXT']?></p>
                                    </div>
                                    <?if($item['FILES']):?>
                                        <div class="product-review-imgs">
                                            <button class="slider-arrow slider-arrow-prev" aria-label="Назад">
                                                <svg width="30" height="30"><use xlink:href="#icon-arrow-down"/></svg>
                                            </button>
                                            <button class="slider-arrow slider-arrow-next" aria-label="Вперед">
                                                <svg width="30" height="30"><use xlink:href="#icon-arrow-down"/></svg>
                                            </button>
                                            <div class="product-review-imgs-slider swiper-container">
                                                <div class="swiper-wrapper">
                                                    <?foreach($item['FILES'] as $file):?>
                                                        <div class="product-review-imgs-slide swiper-slide">
                                                            <a href="<?=$file['BIG']?>" data-fancybox="product-review-<?=$item['ID']?>">
                                                                <img src="<?=$file['SMALL']['src']?>" alt="">
                                                            </a>
                                                        </div>
                                                    <?endforeach;?>
                                                </div>
                                            </div>
                                        </div>
                                    <?endif;?>
                                </div>
                            <?endforeach;?>
                        </div>
                        <?/*div class="read-more-btn-wrapp">
                            <a href="#" class="btn read-more-btn">Показать ещё</a>
                        </div*/?>
                    </div>

                </div>

                <?if($arResult["PROPERTIES"]["VIDEO"]["~VALUE"]):?>
                    <div id="product-tab-3" class="tab-block">
                        <div class="product-tab-section">
                            <div class="product-tab-title product-tab-video-title"><div>Видеообзор</div> <b><?=$arResult["NAME"]?></b></div>
                            <div class="product-video">
                                <a href="<?=$arResult["PROPERTIES"]["VIDEO"]["~VALUE"]?>" class="product-video-link" data-fancybox data-fancybox-type="iframe">
                                    <span class="product-video-link-logo">
                                        <img src="img/youtube-logo.svg" alt="">
                                    </span>
                                    <span class="product-video-link-play">
                                        <i></i>
                                        <span>Смотреть</span>
                                    </span>
                                    <span class="product-video-link-img cover-img">
                                        <img src="<?=getVideoCover($arResult["PROPERTIES"]["VIDEO"]["~VALUE"])?>" alt="">
                                    </span>
                                </a>
                                <div class="product-video-body">
                                    <div class="product-video-desc content-text">
                                        <p>Ознакомиться с видеопрезентацией различных товаров медицинского назначения, можно на нашем Youtube канале. Перейдя по ссылке, Вы найдете более 100 видеороликов, сможете увидеть комплектацию, внешний вид, характеристики товаров и многое другое. Подписывайтесь на наш канал, будьте всегда в курсе новинок от компании Гипермед - Центра торговли медицинскими товарами!
                                    </div>
                                    <a href="https://www.youtube.com/channel/UCMb0--_oRvzGGYv-Bu_w8zQ" target="_blank" class="product-video-more-link">Посмотреть все видеопрезентации&nbsp;&#62;</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?endif;?>
                <?if($arResult['ARTICLES']):?>
                    <div id="product-tab-4" class="tab-block">
                        <div class="product-tab-section">
                            <div class="product-tab-title product-tab-articles-title">Статьи</div>
                            <div class="product-articles-row articles-row flex-row">
                                <? foreach($arResult['ARTICLES'] as $article):?>
                                <div class="articles-col flex-row-item swiper-slide">
                                    <div class="article-item">
                                        <a href="<?=$article["DETAIL_PAGE_URL"]?>" class="item-link" aria-label="Читать статью"></a>
                                        <div class="article-item-img">
                                            <span><img src="<?=$article["PREVIEW_PICTURE"]?>" alt="<?=$article["NAME"]?>"></span>
                                        </div>
                                        <div class="article-item-body">
                                            <div class="article-item-title"><?=$article["NAME"]?></div>
                                            <div class="article-item-desc"><?=cut_string($article["PREVIEW_TEXT"],100)?></div>
                                            <div class="article-item-foot">
                                                <div class="article-item-views">
                                                    <svg width="20" height="20"><use xlink:href="#icon-eye"/></svg>
                                                    <span><?=$article["SHOW_COUNTER"]?></span>
                                                </div>
                                                <div class="article-item-btn">
                                                    Читать >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?endforeach;?>
                            </div>
                        </div>
                    </div>
                <?endif;?>
            </div>
            <div class="product-programm visible-tablet">
                <?if($element->getIPRA()):?>
                    <div class="product-programm-icon">
                        <img src="img/product-programm-icon.svg" alt="">
                    </div>
                    <div class="product-programm-body">
                        <div class="product-programm-desc">Данный товар участвует в индивидуальной программе реабилитации</div>
                        <a href="/ipra/" class="product-programm-link">Подробнее&nbsp;&#62;</a>
                    </div>
                <?endif?>
            </div>
        </div>
    </div>
<div class="bx-catalog-element<?=$themeClass?>"  itemscope itemtype="http://schema.org/Product">

	<!--Small Card-->
	<!--Top tabs-->


</div>
<script>
	BX.message({
		ECONOMY_INFO_MESSAGE: '<?=GetMessageJS('CT_BCE_CATALOG_ECONOMY_INFO2')?>',
		TITLE_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR')?>',
		TITLE_BASKET_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS')?>',
		BASKET_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR')?>',
		BTN_SEND_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS')?>',
        BTN_MESSAGE_DETAIL_BASKET_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_BASKET_REDIRECT')?>',
		BTN_MESSAGE_CLOSE: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE')?>',
		BTN_MESSAGE_CLOSE_POPUP: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE_POPUP')?>',
		TITLE_SUCCESSFUL: '<?=GetMessageJS('CT_BCE_CATALOG_ADD_TO_BASKET_OK')?>',
		COMPARE_MESSAGE_OK: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_OK')?>',
		COMPARE_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_UNKNOWN_ERROR')?>',
		COMPARE_TITLE: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_TITLE')?>',
		BTN_MESSAGE_COMPARE_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT')?>',
		PRODUCT_GIFT_LABEL: '<?=GetMessageJS('CT_BCE_CATALOG_PRODUCT_GIFT_LABEL')?>',
		PRICE_TOTAL_PREFIX: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_PRICE_TOTAL_PREFIX')?>',
		RELATIVE_QUANTITY_MANY: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_MANY'])?>',
		RELATIVE_QUANTITY_FEW: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_FEW'])?>',
		SITE_ID: '<?=CUtil::JSEscape($component->getSiteId())?>'
	});

	var <?=$obName?> = new JCCatalogElement(<?=CUtil::PhpToJSObject($jsParams, false, true)?>);
</script>
<?unset($actualItem, $itemIds, $jsParams);


if(!$arResult['OFFERS']):?>
    <script>
        $(document).ready(function(){
           $('.select-number-btn-plus').click();
           $('.select-number-btn-minus').click();
        });
    </script>
<?endif;?>