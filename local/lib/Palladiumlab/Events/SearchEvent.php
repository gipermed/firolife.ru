<?php


namespace Palladiumlab\Events;


use CIBlockElement;
use Palladiumlab\Support\Bitrix\Resource;
use Palladiumlab\Support\Util\Str;

class SearchEvent
{
    public static function index(array $fields): array
    {
        if (
            $fields['MODULE_ID'] === 'iblock'
            && (int)$fields['PARAM2'] === CATALOG_ID
            && array_key_exists('BODY', $fields)
            && !Str::startsWith($fields['ITEM_ID'], 'S')
        ) {
            $elementId = (int)$fields['ITEM_ID'];

            $section = \CIBlockSection::GetList([], [
                'IBLOCK_ID' => CATALOG_ID,
                'HAS_ELEMENT' => $elementId,
            ], false, [
                'NAME'
            ])->fetch();

            $offers = (new Resource(
                CIBlockElement::getList([], [
                    'IBLOCK_ID' => IBLOCK_CATALOG_TP_ID,
                    'PROPERTY_CML2_LINK' => $elementId,
                ], false, false, [
                    'PROPERTY_ARTICLE'
                ])
            ))->toArray();

            $fields['BODY'] = trim($fields['BODY']);

            $fields['BODY'] .= ' ' . implode(' ', array_column($offers, 'PROPERTY_ARTICLE_VALUE'));
            $fields['BODY'] .= ' ' . $section['NAME'];
        }

        return $fields;
    }
}