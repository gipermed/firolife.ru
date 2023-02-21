<? require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetPageProperty("description", "Личные данные");
$APPLICATION->SetTitle("Личные данные");
$APPLICATION->SetPageProperty('title', 'Личные данные');

if (!$USER->IsAuthorized())
{
	$_SESSION["BACKURL"] = $APPLICATION->GetCurPage();
	LocalRedirect("/auth/");
}
?>


<? $APPLICATION->IncludeComponent("palladiumlab:user.profile", "main3", []) ?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>