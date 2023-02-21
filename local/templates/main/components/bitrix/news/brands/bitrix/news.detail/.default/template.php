<?php check_prolog();
$this->setFrameMode(true);
$picture = $arResult['DETAIL_PICTURE']['SRC'];
?>
<div class="brandsDetail section content-section">
    <div class="brandsDetail-uptitle">Бренды</div>
    <h1 class="section-title brandsDetail-title"><?= $arResult['NAME'] ?></h1>
    <div class="brandsDetail-info">
        <?if($arResult['DETAIL_PICTURE']):?>
            <div class="brandsDetail-img">
                <img src="<?=$arResult['DETAIL_PICTURE']['src']?>" alt="<?= $arResult['NAME'] ?>">
            </div>
        <?endif;?>
        <?if($arResult['DETAIL_TEXT']):?>
            <div class="brandsDetail-content content-text">
                <div class="brandsDetail-content__title">О компании</div>
                <?= $arResult['DETAIL_TEXT'] ?>
            </div>
        <?endif;?>
    </div>
</div>
