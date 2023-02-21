<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $templateData */
/** @var @global CMain $APPLICATION */
/** @var array $arResult */
global $APPLICATION;
$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

$navNum = $arResult['NAV_NUM'];
$navNumFromRequest = $request->get("navNum");


$isAjax = $request->isAjaxRequest() && $navNumFromRequest && $navNumFromRequest == $navNum;

if ($isAjax)
{
	$content = ob_get_contents();
	ob_end_clean();
	$APPLICATION->RestartBuffer();

	list(, $items) = explode("<!--items-$navNum-->", $content);
	list(, $pagen) = explode("<!--pagen-$navNum-->", $content);


	echo json_encode(array(
		"items" => $items,
		"pagen" => $pagen,
	));
	die();
}


