<div class="order-view">
    <h2>Заказ № <?= $arResult["ID"] ?></h2>

    <div class="order-view__date">от <?= $arResult["DATE_INSERT"]->format('d.m.Y H:i:s') ?></div>

    <table class="order-view__props">
        <tbody>
        <tr>
            <th>Статус</th>
            <td><b><?= $arResult["CANCELED"] == "Y" ? "Отменен" : $arResult["STATUS"]["NAME"] ?></b></td>
        </tr>
        </tbody>
    </table>

	<? /*?>
	<div class="order-view__divide">

		<h3>Ваш персональный менеджер по заказу</h3>

		<table class="order-view__props">
			<tbody>
			<tr>
				<th>Имя менеджера</th>
				<td></td>
			</tr>
			<tr>
				<th>Телефон</th>
				<td><?=$arResult["PROPS"]["PHONE"]?></td>
			</tr>
			<tr>
				<th>Email</th>
				<td><?=$arResult["PROPS"]["EMAIL"]?></td>
			</tr>
			</tbody>
		</table>

	</div>
		<?/**/ ?>


    <div class="order-view__divide">
        <h3>Данные заказа</h3>

        <table class="order-view__props">
            <tbody>
            <tr>
                <th>Город получения</th>
                <td><?= $arResult["PROPS"]["LOCATION"] ?></td>
            </tr>
            <tr>
                <th>Способ получения</th>
                <td><?= $arResult["SHIPMENT"]["0"]["DELIVERY"]["NAME"] ?></td>
            </tr>
            <tr>
                <th>Примечание</th>
                <td></td>
            </tr>
            <tr>
                <th>Получатель заказа</th>
                <td><?= $arResult["PROPS"]["FIO"] ?></td>
            </tr>

			<? foreach ($arResult['PAYMENT'] as $payment) : ?>
				<? if (count($arResult['PAYMENT']) > 1): ?>
                    <tr>
                        <th>Счет</th>
                        <td><?= $payment["TITLE"] ?></td>
                    </tr>
				<? endif ?>
                <tr>
                    <th>Способ оплаты</th>
                    <td><?= $payment["PAY_SYSTEM_NAME"] ?></td>
                </tr>

				<? if ($payment["STATUS"]): ?>
                    <tr>
                        <th>Статус оплаты</th>
                        <td><?= $payment["STATUS"] ?></td>
                    </tr>
				<? endif ?>

			<? endforeach ?>

            </tbody>
        </table>
    </div>

    <div class="order-view__payments">
		<?
		foreach ($arResult['PAYMENT'] as $payment)
		{
			if ($payment["ALLOW_TO_PAY"]) echo $payment['BUFFERED_OUTPUT'];
		}
		?>
    </div>

    <div class="order-view__goods order-goods orders-table-view">
        <table>
            <thead>
            <tr>
                <th class="order-goods__name">Наименование</th>
                <th class="order-goods__cost">Цена</th>
                <th class="order-goods__count">Кол-во</th>
                <th class="order-goods__total">Стоимость</th>
                <th class="order-goods__actions"></th>
            </tr>
            </thead>
            <tfoot>
            </tfoot>
            <tbody>
			<? $sum = 0; ?>
			<? $ids = [] ?>
			<? foreach ($arResult["BASKET"] as $item): ?>
                <tr>
                    <td class="order-goods__name">
						<? if ($item["PROP_VALS"]["SIZE"]): ?>
                            <div class="order-goods__wtis">Размер: <span
                                        class="order-goods__good-id"><?= $item["PROP_VALS"]["SIZE"] ?></span></div>
						<? endif ?>
                        <a href="<?= getCatalogProductUrl($item["PRODUCT_ID"], true) ?>"
                           class="order-goods__name-main c-black"><?= $item["NAME"] ?></a>
                    </td>
                    <td class="order-goods__cost"><?= \CCurrencyLang::CurrencyFormat($item["PRICE"], "RUB") ?> р.</td>
                    <td class="order-goods__count"><?= $item["QUANTITY"] ?></td><? $sum += $item["QUANTITY"] ?>
                    <td class="order-goods__total"><span
                                class="cost-value"><?= \CCurrencyLang::CurrencyFormat(str_replace(" ", "", $item["FORMATED_SUM"]), "RUB") ?> р.</span>
                    </td>

                    <td class="order-goods__actions">
						<? $ids[] = $item["PRODUCT_ID"] ?>
                        <a href="download.php?id=<?= $item["PRODUCT_ID"] ?>" target="_blank">
                            <span class="v-icon v-icon--rst" title="Сертификат соответствия"></span>
                        </a>
                    </td>
                </tr>
			<? endforeach; ?>
            </tbody>
        </table>

        <div class="order-goods__total-message">
            <div class="order-goods__orders-goods-count">
                <span><?= $sum ?></span>
                <span><?= pw($sum, "товар", "товара", "товаров") ?></span>
                <span>на сумму</span>
                <span class="cost-value"><?= \CCurrencyLang::CurrencyFormat($arResult["PRODUCT_SUM"], "RUB") ?> р.</span>
            </div>


            <div style="">
                <h3 class="order-goods__total-text">
                    Итого&nbsp;<?= \CCurrencyLang::CurrencyFormat(str_replace(" ", "", $arResult["PRICE_FORMATED"]), "RUB") ?>
                </h3>
                <span class="order-goods__cost-value">р.</span>
            </div>
        </div>

    </div>


    <div class="order-view__footer-actions">
        <a href="<?= $arResult["URL_TO_COPY"] ?>" class="order-view__repeat-btn v-btn v-btn--red v-btn--sm">
            Повторить заказ
        </a>
    </div>


    <div>
        <h3>Документы по товарам</h3>
        <div>
            <a href="download.php?id=<?= implode(",", $ids) ?>" target="_blank"
               class="order-view__download-doc c-black linkRedHover keepUnderline lnkUnd">
                <span class="v-icon v-icon--export-basket"></span>
                <span class="underlined" style="position: relative; top: -6px;">Сертификаты соответствия</span>
            </a>
        </div>

    </div>

</div>












































