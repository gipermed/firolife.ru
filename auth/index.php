<? require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
if ($GLOBALS["USER"]->IsAuthorized())
{
	$backurl = $_SESSION["BACKURL"];
	$backurl = strlen($backurl) ? $backurl : "/personal/";
	LocalRedirect($backurl);
}
?>

<? $APPLICATION->IncludeComponent("bitrix:system.auth.form", ".default", array(
		"REGISTER_URL"        => "",
		"FORGOT_PASSWORD_URL" => "",
		"PROFILE_URL"         => "",
		"SHOW_ERRORS"         => "Y"
	), false); ?>

<? require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php'); ?>
