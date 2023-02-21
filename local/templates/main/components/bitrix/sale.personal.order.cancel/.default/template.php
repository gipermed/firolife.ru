<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="cabinet cabinet-orders">
    <div class="cabinet-section-title">Отменить заказ</div>
    <div class="order-cancel">
        <div class="order-cancel__return">Вернуться в <a href="<?=$arResult["URL_TO_LIST"]?>">Мои заказы</a></div>
        <?if($arResult["ERROR_MESSAGE"] == ''):?>
            <div class="order-cancel__description">
                <span>Вы уверены, что хотите отменить заказ <a href="<?=$arResult["URL_TO_LIST"]?>">№<?=$arResult["ID"]?></a>?</span>
                <strong>Отмена заказа необратима.</strong>
            </div>
            <div class="order-cancel__reason">Укажите причину отмены заказа:</div>
            <form method="post" class="form-order-cancel" action="<?=POST_FORM_ACTION_URI?>">
                <input type="hidden" name="CANCEL" value="Y">
                <?=bitrix_sessid_post()?>
                <input type="hidden" name="ID" value="<?=$arResult["ID"]?>">
                <textarea class="form-control" rows="10" name="REASON_CANCELED"></textarea><br /><br />
                <div class="order-cancel__explain">Если у вас осталиь вопросы - напишите в службу поддержки на электронную почту: <a href="mailto:no-reply@firolife.ru">no-reply@firolife.ru</a> или&nbsp;свяжитесь с оператором интернет-магазина по телефону: <a href="tel:8 8003014406">8 800 301-44-06</a></div>
                <input type="submit" name="action" class="btn btn-submit" value="<?=GetMessage("SALE_CANCEL_ORDER_BTN") ?>">
            </form>
            <div class="order-cancel__success">
                <div class="close">
                    <svg class="icon"><use xlink:href="#icon-close"></use></svg>
                </div>
                <div class="title">Ваш заказ</div>
                <div class="nubmer">№<?=$arResult["ID"]?></div>
                <div class="subtitle">отменён</div>
            </div>
        <?else:?>
            <?=ShowError($arResult["ERROR_MESSAGE"]);?>
        <?endif;?>
    </div>
</div>