<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main;
use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 * @var array $arResult
 * @var CMain $APPLICATION
 * @var CUser $USER
 * @var SaleOrderAjax $component
 * @var string $templateFolder
 */

$context = Main\Application::getInstance()->getContext();
$request = $context->getRequest();

if (empty($arParams['TEMPLATE_THEME']))
{
	$arParams['TEMPLATE_THEME'] = Main\ModuleManager::isModuleInstalled('bitrix.eshop') ? 'site' : 'blue';
}

if ($arParams['TEMPLATE_THEME'] === 'site')
{
	$templateId = Main\Config\Option::get('main', 'wizard_template_id', 'eshop_bootstrap', $component->getSiteId());
	$templateId = preg_match('/^eshop_adapt/', $templateId) ? 'eshop_adapt' : $templateId;
	$arParams['TEMPLATE_THEME'] = Main\Config\Option::get('main', 'wizard_'.$templateId.'_theme_id', 'blue', $component->getSiteId());
}

if (!empty($arParams['TEMPLATE_THEME']))
{
	if (!is_file(Main\Application::getDocumentRoot().'/bitrix/css/main/themes/'.$arParams['TEMPLATE_THEME'].'/style.css'))
	{
		$arParams['TEMPLATE_THEME'] = 'blue';
	}
}

$arParams['ALLOW_USER_PROFILES'] = $arParams['ALLOW_USER_PROFILES'] === 'Y' ? 'Y' : 'N';
$arParams['SKIP_USELESS_BLOCK'] = $arParams['SKIP_USELESS_BLOCK'] === 'N' ? 'N' : 'Y';

if (!isset($arParams['SHOW_ORDER_BUTTON']))
{
	$arParams['SHOW_ORDER_BUTTON'] = 'final_step';
}

$arParams['HIDE_ORDER_DESCRIPTION'] = isset($arParams['HIDE_ORDER_DESCRIPTION']) && $arParams['HIDE_ORDER_DESCRIPTION'] === 'Y' ? 'Y' : 'N';
$arParams['SHOW_TOTAL_ORDER_BUTTON'] = $arParams['SHOW_TOTAL_ORDER_BUTTON'] === 'Y' ? 'Y' : 'N';
$arParams['SHOW_PAY_SYSTEM_LIST_NAMES'] = $arParams['SHOW_PAY_SYSTEM_LIST_NAMES'] === 'N' ? 'N' : 'Y';
$arParams['SHOW_PAY_SYSTEM_INFO_NAME'] = $arParams['SHOW_PAY_SYSTEM_INFO_NAME'] === 'N' ? 'N' : 'Y';
$arParams['SHOW_DELIVERY_LIST_NAMES'] = $arParams['SHOW_DELIVERY_LIST_NAMES'] === 'N' ? 'N' : 'Y';
$arParams['SHOW_DELIVERY_INFO_NAME'] = $arParams['SHOW_DELIVERY_INFO_NAME'] === 'N' ? 'N' : 'Y';
$arParams['SHOW_DELIVERY_PARENT_NAMES'] = $arParams['SHOW_DELIVERY_PARENT_NAMES'] === 'N' ? 'N' : 'Y';
$arParams['SHOW_STORES_IMAGES'] = $arParams['SHOW_STORES_IMAGES'] === 'N' ? 'N' : 'Y';

if (!isset($arParams['BASKET_POSITION']) || !in_array($arParams['BASKET_POSITION'], array('before', 'after')))
{
	$arParams['BASKET_POSITION'] = 'after';
}

$arParams['EMPTY_BASKET_HINT_PATH'] = isset($arParams['EMPTY_BASKET_HINT_PATH']) ? (string)$arParams['EMPTY_BASKET_HINT_PATH'] : '/';
$arParams['SHOW_BASKET_HEADERS'] = $arParams['SHOW_BASKET_HEADERS'] === 'Y' ? 'Y' : 'N';
$arParams['HIDE_DETAIL_PAGE_URL'] = isset($arParams['HIDE_DETAIL_PAGE_URL']) && $arParams['HIDE_DETAIL_PAGE_URL'] === 'Y' ? 'Y' : 'N';
$arParams['DELIVERY_FADE_EXTRA_SERVICES'] = $arParams['DELIVERY_FADE_EXTRA_SERVICES'] === 'Y' ? 'Y' : 'N';

$arParams['SHOW_COUPONS'] = isset($arParams['SHOW_COUPONS']) && $arParams['SHOW_COUPONS'] === 'N' ? 'N' : 'Y';

if ($arParams['SHOW_COUPONS'] === 'N')
{
	$arParams['SHOW_COUPONS_BASKET'] = 'N';
	$arParams['SHOW_COUPONS_DELIVERY'] = 'N';
	$arParams['SHOW_COUPONS_PAY_SYSTEM'] = 'N';
}
else
{
	$arParams['SHOW_COUPONS_BASKET'] = isset($arParams['SHOW_COUPONS_BASKET']) && $arParams['SHOW_COUPONS_BASKET'] === 'N' ? 'N' : 'Y';
	$arParams['SHOW_COUPONS_DELIVERY'] = isset($arParams['SHOW_COUPONS_DELIVERY']) && $arParams['SHOW_COUPONS_DELIVERY'] === 'N' ? 'N' : 'Y';
	$arParams['SHOW_COUPONS_PAY_SYSTEM'] = isset($arParams['SHOW_COUPONS_PAY_SYSTEM']) && $arParams['SHOW_COUPONS_PAY_SYSTEM'] === 'N' ? 'N' : 'Y';
}

