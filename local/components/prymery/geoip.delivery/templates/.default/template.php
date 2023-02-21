<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

	use Bitrix\Main\Localization\Loc as Loc;

	$COMPONENT_NAME = 'PRYMERY.GEOIP.DELIVERY';

	$oManager = \Prymery\GeoIP\Manager::getInstance();

    // component parameters
    $signer = new \Bitrix\Main\Security\Sign\Signer;
    $signedParameters = $signer->sign(base64_encode(serialize($arResult['_ORIGINAL_PARAMS'])), 'prymery.geoip.delivery');
    $signedTemplate = $signer->sign((string)$arResult['TEMPLATE'], 'prymery.geoip.delivery');
?>
<? if ($arParams['IS_AJAX'] == 'N'): ?>

    <div class="prymery__geoip__delivery prymery__geoip__delivery--default js-prymery__geoip__delivery preloader"
         id="prymery__geoip__delivery-id<?= $arParams['RAND_STRING']; ?>"
         data-rand="<?= $arParams['RAND_STRING']; ?>">

		<? $frame = $this->createFrame('prymery__geoip__delivery-id' . $arParams['RAND_STRING'], false)->begin(); ?>

		<? /*if (strlen(trim($arParams['PROLOG'])) > 0): ?>
            <div class="prymery__geoip__delivery-prolog">
				<?= preg_replace('/#CITY#/', '<span class="prymery__geoip__delivery-city js-prymery__geoip__delivery-city">' . $arResult['DEFAULT_CITY'] . '</span>', trim($arParams['PROLOG'])); ?>
            </div>
		<? endif; */?>

        <div class="prymery__geoip__delivery-preloader prymery__geoip__delivery-preloader--hide"></div>

        
        <table class="prymery__geoip__delivery-box js-prymery__geoip__delivery-box" data-city="<?//=$arParams['CITY'];?>" data-location="<?//=$arParams['LOCATION'];?>" data-cookie-domain="<?=$arParams['COOKIE_DOMAIN'];?>" >
			<? if (count($arResult['ITEMS'])): ?>
				<? foreach ($arResult['ITEMS'] as $delivery): ?>

                        <tr class="prymery__geoip__delivery-box-item  prymery__geoip__delivery-box-item--<?= $delivery['ID'] ?>">
							<?php
								$img = false;
								if (intval($delivery['LOGOTIP']) && $arParams['IMG_SHOW'] == 'Y') {
									$img = CFile::ResizeImageGet($delivery['LOGOTIP'], array('width' => $arParams['IMG_WIDTH'], 'height' => $arParams['IMG_HEIGHT']), BX_RESIZE_IMAGE_PROPORTIONAL_ALT);
								}
							?>
                            <td class="prymery__geoip__delivery-box-item-name <?= ($img ? ' prymery__geoip__delivery-box-item-name--image ' : ''); ?>">

								<? /*if ($img): ?>
                                        <img class="prymery__geoip__delivery-box-item-name-img" src="<?= $img['src']; ?>" alt="<?= $delivery['NAME']; ?>"/>
								<? endif; */?>

                                <div class="prymery__geoip__delivery-box-item-name-text">
                                    <?if($arParams['SHOW_PARENT'] == 'Y' && !!$delivery['PARENT_NAME'])
                                    {
                                        echo $delivery['PARENT_NAME'] . ' <span>(' .  $delivery['NAME'] . ') </span>';
                                    }
                                    else {
										echo $delivery['NAME'];
                                    }
                                    ?>
                                </div>


								<? if (!!$delivery['DESCRIPTION']): ?>
                                    <div class="prymery__geoip__delivery-box-item-more">
                                        <div class="prymery__geoip__delivery-box-item-more-content"><?= $delivery['DESCRIPTION'] ?></div>
                                    </div>
								<? endif; ?>
                            </td>
                            <td class="prymery__geoip__delivery-box-item-period">
								<?=$delivery['PERIOD_TEXT'];?>
                                <?//=$oManager->getDeliveryPeriodFormat($delivery['PERIOD_FROM'], $delivery['PERIOD_TO']); ?>
                            </td>
                            <td class="prymery__geoip__delivery-box-item-price">
								<?//=$delivery['PRICE_FORMATED'] ?>
                                <?php
                                    if($delivery['PRICE'] == '0')
                                    {
                                        echo GetMessage($COMPONENT_NAME . 'FREE');
                                    }
                                    else
                                    {
                                        echo $delivery['PRICE_FORMATED'];
                                    }
                                ?>
                            </td>
                        </tr>


				<? endforeach; ?>
			<? else: ?>
                <tr class="prymery__geoip__delivery-box-item prymery__geoip__delivery-box-item--empty">
                    <td><?= GetMessage($COMPONENT_NAME . 'EMPTY') ?></td>
                </tr>
			<? endif; ?>
        </table>


		<? if (strlen(trim($arParams['EPILOG'])) > 0): ?>
            <div class="prymery__geoip__delivery-epilog">
				<?= preg_replace('/#CITY#/', '<span class="prymery__geoip__delivery-city js-prymery__geoip__delivery-city">' . $arResult['DEFAULT_CITY'] . '</span>', trim($arParams['~EPILOG'])); ?>
            </div>
		<? endif; ?>


        <script type="text/javascript" class="prymery-authuserphone-jsdata">
            window.PrymeryGeoipDeliveryData = window.PrymeryGeoipDeliveryData || {};
            window.PrymeryGeoipDeliveryData["<?=$arParams['RAND_STRING'];?>"] = <?= Bitrix\Main\Web\Json::encode(array(
                'productId' => $arParams['PRODUCT_ID'],
                'location' => ($arParams['CALCULATE_NOW'] == 'Y' ? $arParams['LOCATION'] : ''),
                'city' => $arParams['CITY'],
            ));?>;
        </script>


		<? $frame->beginStub(); ?>

		<?/* if (strlen(trim($arParams['PROLOG'])) > 0): ?>
            <div class="prymery__geoip__delivery-prolog">
				<?= preg_replace('/#CITY#/', '<span class="prymery__geoip__delivery-city js-prymery__geoip__delivery-city">' . $arResult['DEFAULT_CITY'] . '</span>', trim($arParams['PROLOG'])); ?>
            </div>
		<? endif; */?>

        <div class="prymery__geoip__delivery-preloader prymery__geoip__delivery-preloader--hide"></div>
        <table class="prymery__geoip__delivery-box js-prymery__geoip__delivery-box" data-city="" data-location="" data-cookie-domain=""></table>

		<? if (strlen(trim($arParams['EPILOG'])) > 0): ?>
            <div class="prymery__geoip__delivery-epilog">
				<?= preg_replace('/#CITY#/', '<span class="prymery__geoip__delivery-city js-prymery__geoip__delivery-city">' . $arResult['DEFAULT_CITY'] . '</span>', trim($arParams['~EPILOG'])); ?>
            </div>
		<? endif; ?>


        <? $frame->end(); ?>
    </div>

    <script type="text/javascript" class="prymery-authuserphone-jsdata">
        window.PrymeryGeoipDeliveryDataBase = window.PrymeryGeoipDeliveryDataBase || {};
        window.PrymeryGeoipDeliveryDataBase["<?=$arParams['RAND_STRING'];?>"] = <?= Bitrix\Main\Web\Json::encode(array(
            'parameters' => $signedParameters,
            'template'   => $signedTemplate,
            'siteId'     => SITE_ID,
            'ajaxUrl'    => $this->getComponent()->getPath() . '/ajax.php',

            'debug'      => $arParams['IS_DEBUG'],
            'version'      => $arParams['LV'],
            'messages' => array(),
        ));?>;
    </script>
    
