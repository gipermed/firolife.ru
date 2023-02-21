<?php


namespace Palladiumlab\Price;


use Bitrix\Catalog\PriceTable;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;

class PriceProduct
{
	public static function getMinPriceOfProduct(int $productId)
	{
		$minPrice=0;
		try
		{
			$allProductPrices = PriceTable::getList([
				"select" => ["*"],
				"filter" => [
					"=PRODUCT_ID" => $productId,
				],
				"order"  => ["CATALOG_GROUP_ID" => "ASC"]
			])->fetchCollection();
			foreach ($allProductPrices as $obj)
			{
				$price = $obj->getPrice();
				if($minPrice===0)
					$minPrice=$price;
				elseif($price <$minPrice) {
					$minPrice=$price;
				}
			}

		} catch (ObjectPropertyException $e)
		{
			echo $e;
		} catch (ArgumentException $e)
		{
			echo $e;

		} catch (SystemException $e)
		{
			echo $e;
		}
		return $minPrice;
	}
}