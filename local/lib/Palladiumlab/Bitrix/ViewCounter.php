<?php


namespace Palladiumlab\Bitrix;


use Bitrix\Iblock\ElementTable;
use CIBlockElement;
use Palladiumlab\Support\Bitrix\Resource;

class ViewCounter
{
    public const PROPERTY_CODE = 'VIEW_COUNTER';

    protected int $iblockId;
    protected int $elementId;
    protected int $currentValue;

    public function __construct(int $elementId, int $iblockId)
    {
        $this->elementId = $elementId;
        $this->iblockId = $iblockId;

        $this->currentValue = $this->currentValue();
    }

    public function currentValue(): int
    {
        return (int)CIBlockElement::getList([], [
            'ID' => $this->elementId,
            'IBLOCK_ID' => $this->iblockId,
        ], false, false, [
            'PROPERTY_' . self::PROPERTY_CODE,
        ])->fetch()['PROPERTY_' . self::PROPERTY_CODE . '_VALUE'];
    }

    public static function getCurrentCounters(array $items): array
    {
        if (empty($items)) {
            return [];
        }

        /** @noinspection PhpUnhandledExceptionInspection */
        $iblocks = array_unique(array_column(ElementTable::getList([
            'filter' => ['ID' => $items],
            'select' => ['IBLOCK_ID'],
        ])->fetchAll(), 'IBLOCK_ID'));

        $counters = (new Resource(CIBlockElement::GetList([], [
            'ID' => $items,
            'IBLOCK_ID' => $iblocks,
        ], false, false, [
            'ID', 'PROPERTY_' . self::PROPERTY_CODE
        ])))->toArray();

        return array_map(static fn(array $article) => [
            'id' => $article['ID'],
            'counter' => $article['PROPERTY_' . ViewCounter::PROPERTY_CODE . '_VALUE'] ?? 0,
        ], $counters);
    }

    public function increment(): ViewCounter
    {
        return $this->update(++$this->currentValue);
    }

    protected function update(int $value): ViewCounter
    {
        CIBlockElement::setPropertyValuesEx($this->elementId, $this->iblockId, [self::PROPERTY_CODE => $value]);

        return $this;
    }

    public function decrement(): ViewCounter
    {
        return $this->update(--$this->currentValue);
    }
}