<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?php
use Palladiumlab\Catalog\Element;
if($arResult["ITEMS"]):?>
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH . '/assets/css/vendor/jquery-ui.min.css'?>">
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH . '/assets/css/vendor/jquery-ui.structure.min.css'?>">
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH . '/assets/css/vendor/jquery-ui.theme.min.css'?>">
    <script src="<?=SITE_TEMPLATE_PATH . '/assets/js/vendor/jquery-ui.min.js'?>"></script>
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
                                <a href="<?=str_replace('/catalog/','/product/',$arElement["DETAIL_PAGE_URL"])?>" class=" <?= is_array($arElement["DETAIL_PICTURE"]) ? "" : "product-item-img product-item-img-no-photo" ?>">
                                    <? if (is_array($arElement["DETAIL_PICTURE"])): ?>
                                        <a href="<?= str_replace('/catalog/','/product/',$arElement["DETAIL_PAGE_URL"]) ?>">
                                            <img border="0" src="<?= $arElement["DETAIL_PICTURE"]["SRC"] ?>"
                                                 alt="<?= $arElement["NAME"] ?>" title="<?= $arElement["NAME"] ?>"/>
                                        </a>
                                    <? else: ?>
                                        <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/no-photo.svg" alt="" width="144">
                                    <?endif?>
                                </a>
                                <div class="product-item-title">
                                    <?
                                    if($arElement['PROPERTIES']['NAIMENOVANIE_DLYA_SAYTA']['VALUE']){
                                        $arElement["NAME"] = $arElement['PROPERTIES']['NAIMENOVANIE_DLYA_SAYTA']['VALUE'];
                                    }
                                    ?>
                                    <a href="<?=str_replace('/catalog/','/product/',$arElement["DETAIL_PAGE_URL"])?>"><?=$arElement["NAME"]?></a>
                                </div>
                                <div class="product-item-foot">
                                    <?if($arElement["OFFERS"]):?>
                                        <div class="pricebl product-item-info-container product-item-price-container">
                                            <?
                                            $arPrice = [];
                                            $quantity = 1;
                                            $renewal = 'N';
                                            $mxResult = CCatalogSKU::GetInfoByProductIBlock($arParams['IBLOCK_ID']);
                                            if (is_array($mxResult)){
                                                $rsOffers = CIBlockElement::GetList(array("CATALOG_PRICE_1"=>"ASC"),array('IBLOCK_ID' => $mxResult['IBLOCK_ID'], 'PROPERTY_'.$mxResult['SKU_PROPERTY_ID'] => $arElement["ID"]));
                                                while ($arOffer = $rsOffers->GetNext()){
                                                    $ar_price = CCatalogProduct::GetOptimalPrice($arOffer['ID'], $quantity, $USER->GetUserGroupArray(), $renewal);
                                                    $price = is_array($ar_price["PRICE"]) ? $ar_price["PRICE"]["PRICE"]:$ar_price["PRICE"];
                                                    if($price>0){
                                                        echo "<span class='product-item-price-current'>от " . round($price) . " ₽</span>" ;
                                                        break;
                                                    }
                                                }
                                            }
                                            ?>
                                        </div>
                                    <?elseif($arElement['MIN_PRICE']['VALUE']):?>
                                        <div class="pricebl product-item-info-container product-item-price-container">
                                            <span class='product-item-price-current'><?=$arElement['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?></span>
                                        </div>
                                    <?endif;?>
                                    <div class="products-col__btns">
                                        <a class="btn nowrap" href="<?=str_replace('/catalog/','/product/',$arElement["DETAIL_PAGE_URL"])?>">Посмотреть</a>
                                    </div>
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

<?else:?>

    <style>
        .catalog-sidebar{display: none;}
        .catalog-sort{display: none;}
    </style>
        <div class="empty-product">
            <div class="page-404-icon">
                <svg viewBox="0 0 294 294" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M212.396 107.999C212.396 113.522 204.817 118 195.462 118C186.111 118 178.527 113.522 178.527 107.999C178.527 102.475 186.111 98 195.462 98C204.817 98 212.396 102.475 212.396 107.999Z" fill="#7FD54C"/>
                    <path d="M115.029 108.444C115.029 117.8 107.445 125.383 98.0944 125.383C88.7436 125.383 81.1602 117.8 81.1602 108.444C81.1602 99.089 88.7436 91.5103 98.0944 91.5103C107.445 91.5103 115.029 99.089 115.029 108.444Z" fill="#7FD54C"/>
                    <path d="M206.987 173.428C210.838 173.428 213.965 176.549 213.965 180.406C213.965 210.529 189.736 235.038 159.952 235.038H136.43C106.646 235.038 82.4171 210.664 82.4171 180.708C82.4171 176.852 85.5389 173.726 89.3954 173.726C93.2477 173.726 96.3689 176.852 96.3689 180.708C96.3689 202.965 114.34 221.076 136.43 221.076H159.951C182.04 221.076 200.007 202.835 200.007 180.406C200.008 176.549 203.135 173.428 206.987 173.428Z" fill="#7FD54C"/>
                    <path d="M147 294C65.9622 294 0.0351562 228.054 0.0351562 146.998C0.0351562 65.9457 65.9622 0 147 0C228.033 0 293.961 65.9457 293.961 146.998C293.961 228.054 228.033 294 147 294ZM147 13.9617C73.657 13.9617 13.9922 73.6411 13.9922 146.998C13.9922 220.359 73.6576 280.038 147 280.038C220.339 280.038 280.003 220.359 280.003 146.998C280.003 73.6405 220.339 13.9617 147 13.9617Z" fill="#7FD54C"/>
                </svg>
            </div>
            <div class="empty-product__body">
                <h1 class="empty-product__title color:success">Товар отсутствует</h1>
                <div class="empty-product__subtitle color:success">идет работа по наполнению</div>
                <a href="/" class="btn btn--success">Перейти на главную</a>
            </div>
        </div>

<?endif;?>