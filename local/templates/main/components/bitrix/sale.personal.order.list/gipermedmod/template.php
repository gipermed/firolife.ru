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
CModule::IncludeModule('ipol.sdek');

Loc::loadMessages(__FILE__);
?>

<div class="cabinet cabinet-orders">
    <div class="cabinet-section-title">Мои заказы <a href="/personal/main/" class="btn-lk-return">< Вернуться в профиль</a></div>
    <div class="orders-list">

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
		if (!count($arResult['ORDERS'])){?>
            <div class="order-empty">
                <div class="order-empty__thumb">
                    <svg class="icon" width="196" height="196" viewBox="0 0 196 196" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M141.599 72.2963C141.599 78.5333 136.546 83.5889 130.309 83.5889C124.075 83.5889 119.02 78.5333 119.02 72.2963C119.02 66.0593 124.075 61.0068 130.309 61.0068C136.546 61.0068 141.599 66.0593 141.599 72.2963Z" fill="#C8C8C8"/>
                        <path d="M76.6883 72.2963C76.6883 78.5333 71.6327 83.5889 65.3989 83.5889C59.165 83.5889 54.1094 78.5333 54.1094 72.2963C54.1094 66.0593 59.165 61.0068 65.3989 61.0068C71.6327 61.0068 76.6883 66.0593 76.6883 72.2963Z" fill="#C8C8C8"/>
                        <path d="M59.5975 156.691C57.0296 156.691 54.9453 154.61 54.9453 152.039C54.9453 131.957 71.098 115.618 90.954 115.618H106.635C126.491 115.618 142.644 131.867 142.644 151.838C142.644 154.409 140.563 156.493 137.992 156.493C135.423 156.493 133.343 154.409 133.343 151.838C133.343 137 121.362 124.926 106.635 124.926H90.9543C76.2282 124.926 64.2503 137.087 64.2503 152.039C64.2496 154.61 62.1653 156.691 59.5975 156.691Z" fill="#C8C8C8"/>
                        <path d="M98.0001 196C43.9748 196 0.0234375 152.036 0.0234375 97.9984C0.0234375 43.9638 43.9748 0 98.0001 0C152.022 0 195.974 43.9638 195.974 97.9984C195.974 152.036 152.022 196 98.0001 196ZM98.0001 9.30779C49.1047 9.30779 9.32812 49.094 9.32812 97.9984C9.32812 146.906 49.105 186.692 98.0001 186.692C146.892 186.692 186.669 146.906 186.669 97.9984C186.669 49.0937 146.892 9.30779 98.0001 9.30779Z" fill="#C8C8C8"/>
                    </svg>
                </div>
                <div class="order-empty__title">Здесь пусто</div>
                <div class="order-empty__subtitle">У вас нет оформленных заказов.</div>
                <div class="order-empty__description">
                    Чтобы оформить заказ воспользуйтесь каталогом продукции для добавления товаров в корзину. После добавления товаров в корзину оформите заказ.
                </div>
                <div class="order-empty__action">
                    <a href="<?= htmlspecialcharsbx($arParams['PATH_TO_CATALOG']) ?>" class="btn">Перейти в каталог</a>
                </div>
            </div>
		<?} ?>

		<?php
		//if ($_REQUEST["show_canceled"] === 'Y' && count($arResult['ORDERS']))
		$paymentChangeData = array();
		$orderHeaderStatus = null;

		foreach ($arResult['ORDERS'] as $key => $order): ?>
            <div class="order-item">
                <div class="order-item__head">
                    <div class="order-item__number">Заказ <?= Loc::getMessage('SPOL_TPL_NUMBER_SIGN') . $order['ORDER']['ACCOUNT_NUMBER'] ?></div>
                    <? if ($order["ORDER"]["CAN_CANCEL"] === "Y" && $order["ORDER"]['PAY_SYSTEM_ID'] == 2 && $order["ORDER"]['PAYED'] == 'N'):?>
                        <div class="order-item__pay">
                            <a href="<?= htmlspecialcharsbx('/sale/?ORDER_ID=').$order["ORDER"]["ID"] ?>" class="btn">Оплатить заказ</a>
                        </div>
                    <?endif; ?>
                    <a href="<?= htmlspecialcharsbx($order["ORDER"]["URL_TO_COPY"]) ?>" class="order-item__repeat">
                        <span><?= Loc::getMessage('SPOL_TPL_REPEAT_ORDER') ?></span>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.28195 10.7189C4.21228 10.649 4.12952 10.5936 4.0384 10.5558C3.94728 10.518 3.8496 10.4985 3.75095 10.4985C3.6523 10.4985 3.55461 10.518 3.4635 10.5558C3.37238 10.5936 3.28962 10.649 3.21995 10.7189L0.219947 13.7189C0.0791174 13.8597 0 14.0507 0 14.2499C0 14.449 0.0791174 14.64 0.219947 14.7809C0.360777 14.9217 0.551784 15.0008 0.750947 15.0008C0.950111 15.0008 1.14112 14.9217 1.28195 14.7809L3.75095 12.3104L6.21995 14.7809C6.36078 14.9217 6.55178 15.0008 6.75095 15.0008C6.95011 15.0008 7.14112 14.9217 7.28195 14.7809C7.42278 14.64 7.5019 14.449 7.5019 14.2499C7.5019 14.0507 7.42278 13.8597 7.28195 13.7189L4.28195 10.7189ZM23.7819 9.21888C23.7123 9.14903 23.6295 9.09362 23.5384 9.05581C23.4473 9.018 23.3496 8.99854 23.2509 8.99854C23.1523 8.99854 23.0546 9.018 22.9635 9.05581C22.8724 9.09362 22.7896 9.14903 22.7199 9.21888L20.2509 11.6894L17.7819 9.21888C17.6411 9.07805 17.4501 8.99893 17.2509 8.99893C17.0518 8.99893 16.8608 9.07805 16.7199 9.21888C16.5791 9.35971 16.5 9.55071 16.5 9.74988C16.5 9.94904 16.5791 10.14 16.7199 10.2809L19.7199 13.2809C19.7896 13.3507 19.8724 13.4061 19.9635 13.4439C20.0546 13.4818 20.1523 13.5012 20.2509 13.5012C20.3496 13.5012 20.4473 13.4818 20.5384 13.4439C20.6295 13.4061 20.7123 13.3507 20.7819 13.2809L23.7819 10.2809C23.8518 10.2112 23.9072 10.1284 23.945 10.0373C23.9828 9.94621 24.0023 9.84853 24.0023 9.74988C24.0023 9.65122 23.9828 9.55354 23.945 9.46242C23.9072 9.37131 23.8518 9.28854 23.7819 9.21888Z" fill="currentColor"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 4.4998C10.7507 4.49884 9.52107 4.81026 8.42287 5.40574C7.32466 6.00121 6.39278 6.86183 5.712 7.9093C5.60007 8.068 5.43094 8.17709 5.2402 8.21363C5.04947 8.25016 4.852 8.21129 4.68934 8.10518C4.52668 7.99908 4.41153 7.83401 4.3681 7.64473C4.32467 7.45544 4.35636 7.25669 4.4565 7.0903C5.51474 5.46405 7.07018 4.22333 8.89098 3.55308C10.7118 2.88283 12.7004 2.81894 14.5605 3.37094C16.4206 3.92294 18.0524 5.06126 19.2129 6.61623C20.3733 8.1712 21.0002 10.0596 21 11.9998C21 12.1989 20.9209 12.3899 20.7801 12.5307C20.6393 12.6714 20.4484 12.7505 20.2493 12.7505C20.0501 12.7505 19.8592 12.6714 19.7184 12.5307C19.5776 12.3899 19.4985 12.1989 19.4985 11.9998C19.4985 10.0107 18.7083 8.10302 17.3018 6.6965C15.8953 5.28997 13.9876 4.4998 11.9985 4.4998H12ZM3.75 11.2498C3.94891 11.2498 4.13968 11.3288 4.28033 11.4695C4.42098 11.6101 4.5 11.8009 4.5 11.9998C4.49944 13.6171 5.0217 15.1913 5.98888 16.4875C6.95606 17.7838 8.31634 18.7326 9.86686 19.1926C11.4174 19.6526 13.075 19.5991 14.5927 19.04C16.1103 18.4809 17.4065 17.4462 18.288 16.0903C18.34 16.0039 18.4088 15.929 18.4904 15.8698C18.572 15.8106 18.6647 15.7685 18.7629 15.746C18.8611 15.7235 18.9629 15.721 19.0621 15.7386C19.1613 15.7563 19.256 15.7938 19.3404 15.8489C19.4248 15.9039 19.4972 15.9754 19.5534 16.0591C19.6095 16.1428 19.6483 16.2369 19.6672 16.3359C19.6862 16.4349 19.685 16.5367 19.6637 16.6352C19.6425 16.7337 19.6016 16.8269 19.5435 16.9093C18.4853 18.5355 16.9298 19.7763 15.109 20.4465C13.2882 21.1168 11.2996 21.1807 9.4395 20.6287C7.57944 20.0767 5.94756 18.9383 4.78712 17.3834C3.62669 15.8284 2.99983 13.94 3 11.9998C3 11.9012 3.01945 11.8035 3.05723 11.7124C3.09502 11.6213 3.1504 11.5386 3.2202 11.4689C3.29 11.3993 3.37286 11.3441 3.46403 11.3065C3.55519 11.2689 3.65288 11.2496 3.7515 11.2498H3.75Z" fill="currentColor"/>
                        </svg>
                    </a>
                    <? if ($order["ORDER"]["CAN_CANCEL"] === "Y"):?>
                        <div class="order-item__cancel">
                            <a href="<?= htmlspecialcharsbx($order["ORDER"]["URL_TO_CANCEL"]) ?>">
                                <span>Отменить заказ</span>
                                <svg class="order-tip-toggler" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8 15C6.14348 15 4.36301 14.2625 3.05025 12.9497C1.7375 11.637 1 9.85652 1 8C1 6.14348 1.7375 4.36301 3.05025 3.05025C4.36301 1.7375 6.14348 1 8 1C9.85652 1 11.637 1.7375 12.9497 3.05025C14.2625 4.36301 15 6.14348 15 8C15 9.85652 14.2625 11.637 12.9497 12.9497C11.637 14.2625 9.85652 15 8 15ZM8 16C10.1217 16 12.1566 15.1571 13.6569 13.6569C15.1571 12.1566 16 10.1217 16 8C16 5.87827 15.1571 3.84344 13.6569 2.34315C12.1566 0.842855 10.1217 0 8 0C5.87827 0 3.84344 0.842855 2.34315 2.34315C0.842855 3.84344 0 5.87827 0 8C0 10.1217 0.842855 12.1566 2.34315 13.6569C3.84344 15.1571 5.87827 16 8 16Z" fill="currentColor"/>
                                    <path d="M5.25412 5.786C5.25275 5.81829 5.258 5.85053 5.26955 5.88072C5.2811 5.91091 5.2987 5.93841 5.32127 5.96155C5.34385 5.98468 5.37091 6.00296 5.40081 6.01524C5.43071 6.02753 5.4628 6.03357 5.49512 6.033H6.32012C6.45812 6.033 6.56812 5.92 6.58612 5.783C6.67612 5.127 7.12612 4.649 7.92812 4.649C8.61412 4.649 9.24212 4.992 9.24212 5.817C9.24212 6.452 8.86812 6.744 8.27712 7.188C7.60412 7.677 7.07112 8.248 7.10912 9.175L7.11212 9.392C7.11317 9.45761 7.13997 9.52017 7.18674 9.5662C7.23351 9.61222 7.2965 9.63801 7.36212 9.638H8.17312C8.23942 9.638 8.30301 9.61166 8.3499 9.56478C8.39678 9.51789 8.42312 9.4543 8.42312 9.388V9.283C8.42312 8.565 8.69612 8.356 9.43312 7.797C10.0421 7.334 10.6771 6.82 10.6771 5.741C10.6771 4.23 9.40112 3.5 8.00412 3.5C6.73712 3.5 5.34912 4.09 5.25412 5.786ZM6.81112 11.549C6.81112 12.082 7.23612 12.476 7.82112 12.476C8.43012 12.476 8.84912 12.082 8.84912 11.549C8.84912 10.997 8.42912 10.609 7.82012 10.609C7.23612 10.609 6.81112 10.997 6.81112 11.549Z" fill="currentColor"/>
                                </svg>
                            </a>
                            <div class="order-cancel__tip">
                                <div class="close">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M17.7819 6.21888C17.8518 6.28854 17.9072 6.37131 17.945 6.46243C17.9828 6.55354 18.0023 6.65122 18.0023 6.74988C18.0023 6.84853 17.9828 6.94621 17.945 7.03733C17.9072 7.12844 17.8518 7.21121 17.7819 7.28088L7.28195 17.7809C7.14112 17.9217 6.95011 18.0008 6.75095 18.0008C6.55178 18.0008 6.36078 17.9217 6.21995 17.7809C6.07912 17.64 6 17.449 6 17.2499C6 17.0507 6.07912 16.8597 6.21995 16.7189L16.7199 6.21888C16.7896 6.14903 16.8724 6.09362 16.9635 6.05581C17.0546 6.018 17.1523 5.99854 17.2509 5.99854C17.3496 5.99854 17.4473 6.018 17.5384 6.05581C17.6295 6.09362 17.7123 6.14903 17.7819 6.21888Z" fill="currentColor"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6.22034 6.21888C6.1505 6.28854 6.09508 6.37131 6.05727 6.46243C6.01946 6.55354 6 6.65122 6 6.74988C6 6.84853 6.01946 6.94621 6.05727 7.03733C6.09508 7.12844 6.1505 7.21121 6.22034 7.28088L16.7203 17.7809C16.8612 17.9217 17.0522 18.0008 17.2513 18.0008C17.4505 18.0008 17.6415 17.9217 17.7823 17.7809C17.9232 17.64 18.0023 17.449 18.0023 17.2499C18.0023 17.0507 17.9232 16.8597 17.7823 16.7189L7.28234 6.21888C7.21267 6.14903 7.12991 6.09362 7.03879 6.05581C6.94767 6.018 6.84999 5.99854 6.75134 5.99854C6.65269 5.99854 6.55501 6.018 6.46389 6.05581C6.37277 6.09362 6.29001 6.14903 6.22034 6.21888Z" fill="currentColor"/>
                                    </svg>
                                </div>
                                <div class="title">Отменить заказ</div>
                                <div class="description">Заказ возможно отменить до статуса «Принят». Если у вас остались вопросы - напишите в службу поддержки на электронную почту: <a href="mailto:no-reply@firolife.ru">no-reply@firolife.ru</a> или свяжитесь с оператором интернет-магазина<br> по телефону: <a href="tel:88003014406">8 800 301-44-06</a></div>
                            </div>
                        </div>
                    <?endif; ?>
                </div>
                <?php
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
                <div class="order-item__details">
                    <div class="order-item__detail">
                        <span>Дата оформления заказа</span>
                        <?= $order['ORDER']['DATE_INSERT_FORMATED'] ?>
                    </div>
                    <div class="order-item__detail">
                        <span>Статус оплаты и сумма</span>
                        <?= $payStatus ?><br>
                        Сумма <?= $order["ORDER"]["FORMATED_PRICE"] ?>
                    </div>
                    <div class="order-item__detail">
                        <span>Доставка</span>
                        <?= $arResult['DELIVERY_NAME'][$order["ORDER"]["DELIVERY_ID"]]['NAME'] ?>
                    </div>
                    <div class="order-item__detail">
                        <?
                        //pre(CDeliverySDEK::$date);
                        ?>
                        <span>Дата и адрес доставки</span>
                        <!--Дата получения 01-03/09/2021<br>-->
                        <?if($order["ORDER"]['DELIVERY_ID'] == 15 && $order['PROPS']['STORE']['VALUE']):?>
                            <?=$arResult['ALL_STORE'][$order['PROPS']['STORE']['VALUE']]['ADDRESS'];?>
                        <?endif;?>
                        <?if($order["PROPS"]["ADDRESS"]['VALUE']):?>
                            Адрес: <?= $order["PROPS"]["ADDRESS"]['VALUE'] ?>
                        <?endif;?>
                        <?//=$order["PROPS"]["ADDRESS_PVZ"]['VALUE']?>
                    </div>
                    <div class="order-item__detail order-item__detail--status">
                        <span>Статус заказа</span>
                        <?= $arResult["STATUS_INFO"][$order["ORDER"]["STATUS_ID"]]['NAME'] ?>
                    </div>
                </div>
                <div class="order-item__count"><?= count($order["BASKET_ITEMS"]) ?> <?=endingsForm(count($order["BASKET_ITEMS"]),'товар','товара','товаров');?></div>
                <div class="order-item__products-previews-cont">
                    <div class="order-item__products-previews">
                        <? foreach ($order["BASKET_ITEMS"] as $basketItem):?>
                            <?if($arResult['PHOTOS'][$basketItem['PRODUCT_ID']]):?>
                                <a href="<?=$basketItem['DETAIL_PAGE_URL']?>"><img src="<?=$arResult['PHOTOS'][$basketItem['PRODUCT_ID']]?>" alt="<?=$basketItem['NAME']?>"></a>
                            <?elseif($arResult['PHOTOS'][$arResult['CATALOG_IDS'][$basketItem['PRODUCT_ID']]]):?>
                                <a href="<?=$basketItem['DETAIL_PAGE_URL']?>"><img src="<?=$arResult['PHOTOS'][$arResult['CATALOG_IDS'][$basketItem['PRODUCT_ID']]]?>" alt="<?=$basketItem['NAME']?>"></a>
                            <?endif;?>
                        <?endforeach; ?>
                    </div>
                </div>
                <div class="order-item__products">
                    <? foreach ($order["BASKET_ITEMS"] as $basketItem):?>
                        <div class="order-product">
                            <?if($arResult['PHOTOS'][$basketItem['PRODUCT_ID']]):?>
                                <a href="<?=$basketItem['DETAIL_PAGE_URL']?>" class="order-product__thumb">
                                    <img src="<?=$arResult['PHOTOS'][$basketItem['PRODUCT_ID']]?>" alt="<?=$basketItem['NAME']?>">
                                </a>
                            <?elseif($arResult['PHOTOS'][$arResult['CATALOG_IDS'][$basketItem['PRODUCT_ID']]]):?>
                                <a href="<?=$basketItem['DETAIL_PAGE_URL']?>" class="order-product__thumb">
                                    <img src="<?=$arResult['PHOTOS'][$arResult['CATALOG_IDS'][$basketItem['PRODUCT_ID']]]?>" alt="<?=$basketItem['NAME']?>">
                                </a>
                            <?endif;?>
                            <div class="order-product__content">
                                <a href="<?=$basketItem['DETAIL_PAGE_URL']?>" class="order-product__title"><?= $basketItem['NAME'] ?></a>
                                <?if($arResult['COLORS'][$basketItem['PRODUCT_ID']] || $arResult['SIZES'][$basketItem['PRODUCT_ID']]):?>
                                    <ul class="order-product__options">
                                        <?if($arResult['COLORS'][$basketItem['PRODUCT_ID']]):?>
                                            <li><?=$arResult['COLORS'][$basketItem['PRODUCT_ID']]?></li>
                                        <?endif;?>
                                        <?if($arResult['SIZES'][$basketItem['PRODUCT_ID']]):?>
                                            <li><?=$arResult['SIZES'][$basketItem['PRODUCT_ID']]?></li>
                                        <?endif;?>
                                    </ul>
                                <?endif;?>
                            </div>
                            <div class="order-product__qty"><?= $basketItem['QUANTITY'] ?> шт</div>
                            <div class="order-product__price"><?= number_format($basketItem['PRICE'], 0, '', ' ');?> ₽</div>
                        </div>
                    <?endforeach;?>
                </div>
                <div class="order-products__toggle">
                    <span>Подробнее о товарах</span>
                    <span>Скрыть детали</span>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4699 6.96888C11.5396 6.89903 11.6224 6.84362 11.7135 6.80581C11.8046 6.768 11.9023 6.74854 12.0009 6.74854C12.0996 6.74854 12.1973 6.768 12.2884 6.80581C12.3795 6.84362 12.4623 6.89903 12.5319 6.96888L21.5319 15.9689C21.6728 16.1097 21.7519 16.3007 21.7519 16.4999C21.7519 16.699 21.6728 16.89 21.5319 17.0309C21.3911 17.1717 21.2001 17.2508 21.0009 17.2508C20.8018 17.2508 20.6108 17.1717 20.4699 17.0309L12.0009 8.56038L3.53195 17.0309C3.39112 17.1717 3.20011 17.2508 3.00095 17.2508C2.80178 17.2508 2.61078 17.1717 2.46995 17.0309C2.32912 16.89 2.25 16.699 2.25 16.4999C2.25 16.3007 2.32912 16.1097 2.46995 15.9689L11.4699 6.96888Z" fill="currentColor"/>
                    </svg>
                </div>
            </div>
		<?endforeach;
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