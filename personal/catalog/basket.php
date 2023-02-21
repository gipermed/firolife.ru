<? require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetPageProperty('title', 'Моя корзина');

if (!$USER->IsAuthorized())
{
	$_SESSION["BACKURL"] = $APPLICATION->GetCurPage();
	LocalRedirect("/auth/");
}
?>

<div class="cabinet-nav">
    <div class="cabinet-menu-wrapp">
		<?php $APPLICATION->IncludeComponent("bitrix:menu", "personal.cabinet", array(
			"ROOT_MENU_TYPE"        => "headercabinet",
			"MAX_LEVEL"             => "1",
			"CHILD_MENU_TYPE"       => "bottom",
			"USE_EXT"               => "N",
			"ALLOW_MULTI_SELECT"    => "N",
			"MENU_CACHE_TYPE"       => "Y",
			"MENU_CACHE_TIME"       => "360000",
			"MENU_CACHE_USE_GROUPS" => "N",
			"MENU_CACHE_GET_VARS"   => "N",
		)); ?>
    </div>
    <i class="cabinet-menu-arrow visible-mobile">
        <svg width="24"
             height="24">
            <use xlink:href="#icon-chevron-down"/>
        </svg>
    </i>
</div>
<ul class="cabinet-page-nav tabs-nav-default">
    <li>
        <a href="fav.php">Избранное</a>
    </li>
    <li>
        <a href="await.php">Лист
            ожидания</a>
    </li>
    <li class="active">
        <a href="#">Корзина</a>
    </li>
</ul>
<div class="cabinet cabinet-products">

	<? $APPLICATION->IncludeComponent("bitrix:sale.basket.basket", "gipermed", array(
			"ACTION_VARIABLE"                 => "basketAction",
			"ADDITIONAL_PICT_PROP_28"         => "-",
			"ADDITIONAL_PICT_PROP_29"         => "-",
			"ADDITIONAL_PICT_PROP_30"         => "-",
			"ADDITIONAL_PICT_PROP_31"         => "-",
			"ADDITIONAL_PICT_PROP_37"         => "-",
			"ADDITIONAL_PICT_PROP_38"         => "-",
			"AUTO_CALCULATION"                => "Y",
			"BASKET_IMAGES_SCALING"           => "standard",
			"COLUMNS_LIST_EXT"                => array(
				"PREVIEW_PICTURE",
				"DISCOUNT",
				"DELETE"
			),
			"COLUMNS_LIST_MOBILE"             => array(
				"PREVIEW_PICTURE",
				"DISCOUNT",
				"DELETE"
			),
			"COMPATIBLE_MODE"                 => "N",
			"CORRECT_RATIO"                   => "Y",
			"DEFERRED_REFRESH"                => "N",
			"DISCOUNT_PERCENT_POSITION"       => "bottom-right",
			"DISPLAY_MODE"                    => "extended",
			"EMPTY_BASKET_HINT_PATH"          => "/",
			"GIFTS_BLOCK_TITLE"               => "Выберите один из подарков",
			"GIFTS_CONVERT_CURRENCY"          => "N",
			"GIFTS_HIDE_BLOCK_TITLE"          => "N",
			"GIFTS_HIDE_NOT_AVAILABLE"        => "N",
			"GIFTS_MESS_BTN_BUY"              => "Выбрать",
			"GIFTS_MESS_BTN_DETAIL"           => "Подробнее",
			"GIFTS_PAGE_ELEMENT_COUNT"        => "4",
			"GIFTS_PLACE"                     => "BOTTOM",
			"GIFTS_PRODUCT_PROPS_VARIABLE"    => "prop",
			"GIFTS_PRODUCT_QUANTITY_VARIABLE" => "quantity",
			"GIFTS_SHOW_DISCOUNT_PERCENT"     => "Y",
			"GIFTS_SHOW_OLD_PRICE"            => "N",
			"GIFTS_TEXT_LABEL_GIFT"           => "Подарок",
			"HIDE_COUPON"                     => "N",
			"LABEL_PROP"                      => array(),
			"PATH_TO_ORDER"                   => "/sale/",
			"PRICE_DISPLAY_MODE"              => "Y",
			"PRICE_VAT_SHOW_VALUE"            => "N",
			"PRODUCT_BLOCKS_ORDER"            => "props,sku,columns",
			"QUANTITY_FLOAT"                  => "Y",
			"SET_TITLE"                       => "Y",
			"SHOW_DISCOUNT_PERCENT"           => "Y",
			"SHOW_FILTER"                     => "N",
			"SHOW_RESTORE"                    => "N",
			"TEMPLATE_THEME"                  => "site",
			"TOTAL_BLOCK_DISPLAY"             => array(),
			"USE_DYNAMIC_SCROLL"              => "Y",
			"USE_ENHANCED_ECOMMERCE"          => "N",
			"USE_GIFTS"                       => "N",
			"USE_PREPAYMENT"                  => "N",
			"USE_PRICE_ANIMATION"             => "N"
		)); ?>
</div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
