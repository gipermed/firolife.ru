<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>


<table>
	<? foreach ([
					"FIO",
					"EMAIL",
					"PHONE",
					"CITY",
					"ADDRESS"
				] as $field): ?>
        <tr>
            <td><?= $arResult[$field]["NAME"] ?></td>
            <td><?= $arResult[$field]["VALUE"] ?></td>
        </tr>
	<? endforeach; ?>
    <tr>
        <td>Служба доставки</td>
        <td> <?= $arResult["DELIVERY"] ?> </td>
    </tr>
    <tr>
        <td>Платежная система</td>
        <td> <?= $arResult["PAYMENT"] ?></td>
    </tr>
    <tr>
        <td>Сумма заказа</td>
        <td> <?= \CCurrencyLang::CurrencyFormat($arResult["BASKET"]["SUM"], "RUB") ?> руб</td>
    </tr>
</table>
<br>
<br>

<b>Товары в заказе:</b>
<table border="1">
    <tr>
        <td>Наименование</td>
        <td>Размер</td>
        <td>Кол-во</td>
        <td>Цена</td>
        <td>Стоимость</td>
    </tr>
	<? foreach ($arResult["BASKET"]["ITEMS"] as $item): ?>
        <tr>
            <td><?= $item["NAME"] ?></td>
            <td><?= $item["PROPS"]["SIZE"] ?></td>
            <td><?= $item["QTY"] ?></td>
            <td><?= \CCurrencyLang::CurrencyFormat($item["PRICE"], "RUB") ?> руб</td>
            <td><?= \CCurrencyLang::CurrencyFormat($item["SUM"], "RUB") ?> руб</td>
        </tr>
	<? endforeach; ?>
</table>