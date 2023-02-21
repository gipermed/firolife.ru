<?php


namespace Palladiumlab\Deploy\Constants\Dumper;


use Bitrix\Highloadblock\HighloadBlockTable;
use Exception;

class HighloadBlockDumper implements Dumper
{
    public function dump(): ?array
    {
        try {
            $result = false;
            if (modules('highloadblock')) {
                $result = [];
                $list = HighloadBlockTable::getList([
                    'order' => ['ID' => 'ASC']
                ]);
                while ($item = $list->fetch()) {
                    $result[] = [
                        'name' => $item['NAME'],
                        'code' => 'HLBLOCK_' . mb_strtoupper($item['NAME']) . '_ID',
                        'id' => $item['ID'],
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
        return 'highloadblock';
    }

    public function blockTitle(): string
    {
        return 'Константы highload-блоков';
    }

    public function itemTitle(array $constant): string
    {
        return "Highload-блок {$constant['name']}";
    }
}