<?
use Bitrix\Main\Loader;
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */
use \Bitrix\Main\Config\Option;

$arParams["USE_CAPTCHA"] = (($arParams["USE_CAPTCHA"] != "N" && !$USER->IsAuthorized()) ? "Y" : "N");

$arResult['JS_OBJECT'] = $arParams;
if($arParams['ARFIELDS']){
    foreach($arParams['ARFIELDS'] as $key=>$field){
        $arResult['FIELDS'][$field]['CODE'] = $field;
        foreach($arParams['REQUEST_ARFIELDS'] as $request){
            if($field==$request){
                $arResult['FIELDS'][$field]['REQUIRED'] = 'Y';
            }
        }
    }
    $arResult['JS_OBJECT']['FIELDS'] = $arResult['FIELDS'];
    $arResult['JS_OBJECT']['SUCCESS_MESSAGE'] = $arParams['SUCCESS_MESSAGE'];
	$arResult['JS_OBJECT']['SUCCESS_MESSAGE_TITLE'] = $arParams['SUCCESS_MESSAGE_TITLE'];
    $arResult['JS_OBJECT']['AJAX_PATH'] = (!empty($arParams['AJAX_PATH'])) ? $componentPath.'/customAjax/'.$arParams['AJAX_PATH'] : $componentPath.'/ajax.php';
}
$arResult['JS_OBJECT']['PRESENT'] = $arParams['PRESENT'];
if($arParams['ELEMENT_ID'] && $arParams['LINK_ELEMENT_IBLOCK']){
	CModule::IncludeModule('iblock');
    $arSelect = Array("ID", "NAME");
    $arFilter = Array("IBLOCK_ID" => $arParams['LINK_ELEMENT_IBLOCK'], "ID" => $arParams['ELEMENT_ID'], "ACTIVE"=>"Y");
    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
    while($ob = $res->Fetch()){
        $arResult['JS_OBJECT']['FIELDS']['ELEMENT_NAME'] = $ob['NAME'];
    }
}
if($arResult['JS_OBJECT']['GOAL_METRIKA']){
    if($yacounter_id = Option::get($arParams['PRYMERY_MODULE_ID'], 'PR_YA_METRIKA_ID', "", SITE_ID)){
        $arResult['JS_OBJECT']['YA_COUNTER_ID'] = $yacounter_id;
    }else{
        unset($arResult['JS_OBJECT']['GOAL_METRIKA']);
        $arResult['ERROR_COUNTERS_ID'] = GetMessage('ERROR_COUNTERS_ID');
    }
}

if($arParams["USE_CAPTCHA"] == "Y")
    $arResult["capCode"] =  htmlspecialcharsbx($APPLICATION->CaptchaGetCode());

if($arParams['SAVE'] == 'Y' && !empty($arParams['LEAD_IBLOCK'])){
    $arResult['JS_OBJECT']['SAVE'] = 'Y';
    $arResult['JS_OBJECT']['TITLE'] = $arParams['TITLE'];
    $arResult['JS_OBJECT']['LEAD_IBLOCK'] = $arParams['LEAD_IBLOCK'];
    $arResult['JS_OBJECT']['STORE_ID'] = $arParams['STORE_ID'];
}

$this->IncludeComponentTemplate();
?>