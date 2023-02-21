<?
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
if(!CModule::IncludeModule("highloadblock"))
    return;
//GetList
?>

<?php
//echo 'Данные приняты - '. $_POST['arr'];

//echo '<pre>';
//print_r($_POST['arr']);
//echo '</pre>';

global $USER;
CModule::IncludeModule('sale');

use Bitrix\Highloadblock as HL;

$hlbl = 3; // Указываем ID нашего highloadblock блока к которому будет делать запросы.
$hlblock = HL\HighloadBlockTable::getById($hlbl)->fetch();

$entity = HL\HighloadBlockTable::compileEntity($hlblock);
$entity_data_class = $entity->getDataClass();

if($_POST['action'] == "del")
    $entity_data_class::Delete($_POST['arr']);

if($_POST['action'] == "new") {
    if($_POST['arr'][0]){
        $arLocs = CSaleLocation::GetByID($_POST['arr'][0], LANGUAGE_ID);

        $arLocs2 = CSaleLocation::GetLocationZIP($_POST['arr'][0]);
        $arLocs2 = $arLocs2->Fetch();
    }
    if($_POST['arr'][7]){
        if($_POST['arr'][7] != 'other'){
            $res = \Bitrix\Sale\Location\LocationTable::getList(array(
                'filter' => array('ID' => $_POST['arr'][7], '=NAME.LANGUAGE_ID' => LANGUAGE_ID),
                'select' => array('NAME_RU' => 'NAME.NAME')
            ));
            while ($item = $res->fetch()) {
                $arStreet = $item;
            }
        }else{
            $arStreet['NAME_RU'] = $_POST['arr'][8];
        }
    }
// Массив полей для добавления
    $data = array(
        "UF_CODE" => $_POST['arr'][0],
        "UF_INDEX" => $arLocs2['ZIP'],
        "UF_REGION" => $_POST['arr'][2],
        "UF_TYPE_ADR" => $_POST['arr'][3],
        "UF_CITY" => $arLocs['CITY_NAME'],
        "UF_COMENT" => $_POST['arr'][5],
        "UF_MAINADR" => $_POST['arr'][6],
        "UF_KVARTIRA" => $_POST['arr'][12],
        "UF_FLOOR" => $_POST['arr'][13],
        "UF_STROENIE" => $_POST['arr'][11],
        "UF_KORPUS" => $_POST['arr'][10],
        "UF_HOME" => $_POST['arr'][9],
        "UF_STREET" => $arStreet['NAME_RU'],
        "UF_STREET_CODE" => $_POST['arr'][7],
        "UF_ID_USER" => $USER->GetID()
    );
    $result = $entity_data_class::add($data);
    echo $result;
}

if($_POST['action'] == "edit") {
    if($_POST['arr'][0]){
        $arLocs = CSaleLocation::GetByID($_POST['arr'][0], LANGUAGE_ID);

        $arLocs2 = CSaleLocation::GetLocationZIP($_POST['arr'][0]);
        $arLocs2 = $arLocs2->Fetch();
    }
    if($_POST['arr'][7]){
        if($_POST['arr'][7] != 'other'){
            $res = \Bitrix\Sale\Location\LocationTable::getList(array(
                'filter' => array('ID' => $_POST['arr'][7], '=NAME.LANGUAGE_ID' => LANGUAGE_ID),
                'select' => array('NAME_RU' => 'NAME.NAME')
            ));
            while ($item = $res->fetch()) {
                $arStreet = $item;
            }
        }else{
            $arStreet['NAME_RU'] = $_POST['arr'][13];
        }
    }
// Массив полей для добавления
    $data = array(
        "UF_TYPE_ADR" => $_POST['arr'][3],
        "UF_CITY" => $arLocs['CITY_NAME'],
        "UF_COMENT" => $_POST['arr'][5],
        "UF_STROENIE" => $_POST['arr'][8],
        "UF_KVARTIRA" => $_POST['arr'][9],
        "UF_KORPUS" => $_POST['arr'][10],
        "UF_HOME" => $_POST['arr'][11],
        "UF_FLOOR" => $_POST['arr'][13],
        "UF_INDEX" => $arLocs2['ZIP'],
        "UF_STREET" => $arStreet['NAME_RU'],
        "UF_STREET_CODE" => $_POST['arr'][7],
        "UF_ID_USER" => $USER->GetID(),
        "UF_CODE" => $_POST['arr'][0],
    );
    $result = $entity_data_class::update($_POST['arr'][12], $data);
}
?>
