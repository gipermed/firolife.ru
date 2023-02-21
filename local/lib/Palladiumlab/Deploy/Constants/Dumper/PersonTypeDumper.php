<?php


namespace Palladiumlab\Deploy\Constants\Dumper;


use Bitrix\Sale\Internals\PersonTypeTable;
use Exception;

class PersonTypeDumper implements Dumper
{
    public function dump(): ?array
    {
        try {
            $result = false;
            if (modules('sale')) {
                $result = [];
                $list = PersonTypeTable::getList([
                    'filter' => ['!CODE' => null],
                    'order' => ['ID' => 'ASC']
                ]);
                while ($item = $list->fetch()) {
                    $result[] = [
                        'name' => $item['NAME'],
                        'code' => 'PERSON_TYPE_' . mb_strtoupper($item['CODE']) . '_ID',
                        'id' => (int)$item['ID'],
                    ];
                }
            }
            return $result;
        } catch (Exception $e) {
            return null;
        }
    }

    public function key(): string
    {
        return 'person_type';
    }

    public function blockTitle(): string
    {
        return 'Константы типов плательщика';
    }

    public function itemTitle(array $constant): string
    {
        return "Тип плательщика {$constant['name']}";
    }
}