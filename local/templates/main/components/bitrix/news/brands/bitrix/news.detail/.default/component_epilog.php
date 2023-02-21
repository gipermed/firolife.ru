<?php check_prolog();

use Palladiumlab\Bitrix\ViewCounter;

/**
 * @var array $arResult
 */

(new ViewCounter($arResult['ID'], $arResult['IBLOCK_ID']))->increment();
