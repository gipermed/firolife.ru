<?php check_prolog();

?>

<div id="modal-recall" class="modal modal-recall">
    <div class="modal-body">
        <a href="#" class="modal-close-btn" aria-label="Закрыть">
            <svg width="24" height="24"><use xlink:href="#icon-close"/></svg>
        </a>
        <div class="modal-head">
            <div class="modal-title">Заказать звонок</div>
        </div>
        <div class="modal-content">
            <form action="?" class="recall-form form form-ajax" data-modal-sent="#modal-sent">
                <label class="form-block" aria-label="Имя">
                    <input type="text" class="input" placeholder="Имя*" required>
                </label>
                <label class="form-block" aria-label="Телефон">
                    <input type="tel" class="input" placeholder="+7 (777) 777-77-77" required>
                </label>
                <div class="submit-wrapp">
                    <button type="submit" class="btn submit btn-full">Отправить</button>
                </div>
                <div class="form-agreement">
                    Нажимая кнопку «Отправить», Вы соглашаетесь на обработку <a href="#">персональных данных</a>.
                </div>
                <div class="form-required-info">* Поля обязательные для заполнения</div>
            </form>
        </div>
    </div>
</div>
