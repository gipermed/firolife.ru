<?php

/**
 * @noinspection AutoloadingIssuesInspection
 * @noinspection UnknownInspectionInspection
 * @noinspection PhpUnused
 * @noinspection PhpMissingFieldTypeInspection
 */

check_prolog();

use Bitrix\Catalog\PriceTable;
use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\Localization\Loc;
use Bitrix\Sale\Basket;
use Bitrix\Sale\Order;
use Bitrix\Sale\PersonType;
use Bitrix\Sale\PropertyValue;
use Palladiumlab\Api\Rates\Rates;
use Palladiumlab\Support\Bitrix\Resource;
use Palladiumlab\Support\File\File;
use Palladiumlab\Support\Util\Arr;
use Palladiumlab\Support\Util\Num;
use Palladiumlab\Support\Util\Str;
use Palladiumlab\Traits\Components\SendJson;

Loc::loadMessages(__FILE__);

CBitrixComponent::includeComponentClass('bitrix:sale.order.ajax');

class SaleOrderComponent extends SaleOrderAjax
{
    use SendJson;

    public const PATH_TO_BASKET = '/cart/';

    public const ACTION_GET_DELIVERY_PRICE = 'getDeliveryPrice';

    public const SUCCESS_URL = '/cart/';
    public const SESSION_USER_ORDERS = 'SALE_ORDER_ID';

    protected $order;
    protected array $errors = [];
    protected Basket $calculateBasket;
    protected bool $orderLoaded = false;
    protected string $templateFile = '';

    public function __construct($component = null)
    {
        parent::__construct($component);

        modules(['catalog', 'sale']);
    }

    public function onPrepareComponentParams($arParams): array
    {
        $arParams = parent::onPrepareComponentParams($arParams);

        if ((int)$arParams['PERSON_TYPE_ID'] > 0) {
            $arParams['PERSON_TYPE_ID'] = (int)$arParams['PERSON_TYPE_ID'];
        } else if ((int)$this->request['PERSON_TYPE_ID'] > 0) {
            $arParams['PERSON_TYPE_ID'] = (int)$this->request['PERSON_TYPE_ID'];
        }

        $arParams['PATH_TO_BASKET'] = self::PATH_TO_BASKET;
        $arParams['DISABLE_BASKET_REDIRECT'] = 'Y';

        return $arParams;
    }

    public function executeComponent()
    {
        $ajaxAction = $this->request->get('orderAjaxAction');

        $arResult = &$this->arResult;

        $this->processSuccess();
        $this->initOrder();
        $this->fillResult();

        if ($ajaxAction && check_bitrix_sessid()) {
            $this->processAjaxAction();
        }
        $this->trySaveOrder();

        $arResult['ERRORS'] = $this->errors;

        $this->includeComponentTemplate($this->templateFile);
    }

    protected function processSuccess(): void
    {
        if (($orderId = (int)$this->request->get('ORDER_ID')) && $orderId > 0) {
            $sessionOrders = Arr::wrap($_SESSION[self::SESSION_USER_ORDERS]);
            try {
                /** @noinspection TypeUnsafeArraySearchInspection */
                if (in_array($orderId, $sessionOrders) && ($order = Order::load($orderId)) && !$order->isCanceled()) {
                    /** @var $order Order */
                    $this->order = $order;
                    $this->orderLoaded = true;
                    $this->showOrderAction();
                    $this->templateFile = 'confirm';
                }
            } catch (ArgumentNullException $e) {

            }
        }
    }

    protected function initOrder(): void
    {
        try {
            global $USER;
            $order = $this->getOrder($USER->GetID() ?: CSaleUser::GetAnonymousUserID());
            if (!$this->orderLoaded) {
                $this->order = $order;
            }
            /** @noinspection NullPointerExceptionInspection */
            if ($this->order->getBasket()->count() === 0) {
                //LocalRedirect(self::PATH_TO_BASKET);
                $this->templateFile = 'empty';
            }

            $this->synchronizeRequest();
            $this->setOrderProps();
        } catch (Exception $e) {
            $this->errors[] = $e->getMessage();
        }
    }