<? else: ?>

    <div class="prymery__geoip__delivery-box js-prymery__geoip__delivery-box" data-city="<?=$arParams['CITY'];?>" data-location="<?=$arParams['LOCATION'];?>"  >
		<? if (count($arResult['ITEMS'])): ?>
			<? foreach ($arResult['ITEMS'] as $delivery): ?>

                <p class="prymery__geoip__delivery-box-item  prymery__geoip__delivery-box-item--<?= $delivery['ID'] ?>">
                    <span class="prymery__geoip__delivery-box-item-name-text">
                        <?if($arParams['SHOW_PARENT'] == 'Y' && !!$delivery['PARENT_NAME'])
                        {
                            echo $delivery['PARENT_NAME'] . ' <span>(' .  $delivery['NAME'] . ') </span>';
                        }
                        else {
                            echo $delivery['NAME'];
                        }
                        ?>
                    </span>
                    <? /*if (!!$delivery['DESCRIPTION']): ?>
                        <span class="prymery__geoip__delivery-box-item-more">
                            <?= $delivery['DESCRIPTION'] ?>
                        </span>
                    <? endif; */?>
                    <?if($delivery['PERIOD_TEXT']):?>
                        - <?=$delivery['PERIOD_TEXT'];?>
                    <?endif;?>
                        -
                    <?php
                        if(trim($delivery['PRICE']) === '0')
                        {
                            echo GetMessage($COMPONENT_NAME . 'FREE');
                        }
                        elseif(trim($delivery['PRICE']) === '')
                        {
                            echo '';
                        }
                        else
                        {
                            echo $delivery['PRICE_FORMATED'];
                        }
                    ?>
                </p>


			<? endforeach; ?>
		<? else: ?>
            <div class="prymery__geoip__delivery-box-item prymery__geoip__delivery-box-item--empty">
                <div><?= GetMessage($COMPONENT_NAME . 'EMPTY') ?></div>
            </div>
		<? endif; ?>
    </div>

<? endif; ?>



