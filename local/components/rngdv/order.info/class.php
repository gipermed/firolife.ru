<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();


class RngdvOrderInfo extends CBitrixComponent
{
	private $order;
	private $user;


	public function executeComponent()
	{
		$orderId = $this->arParams["ORDER_ID"];
		$this->order = \Bitrix\Sale\Order::load($orderId);

		$this->getResult();

//		print_r($this->arResult);
		ob_start();
		$this->IncludeComponentTemplate();
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}

	private function getResult()
	{
		$this->arResult = $this->getOrderProps();

		$this->arResult["PAYMENT"] = $this->getPaymentSystem();
		$this->arResult["DELIVERY"] = $this->getDelivery();
		$this->arResult["BASKET"] = $this->getBasket();
	}

	private function getOrderProps()
	{
		$arOrderProps = $this->order->getPropertyCollection()->getArray();
		$arOrderPropValues = [];

		foreach ($arOrderProps['properties'] as $arOrderProp)
		{
			$code = $arOrderProp["CODE"];
			$name = $arOrderProp["NAME"];
			$value = $arOrderProp["VALUE"][0];

			if (in_array($code, [
				"LOCATION",
				"POSTCODE",
				"INDIVIDUAL_SELFPICKUP"
			])) continue;

			$arOrderPropValues[$code] = [
				"NAME"  => $name,
				"VALUE" => $value
			];
		}

		return $arOrderPropValues;
	}

	private function getPaymentSystem()
	{
		$paymentCollection = $this->order->getPaymentCollection();

		foreach ($paymentCollection as $payment)
		{
			return $payment->getPaymentSystemName();
		}
	}

	private function getDelivery()
	{
		$shipmentCollection = $this->order->getShipmentCollection();

		foreach ($shipmentCollection as $shipment)
		{
			return $shipment->getDeliveryName();
		}
	}

	private function getBasket()
	{
		$basket = $this->order->getBasket();
		$basketItems = $basket->getBasketItems();
		$res = [
			"SUM"    => $basket->getPrice(),
			"WEIGHT" => $basket->getWeight(),
			"ITEMS"  => [],
		];

		foreach ($basketItems as $item)
		{
			$ar = [
				"NAME"   => $item->getField('NAME'),
				"PRICE"  => $item->getPrice(),
				"QTY"    => $item->getQuantity(),
				"SUM"    => $item->getFinalPrice(),
				"WEIGHT" => $item->getWeight(),
				"PROPS"  => []
			];


			$basketPropertyCollection = $item->getPropertyCollection();
			$props = $basketPropertyCollection->getPropertyValues();


			foreach ($props as $prop)
			{
				$code = $prop["CODE"];
				$value = $prop["VALUE"];

				$ar["PROPS"][$code] = $value;
			}


			$res["ITEMS"][] = $ar;
		}

		return $res;
	}

	private function getUserProfile()
	{
		$userId = $this->order->getUserId();

		$rw = \CSaleOrderUserProps::GetList([], ["USER_ID" => $userId]);
		$userProfile = $rw->Fetch();


		$rs = \CSaleOrderUserPropsValue::GetList([], ["USER_PROPS_ID" => $userProfile["ID"]]);
		$arUserPropValues = [];
		while ($rw = $rs->GetNext()) $arUserPropValues[$rw["PROP_CODE"]] = $rw["VALUE"];

		return $arUserPropValues;
	}
}