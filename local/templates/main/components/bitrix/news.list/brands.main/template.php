<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
use Bitrix\Main\Localization\Loc;
if ($arResult["ITEMS"]): ?>
    <div class="section home-brands-section">
        <div class="container">
            <div class="section-title"><?=Loc::getMessage('BRANDS_MAIN_TITLE')?></div>
            <div class="brands-slider-container swiper-slider-container">
                <div class="brands-main-slider swiper">
                    <div class="swiper-wrapper">
                        <? foreach ($arResult["ITEMS"] as $arItem):
                            $this->addEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::getArrayById($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                            $this->addDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::getArrayById($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                            ?>
                            <div class="swiper-slide">
                                <div class="brands-item" id="<?= $this->getEditAreaId($arItem['ID']) ?>">
                                    <?if($arItem['PREVIEW_PICTURE']):?>
                                        <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="brands-item__thumb">
                                            <img src="<?=$arItem['PREVIEW_PICTURE']['src']?>" alt="<?=$arItem['~NAME']?>">
                                        </a>
                                    <?endif;?>
                                </div>
                            </div>
                        <?endforeach; ?>
                    </div>
                </div>
                <div class="swiper-button-prev"><svg class="icon"><use xlink:href="#icon-arrow-down"></use></svg></div>
                <div class="swiper-button-next"><svg class="icon"><use xlink:href="#icon-arrow-down"></use></svg></div>
            </div>
            <div class="read-more-btn-wrapp">
                <a href="/brands/" class="btn read-more-btn"><?=Loc::getMessage('BRANDS_MAIN_TITLE_LINK')?></a>
            </div>
        </div>
    </div>
<?endif; ?>