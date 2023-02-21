<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="catalog-body">

    <div class="catalog-row products-row flex-row">
		<?foreach($arResult["ROWS"] as $arItems):?>
            <?foreach($arItems as $arElement):?>
                <div class="products-col swiper-slide">
                    <?
                    $this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arElement["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arElement["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCT_ELEMENT_DELETE_CONFIRM')));
                    ?>
                    <div class="product-item" id="<?=$this->GetEditAreaId($arElement['ID']);?>">

                        <a href="#" class="add-to-favorites-btn product-item-favorites" aria-label="Добавить в избранное" data-title="Добавить в избранное" data-title-active="Убрать из избранного">
                            <svg width="24" height="24"><use xlink:href="#icon-like"/></svg>
                        </a>
                        <div class="product-item-stikers">
                            <div class="product-item-stiker product-item-stiker-new">Новинка</div>
                        </div>


                        <a href="#" class="product-item-img product-item-img-no-photo">

                            <?if(is_array($arElement["PREVIEW_PICTURE"])):?>
                                <a href="<?=$arElement["DETAIL_PAGE_URL"]?>">
                                    <img border="0" src="<?=$arElement["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arElement["PREVIEW_PICTURE"]["WIDTH"]?>" height="<?=$arElement["PREVIEW_PICTURE"]["HEIGHT"]?>" alt="<?=$arElement["NAME"]?>" title="<?=$arElement["NAME"]?>" />
                                </a>
                            <?else:?>
                                <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/no-photo.svg" alt="" width="144">
                            <?endif?>
                        </a>
                        <div class="product-item-title">
                            <a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a>
                        </div>
                        <div class="product-item-foot">


							<?if(is_array($arElement["OFFERS"]) && !empty($arElement["OFFERS"])):?>
                                <!-- Показываем наименьшую для от -->
                                <div class="pricebl">
									<?
									$arPrice = [];
									$quantity = 1;
									$renewal = 'N';
									$mxResult = CCatalogSKU::GetInfoByProductIBlock($arParams['IBLOCK_ID']
									);
									if (is_array($mxResult))
									{
										$rsOffers = CIBlockElement::GetList(array("PRICE"=>"ASC"),array('IBLOCK_ID' => $mxResult['IBLOCK_ID'], 'PROPERTY_'.$mxResult['SKU_PROPERTY_ID'] => $arElement["ID"]));
										while ($arOffer = $rsOffers->GetNext())
										{
										    //var_dump($arOffer);
										    $ar_price = CCatalogProduct::GetOptimalPrice($arOffer['ID'], $quantity, $USER->GetUserGroupArray(), $renewal);
											//$ar_price = GetCatalogProductPrice($arOffer["ID"], 7);
											echo "<p>от " .$ar_price["PRICE"]. " руб.</p>" ;
											break;
										}
									}
									?>
                                </div>
                                <!-- Показываем предложения при наведении -->
								<?
								$idli=0;
								$idvlock=0;
								$idplus=0;
								$idminus=0;
								$idminusik=0;
								$idravno=0;
								?>
                                <div id="tabvanilla" class="widget">
                                    <ul class="tabnav">
										<?foreach($arElement["OFFERS"] as $arOffer):?>

											<?foreach($arOffer["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
                                                <li><a href="#<?=$arElement["ID"]?><?{ $idli++; echo $idli;}?>">
														<?
														if(is_array($arProperty["DISPLAY_VALUE"]))
															echo implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);
														else
															echo $arProperty["DISPLAY_VALUE"];
														?> кг.
                                                    </a></li>
											<?endforeach?>

										<?endforeach;?>
                                    </ul>
                                    <div style="clear:both;"></div>
									<?foreach($arElement["OFFERS"] as $arOffer):?>
                                        <div id="<?=$arElement["ID"]?><?{ $idvlock++; echo $idvlock;}?>" class="tabdiv">
											<?foreach($arOffer["PRICES"] as $code=>$arPrice):?>
												<?if($arPrice["CAN_ACCESS"]):?>
                                                    <p><?=$arPrice["PRINT_VALUE"]?></p>
												<?endif;?>
											<?endforeach;?>
                                            <form action="<?=POST_FORM_ACTION_URI?>" method="post" enctype="multipart/form-data">
                                                <!-- Кладем колличества товара -->
                                                <a class="MinusList" href="javascript:void(0)" onclick="if (BX('<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?><?=$arElement["ID"]?><?{ $idminus++; echo $idminus;}?>').value > 1) BX('<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?><?=$arElement["ID"]?><?{ $idminusik++; echo $idminusik;}?>').value--;">-</a>
                                                <input type="text" name="<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?>" value="1" size="5" class="qantinbsk" id="<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?><?=$arElement["ID"]?><?{ $idravno++; echo $idravno;}?>">
                                                <a class="PlusList" href="javascript:void(0)" onclick="BX('<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?><?=$arElement["ID"]?><?{ $idplus++; echo $idplus;}?>').value++;">+</a>

                                                <input type="hidden" name="<?echo $arParams["ACTION_VARIABLE"]?>" value="BUY">
                                                <input type="hidden" name="<?echo $arParams["PRODUCT_ID_VARIABLE"]?>" value="<?echo $arOffer["ID"]?>">
                                                <input type="submit" name="<?echo $arParams["ACTION_VARIABLE"]."BUY"?>" value="Купить" style="display:none;">
                                                <input type="submit" name="<?echo $arParams["ACTION_VARIABLE"]."ADD2BASKET"?>" value="В корзину" class="inbsk">
                                            </form>
                                        </div>
									<?endforeach;?>
                                </div>
							<?else:?><!-- Если предложений вообще нет -->
								<?foreach($arElement["PRICES"] as $code=>$arPrice):?>
									<?if($arPrice["CAN_ACCESS"]):?>
                                        <div class="nooffers">
											<?if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):?>
                                                <s><?=$arPrice["PRINT_VALUE"]?></s> <?=$arPrice["PRINT_DISCOUNT_VALUE"]?>
											<?else:?>
                                                <p><?=$arPrice["PRINT_VALUE"]?></p>
											<?endif;?>
                                            <noindex>
                                                <a href="<?echo $arElement["ADD_URL"]?>" rel="nofollow">В корзину</a>
                                            </noindex>
                                        </div>
									<?endif;?>
								<?endforeach;?>
							<?endif?>


                            <div class="product-item-prices">
                                <?foreach($arElement["PRICES"] as $code=>$arPrice):?>
                                    <div class="product-item-cost"><?=$arPrice["PRINT_VALUE"]?> ₽</div>

                                    <?if($arPrice["CAN_ACCESS"]):?>
                                        <div class="product-item-cost"><?=$arPrice["PRINT_VALUE"]?> ₽</div>
                                    <?endif;?>
                                <?endforeach;?>
                            </div>
							<?if($arElement["CAN_BUY"]):?>
                                <a href="#" OnClick="window.location='<?echo CUtil::JSEscape
									($arElement["DETAIL_PAGE_URL"])."#buy"?>'" class="btn btn-full product-item-btn add-to-cart-btn" data-text="В корзину" data-text-active="Добавлено">В корзину</a>
                            <?elseif((count($arResult["PRICES"]) > 0) || is_array($arElement["PRICE_MATRIX"])):?>
								<?=GetMessage("CATALOG_NOT_AVAILABLE")?>
							<?endif?>
                        </div>
                    </div>
                </div>
		    <?endforeach?>
		<?endforeach?>
    </div>
</div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
    <br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
<?php /*	<?foreach($arResult["ROWS"] as $arItems):?>
		<tr valign="top">
		<?foreach($arItems as $arElement):?>
		<?if(is_array($arElement)):?>
			<?
			$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arElement["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arElement["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCT_ELEMENT_DELETE_CONFIRM')));
			?>
			<td width="<?=$arResult["TD_WIDTH"]?>" id="<?=$this->GetEditAreaId($arElement['ID']);?>">
				<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td valign="top">
					<?if(is_array($arElement["PREVIEW_PICTURE"])):?>
						<a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><img border="0" src="<?=$arElement["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arElement["PREVIEW_PICTURE"]["WIDTH"]?>" height="<?=$arElement["PREVIEW_PICTURE"]["HEIGHT"]?>" alt="<?=$arElement["NAME"]?>" title="<?=$arElement["NAME"]?>" /></a>
					<?endif?>
					</td>
					<td valign="top">
						<a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a><br />
						<?foreach($arElement["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
							<small><?=$arProperty["NAME"]?>:&nbsp;<?
								if(is_array($arProperty["DISPLAY_VALUE"]))
									echo implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);
								else
									echo $arProperty["DISPLAY_VALUE"];?></small><br />
						<?endforeach?>
						<br />
						<?=$arElement["PREVIEW_TEXT"]?>
					</td>
				</tr>
				</table>
			</td>
		<?else:?>
			<td width="<?=$arResult["TD_WIDTH"]?>" rowspan="<?=$arResult["nRowsPerItem"]?>">
				&nbsp;
			</td>
		<?endif;?>
		<?endforeach?>
		</tr>
		<?if($arResult["bDisplayPrices"]):?>
			<tr valign="top">
			<?foreach($arItems as $arElement):?>
			<?if(is_array($arElement)):?>
				<td width="<?=$arResult["TD_WIDTH"]?>" class="data-cell">
				<?foreach($arElement["PRICES"] as $code=>$arPrice):?>
					<?if($arPrice["CAN_ACCESS"]):?>
						<p><?=$arResult["PRICES"][$code]["TITLE"];?>:&nbsp;&nbsp;
						<?if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):?>
							<s><?=$arPrice["PRINT_VALUE"]?></s> <span class="catalog-price"><?=$arPrice["PRINT_DISCOUNT_VALUE"]?></span>
						<?else:?>
							<span class="catalog-price"><?=$arPrice["PRINT_VALUE"]?></span>
						<?endif?>
						</p>
					<?endif;?>
				<?endforeach;?>
				<?if(is_array($arElement["PRICE_MATRIX"])):?>
				<table cellpadding="0" cellspacing="0" border="0" width="100%" class="data-table">
				<thead>
				<tr>
					<?if(count($arElement["PRICE_MATRIX"]["ROWS"]) >= 1 && ($arElement["PRICE_MATRIX"]["ROWS"][0]["QUANTITY_FROM"] > 0 || $arElement["PRICE_MATRIX"]["ROWS"][0]["QUANTITY_TO"] > 0)):?>
						<td><?=GetMessage("CATALOG_QUANTITY") ?></td>
					<?endif;?>
					<?foreach($arElement["PRICE_MATRIX"]["COLS"] as $typeID => $arType):?>
						<td><?=$arType["NAME_LANG"] ?></td>
					<?endforeach?>
				</tr>
				</thead>
				<?foreach ($arElement["PRICE_MATRIX"]["ROWS"] as $ind => $arQuantity):?>
				<tr>
					<?if(count($arElement["PRICE_MATRIX"]["ROWS"]) > 1 || count($arElement["PRICE_MATRIX"]["ROWS"]) == 1 && ($arElement["PRICE_MATRIX"]["ROWS"][0]["QUANTITY_FROM"] > 0 || $arElement["PRICE_MATRIX"]["ROWS"][0]["QUANTITY_TO"] > 0)):?>
						<th nowrap>
						<?if(IntVal($arQuantity["QUANTITY_FROM"]) > 0 && IntVal($arQuantity["QUANTITY_TO"]) > 0)
								echo str_replace("#FROM#", $arQuantity["QUANTITY_FROM"], str_replace("#TO#", $arQuantity["QUANTITY_TO"], GetMessage("CATALOG_QUANTITY_FROM_TO")));
							elseif(IntVal($arQuantity["QUANTITY_FROM"]) > 0)
								echo str_replace("#FROM#", $arQuantity["QUANTITY_FROM"], GetMessage("CATALOG_QUANTITY_FROM"));
							elseif(IntVal($arQuantity["QUANTITY_TO"]) > 0)
								echo str_replace("#TO#", $arQuantity["QUANTITY_TO"], GetMessage("CATALOG_QUANTITY_TO"));
							?>
						</th>
					<?endif;?>
					<?foreach($arElement["PRICE_MATRIX"]["COLS"] as $typeID => $arType):?>
						<td>
							<?if($arElement["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["DISCOUNT_PRICE"] < $arElement["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["PRICE"])
								echo '<s>'.FormatCurrency($arElement["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["PRICE"], $arElement["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["CURRENCY"]).'</s> <span class="catalog-price">'.FormatCurrency($arElement["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["DISCOUNT_PRICE"], $arElement["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["CURRENCY"])."</span>";
							else
								echo '<span class="catalog-price">'.FormatCurrency($arElement["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["PRICE"], $arElement["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["CURRENCY"])."</span>";
							?>&nbsp;
						</td>
					<?endforeach?>
				</tr>
				<?endforeach?>
				</table>
				<?endif?>
				</td>
			<?endif;?>
			<?endforeach?>
			</tr>
		<?endif;?>
		<?if($arResult["bDisplayButtons"]):?>
			<tr valign="top">
			<?foreach($arItems as $arElement):?>
			<?if(is_array($arElement)):?>
				<td>
				<?if($arParams["DISPLAY_COMPARE"]):?>
					<noindex><a href="<?echo $arElement["COMPARE_URL"]?>" rel="nofollow"><?echo GetMessage("CATALOG_COMPARE")?></a>&nbsp;</noindex>
				<?endif?>
				<?if($arElement["CAN_BUY"]):?>
					<input name="buy" type="button" value="<?= GetMessage("CATALOG_BUY") ?>" OnClick="window.location='<?echo CUtil::JSEscape($arElement["DETAIL_PAGE_URL"])."#buy"?>'" />
				<?elseif((count($arResult["PRICES"]) > 0) || is_array($arElement["PRICE_MATRIX"])):?>
					<?=GetMessage("CATALOG_NOT_AVAILABLE")?>
				<?endif?>
				</td>
			<?endif;?>
			<?endforeach?>
			</tr>
		<?endif;?>
	<?endforeach?>
</table>
</div>*/?>
