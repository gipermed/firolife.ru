<? require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetTitle("");
$APPLICATION->SetPageProperty('title', 'Лист ожидания');

use Bitrix\Main\Loader;

Loader::includeModule("highloadblock");

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

if (!$USER->IsAuthorized())
{
	$_SESSION["BACKURL"] = $APPLICATION->GetCurPage();
	LocalRedirect("/auth/");
}
?>
	<script type="text/javascript">
		$( init );
		function init() {
			$('#myButton').bind( 'click', sayHello );
		}
		function sayHello() {
			alert( "Всем - привет!" );
		}
	</script>
	<div>
		<input type="button" id="myButton" value="Нажми меня" />
	</div>



 <? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>