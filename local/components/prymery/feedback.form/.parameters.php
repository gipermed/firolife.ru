<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arCurrentValues */
use Bitrix\Main\Loader;
use Bitrix\Iblock;

if (!Loader::includeModule('iblock'))
    return;

$arIBlockTypes = CIBlockParameters::GetIBlockTypes();

$arIBlocks = array();
$arIBlocksType = array();
$rsIBlocks = CIBlock::GetList(array("sort" => "asc"), array("ACTIVE" => "Y"));
while ($arIBlock = $rsIBlocks->Fetch()){
    if($arIBlock["IBLOCK_TYPE_ID"] == $arCurrentValues["IBLOCK_TYPE"])
        $arIBlocksType[$arIBlock["ID"]] = "[" . $arIBlock["ID"] . "] " . $arIBlock["NAME"];
    $arIBlocks[$arIBlock["ID"]] = "[" . $arIBlock["ID"] . "] " . $arIBlock["NAME"];

}

$arFields = array("NAME" => GetMessage("PRYMERY_FF_FIELD_NAME"),"EMAIL" => GetMessage("PRYMERY_FF_FIELD_EMAIL"),"PHONE" => GetMessage("PRYMERY_FF_FIELD_PHONE"),
    "MESSAGE" => GetMessage("PRYMERY_FF_FIELD_MESSAGE"),"RATING" => GetMessage("PRYMERY_FF_FIELD_RATING"));
$arComponentParameters = array(
    "PARAMETERS" => array(
        "TITLE" => Array(
            "PARENT" => "ADDITIONAL_SETTINGS",
            "NAME" => GetMessage("PRYMERY_FF_TITLE"),
            "TYPE" => "STRING",
            "DEFAULT" => ""
        ),
        "SUBTITLE" => Array(
            "PARENT" => "ADDITIONAL_SETTINGS",
            "NAME" => GetMessage("PRYMERY_FF_SUBTITLE"),
            "TYPE" => "STRING",
            "DEFAULT" => ""
        ),
        'ARFIELDS' => array(
            'GROUP' => 'ADDITIONAL_SETTINGS',
            'NAME' => GetMessage("PRYMERY_FF_ARFIELDS"),
            'TYPE' => 'LIST',
            'VALUES' => $arFields,
            "MULTIPLE" => "Y",
        ),
        'REQUEST_ARFIELDS' => array(
            'GROUP' => 'ADDITIONAL_SETTINGS',
            'NAME' => GetMessage("PRYMERY_FF_REQUEST_ARFIELDS"),
            'TYPE' => 'LIST',
            "MULTIPLE" => "Y",
            'VALUES' => $arFields,
        ),
        "EMAIL_TO" => Array(
            "PARENT" => "ADDITIONAL_SETTINGS",
            "NAME" => GetMessage("PRYMERY_FF_EMAIL_TO"),
            "TYPE" => "STRING",
            "DEFAULT" => ""
        ),
        "BUTTON" => Array(
            "PARENT" => "ADDITIONAL_SETTINGS",
            "NAME" => GetMessage("PRYMERY_FF_BUTTON"),
            "TYPE" => "STRING",
            "DEFAULT" => ""
        ),
        "SUCCESS_MESSAGE" => Array(
            "PARENT" => "ADDITIONAL_SETTINGS",
            "NAME" => GetMessage("PRYMERY_FF_SUCCESS_MESSAGE"),
            "TYPE" => "STRING",
            "DEFAULT" => ""
        ),
        "GOAL_METRIKA" => Array(
            "PARENT" => "ADDITIONAL_SETTINGS",
            "NAME" => GetMessage("PRYMERY_FF_GOAL_METRIKA"),
            "TYPE" => "STRING",
            "DEFAULT" => ""
        ),
        "GOAL_ANALITICS" => Array(
            "PARENT" => "ADDITIONAL_SETTINGS",
            "NAME" => GetMessage("PRYMERY_FF_GOAL_ANALITICS"),
            "TYPE" => "STRING",
            "DEFAULT" => ""
        ),
        "PERSONAL_DATA" => Array(
            "PARENT" => "ADDITIONAL_SETTINGS",
            "NAME" => GetMessage("PRYMERY_FF_PERSONAL_DATA"),
            "TYPE" => "CHECKBOX",
            "REFRESH" => "Y",
            "DEFAULT" => "N"
        ),
        "AJAX_PATH" => Array(
            "PARENT" => "ADDITIONAL_SETTINGS",
            "NAME" => GetMessage("PRYMERY_FF_AJAX_PATH"),
            "TYPE" => "STRING",
            "DEFAULT" => ""
        ),
        "USE_CAPTCHA" => Array(
            "PARENT" => "ADDITIONAL_SETTINGS",
            "NAME" => GetMessage("PRYMERY_FF_USE_CAPTCHA"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N"
        ),
        "SAVE" => Array(
            "PARENT" => "ADDITIONAL_SETTINGS",
            "NAME" => GetMessage("PRYMERY_FF_SAVE"),
            "TYPE" => "CHECKBOX",
            "REFRESH" => "Y",
            "DEFAULT" => "N"
        ),
        "LINK_ELEMENT_IBLOCK" => Array(
            "PARENT" => "ADDITIONAL_SETTINGS",
            "NAME" => GetMessage("PRYMERY_FF_LINK_ELEMENT_IBLOCK"),
            "TYPE" => "LIST",
            "ADDITIONAL_VALUES" => "Y",
            "VALUES" => $arIBlocks
        ),
    )
);
if ($arCurrentValues['SAVE'] == 'Y')
    $arComponentParameters['PARAMETERS']['LEAD_IBLOCK'] = array(
        "PARENT" => "ADDITIONAL_SETTINGS",
        "NAME" => GetMessage("PRYMERY_FF_LEAD_IBLOCK"),
        "TYPE" => "LIST",
        "ADDITIONAL_VALUES" => "Y",
        "VALUES" => $arIBlocks
    );
if ($arCurrentValues['PERSONAL_DATA'] == 'Y')
    $arComponentParameters['PARAMETERS']['PERSONAL_DATA_PAGE'] = array(
        "PARENT" => "ADDITIONAL_SETTINGS",
        "NAME" => GetMessage("PRYMERY_FF_PERSONAL_DATA_PAGE"),
        "TYPE" => "STRING",
    );
if ($arCurrentValues['MODAL'] == 'Y')
    $arComponentParameters['PARAMETERS']['MODAL_LINK_TEXT'] = array(
        "PARENT" => "ADDITIONAL_SETTINGS",
        "NAME" => GetMessage("PRYMERY_FF_MODAL_LINK_TEXT"),
        "TYPE" => "STRING",
        "DEFAULT" => "Обратная связь"
    );
?>