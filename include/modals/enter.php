<?php check_prolog();

global $APPLICATION;

?>

<div id="modal-enter" class="modal modal-enter">
    <div class="modal-body">
        <?/*a href="#" class="modal-close-btn" aria-label="Закрыть">
            <svg width="24" height="24">
                <use xlink:href="#icon-close"/>
            </svg>
        </a>
        <div class="modal-head">
            <div class="modal-title">Вход</div>
        </div>
        <div class="modal-content">
			<?php $APPLICATION->IncludeComponent('palladiumlab:user.auth', 'main') ?>
        </div>
        <div class="modal-foot">
            <div class="modal-login-nav">
                <div class="modal-login-nav-title">Нет аккаунта?</div>
                <a href="#modal-registration" class="modal-login-nav-link modal-open-btn">Зарегистрироваться</a>
            </div>
        </div*/?>

        <div class="authFlex">
            <? $APPLICATION->IncludeComponent('bxmaker:authuserphone.login', '.default', array('SET_TITLE'=>'N'), false); ?>
        </div>
    </div>
</div>

