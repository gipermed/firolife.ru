<?
if($_REQUEST['ajax']){
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
}else{
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
}?>
<div class="modalFeedback">
    <?
    $APPLICATION->IncludeComponent(
        "prymery:feedback.form",
        "feedback",
        array(
            "ARFIELDS" => array(
                0 => "RATING",
                1 => "PHONE",
                2 => "EMAIL",
                3 => "NAME",
                4 => "MESSAGE",
            ),
            "REQUEST_ARFIELDS" => array(
                0 => "NAME",
                1 => "PHONE",
                2 => "EMAIL",
            ),
            "CUSTOM_CLASS" => "modal-feedback",
            "CUSTOM_CLASS_FORM" => "feedback-form",
            "COMPONENT_TEMPLATE" => ".default",
            "EMAIL_TO" => "apdnnb@mail.ru",
			"SUCCESS_MESSAGE_TITLE" => "Сообщение отправлено",
            "SUCCESS_MESSAGE" => "Мы перезвоним вам в течение 15 минут",
            "GOAL_METRIKA" => "",
            "GOAL_ANALITICS" => "",
            "USE_CAPTCHA" => "N",
            "SAVE" => "Y",
            "BUTTON" => "Отправить",
            "TITLE" => "Связаться с нами",
            "SUBTITLE" => "",
            "PERSONAL_DATA" => "Y",
            "PERSONAL_DATA_PAGE" => "/policy/",
            "LEAD_IBLOCK" => ""
        ),
        false
    ); ?>
</div>
<?
if($_REQUEST['ajax']){
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
}else{
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
}?>