    protected function synchronizeRequest(): void
    {
        $modifiedFields = [
            'PERSON_TYPE_ID' => (int)$this->request['PERSON_TYPE_ID'] ?: PERSON_TYPE_PRIVATE_PERSON_ID,
            'PAY_SYSTEM_ID' => (int)$this->request['PAY_SYSTEM_ID'] ?: PAY_SYSTEM_CASH_ID,
        ];
        if (($deliveryId = (int)$this->request['DELIVERY_ID']) && $deliveryId > 0) {
            $modifiedFields['DELIVERY_ID'] = $deliveryId;
        }
        if (($paySystemId = (int)$this->request['PAYMENT_ID']) && $paySystemId > 0) {
            $modifiedFields['PAY_SYSTEM_ID'] = $paySystemId;
        }
        try {
            $this->synchronizeOrder($modifiedFields, $this->order);
        } catch (Exception $e) {
            $this->errors[] = $e->getMessage();
        }
    }

    protected function setOrderProps(): void
    {
        try {
            /** @var PropertyValue $prop */
            foreach ($this->order->getPropertyCollection() as $prop) {
                if ((int)$prop->getPersonTypeId() !== (int)$this->order->getPersonTypeId()) {
                    continue;
                }

                $propCode = $prop->getField('CODE');

                if (!empty($this->request->getPost($propCode))) {
                    $value = $this->request->getPost($propCode);
                } else {
                    $value = $prop->getProperty()['DEFAULT_VALUE'] ?: false;
                }

                if (!empty($value)) {
                    $prop->setValue($value);
                }
            }
            if ($comment = $this->request->getPost('COMMENT')) {
                $this->order->setField('USER_DESCRIPTION', $comment);
            }

        } catch (Exception $e) {
            $this->addError($e->getMessage());
        }
    }

    protected function addError($res, $type = 'MAIN'): void
    {
        parent::addError($res, $type);
        $this->errors[] = $res;
        $this->errors = array_unique($this->errors);
    }

    protected function fillResult(): void
    {
        /** @noinspection NullPointerExceptionInspection */
        // $this->calculateBasket = $this->order->getBasket()->createClone();
        $arResult = &$this->arResult;

        try {
            $arResult['PERSON_TYPE'] = PersonType::load($this->getSiteId());

            $this->fillPaySystem();
            $this->fillProperties();
            $this->fillDelivery();
            $this->fillBasket();
            $this->fillTotal();
        } catch (Exception $e) {
            $this->addError($e->getMessage());
        }
    }

    protected function fillPaySystem(): void
    {
        $this->obtainPaySystem();
    }

    protected function fillProperties(): void
    {
        $arResult = &$this->arResult;
        try {
            $arResult['ORDER_PROPERTIES'] = [];
            $orderClone = $this->order->createClone();
            $orderClone->setPersonTypeId(0);
            $properties = $orderClone->getPropertyCollection()->getArray();

            foreach ($properties['properties'] as $property) {
                $formatted = $this->getOrderPropFormatted($property);
                $property['VALUE'] = $formatted['VALUE'];
                $property['VALUE_FORMATTED'] = $formatted['VALUE_FORMATED'];
                $arResult['ORDER_PROPERTIES'][$property['PERSON_TYPE_ID']][$property['CODE']] = $property;
                unset($formatted);
            }
            unset($orderClone);
        } catch (Exception $e) {
            $this->addError($e->getMessage());
        }
    }

    protected function fillDelivery(): void
    {
        try {
            $this->obtainDelivery();
            foreach ($this->arResult['DELIVERY'] as &$delivery) {
                $delivery['PRICE_FORMATTED'] = $delivery['PRICE_FORMATED'];
            }
        } catch (Exception $e) {
            $this->addError($e->getMessage());
        }
    }

