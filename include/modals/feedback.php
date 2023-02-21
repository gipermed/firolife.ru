<?php check_prolog();

?>

<div id="modal-feedback" class="modal modal-feedback">
    <div class="modal-body">
        <a href="#" class="modal-close-btn" aria-label="Закрыть">
            <svg width="24" height="24"><use xlink:href="#icon-close"/></svg>
        </a>
        <div class="modal-head">
            <div class="modal-title">Связаться с нами</div>
        </div>
        <div class="modal-content">
            <div class="modal-desc">Мы постоянно работаем над тем, чтобы улучшить наш сервис. В этом очень помогают пожелания наших покупателей.</div>
            <div class="modal-desc modal-feedback-desc">Если у Вас есть вопросы и пожелания по работе сайта, колл-центра, службы доставки или качеству продукции воспользуйтесь формой обратной связи.</div>
            <form action="?" class="feedback-form form">
                <label class="form-block form-block-select">
                    <i class="select-icon"><svg width="24" height="24"><use xlink:href="#icon-chevron-down"/></svg></i>
                    <select class="select input">
                        <option selected>Качество продукции</option>
                        <option>2</option>
                        <option>3</option>
                    </select>
                </label>
                <div class="form-row flex-row">
                    <div class="form-col flex-row-item">
                        <label class="form-block" aria-label="Телефон">
                            <input type="tel" class="input" placeholder="Телефон" required>
                        </label>
                    </div>
                    <div class="form-col flex-row-item">
                        <label class="form-block" aria-label="Email">
                            <input type="email" class="input" placeholder="Электронная почта*" required>
                        </label>
                    </div>
                </div>
                <label class="form-block" aria-label="Имя">
                    <input type="text" class="input" placeholder="Имя" required>
                </label>
                <label class="form-block" aria-label="Текст сообщения">
                    <textarea class="input textarea" placeholder="Текст сообщения" required></textarea>
                </label>
                <div class="submit-wrapp">
                    <button type="submit" class="btn submit btn-full">Отправить</button>
                </div>
                <div class="form-agreement">Нажимая кнопку «Отправить», Вы соглашаетесь на обработку <a href="#">персональных данных</a>.</div>
                <div class="form-required-info">* Поля обязательные для заполнения</div>
            </form>
        </div>
    </div>
</div>
