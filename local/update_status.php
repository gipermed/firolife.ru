<?
//if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') die();
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
//use Bitrix\Catalog\SubscribeTable;
//use Bitrix\Catalog\Product\SubscribeManager;
use Bitrix\Sale;

$a = $_POST['a'];
  $b = $_POST['b'];
 // $p = $_POST['p'];
  echo $a;
  echo $b;

// получаем объект существующего заказа
$order = Sale\Order::load($a);
 
// задаем значение для поля STATUS_ID - N (статус: принят)
$order->setField('STATUS_ID', $b);
//$order->setField('USER_DESCRIPTION', 'Доставить до дому');
// отгрузка заказа
if ($b == 'W' || $b == 'YK'){
        // получаем объекты отгрузки
        $shipmentCollection = $order->getShipmentCollection(); 
         
        foreach ($shipmentCollection as $shipment) {
            if (!$shipment->isSystem()) {
                $shipment->allowDelivery(); // разрешаем отгрузку
                $shipment->setField('DEDUCTED', 'Y'); // отгружено
                $shipment->setField('STATUS_ID', 'DF'); // отгружено
            }
        }
 }

// оплата заказа
if($_POST['p']) {
// получаем объекты оплаты
     $collection = $order->getPaymentCollection();
     $paid = $order->isPaid();
     if (!$paid) {
         foreach ($collection as $payment) {

             $sum = $payment->getSum();
             $payment->delete();
             $service = \Bitrix\Sale\PaySystem\Manager::getObjectById(3);
             $payment = $collection->createItem($service);
             $payment->setField('SUM', $sum);
             $payment->setField('PAID', 'Y');
         }
         $order->setField('STATUS_ID', 'P');
         $order->save();
         $order = Sale\Order::load($a);
         $order->setField('STATUS_ID', 'YT');
     }
 }
 // отмена заказа
if ($b == 'YC'){
    $order->setField("CANCELED","Y");
}      
// сохраняем изменения
$order->save();

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"); ?>