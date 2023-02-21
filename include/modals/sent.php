<?php check_prolog();

?>

<div id="modal-sent" class="modal modal-sent">
    <div class="modal-body">
        <a href="#" class="modal-close-btn" aria-label="Закрыть">
            <svg width="24" height="24"><use xlink:href="#icon-close"/></svg>
        </a>
        <div class="modal-head">
            <div class="modal-title">Спасибо за ваш запрос!</div>
        </div>
        <div class="modal-content">
            <div class="modal-sent-icon">
                <img src="<?= SITE_TEMPLATE_PATH ?>/assets/img/sent-icon.svg" alt="">
            </div>
            <div class="modal-sent-desc modal-desc">В ближайшее время с вами свяжется менеджер и ответит на все интересующие вопросы по указанному номеру телефона.</div>
            <a href="#" class="btn btn-full submit modal-close-link">Закрыть</a>
        </div>
    </div>
</div>
