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

$date = date('d/m/Y', strtotime($arResult['DATE_CREATE']));

$picture = $arResult['DETAIL_PICTURE']['SRC'];

$viewCounter = Num::formatThousand((int)($arResult['DISPLAY_PROPERTIES']['VIEW_COUNTER']['VALUE'] ?? 0));
?>
<div class="article section content-section">
    <div class="article-body">
        <h1 class="section-title article-title"><?= $arResult['NAME'] ?></h1>
        <div class="article-info">
            <div class="article-item-views">
                <svg width="20" height="20">
                    <use xlink:href="#icon-eye"/>
                </svg>
                <span class="js-view-counter" data-item-id="<?= $arResult['ID'] ?>">
                    <?= $viewCounter ?>
                </span>
            </div>
            <div class="article-date"><?= $date ?></div>
        </div>
        <div class="article-content content-text">
            <?= $arResult['DETAIL_TEXT'] ?>
        </div>
    </div>
    <div class="article-products hidden-tablet">
        <div class="article-product">
            <a href="#" class="item-link" aria-label="Перейти на страницу"></a>
            <div class="article-product-sale">-10%</div>
            <div class="article-product-body">
                <div class="article-product-title">Антисептик для рук<br> Dezon</div>
                <div class="article-product-desc">
                    Скидка 10% при покупке 5 бутылок антисептиков с распылителем производства Dezon
                </div>
                <div class="article-product-btn">Подробнее</div>
            </div>
            <div class="article-product-img">
                <img src="<?= SITE_TEMPLATE_PATH ?>/assets/img/article-product-img.png"
                     srcset="<?= SITE_TEMPLATE_PATH ?>/assets/img/article-product-img@2x.png 2x" alt="">
            </div>
        </div>
    </div>
</div>
