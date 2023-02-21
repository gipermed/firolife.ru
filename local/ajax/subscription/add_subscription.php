<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader;
\Bitrix\Main\Loader::includeModule('iblock');
$el = new \CIBlockElement;

if($_REQUEST['EMAIL']) {
        $host = 'https://api.sendpulse.com/addressbooks/{id}/emails';
//        $guid_transaction = guid_generate();
//        $postData = array(
//            'ИдентификаторТранзакции' => $guid_transaction,
//            'ИдентификаторИсточника' => $GUID_SOURCE,
//            'ИдентификаторЛичногоКабинета' => $user['UF_GUID'],
//            'Indicators' => $arLk[$user['UF_GUID']],
//        );
//        $postData = json_encode($postData);
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $host.$user['UF_GUID']);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
//
//        $result = curl_exec($ch);
//        $arResult = json_decode($result);
//
//        if (curl_errno($ch)) {
//            echo 'Error:' . curl_error($ch);
//        }
//        curl_close($ch);
//    }
}

