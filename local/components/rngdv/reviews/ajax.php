<?
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
//require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
$GLOBALS["APPLICATION"]->RestartBuffer();

$dir = explode("/", __DIR__);

do
{
	$component = array_pop($dir);
} while (strlen($component) <= 0 && count($dir) > 0);
do
{
	$namespace = array_pop($dir);
} while (strlen($namespace) <= 0 && count($dir) > 0);


$params = $_REQUEST["params"];

$arParams = $_REQUEST["params"] ? (new ComponentParamsSerializer)->unserialize($_REQUEST["params"]) : [];

$GLOBALS["APPLICATION"]->IncludeComponent("$namespace:$component", $arParams["COMPONENT_TEMPLATE"], $arParams, false);

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");