$arParams['SHOW_NEAREST_PICKUP'] = $arParams['SHOW_NEAREST_PICKUP'] === 'Y' ? 'Y' : 'N';
$arParams['DELIVERIES_PER_PAGE'] = isset($arParams['DELIVERIES_PER_PAGE']) ? intval($arParams['DELIVERIES_PER_PAGE']) : 9;
$arParams['PAY_SYSTEMS_PER_PAGE'] = isset($arParams['PAY_SYSTEMS_PER_PAGE']) ? intval($arParams['PAY_SYSTEMS_PER_PAGE']) : 9;
$arParams['PICKUPS_PER_PAGE'] = isset($arParams['PICKUPS_PER_PAGE']) ? intval($arParams['PICKUPS_PER_PAGE']) : 5;
$arParams['SHOW_PICKUP_MAP'] = $arParams['SHOW_PICKUP_MAP'] === 'N' ? 'N' : 'Y';
$arParams['SHOW_MAP_IN_PROPS'] = $arParams['SHOW_MAP_IN_PROPS'] === 'Y' ? 'Y' : 'N';
$arParams['USE_YM_GOALS'] = $arParams['USE_YM_GOALS'] === 'Y' ? 'Y' : 'N';
$arParams['USE_ENHANCED_ECOMMERCE'] = isset($arParams['USE_ENHANCED_ECOMMERCE']) && $arParams['USE_ENHANCED_ECOMMERCE'] === 'Y' ? 'Y' : 'N';
$arParams['DATA_LAYER_NAME'] = isset($arParams['DATA_LAYER_NAME']) ? trim($arParams['DATA_LAYER_NAME']) : 'dataLayer';
$arParams['BRAND_PROPERTY'] = isset($arParams['BRAND_PROPERTY']) ? trim($arParams['BRAND_PROPERTY']) : '';

$useDefaultMessages = !isset($arParams['USE_CUSTOM_MAIN_MESSAGES']) || $arParams['USE_CUSTOM_MAIN_MESSAGES'] != 'Y';

if ($useDefaultMessages || !isset($arParams['MESS_AUTH_BLOCK_NAME']))
{
	$arParams['MESS_AUTH_BLOCK_NAME'] = Loc::getMessage('AUTH_BLOCK_NAME_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_REG_BLOCK_NAME']))
{
	$arParams['MESS_REG_BLOCK_NAME'] = Loc::getMessage('REG_BLOCK_NAME_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_BASKET_BLOCK_NAME']))
{
	$arParams['MESS_BASKET_BLOCK_NAME'] = Loc::getMessage('BASKET_BLOCK_NAME_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_REGION_BLOCK_NAME']))
{
	$arParams['MESS_REGION_BLOCK_NAME'] = Loc::getMessage('REGION_BLOCK_NAME_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_PAYMENT_BLOCK_NAME']))
{
	$arParams['MESS_PAYMENT_BLOCK_NAME'] = Loc::getMessage('PAYMENT_BLOCK_NAME_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_DELIVERY_BLOCK_NAME']))
{
	$arParams['MESS_DELIVERY_BLOCK_NAME'] = Loc::getMessage('DELIVERY_BLOCK_NAME_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_BUYER_BLOCK_NAME']))
{
	$arParams['MESS_BUYER_BLOCK_NAME'] = Loc::getMessage('BUYER_BLOCK_NAME_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_BACK']))
{
	$arParams['MESS_BACK'] = Loc::getMessage('BACK_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_FURTHER']))
{
	$arParams['MESS_FURTHER'] = Loc::getMessage('FURTHER_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_EDIT']))
{
	$arParams['MESS_EDIT'] = Loc::getMessage('EDIT_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_ORDER']))
{
	$arParams['MESS_ORDER'] = $arParams['~MESS_ORDER'] = Loc::getMessage('ORDER_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_PRICE']))
{
	$arParams['MESS_PRICE'] = Loc::getMessage('PRICE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_PERIOD']))
{
	$arParams['MESS_PERIOD'] = Loc::getMessage('PERIOD_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_NAV_BACK']))
{
	$arParams['MESS_NAV_BACK'] = Loc::getMessage('NAV_BACK_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_NAV_FORWARD']))
{
	$arParams['MESS_NAV_FORWARD'] = Loc::getMessage('NAV_FORWARD_DEFAULT');
}

$useDefaultMessages = !isset($arParams['USE_CUSTOM_ADDITIONAL_MESSAGES']) || $arParams['USE_CUSTOM_ADDITIONAL_MESSAGES'] != 'Y';

