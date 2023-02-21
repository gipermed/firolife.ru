<?php check_prolog();

?>

<div id="modal-forgot" class="modal modal-forgot">
    <div class="modal-body">
        <a href="#" class="modal-close-btn" aria-label="Закрыть">
            <svg width="24" height="24"><use xlink:href="#icon-close"/></svg>
        </a>
        <div class="modal-head">
            <div class="modal-title">Забыли пароль?</div>
        </div>
        <div class="modal-content">
            <div class="modal-desc">Введите адрес электронной почты, мы отправим вам сообщение со ссылкой для сброса пароля.</div>
            <form action="?" class="forgot-form form">
                <label class="form-block" aria-label="E-mail">
                    <input type="email" class="input" placeholder="example@example.ru" required>
                </label>
                <div class="submit-wrapp">
                    <button type="submit" class="btn submit btn-full">Отправить</button>
                </div>
            </form>
        </div>
    </div>
</div>
