<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
?>
        <h1 class="section-title">Корзина</h1>
        <div class="empty-info">
            <div class="empty-info-icon">
                <img src="<?=SITE_TEMPLATE_PATH?>assets/img/empty-icon.svg" alt="">
            </div>
            <div class="empty-info-title">Здесь пусто</div>
            <div class="cart-empty-info">
                <div class="empty-info-desc">В корзину ничего не добавлено.</div>
                <div class="cart-empty-desc">Воспользуйтесь поиском, чтобы найти необходимые товары.</div>
                <a href="/" class="btn btn-full btn-green cart-empty-btn">Начать покупки</a>
            </div>
        </div>
