<?php

foreach ($arResult["INFO"]["DELIVERY"] as &$arDelivery)
{
	$name = explode(":", $arDelivery["NAME"]);
	if (is_array($name) && count($name) > 1) $arDelivery["NAME"] = $name[1];

	//	$profileName = $arDelivery["CONFIG"]["MAIN"]["PROFILE_NAME"];
	//	$profileId = $arDelivery["CONFIG"]["MAIN"]["PROFILE_ID"];
	//
	//	if ( !empty($profileName) && strlen($profileName) ) {
	//		$profileName = str_replace("[$profileId]", "", $profileName);
	//		$arDelivery["NAME"] = trim($arDelivery);
	//	}
}

$newResult = [];

foreach ($arResult["ORDERS"] as $orderInfo)
{
	$arOrder = $orderInfo["ORDER"];
	$statusId = $arOrder["STATUS_ID"];
	$deliveryId = $arOrder["DELIVERY_ID"];
	$paySystemId = $arOrder["PAY_SYSTEM_ID"];

	$isHistory = in_array($statusId, ["F"]);
	$payment = $arResult["INFO"]["PAY_SYSTEM"][$paySystemId]["NAME"];
	$delivery = $arResult["INFO"]["DELIVERY"][$deliveryId]["NAME"];
	$status = $arResult["INFO"]["STATUS"][$statusId]["NAME"];

	if ($arOrder["CANCELED"] == "Y")
	{
		$status = "Отменен";
		$isHistory = true;
	}

	$tmpOrder = [
		"id"        => $arOrder["ID"],
		"date"      => $arOrder["DATE_INSERT"]->format('d.m.Y H:i:s'),
		"timestamp" => $arOrder["DATE_INSERT"]->getTimestamp(),
		"price"     => $arOrder["FORMATED_PRICE"],
		"url"       => $arOrder["URL_TO_DETAIL"],

		"isHistory" => $isHistory,
		"status"    => $status,
		"delivery"  => $delivery,
		"payment"   => $payment,

		"names"    => "",
		"products" => []
	];

	foreach ($orderInfo["BASKET_ITEMS"] as $arBasketItem)
	{
		$tmpOrder["names"] .= $arBasketItem["NAME"] . " ";
		$tmpOrder["products"][] = [
			"name"  => $arBasketItem["NAME"],
			"price" => \CCurrencyLang::CurrencyFormat($arBasketItem["PRICE"], "RUB"),
		];
	}

	$newResult[] = $tmpOrder;
}

$arResult = $newResult;
?>
    <pre><? //print_r($arResult)?></pre><?
?>
    <pre><? //print_r($arResult["ORDERS"])?></pre><?