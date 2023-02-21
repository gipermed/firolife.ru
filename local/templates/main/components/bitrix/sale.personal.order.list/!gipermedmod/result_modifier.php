<?php

use Palladiumlab\Basket\ProductLinkElement;

\Bitrix\Main\Loader::includeModule('iblock');
$productIds = [];
foreach ($arResult["ORDERS"] as $k => $order)
{
	foreach ($order["BASKET_ITEMS"] as $basketItem)
	{
		$productIds[] = $basketItem['PRODUCT_ID'];
	}
}

$arResult["PHOTO_PRODUCTS"] = ProductLinkElement::getPhotoElement($productIds, $arParams)

?>