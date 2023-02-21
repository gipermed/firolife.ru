<?php


namespace Palladiumlab\Support\Bitrix\Sale;


use Bitrix\Catalog\Product;
use Bitrix\Catalog\ProductTable;
use Bitrix\Currency\CurrencyManager;
use Bitrix\Main\Context;
use Bitrix\Main\Error;
use Bitrix\Main\Result;
use Bitrix\Sale;
use Palladiumlab\Api\Rates\Rates;
use Palladiumlab\Bitrix\Sale\BasketItem;
use Palladiumlab\Support\Util\Arr;
use Palladiumlab\Support\Util\Num;

/**
 * Class Basket
 * @package Palladiumlab\Support\Sale
 */
class BasketManager
{
    protected Sale\BasketBase $basket;

    public function __construct(Sale\BasketBase $basket)
    {
        $this->basket = $basket;
    }

    public static function createFromCurrent(): self
    {
        modules('sale');

        return new self(self::load());
    }

    protected static function load(): Sale\BasketBase
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Context::getCurrent()->getSite());
    }

    public function current(): Sale\BasketBase
    {
        return $this->basket;
    }

    public function setProductQuantity(int $productId, float $quantity)
    {
        if ($basketProduct = $this->findProduct($productId)) {

            /** @noinspection PhpUnhandledExceptionInspection */
            $result = $basketProduct->setField('QUANTITY', $quantity);

            /** @noinspection PhpUnhandledExceptionInspection */
            return !$result->isSuccess() ? $result : $this->basket->save();
        }

        return (new Result())->addError(new Error('Product not found'));
    }

    public function findProduct(int $productId): ?Sale\BasketItem
    {
        /** @var Sale\BasketItem $item */
        foreach ($this->basket as $item) {
            /** @noinspection PhpUnhandledExceptionInspection */
            if ((int)$item->getProductId() === $productId) {
                return $item;
            }
        }

        return null;
    }

    public function findProductBase(int $baseProductId): ?BasketItem
    {
        /** @var BasketItem $item */
        foreach ($this->basket as $item) {
            /** @noinspection PhpUnhandledExceptionInspection */
            if ((int)$item->getPropertyValue('BASE_PRODUCT_ID', 0) === $baseProductId) {
                return $item;
            }
        }

        return null;
    }

    public function addProduct(int $productId, float $quantity, array $props = [], float $price = 0): Result
    {
        $fields = [
            'PRODUCT_ID' => $productId,
            'QUANTITY' => $quantity,
            'PROPS' => $props,
        ];

        if ($price > 0) {
            $fields = array_merge($fields, [
                'CURRENCY' => CurrencyManager::getBaseCurrency(),
                'LID' => Context::getCurrent()->getSite(),
                'PRICE' => $price,
                'CUSTOM_PRICE' => 'Y',
            ]);
        }

        /** @noinspection PhpUnhandledExceptionInspection */
        $result = Product\Basket::addProduct($fields);

        $this->reload();

        return $result;
    }

    public function reload(): BasketManager
    {
        $this->basket = self::load();

        return $this;
    }

    public function removeProduct(int $productId): Result
    {
        $result = new Result();

        if ($item = $this->findProduct($productId)) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $result = $item->delete();
        } else {
            $result->addError(new Error('Item not found'));
        }

        /** @noinspection PhpUnhandledExceptionInspection */
        $result = !$result->isSuccess() ? $result : $this->basket->save();

        $this->reload();

        return $result;
    }

    public function clear(): Result
    {
        $result = new Result();

        /** @var Sale\BasketItem $item */
        foreach ($this->basket as $item) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $tmpResult = $item->delete();

            if (!$tmpResult->isSuccess()) {
                $result = $tmpResult;
                break;
            }
        }

        /** @noinspection PhpUnhandledExceptionInspection */
        return !$result->isSuccess() ? $result : $this->basket->save();
    }

    public function getSummary(): float
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return $this->basket->getPrice();
    }

    public function getQuantity(): int
    {
        return array_reduce($this->basket->getBasketItems(), static function ($quantity, Sale\BasketItemBase $item) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $quantity += $item->getQuantity();

            return $quantity;
        }, 0);
    }

    public function getJsProducts(): array
    {
        $rate = (new Rates())->getUSD();

        return array_map(static function (BasketItem $basketItem) use ($rate) {
            /** @noinspection PhpUnhandledExceptionInspection */
            return [
                'id' => $basketItem->getProductId(),

                'quantity' => (int)$basketItem->getQuantity(),

                'price' => (float)$basketItem->getPrice(),
                'priceUSD' => Num::parseFloat(Num::formatPrecision($basketItem->getPrice() * $rate)),

                'baseProductId' => (int)$basketItem->getPropertyValue('BASE_PRODUCT_ID'),
            ];
        }, $this->basket->getBasketItems());
    }

    public function clearUnavailable()
    {
        $products = array_map(static function (BasketItem $basketItem) {
            /** @noinspection PhpUnhandledExceptionInspection */
            return $basketItem->getProductId();
        }, $this->basket->getBasketItems());

        /** @noinspection PhpUnhandledExceptionInspection */
        /** @noinspection PhpMultipleClassDeclarationsInspection */
        $productsInfo = Arr::combineKeys(ProductTable::getList([
            'filter' => ['=ID' => $products],
            'select' => ['ID', 'AVAILABLE']
        ])->fetchAll(), 'ID');

        /** @var BasketItem $basketItem */
        foreach ($this->basket->getBasketItems() as $basketItem) {
            /** @noinspection PhpUnhandledExceptionInspection */
            if ($productsInfo[$basketItem->getProductId()]['AVAILABLE'] === 'N') {
                $this->removeProduct($basketItem->getProductId());
            }
        }

        return $this;
    }
}