<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main;
use Bitrix\Main\Localization\Loc;
\Bitrix\Main\UI\Extension::load("ui.fonts.ruble");

if (!isset($arParams['DISPLAY_MODE']) || !in_array($arParams['DISPLAY_MODE'], array('extended', 'compact'))) {
	$arParams['DISPLAY_MODE'] = 'extended';
}

$arParams['USE_DYNAMIC_SCROLL'] = isset($arParams['USE_DYNAMIC_SCROLL']) && $arParams['USE_DYNAMIC_SCROLL'] === 'N' ? 'N' : 'Y';
$arParams['SHOW_FILTER'] = isset($arParams['SHOW_FILTER']) && $arParams['SHOW_FILTER'] === 'N' ? 'N' : 'Y';

$arParams['PRICE_DISPLAY_MODE'] = isset($arParams['PRICE_DISPLAY_MODE']) && $arParams['PRICE_DISPLAY_MODE'] === 'N' ? 'N' : 'Y';

if (!isset($arParams['TOTAL_BLOCK_DISPLAY']) || !is_array($arParams['TOTAL_BLOCK_DISPLAY']))
{
	$arParams['TOTAL_BLOCK_DISPLAY'] = array('top');
}
if (empty($arParams['PRODUCT_BLOCKS_ORDER']))
{
	$arParams['PRODUCT_BLOCKS_ORDER'] = 'props,sku,columns';
}

if (is_string($arParams['PRODUCT_BLOCKS_ORDER']))
{
	$arParams['PRODUCT_BLOCKS_ORDER'] = explode(',', $arParams['PRODUCT_BLOCKS_ORDER']);
}

$arParams['USE_PRICE_ANIMATION'] = isset($arParams['USE_PRICE_ANIMATION']) && $arParams['USE_PRICE_ANIMATION'] === 'N' ? 'N' : 'Y';
$arParams['EMPTY_BASKET_HINT_PATH'] = isset($arParams['EMPTY_BASKET_HINT_PATH']) ? (string)$arParams['EMPTY_BASKET_HINT_PATH'] : '/';
$arParams['USE_ENHANCED_ECOMMERCE'] = isset($arParams['USE_ENHANCED_ECOMMERCE']) && $arParams['USE_ENHANCED_ECOMMERCE'] === 'Y' ? 'Y' : 'N';
$arParams['DATA_LAYER_NAME'] = isset($arParams['DATA_LAYER_NAME']) ? trim($arParams['DATA_LAYER_NAME']) : 'dataLayer';
$arParams['BRAND_PROPERTY'] = isset($arParams['BRAND_PROPERTY']) ? trim($arParams['BRAND_PROPERTY']) : '';



\CJSCore::Init(array('fx', 'popup', 'ajax'));

//$this->addExternalCss($templateFolder.'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css');

$this->addExternalJs($templateFolder.'/js/mustache.js');
$this->addExternalJs($templateFolder.'/js/action-pool.js');
$this->addExternalJs($templateFolder.'/js/filter.js');
$this->addExternalJs($templateFolder.'/js/component.js');

$mobileColumns = isset($arParams['COLUMNS_LIST_MOBILE'])
	? $arParams['COLUMNS_LIST_MOBILE']
	: $arParams['COLUMNS_LIST'];
$mobileColumns = array_fill_keys($mobileColumns, true);
$jsTemplates = new Main\IO\Directory(Main\Application::getDocumentRoot().$templateFolder.'/js-templates');
/** @var Main\IO\File $jsTemplate */
foreach ($jsTemplates->getChildren() as $jsTemplate)
{
	include($jsTemplate->getPath());
}

$displayModeClass = $arParams['DISPLAY_MODE'] === 'compact' ? ' basket-items-list-wrapper-compact' : '';

