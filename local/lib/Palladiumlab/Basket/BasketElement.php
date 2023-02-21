<?php


namespace Palladiumlab\Basket;

use Palladiumlab\Sku\SkuModel;

class BasketElement
{
	private SkuModel $sku;
	private string $nameWithoutSku;
	private string $fullName;
	private float $quantity;
	private string $price;
	private string $currency;

	public function __construct($arResult)
	{
		$name = $arResult["NAME"];
		if ($name !== null)
		{
			$this->fullName = $name;
			$this->quantity = $arResult["QUANTITY"];
			$this->price = $arResult["PRICE"];
			$this->currency = $arResult["CURRENCY"];
			$this->processSkuFromName();
		}
	}

	private function processSkuFromName()
	{
		$sku = $this->parseNameSku();
		if ($sku !== false)
		{
			$arSku = explode(",", $sku);
			$this->sku = new SkuModel($arSku[0], $arSku[1]);
		}
	}

	private function parseNameSku()
	{
		$name = $this->fullName;
		$lenOfName = strlen($name);
		if ($name[$lenOfName - 1] === ")")
		{
			$beginPosSku = strrpos($name, "(") + 1;
			if ($beginPosSku !== false)
			{
				$this->nameWithoutSku = substr($name, 0, $beginPosSku - 1);
				return substr($name, $beginPosSku, -1);
			}
		}
		return false;
	}

	/**
	 * @return SkuModel
	 */
	public function getSku(): SkuModel
	{
		return $this->sku;
	}

	/**
	 * @return string
	 */
	public function getNameWithoutSku(): string
	{
		return $this->nameWithoutSku;
	}

	/**
	 * @return mixed|string
	 */
	public function getFullName()
	{
		return $this->fullName;
	}

	/**
	 * @return float|mixed
	 */
	public function getQuantity()
	{
		return $this->quantity;
	}

	/**
	 * @return mixed|string
	 */
	public function getPrice()
	{
		return $this->price;
	}

	public function getFormattedPrice()
	{
		return \CCurrencyLang::CurrencyFormat($this->price * $this->quantity, $this->currency);
	}
}