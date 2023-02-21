<?php


namespace Palladiumlab\Basket;

use Bitrix\Iblock\Element;
use Bitrix\Main\Entity\ReferenceField;
use Bitrix\Main\Loader;
use Illuminate\Support\Collection;
use Palladiumlab\Photo\PhotoModel;

class ProductLinkElement
{
	/**
	 * @param array $arIdsProducts
	 * @param array $arParams
	 * @return PhotoModel[]
	 * @throws \Bitrix\Main\ArgumentException
	 * @throws \Bitrix\Main\LoaderException
	 * @throws \Bitrix\Main\SystemException
	 */
	static function getPhotoElement(array $arIdsProducts, array $arParams): Collection
	{
		Loader::includeModule('iblock');
		$sql = [
			'select'  => [
				'SKU_LINK_ID_' => 'SKU_LINK_ID',
				'MORE_PHOTO.FILE'
			],
			'runtime' => [
				new ReferenceField('CML2_LINK', 'Bitrix\Iblock\PropertyTable', [
					"=ref.CODE" => new \Bitrix\Main\DB\SqlExpression('?', 'CML2_LINK'),
				], ["join_type" => "left"]),
				new ReferenceField('SKU_LINK_ID', '\Bitrix\Iblock\ElementPropertyTable', [
					"=this.ID"           => "ref.VALUE",
					"=this.CML2_LINK.ID" => "ref.IBLOCK_PROPERTY_ID",
				], ["join_type" => "inner"]),
				new ReferenceField('SKU_ITEM', '\Bitrix\Iblock\ElementTable', [
					"=this.SKU_LINK_ID.IBLOCK_ELEMENT_ID" => "ref.ID",
				], ["join_type" => "left"])
			],
			'order'   => ['ID' => 'ASC'],
			'filter'  => [
				"IBLOCK_ID"                     => IBLOCK_CATALOG_ID,
				"SKU_LINK_ID_IBLOCK_ELEMENT_ID" => $arIdsProducts
			],
			'cache'   => ($arParams["CACHE_TYPE"] != "N" ? [
				"ttl"         => $arParams["CACHE_TIME"],
				"cache_joins" => true
			] : null),
		];
		$iterator = \Bitrix\Iblock\Elements\ElementCatalogTable::getList($sql);
		$skuPictures = new Collection($iterator->fetchAll());
		$skuPictures = $skuPictures->mapToGroups(fn($value) => [
			$value["SKU_LINK_ID_IBLOCK_ELEMENT_ID"] => new PhotoModel($value['IBLOCK_ELEMENTS_ELEMENT_CATALOG_MORE_PHOTO_FILE_DESCRIPTION'], $value["IBLOCK_ELEMENTS_ELEMENT_CATALOG_MORE_PHOTO_FILE_ID"])
		]);

//		while ($elem = $iterator->fetch())
//		{
//			$newPhoto = new PhotoModel($elem['IBLOCK_ELEMENTS_ELEMENT_CATALOG_MORE_PHOTO_FILE_DESCRIPTION'],
//				$elem["IBLOCK_ELEMENTS_ELEMENT_CATALOG_MORE_PHOTO_FILE_ID"]);
//			//$skuPictures->map(fn($item,$key)=>new Collection($item,$newPhoto));
//			$coll = $skuPictures->get($elem['SKU_LINK_ID_IBLOCK_ELEMENT_ID'],fn()=>new Collection());
//
//			$newColl=$coll->push($newPhoto);
//			$skuPictures->put($elem['SKU_LINK_ID_IBLOCK_ELEMENT_ID'],$newColl);
//		}
		return $skuPictures;
	}
}