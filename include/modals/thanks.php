<?php check_prolog();

?>

<div id="modal-thanks" class="modal modal-thanks">
    <div class="modal-body">
        <a href="#" class="modal-close-btn" aria-label="Закрыть">
            <svg width="24" height="24"><use xlink:href="#icon-close"/></svg>
        </a>
        <div class="modal-head">
            <div class="modal-thanks-head">
                <div class="logo">
                    <img src="img/logo.svg" alt="" width="63">
                </div>
                <div class="modal-title">Спасибо за заказ</div>
            </div>
            <div class="modal-thanks-head-desc">Ваш заказ оформлен. Пожалуйста, дождитесь подтверждения вашего заказа.</div>
            <div class="modal-thanks-head-order">
                <table class="modal-thanks-head-order-table">
                    <tr>
                        <td>Номер заказа</td>
                        <td>4356</td>
                    </tr>
                    <tr>
                        <td>Дата</td>
                        <td>13.04.2021 г.</td>
                    </tr>
                    <tr>
                        <td>Сумма</td>
                        <td>45 032 ₽.</td>
                    </tr>
                    <tr>
                        <td>Статус оплаты</td>
                        <td>Оплачен</td>
                    </tr>
                    <tr>
                        <td>Адрес доставки</td>
                        <td>Пункт выдачи заказа СДЕК<br> г. Москва, ул. Летная, д. 7, стр. 4</td>
                    </tr>
                    <tr>
                        <td>Дата получения</td>
                        <td>23-25.04.2021 г.</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="modal-thanks-order">
            @@include('ordering-confirm-items.html')
        </div>
        <div class="modal-content">
            <div class="content-text">
                <p>Вы можете следить за выполнением своего заказа (на какой стадии выполнения он находится), войдя личный кабинет интернет-магазина www.gipermed.com.
                <p>Для того, чтобы аннулировать заказ, воспользуйтесь функцией отмены заказа, которая доступна личном кабинете интернет-магазина  www.gipermed.com.
                <p>Пожалуйста, при обращении к администрации сайта www.gipermed.com указывайте номер вашего заказа.
            </div>
            <div class="modal-thanks-foot">
                <div class="modal-thanks-foot-desc">
                    С уважением,<br> администрация Интернет-магазина!
                </div>
                <a href="" class="btn btn-green modal-thanks-btn">Вернуться на главную</a>
            </div>
        </div>
    </div>
</div>