if ($useDefaultMessages || !isset($arParams['MESS_PRICE_FREE']))
{
	$arParams['MESS_PRICE_FREE'] = Loc::getMessage('PRICE_FREE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_ECONOMY']))
{
	$arParams['MESS_ECONOMY'] = Loc::getMessage('ECONOMY_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_REGISTRATION_REFERENCE']))
{
	$arParams['MESS_REGISTRATION_REFERENCE'] = Loc::getMessage('REGISTRATION_REFERENCE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_AUTH_REFERENCE_1']))
{
	$arParams['MESS_AUTH_REFERENCE_1'] = Loc::getMessage('AUTH_REFERENCE_1_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_AUTH_REFERENCE_2']))
{
	$arParams['MESS_AUTH_REFERENCE_2'] = Loc::getMessage('AUTH_REFERENCE_2_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_AUTH_REFERENCE_3']))
{
	$arParams['MESS_AUTH_REFERENCE_3'] = Loc::getMessage('AUTH_REFERENCE_3_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_ADDITIONAL_PROPS']))
{
	$arParams['MESS_ADDITIONAL_PROPS'] = Loc::getMessage('ADDITIONAL_PROPS_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_USE_COUPON']))
{
	$arParams['MESS_USE_COUPON'] = Loc::getMessage('USE_COUPON_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_COUPON']))
{
	$arParams['MESS_COUPON'] = Loc::getMessage('COUPON_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_PERSON_TYPE']))
{
	$arParams['MESS_PERSON_TYPE'] = Loc::getMessage('PERSON_TYPE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_SELECT_PROFILE']))
{
	$arParams['MESS_SELECT_PROFILE'] = Loc::getMessage('SELECT_PROFILE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_REGION_REFERENCE']))
{
	$arParams['MESS_REGION_REFERENCE'] = Loc::getMessage('REGION_REFERENCE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_PICKUP_LIST']))
{
	$arParams['MESS_PICKUP_LIST'] = Loc::getMessage('PICKUP_LIST_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_NEAREST_PICKUP_LIST']))
{
	$arParams['MESS_NEAREST_PICKUP_LIST'] = Loc::getMessage('NEAREST_PICKUP_LIST_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_SELECT_PICKUP']))
{
	$arParams['MESS_SELECT_PICKUP'] = Loc::getMessage('SELECT_PICKUP_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_INNER_PS_BALANCE']))
{
	$arParams['MESS_INNER_PS_BALANCE'] = Loc::getMessage('INNER_PS_BALANCE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_ORDER_DESC']))
{
	$arParams['MESS_ORDER_DESC'] = Loc::getMessage('ORDER_DESC_DEFAULT');
}

$useDefaultMessages = !isset($arParams['USE_CUSTOM_ERROR_MESSAGES']) || $arParams['USE_CUSTOM_ERROR_MESSAGES'] != 'Y';

if ($useDefaultMessages || !isset($arParams['MESS_PRELOAD_ORDER_TITLE']))
{
	$arParams['MESS_PRELOAD_ORDER_TITLE'] = Loc::getMessage('PRELOAD_ORDER_TITLE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_SUCCESS_PRELOAD_TEXT']))
{
	$arParams['MESS_SUCCESS_PRELOAD_TEXT'] = Loc::getMessage('SUCCESS_PRELOAD_TEXT_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_FAIL_PRELOAD_TEXT']))
{
	$arParams['MESS_FAIL_PRELOAD_TEXT'] = Loc::getMessage('FAIL_PRELOAD_TEXT_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_DELIVERY_CALC_ERROR_TITLE']))
{
	$arParams['MESS_DELIVERY_CALC_ERROR_TITLE'] = Loc::getMessage('DELIVERY_CALC_ERROR_TITLE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_DELIVERY_CALC_ERROR_TEXT']))
{
	$arParams['MESS_DELIVERY_CALC_ERROR_TEXT'] = Loc::getMessage('DELIVERY_CALC_ERROR_TEXT_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_PAY_SYSTEM_PAYABLE_ERROR']))
{
	$arParams['MESS_PAY_SYSTEM_PAYABLE_ERROR'] = Loc::getMessage('PAY_SYSTEM_PAYABLE_ERROR_DEFAULT');
}

$scheme = $request->isHttps() ? 'https' : 'http';

switch (LANGUAGE_ID)
{
	case 'ru':
		$locale = 'ru-RU'; break;
	case 'ua':
		$locale = 'ru-UA'; break;
	case 'tk':
		$locale = 'tr-TR'; break;
	default:
		$locale = 'en-US'; break;
}

$this->addExternalCss('/bitrix/css/main/bootstrap.css');
$APPLICATION->SetAdditionalCSS('/bitrix/css/main/themes/'.$arParams['TEMPLATE_THEME'].'/style.css', true);
$APPLICATION->SetAdditionalCSS($templateFolder.'/style.css', true);
$this->addExternalJs($templateFolder.'/order_ajax.js');
\Bitrix\Sale\PropertyValueCollection::initJs();
$this->addExternalJs($templateFolder.'/script.js');
?>
	<NOSCRIPT>
		<div style="color:red"><?=Loc::getMessage('SOA_NO_JS')?></div>
	</NOSCRIPT>
