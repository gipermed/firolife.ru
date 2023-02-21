<?
//if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') die();
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
//use Bitrix\Catalog\SubscribeTable;
//use Bitrix\Catalog\Product\SubscribeManager;
use Bitrix\Sale;

//$a = $_POST['a'];
  //$b = $_POST['b'];
 // $p = $_POST['p'];
$a = 522;

  echo $a;
  //echo $b;



// получаем объект существующего заказа
$order = Sale\Order::load($a);
//$order->getAvailableFields();
$propertyCollection = $order->getAvailableFields();
//$propertyCollection = $order->getPropertyCollection();
echo '<pre>';
print_r($propertyCollection);
echo '<pre>';
 
/*// задаем значение для поля STATUS_ID - N (статус: принят)
$order->setField('STATUS_ID', $b);
//$order->setField('USER_DESCRIPTION', 'Доставить до дому');
if ($b == 'W' || $b == 'C'){
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

 if($_POST['p']){
// получаем объекты оплаты
    $collection = $order->getPaymentCollection();
    foreach ($collection as $payment)
    {        
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
*/
// сохраняем изменения
$order->save();

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"); ?>