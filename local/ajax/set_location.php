<?
if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') die();
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if($_REQUEST['DATA']):
    if($_REQUEST['DATA']['city']){
        if($_REQUEST['DATA']['region']){
            $res = \Bitrix\Sale\Location\LocationTable::getList(array(
                'filter' => array('>=TYPE.ID' => '3', '<=TYPE.ID' => '5', '=NAME.LANGUAGE_ID' => LANGUAGE_ID, '=PARENT.NAME.NAME' => $_REQUEST['DATA']['region'], '=PARENT.NAME.LANGUAGE_ID' => LANGUAGE_ID, 'NAME_RU' =>$_REQUEST['DATA']['city']),
                'select' => array('ID','NAME_RU' => 'NAME.NAME','PARENT_NAME' => 'PARENT.NAME.NAME')
            ));
            while ($item = $res->fetch()) {
                $curCity = $item;
            }
        }
        if(!$curCity){
            $res = \Bitrix\Sale\Location\LocationTable::getList(array(
                'filter' => array('>=TYPE.ID' => '3', '<=TYPE.ID' => '5', '=NAME.LANGUAGE_ID' => LANGUAGE_ID, '=PARENT.NAME.LANGUAGE_ID' => LANGUAGE_ID, 'NAME_RU' =>$_REQUEST['DATA']['city']),
                'select' => array('ID','NAME_RU' => 'NAME.NAME','PARENT_NAME' => 'PARENT.NAME.NAME')
            ));
            while ($item = $res->fetch()) {
                $curCity = $item;
            }
        }
    }
    echo json_encode($curCity);
endif;
if($_REQUEST['ACTION'] == 'select' && $_REQUEST['CITY_ID']){
//    $APPLICATION->set_cookie('prymery.geoip.2.8.1_city_id',$_REQUEST['CITY_ID']);
//    $APPLICATION->set_cookie('prymery.geoip.2.8.1_location',$_REQUEST['CITY_ID']);

    setcookie('prymery.geoip.2.8.1_city_id',$_REQUEST['CITY_ID'], time()+(86400*30));
    setcookie('prymery.geoip.2.8.1_location',$_REQUEST['CITY_ID'], time()+(86400*30));

    echo json_encode(1);
}
if($_REQUEST['ACTION'] == 'select' && $_REQUEST['CITY_CODE']){
    $res = \Bitrix\Sale\Location\LocationTable::getList(array(
        'filter' => array('CODE' =>$_REQUEST['CITY_CODE']),
        'select' => array('ID','NAME_RU' => 'NAME.NAME','PARENT_NAME' => 'PARENT.NAME.NAME')
    ));
    while ($item = $res->fetch()) {
        $curCity = $item;
    }
//    $APPLICATION->set_cookie('prymery.geoip.2.8.1_city_id',$_REQUEST['CITY_ID']);
//    $APPLICATION->set_cookie('prymery.geoip.2.8.1_location',$_REQUEST['CITY_ID']);

//    setcookie('prymery.geoip.2.8.1_city_id',$curCity['ID'], time()+(86400*30));
//    setcookie('prymery.geoip.2.8.1_location',$curCity['ID'], time()+(86400*30));

    echo json_encode($curCity);
}
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"); ?>