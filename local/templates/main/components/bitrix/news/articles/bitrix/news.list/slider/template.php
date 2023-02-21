<?php check_prolog();

use Palladiumlab\Support\Util\Num;

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->setFrameMode(true);

?>
<div class="articles-slider swiper-container">
    <button class="slider-arrow slider-arrow-prev" aria-label="Назад">
        <svg width="30" height="30">
            <use xlink:href="#icon-arrow-down"/>
        </svg>
    </button>
    <button class="slider-arrow slider-arrow-next" aria-label="Вперед">
        <svg width="30" height="30">
            <use xlink:href="#icon-arrow-down"/>
        </svg>
    </button>
    <div class="swiper-wrapper">
        <?php foreach ($arResult["ITEMS"] as $item) { ?>
            <?php
            $this->addEditAction($item['ID'], $item['EDIT_LINK'], CIBlock::getArrayById($item["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->addDeleteAction($item['ID'], $item['DELETE_LINK'], CIBlock::getArrayById($item["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

            $picture = $item['PREVIEW_PICTURE']['SRC'] ?: $item['DETAIL_PICTURE']['SRC'];

            $viewCounter = Num::formatThousand((int)($item['DISPLAY_PROPERTIES']['VIEW_COUNTER']['VALUE'] ?? 0));
            ?>
            <div class="articles-col flex-row-item swiper-slide" id="<?= $this->getEditAreaId($item['ID']) ?>">
                <div class="article-item">
                    <a href="<?= $item['DETAIL_PAGE_URL'] ?>" class="item-link" aria-label="Читать статью"></a>
                    <div class="article-item-img">
                        <span><img src="<?= $picture ?>" srcset="<?= $picture ?> 2x" alt=""></span>
                    </div>
                    <div class="article-item-body">
                        <div class="article-item-title"><?= $item['NAME'] ?></div>
                        <div class="article-item-desc"><?= $item['PREVIEW_TEXT'] ?></div>
                        <div class="article-item-foot">
                            <div class="article-item-views">
                                <svg width="20" height="20">
                                    <use xlink:href="#icon-eye"/>
                                </svg>
                                <span class="js-view-counter" data-item-id="<?= $item['ID'] ?>">
                                    <?= $viewCounter ?>
                                </span>
                            </div>
                            <div class="article-item-btn">Читать</div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
