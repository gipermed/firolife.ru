<?php


namespace Palladiumlab\Deploy\Constants\Dumper;


use Bitrix\Sale\Delivery\Services\Table as DeliveryServiceTable;
use Exception;

class DeliveryServiceDumper implements Dumper
{
    public function dump(): ?array
    {
        try {
            $result = false;
            if (modules('sale')) {
                $result = [];
                $list = DeliveryServiceTable::getList([
                    'filter' => ['!XML_ID' => null],
                    'order' => ['ID' => 'ASC']
                ]);
                while ($item = $list->fetch()) {
                    if (!empty($item['XML_ID'])) {
                        $result[] = [
                            'name' => $item['XML_ID'],
                            'code' => 'DELIVERY_SERVICE_' . mb_strtoupper($item['XML_ID']) . '_ID',
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
        return 'delivery_service';
    }

    public function blockTitle(): string
    {
        return 'Константы типов доставки';
    }

    public function itemTitle(array $constant): string
    {
        return "Тип доставки {$constant['name']}";
    }
}