<?

if ($request->get('ORDER_ID') <> '')
{
	include(Main\Application::getDocumentRoot().$templateFolder.'/confirm.php');
}
elseif ($arParams['DISABLE_BASKET_REDIRECT'] === 'Y' && $arResult['SHOW_EMPTY_BASKET'])
{
	include(Main\Application::getDocumentRoot().$templateFolder.'/empty.php');
}
else
{
	Main\UI\Extension::load('phone_auth');

	$hideDelivery = empty($arResult['DELIVERY']);
	?>
	<form action="<?=POST_FORM_ACTION_URI?>" method="POST" name="ORDER_FORM" id="bx-soa-order-form" enctype="multipart/form-data">
		<?
		echo bitrix_sessid_post();
		if ($arResult['PREPAY_ADIT_FIELDS'] <> ''){
			echo $arResult['PREPAY_ADIT_FIELDS'];
		}

        $rsUsers = CUser::GetList(($by="personal_country"), ($order="desc"), Array("ID" => $USER->GetId()));
        while($arUser = $rsUsers->Fetch()){
            if($arUser['PERSONAL_PHONE']){
                $phone = $arUser['PERSONAL_PHONE'];
            }elseif($arUser['PERSONAL_MOBILE']){
                $phone = $arUser['PERSONAL_MOBILE'];
            }
        }
		?>
		<input type="hidden" name="<?=$arParams['ACTION_VARIABLE']?>" value="saveOrderAjax">
		<input type="hidden" name="location_type" value="code">
		<input type="hidden" name="BUYER_STORE" id="BUYER_STORE" value="<?=$arResult['BUYER_STORE']?>">
		<div id="bx-soa-order" class="!row bx-<?=$arParams['TEMPLATE_THEME']?>" style="opacity: 0">
            <div class="cart section">
                <div class="cart-body cart__blocks order__blocks<?if($un_authorized):?> unauth<?endif;?>">

                    <div class="order__section">
                        <div class="order__section-head">
                            <div class="order__section-num"><span>1</span></div>
                            <div class="order__section-title">Контактные данные</div>
                        </div>
                        <div class="order__section-desc">
                            Введите ваш номер телефона, чтобы мы могли сообщить вам о статусе заказа
                        </div>
                        <div class="order__section-body">
                            <div class="order__phone-auth">
                                <?global $USER;
                                if(!$USER->IsAuthorized()):?>
                                    <input type="text" class="js-phone-masked2 order__phone-input" placeholder="Телефон">
                                    <a href="#modal-enter" class="modal-open-btn order__phone-btn disabled">Выслать код подтверждения</a>
                                <?else:?>
                                    <input type="text" class="js-phone-masked2 order__phone-input" value="<?=$phone?>" placeholder="Телефон">
                                    <a href="<?= $APPLICATION->GetCurPageParam("logout=yes", array("login", "logout", "register", "forgot_password", "change_password"));?>"
                                       class="order__phone-btn2">
                                        Сменить пользователя
                                    </a>
                                <?endif;?>
                            </div>
                            <?global $USER;
                            if(!$USER->IsAuthorized()):?>
                                <div class="order__phone-link">
                                    <a href="#modal-enter" class="modal-open-btn">Или авторизуйтесь</a>
                                </div>
                            <?else:?>
                                <div class="order__phone-info">Вы авторизованы</div>
                            <?endif;?>
                        </div>
                    </div>
                    <!--	MAIN BLOCK	-->
                    <div class="bx-soa">
                        <div id="bx-soa-main-notifications">
                            <div class="alert alert-danger" style="display:none"></div>
                            <div data-type="informer" style="display:none"></div>
                        </div>
                        <!--	AUTH BLOCK	-->
                        <div id="bx-soa-auth" class="bx-soa-section bx-soa-auth" style="display:none">
                            <div class="bx-soa-section-title-container">
                                <h2 class="bx-soa-section-title col-sm-9">
                                    <span class="bx-soa-section-title-count"></span><?=$arParams['MESS_AUTH_BLOCK_NAME']?>
                                </h2>
                            </div>
                            <div class="bx-soa-section-content container-fluid"></div>
                        </div>

                        <!--	DUPLICATE MOBILE ORDER SAVE BLOCK	-->
                        <div id="bx-soa-total-mobile" style="margin-bottom: 6px;"></div>

                        <?/* if ($arParams['BASKET_POSITION'] === 'before'): ?>
                            <!--	BASKET ITEMS BLOCK	-->
                            <div id="bx-soa-basket" data-visited="false" class="bx-soa-section bx-active">
                                <div class="bx-soa-section-title-container">
                                    <h2 class="bx-soa-section-title col-sm-9">
                                        <span class="bx-soa-section-title-count"></span><?=$arParams['MESS_BASKET_BLOCK_NAME']?>
                                    </h2>
                                    <div class="col-xs-12 col-sm-3 text-right"><a href="javascript:void(0)" class="bx-soa-editstep"><?=$arParams['MESS_EDIT']?></a></div>
                                </div>
                                <div class="bx-soa-section-content container-fluid"></div>
                            </div>
                        <? endif */?>

                        <!--	REGION BLOCK	-->
                        <div id="bx-soa-region" data-visited="false" class="bx-soa-section bx-active">
                            <div class="bx-soa-section-title-container">
                                <h2 class="bx-soa-section-title col-sm-9">
                                    <span class="bx-soa-section-title-count"></span><?=$arParams['MESS_REGION_BLOCK_NAME']?>
                                </h2>
                                <div class="col-xs-12 col-sm-3 text-right"><a href="" class="bx-soa-editstep"><?=$arParams['MESS_EDIT']?></a></div>
                            </div>
                            <div class="bx-soa-section-content container-fluid"></div>
                        </div>

                        <!--	DELIVERY BLOCK	-->
                        <div class="order__section">
                            <div class="order__section-head">
                                <div class="order__section-num"><span>2</span></div>
                                <div class="order__section-title">Доставка</div>
                            </div>
                            <div class="order__section-desc">
                                Выберите, каким способом, хотите получить товар
                            </div>
                            <div id="bx-soa-delivery" data-visited="false" class="bx-soa-section bx-active" <?=($hideDelivery ? 'style="display:none"' : '')?>>
                                <div class="bx-soa-section-title-container">
                                    <h2 class="bx-soa-section-title col-sm-9">
                                        <span class="bx-soa-section-title-count"></span><?=$arParams['MESS_DELIVERY_BLOCK_NAME']?>
                                    </h2>
                                    <div class="col-xs-12 col-sm-3 text-right"><a href="" class="bx-soa-editstep"><?=$arParams['MESS_EDIT']?></a></div>
                                </div>
                                <div class="bx-soa-section-content"></div>
                            </div>
                        </div>
                        <!--	PICKUP BLOCK	-->
                        <div id="bx-soa-pickup" data-visited="false" class="bx-soa-section" style="display:none">
                            <div class="bx-soa-section-title-container">
                                <h2 class="bx-soa-section-title col-sm-9">
                                    <span class="bx-soa-section-title-count"></span>
                                </h2>
                                <div class="col-xs-12 col-sm-3 text-right"><a href="" class="bx-soa-editstep"><?=$arParams['MESS_EDIT']?></a></div>
                            </div>
                            <div class="bx-soa-section-content container-fluid"></div>
                        </div>
                        <!--	BUYER PROPS BLOCK	-->
                        <div class="order__section">
                            <div class="order__section-head">
                                <div class="order__section-num"><span>3</span></div>
                                <div class="order__section-title">Комментарий к заказу</div>
                            </div>
                            <div id="bx-soa-properties" data-visited="false" class="bx-soa-section bx-active">
                                <div class="bx-soa-section-title-container">
                                    <h2 class="bx-soa-section-title col-sm-9">
                                        <span class="bx-soa-section-title-count"></span><?=$arParams['MESS_BUYER_BLOCK_NAME']?>
                                    </h2>
                                    <div class="col-xs-12 col-sm-3 text-right"><a href="" class="bx-soa-editstep"><?=$arParams['MESS_EDIT']?></a></div>
                                </div>
                                <div class="bx-soa-section-content"></div>
                            </div>
                        </div>

                        <!--	PAY SYSTEMS BLOCK	-->
                        <div class="order__section">
                            <div class="order__section-head">
                                <div class="order__section-num"><span>4</span></div>
                                <div class="order__section-title">Оплата</div>
                            </div>
                            <div class="order__section-desc">
                                Поставка товаров по России осуществляется только после 100% оплаты заказа
                            </div>
                            <div id="bx-soa-paysystem" data-visited="false" class="bx-soa-section bx-active">
                                <div class="bx-soa-section-title-container">
                                    <h2 class="bx-soa-section-title col-sm-9">
                                        <span class="bx-soa-section-title-count"></span><?=$arParams['MESS_PAYMENT_BLOCK_NAME']?>
                                    </h2>
                                    <div class="col-xs-12 col-sm-3 text-right"><a href="" class="bx-soa-editstep"><?=$arParams['MESS_EDIT']?></a></div>
                                </div>
                                <div class="bx-soa-section-content"></div>
                            </div>
                        </div>
                        <? if ($arParams['BASKET_POSITION'] === 'after'): ?>
                            <div style="display: none;">
                                <!--	BASKET ITEMS BLOCK	-->
                                <div id="bx-soa-basket" data-visited="false" class="bx-soa-section bx-active">
                                    <div class="bx-soa-section-title-container">
                                        <h2 class="bx-soa-section-title col-sm-9">
                                            <span class="bx-soa-section-title-count"></span><?=$arParams['MESS_BASKET_BLOCK_NAME']?>
                                        </h2>
                                        <div class="col-xs-12 col-sm-3 text-right"><a href="javascript:void(0)" class="bx-soa-editstep"><?=$arParams['MESS_EDIT']?></a></div>
                                    </div>
                                    <div class="bx-soa-section-content"></div>
                                </div>
                            </div>

                            <div class="order-page__products order-item">
                                <div class="order-item__count">
                                    <span><?= count($arResult["BASKET_ITEMS"]) ?> <?=endingsForm(count($arResult["BASKET_ITEMS"]),'товар','товара','товаров');?></span>
                                    <a href="/cart/" class="order-item__count-link">Изменить</a>
                                </div>
                                <div class="order-item__products-previews-cont">
                                    <div class="order-item__products-previews">
                                        <? foreach ($arResult["BASKET_ITEMS"] as $basketItem):?>
                                            <?if($basketItem['PREVIEW_PICTURE_SRC']):?>
                                                <a href="<?=$basketItem['DETAIL_PAGE_URL']?>">
                                                    <img src="<?=$basketItem['PREVIEW_PICTURE_SRC']?>" alt="<?=$basketItem['NAME']?>">
                                                </a>
                                            <?else:?>
                                                <div class="order-page__nophoto"></div>
                                            <?endif;?>
                                        <?endforeach; ?>
                                    </div>
                                </div>
                                <div class="order-item__products">
                                    <? foreach ($arResult["BASKET_ITEMS"] as $basketItem):?>
                                        <div class="order-product">
                                            <?if($basketItem['PREVIEW_PICTURE_SRC']):?>
                                                <a href="<?=$basketItem['DETAIL_PAGE_URL']?>" class="order-product__thumb">
                                                    <img src="<?=$basketItem['PREVIEW_PICTURE_SRC']?>" alt="<?=$basketItem['NAME']?>">
                                                </a>
                                            <?else:?>
                                                <div class="order-page__nophoto"></div>
                                            <?endif;?>
                                            <div class="order-product__content">
                                                <a href="<?=$basketItem['DETAIL_PAGE_URL']?>" class="order-product__title"><?= $basketItem['NAME'] ?></a>
                                                <?if($basketItem['PROPS']):?>
                                                    <ul class="order-product__options">
                                                        <?foreach($basketItem['PROPS'] as $prop):?>
                                                            <li><?=$prop['NAME']?>:<?=$prop['VALUE']?></li>
                                                        <?endforeach;?>
                                                    </ul>
                                                <?endif;?>
                                            </div>
                                            <div class="order-product__qty"><?= $basketItem['QUANTITY'];?> шт</div>
                                            <div class="order-product__price"><?= $basketItem['PRICE_FORMATED'];?></div>
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
                        <? endif ?>

                        <div style="display: none;">
                            <div id='bx-soa-basket-hidden' class="bx-soa-section"></div>
                            <div id='bx-soa-region-hidden' class="bx-soa-section"></div>
                            <div id='bx-soa-paysystem-hidden' class="bx-soa-section"></div>
                            <div id='bx-soa-delivery-hidden' class="bx-soa-section"></div>
                            <div id='bx-soa-pickup-hidden' class="bx-soa-section"></div>
                            <div id="bx-soa-properties-hidden" class="bx-soa-section"></div>
                            <div id="bx-soa-auth-hidden" class="bx-soa-section">
                                <div class="bx-soa-section-content container-fluid reg"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--	SIDEBAR BLOCK	-->
                <div id="bx-soa-total" class="bx-soa-sidebar">
                    <div class="bx-soa-cart-total-ghost"></div>
                    <div class="bx-soa-cart-total"></div>

                    <div class="cart-sidebar">
                        <div class="cart-total__group">
                            <div class="cart-total__title">Промокод</div>
                            <input type="text" class="form-control" placeholder="Промокод">
                            <a href="#" class="cart-promo-link-tip">Как получить промокод?</a>
                        </div>
                        <div class="cart-total__group">
                            <div class="cart-total__title">
                                <span>Бонусные рубли</span>
                                <div class="tip-hover">
                                    <div class="tip-hover__head"><svg class="icon"><use xlink:href="#question-circle-sm"></use></svg></div>
                                    <div class="tip-hover__body">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis, porro?</div>
                                </div>
                            </div>
                            <div class="cart-total-bonus-group">
                                <input type="text" class="form-control" placeholder="Бонусные рубли">
                                <div class="btn">Списать</div>
                            </div>
                            <div class="cart-bonuces-value">Нет бонусных рублей для скидки</div>
                        </div>
                        <div class="cart-total__group">
                            <div class="cart-bonuces-reward">
                                <div class="char">Бонусы за заказ</div>
                                <div class="val">+45<div class="icon">₽</div></div>
                            </div>
                        </div>
                        <div class="cart-total__group">
                            <div class="cart-total__title">Ваш заказ</div>
                            <div class="order-total__list">
                                <div class="order-total__item order-total__item--total">
                                    <div class="order-total__char">Сумма товаров</div>
                                    <div class="order-total__val jsAllProductSum">0</div>
                                </div>
                                <div class="order-total__item order-total__item--total">
                                    <div class="order-total__char">Стоимость доставки</div>
                                    <div class="order-total__val JsDeliveryPrice">0</div>
                                </div>
                                <div class="order-total__list--extra" style="display: block">
                                    <div class="order-total__item order-total__item--total">
                                        <div class="order-total__char">Скидки</div>
                                        <div class="order-total__val jsAllDiscount">- 0</div>
                                    </div>
                                    <div class="order-total__item">
                                        <div class="order-total__char">Скидки по товарам</div>
                                        <div class="order-total__val jsProductDiscount">- 0</div>
                                    </div>
                                    <div class="order-total__item">
                                        <div class="order-total__char">Бонусные рубли</div>
                                        <div class="order-total__val">- 77 ₽</div>
                                    </div>
                                </div>
                                <div class="toggle-order-extra open">
                                    <span>Развернуть</span>
                                    <span>Свернуть</span>
                                    <svg class="icon"><use xlink:href="#icon-chevron-down"></use></svg>
                                </div>
                            </div>
                        </div>

                        <div class="cart-sidebar-total">
                            <div class="cart-sidebar-total-title">Итого</div>
                            <div class="cart-sidebar-total-sum jsAllSum">0</div>
                        </div>

                        <div class="cart-sidebar-checkbox">
                            <label for="SEND_EMAIL">
                                <input type="checkbox" name="SEND_EMAIL">
                                <span>Прислать уведомление на E-mail</span>
                            </label>
                        </div>

                        <div class="order-finish-tip">Внимательно проверьте данные заказа</div>
                        <!--	ORDER SAVE BLOCK	-->
                        <div id="bx-soa-orderSave">
                            <?/*div class="checkbox">
                                <?
                                if ($arParams['USER_CONSENT'] === 'Y')
                                {
                                    $APPLICATION->IncludeComponent(
                                        'bitrix:main.userconsent.request',
                                        '',
                                        array(
                                            'ID' => $arParams['USER_CONSENT_ID'],
                                            'IS_CHECKED' => $arParams['USER_CONSENT_IS_CHECKED'],
                                            'IS_LOADED' => $arParams['USER_CONSENT_IS_LOADED'],
                                            'AUTO_SAVE' => 'N',
                                            'SUBMIT_EVENT_NAME' => 'bx-soa-order-save',
                                            'REPLACE' => array(
                                                'button_caption' => isset($arParams['~MESS_ORDER']) ? $arParams['~MESS_ORDER'] : $arParams['MESS_ORDER'],
                                                'fields' => $arResult['USER_CONSENT_PROPERTY_DATA']
                                            )
                                        )
                                    );
                                }
                                ?>
                            </div*/?>
                            <a href="javascript:void(0)" style="margin: 10px 0" class="btn btn-full btn-green cart-btn !hidden-xs" data-save-button="true">
                                <?=$arParams['MESS_ORDER']?>
                            </a>
                        </div>

                        <?/*a href="#" data-entity="basket-checkout-button" class="btn btn-full btn-green cart-btn">Перейти к оформлению</a*/?>
                    </div>
                </div>
            </div>
		</div>
	</form>

	<div id="bx-soa-saved-files" style="display:none"></div>
	<div id="bx-soa-soc-auth-services" style="display:none">
		<?
		$arServices = false;
		$arResult['ALLOW_SOCSERV_AUTHORIZATION'] = Main\Config\Option::get('main', 'allow_socserv_authorization', 'Y') != 'N' ? 'Y' : 'N';
		$arResult['FOR_INTRANET'] = false;

		if (Main\ModuleManager::isModuleInstalled('intranet') || Main\ModuleManager::isModuleInstalled('rest'))
			$arResult['FOR_INTRANET'] = true;

		if (Main\Loader::includeModule('socialservices') && $arResult['ALLOW_SOCSERV_AUTHORIZATION'] === 'Y')
		{
			$oAuthManager = new CSocServAuthManager();
			$arServices = $oAuthManager->GetActiveAuthServices(array(
				'BACKURL' => $this->arParams['~CURRENT_PAGE'],
				'FOR_INTRANET' => $arResult['FOR_INTRANET'],
			));

			if (!empty($arServices))
			{
				$APPLICATION->IncludeComponent(
					'bitrix:socserv.auth.form',
					'flat',
					array(
						'AUTH_SERVICES' => $arServices,
						'AUTH_URL' => $arParams['~CURRENT_PAGE'],
						'POST' => $arResult['POST'],
					),
					$component,
					array('HIDE_ICONS' => 'Y')
				);
			}
		}
		?>
	</div>

	<div style="display: none">
		<?
		// we need to have all styles for sale.location.selector.steps, but RestartBuffer() cuts off document head with styles in it
		$APPLICATION->IncludeComponent(
			'bitrix:sale.location.selector.steps',
			'.default',
			array(),
			false
		);
		$APPLICATION->IncludeComponent(
			'bitrix:sale.location.selector.search',
			'.default',
			array(),
			false
		);
		?>
	</div>
	<?
	$signer = new Main\Security\Sign\Signer;
	$signedParams = $signer->sign(base64_encode(serialize($arParams)), 'sale.order.ajax');
	$messages = Loc::loadLanguageFile(__FILE__);
	?>
	<script>
		BX.message(<?=CUtil::PhpToJSObject($messages)?>);
		BX.Sale.OrderAjaxComponent.init({
			result: <?=CUtil::PhpToJSObject($arResult['JS_DATA'])?>,
			locations: <?=CUtil::PhpToJSObject($arResult['LOCATIONS'])?>,
			params: <?=CUtil::PhpToJSObject($arParams)?>,
			signedParamsString: '<?=CUtil::JSEscape($signedParams)?>',
			siteID: '<?=CUtil::JSEscape($component->getSiteId())?>',
			ajaxUrl: '<?=CUtil::JSEscape($component->getPath().'/ajax.php')?>',
			templateFolder: '<?=CUtil::JSEscape($templateFolder)?>',
			propertyValidation: true,
			showWarnings: true,
			pickUpMap: {
				defaultMapPosition: {
					lat: 55.76,
					lon: 37.64,
					zoom: 7
				},
				secureGeoLocation: false,
				geoLocationMaxTime: 5000,
				minToShowNearestBlock: 3,
				nearestPickUpsToShow: 3
			},
			propertyMap: {
				defaultMapPosition: {
					lat: 55.76,
					lon: 37.64,
					zoom: 7
				}
			},
			orderBlockId: 'bx-soa-order',
			authBlockId: 'bx-soa-auth',
			basketBlockId: 'bx-soa-basket',
			regionBlockId: 'bx-soa-region',
			paySystemBlockId: 'bx-soa-paysystem',
			deliveryBlockId: 'bx-soa-delivery',
			pickUpBlockId: 'bx-soa-pickup',
			propsBlockId: 'bx-soa-properties',
			totalBlockId: 'bx-soa-total'
		});
	</script>
	<script>
		<?
		// spike: for children of cities we place this prompt
		$city = \Bitrix\Sale\Location\TypeTable::getList(array('filter' => array('=CODE' => 'CITY'), 'select' => array('ID')))->fetch();
		?>
		BX.saleOrderAjax.init(<?=CUtil::PhpToJSObject(array(
			'source' => $component->getPath().'/get.php',
			'cityTypeId' => intval($city['ID']),
			'messages' => array(
				'otherLocation' => '--- '.Loc::getMessage('SOA_OTHER_LOCATION'),
				'moreInfoLocation' => '--- '.Loc::getMessage('SOA_NOT_SELECTED_ALT'), // spike: for children of cities we place this prompt
				'notFoundPrompt' => '<div class="-bx-popup-special-prompt">'.Loc::getMessage('SOA_LOCATION_NOT_FOUND').'.<br />'.Loc::getMessage('SOA_LOCATION_NOT_FOUND_PROMPT', array(
						'#ANCHOR#' => '<a href="javascript:void(0)" class="-bx-popup-set-mode-add-loc">',
						'#ANCHOR_END#' => '</a>'
					)).'</div>'
			)
		))?>);
	</script>
	<?
	if ($arParams['SHOW_PICKUP_MAP'] === 'Y' || $arParams['SHOW_MAP_IN_PROPS'] === 'Y')
	{
		if ($arParams['PICKUP_MAP_TYPE'] === 'yandex')
		{
			$this->addExternalJs($templateFolder.'/scripts/yandex_maps.js');
			$apiKey = htmlspecialcharsbx(Main\Config\Option::get('fileman', 'yandex_map_api_key', ''));
			?>
			<script src="<?=$scheme?>://api-maps.yandex.ru/2.1.50/?apikey=<?=$apiKey?>&load=package.full&lang=<?=$locale?>"></script>
			<script>
				(function bx_ymaps_waiter(){
					if (typeof ymaps !== 'undefined' && BX.Sale && BX.Sale.OrderAjaxComponent)
						ymaps.ready(BX.proxy(BX.Sale.OrderAjaxComponent.initMaps, BX.Sale.OrderAjaxComponent));
					else
						setTimeout(bx_ymaps_waiter, 100);
				})();
			</script>
			<?
		}

		if ($arParams['PICKUP_MAP_TYPE'] === 'google')
		{
			$this->addExternalJs($templateFolder.'/scripts/google_maps.js');
			$apiKey = htmlspecialcharsbx(Main\Config\Option::get('fileman', 'google_map_api_key', ''));
			?>
			<script async defer
				src="<?=$scheme?>://maps.googleapis.com/maps/api/js?key=<?=$apiKey?>&callback=bx_gmaps_waiter">
			</script>
			<script>
				function bx_gmaps_waiter()
				{
					if (BX.Sale && BX.Sale.OrderAjaxComponent)
						BX.Sale.OrderAjaxComponent.initMaps();
					else
						setTimeout(bx_gmaps_waiter, 100);
				}
			</script>
			<?
		}
	}

	if ($arParams['USE_YM_GOALS'] === 'Y')
	{
		?>
		<script>
			(function bx_counter_waiter(i){
				i = i || 0;
				if (i > 50)
					return;

				if (typeof window['yaCounter<?=$arParams['YM_GOALS_COUNTER']?>'] !== 'undefined')
					BX.Sale.OrderAjaxComponent.reachGoal('initialization');
				else
					setTimeout(function(){bx_counter_waiter(++i)}, 100);
			})();
		</script>
		<?
	}
}