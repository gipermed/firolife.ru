<?
if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') die();
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if($_REQUEST['DEL']):    
    global $USER;
//    CUser::Delete($USER->GetId());

$fields = Array("ACTIVE" => "N"); 
$USER->Update($USER->GetId(),$fields);
$USER->Logout();
    echo json_encode(1);
endif;
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"); ?>