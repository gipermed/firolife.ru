<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

    use Bitrix\Main\Localization\Loc as Loc;


    $this->setFrameMode(true);

    $BXMAKER_COMPONENT_NAME = 'BXMAKER.GEOIP.CITY.LINE';

    $oManager = \Bxmaker\GeoIP\Manager::getInstance();

?>


<div class="bxmaker__geoip__city__line  bxmaker__geoip__city__line--default js-bxmaker__geoip__city__line"
     id="bxmaker__geoip__city__line-id<?= $randString; ?>" data-rand="<?=$arParams['RAND_STRING'];?>" >


    <div class="bxmaker__geoip__city__line-context js-bxmaker__geoip__city__line-context">
        <span class="bxmaker__geoip__city__line-name js-bxmaker__geoip__city__line-name js-bxmaker__geoip__city__line-city"></span>


        <div class="bxmaker__geoip__city__line-question js-bxmaker__geoip__city__line-question">
            <div class="bxmaker__geoip__city__line-question-text">
                <?= preg_replace('/#CITY#/', '<span class="js-bxmaker__geoip__city__line-city"></span>', $arParams['~QUESTION_TEXT']); ?>
            </div>
            <div class="bxmaker__geoip__city__line-question-btn-box">
                <div class="bxmaker__geoip__city__line-question-btn-no js-bxmaker__geoip__city__line-question-btn-no"><?= Loc::getMessage($BXMAKER_COMPONENT_NAME . 'BTN_NO'); ?></div>
                <div class="bxmaker__geoip__city__line-question-btn-yes js-bxmaker__geoip__city__line-question-btn-yes"><?= Loc::getMessage($BXMAKER_COMPONENT_NAME . 'BTN_YES'); ?></div>
            </div>
        </div>

        <div class="bxmaker__geoip__city__line-info js-bxmaker__geoip__city__line-info">
            <div class="bxmaker__geoip__city__line-info-content">
                <?= $arParams['~INFO_TEXT']; ?>
            </div>
            <div class="bxmaker__geoip__city__line-info-btn-box">
                <div class="bxmaker__geoip__city__line-info-btn js-bxmaker__geoip__city__line-info-btn"><?= $arParams['~BTN_EDIT']; ?></div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript" class="bxmaker-authuserphone-jsdata">
    window.BxmakerGeoipCityLineData = window.BxmakerGeoipCityLineData || {};
    window.BxmakerGeoipCityLineData["<?=$arParams['RAND_STRING'];?>"] = <?= Bitrix\Main\Web\Json::encode(array(
        'messages' => array(),
        'debug'          => ($arParams['IS_DEBUG'] == 'Y'),
        'tooltipTimeout' => 500,
        'animateTimeout' => 200,
        'infoShow' => ($arParams['INFO_SHOW'] == 'Y'),
        'questionShow' => ($arParams['QUESTION_SHOW'] == 'Y'),

    ));?>;
</script>
