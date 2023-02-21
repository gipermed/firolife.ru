<?php

if (!\defined("B_PROLOG_INCLUDED") || \B_PROLOG_INCLUDED !== \true) {
    die;
}
use Bitrix\Main\Localization\Loc as Loc;
$COMPONENT_NAME = 'BXMAKER.GEOIP.DELIVERY';
$oManager = \BXmaker\GeoIP\Manager::getInstance();
// component parameters
$signer = new \Bitrix\Main\Security\Sign\Signer();
$signedParameters = $signer->sign(\base64_encode(\serialize($arResult['_ORIGINAL_PARAMS'])), 'bxmaker.geoip.delivery');
$signedTemplate = $signer->sign((string) $arResult['TEMPLATE'], 'bxmaker.geoip.delivery');
if ($arParams['IS_AJAX'] == 'N') {
    ?>

    <div class="bxmaker__geoip__delivery bxmaker__geoip__delivery--default js-bxmaker__geoip__delivery preloader"
         id="bxmaker__geoip__delivery-id<?php 
    echo $arParams['RAND_STRING'];
    ?>"
         data-rand="<?php 
    echo $arParams['RAND_STRING'];
    ?>">

		<?php 
    $frame = $this->createFrame('bxmaker__geoip__delivery-id' . $arParams['RAND_STRING'], \false)->begin();
    ?>

        <div class="bxmaker__geoip__delivery-preloader bxmaker__geoip__delivery-preloader--hide"></div>
        <div class="bxmaker__geoip__delivery-box js-bxmaker__geoip__delivery-box cart-delivery-info" data-city="<?php
    // =$arParams['CITY'];
    ?>" data-location="<?php 
    // =$arParams['LOCATION'];
    ?>" data-cookie-domain="<?php 
    echo $arParams['COOKIE_DOMAIN'];
    ?>" >
			<?php 
    if (\count($arResult['ITEMS'])) {
        ?>
				<?php 
        foreach ($arResult['ITEMS'] as $delivery) {
            ?>

                        <div class="bxmaker__geoip__delivery-box-item  bxmaker__geoip__delivery-box-item--<?php
            echo $delivery['ID'];
            ?>">

                            <div class="bxmaker__geoip__delivery-box-item-name">
                                <div class="bxmaker__geoip__delivery-box-item-name-text char">
                                    <?php 
                                        if ($arParams['SHOW_PARENT'] == 'Y' && !!$delivery['PARENT_NAME']) {
                                            echo $delivery['PARENT_NAME'] . ' <span>(' . $delivery['NAME'] . ') </span>';
                                        } else {
                                            echo $delivery['NAME'];
                                        }
                                        ?>
                                </div>
                            </div>
                            <?/*div class="bxmaker__geoip__delivery-box-item-period prymery__geoip__delivery-box-item">
								<?php 
                                echo $delivery['PERIOD_TEXT'];
                                ?>
                            </div*/?>
                            <div class="bxmaker__geoip__delivery-box-item-price prymery__geoip__delivery-box-item val">
                                <?php 
                                if ($delivery['PRICE'] == '0') {
                                    echo \GetMessage($COMPONENT_NAME . 'FREE');
                                } else {
                                    echo $delivery['PRICE_FORMATED'];
                                }
                                ?>
                            </div>
                        </div>


				<?php 
        }
        ?>
        <div class="cart-delivery-info__item cart-delivery-info__item--summ">
            <div class="char">Оплата</div>
            <div class="val">Онлайн или при получении</div>
        </div>
			<?php 
    } else {
        ?>
                <div class="bxmaker__geoip__delivery-box-item bxmaker__geoip__delivery-box-item--empty">
                    <div><?php
        echo \GetMessage($COMPONENT_NAME . 'EMPTY');
        ?></div>
                </div>
			<?php 
    }
    ?>
        </div>

        <script type="text/javascript" class="bxmaker-authuserphone-jsdata">
            window.BxmakerGeoipDeliveryData = window.BxmakerGeoipDeliveryData || {};
            window.BxmakerGeoipDeliveryData["<?php 
    echo $arParams['RAND_STRING'];
    ?>"] = <?php 
    echo \Bitrix\Main\Web\Json::encode(array('productId' => $arParams['PRODUCT_ID'], 'location' => $arParams['CALCULATE_NOW'] == 'Y' ? $arParams['LOCATION'] : '', 'city' => $arParams['CITY']));
    ?>;
        </script>


		<?php 
    $frame->beginStub();
    ?>

		<?php 
    if (\strlen(\trim($arParams['PROLOG'])) > 0) {
        ?>
            <div class="bxmaker__geoip__delivery-prolog">
				<?php 
        echo \preg_replace('/#CITY#/', '<span class="bxmaker__geoip__delivery-city js-bxmaker__geoip__delivery-city">' . $arResult['DEFAULT_CITY'] . '</span>', \trim($arParams['PROLOG']));
        ?>
            </div>
		<?php 
    }
    ?>

        <div class="bxmaker__geoip__delivery-preloader bxmaker__geoip__delivery-preloader--hide"></div>
        <table class="bxmaker__geoip__delivery-box js-bxmaker__geoip__delivery-box" data-city="" data-location="" data-cookie-domain=""></table>

		<?php 
    if (\strlen(\trim($arParams['EPILOG'])) > 0) {
        ?>
            <div class="bxmaker__geoip__delivery-epilog">
				<?php 
        echo \preg_replace('/#CITY#/', '<span class="bxmaker__geoip__delivery-city js-bxmaker__geoip__delivery-city">' . $arResult['DEFAULT_CITY'] . '</span>', \trim($arParams['~EPILOG']));
        ?>
            </div>
		<?php 
    }
    ?>


        <?php 
    $frame->end();
    ?>
    </div>

    <script type="text/javascript" class="bxmaker-authuserphone-jsdata">
        window.BxmakerGeoipDeliveryDataBase = window.BxmakerGeoipDeliveryDataBase || {};
        window.BxmakerGeoipDeliveryDataBase["<?php 
    echo $arParams['RAND_STRING'];
    ?>"] = <?php 
    echo \Bitrix\Main\Web\Json::encode(array('parameters' => $signedParameters, 'template' => $signedTemplate, 'siteId' => \SITE_ID, 'ajaxUrl' => $this->getComponent()->getPath() . '/ajax.php', 'debug' => $arParams['IS_DEBUG'], 'version' => $arParams['LV'], 'messages' => array()));
    ?>;
    </script>
    
<?php 
} else {
    ?>

    <div class="bxmaker__geoip__delivery-box js-bxmaker__geoip__delivery-box cart-delivery-info" data-city="<?php
    echo $arParams['CITY'];
    ?>" data-location="<?php 
    echo $arParams['LOCATION'];
    ?>"  >
		<?php 
    if (\count($arResult['ITEMS'])) {
        ?>
			<?php 
        foreach ($arResult['ITEMS'] as $delivery) {
            ?>

                <div class="cart-delivery-info__item bxmaker__geoip__delivery-box-item  bxmaker__geoip__delivery-box-item--<?php echo $delivery['ID'];?>">
					<?php 
                    $img = \false;
                    if (\intval($delivery['LOGOTIP']) && $arParams['IMG_SHOW'] == 'Y') {
                        $img = \CFile::ResizeImageGet($delivery['LOGOTIP'], array('width' => $arParams['IMG_WIDTH'], 'height' => $arParams['IMG_HEIGHT']), \BX_RESIZE_IMAGE_PROPORTIONAL_ALT);
                    }
                    ?>
                    <div class="bxmaker__geoip__delivery-box-item-name">
                        <div class="bxmaker__geoip__delivery-box-item-name-text char">
							<?php 
                                if ($arParams['SHOW_PARENT'] == 'Y' && !!$delivery['PARENT_NAME']) {
                                    echo $delivery['PARENT_NAME'] . ' <span>(' . $delivery['NAME'] . ') </span>';
                                } else {
                                    echo $delivery['NAME'];
                                }
                                ?>
                        </div>
                    </div>
                    <?/*div class="bxmaker__geoip__delivery-box-item-period prymery__geoip__delivery-box-item">
                        <?php 
                            echo $delivery['PERIOD_TEXT'];
                            ?>
                    </div*/?>
                    <div class="bxmaker__geoip__delivery-box-item-price prymery__geoip__delivery-box-item val">
                        <?php 
                            if (\trim($delivery['PRICE']) === '0') {
                                echo \GetMessage($COMPONENT_NAME . 'FREE');
                            } elseif (\trim($delivery['PRICE']) === '') {
                                echo '';
                            } else {
                                echo $delivery['PRICE_FORMATED'];
                            }
                            ?>
                    </div>
                </div>
			<?php 
        }
        ?>
        <div class="cart-delivery-info__item cart-delivery-info__item--summ">
            <div class="char">Оплата</div>
            <div class="val">Онлайн или при получении</div>
        </div>
		<?php 
    } else {
        ?>
            <div class="bxmaker__geoip__delivery-box-item bxmaker__geoip__delivery-box-item--empty">
                <div><?php
        echo \GetMessage($COMPONENT_NAME . 'EMPTY');
        ?></div>
            </div>
		<?php 
    }
    ?>
    </div>

<?php 
}
?>



<?php 