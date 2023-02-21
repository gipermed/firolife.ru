<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?CModule::IncludeModule('iblock');
if(!empty($arResult["CATEGORIES"]) && $arResult['CATEGORIES_ITEMS_EXISTS']):?>
	<table class="title-search-result">
		<?foreach($arResult["CATEGORIES"] as $category_id => $arCategory):?>
			<?foreach($arCategory["ITEMS"] as $i => $arItem):
                $arSelect = Array("ID", "NAME", "PREVIEW_PICTURE");
                $arFilter = Array("ID"=>$arItem['ITEM_ID'], "ACTIVE"=>"Y");
                $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
                while($ob = $res->Fetch()) {
                    if($ob['PREVIEW_PICTURE']){
                        $file = CFile::ResizeImageGet($ob['PREVIEW_PICTURE'], array('width'=>50, 'height'=>50), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                    }

                    $arItem['PICTURE'] = $file['src'];
                }
                ?>
			<tr>
				<?if($category_id === "all"):?>
				<?elseif(isset($arItem["ICON"])):?>
					<td class="title-search-item">
                        <a href="<?= $arItem["URL"]?>">
                            <?if($arItem['PICTURE']):?>
                                <img src="<?= $arItem['PICTURE']?>">
                            <?endif;?>
                           <span><?echo $arItem["NAME"]?></span>
                        </a>
                    </td>
				<?else:?>
					<td class="title-search-more"><a href="<?echo $arItem["URL"]?>"><?echo $arItem["NAME"]?></a></td>
				<?endif;?>
			</tr>
			<?endforeach;?>
		<?endforeach;?>
		<tr>
			<td class="title-search-separator">&nbsp;</td>
		</tr>
	</table><div class="title-search-fader"></div>
<?endif;
?>