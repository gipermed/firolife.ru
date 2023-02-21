<?php


namespace Palladiumlab\Deploy\Constants\Dumper;


use CForm;
use Exception;

class WebFormDumper implements Dumper
{
    public function dump(): ?array
    {
        try {
            $result = false;
            if (modules('form')) {
                $result = [];

                $by = 's_id';
                $order = 'asc';

                $list = CForm::GetList($by, $order, [], $isFiltered);
                while ($item = $list->fetch()) {
                    $result[] = [
                        'name' => $item['SID'],
                        'code' => 'WEBFORM_' . mb_strtoupper($item['SID']) . '_ID',
                        'id' => $item['ID'],
                    ];
                    $result[] = [
                        'name' => $item['SID'],
                        'code' => 'WEBFORM_' . mb_strtoupper($item['SID']) . '_SID',
                        'id' => '"' . $item['SID'] . '"',
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
        return 'web_form';
    }

    public function blockTitle(): string
    {
        return 'Константы Web Form';
    }

    public function itemTitle(array $constant): string
    {
        return "Web-форма {$constant['name']}";
    }
}