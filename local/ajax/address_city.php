<?
/*if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') die();
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if($_REQUEST['term']):
    $res = \Bitrix\Sale\Location\LocationTable::getList(array(
        'filter' => array('>=TYPE.ID' => '3', '<=TYPE.ID' => '5', '=NAME.LANGUAGE_ID' => LANGUAGE_ID, '=PARENT.NAME.LANGUAGE_ID' => LANGUAGE_ID, 'NAME_RU' =>$_REQUEST['term'].'%'),
        'select' => array('ID','NAME_RU' => 'NAME.NAME','PARENT_NAME' => 'PARENT.NAME.NAME',)
    ));

    while ($item = $res->fetch()) {
        $arJSON['results'][] = array('id' => $item['ID'],'text' => $item['NAME_RU'].'('.$item['PARENT_NAME'].')');
    }
    echo json_encode($arJSON);
endif;
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"); */?>
<?
/** @global \CMain $APPLICATION */

define("NOT_CHECK_PERMISSIONS", true);
define("STOP_STATISTICS", true);
define("NO_KEEP_STATISTIC", "Y");
define("NO_AGENT_STATISTIC", "Y");
define("DisableEventsCheck", true);
// define('BX_SECURITY_SESSION_READONLY', true);
define("PUBLIC_AJAX_MODE", true);

$siteId = isset($_REQUEST['siteId']) && is_string($_REQUEST['siteId']) ? $_REQUEST['siteId'] : '';
$siteId = substr(preg_replace('/[^a-z0-9_]/i', '', $siteId), 0, 2);
if (!empty($siteId) && is_string($siteId)) {
    define('SITE_ID', $siteId);
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$request->addFilter(new \Bitrix\Main\Web\PostDecodeFilter);

$signer = new \Bitrix\Main\Security\Sign\Signer;

try {
    $template = $signer->unsign($request->get('template'), 'prymery.geoip.city');
    $paramString = $signer->unsign($request->get('parameters'), 'prymery.geoip.city');
} catch (\Bitrix\Main\Security\Sign\BadSignatureException $e) {
    die();
}

if (!\Bitrix\Main\Loader::includeModule('prymery.geoip')) {
    die();
}

$oManager = \Prymery\GeoIP\Manager::getInstance();

$parameters = unserialize(base64_decode($paramString));

$parameters['IS_AJAX'] = 'Y';


$APPLICATION->IncludeComponent('prymery:geoip.city', $template, $parameters, false);


require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php');

