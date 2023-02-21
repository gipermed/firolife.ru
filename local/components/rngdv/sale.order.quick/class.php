<?

use \Bitrix\Main\Context, \Bitrix\Currency\CurrencyManager, \Bitrix\Sale\Order, \Bitrix\Sale\Basket, \Bitrix\Sale\Delivery, \Bitrix\Sale\PaySystem;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class CSaleOrderQuick extends \CBitrixComponent
{
	const COMPONENT = "sale.order.quick";
	const AJAX_URL = "/local/components/rngdv/sale.order.quick/ajax.php";

	public function executeComponent()
	{
		$this->arResult["COMPONENT"] = self::COMPONENT;
		$this->arResult["AJAX_URL"] = self::AJAX_URL;

		$request = Context::getCurrent()->getRequest();

		$isAjax = $request->isAjaxRequest() && $request->get("component") == self::COMPONENT;


		if ($isAjax)
		{
			$this->getBasketSummary();

			if ($request->get("form_submitted") != "Y")
			{
				$this->includeComponentTemplate();
			} else
			{
				$errors = [];

				if ($this->arResult["QTY"] <= 0) $errors[] = "В корзине нет товаров";

				$requestParams = [
					"NAME"     => "Укажите имя",
					"PHONE"    => "Укажите телефон",
					"COMMENT"  => false,
					"DELIVERY" => false,
					"PAYMENT"  => false,
				];

				foreach ($requestParams as $param => $error)
				{
					$val = trim($request->get($param));

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

	private function getBasketSummary()
	{
		Bitrix\Main\Loader::includeModule("sale");

		$basket = Basket::loadItemsForFUser(\CSaleBasket::GetBasketUserID(), Context::getCurrent()->getSite());

		$this->arResult["SUM"] = \CCurrencyLang::CurrencyFormat($basket->getPrice(), "RUB");
		$this->arResult["QTY"] = array_sum($basket->getQuantityList());
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
		$order->setField('USER_DESCRIPTION', $requestParams["COMMENT"]);

		// Устанавливаем свойства
		$propertyCollection = $order->getPropertyCollection();
		$propertyCollection->getPhone()->setValue($requestParams["PHONE"]);
		$propertyCollection->getPayerName()->setValue($requestParams["NAME"]);
		$propertyCollection->getUserEmail()->setValue;


		// Устанавливаем товары из корзины
		$basket = Basket::loadItemsForFUser(\CSaleBasket::GetBasketUserID(), $siteId);
		$order->setBasket($basket->getOrderableItems());


		// курьер кар 5
		// курьер нал 2
		// сам кар 8
		// сам нал 11
		$deliveryId = 0;
		$deliveryPrice = 0;
		switch ($requestParams["DELIVERY"])
		{
			case "self":
				$deliveryId = 43;
				$deliveryPrice = 0;
				break;
			case "courier":
				$deliveryId = 37;
				$deliveryPrice = 250;
				break;
			case "courier-auto":
				$deliveryId = 44;
				$deliveryPrice = 350;
				break;
		}

		if ($requestParams["DELIVERY"] == "self")
		{
			$paySystemId = $requestParams["PAYMENT"] == "card" ? 8 : 11;
		} else
		{
			$paySystemId = $requestParams["PAYMENT"] == "card" ? 5 : 2;
		}


		// Создаём одну отгрузку и устанавливаем способ доставки - "Без доставки" (он служебный)
		$shipmentCollection = $order->getShipmentCollection();
		$shipment = $shipmentCollection->createItem();

		$service = \Bitrix\Sale\Delivery\Services\Manager::getById($deliveryId);

		$shipment->setFields([
			'DELIVERY_ID'           => $service['ID'],
			'DELIVERY_NAME'         => $service['NAME'],
			'ALLOW_DELIVERY'        => 'Y',
			'PRICE_DELIVERY'        => $service["CONFIG"]["MAIN"]["PRICE"],
			'CUSTOM_PRICE_DELIVERY' => 'Y'
		]);

		$shipmentItemCollection = $shipment->getShipmentItemCollection();

		foreach ($order->getBasket() as $item)
		{
			$shipmentItem = $shipmentItemCollection->createItem($item);
			$shipmentItem->setQuantity($item->getQuantity());
		}


		$paymentCollection = $order->getPaymentCollection();
		$payment = $paymentCollection->createItem();
		$paySystemService = PaySystem\Manager::getObjectById($paySystemId);
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