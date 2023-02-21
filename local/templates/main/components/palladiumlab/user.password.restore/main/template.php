<?php check_prolog();

use Bitrix\Main\Context;

/**
 * @var CMain $APPLICATION
 * @var array $arResult
 */

$r = Context::getCurrent()->getRequest();

?>
<form action="?" class="restore-password-form login-form form">

    <?= bitrix_sessid_post() ?>
    <input type="hidden" name="action" value="password_restore">

    <div class="form-title h3">Восстановление пароля</div>

    <label class="form-block">
        <span class="form-block-title">Электронная почта <span>*</span></span>
        <span class="form-block-input">
            <input type="email" class="input" required name="email" value="<?= $r['email'] ?>">
            <i class="form-block-icon form-block-icon-valid">
                <svg width="16" height="16"><use xlink:href="#icon-check"/></svg>
            </i>
            <a href="#" class="form-block-icon form-block-icon-clear">
                <svg width="16" height="16"><use xlink:href="#icon-close"/></svg>
            </a>
        </span>
    </label>

    <div class="login-form-info">
        На указанный адрес электронной почты будет отправлена ссылка для генерации нового пароля
    </div>

    <div class="form-submit">
        <button type="submit" class="submit btn" formnovalidate>Отправить</button>
    </div>

</form>
