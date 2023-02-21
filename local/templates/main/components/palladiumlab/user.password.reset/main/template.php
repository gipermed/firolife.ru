<?php check_prolog();

use Bitrix\Main\Context;

/**
 * @var CMain $APPLICATION
 * @var array $arResult
 */

$r = Context::getCurrent()->getRequest();

?>
<form action="?" class="reset-password-form login-form form" method="post">

    <?= bitrix_sessid_post() ?>
    <input type="hidden" name="action" value="password_reset">

    <div class="form-title h3">Восстановление пароля</div>

    <label class="form-block">
        <span class="form-block-title">Пароль <span>*</span></span>
        <span class="form-block-input">
            <input type="password" class="input" name="password" required>
            <i class="form-block-icon form-block-icon-valid">
                <svg width="16" height="16"><use xlink:href="#icon-check"/></svg>
            </i>
            <a href="#" class="form-block-icon form-block-icon-clear">
                <svg width="16" height="16"><use xlink:href="#icon-close"/></svg>
            </a>
        </span>
    </label>

    <label class="form-block">
        <span class="form-block-title">Подтверждение пароля <span>*</span></span>
        <span class="form-block-input">
            <input type="password" class="input" name="password_confirm" required>
            <i class="form-block-icon form-block-icon-valid">
                <svg width="16" height="16"><use xlink:href="#icon-check"/></svg>
            </i>
            <a href="#" class="form-block-icon form-block-icon-clear">
                <svg width="16" height="16"><use xlink:href="#icon-close"/></svg>
            </a>
        </span>
    </label>

    <div class="form-submit">
        <button type="submit" class="submit btn" formnovalidate>Восстановить</button>
    </div>

</form>
