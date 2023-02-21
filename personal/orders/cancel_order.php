<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Новая страница");
$APPLICATION->IncludeComponent("bitrix:sale.personal.order.cancel", "", [
	"PATH_TO_LIST" => "index.php",
	"ID"           => $ID,
])
?>


<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>