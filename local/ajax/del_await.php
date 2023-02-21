<?
if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') die();
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Catalog\SubscribeTable;
use Bitrix\Catalog\Product\SubscribeManager;
$subscribeManager = new \Bitrix\Catalog\Product\SubscribeManager;

if($_REQUEST['ID'] || $_REQUEST['ITEM_ID'] || $_REQUEST['ACTION']):
    global $USER;
    $user = new CUser;

    $subscribe = SubscribeTable::getList(array(
        'select' => array('*'),
        'filter' => array(
            '=ID' => $_REQUEST['ID'],
            '=ITEM_ID' => $_REQUEST['ITEM_ID'],
            '=USER_ID' => $USER->GetId(),
        ),
        'runtime' => array()
    ))->fetchAll();
    foreach($subscribe as $item){
        if($item){
            if(!$subscribeManager->deleteManySubscriptions(array($item['ID']), $_REQUEST['ITEM_ID']))
            {
                $errorObject = current($subscribeManager->getErrors());
                if($errorObject) {
                    $errors = $errorObject->getMessage();
                }
            }
        }
    }

    echo json_encode(1);
endif;
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"); ?>