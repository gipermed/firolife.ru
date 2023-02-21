<? require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetPageProperty('title', 'Мои заказы');

if (!$USER->IsAuthorized())
{
	$_SESSION["BACKURL"] = $APPLICATION->GetCurPage();
	LocalRedirect("/auth/");
}
?>

<?//$_REQUEST['show_all'] = "Y";?>

<? $APPLICATION->IncludeComponent(
	"bitrix:sale.personal.order.list", 
	"gipermedmod", 
	array(
		"STATUS_COLOR_N" => "green",
		"STATUS_COLOR_P" => "yellow",
		"STATUS_COLOR_F" => "gray",
		"STATUS_COLOR_PSEUDO_CANCELLED" => "red",
		"PATH_TO_DETAIL" => "detail.php?ID=#ID#",
		"PATH_TO_COPY" => "index.php",
		"PATH_TO_CANCEL" => "cancel_order.php?ID=#ID#",
		"PATH_TO_BASKET" => "/cart/",
		"PATH_TO_PAYMENT" => "payment.php",
		"ORDERS_PER_PAGE" => "2000",
		"ID" => $_REQUEST["ID"],
		"SET_TITLE" => "Y",
		"SAVE_IN_SESSION" => "Y",
		"NAV_TEMPLATE" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CACHE_GROUPS" => "Y",
		"HISTORIC_STATUSES" => array(
		),
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"COMPONENT_TEMPLATE" => "gipermedmod",
		"PATH_TO_CATALOG" => "/catalog/",
		"DISALLOW_CANCEL" => "N",
		"RESTRICT_CHANGE_PAYSYSTEM" => array(
			0 => "0",
		),
		"REFRESH_PRICES" => "N",
		"DEFAULT_SORT" => "STATUS",
		"ALLOW_INNER" => "N",
		"ONLY_INNER_FULL" => "N",
		"STATUS_COLOR_C" => "gray",
		"STATUS_COLOR_D" => "gray",
		"STATUS_COLOR_G" => "gray",
		"STATUS_COLOR_L" => "gray",
		"STATUS_COLOR_ND" => "gray",
		"STATUS_COLOR_NN" => "gray",
		"STATUS_COLOR_R" => "gray",
		"STATUS_COLOR_T" => "gray",
		"STATUS_COLOR_VO" => "gray",
		"STATUS_COLOR_W" => "gray",
		"STATUS_COLOR_YT" => "gray"
	),
	false
); ?>




<?
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php');
?>
