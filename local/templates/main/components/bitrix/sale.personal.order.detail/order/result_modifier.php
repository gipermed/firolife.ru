<?php
foreach ($arResult["ORDER_PROPS"] as $arProp)
{
	$arResult["PROPS"][$arProp["CODE"]] = $arProp["VALUE"];
}


$name = explode(":", $arResult["SHIPMENT"]["0"]["DELIVERY"]["NAME"]);
if (is_array($name) && count($name) > 1) $arResult["SHIPMENT"]["0"]["DELIVERY"]["NAME"] = $name[1];

foreach ($arResult["BASKET"] as &$item)
{
	foreach ($item["PROPS"] as $prop)
	{
		$item["PROP_VALS"][$prop["CODE"]] = $prop["VALUE"];
	}
}


foreach ($arResult['PAYMENT'] as &$payment)
{
	$paymentData[$payment['ACCOUNT_NUMBER']] = array(
		"payment"         => $payment['ACCOUNT_NUMBER'],
		"order"           => $arResult['ACCOUNT_NUMBER'],
		"allow_inner"     => $arParams['ALLOW_INNER'],
		"only_inner_full" => $arParams['ONLY_INNER_FULL'],
		"refresh_prices"  => $arParams['REFRESH_PRICES'],
		"path_to_payment" => $arParams['PATH_TO_PAYMENT']
	);
	$paymentSubTitle = "Счет №" . $payment['ACCOUNT_NUMBER'];
	if (isset($payment['DATE_BILL']))
	{
		$paymentSubTitle .= " от " . $payment['DATE_BILL']->format($arParams['ACTIVE_DATE_FORMAT']);
	}
	$paymentSubTitle .= ",";
	$payment["TITLE"] = htmlspecialcharsbx($paymentSubTitle);

	//$payment['PAY_SYSTEM_NAME']
	$paymentStatus = "";

	if ($payment['PAID'] === 'Y') $paymentStatus = "Оплачено"; elseif ($arResult['IS_ALLOW_PAY'] == 'N') $paymentStatus = "На проверке менеджером";
	else $paymentStatus = "Не оплачено";


	$payment["STATUS"] = $payment['PAY_SYSTEM']["IS_CASH"] !== "Y" ? $paymentStatus : "";


	$payment["ALLOW_TO_PAY"] = $payment["PAID"] !== "Y" && $payment['PAY_SYSTEM']["IS_CASH"] !== "Y" && $payment['PAY_SYSTEM']['ACTION_FILE'] !== 'cash' && $payment['PAY_SYSTEM']['PSA_NEW_WINDOW'] !== 'Y' && $arResult['CANCELED'] !== 'Y' && $arResult["IS_ALLOW_PAY"] !== "N";
}