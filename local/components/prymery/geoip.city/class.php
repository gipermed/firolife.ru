<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

    use Bitrix\Main\Loader;
    use Bitrix\Main\Localization\Loc as Loc;

    Loc::loadMessages(__FILE__);

    class PrymeryGeoipCityComponent extends CBitrixComponent
    {

        public function onPrepareComponentParams($arParams)
        {

            if (\Bitrix\Main\Loader::includeModule('prymery.geoip')) {

                $oManager = \Prymery\GeoIP\Manager::getInstance();

                //для ajax
                $this->arResult['_ORIGINAL_PARAMS'] = $arParams;

                $arParams['LV'] = $oManager->getLogicVersion();
                $arParams['RAND_STRING'] = $this->getParamStr($arParams, 'RAND_STRING', $this->randString());
                $arParams['ENABLE_JQUERY'] = $this->getParamBool($arParams, 'ENABLE_JQUERY', 'Y');
                $arParams['IS_AJAX'] = $this->getParamBool($arParams, 'IS_AJAX', 'N');

                $arParams['CACHE_TIME'] = $this->getParamInt($arParams, 'CACHE_TIME', 8640000);
                $arParams['CACHE_TYPE'] = $this->getParamFromList($arParams, 'CACHE_TYPE', array(
                    'N',
                    'Y',
                    'A'
                ), 'A');


                $arParams['CITY_LABEL'] = $this->getParamStr($arParams, 'CITY_LABEL', '');
                $arParams['RELOAD_PAGE'] = $this->getParamBool($arParams, 'RELOAD_PAGE', 'N');
                $arParams['CITY_SHOW'] = $this->getParamBool($arParams, 'CITY_SHOW', 'N');
                $arParams['QUESTION_SHOW'] = $this->getParamBool($arParams, 'QUESTION_SHOW', 'N');

                $arParams['REDIRECT_WAIT_CONFIRM'] = $this->getParamBool($arParams, 'REDIRECT_WAIT_CONFIRM', 'N');
                $arParams['INFO_SHOW'] = $this->getParamBool($arParams, 'INFO_SHOW', 'N');
                $arParams['QUESTION_TEXT'] = $this->getParamStr($arParams, 'QUESTION_TEXT', $this->getMessage('QUESTION_TEXT_DEFAULT'));
                $arParams['INFO_TEXT'] = $this->getParamStr($arParams, 'INFO_TEXT', $this->getMessage('INFO_TEXT_DEFAULT'));
                $arParams['BTN_EDIT'] = $this->getParamStr($arParams, 'BTN_EDIT', $this->getMessage('BTN_EDIT_DEFAULT'));

                $arParams['POPUP_LABEL'] = $this->getParamStr($arParams, 'POPUP_LABEL', $this->getMessage('POPUP_LABEL_DEFAULT'));
                $arParams['INPUT_LABEL'] = $this->getParamStr($arParams, 'INPUT_LABEL', $this->getMessage('INPUT_LABEL_DEFAULT'));
                $arParams['MSG_EMPTY_RESULT'] = $this->getParamStr($arParams, 'MSG_EMPTY_RESULT', $this->getMessage('MSG_EMPTY_RESULT_DEFAULT'));
                $arParams['SEARCH_SHOW'] = $this->getParamBool($arParams, 'SEARCH_SHOW', 'N');

                $arParams['FAVORITE_SHOW'] = $this->getParamBool($arParams, 'FAVORITE_SHOW', 'N');
                $arParams['CITY_COUNT'] = $this->getParamInt($arParams, 'CITY_COUNT', 30);
                $arParams['FID'] = $this->getParamInt($arParams, 'FID', 0);

                $arParams['IS_DEBUG'] = $oManager->isEnabledDebug();

                $arParams['USE_DOMAIN_REDIRECT'] = ($oManager->isOptionUseDomainRedirect() ? 'Y' : 'N');
                $arParams['LOCATION_DOMAIN'] = $oManager->getLocationDomain();
                $arParams['COOKIE_PREFIX'] = $oManager->getCookiePrefix();
                $arParams['COOKIE_DOMAIN'] = $oManager->getCookieDomain();

                $arParams['USE_YANDEX'] = $oManager->getParam('USE_YANDEX', 'Y');
                $arParams['USE_YANDEX_SEARCH'] = $oManager->getParam('USE_YANDEX_SEARCH', 'N');
                $arParams['YANDEX_MAP_API_KEY'] = $oManager->getYandexMapApiKey();
                $arParams['YANDEX_SEARCH_SKIP_WORDS'] = explode(',', preg_replace('/,\s*/', ',', $oManager->getParam('YANDEX_SEARCH_SKIP_WORDS', '')));

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
            return Loc::getMessage('PRYMERY.GEOIP.CITY.' . $name);
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

            $this->arResult['ITEMS'] = array();

            $this->arResult['TEMPLATE'] = $this->getTemplateName();
            if (!is_string($this->arResult['TEMPLATE'])) {
                $this->arResult['TEMPLATE'] = '';
            }



            if ($this->startResultCache($CACHE_TIME)) {

                if (defined('BX_COMP_MANAGED_CACHE') && is_object($GLOBALS['CACHE_MANAGER'])) {
                    $GLOBALS['CACHE_MANAGER']->RegisterTag('prymery_geoip_city');
                }

                $oFavoritesCity = new Prymery\GeoIP\Favorites\CityTable();

                $this->arResult['ITEMS'] = array();

                // если нужно выводить список городов
                if ($this->arParams['FAVORITE_SHOW'] == 'Y' && $this->arParams['FID']) {

                    //  полуаем список избранных местоположений
                    $arFavoriteCityID = array();
                    if ($this->arParams['FID']) {
                        $dbrFavoriteCity = $oFavoritesCity->getList(array(
                            'order'  => array( 'SORT' => 'ASC' ),
                            'filter' => array(
                                'FID' => $this->arParams['FID']
                            )
                        ));
                        while ($arFavoriteCity = $dbrFavoriteCity->fetch()) {
                            $arFavoriteCityID[ $arFavoriteCity['LOCATION_ID'] ] = array(
                                'SORT' => $arFavoriteCity["SORT"],
                                'MARK' => $arFavoriteCity["MARK"]
                            );
                        }
                    }

                    if (count($arFavoriteCityID)) {
                        // если используется локальная база
                        if ($oManager->isOptionUseLocalBase()) {

                            $oLocationCity = new \Prymery\GeoIP\Location\CityTable();
                            $oLocationRegion = new \Prymery\GeoIP\Location\RegionTable();
                            $oLocationCountry = new \Prymery\GeoIP\Location\CountryTable();

                            $dbrLocationCity = $oLocationCity->getList(array(
                                'filter' => array(
                                    'ID' => array_keys($arFavoriteCityID)
                                )
                            ));
                            while ($arLocationCity = $dbrLocationCity->fetch()) {
                                $this->arResult['ITEMS'][] = array(
                                    'ID'      => $arLocationCity['ID'],
                                    'NAME'    => $arLocationCity['NAME'],
                                    'NAME_EN' => $arLocationCity['NAME_EN'],
                                    'SORT'    => $arFavoriteCityID[ $arLocationCity['ID'] ]['SORT'],
                                    'MARK'    => $arFavoriteCityID[ $arLocationCity['ID'] ]['MARK']
                                );
                            }


                        } // если используются местоположения интернет-магазина
                        elseif (Loader::includeModule('sale')) {

                            if (\CSaleLocation::isLocationProEnabled()) {
                                $res = \Bitrix\Sale\Location\LocationTable::getList(array(
                                    'select' => array(
                                        '*',
                                        'CITY_NAME' => 'NAME.NAME'
                                    ),
                                    'order'  => array( 'SORT' => 'ASC' ),
                                    'filter' => array(
                                        '=NAME.LANGUAGE_ID' => $oManager->getParam('LOCATION_LANG', LANGUAGE_ID),
                                        'ID'                => array_keys($arFavoriteCityID),
                                        '!CITY_NAME'        => false
                                    )
                                ));
                                while ($arLocationCity = $res->fetch()) {
                                    $this->arResult['ITEMS'][] = array(
                                        'ID'      => $arLocationCity['ID'],
                                        'NAME'    => $arLocationCity['CITY_NAME'],
                                        'NAME_EN' => $arLocationCity['CITY_NAME'],
                                        'SORT'    => $arFavoriteCityID[ $arLocationCity['ID'] ]['SORT'],
                                        'MARK'    => $arFavoriteCityID[ $arLocationCity['ID'] ]['MARK'],
                                    );
                                }
                            } else {

                                $res = \CSaleLocation::GetList(array(
                                    "SORT"              => "ASC",
                                    "COUNTRY_NAME_LANG" => "ASC",
                                    "CITY_NAME_LANG"    => "ASC"
                                ), array(
                                    "LID"        => $oManager->getParam('LOCATION_LANG', LANGUAGE_ID),
                                    'ID'         => array_keys($arFavoriteCityID),
                                    '!CITY_NAME' => false
                                ));
                                while ($arLocationCity = $res->fetch()) {
                                    $this->arResult['ITEMS'][] = array(
                                        'ID'      => $arLocationCity['ID'],
                                        'NAME'    => $arLocationCity['CITY_NAME'],
                                        'NAME_EN' => $arLocationCity['CITY_NAME'],
                                        'SORT'    => $arFavoriteCityID[ $arLocationCity['ID'] ]['SORT'],
                                        'MARK'    => $arFavoriteCityID[ $arLocationCity['ID'] ]['MARK']
                                    );
                                }
                            }
                        }

                        \Bitrix\Main\Type\Collection::sortByColumn($this->arResult['ITEMS'], 'SORT');
                    }
                }

                //данные для js
                $this->arResult['JS_DATA'] = $this->getJsParams();

                $this->setResultCacheKeys(array());
                $this->IncludeComponentTemplate();
            }


        }

        /**
         * Массив парамтеров для рабоыт js  логики
         */
        public function getJsParams()
        {
            return array(
                'messages' => array(
                    'emptyResult' => $this->arParams['MSG_EMPTY_RESULT']
                ),

                'cookiePrefix'   => $this->arParams['COOKIE_PREFIX'],
                'cookieDomain'   => $this->arParams['COOKIE_DOMAIN'],
                'locationDomain' => $this->arParams['LOCATION_DOMAIN'],

                'redirectWaitConfirm'     => ($this->arParams['REDIRECT_WAIT_CONFIRM'] == 'Y'),
                'useDomainRedirect'     => ($this->arParams['USE_DOMAIN_REDIRECT'] == 'Y'),
                'reload'                => ($this->arParams['RELOAD_PAGE'] == 'Y'),
                'searchShow'            => ($this->arParams['SEARCH_SHOW'] == 'Y'),
                'favoriteShow'          => ($this->arParams['FAVORITE_SHOW'] == 'Y'),
                'useYandex'             => ($this->arParams['USE_YANDEX'] == 'Y'),
                'useYandexSearch'       => ($this->arParams['USE_YANDEX_SEARCH'] == 'Y'),
                'yandexSearchSkipWords' => $this->arParams['YANDEX_SEARCH_SKIP_WORDS'],
                'yandexApiKey'          => $this->arParams['YANDEX_MAP_API_KEY'],
                'animateTimeout'        => 300,
                'searchTimeout'         => 500,
            );
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

                //                if (!check_bitrix_sessid()) {
                //                    $arAnswer['error'] = array(
                //                        'MSG'  => $this->getMessage('AJAX.INVALID_SESSID'),
                //                        'CODE' => 'INVALID_SESSID',
                //                        'MORE' => ''
                //                    );
                //                    break;
                //                }

                if ($oManager->isExpired()) {
                    $arAnswer['error'] = array(
                        'MSG'  => $this->getMessage('AJAX.DEMO_EXPIRED'),
                        'CODE' => 'DEMO_EXPIRED',
                        'MORE' => ''
                    );
                    break;
                }


                switch ($req->getPost('method')) {
                    // поиск
                    case 'search':
                        {
                            $query = $req->getPost('query');

                            if (!$query || strlen(trim($query)) < 3) {
                                $arAnswer['error'] = array(
                                    'MSG'  => $this->getMessage('AJAX.ERROR_SEARCH_LENGTH'),
                                    'CODE' => 'EMPTY_QUERY',
                                    'MORE' => ''
                                );
                                break;
                            }


                            $arAnswer['response'] = array(
                                'items' => array(),
                                'count' => 0
                            );

                            $arAnswer['response']['items'] = $oManager->searchLocation($query);
                            $arAnswer['response']['count'] = count($arAnswer['response']['items']);

                            break;
                        }
                    // установка нового местооложения по id местоположения битрикса
                    case 'selectLocation':
                        {
                            if (intval($req->getPost('id')) <= 0) {
                                $arAnswer['error'] = array(
                                    'CODE' => 'ERROR_LOCATION_ID',
                                    'MSG'  => $this->getMessage('AJAX.ERROR_LOCATION_ID'),
                                    'MORE' => ''
                                );
                                break;
                            }

                            $oManager->selectLocation($req->getPost('id'));

                            $arAnswer['response'] = $oManager->getFullData();

                            //проверка необходимости переадресации на поддомен
                            if ($oManager->isNeedRedirect()) {
                                $arAnswer['response']['redirect'] = $oManager->getLocationDomainTransferUrl();
                            }

                            break;
                        }
                    // устнаовка местоположения  из яндекса
                    case 'selectYandexLocation':
                        {


                            if (!$req->getPost('city') || strlen(trim($req->getPost('city'))) < 3) {
                                $arAnswer['error'] = array(
                                    'CODE' => 'ERROR_CITY',
                                    'MSG'  => $this->getMessage('AJAX.ERROR_CITY'),
                                    'MORE' => ''
                                );
                                break;
                            }
                            if (!$req->getPost('country') || strlen(trim($req->getPost('country'))) < 3) {
                                $arAnswer['error'] = array(
                                    'CODE' => 'ERROR_COUNTRY',
                                    'MSG'  => $this->getMessage('AJAX.ERROR_COUNTRY'),
                                    'MORE' => ''
                                );
                                break;
                            }

                            $country = trim($req->getPost('country'));
                            $city = trim($req->getPost('city'));
                            $region = trim($req->getPost('region'));
                            $area = trim($req->getPost('area'));
                            $lng = floatval($req->getPost('lng'));
                            $lat = floatval($req->getPost('lat'));
                            $location = intval($req->getPost('location'));

                            $country = strip_tags($country);
                            $city = strip_tags($city);
                            $region = strip_tags($region);
                            $area = strip_tags($area);

                            //если поиск города по яндексу, то ничего не делаем
                            if ($oManager->isOptionUseYandexSearch()) {
                                $oManager->setYandex(1);
                                $oManager->setLocation($location);
                                $oManager->setLocationCode($location);
                                $oManager->setZip('');
                                $oManager->setCountryId(0);
                                $oManager->setRegionId(0);
                                $oManager->setLat($lat);
                                $oManager->setLng($lng);
                                $oManager->setCountry($country);
                                $oManager->setCity($city);
                                $oManager->setRegion($region);
                                $oManager->setArea($area);


                                $oManager->saveCookie();
                            } // иначе ищем соответствие
                            else {

                                if ($region == $city) {
                                    $region = '';
                                }

                                $arFoundLocation = $oManager->searchLocation($city);

                                $arYandexLocation = $oManager->changeCaseToLower(array(
                                    'city'    => $city,
                                    'country' => $country,
                                    'region'  => $region,
                                    'area'    => $area
                                ));

                                $arFind = array();
                                foreach ($arFoundLocation as $item) {
                                    $item = $oManager->changeCaseToLower($item);

                                    $arFind[ $item['location'] ] = 0;
                                    $arFind[ $item['location'] ] += ($item['city'] == $arYandexLocation['city']) ? 4 : 0;
                                    $arFind[ $item['location'] ] += ($item['region'] == $arYandexLocation['region']) ? 2 : 0;
                                }


                                if (count($arFind) && max($arFind) >= 4) {
                                    $id = array_search(max($arFind), $arFind);
                                    $oManager->selectLocation($id);
                                }

                                $fullData = $oManager->getFullData();

                                if (floatval($fullData['lng']) <= 0) {
                                    $oManager->setLng($lng);
                                }
                                if (floatval($fullData['lat']) <= 0) {
                                    $oManager->setLat($lat);
                                }
                            }

                            $arAnswer['response'] = $oManager->getFullData();

                            //проверка необходимости переадресации на поддомен
                            if ($oManager->isNeedRedirect()) {
                                $arAnswer['response']['redirect'] = $oManager->getLocationDomainTransferUrl();
                            }

                            break;
                        }
                    //redirect
                    case 'checkNeedRedirect':
                        {
                            //проверка необходимости переадресации на поддомен
                            $arAnswer['response']['need'] = $oManager->isNeedRedirect();
                            $arAnswer['response']['redirect'] = $oManager->getLocationDomainTransferUrl();
                            break;
                        }

                    // для отдачи параметров работы js логики в режиме композита без фонового запроса
                    case 'getJsParams': {
                        $arAnswer['response']['params'] = $this->getJsParams();

                        //установим куки
                        $oManager->saveCookie();

                        //не нужно приводить к нижнему регистру ключи массива
                        $oManager->getBase()->showJson($arAnswer, false);

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