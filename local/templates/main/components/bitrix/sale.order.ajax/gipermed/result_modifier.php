<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;
/**
 * @var array $arParams
 * @var array $arResult
 * @var SaleOrderAjax $component
 */

$component = $this->__component;
$component::scaleImages($arResult['JS_DATA'], $arParams['SERVICES_IMAGES_SCALING']);

$dbResult = CCatalogStore::GetList(array('PRODUCT_ID'=>'ASC','ID' => 'ASC'), array('ACTIVE' => 'Y', '!ADDRESS'=>false), false, false, array("*"));
while($arStore = $dbResult->Fetch()){
    $arResult['STORES'][] = $arStore;
}

$hlbl = 3; // Указываем ID нашего highloadblock блока к которому будет делать запросы.
$hlblock = HL\HighloadBlockTable::getById($hlbl)->fetch();

$entity = HL\HighloadBlockTable::compileEntity($hlblock);
$entity_data_class = $entity->getDataClass();

$rsData = $entity_data_class::getList(array(
    "select" => array("*"),
    "order" => array("ID" => "ASC"),
    "filter" => array("UF_ID_USER"=>$USER->GetID())  // Задаем параметры фильтра выборки
));
while($arData = $rsData->Fetch()){
    $arResult['ADDRESS'][] = $arData;
}

CModule::IncludeModule('iblock');
$arSelect = Array("ID", "NAME", "PROPERTY_ID", 'IBLOCK_SECTION_ID');
$arFilter = Array("IBLOCK_ID"=>97, "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array('SORT'=>'ASC'), $arFilter, false, Array(), $arSelect);
while($ob = $res->Fetch()) {
    $allDeliveries[$ob['IBLOCK_SECTION_ID']][] = $ob;
}

$arFilter = Array('IBLOCK_ID'=>97, 'GLOBAL_ACTIVE'=>'Y');
$db_list = CIBlockSection::GetList(Array('SORT'=>'ASC'), $arFilter, false, array('ID','CODE','NAME','SORT','DEPTH_LEVEL','IBLOCK_SECTION_ID'));
while($ar_result = $db_list->Fetch()) {
    if($ar_result['DEPTH_LEVEL'] == 1){
        $allSections[$ar_result['ID']]['INFO'] = $ar_result;
        if($allDeliveries[$ar_result['ID']]){
            $allSections[$ar_result['ID']]['ITEMS'] = $allDeliveries[$ar_result['ID']];
        }
    }else{
        $allSections[$ar_result['IBLOCK_SECTION_ID']]['SUB'][$ar_result['ID']]['INFO'] = $ar_result;
        if($allDeliveries[$ar_result['ID']]){
            $allSections[$ar_result['IBLOCK_SECTION_ID']]['SUB'][$ar_result['ID']]['ITEMS'] = $allDeliveries[$ar_result['ID']];
        }
    }
}
if($allSections){
    $arResult['JS_SECTIONS'] = $allSections;
}