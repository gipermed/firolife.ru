<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

    use Bitrix\Main\Localization\Loc as Loc;

    $this->setFrameMode(true);

    /**
     * @var $this \CBitrixComponentTemplate
     */


    $COMPONENT_NAME = 'BXMAKER.GEOIP.CITY';

    $oManager = \Bxmaker\GeoIP\Manager::getInstance();


    // component parameters
    $signer = new \Bitrix\Main\Security\Sign\Signer;
    $signedParameters = $signer->sign(base64_encode(serialize($arResult['_ORIGINAL_PARAMS'])), 'bxmaker.geoip.city');
    $signedTemplate = $signer->sign((string)$arResult['TEMPLATE'], 'bxmaker.geoip.city');


?>

<div class="bxmaker__geoip__city bxmaker__geoip__city--default js-bxmaker__geoip__city "
     id="bxmaker__geoip__city-id<?= $arParams['RAND_STRING']; ?>"
     data-rand="<?= $arParams['RAND_STRING']; ?>">

    <? if ($arParams['CITY_SHOW'] == 'Y'): ?>
        <? $APPLICATION->IncludeComponent("bxmaker:geoip.city.line", ".default", array(
            "COMPONENT_TEMPLATE"   => ".default",
            "CACHE_TYPE"           => $arParams['CACHE_TYPE'],
            "CACHE_TIME"           => $arParams['CACHE_TIME'],
            "COMPOSITE_FRAME_MODE" => $arParams['COMPOSITE_FRAME_MODE'],
            "COMPOSITE_FRAME_TYPE" => $arParams['COMPOSITE_FRAME_TYPE'],
            "CITY_LABEL"           => $arParams['~CITY_LABEL'],
            "QUESTION_SHOW"        => $arParams['QUESTION_SHOW'],
            "QUESTION_TEXT"        => $arParams['~QUESTION_TEXT'],
            "INFO_SHOW"            => $arParams['~INFO_SHOW'],
            "INFO_TEXT"            => $arParams['~INFO_TEXT'],
            "BTN_EDIT"             => $arParams['~BTN_EDIT'],
        ), $component, array( 'HIDE_ICON' => 'Y' )); ?>
    <? endif; ?>

    <div class="bxmaker__geoip__city__composite__params" id="bxmaker__geoip__city__composite__params__id<?= $arParams['RAND_STRING']; ?>">

        <? $frame = $this->createFrame('bxmaker__geoip__city__composite__params__id' . $arParams['RAND_STRING'], false)->begin(''); ?>

        <script type="text/javascript" class="bxmaker-authuserphone-jsdata">
            window.BxmakerGeoipCityData = window.BxmakerGeoipCityData || {};
            window.BxmakerGeoipCityData["<?=$arParams['RAND_STRING'];?>"] = <?= Bitrix\Main\Web\Json::encode($arResult['JS_DATA']);?>;
        </script>

        <? $frame->end(); ?>

    </div>


    <div class="bxmaker__geoip__popup js-bxmaker__geoip__popup <?=($arParams['SEARCH_SHOW'] != 'Y' ? 'bxmaker__geoip__popup--nosearch' : '');?>"
         id="bxmaker__geoip__popup-id<?= $arParams['RAND_STRING']; ?>">
        <div class="bxmaker__geoip__popup-background js-bxmaker__geoip__popup-background"></div>

        <div class="bxmaker__geoip__popup-content js-bxmaker__geoip__popup-content">
            <div class="bxmaker__geoip__popup-close js-bxmaker__geoip__popup-close">&times;</div>
            <div class="bxmaker__geoip__popup-header">
                <?= $arParams['~POPUP_LABEL']; ?>
            </div>

            <?if($arParams['SEARCH_SHOW'] == 'Y'):?>
            <div class="bxmaker__geoip__popup-search">
                <input type="text" name="city" value="" placeholder="<?= $arParams['~INPUT_LABEL']; ?>" autocomplete="off">
                <span class="bxmaker__geoip__popup-search-clean js-bxmaker__geoip__popup-search-clean">&times;</span>
                <div class="bxmaker__geoip__popup-search-options js-bxmaker__geoip__popup-search-options"></div>
            </div>
            <?endif;?>


            <div class="bxmaker__geoip__popup-options">
                <?
                    $iColRows = ceil(count($arResult['ITEMS']) / 3);
                ?>
                <div class="bxmaker__geoip__popup-options-col">
                    <?
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
    window.BxmakerGeoipCityDataBase["<?=$arParams['RAND_STRING'];?>"] = <?= Bitrix\Main\Web\Json::encode(array(
        'parameters' => $signedParameters,
        'template'   => $signedTemplate,
        'siteId'     => SITE_ID,
        'ajaxUrl'    => $this->getComponent()->getPath() . '/ajax.php',
        'debug'      => $arParams['IS_DEBUG'],
        'version'      => $arParams['LV'],
    ));?>;
</script>