<?php check_prolog();

?>

<div id="modal-fast-buy" class="modal modal-fast-buy">
    <div class="modal-body">
        <a href="#" class="modal-close-btn" aria-label="Закрыть">
            <svg width="24" height="24"><use xlink:href="#icon-close"/></svg>
        </a>
        <div class="modal-head">
            <div class="modal-title">Заявка на покупку товара</div>
        </div>
        <div class="modal-content">
            <div class="modal-desc">Заполните форму быстрого заказа, наши менеджеры скоро свяжутся с вами.</div>
            <form action="?" class="fast-buy-form form">
                <label class="form-block" aria-label="Имя">
                    <input type="text" class="input" placeholder="Имя" required>
                </label>
                <label class="form-block" aria-label="Телефон">
                    <input type="tel" class="input" placeholder="+7 (777) 777-77-77" required>
                </label>
                <label class="form-block" aria-label="Email">
                    <input type="email" class="input" placeholder="example@example.ru" required>
                </label>
                <div class="submit-wrapp">
                    <button type="submit" class="btn submit btn-full">Оформить заказ</button>
                </div>
                <div class="form-agreement">Нажимая кнопку «Оформить заказ», я соглашаюсь на получение информации от интернет-магазина и уведомлений о состоянии моих заказов, а также принимаю условия <a href="#">политики конфиденциальности</a>.</div>
            </form>
        </div>
    </div>
</div>
