<?php


namespace Palladiumlab\Deploy\Constants\Dumper;


use Bitrix\Iblock\IblockTable;
use Exception;

class IblockDumper implements Dumper
{
    public function dump(): ?array
    {
        try {
            $result = false;
            if (modules('iblock')) {
                $result = [];
                $list = IblockTable::getList([
                    'order' => ['ID' => 'ASC']
                ]);
                while ($item = $list->fetch()) {
                    if (!empty($item['CODE'])) {
                        $result[] = [
                            'name' => $item['NAME'],
                            'site_id' => $item['LID'],
                            'code' => 'IBLOCK_' . str_replace('-', '_', strtoupper($item['CODE'])) . '_ID',
                            'id' => $item['ID'],
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
        return 'iblock';
    }


    public function blockTitle(): string
    {
        return 'Константы инфоблоков';
    }

    public function itemTitle(array $constant): string
    {
        return "Инфоблок {$constant['name']}, Сайт: {$constant['site_id']}";
    }
}