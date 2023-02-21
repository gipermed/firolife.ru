<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

    use Bitrix\Main\Localization\Loc as Loc;

    Loc::loadLanguageFile(__FILE__);

    $BXMAKER_COMPONENT_NAME = 'BXMAKER.GEOIP.DELIVERY.PARAMS.';

    $arPersonTypes = array();
    if (\Bitrix\Main\Loader::includeModule('sale')) {

        // Выведем переключатели для выбора типа плательщика для текущего сайта
        $dbrTypes = \CSalePersonType::GetList(Array( "SORT" => "ASC" ));
        while ($arType = $dbrTypes->Fetch()) {
            $arPersonTypes[ $arType['ID'] ] = $arType['NAME'];
        }
    }

    // парамтеры
    $arComponentParameters = array(
        "GROUPS"     => array(),
        "PARAMETERS" => array(
            'CACHE_TIME'     => array(),
            'ENABLE_JQUERY'  => array(
                "PARENT"  => "BASE",
                'NAME'    => Loc::getMessage($BXMAKER_COMPONENT_NAME . 'ENABLE_JQUERY'),
                'TYPE'    => 'CHECKBOX',
                'DEFAULT' => 'N'
            ),
            'CALCULATE_NOW'  => array(
                'NAME'    => Loc::getMessage($BXMAKER_COMPONENT_NAME . 'CALCULATE_NOW'),
                'TYPE'    => 'CHECKBOX',
                'DEFAULT' => 'N'
            ),
            'PRODUCT_ID'     => array(
                "PARENT"  => "BASE",
                'NAME'    => Loc::getMessage($BXMAKER_COMPONENT_NAME . 'PRODUCT_ID'),
                'TYPE'    => 'STRING',
                'DEFAULT' => ''
            ),
            'SHOW_PARENT'    => array(
                'NAME'    => Loc::getMessage($BXMAKER_COMPONENT_NAME . 'SHOW_PARENT'),
                'TYPE'    => 'CHECKBOX',
                'DEFAULT' => 'N'
            ),
            'IMG_SHOW'       => array(
                'NAME'    => Loc::getMessage($BXMAKER_COMPONENT_NAME . 'IMG_SHOW'),
                'TYPE'    => 'CHECKBOX',
                'DEFAULT' => 'N'
            ),
            'IMG_WIDTH'      => array(
                'NAME'    => Loc::getMessage($BXMAKER_COMPONENT_NAME . 'IMG_WIDTH'),
                'TYPE'    => 'STRING',
                'DEFAULT' => '30'
            ),
            'IMG_HEIGHT'     => array(
                'NAME'    => Loc::getMessage($BXMAKER_COMPONENT_NAME . 'IMG_HEIGHT'),
                'TYPE'    => 'STRING',
                'DEFAULT' => '30'
            ),
            'PROLOG'         => array(
                'NAME'    => Loc::getMessage($BXMAKER_COMPONENT_NAME . 'PROLOG'),
                'TYPE'    => 'STRING',
                'DEFAULT' => Loc::getMessage($BXMAKER_COMPONENT_NAME . 'PROLOG_DEFAULT')
            ),
            'EPILOG'         => array(
                'NAME'    => Loc::getMessage($BXMAKER_COMPONENT_NAME . 'EPILOG'),
                'TYPE'    => 'STRING',
                'DEFAULT' => Loc::getMessage($BXMAKER_COMPONENT_NAME . 'EPILOG_DEFAULT')
            ),
            'DEFAULT_WEIGHT' => array(
                'NAME'    => Loc::getMessage($BXMAKER_COMPONENT_NAME . 'DEFAULT_WEIGHT'),
                'TYPE'    => 'STRING',
                'DEFAULT' => '800'
            ),
            'PERSONAL_TYPE'  => array(
                'NAME'    => Loc::getMessage($BXMAKER_COMPONENT_NAME . 'PERSONAL_TYPE'),
                'TYPE'    => 'LIST',
                'DEFAULT' => '1',
                'VALUES'  => $arPersonTypes
            ),
        ),
    );


