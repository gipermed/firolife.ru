<? require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetPageProperty("description", "Профиль");
$APPLICATION->SetTitle("Профиль");
$APPLICATION->SetPageProperty('title', 'Профиль');

if (!$USER->IsAuthorized())
{
	$_SESSION["BACKURL"] = $APPLICATION->GetCurPage();
	LocalRedirect("/auth/");
}
?><?$APPLICATION->IncludeComponent(
	"palladiumlab:user.profile3",
	"main",
Array()
);?><?
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php');
?>