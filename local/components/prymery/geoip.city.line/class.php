<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

    use Bitrix\Main\Loader;
    use Bitrix\Main\Localization\Loc as Loc;

    Loc::loadMessages(__FILE__);

    class PrymeryGeoipCityLineComponent extends CBitrixComponent
    {

        public function onPrepareComponentParams($arParams)
        {

            if (\Bitrix\Main\Loader::includeModule('prymery.geoip')) {

                $oManager = \Prymery\GeoIP\Manager::getInstance();

                //для ajax
                $this->arResult['_ORIGINAL_PARAMS'] = $arParams;

                $arParams['LV'] = $oManager->getLogicVersion();
                $arParams['RAND_STRING'] = $this->getParamStr($arParams, 'RAND_STRING', $this->randString());
                $arParams['IS_DEBUG'] = ($oManager->isEnabledDebug() ? 'Y' : 'N');

                $arParams['CACHE_TIME'] = $this->getParamInt($arParams, 'CACHE_TIME', 8640000);
                $arParams['CACHE_TYPE'] = $this->getParamFromList($arParams, 'CACHE_TYPE', array(
                    'N',
                    'Y',
                    'A'
                ), 'A');

                $arParams['CITY_LABEL'] = $this->getParamStr($arParams, 'CITY_LABEL', '');
                $arParams['QUESTION_SHOW'] = $this->getParamBool($arParams, 'QUESTION_SHOW', 'N');
                $arParams['INFO_SHOW'] = $this->getParamBool($arParams, 'INFO_SHOW', 'N');
                $arParams['QUESTION_TEXT'] = $this->getParamStr($arParams, 'QUESTION_TEXT', $this->getMessage('QUESTION_TEXT_DEFAULT'));
                $arParams['INFO_TEXT'] = $this->getParamStr($arParams, 'INFO_TEXT', $this->getMessage('INFO_TEXT_DEFAULT'));
                $arParams['BTN_EDIT'] = $this->getParamStr($arParams, 'BTN_EDIT', $this->getMessage('BTN_EDIT_DEFAULT'));

                $arParams['COOKIE_PREFIX'] = $oManager->getCookiePrefix();
                $arParams['COOKIE_DOMAIN'] = $oManager->getCookieDomain();
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



        public function getMessage($name)
        {
            return Loc::getMessage('PRYMERY.GEOIP.CITY.LINE.' . $name);
        }


        public function executeComponent()
        {
            $this->setFrameMode(true);

            try {

                // подключаем модуль
                if (!Loader::includeSharewareModule('prymery.geoip')) {
                    throw new \Bitrix\Main\LoaderException($this->getMessage("MODULE_NOT_INSTALLED"));
                }

                $oManager = \Prymery\GeoIP\Manager::getInstance();

                if ($this->arParams["CACHE_TYPE"] == "N" || $this->arParams["CACHE_TYPE"] == "A" && COption::GetOptionString("main", "component_cache_on", "Y") == "N") {
                    $CACHE_TIME = 0;
                } else {
                    $CACHE_TIME = $this->arParams["CACHE_TIME"];
                }

                $this->arResult['TEMPLATE'] = $this->getTemplateName();
                if (!is_string($this->arResult['TEMPLATE'])) {
                    $this->arResult['TEMPLATE'] = '';
                }

                if ($this->startResultCache($CACHE_TIME)) {

                    if (defined('BX_COMP_MANAGED_CACHE') && is_object($GLOBALS['CACHE_MANAGER']))
                    {
                        $GLOBALS['CACHE_MANAGER']->RegisterTag('prymery_geoip_city_line');
                    }

                    $oManager = \Prymery\GeoIP\Manager::getInstance();

                    $this->arResult['CITY_DEFAULT'] = $oManager->getParam('DEFAULT_CITY', $this->getMessage('CITY_DEFAULT'));
                    $this->arResult['DEBUG'] = $oManager->getParam('DEBUG', 'N');

                    $this->setResultCacheKeys(array());
                    $this->IncludeComponentTemplate();
                }

            } catch (Exception $e) {
                ShowError($e->getMessage());
            }

            return parent::executeComponent();
        }



    }