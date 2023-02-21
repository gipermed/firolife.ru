<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?php
use Palladiumlab\Catalog\Element;
?>


<link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH . '/assets/css/vendor/jquery-ui.min.css'?>">
<link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH . '/assets/css/vendor/jquery-ui.structure.min.css'?>">
<link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH . '/assets/css/vendor/jquery-ui.theme.min.css'?>">
<script src="<?=SITE_TEMPLATE_PATH . '/assets/js/vendor/jquery-ui.min.js'?>"></script>,


<div class="catalog-sectionclickon">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
    <div class="catalog-body">

        <div class="catalog-row products-row flex-row">

            <?foreach($arResult["ITEMS"] as $arElement):?>
				<?php
				$mainId = $this->GetEditAreaId($arElement['ID']);
				$itemIds = [
					'ID'             => $mainId,
					'SUBSCRIBE_LINK' => $mainId . '_subscribe',
				]
				?>

				<? $element = new Element($arElement) ?>
                <div class="products-col swiper-slide">
					<?
					$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arElement["IBLOCK_ID"], "ELEMENT_EDIT"));
					$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arElement["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCT_ELEMENT_DELETE_CONFIRM')));
					?>
                    <div class="product-item"
                         id="<?= $mainId ?>">

                        <a href="#"
                           class="add-to-favorites-btn product-item-favorites"
                           aria-label="Добавить в избранное"
                           data-title="Добавить в избранное"
                           data-product="<?=$arElement['ID']?>"
                           data-title-active="Убрать из избранного">
                            <svg width="24"
                                 height="24">
                                <use xlink:href="#icon-like"/>
                            </svg>
                        </a>
                        <div class="product-item-stikers">
							<? $element->echoStickers(); ?>
                            </div>

                            <a href="#"
                               class=" <?= is_array($arElement["DETAIL_PICTURE"]) ? "" : "product-item-img product-item-img-no-photo" ?>">

								<? if (is_array($arElement["DETAIL_PICTURE"])): ?>
                                    <a href="<?= $arElement["DETAIL_PAGE_URL"] ?>">
                                        <img border="0" src="<?= $arElement["DETAIL_PICTURE"]["SRC"] ?>"
                                             alt="<?= $arElement["NAME"] ?>" title="<?= $arElement["NAME"] ?>"/>
                                    </a>
								<? else: ?>
                                    <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/no-photo.svg" alt="" width="144">
								<?endif?>
                            </a>
                            <div class="product-item-title">
                                <a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a>
                            </div>
                            <div class="product-item-foot">


								<?if(is_array($arElement["OFFERS"]) && !empty($arElement["OFFERS"])):?>
                                    <!-- Показываем наименьшую для от -->
                                    <div class="pricebl">
										<?
										$arPrice = [];
										$quantity = 1;
										$renewal = 'N';
										$mxResult = CCatalogSKU::GetInfoByProductIBlock($arParams['IBLOCK_ID']
										);
										if (is_array($mxResult))
										{
											$rsOffers = CIBlockElement::GetList(array("PRICE"=>"ASC"),array('IBLOCK_ID' => $mxResult['IBLOCK_ID'], 'PROPERTY_'.$mxResult['SKU_PROPERTY_ID'] => $arElement["ID"]));
											while ($arOffer = $rsOffers->GetNext())
											{
												//var_dump($arOffer);
												$ar_price = CCatalogProduct::GetOptimalPrice($arOffer['ID'], $quantity, $USER->GetUserGroupArray(), $renewal);
												//$ar_price = GetCatalogProductPrice($arOffer["ID"], 7);
												$price = is_array($ar_price["PRICE"]) ?
                                                    $ar_price["PRICE"]["PRICE"]:$ar_price["PRICE"];
                                                echo "<p>от " . $price . " руб.</p>" ;
												break;
											}
										}
										?>
                                    </div>
                                    <div>
                                        <a class="btn nowrap" href="<?=$arElement["DETAIL_PAGE_URL"]?>">Показать
                                            предложения</a>
                                    </div>
<?endif;?>
                            </div>
                        </div>
                    </div>
            <? endforeach?>

        </div>
    </div>

<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
</div>
