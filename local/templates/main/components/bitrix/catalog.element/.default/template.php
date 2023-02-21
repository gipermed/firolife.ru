<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

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
$this->addExternalCss('/bitrix/css/main/bootstrap.css');

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
	'DESCRIPTION_ID' => $mainId.'_description',
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
	$actualItem = $arResult['OFFERS'][$arResult['OFFERS_SELECTED']] ?? reset($arResult['OFFERS']);
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

if ($arParams['SHOW_SKU_DESCRIPTION'] === 'Y')
{
	$skuDescription = false;
	foreach ($arResult['OFFERS'] as $offer)
	{
		if ($offer['DETAIL_TEXT'] != '' || $offer['PREVIEW_TEXT'] != '')
		{
			$skuDescription = true;
			break;
		}
	}
	$showDescription = $skuDescription || !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
}
else
{
	$showDescription = !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
}

$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
$buyButtonClassName = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);
$showButtonClassName = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
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
?>

<style>
    #SDEK_pvz
    {display: none}
</style>
<div class="bx-catalog-element bx-<?=$arParams['TEMPLATE_THEME']?>" id="<?=$itemIds['ID']?>"
	itemscope itemtype="http://schema.org/Product">
	<div class="container-fluid">
		<?php
		if ($arParams['DISPLAY_NAME'] === 'Y')
		{
			?>
			<div class="row">
				<div class="col-xs-12">
					<h1 class="bx-title section-title"><?=$arResult['NAME']?><?//=$name?></h1>
				</div>
			</div>
			<?php
		}
		?>
        <div class="product-head">
            <div class="product-head-content">
                <h1 class="product-title section-title"><?=$arResult["NAME"]?></h1>
                <div class="product-head-info" style="max-width: 700px;">
                    <?if($arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]):?>
                        <div class="product-code">
                            Артикул:
                            <span><?=$arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]?></span>
                        </div>
                    <?endif;?>
                    <div class="product-reviews">
                        <i class="visible-mobile">
                            <svg width="16" height="16"><use xlink:href="#icon-star-fill"/></svg>
                        </i>
                        <?
                        $APPLICATION->IncludeComponent(
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
                        );
                        ?>
                        <a href="#" class="product-reviews-count">120 отзывов</a>
                    </div>
                    <a href="#" class="add-to-favorites-btn product-favorites">
                        <svg width="24" height="24"><use xlink:href="#icon-like"/></svg>
                        <span>В избранное</span>
                    </a>
                </div>
            </div>
            <div class="product-programm hidden-tablet">
                <?//if($element->getIPRA()):?>
                    <div class="product-programm-icon">
                        <img src="<?=SITE_TEMPLATE_PATH?>assets/img/product-programm-icon.svg" alt="">
                    </div>
                    <div class="product-programm-body">
                        <div class="product-programm-desc">Данный товар участвует в индивидуальной программе реабилитации</div>
                        <a href="#" class="product-programm-link">Подробнее&nbsp;&#62;</a>
                    </div>
                <?//endif?>
            </div>
        </div>





		<div class="row">
			<div class="col-md-6 col-sm-12">
				<div class="product-item-detail-slider-container" id="<?=$itemIds['BIG_SLIDER_ID']?>">
					<span class="product-item-detail-slider-close" data-entity="close-popup"></span>
					<div class="product-item-detail-slider-block
						<?=($arParams['IMAGE_RESOLUTION'] === '1by1' ? 'product-item-detail-slider-block-square' : '')?>"
						data-entity="images-slider-block">
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
                                    unset($explode_name2);
                                    $explode_name2 = explode('YM_',$actualItem['PROPERTIES']['MORE_PHOTO']['DESCRIPTION'][$key]);
                                    if($explode_name2[1]){
                                        continue;
                                    }
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
                                        $explode_name2 = explode('YM_',$offer['PROPERTIES']['MORE_PHOTO']['DESCRIPTION'][$keyPhoto]);
                                        if($explode_name2[1]){
                                            continue;
                                        }
										?>
										<div class="product-item-detail-slider-controls-image<?=($keyPhoto == 0 ? ' active' : '')?>"
											data-entity="slider-control" data-value="<?=$offer['ID'].'_'.$photo['ID']?>">
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
                                        $explode_name2 = explode('YM_',$actualItem['PROPERTIES']['MORE_PHOTO']['DESCRIPTION'][$key]);
                                        if($explode_name2[1]){
                                            continue;
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

			<div class="col-md-6 col-sm-12">
				<div class="row">
					<div class="col-sm-6">
						<div class="product-item-detail-info-section">
							<?php
							foreach ($arParams['PRODUCT_INFO_BLOCK_ORDER'] as $blockName)
							{
								switch ($blockName)
								{
									case 'sku':
										if ($haveOffers && !empty($arResult['OFFERS_PROP']))
										{
											?>
											<div id="<?=$itemIds['TREE_ID']?>">
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
																		<?foreach ($skuProperty['VALUES'] as &$value){
																			$value['NAME'] = htmlspecialcharsbx($value['NAME']);
                                                                            if ($skuProperty['SHOW_MODE'] === 'PICT'){
																				?>
																				<li class="product-item-scu-item-color-container" title="<?=$value['NAME']?>"
																					data-treevalue="<?=$propertyId?>_<?=$value['ID']?>"
																					data-onevalue="<?=$value['ID']?>">
																					<div class="product-item-scu-item-color-block">
																						<div class="product-item-scu-item-color" title="<?=$value['NAME']?>" style="background-image: url('<?=$value['PICT']['SRC']?>');">
																						</div>
																					</div>
																				</li>
																				<?php
																			}else{
                                                                                if ($skuProperty['NAME'] == "Размер"){?>

                                                                                    <li class="product-item-scu-item-text-container" title="<?=$value['NAME']?>"
                                                                                        data-treevalue="<?=$propertyId?>_<?=$value['ID']?>"
                                                                                        data-onevalue="<?=$value['ID']?>">
                                                                                        <div class="product-item-scu-item-text-block" >
                                                                                            <div class="product-item-scu-item-text "><?=$value['NAME']?></div>
                                                                                        </div>
                                                                                    </li>
                                                                                <?}else{
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
								}
							}
							?>
						</div>
					<!--</div>
					<div class="col-sm-6">-->
                            <div class="product-item-detail-pay-block">
                                <?php
                                foreach ($arParams['PRODUCT_PAY_BLOCK_ORDER'] as $blockName)
                                {
                                    switch ($blockName)
                                    {
                                        case 'rating':
                                            if ($arParams['USE_VOTE_RATING'] === 'Y')
                                            {
                                                ?>
                                                <div class="product-item-detail-info-container">
                                                    <?php
                                                    $APPLICATION->IncludeComponent(
                                                        'bitrix:iblock.vote',
                                                        'stars',
                                                        array(
                                                            'CUSTOM_SITE_ID' => $arParams['CUSTOM_SITE_ID'] ?? null,
                                                            'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
                                                            'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                                                            'ELEMENT_ID' => $arResult['ID'],
                                                            'ELEMENT_CODE' => '',
                                                            'MAX_VOTE' => '5',
                                                            'VOTE_NAMES' => array('1', '2', '3', '4', '5'),
                                                            'SET_STATUS_404' => 'N',
                                                            'DISPLAY_AS_RATING' => $arParams['VOTE_DISPLAY_AS_RATING'],
                                                            'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                                                            'CACHE_TIME' => $arParams['CACHE_TIME']
                                                        ),
                                                        $component,
                                                        array('HIDE_ICONS' => 'Y')
                                                    );
                                                    ?>
                                                </div>
                                                <?php
                                            }

                                            break;

                                        case 'price':
                                            ?>
                                            <div class="product-item-detail-info-container">
                                                <?php
                                                if ($arParams['SHOW_OLD_PRICE'] === 'Y')
                                                {
                                                    ?>
                                                    <div class="product-item-detail-price-old" id="<?=$itemIds['OLD_PRICE_ID']?>"
                                                         style="display: <?=($showDiscount ? '' : 'none')?>;">
                                                        <?=($showDiscount ? $price['PRINT_RATIO_BASE_PRICE'] : '')?>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                                <div class="product-item-detail-price-current" id="<?=$itemIds['PRICE_ID']?>">
                                                    <?=$price['PRINT_RATIO_PRICE']?>
                                                </div>
                                                <?php
                                                if ($arParams['SHOW_OLD_PRICE'] === 'Y')
                                                {
                                                    ?>
                                                    <div class="item_economy_price" id="<?=$itemIds['DISCOUNT_PRICE_ID']?>"
                                                         style="display: <?=($showDiscount ? '' : 'none')?>;">
                                                        <?php
                                                        if ($showDiscount)
                                                        {
                                                            echo Loc::getMessage('CT_BCE_CATALOG_ECONOMY_INFO2', array('#ECONOMY#' => $price['PRINT_RATIO_DISCOUNT']));
                                                        }
                                                        ?>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <?php
                                            break;

                                        case 'priceRanges':
                                            if ($arParams['USE_PRICE_COUNT'])
                                            {
                                                $showRanges = !$haveOffers && count($actualItem['ITEM_QUANTITY_RANGES']) > 1;
                                                $useRatio = $arParams['USE_RATIO_IN_RANGES'] === 'Y';
                                                ?>
                                                <div class="product-item-detail-info-container"
                                                    <?=$showRanges ? '' : 'style="display: none;"'?>
                                                     data-entity="price-ranges-block">
                                                    <div class="product-item-detail-info-container-title">
                                                        <?=$arParams['MESS_PRICE_RANGES_TITLE']?>
                                                        <span data-entity="price-ranges-ratio-header">
                                                            (<?=(Loc::getMessage(
                                                                    'CT_BCE_CATALOG_RATIO_PRICE',
                                                                    array('#RATIO#' => ($useRatio ? $measureRatio : '1').' '.$actualItem['ITEM_MEASURE']['TITLE'])
                                                                ))?>)
                                                        </span>
                                                    </div>
                                                    <dl class="product-item-detail-properties" data-entity="price-ranges-body">
                                                        <?php
                                                        if ($showRanges)
                                                        {
                                                            foreach ($actualItem['ITEM_QUANTITY_RANGES'] as $range)
                                                            {
                                                                if ($range['HASH'] !== 'ZERO-INF')
                                                                {
                                                                    $itemPrice = false;

                                                                    foreach ($arResult['ITEM_PRICES'] as $itemPrice)
                                                                    {
                                                                        if ($itemPrice['QUANTITY_HASH'] === $range['HASH'])
                                                                        {
                                                                            break;
                                                                        }
                                                                    }

                                                                    if ($itemPrice)
                                                                    {
                                                                        ?>
                                                                        <dt>
                                                                            <?php
                                                                            echo Loc::getMessage(
                                                                                    'CT_BCE_CATALOG_RANGE_FROM',
                                                                                    array('#FROM#' => $range['SORT_FROM'].' '.$actualItem['ITEM_MEASURE']['TITLE'])
                                                                                ).' ';

                                                                            if (is_infinite($range['SORT_TO']))
                                                                            {
                                                                                echo Loc::getMessage('CT_BCE_CATALOG_RANGE_MORE');
                                                                            }
                                                                            else
                                                                            {
                                                                                echo Loc::getMessage(
                                                                                    'CT_BCE_CATALOG_RANGE_TO',
                                                                                    array('#TO#' => $range['SORT_TO'].' '.$actualItem['ITEM_MEASURE']['TITLE'])
                                                                                );
                                                                            }
                                                                            ?>
                                                                        </dt>
                                                                        <dd><?=($useRatio ? $itemPrice['PRINT_RATIO_PRICE'] : $itemPrice['PRINT_PRICE'])?></dd>
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </dl>
                                                </div>
                                                <?php
                                                unset($showRanges, $useRatio, $itemPrice, $range);
                                            }

                                            break;

                                        case 'quantityLimit':
                                            if ($arParams['SHOW_MAX_QUANTITY'] !== 'N')
                                            {
                                                if ($haveOffers)
                                                {
                                                    ?>
                                                    <div class="product-item-detail-info-container" id="<?=$itemIds['QUANTITY_LIMIT']?>" style="display: none;">
                                                        <div class="product-item-detail-info-container-title">
                                                            <?=$arParams['MESS_SHOW_MAX_QUANTITY']?>:
                                                            <span class="product-item-quantity" data-entity="quantity-limit-value"></span>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                else
                                                {
                                                    if (
                                                        $measureRatio
                                                        && (float)$actualItem['PRODUCT']['QUANTITY'] > 0
                                                        && $actualItem['CHECK_QUANTITY']
                                                    )
                                                    {
                                                        ?>
                                                        <div class="product-item-detail-info-container" id="<?=$itemIds['QUANTITY_LIMIT']?>">
                                                            <div class="product-item-detail-info-container-title">
                                                                <?=$arParams['MESS_SHOW_MAX_QUANTITY']?>:
                                                                <span class="product-item-quantity" data-entity="quantity-limit-value">
																<?php
                                                                if ($arParams['SHOW_MAX_QUANTITY'] === 'M')
                                                                {
                                                                    if ((float)$actualItem['PRODUCT']['QUANTITY'] / $measureRatio >= $arParams['RELATIVE_QUANTITY_FACTOR'])
                                                                    {
                                                                        echo $arParams['MESS_RELATIVE_QUANTITY_MANY'];
                                                                    }
                                                                    else
                                                                    {
                                                                        echo $arParams['MESS_RELATIVE_QUANTITY_FEW'];
                                                                    }
                                                                }
                                                                else
                                                                {
                                                                    echo $actualItem['PRODUCT']['QUANTITY'].' '.$actualItem['ITEM_MEASURE']['TITLE'];
                                                                }
                                                                ?>
															</span>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                            }

                                            break;

                                        case 'quantity':
                                            if ($arParams['USE_PRODUCT_QUANTITY'])
                                            {
                                                ?>
                                                <div class="product-item-detail-info-container" style="<?=(!$actualItem['CAN_BUY'] ? 'display: none;' : '')?>"
                                                     data-entity="quantity-block">
                                                    <div class="product-item-detail-info-container-title"><?=Loc::getMessage('CATALOG_QUANTITY')?></div>
                                                    <div class="product-item-amount">
                                                        <div class="product-item-amount-field-container">
                                                            <span class="product-item-amount-field-btn-minus no-select" id="<?=$itemIds['QUANTITY_DOWN_ID']?>"></span>
                                                            <input class="product-item-amount-field" id="<?=$itemIds['QUANTITY_ID']?>" type="number"
                                                                   value="<?=$price['MIN_QUANTITY']?>">
                                                            <span class="product-item-amount-field-btn-plus no-select" id="<?=$itemIds['QUANTITY_UP_ID']?>"></span>
                                                            <span class="product-item-amount-description-container">
															<span id="<?=$itemIds['QUANTITY_MEASURE']?>">
																<?=$actualItem['ITEM_MEASURE']['TITLE']?>
															</span>
															<span id="<?=$itemIds['PRICE_TOTAL']?>"></span>
														</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }

                                            break;

                                        case 'buttons':
                                            ?>
                                            <div data-entity="main-button-container">
                                                <div id="<?=$itemIds['BASKET_ACTIONS_ID']?>" style="display: <?=($actualItem['CAN_BUY'] ? '' : 'none')?>;">
                                                    <?php
                                                    if ($showAddBtn)
                                                    {
                                                        ?>
                                                        <div class="product-item-detail-info-container">
                                                            <a class="btn <?=$showButtonClassName?> product-item-detail-buy-button" id="<?=$itemIds['ADD_BASKET_LINK']?>"
                                                               href="javascript:void(0);">
                                                                <span><?=$arParams['MESS_BTN_ADD_TO_BASKET']?></span>
                                                            </a>
                                                        </div>
                                                        <?php
                                                    }

                                                    if ($showBuyBtn)
                                                    {
                                                        ?>
                                                        <div class="product-item-detail-info-container">
                                                            <a class="btn <?=$buyButtonClassName?> product-item-detail-buy-button" id="<?=$itemIds['BUY_LINK']?>"
                                                               href="javascript:void(0);">
                                                                <span><?=$arParams['MESS_BTN_BUY']?></span>
                                                            </a>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                <?php
                                                if ($showSubscribe)
                                                {
                                                    ?>
                                                    <div class="product-item-detail-info-container">
                                                        <?php
                                                        $APPLICATION->IncludeComponent(
                                                            'bitrix:catalog.product.subscribe',
                                                            '',
                                                            array(
                                                                'CUSTOM_SITE_ID' => $arParams['CUSTOM_SITE_ID'] ?? null,
                                                                'PRODUCT_ID' => $arResult['ID'],
                                                                'BUTTON_ID' => $itemIds['SUBSCRIBE_LINK'],
                                                                'BUTTON_CLASS' => 'btn btn-default product-item-detail-buy-button',
                                                                'DEFAULT_DISPLAY' => !$actualItem['CAN_BUY'],
                                                                'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
                                                            ),
                                                            $component,
                                                            array('HIDE_ICONS' => 'Y')
                                                        );
                                                        ?>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                                <div class="product-item-detail-info-container">
                                                    <a class="btn btn-link product-item-detail-buy-button" id="<?=$itemIds['NOT_AVAILABLE_MESS']?>"
                                                       href="javascript:void(0)"
                                                       rel="nofollow" style="display: <?=(!$actualItem['CAN_BUY'] ? '' : 'none')?>;">
                                                        <?=$arParams['MESS_NOT_AVAILABLE']?>
                                                    </a>
                                                </div>
                                            </div>
                                            <?php
                                            break;
                                    }
                                }

                                if ($arParams['DISPLAY_COMPARE'])
                                {
                                    ?>
                                    <div class="product-item-detail-compare-container">
                                        <div class="product-item-detail-compare">
                                            <div class="checkbox">
                                                <label id="<?=$itemIds['COMPARE_LINK']?>">
                                                    <input type="checkbox" data-entity="compare-checkbox">
                                                    <span data-entity="compare-title"><?=$arParams['MESS_BTN_COMPARE']?></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                    </div>
				</div>
			</div>
<div>
    Доставка курьером от <span id='SDEK_cPrice2'><?=($arResult['DELIVERY']['courier']!='no')?$arResult['DELIVERY']['courier']:""?></span>
    <br>Доставка до пункта выдачи заказов от <span id='SDEK_cPricePicup'></span>

    <? $APPLICATION->IncludeComponent("ipoll:ipol.sdekPickup", ".element", Array(

    ),
        false
    ); ?>
</div>
                <?$APPLICATION->IncludeComponent(
	"bitrix:catalog.store.amount", 
	"template1", 
	array(
		"CACHE_TIME" => "36000",
		"CACHE_TYPE" => "A",
		"ELEMENT_CODE" => "bandazh-gryzhevoy-pakhovyy-t-29-03",
		"ELEMENT_ID" => "bandazh-gryzhevoy-pakhovyy-t-29-03",
		"FIELDS" => array(
			0 => "",
			1 => "",
		),
		"IBLOCK_ID" => "55",
		"IBLOCK_TYPE" => "1c_catalog",
		"MAIN_TITLE" => "",
		"MIN_AMOUNT" => "3",
		"OFFER_ID" => "57548",
		"SHOW_EMPTY_STORE" => "Y",
		"SHOW_GENERAL_STORE_INFORMATION" => "N",
		"STORES" => array(
			0 => "2",
			1 => "6",
			2 => "7",
			3 => "8",
			4 => "",
		),
		"STORE_PATH" => "/contacts/",
		"USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"USE_MIN_AMOUNT" => "N",
		"COMPONENT_TEMPLATE" => "template1"
	),
	false
);?>

                <div class="product-info product-delivery">
                    <div class="product-info-title">Доставка:</div>
                    <div class="product-info-desc">
                        <p>Доставим по Москве и МО 05 марта - от 100 ₽
                        <p>Самовывоз в магазине в Москве 04 марта - бесплатно
                        <p>В пункте выдачи 05 марта - от 1 ₽
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
                    <a href="#" class="product-brand-logo">
                        <?
                        $dd=$manufacters->where("name",$arResult['PROPERTIES']['PROIZVODITEL']['VALUE'])->first();
                        $fileImg=CFile::GetFileArray($dd->detail_picture);
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
	<!--	<div class="row">
			<div class="col-xs-12">
				<?php
				if ($haveOffers)
				{
					if ($arResult['OFFER_GROUP'])
					{
						foreach ($arResult['OFFER_GROUP_VALUES'] as $offerId)
						{
							?>
							<span id="<?=$itemIds['OFFER_GROUP'].$offerId?>" style="display: none;">
								<?php
								$APPLICATION->IncludeComponent(
									'bitrix:catalog.set.constructor',
									'.default',
									array(
										'CUSTOM_SITE_ID' => $arParams['CUSTOM_SITE_ID'] ?? null,
										'IBLOCK_ID' => $arResult['OFFERS_IBLOCK'],
										'ELEMENT_ID' => $offerId,
										'PRICE_CODE' => $arParams['PRICE_CODE'],
										'BASKET_URL' => $arParams['BASKET_URL'],
										'OFFERS_CART_PROPERTIES' => $arParams['OFFERS_CART_PROPERTIES'],
										'CACHE_TYPE' => $arParams['CACHE_TYPE'],
										'CACHE_TIME' => $arParams['CACHE_TIME'],
										'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
										'TEMPLATE_THEME' => $arParams['~TEMPLATE_THEME'],
										'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
										'CURRENCY_ID' => $arParams['CURRENCY_ID']
									),
									$component,
									array('HIDE_ICONS' => 'Y')
								);
								?>
							</span>
							<?php
						}
					}
				}
				else
				{
					if ($arResult['MODULES']['catalog'] && $arResult['OFFER_GROUP'])
					{
						$APPLICATION->IncludeComponent(
							'bitrix:catalog.set.constructor',
							'.default',
							array(
								'CUSTOM_SITE_ID' => $arParams['CUSTOM_SITE_ID'] ?? null,
								'IBLOCK_ID' => $arParams['IBLOCK_ID'],
								'ELEMENT_ID' => $arResult['ID'],
								'PRICE_CODE' => $arParams['PRICE_CODE'],
								'BASKET_URL' => $arParams['BASKET_URL'],
								'CACHE_TYPE' => $arParams['CACHE_TYPE'],
								'CACHE_TIME' => $arParams['CACHE_TIME'],
								'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
								'TEMPLATE_THEME' => $arParams['~TEMPLATE_THEME'],
								'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
								'CURRENCY_ID' => $arParams['CURRENCY_ID']
							),
							$component,
							array('HIDE_ICONS' => 'Y')
						);
					}
				}
				?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-8 col-md-9">
				<div class="row" id="<?=$itemIds['TABS_ID']?>">
					<div class="col-xs-12">
						<div class="product-item-detail-tabs-container">
							<ul class="product-item-detail-tabs-list">
								<?php
								if ($showDescription)
								{
									?>
									<li class="product-item-detail-tab active" data-entity="tab" data-value="description">
										<a href="javascript:void(0);" class="product-item-detail-tab-link">
											<span><?=$arParams['MESS_DESCRIPTION_TAB']?></span>
										</a>
									</li>
									<?php
								}

								if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS'])
								{
									?>
									<li class="product-item-detail-tab" data-entity="tab" data-value="properties">
										<a href="javascript:void(0);" class="product-item-detail-tab-link">
											<span><?=$arParams['MESS_PROPERTIES_TAB']?></span>
										</a>
									</li>
									<?php
								}

								if ($arParams['USE_COMMENTS'] === 'Y')
								{
									?>
									<li class="product-item-detail-tab" data-entity="tab" data-value="comments">
										<a href="javascript:void(0);" class="product-item-detail-tab-link">
											<span><?=$arParams['MESS_COMMENTS_TAB']?></span>
										</a>
									</li>
									<?php
								}
								?>
							</ul>
						</div>
					</div>
				</div>
				<div class="row" id="<?=$itemIds['TAB_CONTAINERS_ID']?>">
					<div class="col-xs-12">
						<?php
						if ($showDescription)
						{
							?>
							<div class="product-item-detail-tab-content active" data-entity="tab-container" data-value="description"
								itemprop="description" id="<?=$itemIds['DESCRIPTION_ID']?>">
								<?php
								if (
									$arResult['PREVIEW_TEXT'] != ''
									&& (
										$arParams['DISPLAY_PREVIEW_TEXT_MODE'] === 'S'
										|| ($arParams['DISPLAY_PREVIEW_TEXT_MODE'] === 'E' && $arResult['DETAIL_TEXT'] == '')
									)
								)
								{
									echo $arResult['PREVIEW_TEXT_TYPE'] === 'html' ? $arResult['PREVIEW_TEXT'] : '<p>'.$arResult['PREVIEW_TEXT'].'</p>';
								}

								if ($arResult['DETAIL_TEXT'] != '')
								{
									echo $arResult['DETAIL_TEXT_TYPE'] === 'html' ? $arResult['DETAIL_TEXT'] : '<p>'.$arResult['DETAIL_TEXT'].'</p>';
								}
								?>
							</div>
							<?php
						}

						if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS'])
						{
							?>
							<div class="product-item-detail-tab-content" data-entity="tab-container" data-value="properties">
								<?php
								if (!empty($arResult['DISPLAY_PROPERTIES']))
								{
									?>
									<dl class="product-item-detail-properties">
										<?php
										foreach ($arResult['DISPLAY_PROPERTIES'] as $property)
										{
											?>
											<dt><?=$property['NAME']?></dt>
											<dd><?=(
												is_array($property['DISPLAY_VALUE'])
													? implode(' / ', $property['DISPLAY_VALUE'])
													: $property['DISPLAY_VALUE']
												)?>
											</dd>
											<?php
										}
										unset($property);
										?>
									</dl>
									<?php
								}

								if ($arResult['SHOW_OFFERS_PROPS'])
								{
									?>
									<dl class="product-item-detail-properties" id="<?=$itemIds['DISPLAY_PROP_DIV']?>"></dl>
									<?php
								}
								?>
							</div>
							<?php
						}

						if ($arParams['USE_COMMENTS'] === 'Y')
						{
							?>
							<div class="product-item-detail-tab-content" data-entity="tab-container" data-value="comments" style="display: none;">
								<?php
								$componentCommentsParams = array(
									'ELEMENT_ID' => $arResult['ID'],
									'ELEMENT_CODE' => '',
									'IBLOCK_ID' => $arParams['IBLOCK_ID'],
									'SHOW_DEACTIVATED' => $arParams['SHOW_DEACTIVATED'],
									'URL_TO_COMMENT' => '',
									'WIDTH' => '',
									'COMMENTS_COUNT' => '5',
									'BLOG_USE' => $arParams['BLOG_USE'],
									'FB_USE' => $arParams['FB_USE'],
									'FB_APP_ID' => $arParams['FB_APP_ID'],
									'VK_USE' => $arParams['VK_USE'],
									'VK_API_ID' => $arParams['VK_API_ID'],
									'CACHE_TYPE' => $arParams['CACHE_TYPE'],
									'CACHE_TIME' => $arParams['CACHE_TIME'],
									'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
									'BLOG_TITLE' => '',
									'BLOG_URL' => $arParams['BLOG_URL'],
									'PATH_TO_SMILE' => '',
									'EMAIL_NOTIFY' => $arParams['BLOG_EMAIL_NOTIFY'],
									'AJAX_POST' => 'Y',
									'SHOW_SPAM' => 'Y',
									'SHOW_RATING' => 'N',
									'FB_TITLE' => '',
									'FB_USER_ADMIN_ID' => '',
									'FB_COLORSCHEME' => 'light',
									'FB_ORDER_BY' => 'reverse_time',
									'VK_TITLE' => '',
									'TEMPLATE_THEME' => $arParams['~TEMPLATE_THEME']
								);
								if(isset($arParams["USER_CONSENT"]))
									$componentCommentsParams["USER_CONSENT"] = $arParams["USER_CONSENT"];
								if(isset($arParams["USER_CONSENT_ID"]))
									$componentCommentsParams["USER_CONSENT_ID"] = $arParams["USER_CONSENT_ID"];
								if(isset($arParams["USER_CONSENT_IS_CHECKED"]))
									$componentCommentsParams["USER_CONSENT_IS_CHECKED"] = $arParams["USER_CONSENT_IS_CHECKED"];
								if(isset($arParams["USER_CONSENT_IS_LOADED"]))
									$componentCommentsParams["USER_CONSENT_IS_LOADED"] = $arParams["USER_CONSENT_IS_LOADED"];
								$APPLICATION->IncludeComponent(
									'bitrix:catalog.comments',
									'',
									$componentCommentsParams,
									$component,
									array('HIDE_ICONS' => 'Y')
								);
								?>
							</div>
							<?php
						}
						?>
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-md-3">
				<div>
					<?php
					if ($arParams['BRAND_USE'] === 'Y')
					{
						$APPLICATION->IncludeComponent(
							'bitrix:catalog.brandblock',
							'.default',
							array(
								'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
								'IBLOCK_ID' => $arParams['IBLOCK_ID'],
								'ELEMENT_ID' => $arResult['ID'],
								'ELEMENT_CODE' => '',
								'PROP_CODE' => $arParams['BRAND_PROP_CODE'],
								'CACHE_TYPE' => $arParams['CACHE_TYPE'],
								'CACHE_TIME' => $arParams['CACHE_TIME'],
								'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
								'WIDTH' => '',
								'HEIGHT' => ''
							),
							$component,
							array('HIDE_ICONS' => 'Y')
						);
					}
					?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<?php
				if ($arResult['CATALOG'] && $actualItem['CAN_BUY'] && \Bitrix\Main\ModuleManager::isModuleInstalled('sale'))
				{
					$APPLICATION->IncludeComponent(
						'bitrix:sale.prediction.product.detail',
						'.default',
						array(
							'BUTTON_ID' => $showBuyBtn ? $itemIds['BUY_LINK'] : $itemIds['ADD_BASKET_LINK'],
							'CUSTOM_SITE_ID' => $arParams['CUSTOM_SITE_ID'] ?? null,
							'POTENTIAL_PRODUCT_TO_BUY' => array(
								'ID' => $arResult['ID'] ?? null,
								'MODULE' => $arResult['MODULE'] ?? 'catalog',
								'PRODUCT_PROVIDER_CLASS' => $arResult['~PRODUCT_PROVIDER_CLASS'] ?? \Bitrix\Catalog\Product\Basket::getDefaultProviderName(),
								'QUANTITY' => $arResult['QUANTITY'] ?? null,
								'IBLOCK_ID' => $arResult['IBLOCK_ID'] ?? null,

								'PRIMARY_OFFER_ID' => $arResult['OFFERS'][0]['ID'] ?? null,
								'SECTION' => array(
									'ID' => $arResult['SECTION']['ID'] ?? null,
									'IBLOCK_ID' => $arResult['SECTION']['IBLOCK_ID'] ?? null,
									'LEFT_MARGIN' => $arResult['SECTION']['LEFT_MARGIN'] ?? null,
									'RIGHT_MARGIN' => $arResult['SECTION']['RIGHT_MARGIN'] ?? null,
								),
							)
						),
						$component,
						array('HIDE_ICONS' => 'Y')
					);
				}

				if ($arResult['CATALOG'] && $arParams['USE_GIFTS_DETAIL'] == 'Y' && \Bitrix\Main\ModuleManager::isModuleInstalled('sale'))
				{
					?>
					<div data-entity="parent-container">
						<?php
						if (!isset($arParams['GIFTS_DETAIL_HIDE_BLOCK_TITLE']) || $arParams['GIFTS_DETAIL_HIDE_BLOCK_TITLE'] !== 'Y')
						{
							?>
							<div class="catalog-block-header" data-entity="header" data-showed="false" style="display: none; opacity: 0;">
								<?=($arParams['GIFTS_DETAIL_BLOCK_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_GIFT_BLOCK_TITLE_DEFAULT'))?>
							</div>
							<?php
						}

						CBitrixComponent::includeComponentClass('bitrix:sale.products.gift');
						$APPLICATION->IncludeComponent(
							'bitrix:sale.products.gift',
							'.default',
							array(
								'CUSTOM_SITE_ID' => $arParams['CUSTOM_SITE_ID'] ?? null,
								'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
								'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],

								'PRODUCT_ROW_VARIANTS' => "",
								'PAGE_ELEMENT_COUNT' => 0,
								'DEFERRED_PRODUCT_ROW_VARIANTS' => \Bitrix\Main\Web\Json::encode(
									SaleProductsGiftComponent::predictRowVariants(
										$arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT'],
										$arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT']
									)
								),
								'DEFERRED_PAGE_ELEMENT_COUNT' => $arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT'],

								'SHOW_DISCOUNT_PERCENT' => $arParams['GIFTS_SHOW_DISCOUNT_PERCENT'],
								'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
								'SHOW_OLD_PRICE' => $arParams['GIFTS_SHOW_OLD_PRICE'],
								'PRODUCT_DISPLAY_MODE' => 'Y',
								'PRODUCT_BLOCKS_ORDER' => $arParams['GIFTS_PRODUCT_BLOCKS_ORDER'],
								'SHOW_SLIDER' => $arParams['GIFTS_SHOW_SLIDER'],
								'SLIDER_INTERVAL' => $arParams['GIFTS_SLIDER_INTERVAL'] ?? '',
								'SLIDER_PROGRESS' => $arParams['GIFTS_SLIDER_PROGRESS'] ?? '',

								'TEXT_LABEL_GIFT' => $arParams['GIFTS_DETAIL_TEXT_LABEL_GIFT'],

								'LABEL_PROP_'.$arParams['IBLOCK_ID'] => array(),
								'LABEL_PROP_MOBILE_'.$arParams['IBLOCK_ID'] => array(),
								'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],

								'ADD_TO_BASKET_ACTION' => ($arParams['ADD_TO_BASKET_ACTION'] ?? ''),
								'MESS_BTN_BUY' => $arParams['~GIFTS_MESS_BTN_BUY'],
								'MESS_BTN_ADD_TO_BASKET' => $arParams['~GIFTS_MESS_BTN_BUY'],
								'MESS_BTN_DETAIL' => $arParams['~MESS_BTN_DETAIL'],
								'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],

								'SHOW_PRODUCTS_'.$arParams['IBLOCK_ID'] => 'Y',
								'PROPERTY_CODE_'.$arParams['IBLOCK_ID'] => $arParams['LIST_PROPERTY_CODE'],
								'PROPERTY_CODE_MOBILE'.$arParams['IBLOCK_ID'] => $arParams['LIST_PROPERTY_CODE_MOBILE'],
								'PROPERTY_CODE_'.$arResult['OFFERS_IBLOCK'] => $arParams['OFFER_TREE_PROPS'],
								'OFFER_TREE_PROPS_'.$arResult['OFFERS_IBLOCK'] => $arParams['OFFER_TREE_PROPS'],
								'CART_PROPERTIES_'.$arResult['OFFERS_IBLOCK'] => $arParams['OFFERS_CART_PROPERTIES'],
								'ADDITIONAL_PICT_PROP_'.$arParams['IBLOCK_ID'] => ($arParams['ADD_PICT_PROP'] ?? ''),
								'ADDITIONAL_PICT_PROP_'.$arResult['OFFERS_IBLOCK'] => ($arParams['OFFER_ADD_PICT_PROP'] ?? ''),

								'HIDE_NOT_AVAILABLE' => 'Y',
								'HIDE_NOT_AVAILABLE_OFFERS' => 'Y',
								'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
								'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
								'PRICE_CODE' => $arParams['PRICE_CODE'],
								'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],
								'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
								'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
								'BASKET_URL' => $arParams['BASKET_URL'],
								'ADD_PROPERTIES_TO_BASKET' => $arParams['ADD_PROPERTIES_TO_BASKET'],
								'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
								'PARTIAL_PRODUCT_PROPERTIES' => $arParams['PARTIAL_PRODUCT_PROPERTIES'],
								'USE_PRODUCT_QUANTITY' => 'N',
								'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
								'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
								'POTENTIAL_PRODUCT_TO_BUY' => array(
									'ID' => $arResult['ID'] ?? null,
									'MODULE' => $arResult['MODULE'] ?? 'catalog',
									'PRODUCT_PROVIDER_CLASS' => $arResult['~PRODUCT_PROVIDER_CLASS'] ?? \Bitrix\Catalog\Product\Basket::getDefaultProviderName(),
									'QUANTITY' => $arResult['QUANTITY'] ?? null,
									'IBLOCK_ID' => $arResult['IBLOCK_ID'] ?? null,

									'PRIMARY_OFFER_ID' => $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['ID'] ?? null,
									'SECTION' => array(
										'ID' => $arResult['SECTION']['ID'] ?? null,
										'IBLOCK_ID' => $arResult['SECTION']['IBLOCK_ID'] ?? null,
										'LEFT_MARGIN' => $arResult['SECTION']['LEFT_MARGIN'] ?? null,
										'RIGHT_MARGIN' => $arResult['SECTION']['RIGHT_MARGIN'] ?? null,
									),
								),

								'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
								'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
								'BRAND_PROPERTY' => $arParams['BRAND_PROPERTY']
							),
							$component,
							array('HIDE_ICONS' => 'Y')
						);
						?>
					</div>
					<?php
				}

				if ($arResult['CATALOG'] && $arParams['USE_GIFTS_MAIN_PR_SECTION_LIST'] == 'Y' && \Bitrix\Main\ModuleManager::isModuleInstalled('sale'))
				{
					?>
					<div data-entity="parent-container">
						<?php
						if (!isset($arParams['GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE']) || $arParams['GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE'] !== 'Y')
						{
							?>
							<div class="catalog-block-header" data-entity="header" data-showed="false" style="display: none; opacity: 0;">
								<?=($arParams['GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_GIFTS_MAIN_BLOCK_TITLE_DEFAULT'))?>
							</div>
							<?php
						}

						$APPLICATION->IncludeComponent(
							'bitrix:sale.gift.main.products',
							'.default',
							array(
								'CUSTOM_SITE_ID' => $arParams['CUSTOM_SITE_ID'] ?? null,
								'PAGE_ELEMENT_COUNT' => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT'],
								'LINE_ELEMENT_COUNT' => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT'],
								'HIDE_BLOCK_TITLE' => 'Y',
								'BLOCK_TITLE' => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE'],

								'OFFERS_FIELD_CODE' => $arParams['OFFERS_FIELD_CODE'],
								'OFFERS_PROPERTY_CODE' => $arParams['OFFERS_PROPERTY_CODE'],

								'AJAX_MODE' => $arParams['AJAX_MODE'],
								'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
								'IBLOCK_ID' => $arParams['IBLOCK_ID'],

								'ELEMENT_SORT_FIELD' => 'ID',
								'ELEMENT_SORT_ORDER' => 'DESC',
								'FILTER_NAME' => 'searchFilter',
								'SECTION_URL' => $arParams['SECTION_URL'],
								'DETAIL_URL' => $arParams['DETAIL_URL'],
								'BASKET_URL' => $arParams['BASKET_URL'],
								'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],
								'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
								'SECTION_ID_VARIABLE' => $arParams['SECTION_ID_VARIABLE'],

								'CACHE_TYPE' => $arParams['CACHE_TYPE'],
								'CACHE_TIME' => $arParams['CACHE_TIME'],

								'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
								'SET_TITLE' => $arParams['SET_TITLE'],
								'PROPERTY_CODE' => $arParams['PROPERTY_CODE'],
								'PRICE_CODE' => $arParams['PRICE_CODE'],
								'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
								'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],

								'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
								'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
								'CURRENCY_ID' => $arParams['CURRENCY_ID'],
								'HIDE_NOT_AVAILABLE' => 'Y',
								'HIDE_NOT_AVAILABLE_OFFERS' => 'Y',
								'TEMPLATE_THEME' => ($arParams['TEMPLATE_THEME'] ?? ''),
								'PRODUCT_BLOCKS_ORDER' => $arParams['GIFTS_PRODUCT_BLOCKS_ORDER'],

								'SHOW_SLIDER' => $arParams['GIFTS_SHOW_SLIDER'],
								'SLIDER_INTERVAL' => $arParams['GIFTS_SLIDER_INTERVAL'] ?? '',
								'SLIDER_PROGRESS' => $arParams['GIFTS_SLIDER_PROGRESS'] ?? '',

								'ADD_PICT_PROP' => ($arParams['ADD_PICT_PROP'] ?? ''),
								'LABEL_PROP' => ($arParams['LABEL_PROP'] ?? ''),
								'LABEL_PROP_MOBILE' => ($arParams['LABEL_PROP_MOBILE'] ?? ''),
								'LABEL_PROP_POSITION' => ($arParams['LABEL_PROP_POSITION'] ?? ''),
								'OFFER_ADD_PICT_PROP' => ($arParams['OFFER_ADD_PICT_PROP'] ?? ''),
								'OFFER_TREE_PROPS' => ($arParams['OFFER_TREE_PROPS'] ?? ''),
								'SHOW_DISCOUNT_PERCENT' => ($arParams['SHOW_DISCOUNT_PERCENT'] ?? ''),
								'DISCOUNT_PERCENT_POSITION' => ($arParams['DISCOUNT_PERCENT_POSITION'] ?? ''),
								'SHOW_OLD_PRICE' => ($arParams['SHOW_OLD_PRICE'] ?? ''),
								'MESS_BTN_BUY' => ($arParams['~MESS_BTN_BUY'] ?? ''),
								'MESS_BTN_ADD_TO_BASKET' => ($arParams['~MESS_BTN_ADD_TO_BASKET'] ?? ''),
								'MESS_BTN_DETAIL' => ($arParams['~MESS_BTN_DETAIL'] ?? ''),
								'MESS_NOT_AVAILABLE' => ($arParams['~MESS_NOT_AVAILABLE'] ?? ''),
								'ADD_TO_BASKET_ACTION' => ($arParams['ADD_TO_BASKET_ACTION'] ?? ''),
								'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] ?? ''),
								'DISPLAY_COMPARE' => ($arParams['DISPLAY_COMPARE'] ?? ''),
								'COMPARE_PATH' => ($arParams['COMPARE_PATH'] ?? ''),
							)
							+ array(
								'OFFER_ID' => empty($arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['ID'])
									? $arResult['ID']
									: $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['ID'],
								'SECTION_ID' => $arResult['SECTION']['ID'],
								'ELEMENT_ID' => $arResult['ID'],

								'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
								'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
								'BRAND_PROPERTY' => $arParams['BRAND_PROPERTY']
							),
							$component,
							array('HIDE_ICONS' => 'Y')
						);
						?>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</div>
	<!--Small Card-->

        <div class="section product-tabs-section">
            <div class="container">
                <div class="product-tabs-nav-wrapp">
                    <ul class="product-tabs-nav tabs-nav" data-tabs="#product-tabs">
                        <li class="active"><a href="#product-tab-1">Описание товара</a></li>
                        <li><a href="#product-tab-2">Отзывы (120)</a></li>
                        <li><a href="#product-tab-3">Видеообзор</a></li>
                        <li><a href="#product-tab-4">Статьи</a></li>
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
                                <div class="product-tab-section">
                                    <div class="product-tab-title">Документация:</div>
                                    <ul class="product-docs">
                                        <? foreach ($element->getDocumentation() as $doc): ?>
                                            <li>
                                                <a href="<?= $doc['SRC'] ?>" class="doc-link">
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


                            <?
                            $componentCommentsParams = array(
                                'ELEMENT_ID' => $arResult['ID'],
                                'ELEMENT_CODE' => '',
                                'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                                'SHOW_DEACTIVATED' => $arParams['SHOW_DEACTIVATED'],
                                'URL_TO_COMMENT' => '',
                                'WIDTH' => '',
                                'COMMENTS_COUNT' => '5',
                                'BLOG_USE' => "Y",
                                'FB_USE' => $arParams['FB_USE'],
                                'FB_APP_ID' => $arParams['FB_APP_ID'],
                                'VK_USE' => $arParams['VK_USE'],
                                'VK_API_ID' => $arParams['VK_API_ID'],
                                'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                                'CACHE_TIME' => $arParams['CACHE_TIME'],
                                'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
                                'BLOG_TITLE' => '',
                                'BLOG_URL' => $arParams['BLOG_URL'],
                                'PATH_TO_SMILE' => '',
                                'EMAIL_NOTIFY' => $arParams['BLOG_EMAIL_NOTIFY'],
                                'AJAX_POSTUSE_COMMENTS' => 'Y',
                                'SHOW_SPAM' => 'Y',
                                'SHOW_RATING' => 'N',
                                'FB_TITLE' => '',
                                'FB_USER_ADMIN_ID' => '',
                                'FB_COLORSCHEME' => 'light',
                                'FB_ORDER_BY' => 'reverse_time',
                                'VK_TITLE' => '',
                                'TEMPLATE_THEME' => $arParams['~TEMPLATE_THEME']
                            );
                            if(isset($arParams["USER_CONSENT"]))
                                $componentCommentsParams["USER_CONSENT"] = $arParams["USER_CONSENT"];
                            if(isset($arParams["USER_CONSENT_ID"]))
                                $componentCommentsParams["USER_CONSENT_ID"] = $arParams["USER_CONSENT_ID"];
                            if(isset($arParams["USER_CONSENT_IS_CHECKED"]))
                                $componentCommentsParams["USER_CONSENT_IS_CHECKED"] = $arParams["USER_CONSENT_IS_CHECKED"];
                            if(isset($arParams["USER_CONSENT_IS_LOADED"]))
                                $componentCommentsParams["USER_CONSENT_IS_LOADED"] = $arParams["USER_CONSENT_IS_LOADED"];
                            $APPLICATION->IncludeComponent(
                                'bitrix:catalog.comments',
                                '',
                                $componentCommentsParams,
                                $component,
                                array('HIDE_ICONS' => 'Y')
                            );
                            ?>


                            <div class="product-tab-title product-tab-review-title">Все отзывы <span>(120)</span></div>

                            <div class="product-tab-reviews">
                                <div class="product-review">


                                    <div class="product-review-name">Кирилл Сергеев</div>

                                    <div class="product-review-info">
                                        <div class="rating">
                                            <div class="rating-state" style="width:70%;"></div>
                                        </div>
                                        <div class="product-review-date">13 марта 2021 г.</div>
                                    </div>
                                    <div class="product-review-text">
                                        <p>Очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец, очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец.
                                    </div>


                                </div>
                                <div class="product-review">


                                    <div class="product-review-name">Кирилл Сергеев</div>

                                    <div class="product-review-info">
                                        <div class="rating">
                                            <div class="rating-state" style="width:70%;"></div>
                                        </div>
                                        <div class="product-review-date">13 марта 2021 г.</div>
                                    </div>
                                    <div class="product-review-text">
                                        <p>Очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец, очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец.
                                    </div>


                                    <div class="product-review-imgs">
                                        <button class="slider-arrow slider-arrow-prev" aria-label="Назад">
                                            <svg width="30" height="30"><use xlink:href="#icon-arrow-down"/></svg>
                                        </button>
                                        <button class="slider-arrow slider-arrow-next" aria-label="Вперед">
                                            <svg width="30" height="30"><use xlink:href="#icon-arrow-down"/></svg>
                                        </button>
                                        <div class="product-review-imgs-slider swiper-container">
                                            <div class="swiper-wrapper">


                                                <div class="product-review-imgs-slide swiper-slide">
                                                    <a href="img/product-img-full.jpg" data-fancybox="product-review-2">
                                                        <img src="img/product-img-small.jpg" srcset="img/product-img-small@2x.jpg 2x" alt="">
                                                    </a>
                                                </div>

                                                <div class="product-review-imgs-slide swiper-slide">
                                                    <a href="img/product-img-full.jpg" data-fancybox="product-review-2">
                                                        <img src="img/product-img-small.jpg" srcset="img/product-img-small@2x.jpg 2x" alt="">
                                                    </a>
                                                </div>

                                                <div class="product-review-imgs-slide swiper-slide">
                                                    <a href="img/product-img-full.jpg" data-fancybox="product-review-2">
                                                        <img src="img/product-img-small.jpg" srcset="img/product-img-small@2x.jpg 2x" alt="">
                                                    </a>
                                                </div>

                                                <div class="product-review-imgs-slide swiper-slide">
                                                    <a href="img/product-img-full.jpg" data-fancybox="product-review-2">
                                                        <img src="img/product-img-small.jpg" srcset="img/product-img-small@2x.jpg 2x" alt="">
                                                    </a>
                                                </div>

                                                <div class="product-review-imgs-slide swiper-slide">
                                                    <a href="img/product-img-full.jpg" data-fancybox="product-review-2">
                                                        <img src="img/product-img-small.jpg" srcset="img/product-img-small@2x.jpg 2x" alt="">
                                                    </a>
                                                </div>





                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="product-review">


                                    <div class="product-review-name">Кирилл Сергеев</div>

                                    <div class="product-review-info">
                                        <div class="rating">
                                            <div class="rating-state" style="width:70%;"></div>
                                        </div>
                                        <div class="product-review-date">13 марта 2021 г.</div>
                                    </div>
                                    <div class="product-review-text">
                                        <p>Очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец, очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец.
                                    </div>

                                    <div class="product-review-answer">
                                        <div class="product-review-answer-head">
                                            <div class="product-review-name">Гипермед</div>
                                            <div class="product-review-date">13 марта 2021 г.</div>
                                        </div>
                                        <div class="product-review-text">
                                            <p>Здравствуйте Кирилл, мы рады, что вам очень понравилась, данная подушка. Спасибо за комментарий!
                                        </div>
                                    </div>


                                    <div class="product-review-imgs">
                                        <button class="slider-arrow slider-arrow-prev" aria-label="Назад">
                                            <svg width="30" height="30"><use xlink:href="#icon-arrow-down"/></svg>
                                        </button>
                                        <button class="slider-arrow slider-arrow-next" aria-label="Вперед">
                                            <svg width="30" height="30"><use xlink:href="#icon-arrow-down"/></svg>
                                        </button>
                                        <div class="product-review-imgs-slider swiper-container">
                                            <div class="swiper-wrapper">



                                                <div class="product-review-imgs-slide swiper-slide">
                                                    <a href="img/product-img-full.jpg" data-fancybox="product-review-3">
                                                        <img src="img/product-img-small.jpg" srcset="img/product-img-small@2x.jpg 2x" alt="">
                                                    </a>
                                                </div>

                                                <div class="product-review-imgs-slide swiper-slide">
                                                    <a href="img/product-img-full.jpg" data-fancybox="product-review-3">
                                                        <img src="img/product-img-small.jpg" srcset="img/product-img-small@2x.jpg 2x" alt="">
                                                    </a>
                                                </div>

                                                <div class="product-review-imgs-slide swiper-slide">
                                                    <a href="img/product-img-full.jpg" data-fancybox="product-review-3">
                                                        <img src="img/product-img-small.jpg" srcset="img/product-img-small@2x.jpg 2x" alt="">
                                                    </a>
                                                </div>




                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="product-review">


                                    <div class="product-review-name">Кирилл Сергеев</div>

                                    <div class="product-review-info">
                                        <div class="rating">
                                            <div class="rating-state" style="width:70%;"></div>
                                        </div>
                                        <div class="product-review-date">13 марта 2021 г.</div>
                                    </div>
                                    <div class="product-review-text">
                                        <p>Очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец, очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец.
                                    </div>


                                    <div class="product-review-imgs">
                                        <button class="slider-arrow slider-arrow-prev" aria-label="Назад">
                                            <svg width="30" height="30"><use xlink:href="#icon-arrow-down"/></svg>
                                        </button>
                                        <button class="slider-arrow slider-arrow-next" aria-label="Вперед">
                                            <svg width="30" height="30"><use xlink:href="#icon-arrow-down"/></svg>
                                        </button>
                                        <div class="product-review-imgs-slider swiper-container">
                                            <div class="swiper-wrapper">



                                                <div class="product-review-imgs-slide swiper-slide">
                                                    <a href="img/product-img-full.jpg" data-fancybox="product-review-4">
                                                        <img src="img/product-img-small.jpg" srcset="img/product-img-small@2x.jpg 2x" alt="">
                                                    </a>
                                                </div>

                                                <div class="product-review-imgs-slide swiper-slide">
                                                    <a href="img/product-img-full.jpg" data-fancybox="product-review-4">
                                                        <img src="img/product-img-small.jpg" srcset="img/product-img-small@2x.jpg 2x" alt="">
                                                    </a>
                                                </div>

                                                <div class="product-review-imgs-slide swiper-slide">
                                                    <a href="img/product-img-full.jpg" data-fancybox="product-review-4">
                                                        <img src="img/product-img-small.jpg" srcset="img/product-img-small@2x.jpg 2x" alt="">
                                                    </a>
                                                </div>




                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="product-review">


                                    <div class="product-review-name">Кирилл Сергеев</div>

                                    <div class="product-review-info">
                                        <div class="rating">
                                            <div class="rating-state" style="width:70%;"></div>
                                        </div>
                                        <div class="product-review-date">13 марта 2021 г.</div>
                                    </div>
                                    <div class="product-review-text">
                                        <p>Очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец, очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец.
                                    </div>


                                </div>
                                <div class="product-review">


                                    <div class="product-review-name">Кирилл Сергеев</div>

                                    <div class="product-review-info">
                                        <div class="rating">
                                            <div class="rating-state" style="width:70%;"></div>
                                        </div>
                                        <div class="product-review-date">13 марта 2021 г.</div>
                                    </div>
                                    <div class="product-review-text">
                                        <p>Очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец, очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец.
                                    </div>


                                </div>
                                <div class="product-review">


                                    <div class="product-review-name">Кирилл Сергеев</div>

                                    <div class="product-review-info">
                                        <div class="rating">
                                            <div class="rating-state" style="width:70%;"></div>
                                        </div>
                                        <div class="product-review-date">13 марта 2021 г.</div>
                                    </div>
                                    <div class="product-review-text">
                                        <p>Очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец, очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец.
                                    </div>


                                    <div class="product-review-imgs">
                                        <button class="slider-arrow slider-arrow-prev" aria-label="Назад">
                                            <svg width="30" height="30"><use xlink:href="#icon-arrow-down"/></svg>
                                        </button>
                                        <button class="slider-arrow slider-arrow-next" aria-label="Вперед">
                                            <svg width="30" height="30"><use xlink:href="#icon-arrow-down"/></svg>
                                        </button>
                                        <div class="product-review-imgs-slider swiper-container">
                                            <div class="swiper-wrapper">



                                                <div class="product-review-imgs-slide swiper-slide">
                                                    <a href="img/product-img-full.jpg" data-fancybox="product-review-7">
                                                        <img src="img/product-img-small.jpg" srcset="img/product-img-small@2x.jpg 2x" alt="">
                                                    </a>
                                                </div>


                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="product-review">


                                    <div class="product-review-name">Кирилл Сергеев</div>

                                    <div class="product-review-info">
                                        <div class="rating">
                                            <div class="rating-state" style="width:70%;"></div>
                                        </div>
                                        <div class="product-review-date">13 марта 2021 г.</div>
                                    </div>
                                    <div class="product-review-text">
                                        <p>Очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец, очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец.
                                    </div>


                                </div>
                                <div class="product-review">


                                    <div class="product-review-name">Кирилл Сергеев</div>

                                    <div class="product-review-info">
                                        <div class="rating">
                                            <div class="rating-state" style="width:70%;"></div>
                                        </div>
                                        <div class="product-review-date">13 марта 2021 г.</div>
                                    </div>
                                    <div class="product-review-text">
                                        <p>Очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец, очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец.
                                    </div>


                                    <div class="product-review-imgs">
                                        <button class="slider-arrow slider-arrow-prev" aria-label="Назад">
                                            <svg width="30" height="30"><use xlink:href="#icon-arrow-down"/></svg>
                                        </button>
                                        <button class="slider-arrow slider-arrow-next" aria-label="Вперед">
                                            <svg width="30" height="30"><use xlink:href="#icon-arrow-down"/></svg>
                                        </button>
                                        <div class="product-review-imgs-slider swiper-container">
                                            <div class="swiper-wrapper">





                                                <div class="product-review-imgs-slide swiper-slide">
                                                    <a href="img/product-img-full.jpg" data-fancybox="product-review-9">
                                                        <img src="img/product-img-small.jpg" srcset="img/product-img-small@2x.jpg 2x" alt="">
                                                    </a>
                                                </div>

                                                <div class="product-review-imgs-slide swiper-slide">
                                                    <a href="img/product-img-full.jpg" data-fancybox="product-review-9">
                                                        <img src="img/product-img-small.jpg" srcset="img/product-img-small@2x.jpg 2x" alt="">
                                                    </a>
                                                </div>


                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="read-more-btn-wrapp">
                                <a href="#" class="btn read-more-btn">Показать ещё</a>
                            </div>
                        </div>
                    </div>
                    <div id="product-tab-3" class="tab-block">
                        <div class="product-tab-section">
                            <div class="product-tab-title product-tab-video-title"><div>Видеообзор</div>
                                <b><?=$arResult["NAME"]?></b></div>
                            <div class="product-video">
                                <a href="<?=$element->getVideo()?>" class="product-video-link" data-fancybox
                                   data-fancybox-type="iframe">
								<span class="product-video-link-logo">
									<img src="img/youtube-logo.svg" alt="">
								</span>
                                    <span class="product-video-link-play">
									<i></i>
									<span>Смотреть</span>
								</span>
                                    <span class="product-video-link-img cover-img">
									<img src="<?=$element->getVideoCover()?>" alt="">
								</span>
                                </a>
                                <div class="product-video-body">
                                    <div class="product-video-desc content-text">
                                        <p>Ознакомиться с видеопрезентацией различных товаров медицинского назначения, можно на нашем Youtube канале. Перейдя по ссылке, Вы найдете более 100 видеороликов, сможете увидеть комплектацию, внешний вид, характеристики товаров и многое другое. Подписывайтесь на наш канал, будьте всегда в курсе новинок от компании Гипермед - Центра торговли медицинскими товарами!
                                    </div>
                                    <a href="#" class="product-video-more-link">Посмотреть все видеопрезентации&nbsp;&#62;</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="product-tab-4" class="tab-block">
                        <div class="product-tab-section">
                            <div class="product-tab-title product-tab-articles-title">Статьи</div>
                            <div class="product-articles-row articles-row flex-row">
                                <? foreach($element->getArticles() as $article):?>
                                    <div class="articles-col flex-row-item swiper-slide">
                                        <div class="article-item">
                                            <a href="<?=$article["DETAIL_PAGE_URL"]?>" class="item-link" aria-label="Читать статью"></a>
                                            <div class="article-item-img">
                                        <span><img src="<?=$article["PICTURE"]?>" srcset="<?=$article["PICTURE2X"]?>
                                        2x"
                                                   alt=""></span>
                                            </div>
                                            <div class="article-item-body">
                                                <div class="article-item-title"><?=$article["NAME"]?></div>
                                                <div class="article-item-desc"><?=$article["TEXT"]?></div>
                                                <div class="article-item-foot">
                                                    <div class="article-item-views">
                                                        <svg width="20" height="20"><use xlink:href="#icon-eye"/></svg>
                                                        <span><?=$article["VIEW_COUNTER"]?></span>
                                                    </div>
                                                    <div class="article-item-btn">Читать</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?endforeach;?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-programm visible-tablet">
                    <?if($element->getIPRA()):?>
                        <div class="product-programm-icon">
                            <img src="img/product-programm-icon.svg" alt="">
                        </div>
                        <div class="product-programm-body">
                            <div class="product-programm-desc">Данный товар участвует в индивидуальной программе реабилитации</div>
                            <a href="#" class="product-programm-link">Подробнее&nbsp;&#62;</a>
                        </div>
                    <?endif?>
                </div>
            </div>
        </div>

<?php
       // echo '<pre>';
//print_r($arResult);
//echo '</pre>';
?>
	<div class="product-item-detail-short-card-fixed hidden-xs" id="<?=$itemIds['SMALL_CARD_PANEL_ID']?>">
		<div class="product-item-detail-short-card-content-container">
			<table>
				<tr>
					<td rowspan="2" class="product-item-detail-short-card-image">
						<img src="" data-entity="panel-picture">
					</td>
					<td class="product-item-detail-short-title-container" data-entity="panel-title">
						<span class="product-item-detail-short-title-text"><?=$name?></span>
					</td>
					<td rowspan="2" class="product-item-detail-short-card-price">
						<?php
						if ($arParams['SHOW_OLD_PRICE'] === 'Y')
						{
							?>
							<div class="product-item-detail-price-old" style="display: <?=($showDiscount ? '' : 'none')?>;"
								data-entity="panel-old-price">
								<?=($showDiscount ? $price['PRINT_RATIO_BASE_PRICE'] : '')?>
							</div>
							<?php
						}
						?>
						<div class="product-item-detail-price-current" data-entity="panel-price">
							<?=$price['PRINT_RATIO_PRICE']?>
						</div>
					</td>
					<?php
					if ($showAddBtn)
					{
						?>
						<td rowspan="2" class="product-item-detail-short-card-btn"
							style="display: <?=($actualItem['CAN_BUY'] ? '' : 'none')?>;"
							data-entity="panel-add-button">
							<a class="btn <?=$showButtonClassName?> product-item-detail-buy-button"
								id="<?=$itemIds['ADD_BASKET_LINK']?>"
								href="javascript:void(0);">
								<span><?=$arParams['MESS_BTN_ADD_TO_BASKET']?></span>
							</a>
						</td>
						<?php
					}

					if ($showBuyBtn)
					{
						?>
						<td rowspan="2" class="product-item-detail-short-card-btn"
							style="display: <?=($actualItem['CAN_BUY'] ? '' : 'none')?>;"
							data-entity="panel-buy-button">
							<a class="btn <?=$buyButtonClassName?> product-item-detail-buy-button" id="<?=$itemIds['BUY_LINK']?>"
								href="javascript:void(0);">
								<span><?=$arParams['MESS_BTN_BUY']?></span>
							</a>
						</td>
						<?php
					}
					?>
					<td rowspan="2" class="product-item-detail-short-card-btn"
						style="display: <?=(!$actualItem['CAN_BUY'] ? '' : 'none')?>;"
						data-entity="panel-not-available-button">
						<a class="btn btn-link product-item-detail-buy-button" href="javascript:void(0)"
							rel="nofollow">
							<?=$arParams['MESS_NOT_AVAILABLE']?>
						</a>
					</td>
				</tr>
				<?php
				if ($haveOffers)
				{
					?>
					<tr>
						<td>
							<div class="product-item-selected-scu-container" data-entity="panel-sku-container">
								<?php
								$i = 0;

								foreach ($arResult['SKU_PROPS'] as $skuProperty)
								{
									if (!isset($arResult['OFFERS_PROP'][$skuProperty['CODE']]))
									{
										continue;
									}

									$propertyId = $skuProperty['ID'];

									foreach ($skuProperty['VALUES'] as $value)
									{
										$value['NAME'] = htmlspecialcharsbx($value['NAME']);
										if ($skuProperty['SHOW_MODE'] === 'PICT')
										{
											?>
											<div class="product-item-selected-scu product-item-selected-scu-color selected"
												title="<?=$value['NAME']?>"
												style="background-image: url('<?=$value['PICT']['SRC']?>'); display: none;"
												data-sku-line="<?=$i?>"
												data-treevalue="<?=$propertyId?>_<?=$value['ID']?>"
												data-onevalue="<?=$value['ID']?>">
											</div>
											<?php
										}
										else
										{
											?>
											<div class="product-item-selected-scu product-item-selected-scu-text selected"
												title="<?=$value['NAME']?>"
												style="display: none;"
												data-sku-line="<?=$i?>"
												data-treevalue="<?=$propertyId?>_<?=$value['ID']?>"
												data-onevalue="<?=$value['ID']?>">
												<?=$value['NAME']?>
											</div>
											<?php
										}
									}

									$i++;
								}
								?>
							</div>
						</td>
					</tr>
					<?php
				}
				?>
			</table>
		</div>
	</div>
	<!--Top tabs-->
	<!--<div class="product-item-detail-tabs-container-fixed hidden-xs" id="<?=$itemIds['TABS_PANEL_ID']?>">
		<ul class="product-item-detail-tabs-list">
			<?php
			if ($showDescription)
			{
				?>
				<li class="product-item-detail-tab active" data-entity="tab" data-value="description">
					<a href="javascript:void(0);" class="product-item-detail-tab-link">
						<span><?=$arParams['MESS_DESCRIPTION_TAB']?></span>
					</a>
				</li>
				<?php
			}

			if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS'])
			{
				?>
				<li class="product-item-detail-tab" data-entity="tab" data-value="properties">
					<a href="javascript:void(0);" class="product-item-detail-tab-link">
						<span><?=$arParams['MESS_PROPERTIES_TAB']?></span>
					</a>
				</li>
				<?php
			}

			if ($arParams['USE_COMMENTS'] === 'Y')
			{
				?>
				<li class="product-item-detail-tab" data-entity="tab" data-value="comments">
					<a href="javascript:void(0);" class="product-item-detail-tab-link">
						<span><?=$arParams['MESS_COMMENTS_TAB']?></span>
					</a>
				</li>
				<?php
			}
			?>
		</ul>
	</div>-->

	<meta itemprop="name" content="<?=$name?>" />
	<meta itemprop="category" content="<?=$arResult['CATEGORY_PATH']?>" />
	<?php
	if ($haveOffers)
	{
		foreach ($arResult['JS_OFFERS'] as $offer)
		{
			$currentOffersList = array();

			if (!empty($offer['TREE']) && is_array($offer['TREE']))
			{
				foreach ($offer['TREE'] as $propName => $skuId)
				{
					$propId = (int)mb_substr($propName, 5);

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
			<?php
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
		<?php
	}
	?>
<!--</div>-->
<?php
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
					$current = '<dt>'.$property['NAME'].'</dt><dd>'.(
						is_array($property['VALUE'])
							? implode(' / ', $property['VALUE'])
							: $property['VALUE']
						).'</dd>';
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
				: null,
			'SHOW_SKU_DESCRIPTION' => $arParams['SHOW_SKU_DESCRIPTION'],
			'DISPLAY_PREVIEW_TEXT_MODE' => $arParams['DISPLAY_PREVIEW_TEXT_MODE']
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
			'CATEGORY' => $arResult['CATEGORY_PATH'],
			'DETAIL_TEXT' => $arResult['DETAIL_TEXT'],
			'DETAIL_TEXT_TYPE' => $arResult['DETAIL_TEXT_TYPE'],
			'PREVIEW_TEXT' => $arResult['PREVIEW_TEXT'],
			'PREVIEW_TEXT_TYPE' => $arResult['PREVIEW_TEXT_TYPE']
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
			<?php
			if (!empty($arResult['PRODUCT_PROPERTIES_FILL']))
			{
				foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propId => $propInfo)
				{
					?>
					<input type="hidden" name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]" value="<?=htmlspecialcharsbx($propInfo['ID'])?>">
					<?php
					unset($arResult['PRODUCT_PROPERTIES'][$propId]);
				}
			}

			$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
			if (!$emptyProductProperties)
			{
				?>
				<table>
					<?php
					foreach ($arResult['PRODUCT_PROPERTIES'] as $propId => $propInfo)
					{
						?>
						<tr>
							<td><?=$arResult['PROPERTIES'][$propId]['NAME']?></td>
							<td>
								<?php
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
										<?php
									}
								}
								else
								{
									?>
									<select name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]">
										<?php
										foreach ($propInfo['VALUES'] as $valueId => $value)
										{
											?>
											<option value="<?=$valueId?>" <?=($valueId == $propInfo['SELECTED'] ? '"selected"' : '')?>>
												<?=$value?>
											</option>
											<?php
										}
										?>
									</select>
									<?php
								}
								?>
							</td>
						</tr>
						<?php
					}
					?>
				</table>
				<?php
			}
			?>
		</div>
		<?php
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
<script>
	BX.message({
		ECONOMY_INFO_MESSAGE: '<?=GetMessageJS('CT_BCE_CATALOG_ECONOMY_INFO2')?>',
		TITLE_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR')?>',
		TITLE_BASKET_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS')?>',
		BASKET_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR')?>',
		BTN_SEND_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS')?>',
		BTN_MESSAGE_DETAIL_BASKET_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_BASKET_REDIRECT')?>',
		BTN_MESSAGE_CLOSE: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE')?>',
		BTN_MESSAGE_DETAIL_CLOSE_POPUP: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE_POPUP')?>',
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
<?php
unset($actualItem, $itemIds, $jsParams);
