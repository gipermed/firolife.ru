<?
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

$dir = explode("/", __DIR__);
do
{
	$template = array_pop($dir);
} while (strlen($template) <= 0 && count($dir) > 0);
do
{
	$skip = array_pop($dir);
} while (strlen($skip) <= 0 && count($dir) > 0);
do
{
	$component = array_pop($dir);
} while (strlen($component) <= 0 && count($dir) > 0);
do
{
	$namespace = array_pop($dir);
} while (strlen($namespace) <= 0 && count($dir) > 0);


$APPLICATION->IncludeComponent("$namespace:$component", "$template", [
		"EMAIL" => "no-reply@firolife.ru",
		"NAME"  => "Что улучшить?"
	], false);

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");