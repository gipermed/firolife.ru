<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

    use Bitrix\Main\Localization\Loc as Loc;


    $this->setFrameMode(true);

    $PRYMERY_COMPONENT_NAME = 'PRYMERY.GEOIP.CITY.LINE';

    $oManager = \Prymery\GeoIP\Manager::getInstance();

?>

<div class="prymery__geoip__city__line  prymery__geoip__city__line--default js-prymery__geoip__city__line"
     id="prymery__geoip__city__line-id<?= $randString; ?>" data-rand="<?=$arParams['RAND_STRING'];?>" >
    <i>
        <svg width="24" height="24">
            <use xlink:href="#icon-location"/>
        </svg>
    </i>
    <span class="prymery__geoip__city__line-label"><?= $arParams['~CITY_LABEL']; ?></span>

    <div class="prymery__geoip__city__line-context js-prymery__geoip__city__line-context">
        <span class="prymery__geoip__city__line-name js-prymery__geoip__city__line-name js-prymery__geoip__city__line-city"></span>


        <div class="prymery__geoip__city__line-question js-prymery__geoip__city__line-question">
            <div class="prymery__geoip__city__line-question-text">
                <?= preg_replace('/#CITY#/', '<span class="js-prymery__geoip__city__line-city"></span>', $arParams['~QUESTION_TEXT']); ?>
            </div>
            <div class="prymery__geoip__city__line-question-btn-box">
                <div class="prymery__geoip__city__line-question-btn-no js-prymery__geoip__city__line-question-btn-no"><?= Loc::getMessage($PRYMERY_COMPONENT_NAME . 'BTN_NO'); ?></div>
                <div class="prymery__geoip__city__line-question-btn-yes js-prymery__geoip__city__line-question-btn-yes"><?= Loc::getMessage($PRYMERY_COMPONENT_NAME . 'BTN_YES'); ?></div>
            </div>
        </div>

        <div class="prymery__geoip__city__line-info js-prymery__geoip__city__line-info">
            <div class="prymery__geoip__city__line-info-content">
                <?= $arParams['~INFO_TEXT']; ?>
            </div>
            <div class="prymery__geoip__city__line-info-btn-box">
                <div class="prymery__geoip__city__line-info-btn js-prymery__geoip__city__line-info-btn"><?= $arParams['~BTN_EDIT']; ?></div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript" class="prymery-authuserphone-jsdata">
    window.PrymeryGeoipCityLineData = window.PrymeryGeoipCityLineData || {};
    window.PrymeryGeoipCityLineData["<?=$arParams['RAND_STRING'];?>"] = <?= Bitrix\Main\Web\Json::encode(array(
        'messages' => array(),
        'debug'          => ($arParams['IS_DEBUG'] == 'Y'),
        'tooltipTimeout' => 500,
        'animateTimeout' => 200,
        'infoShow' => ($arParams['INFO_SHOW'] == 'Y'),
        'questionShow' => ($arParams['QUESTION_SHOW'] == 'Y'),

    ));?>;
</script>
