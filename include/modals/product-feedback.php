<?php check_prolog();

?>

<div id="modal-product-feedback" class="modal modal-product-feedback">
    <div class="modal-body">
        <a href="#" class="modal-close-btn" aria-label="Закрыть">
            <svg width="24" height="24"><use xlink:href="#icon-close"/></svg>
        </a>
        <div class="modal-head">
            <div class="modal-title">Связаться с менеджером</div>
        </div>
        <div class="modal-content">
            <div class="modal-feedback-contacts">
                <div>Для получения информации о товаре «Под заказ» вы можете позвонить по телефонам:</div>
                @@include('contacts-tels.html')
                <div>или воспользоваться формой обратной связи, менеджер свяжется с вами в ближайшее время:</div>
            </div>
            <form action="?" class="feedback-form form">
                <label class="form-block" aria-label="Имя">
                    <input type="text" class="input" placeholder="Имя" required>
                </label>
                <label class="form-block" aria-label="Телефон">
                    <input type="tel" class="input" placeholder="+7 (777) 777-77-77" required>
                </label>
                <div class="submit-wrapp">
                    <button type="submit" class="btn submit btn-full">Отправить</button>
                </div>
                <div class="form-agreement">Нажимая кнопку «Отправить», я соглашаюсь на получение информации от интернет-магазина и уведомлений о состоянии моих заказов, а также принимаю условия <a href="#">политики конфиденциальности</a>.</div>
            </form>
        </div>
    </div>
