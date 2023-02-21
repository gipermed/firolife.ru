<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();


class CBasketSimpleAjax extends CBitrixComponent
{
	private $req;
	private $basket;
	private $item;

	public function executeComponent()
	{
		$this->req = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
		$isAjax = $this->req->isAjaxRequest() || $this->req->get("debug") == "y";
		$component = $this->req->get("component");
		$action = $this->req->get("act");

		if ($isAjax && $component == "basket.simple.ajax" && $action)
		{
			//try {
			switch ($action)
			{
				case "add":
					$this->add();
					break;
				case "qty":
					$this->updateQty();
					break;
				case "del":
					$this->delete();
					break;
				case "rsr":
					$this->restore();
					break;
				case "clr":
					$this->clear();
					break;
				case "gft":
					$this->gift();
					break;
			}

			return true;
//			}
//			catch ( Exception $e ) {
//				$GLOBALS["APPLICATION"]->RestartBuffer();
//				echo json_encode( [ "error" => $e->getMessage() ] );
//				die();
//			}
		}
	}

	private function add()
	{
		CModule::IncludeModule("catalog");

		$id = (int)$this->req->get("id");
		$qty = (int)$this->req->get("qty");

		$boxing = (int)$this->req->get("boxing");
		$size = $this->req->get("size");

		$arParams = [
			[
				"CODE"  => "BOXING",
				"VALUE" => $boxing
			]
		];

		if ($size)
		{
			$arParams[] = [
				"CODE"  => "SIZE",
				"VALUE" => $size
			];
		}

		if ($qty <= 0) $qty = 1;

		Add2BasketByProductID($id, $qty, [], $arParams);
	}

	private function updateQty()
	{
		$this->initBasket();
		$this->initItem();

		$qty = (int)$this->req->get("qty");

		$res = $this->item->setField('QUANTITY', $qty);

		if (!$res->isSuccess()) $this->throwErrors($res->getErrors());

		$this->basket->save();
	}

	private function initBasket()
	{
		\CModule::IncludeModule("sale");

		$this->basket = \Bitrix\Sale\Basket::loadItemsForFUser(\Bitrix\Sale\Fuser::getId(), \Bitrix\Main\Context::getCurrent()->getSite());
	}

	private function initItem()
	{
		$id = (int)$this->req->get("id");
		$this->item = $this->basket->getItemByBasketCode($id);
	}

	private function throwErrors($arErrors)
	{
		$tmp = [];
		foreach ($arErrors as $err)
		{
			$tmp[] = $err->getMessage();
		}

		throw new \Exception(implode("; ", $tmp));
	}

	private function delete()
	{
		$this->initBasket();
		$this->initItem();

		$res = $this->item->delete();

		if (!$res->isSuccess()) $this->throwErrors($res->getErrors());

		$this->basket->save();
	}

	private function restore()
	{
		$this->initBasket();

		CModule::IncludeModule("catalog");

		$context = array('SITE_ID' => $this->getSiteId());
		$item = $this->req->get("item");

		$arProps = [];
		foreach ($item["PROPS"] as $code => $val)
		{
			$arProps[] = [
				"CODE"  => $code,
				"VALUE" => $val
			];
		}

		$fields = [
			"PRODUCT_ID"             => $item["PRODUCT_ID"],
			"QUANTITY"               => $item["QUANTITY"],
			"SORT"                   => $item["SORT"],
			"PROPS"                  => $arProps,
			"MODULE"                 => "catalog",
			"PRODUCT_PROVIDER_CLASS" => '\Bitrix\Catalog\Product\CatalogProvider',
		];

		\Bitrix\Catalog\Product\Basket::addProductToBasketWithPermissions($this->basket, $fields, $context, false);

		$this->basket->save();
	}

	private function clear()
	{
		$this->initBasket();

		foreach ($this->basket as $item)
		{
			$res = $item->delete();

			if (!$res->isSuccess()) $this->throwErrors($res->getErrors());
		}

		$this->basket->save();
	}

	private function gift()
	{
		$this->initBasket();

		$gift = (int)$this->req->get("gift");
		$productId = (int)$this->req->get("prod");


		foreach ($this->basket as $item)
		{
			if ($item->getProductId() == $productId)
			{

				$basketPropertyCollection = $item->getPropertyCollection();

				$giftProp = false;
				foreach ($basketPropertyCollection as $propItem)
				{
					if ($propItem->getField("CODE") == "GIFT")
					{
						$giftProp = $propItem;
					}
				}

				if (!$giftProp)
				{
					$giftProp = $basketPropertyCollection->createItem();
				}


				$giftProp->setFields([
					'NAME'  => 'Подарок',
					'CODE'  => 'GIFT',
					'VALUE' => $gift,
					'SORT'  => 200,
				]);

				break;
			}
		}

		$this->basket->save();
	}
}