if (empty($arResult['ERROR_MESSAGE']))
{


	if ($arResult['BASKET_ITEM_MAX_COUNT_EXCEEDED'])
	{
		?>
		<div id="basket-item-message">
			<?=Loc::getMessage('SBB_BASKET_ITEM_MAX_COUNT_EXCEEDED', array('#PATH#' => $arParams['PATH_TO_BASKET']))?>
		</div>
		<?
	}
	?>

	<div id="basket-root" class="bx-basket bx-<?=$arParams['TEMPLATE_THEME']?> bx-step-opacity" style="opacity: 0;">

		<div class="row">
			<div class="col">
				<div class="alert alert-warning alert-dismissable" id="basket-warning" style="display: none;">
					<span class="close" data-entity="basket-items-warning-notification-close">&times;</span>
					<div data-entity="basket-general-warnings"></div>
					<div data-entity="basket-item-warnings">
						<?=Loc::getMessage('SBB_BASKET_ITEM_WARNING')?>
					</div>
				</div>
			</div>
		</div>
        <div class="cart-head">
            <h1 class="section-title">Корзина</h1>
        </div>


        <div class="cart section">
            <div class="cart__blocks">
                <?$APPLICATION->IncludeComponent("bitrix:main.include", "", array(
	"AREA_FILE_SHOW" => "file",
		"PATH" => "/include/basket-notify.php"
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "N"
	)
);?>
                <div class="cart-body">
                    <div class="cart-nav">
                        <div class="cart__count">
                            У вас в корзине <?=$arResult['BASKET_ITEMS_COUNT'];?> <?=endingsForm($arResult['BASKET_ITEMS_COUNT'],'товар','товара','товаров');?>
                        </div>
                        <a href="<?=$APPLICATION->GetCurPage();?>?del_all=1" data-entity="basket-clear" class="cart-clear-btn">
                            <span>Очистить корзину</span>
                        </a>
                    </div>
                    <div class="cart-items" id="basket-item-table">
                    </div>
                    <div class="delAll_mobile">
                        <a href="<?=$APPLICATION->GetCurPage();?>?del_all=1" data-entity="basket-clear" class="cart-clear-btn">
                            <span>Очистить корзину</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="cart__sticky">
                <div class="cart__sticky2">
                    <div data-entity="basket-total-block">
                    </div>
                        <? $APPLICATION->IncludeComponent( "bxmaker:geoip.delivery",
                            "",
                            array(
                                "COMPONENT_TEMPLATE" => ".default",
                                "CACHE_TYPE" => "A",
                                "CACHE_TIME" => "3600",
                                "COMPOSITE_FRAME_MODE" => "A",
                                "COMPOSITE_FRAME_TYPE" => "AUTO",
                                "PRODUCT_ID" => $arResult['BASKET_ITEM_RENDER_DATA'][0]['PRODUCT_ID'],
                                "IMG_SHOW" => "Y",
                                "PROLOG" => "Способы доставки в ваш город - #CITY#",
                            ),
                            $component
                        ); ?>
                </div>
            </div>
        </div>
    </div>
	<?
	if (!empty($arResult['CURRENCIES']) && Main\Loader::includeModule('currency'))
	{
		CJSCore::Init('currency');

		?>
		<script>
			BX.Currency.setCurrencies(<?=CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true)?>);
		</script>
		<?
	}

	$signer = new \Bitrix\Main\Security\Sign\Signer;
	$signedTemplate = $signer->sign($templateName, 'sale.basket.basket');
	$signedParams = $signer->sign(base64_encode(serialize($arParams)), 'sale.basket.basket');
	$messages = Loc::loadLanguageFile(__FILE__);
	?>
	<script>
		BX.message(<?=CUtil::PhpToJSObject($messages)?>);
		BX.Sale.BasketComponent.init({
			result: <?=CUtil::PhpToJSObject($arResult, false, false, true)?>,
			params: <?=CUtil::PhpToJSObject($arParams)?>,
			template: '<?=CUtil::JSEscape($signedTemplate)?>',
			signedParamsString: '<?=CUtil::JSEscape($signedParams)?>',
			siteId: '<?=CUtil::JSEscape($component->getSiteId())?>',
			siteTemplateId: '<?=CUtil::JSEscape($component->getSiteTemplateId())?>',
			templateFolder: '<?=CUtil::JSEscape($templateFolder)?>'
		});
	</script>
	<?

}
elseif ($arResult['EMPTY_BASKET'])
{
	include(Main\Application::getDocumentRoot().$templateFolder.'/empty.php');
}
else
{
	ShowError($arResult['ERROR_MESSAGE']);
}