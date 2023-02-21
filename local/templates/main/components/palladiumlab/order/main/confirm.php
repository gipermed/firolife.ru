<?php check_prolog();

use Palladiumlab\Management\User;

/**
 * @var array $arResult
 * @var array $arParams
 *
 * @var CMain $APPLICATION
 */

$accountNumber = $arResult['ORDER']['ACCOUNT_NUMBER'];

$APPLICATION->SetTitle("Заказ №{$accountNumber} успешно оформлен!");
$APPLICATION->SetPageProperty('title', "Заказ №{$accountNumber} успешно оформлен!");

$APPLICATION->SetPageProperty('body-class', 'order-is-processed');

$APPLICATION->AddChainItem('Оформление заказа');

$user = User::current();

?>
<a href="/" class="breadcrumbs-back-link">Главная</a>
<h1 class="page-title h2">Заказ <span>№ <?= $accountNumber ?></span> оформлен!</h1>
<div class="order-is-processed-content">
    <p>На вашу почту <span><?= $user->email ?></span> отправлено письмо с информацией по заказу.</p>
    <p>В ближайшее время с Вами свяжется менеджер для подтверждения.</p>
    <p>Заказу присвоен статус «В обработке».</p>
</div>
<ul class="order-is-processed-links">
    <li><a href="/catalog/" class="btn">Каталог</a></li>
    <li><a href="/profile/orders/" class="btn btn-border">История заказов</a></li>
</ul>
