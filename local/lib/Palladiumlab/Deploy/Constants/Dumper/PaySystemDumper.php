<?php


namespace Palladiumlab\Deploy\Constants\Dumper;


use Bitrix\Sale\Internals\PaySystemActionTable;
use Exception;

class PaySystemDumper implements Dumper
{
    public function dump(): ?array
    {
        try {
            $result = false;
            if (modules('sale')) {
                $result = [];
                $list = PaySystemActionTable::getList([
                    'filter' => ['!XML_ID' => null],
                    'order' => ['ID' => 'ASC']
                ]);
                while ($item = $list->fetch()) {
                    if (!empty($item['CODE']) && !empty($item['PAY_SYSTEM_ID'])) {
                        $result[] = [
                            'name' => $item['CODE'],
                            'code' => 'PAY_SYSTEM_' . mb_strtoupper($item['CODE']) . '_ID',
                            'id' => $item['PAY_SYSTEM_ID'],
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
        return 'pay_system';
    }

    public function blockTitle(): string
    {
        return 'Константы платёжных систем';
    }

    public function itemTitle(array $constant): string
    {
        return "Платёжная система {$constant['name']}";
    }
}