<?

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

// вывод для проверки
/*
  $arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", "CODE");
$arFilter = Array("IBLOCK_ID"=>36, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>500), $arSelect);
while($ob = $res->GetNextElement())
{
 $arFields = $ob->GetFields();
    echo '<pre>';
 print_r($arFields["NAME"]);
 print_r($arFields["CODE"]);
    echo '<pre>';
}

$property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>98, "CODE"=>"PROIZVODITEL"));
while($enum_fields = $property_enums->GetNext())
{
    if($enum_fields["ID"]>'4549'){
        echo $enum_fields["ID"]." - ".$enum_fields["VALUE"]."<br>";
    }
}
*/



// обновление инфоблока производителей
/*
$property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>98, "CODE"=>"PROIZVODITEL"));
while($enum_fields = $property_enums->GetNext())
{
    if($enum_fields["ID"]>'4549') {
        echo $enum_fields["ID"] . " - " . $enum_fields["VALUE"] . "<br>";

        $el = new CIBlockElement;

        $PROP = array();
        $PROP[12] = "Белый";  // свойству с кодом 12 присваиваем значение "Белый"
        $PROP[3] = 38;        // свойству с кодом 3 присваиваем значение 38

        $arLoadProductArray = array(
            "MODIFIED_BY" => $USER->GetID(), // элемент изменен текущим пользователем
            "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
            "IBLOCK_ID" => 36,
            "NAME" => $enum_fields["VALUE"],
            "CODE" => $enum_fields["VALUE"],
            "ACTIVE" => "N",            // активен
        );

        if ($PRODUCT_ID = $el->Add($arLoadProductArray))
            echo "New ID: " . $PRODUCT_ID;
        else
            echo "Error: " . $el->LAST_ERROR;
    }
}
*/
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"); ?>