<?
if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') die();
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if($_REQUEST['ACTION'] == 'select' && $_REQUEST['CITY']){
    $res = \Bitrix\Sale\Location\LocationTable::getList(array(
        'filter' => array('NAME_RU' =>$_REQUEST['CITY']),
        'select' => array('ID','NAME_RU' => 'NAME.NAME','PARENT_NAME' => 'PARENT.NAME.NAME')
    ));
    while ($item = $res->fetch()) {
        $curCity = $item['ID'];
    }
    echo json_encode($curCity);
}
if($_REQUEST['ACTION'] == 'selectById' && $_REQUEST['CITY']){
    $res = \Bitrix\Sale\Location\LocationTable::getList(array(
        'filter' => array('ID' =>$_REQUEST['CITY']),
        'select' => array('ID','NAME_RU' => 'NAME.NAME','PARENT_NAME' => 'PARENT.NAME.NAME')
    ));
    while ($item = $res->fetch()) {
        $curCity = $item['NAME_RU'];
    }
    echo json_encode($curCity);
}
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"); ?>