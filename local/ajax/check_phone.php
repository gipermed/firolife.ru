<?
if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') die();
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if($_REQUEST['PHONE'] && $_REQUEST['ACTION'] == 'SEND'):
    \Bitrix\Main\Loader::includeModule('bxmaker.authuserphone');
    $oManager = \Bxmaker\AuthUserPhone\Manager::getInstance();
    if($oManager->isValidPhone($_REQUEST['PHONE'])) {
        if($oManager->isOverLimitAttempts($_REQUEST['PHONE'], $siteId = null)) {
            //error кол-во попыток превышено
            $response['ERROR']['LIMIT'] = 'Y';
        }else{
            $res = $oManager->sendCode('7 999 111-22-33');
            if($res->isSuccess()){
                $response['MSG'] = $res->getMore('MSG');
                $response['TIME'] = $res->getMore('TIME');
            }else{
                // если номер телефона введен с ошибками
                // если не истекло время таймаута до возможности отправить код повторно
                $arErrors = $res->getErrors();
                foreach($arErrors as $obError) {
                    $response['ERROR']['MSG'][] = $obError->getMessage();
                }
            }
        }
    }
    echo json_encode($response);
endif;
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"); ?>