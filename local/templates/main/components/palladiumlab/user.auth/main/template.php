<?php check_prolog();

use Bitrix\Main\Context;

/**
 * @var CMain $APPLICATION
 * @var array $arResult
 */

$r = Context::getCurrent()->getRequest();

?>
<form action="?" class="enter-form form" method="post">

    <?= bitrix_sessid_post() ?>
    <input type="hidden" name="action" value="auth">

    <label class="form-block" aria-label="E-mail или телефон">
        <input type="text" class="input" placeholder="E-mail или телефон" required name="login"
               value="<?= $r['login'] ?>">
    </label>

    <label class="form-block form-block-password" aria-label="Пароль">
        <input type="password" class="input" placeholder="Пароль" required name="password">
        <a href="#" class="password-input-type-toggle">
            <svg width="18" height="18">
                <use xlink:href="#icon-eye-open"/>
            </svg>
            <svg width="18" height="18">
                <use xlink:href="#icon-eye-close"/>
            </svg>
        </a>
    </label>

    <div class="submit-wrapp">
        <button type="submit" class="btn submit btn-full">Войти</button>
    </div>

    <div class="enter-form-forgot-wrapp">
        <a href="#modal-forgot" class="enter-form-forgot modal-open-btn">Забыли пароль?</a>
    </div>

</form>
