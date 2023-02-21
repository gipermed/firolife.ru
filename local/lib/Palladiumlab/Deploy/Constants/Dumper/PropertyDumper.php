<?php


namespace Palladiumlab\Deploy\Constants\Dumper;


use Bitrix\Iblock\PropertyTable;
use Exception;
const IBLOCK =  37;
class PropertyDumper implements Dumper
{

	public function dump(): ?array
	{
		try {
			$result = false;
			if (modules('iblock')) {
				$result = [];
				$list = PropertyTable::getList([
					'order' => ['ID' => 'ASC'],
					'filter'=>['iblock_id' => IBLOCK]
				]);
				while ($item = $list->fetch()) {
					if (!empty($item['CODE'])) {
						$result[] = [
							'name' => $item['NAME'],
							'code' => 'PROPERTY_' . str_replace('-', '_', strtoupper($item['CODE'])) . '_ID',
							'id' => $item['ID'],
							'iblock_id' => $item['IBLOCK_ID'],
						];
					}
				}
			}
			return $result;
		} catch (Exception $e) {
			return null;
		}
	}

	public function key(): string
	{
		return 'id';
	}


	public function blockTitle(): string
	{
		return 'Константы свойств инфоблоков';
	}

	public function itemTitle(array $constant): string
	{
		return "Инфоблок {$constant['iblock_id']}}";
	}
}