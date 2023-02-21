<? require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
$GLOBALS["APPLICATION"]->IncludeComponent("rngdv:favorites", "", array(
	"CACHE_TIME"     => 3600,
	"FILTER_NAME"    => "favFilter",
	"HL_ENTITY_NAME" => "Favorites"
));