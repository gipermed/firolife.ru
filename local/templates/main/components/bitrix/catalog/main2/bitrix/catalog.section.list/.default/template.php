<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="catalog-menu hidden-tablet">

<?
//var_dump($arResult);
$selected=isset($arResult['SELECTED_SECTION']);
$depth_level=2;
$nav=[];
$selected_id=$arResult["SECTIONS"][$arResult['SELECTED_SECTION']]['ID'];
if($selected):

?>
    <ul class="catalog-menu-list">

        <?php foreach ($arResult["CATALOGS_CHAIN"] as $key=>$value):?>

        <? if($value['ID']==$selected_id):?>
                <li><div class="catalog-menu-nav-current"><?=$arResult["SECTIONS"][$arResult['SELECTED_SECTION']]["NAME"]?></div></li>
            <? else:?>
                <li><a href="<?=$value["SECTION_PAGE_URL"]?>">&#60;&nbsp;<?=$value["NAME"]?></a></li>
            <? endif;?>

        <?php endforeach;?>
    </ul>
    <ul class="catalog-menu-list catalog-menu-list-inside">
        <?php
	$depth_level=$arResult["SECTIONS"][$arResult['SELECTED_SECTION']]["DEPTH_LEVEL"]+1;
	    else: ?>
	        <ul class="catalog-menu-list catalog-menu-list-inside">
	    <?
        endif;
        ?>

        <?

foreach ($arResult["SECTIONS"] as $arSection)
{
	if($arSection["DEPTH_LEVEL"]==$depth_level &&
        ($arSection['IBLOCK_SECTION_ID']==$arResult["SECTIONS"][$arResult['SELECTED_SECTION']]['ID'] || !$selected)):?>
        <li id="<?=$this->GetEditAreaId($arSection['ID']);?>"><a
                    href="<?=$arSection["SECTION_PAGE_URL"]?>"><?=$arSection["NAME"]?></a></li>
	<?endif;

}
/*
$CURRENT_DEPTH=$arResult["SECTION"]["DEPTH_LEVEL"]+1;
foreach($arResult["SECTIONS"] as $arSection):
	$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
	$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));
	if($CURRENT_DEPTH<$arSection["DEPTH_LEVEL"])
		echo "<ul>";
	elseif($CURRENT_DEPTH>$arSection["DEPTH_LEVEL"])
		echo str_repeat("</ul>", $CURRENT_DEPTH - $arSection["DEPTH_LEVEL"]);
	$CURRENT_DEPTH = $arSection["DEPTH_LEVEL"];
?>
	<li id="<?=$this->GetEditAreaId($arSection['ID']);?>"><a
                href="<?=$arSection["SECTION_PAGE_URL"]?>"><?=$arSection["NAME"]?></a></li>
<?endforeach*/?>
</ul>
</div>
