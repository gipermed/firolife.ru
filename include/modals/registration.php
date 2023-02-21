<?php check_prolog();

global $APPLICATION;

?>

<div id="modal-registration" class="modal modal-registration">
    <div class="modal-body">
        <a href="#" class="modal-close-btn" aria-label="Закрыть">
            <svg width="24" height="24">
                <use xlink:href="#icon-close"/>
            </svg>
        </a>
        <div class="modal-head">
            <div class="modal-title">Регистрация</div>
        </div>
        <div class="modal-content">
            <div class="modal-desc">Зарегистрируйтесь и начните совершать покупки на Гипермед.</div>
            <?php $APPLICATION->IncludeComponent('palladiumlab:user.register', 'main') ?>
        </div>
        <div class="modal-foot">
            <div class="modal-login-nav">
                <div class="modal-login-nav-title">Есть аккаунт?</div>
                <a href="#modal-enter" class="modal-login-nav-link modal-open-btn">Войти</a>
            </div>
        </div>
    </div>
</div>
