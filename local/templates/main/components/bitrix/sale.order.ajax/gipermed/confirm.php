<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 * @var array $arResult
 * @var $APPLICATION CMain
 */

if ($arParams["SET_TITLE"] == "Y")
{
	$APPLICATION->SetTitle(Loc::getMessage("SOA_ORDER_COMPLETE"));
}
if($arResult["ORDER"]["ACCOUNT_NUMBER"]){
    $db_props = CSaleOrderPropsValue::GetOrderProps($arResult["ORDER"]["ACCOUNT_NUMBER"]);
    while ($arProps = $db_props->Fetch()) {
        $allProps[$arProps['CODE']] = $arProps['VALUE'];
    }

    $dbBasketItems = CSaleBasket::GetList(
        array("NAME" => "ASC"),
        array("FUSER_ID" => CSaleBasket::GetBasketUserID(),"LID" => SITE_ID,"ORDER_ID" => $arResult["ORDER"]["ACCOUNT_NUMBER"]),
        false,false,
        array("ID", "PRODUCT_ID","NAME", "QUANTITY", "PRICE", 'SUM')
    );
    while ($arItems = $dbBasketItems->Fetch()){
        $arBasketItems[] = $arItems;
        $allProducts[$arItems['PRODUCT_ID']] = $arItems['PRODUCT_ID'];
    }
    if($allProducts){
        CModule::IncludeModule('iblock');
        $arSelect = Array("ID", "NAME", "PREVIEW_PICTURE", 'PROPERTY_CML2_ARTICLE', 'PROPERTY_CML2_LINK');
        $arFilter = Array("ID"=>$allProducts, "ACTIVE"=>"Y");
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
        while($ob = $res->Fetch()) {
            if($ob['PREVIEW_PICTURE']){
                $ob['PICTURE'] = CFile::ResizeImageGet($ob['PREVIEW_PICTURE'], array('width'=>80, 'height'=>80), BX_RESIZE_IMAGE_PROPORTIONAL, true);
            }
            $allInfo[$ob['ID']] = $ob;

            if($ob['PROPERTY_CML2_LINK_VALUE']){
                $parents[$ob['PROPERTY_CML2_LINK_VALUE']] = $ob['PROPERTY_CML2_LINK_VALUE'];
            }
        }
        if($parents){
            $arSelect = Array("ID", "NAME", "PREVIEW_PICTURE", 'PROPERTY_CML2_ARTICLE', 'PROPERTY_CML2_LINK');
            $arFilter = Array("ID"=>$parents, "ACTIVE"=>"Y");
            $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
            while($ob = $res->Fetch()) {
                if($ob['PREVIEW_PICTURE']){
                    $ob['PICTURE'] = CFile::ResizeImageGet($ob['PREVIEW_PICTURE'], array('width'=>80, 'height'=>80), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                }
                $allInfo[$ob['ID']] = $ob;

                if($ob['PROPERTY_CML2_LINK_VALUE']){
                    $parents[$ob['PROPERTY_CML2_LINK_VALUE']] = $ob['PROPERTY_CML2_LINK_VALUE'];
                }
            }
        }
    }
}
?>
<? if (!empty($arResult["ORDER"])): ?>
    <?if($arResult["ORDER"]['STATUS_ID'] == 'P' || $arResult["ORDER"]['PAY_SYSTEM_ID'] == 3):?>
        <style>
            #loading_screen,.popup-window-overlay{display: none!important;}
        </style>
        <script>
            $('.order-modal__link').click();
        </script>
        <a href="#order-modal" class="order-modal__link" data-fancybox></a>
        <div style="display: none">
            <div class="order-modal" id="order-modal">
                <div class="order-modal__header">
                    <div class="order-modal__logo">
                        <img src="/local/templates/main//assets/img/logo.svg" alt="GiperMed">
                    </div>
                    <div class="order-modal__title">Спасибо за заказ</div>
                </div>
                <div class="order-modal__body">
                    <div class="order-modal__subtitle">
                        Ваш заказ оформлен. Пожалуйста, дождитесь подтверждения вашего заказа.
                    </div>
                    <div class="order-modal__chars">
                        <div class="order-modal__chars-item">
                            <div class="order-modal__chars-name">Номер заказа</div>
                            <div class="order-modal__chars-val"><?=$arResult["ORDER"]["ACCOUNT_NUMBER"]?></div>
                        </div>
                        <div class="order-modal__chars-item">
                            <div class="order-modal__chars-name">Дата</div>
                            <div class="order-modal__chars-val"><?=$arResult["ORDER"]["DATE_INSERT"]->toUserTime()->format('d.m.Y H:i')?></div>
                        </div>
                        <div class="order-modal__chars-item">
                            <div class="order-modal__chars-name">Сумма</div>
                            <div class="order-modal__chars-val"><?=number_format($arResult['ORDER']['PRICE'], 0, '', ' ');?> ₽.</div>
                        </div>
                        <div class="order-modal__chars-item">
                            <div class="order-modal__chars-name">Статус оплаты</div>
                            <div class="order-modal__chars-val">
                                <?if($arResult['ORDER']['STATUS_ID'] == 'P'):?>
                                    Оплачен
                                <?elseif($arResult['ORDER']['PAY_SYSTEM_ID'] == 2):?>
                                    не оплачен (<a href="/sale/payment.php?ORDER_ID=<?=$arResult["ORDER"]["ACCOUNT_NUMBER"]?>">оплатить онлайн</a>)
                                <?elseif($arResult['ORDER']['PAY_SYSTEM_ID'] == 3):?>
                                    оплата при получении
                                <?endif;?>
                            </div>
                        </div>
                        <div class="order-modal__chars-item">
                            <div class="order-modal__chars-name">Адрес доставки</div>
                            <div class="order-modal__chars-val"><?=$allProps["ADDRESS"];?></div>
                        </div>
                        <?if($allProps["DATE"]):?>
                            <div class="order-modal__chars-item">
                                <div class="order-modal__chars-name">Дата получения</div>
                                <div class="order-modal__chars-val"><?=$allProps["DATE"];?></div>
                            </div>
                        <?endif;?>
                    </div>
                </div>
                <?if($arBasketItems):?>
                    <div class="order-modal__basket">
                        <?foreach($arBasketItems as $item):?>
                            <div class="order-modal__basket-item">
                                <div class="order-modal__basket-picture">
                                    <?if($allInfo[$item['PRODUCT_ID']]['PICTURE']['src']):?>
                                        <img src="<?=$allInfo[$item['PRODUCT_ID']]['PICTURE']['src']?>" alt="">
                                    <?elseif($allInfo[$item['PRODUCT_ID']]['PROPERTY_CML2_LINK_VALUE'] && $parents[$allInfo[$item['PRODUCT_ID']]['PROPERTY_CML2_LINK_VALUE']]):?>
                                        <img src="<?=$parents[$allInfo[$item['PRODUCT_ID']]['PROPERTY_CML2_LINK_VALUE']]['PICTURE']['src']?>" alt="">
                                    <?endif;?>
                                </div>
                                <div class="order-modal__basket-info">
                                    <div class="order-modal__basket-name"><?=$item['NAME']?></div>
                                    <?if($allInfo[$item['PRODUCT_ID']]['PROPERTY_CML2_ARTICLE_VALUE']):?>
                                        <div class="order-modal__basket-article">Артикул: <?=$allInfo[$item['PRODUCT_ID']]['PROPERTY_CML2_ARTICLE_VALUE']?></div>
                                    <?elseif($allInfo[$item['PRODUCT_ID']]['PROPERTY_CML2_LINK_VALUE'] && $parents[$allInfo[$item['PRODUCT_ID']]['PROPERTY_CML2_LINK_VALUE']]):?>
                                        <div class="order-modal__basket-article">Артикул: <?=$parents[$allInfo[$item['PRODUCT_ID']]['PROPERTY_CML2_LINK_VALUE']]['PROPERTY_CML2_ARTICLE_VALUE']?></div>
                                    <?endif;?>
                                    <?/*div class="order-modal__basket-props">Цвет: белый</div*/?>
                                </div>
                                <div class="order-modal__basket-quantity">
                                    Количество : <?=$item['QUANTITY']?> шт
                                </div>
                                <div class="order-modal__basket-price">
                                    <?=number_format($item['PRICE'], 0, '', ' ');?> ₽
                                </div>
                            </div>
                        <?endforeach;?>
                        <div class="order-modal__basket-item order-modal__basket-delivery">
                            <div class="order-modal__basket-picture"></div>
                            <div class="order-modal__basket-info">
                                <div class="order-modal__basket-name">Доставка</div>
                            </div>
                            <div class="order-modal__basket-quantity"></div>
                            <div class="order-modal__basket-price">
                                <?=number_format($arResult['ORDER']['PRICE_DELIVERY'], 0, '', ' ');?> ₽
                            </div>
                        </div>
                        <div class="order-modal__total">
                            <div class="order-modal__total-title">
                                Итоговая стоимость:
                            </div>
                            <div class="order-modal__total-price">
                                <?=number_format($arResult['ORDER']['PRICE'], 0, '', ' ');?> ₽
                            </div>
                        </div>
                    </div>
                <?endif;?>
                <div class="order-modal__text">
                    <p>Вы можете следить за выполнением своего заказа (на какой стадии выполнения он находится), войдя личный кабинет интернет-магазина gipermed.com.</p>
                    <p>Оплатить заказ онлайн вы можете через личный кабинет интернет-магазина  gipermed.com.</p>
                    <p>Для того, чтобы аннулировать заказ, воспользуйтесь функцией отмены заказа, которая доступна личном кабинете интернет-магазина  gipermed.com.</p>
                    <p>Пожалуйста, при обращении к администрации сайта gipermed.com указывайте номер вашего заказа.</p>
                </div>
                <div class="order-modal__footer">
                    С уважением,<br>
                    администрация Интернет-магазина!
                </div>
                <div class="order-modal__btn">
                    <a href="/" class="btn btn-green">Вернуться на главную</a>
                </div>
            </div>
        </div>
    <?endif;?>
<div style="display: none;">
    <?if($arResult["ORDER"]['STATUS_ID'] != 'P' && $arResult["ORDER"]['PAY_SYSTEM_ID'] != 3):?>
        <style>
            html,body{
                display: none!important;
                opacity: 0!important;
            }
        </style>
        <script>
            $(document).ready(function(){
                if($('.payment_info a').attr('href')){
                    $('.sale_order_full_table a').click();
                    window.location.replace($('.payment_info a').attr('href'));
                }
                // document.location.href = $('.payment_info a').attr('href');
            });
        </script>
    <?endif;?>
	<table class="sale_order_full_table">
		<tr>
			<td>
				<?=Loc::getMessage("SOA_ORDER_SUC", array(
					"#ORDER_DATE#" => $arResult["ORDER"]["DATE_INSERT"]->toUserTime()->format('d.m.Y H:i'),
					"#ORDER_ID#" => $arResult["ORDER"]["ACCOUNT_NUMBER"]
				))?>
				<? if (!empty($arResult['ORDER']["PAYMENT_ID"])): ?>
					<?=Loc::getMessage("SOA_PAYMENT_SUC", array(
						"#PAYMENT_ID#" => $arResult['PAYMENT'][$arResult['ORDER']["PAYMENT_ID"]]['ACCOUNT_NUMBER']
					))?>
				<? endif ?>
				<? if ($arParams['NO_PERSONAL'] !== 'Y'): ?>
					<br /><br />
					<?=Loc::getMessage('SOA_ORDER_SUC1', ['#LINK#' => $arParams['PATH_TO_PERSONAL']])?>
				<? endif; ?>
			</td>
		</tr>
	</table>

	<?
	if ($arResult["ORDER"]["IS_ALLOW_PAY"] === 'Y')
	{
		if (!empty($arResult["PAYMENT"]))
		{
			foreach ($arResult["PAYMENT"] as $payment)
			{
				if ($payment["PAID"] != 'Y')
				{
					if (!empty($arResult['PAY_SYSTEM_LIST'])
						&& array_key_exists($payment["PAY_SYSTEM_ID"], $arResult['PAY_SYSTEM_LIST'])
					)
					{
						$arPaySystem = $arResult['PAY_SYSTEM_LIST_BY_PAYMENT_ID'][$payment["ID"]];

						if (empty($arPaySystem["ERROR"]))
						{
							?>
							<br /><br />

							<table class="sale_order_full_table payment_info">
								<tr>
									<td class="ps_logo">
										<div class="pay_name"><?=Loc::getMessage("SOA_PAY") ?></div>
										<?=CFile::ShowImage($arPaySystem["LOGOTIP"], 100, 100, "border=0\" style=\"width:100px\"", "", false) ?>
										<div class="paysystem_name"><?=$arPaySystem["NAME"] ?></div>
										<br/>
									</td>
								</tr>
								<tr>
									<td>
										<? if ($arPaySystem["ACTION_FILE"] <> '' && $arPaySystem["NEW_WINDOW"] == "Y" && $arPaySystem["IS_CASH"] != "Y"): ?>
											<?
											$orderAccountNumber = urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]));
											$paymentAccountNumber = $payment["ACCOUNT_NUMBER"];
											?>
											<script>
												window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=$orderAccountNumber?>&PAYMENT_ID=<?=$paymentAccountNumber?>');
											</script>
										<?=Loc::getMessage("SOA_PAY_LINK", array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".$orderAccountNumber."&PAYMENT_ID=".$paymentAccountNumber))?>
										<? if (CSalePdf::isPdfAvailable() && $arPaySystem['IS_AFFORD_PDF']): ?>
										<br/>
											<?=Loc::getMessage("SOA_PAY_PDF", array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".$orderAccountNumber."&pdf=1&DOWNLOAD=Y"))?>
										<? endif ?>
										<? else: ?>
											<?=$arPaySystem["BUFFERED_OUTPUT"]?>
										<? endif ?>
									</td>
								</tr>
							</table>

							<?
						}
						else
						{
							?>
							<span style="color:red;"><?=Loc::getMessage("SOA_ORDER_PS_ERROR")?></span>
							<?
						}
					}
					else
					{
						?>
						<span style="color:red;"><?=Loc::getMessage("SOA_ORDER_PS_ERROR")?></span>
						<?
					}
				}
			}
		}
	}
	else
	{
		?>
		<br /><strong><?=$arParams['MESS_PAY_SYSTEM_PAYABLE_ERROR']?></strong>
		<?
	}
	?>
</div>
<? else: ?>

	<b><?=Loc::getMessage("SOA_ERROR_ORDER")?></b>
	<br /><br />

	<table class="sale_order_full_table">
		<tr>
			<td>
				<?=Loc::getMessage("SOA_ERROR_ORDER_LOST", ["#ORDER_ID#" => htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"])])?>
				<?=Loc::getMessage("SOA_ERROR_ORDER_LOST1")?>
			</td>
		</tr>
	</table>

<? endif ?>