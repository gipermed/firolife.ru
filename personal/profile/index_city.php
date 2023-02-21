<? require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetTitle("");
$APPLICATION->SetPageProperty('title', 'Лист ожидания');
?>

<?php
$iBlockID = 57;
$arSelect = Array("ID", "IBLOCK_ID", "NAME");//IBLOCK_ID
$arFilter = Array("IBLOCK_ID"=>$iBlockID, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
while($ob = $res->GetNextElement()){
    $arFields = $ob->GetFields();
    $arProps = $ob->GetProperties(
        array("sort" => "asc"),
        array("ID" => Array(14771,14772,14773,14774)));
    $arrResult['ID'] = $arFields['ID'];
    $arrResult['Ширина'] = $arProps['SHIRINA']['VALUE'];
    $arrResult['Высота'] = $arProps['VYSOTA']['VALUE'];
    $arrResult['Длина'] = $arProps['DLINA']['VALUE'];
    $arrResult['Вес'] = $arProps['VES']['VALUE'];

    if (CCatalogSKU::IsExistOffers($arFields['ID'], $iBlockID))
    {
        // Получение торговых предложений
        $resSKU = CCatalogSKU::getOffersList(
            $arFields['ID'],
            $iblockID = 0,
            $skuFilter = array(),
            $fields = array('ID'),
            $propertyFilter = array()
        );
        $arr = $resSKU[$arFields['ID']];

        foreach ($arr as $key => $value) {
            $PRODUCT_ID = $key; // id торгового предложения
            // Перечисление свойств
            $ar_Fields = array(
                'WEIGHT' => $arrResult['Вес'],
                'WIDTH' => $arrResult['Ширина'],
                'LENGTH' => $arrResult['Длина'],
                'HEIGHT' => $arrResult['Высота']
            );
            CCatalogProduct::Update($PRODUCT_ID, $ar_Fields);
        }
    }
    else
    {
        $ar_Fields = array(
           'WEIGHT' => $arrResult['Вес'],
           'WIDTH' => $arrResult['Ширина'],
           'LENGTH' => $arrResult['Длина'],
           'HEIGHT' => $arrResult['Высота']
        );
        CCatalogProduct::Update($arFields['ID'], $ar_Fields);
    }
}
?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>