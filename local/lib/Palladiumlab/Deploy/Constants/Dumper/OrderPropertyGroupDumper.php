<?php


namespace Palladiumlab\Deploy\Constants\Dumper;


use Bitrix\Sale\Internals\OrderPropsGroupTable;
use Exception;

class OrderPropertyGroupDumper implements Dumper
{
    public function dump(): ?array
    {
        try {
            $result = false;
            if (modules('sale')) {
                $result = [];
                $list = OrderPropsGroupTable::getList([
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
                        'code' => 'ORDER_PROPERTY_GROUP_' . $code . '_ID',
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
        return 'order_property_group';
    }

    public function blockTitle(): string
    {
        return 'Константы групп свойств заказа';
    }

    public function itemTitle(array $constant): string
    {
        return "Группа заказа {$constant['name']}";
    }
}