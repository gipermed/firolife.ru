<?php


namespace Palladiumlab\Bitrix\Sale;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\NotImplementedException;
use Bitrix\Main\ObjectNotFoundException;
use Bitrix\Sale;
use Illuminate\Support\Str;

class BasketItem extends Sale\BasketItem
{
    public function getField($name)
    {
        return parent::getField(Str::upper($name));
    }

    /**
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws NotImplementedException
     * @throws ObjectNotFoundException
     */
    public function getPropertyValue(string $code, $default = null)
    {
        $propertyCollection = $this->getPropertyCollection();

        if (!$propertyCollection) {
            return $default;
        }

        return $propertyCollection->getPropertyValues()[$code]['VALUE'] ?? $default;
    }
}