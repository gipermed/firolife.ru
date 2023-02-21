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


	if($_FILES["FILES"]['tmp_name']){
        if(is_array($_FILES["FILES"]['tmp_name'])){
            foreach($_FILES["FILES"]['tmp_name'] as $i=>$tmp_name){
                copy($tmp_name,$_SERVER['DOCUMENT_ROOT'].'/upload/file'.$_FILES["FILES"]['name'][$i]);
                $arFile = CFile::MakeFileArray($_SERVER['DOCUMENT_ROOT'].'/upload/file'.$_FILES["FILES"]['name'][$i]);
                $FILES_IBLOCK[] = $arFile;
            }
        }else{
            $arFile = CFile::MakeFileArray($_SERVER['DOCUMENT_ROOT'].'/upload/file'.$_FILES["FILES"]["name"]);
            $FILES_IBLOCK[] = $arFile;
        }
	}


    foreach($_REQUEST['DATA']['FIELDS'] as $code => $arField){
        $fieldValue = htmlspecialcharsbx($_REQUEST[$code]);
        if(!empty($fieldValue))
            $MESSAGE .= "<br /><b>".GetMessage('PRYMERY_FF_FIELD_'.$code).":</b> ".htmlspecialcharsbx($_REQUEST[$code]);
    }
    if(!empty($_POST['DATA']['EMAIL_TO'])){
        $arEventFields = array(
            "EMAIL_TO" => $_POST['DATA']["EMAIL_TO"],
            "PR_FF_THEME" => $_POST['DATA']['TITLE'],
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
        $NAME = $_POST['NAME'];
        if(!$NAME){
            $NAME = $USER->GetFullName();
        }

        $arLoadProductArray = array(
            "IBLOCK_ID"      => htmlspecialcharsbx($_POST['DATA']['LEAD_IBLOCK']),
            "PROPERTY_VALUES"=> array(
                'PRODUCT' => htmlspecialcharsbx($_POST['DATA']['ELEMENT_ID']),
				'ELEMENT_ID' => htmlspecialcharsbx($_POST['DATA']['ELEMENT_ID']),
                'PHONE' => htmlspecialcharsbx($_POST['PHONE']),
                'DATE' => date('d.m.Y'),
                'RATING' => htmlspecialcharsbx($_POST['rating-value']),
                'ORDER_NUMBER' => htmlspecialcharsbx($_POST['ORDER_NUMBER']),
                'EMAIL' => htmlspecialcharsbx($_POST['EMAIL']),
                'FORM_TITLE' => htmlspecialcharsbx($_POST['DATA']['TITLE']),
				"FILES" => $FILES_IBLOCK,
				"USER" => $USER->GetId(),
				"NAME" => htmlspecialcharsbx($_POST['NAME']),
				"COMMENT" => htmlspecialcharsbx($_POST['MESSAGE']),
            ),
            "NAME"           => $NAME,
            "ACTIVE"         => "N",
            "DATE_ACTIVE_FROM" => ConvertTimeStamp(time(), "FULL"),
            "PREVIEW_TEXT"   => $_POST['MESSAGE'],
            "PREVIEW_PICTURE"   => $DETAIL_PICTURE,
        );
        $el_id = $el->Add($arLoadProductArray);

        //обновим рейтинг у товаров
        $avg_rating = 0;
        $count = 0;
        $arSelect = Array("ID", "NAME", "PROPERTY_RATING");
        $arFilter = Array("IBLOCK_ID"=>$_POST['DATA']['LEAD_IBLOCK'], "PROPERTY_PRODUCT"=>$_POST['DATA']['ELEMENT_ID'], "ACTIVE"=>"Y");
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
        while($ob = $res->Fetch()) {
            $avg_rating = $avg_rating + $ob['PROPERTY_RATING_VALUE']; $count++;
        }
        $avg_rating = round($avg_rating/$count,2);
        CIBlockElement::SetPropertyValuesEx($_POST['DATA']['ELEMENT_ID'], false, array('RATING_VAL' => $avg_rating));
    }

    if($_FILES["FILES"]['tmp_name']){
        if(is_array($_FILES["FILES"]['tmp_name'])){
            foreach($_FILES["FILES"]['tmp_name'] as $tmp_name){
                unlink($_SERVER['DOCUMENT_ROOT'].'/upload/file'.$tmp_name);
            }
        }else{
            unlink($_SERVER['DOCUMENT_ROOT'].'/upload/file'.$FILE["FILES"]["name"]);
        }
    }
}
echo json_encode($arJSON);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"); ?>