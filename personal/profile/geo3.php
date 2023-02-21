<? require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetTitle("");
$APPLICATION->SetPageProperty('title', 'Лист ожидания');

global $USER;

Bitrix\Main\Loader::includeModule('sale');
Bitrix\Main\Loader::includeModule('catalog');
use Bitrix\Main\Loader;
Loader::includeModule("highloadblock");
use Bitrix\Highloadblock as HL;

$products = array(
    array('PRODUCT_ID' => 1811, 'NAME' => 'Товар 1', 'PRICE' => 500, 'CURRENCY' => 'RUB', 'QUANTITY' => 5)
);

$basket = Bitrix\Sale\Basket::create(SITE_ID);

foreach ($products as $product)
{
    $item = $basket->createItem("catalog", $product["PRODUCT_ID"]);
    unset($product["PRODUCT_ID"]);
    $item->setFields($product);
}

$order = Bitrix\Sale\Order::create(SITE_ID, 1);
$order->setPersonTypeId(1);
$order->setBasket($basket);
$order->setField('USER_DESCRIPTION', 'Комментарии покупателя');

$propertyCollection = $order->getPropertyCollection();

$adressProperty = $propertyCollection->getItemByOrderPropertyId(6);
$adressPropertyIndex = $propertyCollection->getItemByOrderPropertyId(9);
$adressCity = $propertyCollection->getItemByOrderPropertyId(4);
$Tarif = $propertyCollection->getItemByOrderPropertyId(10);
$emailPropValue = $propertyCollection->getUserEmail();
$phonePropValue = $propertyCollection->getPhone();

$ar = $propertyCollection->getArray();

echo '<pre>';
print_r($ar);
echo '<pre>';


$adressProperty->setValue("Пенза, ул. Центральная, 1 к2 #SPNZ2");
$adressPropertyIndex->setValue("442930");
$emailPropValue->setValue("test@test.ru");
$phonePropValue->setValue("+79257589567");
$adressCity->setValue("2020");
$Tarif->setValue("136");


$shipmentCollection = $order->getShipmentCollection();
$shipment = $shipmentCollection->createItem(
    Bitrix\Sale\Delivery\Services\Manager::getObjectById(19)
);

$shipmentItemCollection = $shipment->getShipmentItemCollection();

foreach ($basket as $basketItem)
{
    $item = $shipmentItemCollection->createItem($basketItem);
    $item->setQuantity($basketItem->getQuantity());
}

$paymentCollection = $order->getPaymentCollection();
$payment = $paymentCollection->createItem(
    Bitrix\Sale\PaySystem\Manager::getObjectById(3)
);

$payment->setField("SUM", $order->getPrice());
$payment->setField("CURRENCY", $order->getCurrency());

$result = $order->save();
if (!$result->isSuccess())
{
    $result->getErrors();
    print_r($result);
}