<?php


namespace Palladiumlab\Catalog;
use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\ORM\Query;
use Palladiumlab\DetailUrl\ExtenderHelper;

class CatalogProducts
{
	public function get($id)
	{
		if(empty($id))
			return null;
		$elementEntity = ElementTable::getEntity();
		ExtenderHelper::extendPathFields($elementEntity);
		$ret = (new Query($elementEntity))->setSelect(
			["NAME",
			 "ID",
			 "PREVIEW_PICTURE",
			 'DETAIL_PAGE_URL']
		)->where('IBLOCK_ID',IBLOCK_CATALOG_ID)->where('ACTIVE','Y')->
		whereIn('ID',$id)->exec();

//		$ret =  \Bitrix\Iblock\Elements\ElementCatalogTable::getList([
//				"select" => [
//					"NAME",
//					"ID",
//					"PREVIEW_PICTURE",
//					'DETAIL_PAGE_URL',
//					'IBLOCK_SECTION_ID',
//					'IBLOCK_ID',
//					'CODE'
//				],
//				"filter" => ["id" => $id]
//			])->fetch();
//		var_dump($ret);
//		$ret [ 'DETAIL_PAGE_URL' ] = \CIBlock::ReplaceDetailUrl( $ret [ 'DETAIL_PAGE_URL' ],  $ret ,  false ,  'E' );
//		var_dump($ret);
		return $ret->fetchAll();
	}

}