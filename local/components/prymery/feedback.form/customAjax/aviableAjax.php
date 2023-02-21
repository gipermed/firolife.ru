<?
if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') die();
use Bitrix\Main\Loader;
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$arJSON = array('ERROR' => '', 'RESULT' => '');

include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/captcha.php");

if(!empty($_POST["captcha_sid"]) && $_POST["captcha_word"]){
    include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/captcha.php");
    $captcha_code = $_POST["captcha_sid"];
    $captcha_word = $_POST["captcha_word"];
    $cpt = new CCaptcha();
    $captchaPass = COption::GetOptionString("main", "captcha_password", "");
    if (strlen($captcha_word) > 0 && strlen($captcha_code) > 0)
    {
        if (!$cpt->CheckCodeCrypt($captcha_word, $captcha_code, $captchaPass))
            $arJSON['ERROR'] = GetMessage('PRYMERY_FF_ERROR_1');
        $arJSON['RESULT']["capCode"] =  htmlspecialcharsbx($APPLICATION->CaptchaGetCode());
        $arJSON['RESULT']["capSrc"] =  '/bitrix/tools/captcha.php?captcha_sid=' .$arJSON['RESULT']["capCode"];
    }
}

if(empty($arJSON['ERROR'])){
    $MESSAGE = '';
    $arFilter = Array(
        "TYPE_ID"       => array("FEEDBACK_FORM"),
        "ACTIVE"        => "Y",
        "SUBJECT"       => "#SITE_NAME#: #PR_FF_THEME#",
    );
    $rsMess = CEventMessage::GetList($by="site_id", $order="desc", $arFilter);
    while($arMess = $rsMess->GetNext()){
        $arResult['MESS_TEMPLATE_ID'] = $arMess['ID'];
    }
    if(!$arResult['MESS_TEMPLATE_ID']){
        $oEventMessage = new CEventMessage();
        $arFields = array("ACTIVE" => "Y", "EVENT_NAME" => "FEEDBACK_FORM", "LID" => SITE_ID, "EMAIL_FROM" => "#DEFAULT_EMAIL_FROM#", "EMAIL_TO" => "#EMAIL_TO#", "SUBJECT" => "#SITE_NAME#: #PR_FF_THEME#", "MESSAGE" => "#MESSAGE#", "BODY_TYPE" => "html");
        $oEventMessage->Add($arFields);
    }
	
	if($_FILES["FILE"]['tmp_name']){
		copy($_FILES["FILE"]['tmp_name'],$_SERVER['DOCUMENT_ROOT'].'/upload/file'.$_FILES["FILE"]["name"]);
    	$DETAIL_PICTURE = CFile::MakeFileArray($_SERVER['DOCUMENT_ROOT'].'/upload/file'.$_FILES["FILE"]["name"]);
	}

    foreach($_REQUEST['DATA']['FIELDS'] as $code => $arField){
        $fieldValue = htmlspecialcharsbx($_REQUEST[$code]);
        if(!empty($fieldValue))
            
            $MESSAGE .= "<br /><b>".GetMessage('PRYMERY_FF_FIELD_'.$code).":</b> ".htmlspecialcharsbx($_REQUEST[$code]);
    }
	$MESSAGE .= "<br /><b>".GetMessage('PRYMERY_FF_FIELD_PRODUCT').":</b> ".$_POST['DATA']['ELEMENT_ID'];
	$MESSAGE .= "<br /><b>".GetMessage('PRYMERY_FF_FIELD_STORE_ID').":</b> ".$_POST['DATA']['STORE_ID'];
	
	
    if(!empty($_POST['DATA']['EMAIL_TO'])){
        $arEventFields = array(
            "EMAIL_TO" => $_POST['DATA']["EMAIL_TO"],
            "PR_FF_THEME" => GetMessage('PRYMERY_FF_THEME'),
            "NAME" => htmlspecialcharsbx($_POST['DATA']["NAME"]),
            "MESSAGE" => $MESSAGE,
        );
        CEvent::Send(
            'FEEDBACK_FORM',
            SITE_ID,
            $arEventFields,
            'N',
            $arResult['MESS_TEMPLATE_ID'],
            (!empty($arFileID)) ? $arFileID : ''
        );
    }
    if($_POST['DATA']['SAVE'] == 'Y') {
        if (!Loader::includeModule("iblock")) {
            ShowError(GetMessage('PRYMERY_FF_ERROR_2'));
            return;
        }
        $el = new CIBlockElement;
        $dataActiveFrom = ConvertTimeStamp(time()+CTimeZone::GetOffset(), "FULL");
        $NAME = $_POST['FIO'];

        $arLoadProductArray = array(
            "IBLOCK_ID"      => htmlspecialcharsbx($_POST['DATA']['LEAD_IBLOCK']),
            "PROPERTY_VALUES"=> array(
                'PRODUCT' => htmlspecialcharsbx($_POST['DATA']['ELEMENT_ID']),
                'STORE_ID' => $_POST['DATA']['STORE_ID'],
                'STORE_NAME' => htmlspecialcharsbx($_POST['STORE_NAME']),
                'DATE' => date('d.m.Y'),
            ),
            "NAME"           => htmlspecialcharsbx($_POST['EMAIL']),
            "ACTIVE"         => "N",
        );
        $el->Add($arLoadProductArray);
    }
	
	if($_FILES["USER_PHOTO"]['tmp_name'])
  		unlink($_SERVER['DOCUMENT_ROOT'].'/upload/file'.$FILE["USER_PHOTO"]["name"]);
}
echo json_encode($arJSON);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"); ?>