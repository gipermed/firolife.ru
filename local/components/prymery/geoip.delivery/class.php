<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

    use Bitrix\Main\Loader;
    use Bitrix\Main\Localization\Loc as Loc;

    Loc::loadMessages(__FILE__);

    class PrymeryGeoipDeliveryComponent extends CBitrixComponent
    {

        public function onPrepareComponentParams($arParams)
        {
            global $USER;

            if (\Bitrix\Main\Loader::includeModule('prymery.geoip')) {
                $oManager = \Prymery\GeoIP\Manager::getInstance();

                //для ajax
                $this->arResult['_ORIGINAL_PARAMS'] = $arParams;

                $arParams['LV'] = $oManager->getLogicVersion();
                $arParams['RAND_STRING'] = $this->getParamStr($arParams, 'RAND_STRING', $this->randString());
                $arParams['ENABLE_JQUERY'] = $this->getParamBool($arParams, 'ENABLE_JQUERY', 'Y');
                $arParams['IS_AJAX'] = $this->getParamBool($arParams, 'IS_AJAX', 'N');
                $arParams['IS_DEBUG'] = $oManager->isEnabledDebug();

                $arParams['CALCULATE_NOW'] = $this->getParamBool($arParams, 'CALCULATE_NOW', 'N');


                $arParams['CACHE_TIME'] = $this->getParamInt($arParams, 'CACHE_TIME', 8640000);
                $arParams['CACHE_TYPE'] = $this->getParamFromList($arParams, 'CACHE_TYPE', array(
                    'N',
                    'Y',
                    'A'
                ), 'A');

                $arParams['PRODUCT_ID'] = $this->getParamInt($arParams, 'PRODUCT_ID', 0);
                $arParams['DEFAULT_WEIGHT'] = $this->getParamInt($arParams, 'DEFAULT_WEIGHT', 0);
                $arParams['SHOW_PARENT'] = $this->getParamBool($arParams, 'SHOW_PARENT', 'N');
                $arParams['IMG_SHOW'] = $this->getParamBool($arParams, 'IMG_SHOW', 'N');
                $arParams['IMG_WIDTH'] = $this->getParamInt($arParams, 'IMG_WIDTH', 30);
                $arParams['IMG_HEIGHT'] = $this->getParamInt($arParams, 'IMG_HEIGHT', 30);

                $arParams['PROLOG'] = $this->getParamStr($arParams, 'PROLOG', $this->getMessage('PROLOG'));
                $arParams['EPILOG'] = $this->getParamStr($arParams, 'EPILOG', $this->getMessage('EPILOG'));

                $arParams['QUANTITY'] = max($this->getParamInt($arParams, 'QUANTITY', 1),1);
                $arParams['PERSONAL_TYPE'] = $this->getParamInt($arParams, 'PERSONAL_TYPE', 1);

                $arParams['LOCATION'] = $this->getParamInt($arParams, 'LOCATION', $oManager->getLocation());
                $arParams['CITY'] = $this->getParamStr($arParams, 'CITY', $oManager->getCity());

            }

            return parent::onPrepareComponentParams($arParams);
        }

        /**
         * Подготовка парамтра int
         *
         * @param     $arParams
         * @param     $name
         * @param int $defaultValue
         *
         * @return int
         */
        private function getParamInt($arParams, $name, $defaultValue = 0)
        {
            return (isset($arParams[ $name ]) && intval($arParams[ $name ]) > 0 ? intval($arParams[ $name ]) : $defaultValue);
        }

        /**
         * Подготовка паартра типа строка
         *
         * @param        $arParams
         * @param        $name
         * @param string $defaultValue
         *
         * @return string
         */
        private function getParamStr($arParams, $name, $defaultValue = '')
        {
            return (isset($arParams[ $name ]) ? $arParams[ $name ] : $defaultValue);
        }

        /**
         * Подготовка параметра типа флаг
         *
         * @param        $arParams
         * @param        $name
         * @param string $defaultValue
         *
         * @return string
         */
        private function getParamBool($arParams, $name, $defaultValue = 'N')
        {
            return (isset($arParams[ $name ]) && in_array($arParams[ $name ], array(
                'N',
                'Y'
            )) ? $arParams[ $name ] : $defaultValue);
        }

        /**
         * Подготовка параметра из списка
         * @param $arParams
         * @param $name
         * @param array $list
         * @param string $defaultValue
         * @return string
         */
        private function getParamFromList($arParams, $name, array $list, $defaultValue = '')
        {
            return (isset($arParams[ $name ]) && in_array($arParams[ $name ], $list) ? $arParams[ $name ] : $defaultValue);
        }

        /**
         * Нужно ли подключать jQuery
         * @return bool
         */
        private function isNeedEnableJQuery()
        {
            return ($this->arParams['ENABLE_JQUERY'] == 'Y');
        }

        public function getMessage($name)
        {
            return Loc::getMessage('PRYMERY.GEOIP.DELIVERY.'.$name);
        }


        public function executeComponent()
        {
            $this->setFrameMode(true);

            try {

                //обработка ajax запросов --
                $this->ajaxHandler();

                // подключаем модуль
                if (!Loader::includeSharewareModule('prymery.geoip')) {
                    throw new \Bitrix\Main\LoaderException($this->getMessage("MODULE_NOT_INSTALLED"));
                }

                \CJSCore::Init();

                // подклчюаем js
                if ($this->isNeedEnableJQuery()) {
                    CUtil::InitJSCore('jquery');
                }

                $this->showHtml();

            } catch (Exception $e) {
                ShowError($e->getMessage());
            }

            return parent::executeComponent();
        }

        public function showHtml()
        {

            $oManager = \Prymery\GeoIP\Manager::getInstance();

            if ($this->arParams["CACHE_TYPE"] == "N" || $this->arParams["CACHE_TYPE"] == "A" && COption::GetOptionString("main", "component_cache_on", "Y") == "N") {
                $CACHE_TIME = 0;
            } else {
                $CACHE_TIME = $this->arParams["CACHE_TIME"];
            }

            $this->arResult['DEFAULT_CITY'] = $oManager->getParam('DEFAULT_CITY', $this->getMessage('DEFAULT_CITY'));
            $this->arResult['DEBUG'] = $oManager->isEnabledDebug();
            $this->arResult['ITEMS'] = array();

            $this->arResult['TEMPLATE'] = $this->getTemplateName();
            if(!is_string($this->arResult['TEMPLATE']))
            {
                $this->arResult['TEMPLATE'] = '';
            }


            if ($this->startResultCache($CACHE_TIME)) {

                if (defined('BX_COMP_MANAGED_CACHE') && is_object($GLOBALS['CACHE_MANAGER'])) {
                    $GLOBALS['CACHE_MANAGER']->RegisterTag('prymery_geoip_delivery');
                }

                if (!CModule::IncludeModule('catalog') && !CModule::IncludeModule('sale')) {
                    $this->abortResultCache();
                }
                else {

                    if($this->arParams['CALCULATE_NOW'] == 'Y' || $this->arParams['IS_AJAX'] == 'Y')
                    {
                        $oCatalogSKU = new \CCatalogSKU();
                        $oProduct = new \CCatalogProduct();
                        $oPrice = new CPrice();

                        // Определеяем цену
                        $price = 0;
                        $offerId = $this->arParams['PRODUCT_ID'];
                        $arOffers = $oCatalogSKU->getOffersList(array($offerId));
                        if (count($arOffers)) {
                            foreach ($arOffers[$this->arParams['PRODUCT_ID']] as $arOffer) {

                                $arProductPrice = $oProduct->GetOptimalPrice($arOffer['ID'], $this->arParams['QUANTITY'], $this->arParams['USER_GROUPS']);

                                if (!$price || $price > $arProductPrice['DISCOUNT_PRICE']) {
                                    $price = $arProductPrice['DISCOUNT_PRICE'];
                                    $this->arParams['PRODUCT_ID'] = $arOffer['ID'];
                                }
                            }
                        }
                        else
                        {
                            $arProductPrice = $oProduct->GetOptimalPrice($offerId, $this->arParams['QUANTITY'], $this->arParams['USER_GROUPS']);
                            if (!$price || $price > $arProductPrice['DISCOUNT_PRICE']) {
                                $price = $arProductPrice['DISCOUNT_PRICE'];
                            }
                        }
                        $offerId = $this->arParams['PRODUCT_ID'];

                        //persona type
                        if (!$this->arParams['PERSONAL_TYPE'] && Loader::includeModule('sale')) {
                            $dbPersonType = \CSalePersonType::GetList(array("SORT" => "ASC", "NAME" => "ASC"), array("ACTIVE" => "Y", "LID" => SITE_ID));
                            if ($arPersonType = $dbPersonType->GetNext()) {
                                $this->arParams['PERSONAL_TYPE'] = $arPersonType["ID"];
                            }
                        }


                        $arFields = array(
                            'PRODUCT_ID' => $offerId,
                            'QUANTIYT' => $this->arParams['QUANTITY'],
                            'PRICE' => max($price, 1),
                            'SITE_ID' => SITE_ID,
                            'LOCATION' => $this->arParams['LOCATION'],
                            'PERSONAL_TYPE' => $this->arParams['PERSONAL_TYPE'],
                            'DEFAULT_WEIGHT' => $this->arParams['DEFAULT_WEIGHT']
                        );


                        $this->arResult['ITEMS'] = $oManager->getDeliveryItems($arFields);
                    }
                }

                $this->setResultCacheKeys(array());
                $this->IncludeComponentTemplate();
            }

            
        }



        public function ajaxHandler()
        {
            global $USER;

            // AJAX
            $app = \Bitrix\Main\Application::getInstance();
            $req = $app->getContext()->getRequest();

            //обработка только ajax  запросов
            if (!$req->isAjaxRequest() || $this->arParams['IS_AJAX'] != 'Y') {
                return true;
            }

            $oManager = \Prymery\GeoIP\Manager::getInstance();

            $arAnswer = array(
                'response' => array(),
                'error'    => array()
            );

            do {

                // подключаем модуль --
                if (!Loader::includeSharewareModule('prymery.geoip')) {
                    $arAnswer['error'] = array(
                        'MSG'  => $this->getMessage("MODULE_NOT_INSTALLED"),
                        'CODE' => 'MODULE_NOT_INSTALLED',
                        'MORE' => array()
                    );
                    break;
                }

                if (!$req->getPost('method')) {
                    $arAnswer['error'] = array(
                        'MSG'  => $this->getMessage('AJAX.NEED_METHOD'),
                        'CODE' => 'NEED_METHOD',
                        'MORE' => ''
                    );
                    break;
                }

                switch ($req->getPost('method')) {
                    case 'getDelivery':
                        {
                            ob_start();
                            $this->showHtml();

                            $arAnswer['response']['html'] = ob_get_clean();

                            break;
                        }

                    default:
                        {
                            $arAnswer['error'] = array(
                                'MSG'  => $this->getMessage('AJAX.UNDEFINED_METHOD'),
                                'CODE' => 'UNDEFINED_METHOD',
                                'MORE' => ''
                            );
                            break;
                        }
                }


            } while (false);


            $oManager->getBase()->showJson($arAnswer);
        }


    }