<?php


namespace Palladiumlab\Delivery;


class DeliveryElement
{
	private string $statusId;
	private string $deliveryName;
	private string $deliveryId;
	private string $priceDelivery;
	private string $currency;
	private string $tracking;
	private string $formattedDeliveryPrice;
	private string $deliveryStatusName;

	public function __construct($arResult)
	{
		$arResult = current($arResult);
		$this->statusId = $arResult["STATUS_ID"];
		$this->deliveryName = $arResult["DELIVERY_NAME"];
		$this->deliveryId = $arResult["DELIVERY_ID"];
		$this->priceDelivery = $arResult["PRICE_DELIVERY"];
		$this->currency = $arResult["CURRENCY"];
		$this->tracking = is_null($arResult["TRACKING_NUMBER"]) ? "" : $arResult["TRACKING_NUMBER"];
		$this->formattedDeliveryPrice = $arResult["FORMATED_DELIVERY_PRICE"];
		$this->deliveryStatusName = $arResult["DELIVERY_STATUS_NAME"];
	}

	/**
	 * @return mixed|string
	 */
	public function getStatusId()
	{
		return $this->statusId;
	}

	/**
	 * @return mixed|string
	 */
	public function getDeliveryName()
	{
		return $this->deliveryName;
	}

	/**
	 * @return mixed|string
	 */
	public function getDeliveryId()
	{
		return $this->deliveryId;
	}

	/**
	 * @return mixed|string
	 */
	public function getPriceDelivery()
	{
		return $this->priceDelivery;
	}

	/**
	 * @return mixed|string
	 */
	public function getCurrency()
	{
		return $this->currency;
	}

	/**
	 * @return mixed|string
	 */
	public function getTracking()
	{
		return $this->tracking;
	}

	/**
	 * @return mixed|string
	 */
	public function getFormattedDeliveryPrice()
	{
		return $this->formattedDeliveryPrice;
	}

	/**
	 * @return mixed|string
	 */
	public function getDeliveryStatusName()
	{
		return $this->deliveryStatusName;
	}


}