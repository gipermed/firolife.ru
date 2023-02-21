<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

    use Bitrix\Main\Localization\Loc as Loc;

    $this->setFrameMode(true);

    /**
     * @var $this \CBitrixComponentTemplate
     */


    $COMPONENT_NAME = 'PRYMERY.GEOIP.CITY';

    $oManager = \Prymery\GeoIP\Manager::getInstance();


    // component parameters
    global $signedParameters;
    global $signedTemplate;
    $signer = new \Bitrix\Main\Security\Sign\Signer;
    $signedParameters = $signer->sign(base64_encode(serialize($arResult['_ORIGINAL_PARAMS'])), 'prymery.geoip.city');
    $signedTemplate = $signer->sign((string)$arResult['TEMPLATE'], 'prymery.geoip.city');

?>

<div class="prymery__geoip__city prymery__geoip__city--default js-prymery__geoip__city "
     id="prymery__geoip__city-id<?= $arParams['RAND_STRING']; ?>"
     data-rand="<?= $arParams['RAND_STRING']; ?>">

    <? if ($arParams['CITY_SHOW'] == 'Y'): ?>
        <? $APPLICATION->IncludeComponent("prymery:geoip.city.line", ".default", array(
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

    <div class="prymery__geoip__city__composite__params" id="prymery__geoip__city__composite__params__id<?= $arParams['RAND_STRING']; ?>">

        <? $frame = $this->createFrame('prymery__geoip__city__composite__params__id' . $arParams['RAND_STRING'], false)->begin(''); ?>

        <script type="text/javascript" class="prymery-authuserphone-jsdata">
            window.PrymeryGeoipCityData = window.PrymeryGeoipCityData || {};
            window.PrymeryGeoipCityData["<?=$arParams['RAND_STRING'];?>"] = <?= Bitrix\Main\Web\Json::encode($arResult['JS_DATA']);?>;
        </script>

        <? $frame->end(); ?>

    </div>


    <div class="prymery__geoip__popup js-prymery__geoip__popup <?=($arParams['SEARCH_SHOW'] != 'Y' ? 'prymery__geoip__popup--nosearch' : '');?>"
         id="prymery__geoip__popup-id<?= $arParams['RAND_STRING']; ?>">
        <div class="prymery__geoip__popup-background js-prymery__geoip__popup-background"></div>

        <div class="prymery__geoip__popup-content js-prymery__geoip__popup-content">
            <div class="prymery__geoip__popup-close js-prymery__geoip__popup-close">&times;</div>
            <div class="prymery__geoip__popup-header">
                <?= $arParams['~POPUP_LABEL']; ?>
            </div>

            <?if($arParams['SEARCH_SHOW'] == 'Y'):?>
            <div class="prymery__geoip__popup-search">
                <div class="prymery__geoip__popup-icon"></div>
                <input type="text" name="city" value="" placeholder="<?= $arParams['~INPUT_LABEL']; ?>" autocomplete="off">
                <span class="prymery__geoip__popup-search-clean js-prymery__geoip__popup-search-clean">&times;</span>
                <div class="prymery__geoip__popup-search-options js-prymery__geoip__popup-search-options"></div>
            </div>
            <?endif;?>

            <div class="prymery__geoip__popup-options-title">
                Популярные города
            </div>
            <div class="prymery__geoip__popup-options">
                <?
                    $iColRows = ceil(count($arResult['ITEMS']) / 4);
                ?>
                <div class="prymery__geoip__popup-options-col">
                    <?

                        $i = -1;
                        foreach ($arResult['ITEMS'] as $item) {

                            if (++$i > 0 && $i % $iColRows == 0) {
                                echo '</div><div class="prymery__geoip__popup-options-col ">';
                            }
                            if($_COOKIE['prymery_geoip_2_8_1_city_id'] == $item['ID'] ){
                                $item['MARK'] = 'Y';
                            }
                            echo '<div class="prymery__geoip__popup-option ' . ($item['MARK'] && $_COOKIE['prymery_geoip_2_8_1_location_confirm'] ? 'prymery__geoip__popup-option--bold' : '') . ' js-prymery__geoip__popup-option  "	data-id="' . $item['ID'] . '"><span>' . $item['NAME'] . '</span></div>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" class="prymery-authuserphone-jsdata">
    window.PrymeryGeoipCityDataBase = window.PrymeryGeoipCityDataBase || {};
    window.PrymeryGeoipCityDataBase["<?=$arParams['RAND_STRING'];?>"] = <?= Bitrix\Main\Web\Json::encode(array(
        'parameters' => $signedParameters,
        'template'   => $signedTemplate,
        'siteId'     => SITE_ID,
        'ajaxUrl'    => $this->getComponent()->getPath() . '/ajax.php',
        'debug'      => $arParams['IS_DEBUG'],
        'version'      => $arParams['LV'],
    ));?>;
    $('.js-prymery__geoip__popup-option').on('click',function(e){
        $('body').find('.js-prymery__geoip__popup-option').removeClass('prymery__geoip__popup-option--bold');
        $(this).addClass('prymery__geoip__popup-option--bold');
    });
</script>