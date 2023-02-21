<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
use Bitrix\Main\Localization\Loc;
if ($arResult["ITEMS"]) { ?>
    <div class="section home-promotions-section">
        <div class="container">
            <?if($arParams['DETAIL_PRODUCT_PAGE'] == 'Y'):?>
                <h3><?=Loc::getMessage('SALES_MAIN_TITLE')?></h3>
            <?elseif(!$arParams['INNER_PAGE']):?>
                <div class="section-title"><?=Loc::getMessage('SALES_MAIN_TITLE')?></div>
            <?endif;?>
            <div class="promo-row">
                <?php foreach ($arResult["ITEMS"] as $arItem) {
                    $this->addEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::getArrayById($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->addDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::getArrayById($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                    ?>
                    <?/*<div class="promo-col">
                       <div class="promo-item"<?if($arItem['PROPERTIES']['COLOR']['VALUE']):?> style="background-color: <?=$arItem['PROPERTIES']['COLOR']['VALUE']?>;"<?endif;?> id="<?= $this->getEditAreaId($arItem['ID']) ?>">
                            <?if($arItem['PROPERTIES']['DATE']['VALUE']):?>
                                <div class="promo-item__date"><?=Loc::getMessage('SALES_MAIN_PRE_DATE')?> <?=$arItem['PROPERTIES']['DATE']['VALUE']?></div>
                            <?endif;?>
                            <div class="promo-item__content">
                                <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="promo-item__title"><?=$arItem['~NAME']?></a>
                                <div class="promo-item__description"><?=cut_string($arItem['~PREVIEW_TEXT'],150);?></div>
                                <?if($arItem['PROPERTIES']['TITLE']['VALUE']):?>
                                    <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="promo-item__link"><?=$arItem['PROPERTIES']['TITLE']['VALUE']?> ></a>
                                <?endif;?>
                            </div>
                            <?if($arItem['PREVIEW_PICTURE']):?>
                                <div class="promo-item__thumb">
                                    <img src="<?=$arItem['PREVIEW_PICTURE']['src']?>" alt="<?=$arItem['~NAME']?>">
                                </div>
                            <?endif;?>
                        </div>
                    </div>-->*/?>
                        <?php if(strtotime($arItem['PROPERTIES']['DATE']['VALUE']) > strtotime(date("d.m.y")))  {?>
                    <div class="promo-col">
                       <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="promo-item"<?if($arItem['PROPERTIES']['COLOR']['VALUE']):?> style="background-image: url(<?=$arItem['FIELDS']['PREVIEW_PICTURE']['SRC']?>);"<?endif;?> id="<?= $this->getEditAreaId($arItem['ID']) ?>">
                            <?if($arItem['PROPERTIES']['DATE']['VALUE']):?>
                                <div class="promo-item__date"><?=Loc::getMessage('SALES_MAIN_PRE_DATE')?> <?=$arItem['PROPERTIES']['DATE']['VALUE']?></div>
                            <?endif;?>
                            <div class="promo-item__content">
                                <div class="promo-item__description"><?=cut_string($arItem['~PREVIEW_TEXT'],150);?></div>
                                <?if($arItem['PROPERTIES']['TITLE']['VALUE']):?>
                                    <span class="promo-item__link"><?=$arItem['PROPERTIES']['TITLE']['VALUE']?> ></span>
                                <?endif;?>
                            </div>
                            <?if($arItem['PREVIEW_PICTURE']):?>
                               <!-- <div class="promo-item__thumb">
                                    <img src="<?=$arItem['PREVIEW_PICTURE']['src']?>" alt="<?=$arItem['~NAME']?>">
                                </div>-->
                            <?endif;?>
                        </a>
                    </div>
                    <?php }?>

                <?php } ?>
            </div>
            <?if(!$arParams['INNER_PAGE']):?>
                <div class="read-more-btn-wrapp">
                    <a href="/sales/" class="btn read-more-btn"><?=Loc::getMessage('SALES_MAIN_TITLE_LINK')?></a>
                </div>
            <?endif;?>
        </div>
    </div>
<?php } ?>