    protected function fillBasket(): void
    {
        $this->obtainBasket();
        $arResult = &$this->arResult;

        if (empty($arResult["BASKET_ITEMS"])) {
            return;
        }

        $productsIdList = array_column($arResult["BASKET_ITEMS"], 'PROPS.0.VALUE');

        $products = Arr::combineKeys((new Resource(CIBlockElement::GetList([],
            ['IBLOCK_ID' => CATALOG_ID, 'ID' => $productsIdList],
            false,
            false,
            ['IBLOCK_ID', 'ID', 'NAME', 'IBLOCK_SECTION_ID', 'PREVIEW_PICTURE', 'PROPERTY_SIZE', 'PROPERTY_WEIGHT', 'PROPERTY_VOLUME']
        )))->toArray(), 'ID');

        $sections = Arr::combineKeys((new Resource(CIBlockSection::GetList([], [
            'IBLOCK_ID' => CATALOG_ID,
            'ID' => array_column($products, 'IBLOCK_SECTION_ID'),
        ], false, [
            'ID',
            'NAME',
            'SECTION_PAGE_URL',
        ])))->toArray(Resource::TYPE_NEXT), 'ID');

        $offersCollection = Arr::combineKeys((new Resource(CIBlockElement::GetList([],
            ['IBLOCK_ID' => IBLOCK_CATALOG_TP_ID, 'PROPERTY_CML2_LINK' => $productsIdList],
            false,
            false,
            ['IBLOCK_ID', 'ID', 'NAME', 'CODE', 'PROPERTY_ARTICLE', 'PROPERTY_COLOR', 'PROPERTY_CML2_LINK']
        )))->toArray(), 'ID');

        /** @noinspection PhpUnhandledExceptionInspection */
        $colorsManager = HighloadBlockTable::compileEntity(HLBLOCK_COLORS_ID)->getDataClass();

        $offersColors = Arr::pluck($offersCollection, 'PROPERTY_COLOR_VALUE');

        $colors = Arr::combineKeys($colorsManager::getList([
            'filter' => ['=UF_XML_ID' => $offersColors]
        ])->fetchAll(), 'UF_XML_ID');

        $prices = Arr::combineKeys(PriceTable::getList(['filter' => [
            '=PRODUCT_ID' => Arr::pluck($offersCollection, 'ID')
        ]])->fetchAll(), 'PRODUCT_ID');

        $rate = (new Rates())->getUSD();

        foreach ($arResult["BASKET_ITEMS"] as &$basketItem) {

            $basketItem["PRICE_FORMATTED"] = $basketItem["PRICE_FORMATED"];
            $basketItem["WEIGHT_FORMATTED"] = $basketItem["WEIGHT_FORMATED"];
            $basketItem["DISCOUNT_PRICE_PERCENT_FORMATTED"] = $basketItem["DISCOUNT_PRICE_PERCENT_FORMATED"];
            $basketItem["BASE_PRICE_FORMATTED"] = $basketItem["BASE_PRICE_FORMATED"];
            $basketItem["SUM_BASE_FORMATTED"] = $basketItem["SUM_BASE_FORMATED"];

            $product = $products[$basketItem['PROPS'][0]['VALUE']];
            $offers = array_values(array_filter($offersCollection, static function ($offer) use ($product) {
                return $offer['PROPERTY_CML2_LINK_VALUE'] === $product['ID'];
            }));

            $collection = $sections[$product['IBLOCK_SECTION_ID']];

            $basketItem['JS_DATA'] = [

                'ITEM' => [
                    'ID' => $product['ID'],

                    'BASKET_ID' => $basketItem['ID'],

                    'NAME' => $product['NAME'],

                    'PICTURE' => File::getInfo($product['PREVIEW_PICTURE'])->first(),

                    'SIZE' => $product['PROPERTY_SIZE_VALUE'],
                    'WEIGHT' => $product['PROPERTY_WEIGHT_VALUE'],
                    'VOLUME' => $product['PROPERTY_VOLUME_VALUE'],

                    'COLLECTION' => [
                        'NAME' => $collection['NAME'],
                        'URL' => $collection['SECTION_PAGE_URL'],
                    ],

                    'OFFER_ID_SELECTED' => key(array_filter($offers, static function ($offer) use ($basketItem) {
                        return $basketItem['PRODUCT_ID'] === $offer['ID'];
                    })),
                ],

                'OFFERS' => array_map(static function ($offer) use ($rate, $colors, $prices, $basketItem) {
                    $color = $colors[$offer['PROPERTY_COLOR_VALUE']];
                    $price = $prices[$offer['ID']];

                    return [
                        'ID' => $offer['ID'],

                        'PRICE' => $price['PRICE'],
                        'PRICE_USD' => Num::parseFloat(Num::formatPrecision($price['PRICE'] * $rate)),

                        'QUANTITY' => $basketItem['PRODUCT_ID'] === $offer['ID'] ? $basketItem['QUANTITY'] : 1,

                        'ARTICLE' => $offer['PROPERTY_ARTICLE_VALUE'],

                        'COLOR' => $color['UF_NAME'],
                        'COLOR_IMAGE' => File::getInfo($color['UF_FILE'])->first(),

                        'QUANTITY_AVAILABLE' => 0,
                        'QUANTITY_RESERVED' => 0,
                    ];
                }, $offers),
            ];
        }
    }

