<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main, Bitrix\Main\Localization\Loc, Bitrix\Main\Page\Asset;
use Palladiumlab\Basket\BasketElement;
use Palladiumlab\Delivery\DeliveryElement;
use Palladiumlab\Order\OrdersListElement;
use Palladiumlab\Photo\NullPhotoModel;

Asset::getInstance()->addJs("/bitrix/components/bitrix/sale.order.payment.change/templates/bootstrap_v4/script.js");
Asset::getInstance()->addCss("/bitrix/components/bitrix/sale.order.payment.change/templates/bootstrap_v4/style.css");
CJSCore::Init(array(
	'clipboard',
	'fx'
));

Loc::loadMessages(__FILE__);
?>
<ul class="cabinet-page-nav tabs-nav-default">
    <li class="<?= $_REQUEST["filter_history"] == 'Y' ? "" : "active" ?>"><a
                href="<?= $arResult["CURRENT_PAGE"] ?>?filter_history=N">Текущие заказы</a></li>
    <li class="<?= $_REQUEST["filter_history"] == 'Y' ? "active" : "" ?>"><a
                href="<?= $arResult["CURRENT_PAGE"] ?>?filter_history=Y&filter_status=F">Все заказы</a></li>
</ul>
<div class="cabinet cabinet-orders">
    <div class="cabinet-section-title"><?= $_REQUEST["filter_history"] == 'Y' ? "Все заказы" : "Текущие заказы" ?></div>
    <div class="orders">

		<?php
		if (!empty($arResult['ERRORS']['FATAL']))
		{
			foreach ($arResult['ERRORS']['FATAL'] as $code => $error)
			{
				if ($code !== $component::E_NOT_AUTHORIZED) ShowError($error);
			}
			$component = $this->__component;
			if ($arParams['AUTH_FORM_IN_TEMPLATE'] && isset($arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED]))
			{
				?>
                <div class="row">
                    <div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                        <div class="alert alert-danger"><?= $arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED] ?></div>
                    </div>
					<? $authListGetParams = array(); ?>
                    <div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3">
						<? $APPLICATION->AuthForm('', false, false, 'N', false); ?>
                    </div>
                </div>
				<?
			}

		}
		else
		{

		if (!empty($arResult['ERRORS']['NONFATAL']))
		{
			foreach ($arResult['ERRORS']['NONFATAL'] as $error)
			{
				ShowError($error);
			}
		}

		?>

		<?
		if (!count($arResult['ORDERS']))
				{
				?>
            <div class="empty-info">
                <div class="empty-info-icon">
                    <img src="<?= SITE_TEMPLATE_PATH ?>/assets/img/empty-icon.svg"
                         alt="">
                </div>
                <div class="empty-info-title">
                    Здесь
                    пусто
                </div>
                <div class="cart-empty-info">
                    <div class="empty-info-desc">
                        У
                        вас
                        нет
                        ранее
                        оформленных
                        заказов.
                    </div>
                    <div class="cart-empty-desc">
                        Чтобы
                        оформить
                        заказ
                        воспользуйтесь
                        каталогом
                        продукции
                        для
                        добавления
                        товаров
                        в
                        корзину.
                        После
                        добавления
                        товаров
                        в
                        корзину
                        оформите
                        заказ.
                    </div>
                    <a href="<?= htmlspecialcharsbx($arParams['PATH_TO_CATALOG']) ?>"
                       class="btn btn-full btn-green cart-empty-btn">Перейти
                        в
                        каталог</a>
                </div>
            </div>
		<?
		} ?>

		<?php

		//if ($_REQUEST["show_canceled"] === 'Y' && count($arResult['ORDERS']))
		$paymentChangeData = array();
		$orderHeaderStatus = null;

		foreach ($arResult['ORDERS'] as $key => $order): ?>
            <div class="order-item">
                <div class="order">
                    <div class="order-head">
                        <div class="order-tr">
                            <div class="order-td order-td-number">
                                Номер
                                заказа
                            </div>
                            <div class="order-td order-td-date">
                                Дата
                                оформления
                                заказа
                            </div>
                            <div class="order-td order-td-payment">
                                Статус
                                оплаты
                            </div>
                            <div class="order-td order-td-delivery">
                                Доставка
                            </div>
                            <div class="order-td order-td-state">
                                Статус
                                заказа
                            </div>
                        </div>
                    </div>
					<?php
					$orderElement = new OrdersListElement($order["ORDER"]);
					$deliveryElement = new DeliveryElement($order["SHIPMENT"]);
					if ($orderHeaderStatus !== $order['ORDER']['STATUS_ID'] && $arResult['SORT_TYPE'] == 'STATUS')
					{
						$orderHeaderStatus = $order['ORDER']['STATUS_ID'];
						$payStatus = Loc::getMessage('SPOL_TPL_PAID');
						if ($order['ORDER']['IS_ALLOW_PAY'] == 'N') $payStatus = Loc::getMessage('SPOL_TPL_RESTRICTED_PAID');
						foreach ($order["PAYMENT"] as $payment)
						{
							if ($payment['PAID'] !== 'Y')
							{
								$payStatus = Loc::getMessage('SPOL_TPL_NOTPAID');
								break;
							}
						}
					}
					?>
                    <div class="order-body">
                        <div class="order-tr">
                            <div class="order-td order-td-number"
                                 data-title="Номер заказа">
								<?= Loc::getMessage('SPOL_TPL_NUMBER_SIGN') . $order['ORDER']['ACCOUNT_NUMBER'] ?></div>
                            <div class="order-td order-td-date"
                                 data-title="Дата оформления заказа"><?= $order['ORDER']['DATE_INSERT_FORMATED'] ?></div>
                            <div class="order-td order-td-payment"
                                 data-title="Статус
                                оплаты"><?= $payStatus ?></div>
                            <div class="order-td order-td-delivery"
                                 data-title="Доставка">
								<?= //$arResult["INFO"]["DELIVERY"][$order["ORDER"]["DELIVERY_ID"]]["NAME"];
								$deliveryElement->getDeliveryName() ?>
                            </div>
                            <div class="order-td order-td-state"
                                 data-title="Статус заказа">

                                <div class="order-state order-state-<?= $orderElement->getClassNameStatus() ?>"><?= $orderElement->getStatus($arResult["INFO"]["STATUS"]) ?></div>
                            </div>
                            <div class="order-td order-td-total visible-mobile"
                                 data-title="Итоговая стоимость заказа"><?= $order["ORDER"]["FORMATED_PRICE"] ?>
                            </div>
                        </div>
                    </div>
                    <div class="order-cart">
                        <div class="order-cart-head">
                            <a href="#"
                               class="order-cart-link item-link"
                               aria-label="Подробнее"></a>
                            <div class="order-cart-head-tr-wrapp">
                                <div class="order-tr order-tr-cart">
                                    <div class="order-td order-td-cart-title">
                                        Состав
                                        заказа
                                    </div>
                                    <div class="order-td order-td-cart-count">
                                        Товары
                                        (<?= count($order["BASKET_ITEMS"]) ?>
                                        )
                                    </div>
                                    <div class="order-td order-td-cart-sum hidden-mobile">
                                        Итого
                                        сумма: <?= $order["ORDER"]["FORMATED_PRICE"] ?></div>
                                </div>
                            </div>
                            <div class="order-cart-arrow">
                                <svg width="24"
                                     height="24">
                                    <use xlink:href="#icon-chevron-down"/>
                                </svg>
                            </div>
                        </div>
                        <div class="order-cart-body">
                            <div class="ordering-confirm-items">
								<? foreach ($order["BASKET_ITEMS"] as $basketItem):?>
									<?php
									$basketElement = new BasketElement($basketItem);

									$photo = $basketElement->getSku()->searchSkuModelPhoto($arResult["PHOTO_PRODUCTS"]->get($basketItem["PRODUCT_ID"], fn() => new NullPhotoModel()));
									?>
                                    <div class="ordering-confirm-item ordering-confirm-product">
                                        <div class="ordering-confirm-item-body">
                                            <div class="cart-item-product ordering-confirm-item-product">
                                                <a href="#"
                                                   class="item-link"
                                                   aria-label="На страницу продукта"></a>
                                                <div class="cart-item-product-img">
                                                    <img
                                                            src="<?= $photo->first()->getPhotoPath() ?>"
                                                            srcset="<?= $photo->first()->getPhoto2xPath() ?>"
                                                            alt="">
                                                </div>
                                                <div class="cart-item-product-body">
                                                    <div class="cart-item-product-title"><?= $basketElement->getNameWithoutSku() ?></div>
                                                    <div class="cart-item-product-code">
                                                        Артикул:
                                                        <b>0123912-Qm-S</b>
                                                    </div>
                                                    <ul class="cart-item-product-info">
                                                        <li><?= $basketElement->getSku()->getColorFormatted() ?>
                                                        <li><?= $basketElement->getSku()->getSizeFormatted() ?>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="ordering-confirm-item-info">
                                                <div class="ordering-confirm-item-number">
                                                    Количество: <?= $basketElement->getQuantity() ?>
                                                    шт
                                                </div>
                                                <div class="ordering-confirm-item-price"><?= $basketElement->getFormattedPrice() ?></div>
                                            </div>
                                        </div>
                                    </div>
								<?endforeach; ?>

                                <div class="ordering-confirm-item">
                                    <div class="ordering-confirm-item-body">
                                        <div class="ordering-confirm-item-delivery-title">
                                            Доставка
                                        </div>
                                        <div class="ordering-confirm-item-delivery-info">
                                            <p><?= $deliveryElement->getDeliveryName() ?>
                                        </div>
                                        <div class="ordering-confirm-item-delivery-price ordering-confirm-item-price"><?= $deliveryElement->getFormattedDeliveryPrice() ?></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <ul class="order-item-btns">

					<? if ($order["ORDER"]["CAN_CANCEL"] === "Y"):?>
                        <li class="hidden-tablet">
                            <div class="order-cancel">
                                <a href="<?= htmlspecialcharsbx($order["ORDER"]["URL_TO_CANCEL"]) ?>"
                                   class="order-cancel-btn btn btn-with-icon">
                                    <span>Отменить заказ</span>
                                    <svg width="24"
                                         height="24">
                                        <use xlink:href="#icon-question"/>
                                    </svg>
                                </a>
                                <div class="order-cancel-tooltip">
                                    <svg width="36"
                                         height="36">
                                        <use xlink:href="#icon-question"/>
                                    </svg>
                                    <div class="order-cancel-tooltip-text">
                                        <p>
                                            Заказ
                                            возможно
                                            отменить
                                            до
                                            статуса
                                            «Принят».
                                        <p>
                                            Если
                                            у
                                            вас
                                            остались
                                            вопросы
                                            -
                                            напишите
                                            в
                                            службу
                                            поддержки
                                            на
                                            электронную
                                            почту:
                                            <a href="mailto:no-reply@firolife.ru"
                                               target="_blank">no-reply@firolife.ru</a>
                                            или
                                            свяжитесь
                                            с
                                            оператором
                                            интернет-магазина
                                            по
                                            телефону:
                                            <a href="tel:88003014406">8
                                                800
                                                301-44-06</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="visible-tablet">
                            <a href="#modal-order-cancel"
                               class="order-cancel-btn btn btn-with-icon modal-open-btn">
                                <span>Отменить заказ</span>
                                <svg width="24"
                                     height="24">
                                    <use xlink:href="#icon-question"/>
                                </svg>
                            </a>
                        </li>
					<?endif; ?>
                    <li class="order-repeat-btn-wrapp">
                        <a href="<?= htmlspecialcharsbx($order["ORDER"]["URL_TO_COPY"]) ?>"
                           class="order-repeat-btn btn btn-with-icon">
                            <span><?= Loc::getMessage('SPOL_TPL_REPEAT_ORDER') ?></span>
                            <svg width="24"
                                 height="24">
                                <use xlink:href="#icon-repeat"/>
                            </svg>
                        </a>
                    </li>

                </ul>

            </div>

		<?php
		endforeach;

				echo $arResult["NAV_STRING"];

				if ($_REQUEST["filter_history"] !== 'Y')
				{
					$javascriptParams = array(
						"url"            => CUtil::JSEscape($this->__component->GetPath() . '/ajax.php'),
						"templateFolder" => CUtil::JSEscape($templateFolder),
						"templateName"   => $this->__component->GetTemplateName(),
						"paymentList"    => $paymentChangeData,
						"returnUrl"      => CUtil::JSEscape($arResult["RETURN_URL"]),
					);
					$javascriptParams = CUtil::PhpToJSObject($javascriptParams);
					?>
                    <script>
                        BX.Sale.PersonalOrderComponent.PersonalOrderList.init(<?=$javascriptParams?>);
                    </script>
					<?
				}
		}
				?>
            </div>
        </div>
