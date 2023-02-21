<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Отмена подписки");
?>

<? $APPLICATION->IncludeComponent("bitrix:sale.personal.subscribe.cancel", "", array(
	"PATH_TO_LIST" => "await.php",
	"ID"           => $ID,
	"SET_TITLE"    => "Y"
),); ?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>