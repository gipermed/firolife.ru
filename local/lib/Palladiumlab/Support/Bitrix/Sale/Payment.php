<?php


namespace Palladiumlab\Support\Bitrix\Sale;


use Bitrix\Sale\Order;
use Bitrix\Sale\OrderStatus;
use Bitrix\Sale\PaySystem\Manager;
use Bitrix\Sale\PaySystem\Service;
use Exception;

class Payment
{
    public static function showButton(int $orderId): void
    {
        try {
            /** @var Order $order */
            $order = Order::load($orderId);
            /** @var \Bitrix\Sale\Payment $payment */
            $payment = $order->getPaymentCollection()->current();

            if (!$payment->isPaid() && OrderStatus::isAllowPay($order->getField('STATUS_ID'))) {
                /** @var Service $paySystemService */
                $paySystemService = Manager::getObjectById($payment->getPaymentSystemId());

                $paySystemService->initiatePay($payment);
            }
        } catch (Exception $e) {

        }
    }
}