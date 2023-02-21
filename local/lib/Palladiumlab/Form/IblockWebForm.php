<?php


namespace Palladiumlab\Form;


use Bitrix\Iblock\IblockTable;
use Bitrix\Iblock\PropertyTable;
use Bitrix\Main\Error;
use Bitrix\Main\Mail\Event;
use Bitrix\Main\Mail\Internal\EventMessageTable;
use Bitrix\Main\Result;
use Bitrix\Main\Type\DateTime;
use Carbon\Carbon;
use CIBlockElement;
use Palladiumlab\Support\Util\Arr;

class IblockWebForm
{
    public const EMAIL_CODE_TEMPLATE = 'WEB_FORM_#IBLOCK_CODE#_EMAIL';

    public static array $additionalEmailEvents;

    public static function addEmailTemplate(int $iblockId, string $eventCode): void
    {
        static::$additionalEmailEvents[$iblockId][] = $eventCode;
    }

    public static function create(int $iblockId, array $fields): Result
    {
        $result = new Result();

        $element = new CIBlockElement();

        $currentResultsCount = (int)CIBlockElement::getList([], ['IBLOCK_ID' => $iblockId], []);

        $elementId = (int)$element->add([
            'ACTIVE' => 'Y',
            'NAME' => 'Form result #' . ++$currentResultsCount,
            'IBLOCK_ID' => $iblockId,

            'PROPERTY_VALUES' => self::makeProperties($iblockId, $fields)
        ]);

        if (!empty($element->LAST_ERROR)) {
            return $result->addError(new Error(strip_tags($element->LAST_ERROR)));
        }

        $result->setData(['ELEMENT_ID' => $elementId]);

        self::sendEmail($iblockId, $fields);

        return $result;
    }

    protected static function makeProperties(int $iblockId, array $fields): array
    {
        $elementProperties = [];
        /** @noinspection PhpUnhandledExceptionInspection */
        $properties = Arr::combineKeys(PropertyTable::getList([
            'filter' => [
                '=IBLOCK_ID' => $iblockId,
                '=ACTIVE' => 'Y',
                '=CODE' => array_keys($fields),
            ]
        ])->fetchAll(), 'CODE');

        foreach ($properties as $code => $property) {
            $value = $fields[$code];

            if ($value === null) {
                continue;
            }

            if ($property['PROPERTY_TYPE'] === PropertyTable::TYPE_STRING) {
                switch ($property['USER_TYPE']) {
                    case 'Date':
                    case 'DateTime':
                        $elementProperties[$code] = DateTime::createFromTimestamp(Carbon::parse($value)->timestamp);
                        break;
                    case 'HTML':
                        $elementProperties[$code] = ['VALUE' => ['TYPE' => 'TEXT', 'TEXT' => $value]];
                        break;
                    default:
                        $elementProperties[$code] = $value;
                }
            }

            if ($property['PROPERTY_TYPE'] === PropertyTable::TYPE_FILE) {
                ksort($value);

                if ($property['MULTIPLE'] !== 'Y') {
                    $fileValue = [
                        'VALUE' => $value,
                        'DESCRIPTION' => '',
                    ];
                } else {
                    $fileValue = [];
                    foreach ($value['error'] as $k => $v) {
                        if (!$v) {
                            $fileValue[] = [
                                'VALUE' => array_combine(array_keys($value), array_column($value, $k)),
                                'DESCRIPTION' => '',
                            ];
                        }
                    }
                }

                $elementProperties[$code] = $fileValue;
            }
        }

        return $elementProperties;
    }

    protected static function sendEmail(int $iblockId, array $fields): void
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $iblockCode = strtoupper(IblockTable::getRowById($iblockId)['CODE']);

        $eventName = str_replace('#IBLOCK_CODE#', $iblockCode, self::EMAIL_CODE_TEMPLATE);

        $emailEvents = array_unique(array_merge(static::$additionalEmailEvents[$iblockId] ?? [], [$eventName]));

        foreach ($emailEvents as $emailEvent) {
            /** @noinspection PhpUnhandledExceptionInspection */
            /** @noinspection PhpMultipleClassDeclarationsInspection */
            $isEventExists = EventMessageTable::getCount(['EVENT_NAME' => $emailEvent]) > 0;

            $isEventExists && Event::send([
                'EVENT_NAME' => $emailEvent,
                'LID' => SITE_ID,
                'C_FIELDS' => $fields,
            ]);
        }
    }
}