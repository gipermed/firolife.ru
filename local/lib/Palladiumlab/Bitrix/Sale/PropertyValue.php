<?php


namespace Palladiumlab\Bitrix\Sale;


use \Bitrix\Sale;


class PropertyValue extends Sale\PropertyValue
{
    public function getCode(): ?string
    {
        return $this->getField('CODE');
    }
}