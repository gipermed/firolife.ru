<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
use Bitrix\Main\Localization\Loc;
if ($arResult["SECTION"]) { ?>
    <div class="section home-promotions-section">
        <div class="container">
            <?foreach($arResult["SECTION"] as $key=>$section):
                if(!$section){continue;}?>
                <div class="promo-section">
                    <div class="promo-section__title"><?=Loc::getMessage('SALES_SECTION_TITLE_'.$key)?></div>
                    <div class="promo-row">
                        <? foreach ($section as $arItem) {
                            $this->addEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::getArrayById($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                            $this->addDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::getArrayById($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                            ?>
                            <div class="promo-col">
                                <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="promo-item<?if($key == 'END'):?> promo-item__deactive<?endif;?>"<?if($arItem['PREVIEW_PICTURE']):?> style="background-image: url(<?=$arItem['PREVIEW_PICTURE']['SRC']?>);"<?endif;?> id="<?= $this->getEditAreaId($arItem['ID']) ?>">
                                    <?if($arItem['PROPERTIES']['DATE']['VALUE']):?>
                                        <div class="promo-item__date"><?=Loc::getMessage('SALES_MAIN_PRE_DATE')?> <?=$arItem['PROPERTIES']['DATE']['VALUE']?></div>
                                    <?endif;?>
                                    <div class="promo-item__content">
                                        <?/*a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="promo-item__title"><?=$arItem['~NAME']?></a>
                                        <div class="promo-item__description"><?=cut_string($arItem['~PREVIEW_TEXT'],150);?></div*/?>
                                        <?if($arItem['PROPERTIES']['TITLE']['VALUE']):?>
                                            <span class="promo-item__link"><?=$arItem['PROPERTIES']['TITLE']['VALUE']?> ></span>
                                        <?endif;?>
                                    </div>
                                    <?/*if($arItem['PREVIEW_PICTURE']):?>
                                        <div class="promo-item__thumb">
                                            <img src="<?=$arItem['PREVIEW_PICTURE']['src']?>" alt="<?=$arItem['~NAME']?>">
                                        </div>
                                    <?endif;*/?>
                                </a>
                            </div>
                        <? } ?>
                    </div>
                </div>
            <?endforeach;?>
        </div>
    </div>
<? } ?>