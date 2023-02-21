<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

if (!$USER->IsAuthorized()) {
	$APPLICATION->ShowAuthForm();
	return;
}
if (!($arResult = CUser::GetByLogin($USER->GetLogin())->Fetch())) {
	return;
}
if ($_REQUEST['action'] == 'delete') {
		$USER->Update($USER->GetID(), array(
											'ACTIVE' => 'N',
											'UF_ASD_SELFDELETE' => date($DB->DateFormatToPHP(CLang::GetDateFormat('FULL')))));
		$USER->Logout();
	LocalRedirect("/auth/");
}
$this->IncludeComponentTemplate();