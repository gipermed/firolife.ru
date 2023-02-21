<?php

if (!\defined("B_PROLOG_INCLUDED") || \B_PROLOG_INCLUDED !== \true) {
    die;
}
use Bitrix\Main\Localization\Loc as Loc;
$this->setFrameMode(\true);
/**
     * @var $this \CBitrixComponentTemplate
     */
$COMPONENT_NAME = 'BXMAKER.GEOIP.CITY';
$oManager = \Bxmaker\GeoIP\Manager::getInstance();
// component parameters
$signer = new \Bitrix\Main\Security\Sign\Signer();
$signedParameters = $signer->sign(\base64_encode(\serialize($arResult['_ORIGINAL_PARAMS'])), 'bxmaker.geoip.city');
$signedTemplate = $signer->sign((string) $arResult['TEMPLATE'], 'bxmaker.geoip.city');
?>

<div class="bxmaker__geoip__city bxmaker__geoip__city--default js-bxmaker__geoip__city "
     id="bxmaker__geoip__city-id<?php 
echo $arParams['RAND_STRING'];
?>"
     data-rand="<?php 
echo $arParams['RAND_STRING'];
?>">

    <?php 
if ($arParams['CITY_SHOW'] == 'Y') {
    ?>
        <?php 
    $APPLICATION->IncludeComponent("bxmaker:geoip.city.line", ".default", array("COMPONENT_TEMPLATE" => ".default", "CACHE_TYPE" => $arParams['CACHE_TYPE'], "CACHE_TIME" => $arParams['CACHE_TIME'], "COMPOSITE_FRAME_MODE" => $arParams['COMPOSITE_FRAME_MODE'], "COMPOSITE_FRAME_TYPE" => $arParams['COMPOSITE_FRAME_TYPE'], "CITY_LABEL" => $arParams['~CITY_LABEL'], "QUESTION_SHOW" => $arParams['QUESTION_SHOW'], "QUESTION_TEXT" => $arParams['~QUESTION_TEXT'], "INFO_SHOW" => $arParams['~INFO_SHOW'], "INFO_TEXT" => $arParams['~INFO_TEXT'], "BTN_EDIT" => $arParams['~BTN_EDIT']), $component, array('HIDE_ICON' => 'Y'));
    ?>
    <?php 
}
?>

    <div class="bxmaker__geoip__city__composite__params" id="bxmaker__geoip__city__composite__params__id<?php 
echo $arParams['RAND_STRING'];
?>">

        <?php 
$frame = $this->createFrame('bxmaker__geoip__city__composite__params__id' . $arParams['RAND_STRING'], \false)->begin('');
?>

        <script type="text/javascript" class="bxmaker-authuserphone-jsdata">
            window.BxmakerGeoipCityData = window.BxmakerGeoipCityData || {};
            window.BxmakerGeoipCityData["<?php 
echo $arParams['RAND_STRING'];
?>"] = <?php 
echo \Bitrix\Main\Web\Json::encode($arResult['JS_DATA']);
?>;
        </script>

        <?php 
$frame->end();
?>

    </div>


    <div class="bxmaker__geoip__popup js-bxmaker__geoip__popup <?php 
echo $arParams['SEARCH_SHOW'] != 'Y' ? 'bxmaker__geoip__popup--nosearch' : '';
?>"
         id="bxmaker__geoip__popup-id<?php 
echo $arParams['RAND_STRING'];
?>">
        <div class="bxmaker__geoip__popup-background js-bxmaker__geoip__popup-background"></div>

        <div class="bxmaker__geoip__popup-content js-bxmaker__geoip__popup-content">
            <div class="bxmaker__geoip__popup-close js-bxmaker__geoip__popup-close">&times;</div>
            <div class="bxmaker__geoip__popup-header">
                <?php 
echo $arParams['~POPUP_LABEL'];
?>
            </div>

            <?php 
if ($arParams['SEARCH_SHOW'] == 'Y') {
    ?>
            <div class="bxmaker__geoip__popup-search">
                <input type="text" name="city" value="" placeholder="<?php 
    echo $arParams['~INPUT_LABEL'];
    ?>" autocomplete="off">
                <span class="bxmaker__geoip__popup-search-clean js-bxmaker__geoip__popup-search-clean">&times;</span>
                <div class="bxmaker__geoip__popup-search-options js-bxmaker__geoip__popup-search-options"></div>
            </div>
            <?php 
}
?>

			<div class="prymery__geoip__popup-options-title">
                Популярные города
            </div>
            <div class="bxmaker__geoip__popup-options">
                <?php 
$iColRows = \ceil(\count($arResult['ITEMS']) / 4);
?>
                <div class="bxmaker__geoip__popup-options-col">
                    <?php 
$i = -1;
foreach ($arResult['ITEMS'] as $item) {
    if (++$i > 0 && $i % $iColRows == 0) {
        echo '</div><div class="bxmaker__geoip__popup-options-col ">';
    }
    echo '<div class="bxmaker__geoip__popup-option ' . ($item['MARK'] ? 'bxmaker__geoip__popup-option--bold' : '') . ' js-bxmaker__geoip__popup-option  "	data-id="' . $item['ID'] . '"><span>' . $item['NAME'] . '</span></div>';
}
?>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" class="bxmaker-authuserphone-jsdata">
    window.BxmakerGeoipCityDataBase = window.BxmakerGeoipCityDataBase || {};
    window.BxmakerGeoipCityDataBase["<?php 
echo $arParams['RAND_STRING'];
?>"] = <?php 
echo \Bitrix\Main\Web\Json::encode(array('parameters' => $signedParameters, 'template' => $signedTemplate, 'siteId' => \SITE_ID, 'ajaxUrl' => $this->getComponent()->getPath() . '/ajax.php', 'debug' => $arParams['IS_DEBUG'], 'version' => $arParams['LV']));
?>;
</script><?php 