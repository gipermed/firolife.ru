<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<div class="product-detail__availability">
    <svg xmlns="http://www.w3.org/2000/svg" width="0" height="0" style="position:absolute">
        <symbol id="icon-metro" viewBox="0 0 24 24">
            <path d="M21 10.107C21 5.09302 16.9886 1 12 1C7.01143 1 3 5.09302 3 10.107C3 12.614 4.02857 14.9163 5.62286 16.5535C5.77714 16.707 5.93143 16.7581 6.13714 16.7581C6.54857 16.7581 6.85714 16.4512 6.85714 16.0419C6.85714 15.8372 6.75429 15.6326 6.65143 15.5302C5.31429 14.1488 4.44 12.2558 4.44 10.1581C4.44 5.96279 7.83429 2.53488 12 2.53488C16.1657 2.53488 19.56 5.96279 19.56 10.1581C19.56 12.2558 18.7371 14.1488 17.3486 15.5302L10.9714 21.9256L12 23L18.3771 16.5535C19.9714 14.9163 21 12.614 21 10.107Z" fill="currentColor"/>
            <path d="M16.1654 11.8464L13.9025 6.11621L11.9997 9.49296L10.1482 6.11621L7.88537 11.8464H7.2168V12.7162H10.6111V11.8464H10.0968L10.6111 10.4139L11.9997 12.8185L13.4397 10.4139L13.9539 11.8464H13.4397V12.7162H16.8339V11.8464" fill="currentColor"/>
        </symbol>
    </svg>
	<? if(!empty($arResult["STORES"]) && $arParams["MAIN_TITLE"] != ''):?>
		<h4 class="product-detail__availability-title"><?=$arParams["MAIN_TITLE"]?></h4>
	<?endif;?>
	<div class="bx_storege" id="catalog_store_amount_div">
		<?if(!empty($arResult["STORES"])):?>
			<ul id="c_store_amount" class="availability-list">
				 <?php
                $vir = 0;
                ?>
			<?foreach($arResult["STORES"] as $pid => $arProperty):

                $arUF = $GLOBALS["USER_FIELD_MANAGER"]->GetUserFields ('CAT_STORE', $arProperty['ID']);
                ?>
				<li style="<? echo ($arParams['SHOW_EMPTY_STORE'] == 'N' && isset($arProperty['REAL_AMOUNT']) && $arProperty['REAL_AMOUNT'] <= 0 || $arProperty['ID'] == 17 ? 'display: none' : ''); ?>;">
					<?if (isset($arProperty["TITLE"])):?>
                        <div class="char">
                            <?if($arProperty["TITLE"] == 'Виртуальный Склад' && $arProperty['REAL_AMOUNT']>0){$vir = 1;}?>
                            <?if($arProperty["TITLE"] == 'Основной склад'):?>
                                <div class="caption">Интернет-магазин</div>
                            <?elseif($arProperty["TITLE"] != 'Виртуальный Склад'):?>
                                <div class="caption">Магазин</div>
                                <a href="/contacts/#shop_<?=$arProperty["ID"]?>" style="color:<?=$arUF['UF_COLOR']['VALUE']?>;">
                                    <?/*svg width="24" height="24" class="icon"><use xlink:href="#icon-metro"></use></svg*/?><?=str_replace('Магазин ','',$arProperty["TITLE"]);?>
                                </a>
                            <?endif;?>
                        </div>
					<?endif;?>
					<?/*if (isset($arProperty["IMAGE_ID"]) && !empty($arProperty["IMAGE_ID"])):?>
						<span class="schedule"><?=GetMessage('S_IMAGE')?> <?=CFile::ShowImage($arProperty["IMAGE_ID"], 200, 200, "border=0", "", true);?></span>
					<?endif;?>
					<?if (isset($arProperty["PHONE"])):?>
						<span class="tel"><?=GetMessage('S_PHONE')?> <?=$arProperty["PHONE"]?></span>
					<?endif;?>
					<?if (isset($arProperty["SCHEDULE"])):?>
						<span class="schedule"><?=GetMessage('S_SCHEDULE')?> <?=$arProperty["SCHEDULE"]?></span>
					<?endif;?>
					<?if (isset($arProperty["EMAIL"])):?>
						<span><?=GetMessage('S_EMAIL')?> <?=$arProperty["EMAIL"]?></span>
					<?endif;?>
					<?if (isset($arProperty["DESCRIPTION"])):?>
						<span><?=GetMessage('S_DESCRIPTION')?> <?=$arProperty["DESCRIPTION"]?></span>
					<?endif;?>
					<?if (isset($arProperty["COORDINATES"])):?>
						<span><?=GetMessage('S_COORDINATES')?> <?=$arProperty["COORDINATES"]["GPS_N"]?>, <?=$arProperty["COORDINATES"]["GPS_S"]?></span>
					<?endif;*/?>
					<?/*if ($arParams['SHOW_GENERAL_STORE_INFORMATION'] == "Y") :?>
						<?=GetMessage('BALANCE')?>:
					<?else:?>
						<?=GetMessage('S_AMOUNT')?>
					<?endif;*/?>
					<span class="val balance" id="<?=$arResult['JS']['ID']?>_<?=$arProperty['ID']?>">
                        <?if($arProperty['REAL_AMOUNT']>0 && $arProperty["TITLE"] != 'Основной склад' && $arProperty["TITLE"] != 'Виртуальный Склад'):?>
                            <div class="available">В наличии</div>
                        <?elseif($arProperty["TITLE"] != 'Основной склад' && $arProperty["TITLE"] != 'Виртуальный Склад'):?>
                            <div class="unavailable">Нет в наличии</div>
                        <?endif;?>
                        <?if($arProperty["TITLE"] == 'Основной склад' &&  ($arProperty['REAL_AMOUNT']>0 || $vir == 1)):?>
                        <div class="available">В наличии</div>
                        <?elseif($arProperty["TITLE"] == 'Основной склад' &&  $vir == 0 && $arProperty['REAL_AMOUNT']==0):?>
                            <div class="unavailable">Нет в наличии</div>
                        <?endif;?>
                    </span>
					<?
					if (!empty($arProperty['USER_FIELDS']) && is_array($arProperty['USER_FIELDS']))
					{
						foreach ($arProperty['USER_FIELDS'] as $userField)
						{
							if (isset($userField['CONTENT']))
							{
								?><span><?=$userField['TITLE']?>: <?=$userField['CONTENT']?></span><br /><?
							}
						}
					}
					?>
				</li>
			<?endforeach;?>
			</ul>
		<?endif;?>
	</div>
	<?if (isset($arResult["IS_SKU"]) && $arResult["IS_SKU"] == 1):?>
		<script type="text/javascript">
			var obStoreAmount = new JCCatalogStoreSKU(<? echo CUtil::PhpToJSObject($arResult['JS'], false, true, true); ?>);
		</script>
		<?
	endif;?>
</div>