<?

use \Bitrix\Main\Context, \Bitrix\Currency\CurrencyManager, \Bitrix\Sale\Order, \Bitrix\Sale\Basket, \Bitrix\Sale\Delivery, \Bitrix\Sale\PaySystem;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class CSaleOrderQuickProduct extends \CBitrixComponent
{
	const COMPONENT = "sale.order.quick.product";
	const AJAX_URL = "/local/components/rngdv/sale.order.quick.product/ajax.php";

	public function executeComponent()
	{
		$this->arResult["COMPONENT"] = self::COMPONENT;
		$this->arResult["AJAX_URL"] = self::AJAX_URL;

		$request = Context::getCurrent()->getRequest();

		$isAjax = $request->isAjaxRequest() && $request->get("component") == self::COMPONENT;


		if ($isAjax)
		{
			if ($request->get("form_submitted") != "Y")
			{
				$this->includeComponentTemplate();
			} else
			{
				$errors = [];

				$requestParams = [
					"NAME"    => "Укажите Ваше имя",
					"PHONE"   => "Укажите Ваш телефон",
					"EMAIL"   => "Укажите Ваш e-mail",
					"PRODUCT" => false,
					"BOXING"  => false,
					"SIZE"    => false,
					"QTY"     => false,
				];

				foreach ($requestParams as $param => $error)
				{
					$val = trim($request->get($param));

					if ($param == "PHONE")
					{
						if (!preg_match("/^\\+7\\(9\\d{2}\\)\\d{3}\\-\\d{2}\\-\\d{2}$/", $val))
						{
							$errors[] = "Введите корректный номер сотового телефона в формате +7(910)123-45-67";
							$error = false;
						}
					}

					if ($error && strlen($val) == 0) $errors[] = $error; else $requestParams[$param] = $val;
				}


				if (!check_bitrix_sessid()) $errors[] = "sid";

				$this->checkAndSendErrors($errors);
				$this->createOrder($requestParams);
			}
		} else
		{
			$this->includeComponentTemplate("button");
		}
	}

	private function checkAndSendErrors($errors)
	{
		if (!is_array($errors)) return;
		if (count($errors) == 0) return;

		echo json_encode([
			"success" => false,
			"errors"  => $errors
		]);
		die();
	}

	private function createOrder($requestParams)
	{
		Bitrix\Main\Loader::includeModule("sale");
		Bitrix\Main\Loader::includeModule("catalog");

		global $USER;

		$siteId = Context::getCurrent()->getSite();
		$currencyCode = CurrencyManager::getBaseCurrency();

		$userId = $USER->isAuthorized() ? $USER->GetID() : \CSaleUser::GetAnonymousUserID();


		// Создаём новый заказ
		$order = Order::create($siteId, $userId);
		$order->setPersonTypeId(1);
		$order->setField('CURRENCY', $currencyCode);
		$order->setField('USER_DESCRIPTION', "Заказ в 1 клик");

		// Устанавливаем свойства
		$propertyCollection = $order->getPropertyCollection();
		$propertyCollection->getPhone()->setValue($requestParams["PHONE"]);
		$propertyCollection->getPayerName()->setValue($requestParams["NAME"]);
		$propertyCollection->getUserEmail()->setValue($requestParams["EMAIL"]);


		// Создаем корзину
		$basket = Bitrix\Sale\Basket::create($siteId);
		$item = $basket->createItem("catalog", $requestParams["PRODUCT"]);

		$item->setFields([
			"QUANTITY"               => $requestParams["QTY"],
			'LID'                    => $siteId,
			'PRODUCT_PROVIDER_CLASS' => '\CCatalogProductProvider',
		]);

		$item->getPropertyCollection()->setProperty([
			["NAME"  => "Упаковка",
			 "CODE"  => "BOXING",
			 "VALUE" => $requestParams["BOXING"]
			],
			[
				"NAME"  => "Размер",
				"CODE"  => "SIZE",
				"VALUE" => $requestParams["SIZE"]
			]
		]);

		$order->setBasket($basket);


		// Создаём одну отгрузку и устанавливаем способ доставки - "Без доставки" (он служебный)
		$shipmentCollection = $order->getShipmentCollection();
		$shipment = $shipmentCollection->createItem();

		$emptyDeliveryId = Delivery\Services\EmptyDeliveryService::getEmptyDeliveryServiceId();
		$service = Delivery\Services\Manager::getById($emptyDeliveryId);
		$shipment->setFields(array(
			'DELIVERY_ID'   => $service['ID'],
			'DELIVERY_NAME' => $service['NAME'],
		));

		$shipmentItemCollection = $shipment->getShipmentItemCollection();

		foreach ($order->getBasket() as $item)
		{
			$shipmentItem = $shipmentItemCollection->createItem($item);
			$shipmentItem->setQuantity($item->getQuantity());
		}


		// Создаём оплату со способом #2
		$paymentCollection = $order->getPaymentCollection();
		$payment = $paymentCollection->createItem();
		$paySystemService = PaySystem\Manager::getObjectById(2);
		$payment->setFields(array(
			'PAY_SYSTEM_ID'   => $paySystemService->getField("PAY_SYSTEM_ID"),
			'PAY_SYSTEM_NAME' => $paySystemService->getField("NAME"),
			'SUM'             => $order->getPrice()
		));


		// Сохраняем
		$order->doFinalAction(true);
		$result = $order->save();

		if (!$result)
		{
			$this->checkAndSendErrors(["Ошибка при сохранении заказа"]);
		}

		echo json_encode([
			"success" => true,
			"orderId" => $order->getId()
		]);
	}
}