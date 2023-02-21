<?php


namespace Palladiumlab\Bitrix\Sale;

use Bitrix\Main\Error;
use Bitrix\Main\Result;
use Bitrix\Sale;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Order extends Sale\Order
{
    public function getPropertyValue(string $code, $defaultValue = null)
    {
        if ($property = $this->getProperty(Str::upper($code))) {
            return $property->getValue() ?? $defaultValue;
        }

        return $defaultValue;
    }

    public function getProperty(string $code): ?Sale\PropertyValueBase
    {
        try {
            $propertyCollection = $this->getPropertyCollection();
        } catch (Exception $e) {
            return null;
        }

        return $propertyCollection->getItemByOrderPropertyCode(Str::upper($code));
    }

    /**
     * @param $name
     * @return mixed|string|null
     */
    public function getField($name)
    {
        return parent::getField(Str::upper($name));
    }

    public function setPropertyValue(string $code, string $value): Result
    {
        $code = Str::upper($code);

        $result = new Result();

        if (Str::upper($value) === 'Y') {
            $value = 'Y';
        }
        if (Str::upper($value) === 'N') {
            $value = 'N';
        }

        $property = $this->getProperty($code);

        if ($property) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $property->setValue($value);
        } else {
            $result->addError(new Error("Property with code \"{$code}\" not found"));
        }

        return $result;
    }

    public function getPropertyValues(): array
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return Arr::pluck($this->getPropertyCollection()->getArray()['properties'], 'VALUE.0', 'CODE');
    }
}
