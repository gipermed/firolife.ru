<?
if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') die();
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$arJSON = array('RESULT' => '');
include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/captcha.php");
$arJSON['RESULT']["capCode"] =  htmlspecialcharsbx($APPLICATION->CaptchaGetCode());
$arJSON['RESULT']["capSrc"] =  '/bitrix/tools/captcha.php?captcha_sid=' .$arJSON['RESULT']["capCode"];
echo json_encode($arJSON);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"); ?>