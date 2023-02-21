<?php

/** @noinspection PhpMultipleClassDeclarationsInspection */

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");


use Bitrix\Catalog\ProductTable;
use Bitrix\Main\Context;
use Bitrix\Main\Error;
use Bitrix\Main\Result;
use Palladiumlab\Bitrix\ViewCounter;
use Palladiumlab\Catalog\Wishlist;
use Palladiumlab\Form\IblockWebForm;
use Palladiumlab\Support\Bitrix\Bitrix;
use Palladiumlab\Support\Bitrix\Resource;
use Palladiumlab\Support\Bitrix\Sale\BasketManager;

//header('Content-Type: application/json');
$f = fopen("log.txt", "w+");


$context = Context::getCurrent();
$request = $context->getRequest();
$result = new Result();
$action = $request->get('action');

modules([
	'catalog',
	'sale'
]);

$basketManager = BasketManager::createFromCurrent();
$wishList = new Wishlist();
if (!$request->isAjaxRequest()) {
    $result->addError(new Error('Request is not ajax'));
}
if (empty($action)) {
    $result->addError(new Error('Action is empty'));
}
if (!check_bitrix_sessid()) {
    $result->addError(new Error('User session id is invalid'));
}

if ($result->isSuccess()) {
    switch ($action)
	{
		case 'order-cancel':
			$idOrder = (int)$request->getPost('orderId');
			if ($idOrder > 0)
			{
				$ret = CSaleOrder::CancelOrder($idOrder, "Y", "Отменен пользователем");
				if ($ret === false) $result->addError(new Error('Ошибка отмены заказа'));
			} else
			{
				$result->addError(new Error('Empty parameter'));
			}
			break;
		case 'web-form':

//            $result = WebForm::create(
//                WebForm::getIblockIdByCode($request->getPost('form-code')),
//                array_merge($request->getPostList()->toArray(), $request->getFileList()->toArray())
//            );

			break;
		case 'change-offer-in-basket':

            [$fromId, $toId, $quantity, $baseProductId] = [
                (int)$request->getPost('fromId'),
                (int)$request->getPost('toId'),
                (float)$request->getPost('quantity'),
                (float)$request->getPost('baseProductId'),
            ];
            if ($fromId > 0 && $toId > 0 && $quantity > 0) {
                if ($oldOffer = $basketManager->findProduct($fromId)) {
                    try {
                        $oldOffer->delete();

                        $basketManager->current()->save();
                    } catch (Exception $e) {

                    }
                }

                $result = $basketManager->addProduct($toId, $quantity, [
                    ['NAME' => 'BASE_PRODUCT_ID', 'CODE' => 'BASE_PRODUCT_ID', 'VALUE' => $baseProductId],
                ]);
            } else {
                $result->addError(new Error('Empty parameters'));
            }

            break;
        case 'add-to-basket':

            [$id, $quantity, $baseProductId] = [
                (int)$request->getPost('id'),
                (float)$request->getPost('quantity'),
                (float)$request->getPost('baseProductId'),
            ];
            if ($id > 0 && $quantity > 0) {
                $result = $basketManager->addProduct($id, $quantity, [
                    ['NAME' => 'BASE_PRODUCT_ID', 'CODE' => 'BASE_PRODUCT_ID', 'VALUE' => $baseProductId],
                ]);
            } else {
                $result->addError(new Error('Empty parameters'));
            }

            break;
        case 'set-basket-quantity':

            [$id, $quantity] = [
                (int)$request->getPost('id'),
                (float)$request->getPost('quantity'),
            ];
            if ($id > 0 && $quantity > 0) {
                $basketManager->setProductQuantity($id, $quantity);
            } else {
                $result->addError(new Error('Empty parameters'));
            }

            break;
        case 'delete-from-basket':

            if ($id = (int)$request->getPost('id')) {
                $result = $basketManager->removeProduct($id);
            } else {
                $result->addError(new Error('Empty parameter'));
            }

            break;
        case 'clear-cart':

            $result = $basketManager->clear();

            break;

        case 'product-info':

            /** @noinspection PhpUnhandledExceptionInspection */
            $productsInfo = ProductTable::getList([
                'filter' => ['=ID' => $request->get('ID')],
                'select' => ['ID', 'QUANTITY', 'QUANTITY_RESERVED']
            ])->fetchAll();

            $result->setData(['INFO' => $productsInfo]);

            break;

        case 'header-search':

            ob_start();

            Bitrix::globalApplication()->includeComponent("bitrix:main.include", "", array(
                "AREA_FILE_SHOW" => "file",
                "PATH" => "/include/ajax/header-search.php"
            ), false, ['HIDE_ICONS' => 'Y']);

			$result->setData(['html' => ob_get_clean()]);

			break;

		case 'items-views':

			$result->setData(['items' => ViewCounter::getCurrentCounters($request->get('items') ?: [])]);

			break;
		case 'add-to-favorites':

			if ($request->get('ID') !== null) $result = $wishList->add((int)$request->get('ID')); else
			{
				$result->addError(new Error('Empty parameters'));
			}
			break;
		case 'remove-from-favorites':
			if ($request->get('ID') !== null) $result = $wishList->remove((int)$request->get('ID')); else
			{
				$result->addError(new Error('Empty parameters'));
			}
			break;
		case 'is-favorite':
			if ($request->get('ID') !== null)
			{
				$id = (int)$request->get('ID');
				$result->setData(['favorite' => $wishList->exists($id)]);
			} else
			{
				$result->addError(new Error('Empty parameters'));
			}
			break;
		default:
			$result->addError(new Error('Action not found', 404));
			break;
	}
}

try {
    $response = json_encode([
        'success' => $result->isSuccess(),
        'result' => $result->getData(),
        'errors' => $result->getErrorCollection()->toArray(),
    ], JSON_THROW_ON_ERROR);
} catch (JsonException $e) {
    $response = "{\"success\": false, \"errors\": [\"message\": \"{$e->getMessage()}\", \"code\": \"{$e->getCode()}\"]}";
}

echo $response;

die();
