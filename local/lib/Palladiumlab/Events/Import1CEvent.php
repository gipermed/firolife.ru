<?php


namespace Palladiumlab\Events;


class Import1CEvent
{
	// создаем обработчик события "OnAfterIBlockElementAdd"
	public static function BeforeUpdateAddHandler(&$arFields)
	{
		$prop = null;
		foreach ($arFields['PROPERTY_VALUES'][PROPERTY_NAIMENOVANIE_DLYA_SAYTA_ID] as $val)
		{
			$prop = $val;
		}
		if($prop["VALUE"]===null)
			return;
		if($prop["VALUE"]==$arFields["NAME"])
			return;
		$arFields["NAME"]=$prop["VALUE"];
	}
}