    protected function fillTotal(): void
    {
        $this->obtainTotal();
        $arResult = &$this->arResult;

        $arResult['ORDER_PRICE_FORMATTED'] = $arResult['ORDER_PRICE_FORMATED'];
        $arResult['DISCOUNT_PRICE_FORMATTED'] = $arResult['DISCOUNT_PRICE_FORMATED'];
        $arResult['DELIVERY_PRICE_FORMATTED'] = $arResult['DELIVERY_PRICE_FORMATED'];
        $arResult['ORDER_TOTAL_PRICE_FORMATTED'] = $arResult['ORDER_TOTAL_PRICE_FORMATED'];
    }

    protected function processAjaxAction(): void
    {
        $result = [
            'status' => empty($this->errors),
            'errors' => array_unique($this->errors),
            'errorsHtml' => $this->getErrorsHtml(),
        ];
        $action = $this->request->get('orderAjaxAction');

        $this->arResult['ERRORS'] = $this->errors;

        /** @noinspection DegradedSwitchInspection */
        switch ($action) {
            case self::ACTION_GET_DELIVERY_PRICE:
                $this->sendJson(array_merge($result, [
                    'deliveryPrice' => $this->order->getDeliveryPrice(),
                ]));
                break;
            default:
                break;
        }
    }

    protected function getErrorsHtml()
    {
        if (!empty($this->errors)) {
            ob_start();
            $this->includeComponentTemplate('errors');
            return ob_get_clean();
        }

        return '';
    }

    protected function trySaveOrder(): void
    {
        if ($this->request->isPost() && check_bitrix_sessid() && $this->request->getPost('SAVE') === 'Y') {
            try {
                if ($this->validateOrder()) {

                    $this->order->doFinalAction();

                    $result = $this->order->save();
                    if ($result->isSuccess()) {
                        $_SESSION[self::SESSION_USER_ORDERS][] = (int)$result->getId();
                        LocalRedirect(self::SUCCESS_URL . '?ORDER_ID=' . $this->order->getField('ACCOUNT_NUMBER'));
                    } else {
                        /** @var \Bitrix\Main\Error $error */
                        foreach ($result->getErrorCollection() as $error) {
                            $this->addError($error->getMessage());
                        }
                    }
                }
            } catch (Exception $e) {
                $this->addError($e->getMessage());
            }
        }
    }

    protected function validateOrder(): bool
    {
        try {
            /** @noinspection PhpStatementHasEmptyBodyInspection */
            /** @noinspection MissingOrEmptyGroupStatementInspection */
            if (empty($this->request->getPost('AGREEMENT'))) {
                //$this->addError('Необходимо согласие!');
            }

            if (!(bool)$this->order->getPersonTypeId()) {
                $this->addError('Отсутствует тип плательщика');
            }

            if (empty($this->order->getPaySystemIdList())) {
                $this->addError('Отсутствует тип оплаты');
            }

            if (empty($this->order->getDeliveryIdList())) {
                $this->addError('Отсутствует служба доставки');
            }

            /** @var PropertyValue $prop */
            foreach ($this->order->getPropertyCollection() as $prop) {
                if (empty($prop->getValue()) && $prop->isRequired()
                    && (int)$prop->getPersonTypeId() === (int)$this->order->getPersonTypeId()
                ) {
                    $name = Str::ucfirst($prop->getName());
                    $this->addError("Отсутствует значение для свойства заказа \"{$name}\"");
                }
            }

            if ($this->order->getPrice() <= 0) {
                $this->addError('Ошибка обработки заказа, заказ пуст');
            }
        } catch (Exception $e) {
            $this->addError($e->getMessage());
        }

        return empty($this->errors);
    }
}
