<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
$this->setFrameMode(false);
?>
<a href="javascript:;" data-modal="<?= $arResult["AJAX_URL"] ?>?component=<?= $arResult["COMPONENT"] ?>"
   class="v-btn v-btn--lg v-btn--red v-btn--w100 mb-20">
    Купить в 1 клик
</a>