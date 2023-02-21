<?
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';
?>

<?php
global $USER;

use Bitrix\Main\Loader;
use Bitrix\Highloadblock as HL;
use \Bitrix\Main;

Bitrix\Main\Loader::includeModule('sale');
Bitrix\Main\Loader::includeModule('catalog');
Loader::includeModule("highloadblock");

if ($_POST["deliv"] == 19)
{
    $codeSdek = 0;
    $codeBitrix = 0;
    try
    {
        $connection = Main\Application::getInstance()->getConnection();
        $cityID = $_POST["cityIdPost"];
        $queryResult = $connection->query("SELECT BITRIX_ID FROM ipol_sdekcities WHERE SDEK_ID = {$cityID}");
        $item = $queryResult->fetch();
        $codeSdek = $item['BITRIX_ID'];
    }
    catch( Main\DB\SqlException $e )
    {
        var_dump($e->getMessage());
    }

    $res = \Bitrix\Sale\Location\LocationTable::getList(array(
    'filter' => array('>=TYPE.ID' => '5', '<=TYPE.ID' => '6','ID' => $codeSdek),
    'select' => array('CODE')
    ));
    $item = $res->fetch();
    $codeBitrix = $item['CODE'];
}

if ($_POST["deliv"] == 18)
{
    $pieces = explode(";", $_POST["selectreg"]);
    $hlbl = 3; // Указываем ID нашего highloadblock блока к которому будет делать запросы.
    $hlblock = HL\HighloadBlockTable::getById($hlbl)->fetch();
    $entity = HL\HighloadBlockTable::compileEntity($hlblock);
    $entity_data_class = $entity->getDataClass();
    $rsData = $entity_data_class::getList(array(
        "select" => array("*"),
        "order" => array("ID" => "ASC"),
        "filter" => array("UF_ID_USER" => $USER->GetID(),"ID"=>$_POST["adrdost"])  // Задаем параметры фильтра выборки
    ));
    $arData = $rsData->Fetch();
}

$basket = \Bitrix\Sale\Basket::loadItemsForFUser(CSaleBasket::GetBasketUserID(), SITE_ID);
$order = Bitrix\Sale\Order::create(SITE_ID, $USER->GetID());
$order->setPersonTypeId(1);
$order->setBasket($basket);

if ($_POST["deliv"] == 18)
{
    if ($_POST["delivadr"] == 3) {
        $order->setField('USER_DESCRIPTION', $_POST["comentcur"]);
    }
    if ($_POST["delivadr"] == 1) {
        $order->setField('USER_DESCRIPTION', $arData['UF_COMENT']);
    }
}

$propertyCollection = $order->getPropertyCollection();
$adressProperty = $propertyCollection->getItemByOrderPropertyId(6);
$adressPropertyIndex = $propertyCollection->getItemByOrderPropertyId(9);
$adressPropertyCityCode = $propertyCollection->getItemByOrderPropertyId(4);
$Tarif = $propertyCollection->getItemByOrderPropertyId(10);
$emailPropValue = $propertyCollection->getUserEmail();
$phonePropValue = $propertyCollection->getPhone();
$NamePropValue = $propertyCollection->getProfileName();

if ($_POST["deliv"] == 18)
{
    if ($_POST["delivadr"] == 1)
    {
        $adressProperty->setValue("ул: " . $arData['UF_STREET'] . ", дом: " . $arData['UF_HOME'] . ", кор: " . $arData['UF_KORPUS'] . ", стр: " . $arData['UF_STROENIE'] . ", кв: " . $arData['UF_KVARTIRA']);
        $adressPropertyCityCode->setValue($arData['UF_CODE']);
        $adressPropertyIndex->setValue($arData['UF_INDEX']);
    } else
    {
        $adressProperty->setValue($_POST["adres"]);
        $adressPropertyCityCode->setValue($pieces[0]);
        $adressPropertyIndex->setValue($pieces[1]);
    }
    $NamePropValue->setValue($_POST[fio]);
}

if ($_POST["deliv"] == 19)
{
    $adressProperty->setValue($_POST[addresPost]. " #S" . $_POST["chosenPost"]);
    $adressPropertyCityCode->setValue($codeBitrix);
    $Tarif->setValue($_POST["tarifPost"]);
    $NamePropValue->setValue($_POST[fio]);
}

if ($_POST["deliv"] == 22)
{
    $adressProperty->setValue($_POST[adrsam]);
    $adressPropertyCityCode->setValue('0000073738');
    $NamePropValue->setValue($USER->GetLogin());
}

$shipmentCollection = $order->getShipmentCollection();
$shipment = $shipmentCollection->createItem(Bitrix\Sale\Delivery\Services\Manager::getObjectById($_POST["deliv"]));

$emailPropValue->setValue($USER->GetEmail());
$phonePropValue->setValue($USER->GetLogin());

$shipmentItemCollection = $shipment->getShipmentItemCollection();

/** @var Sale\BasketItem $basketItem */

foreach ($basket as $basketItem)
{
    $item = $shipmentItemCollection->createItem($basketItem);
    $item->setQuantity($basketItem->getQuantity());
}
$paymentCollection = $order->getPaymentCollection();

if ($_POST["PaySystem"] == 3)
{
    $payment = $paymentCollection->createItem(Bitrix\Sale\PaySystem\Manager::getObjectById(3));
}
else
{
    $payment = $paymentCollection->createItem(Bitrix\Sale\PaySystem\Manager::getObjectById(2));
}

$payment->setField("SUM", $order->getPrice());
$payment->setField("CURRENCY", $order->getCurrency());

$result = $order->save();
if (!$result->isSuccess())
{
    $result->getErrors();
}
LocalRedirect('/sale/?ORDER_ID='.$order->getId());
?>