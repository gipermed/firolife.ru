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
<? /**/ ?>
    <button data-modal="<?= $arResult["AJAX_URL"] ?>?component=<?= $arResult["COMPONENT"] ?>"
            class="button-new-flat -red -lg -inline mb-16">
        Оформить без регистрации
    </button>
<? /**/ ?>