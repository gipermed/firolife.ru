<?php


namespace Palladiumlab\Order;


class OrdersListElement
{
	private string $orderNum;
	private string $date;
	private string $statusId;
	private string $price;

	public function __construct($arResult)
	{
		$this->statusId = $arResult["STATUS_ID"];
	}

	public function getStatus($statuses)
	{
		return $statuses[$this->statusId]["NAME"];
	}

	public function isButtonCancel()
	{
		if ($this->getClassNameStatus() == "formed") return true;
		return false;
	}

	public function getClassNameStatus()
	{
		$res = "formed";
		switch ($this->statusId)
		{
			case "R":
				$res = "canceled";
				break;
			case "F":
			case "L":
				$res = "delivered";
				break;
			case "W":
			case "D":
			case "T":
			case "G":
			case "C":
				$res = "in-transit";
				break;
			case "N":
			case "VO":
			case "ND":
			case "P":
				$res = "formed";
				break;
			case "NN":
				$res = "return";
				break;
		}
		return $res;
	}
}