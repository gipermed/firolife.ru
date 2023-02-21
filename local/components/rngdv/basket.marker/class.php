<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();


class CBasketMarker extends CBitrixComponent
{
	public function executeComponent()
	{
		\CModule::IncludeModule("sale");

		$basket = \Bitrix\Sale\Basket::loadItemsForFUser(\Bitrix\Sale\Fuser::getId(), \Bitrix\Main\Context::getCurrent()->getSite());

		$this->arResult = array();
		foreach ($basket as $item)
		{
			$id = $item->getProductId();

			if (!is_array($this->arResult[$id])) $this->arResult[$id] = [];

			$props = $item->getPropertyCollection()->getPropertyValues();
			$size = $props["SIZE"]["VALUE"];

			if ($size) $this->arResult[$id][] = $size;
		}


		$this->includeComponentTemplate();
	}
}