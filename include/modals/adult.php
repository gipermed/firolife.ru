<?php check_prolog();

?>

<div id="modal-adult" class="modal modal-adult">
    <div class="modal-body">
        <a href="#" class="modal-close-btn" aria-label="Закрыть">
            <svg width="24" height="24"><use xlink:href="#icon-close"/></svg>
        </a>
        <div class="modal-head">
            <div class="modal-title">Подтвердите возраст</div>
        </div>
        <div class="modal-content">
            <div class="modal-adult-body">
                <div class="modal-adult-icon">
                    <img src="<?= SITE_TEMPLATE_PATH ?>/assets/img/adult-icon.svg" alt="">
                </div>
                <div class="modal-adult-desc">Этот товар категории «для взрослых». Подтвердите, что вы старше 18 лет, чтобы перейти к товару</div>
            </div>
            <ul class="modal-adult-btns">
                <li>
                    <a href="#" class="btn btn-large btn-green btn-full modal-adult-ok modal-close-link">Подтвердить</a>
                </li>
                <li>
                    <a href="#" class="btn btn-large btn-border btn-border-alt btn-full modal-adult-not-ok modal-close-link">Отмена</a>
                </li>
            </ul>
        </div>
    </div>
</div>
