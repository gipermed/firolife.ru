<?
if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') die();
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if($_REQUEST['FIELD'] || $_REQUEST['VAL'] || $_REQUEST['PROMO_UPDATE']):
    global $USER;
    $user = new CUser;

    if($_REQUEST['FIELD'] == 'GENDER'){
        if($_REQUEST['VAL'] == 'val-1'){
            $gender = '';
        }
        if($_REQUEST['VAL'] == 'val-2'){
            $gender = 'M';
        }
        if($_REQUEST['VAL'] == 'val-3'){
            $gender = 'F';
        }
        $fields = Array(
            "PERSONAL_GENDER" => $gender,
        );
        $user->Update($USER->GetId(), $fields);
    }
    if($_REQUEST['FIELD'] == 'HB'){
        $fields = Array(
            "PERSONAL_BIRTHDAY" => str_replace('/','.',$_REQUEST['VAL']),
        );
        $user->Update($USER->GetId(), $fields);
    }
    if($_REQUEST['FIELD'] == 'NAME'){
        $fields = Array(
            "NAME" => $_REQUEST['VAL'],
        );
        $user->Update($USER->GetId(), $fields);
    }
    if($_REQUEST['FIELD'] == 'ALL_PROMO'){
        if($_REQUEST['VAL'] == '1'){
            $val = true;
        }else{
            $val = false;
        }
        $fields = Array(
            "UF_PROMO_SMS" => $val,
            "UF_PROMO_MAIN" => $val,
            "UF_PROMO_CALL" => $val,
            "UF_REVIEWS_EMAIL" => $val,
            "UF_REVIEWS_CALL" => $val,
            "UF_SERVICE_EMAIL" => $val,
        );
        $user->Update($USER->GetId(), $fields);
    }

    if($_REQUEST['PROMO_UPDATE'] && $_REQUEST['FIELD'] == 'EMAIL'){
        $fields[$_REQUEST['FIELD']] = $_REQUEST['VAL'];
        $user->Update($USER->GetId(), $fields);
    }elseif($_REQUEST['PROMO_UPDATE']){
        if($_REQUEST['VAL'] == '1'){
            $val = true;
        }else{
            $val = false;
        }
        $fields[$_REQUEST['FIELD']] = $val;
        $user->Update($USER->GetId(), $fields);

        if($_REQUEST['FIELD'] == 'UF_PROMO_MAIN'){
            $filter = Array("ID"=>$USER->GetId());
            $rsUsers = CUser::GetList(($by="personal_country"), ($order="desc"), $filter);
            while($arUser = $rsUsers->Fetch()){
                $curUser = $arUser;
            }

            if($curUser['EMAIL']){
                if($val){
                    add_sendpulse_user(SENDPULS_PROMO_EMAIL,$curUser['EMAIL']);
                }else{
                    del_sendpulse_user(SENDPULS_PROMO_EMAIL,$curUser['EMAIL']);
                }
            }
        }
    }
    echo json_encode(1);
endif;
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"); ?>