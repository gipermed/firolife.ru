<?php


namespace Palladiumlab\Deploy\Constants\Dumper;


use Bitrix\Catalog\GroupTable;
use Exception;

class PriceDumper implements Dumper
{
    public function dump(): ?array
    {
        try {
            $result = false;
            if (modules('sale')) {
                $result = [];
                $list = GroupTable::getList([
                    'order' => ['ID' => 'ASC']
                ]);
                while ($item = $list->fetch()) {
                    $code = get_transliterate($item['NAME'], [
                        "change_case" => 'U', // 'L' - toLower, 'U' - toUpper, false - do not change
                        "replace_space" => '_',
                        "replace_other" => '_',
                    ]);

                    $result[] = [
                        'name' => $item['NAME'],
                        'code' => 'PRICE_' . $code . '_ID',
                        'id' => $item['ID'],
                    ];
                    $result[] = [
                        'type' => 'name',
                        'name' => $item['NAME'],
                        'code' => 'PRICE_' . $code . '_CODE',
                        'id' => '"' . $item['NAME'] . '"',
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
        return 'price';
    }

    public function blockTitle(): string
    {
        return 'Константы типов цен';
    }

    public function itemTitle(array $constant): string
    {
        if ($constant['type'] === 'name') {
            return "Код цены {$constant['name']}";
        }

        return "Тип цены {$constant['name']}";
    }
}