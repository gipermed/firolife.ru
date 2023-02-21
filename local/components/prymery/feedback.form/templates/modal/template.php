<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>
<!--noindex-->
<div id="<?=$arParams['CUSTOM_CLASS']?>" class="modal<?if($arParams['CUSTOM_CLASS']):?> <?=$arParams['CUSTOM_CLASS']?><?endif;?>">
    <div class="modal-body">
        <a href="#" class="modal-close-btn" aria-label="Закрыть" data-fancybox-close>
            <svg width="24" height="24"><use xlink:href="#icon-close"/></svg>
        </a>
        <?if($arParams['~TITLE']):?>
            <div class="modal-head">
                <div class="modal-title"><?=$arParams['~TITLE']?></div>
            </div>
        <?endif;?>
        <div class="modal-content">
            <?if($arResult['ERROR_COUNTERS_ID']):?>
                <div class="prForm__error"><?=$arResult['ERROR_COUNTERS_ID']?></div>
            <?endif;?>
            <form enctype="multipart/form-data" class="prForm<?if($arParams['CUSTOM_CLASS_FORM']):?> <?=$arParams['CUSTOM_CLASS_FORM']?><?endif;?>" autocomplete="off" method="post" action="<?= $arResult['JS_OBJECT']['AJAX_PATH'] ?>">
                <?if($arResult['JS_OBJECT']['FIELDS']['ELEMENT_NAME']):?>
                    <input value="<?=$arResult['JS_OBJECT']['FIELDS']['ELEMENT_NAME']?>" name="ELEMENT_NAME" type="hidden">
                    <input value="<?=$arParams['ELEMENT_ID']?>" name="ELEMENT_ID" type="hidden">
                <?endif;?>
                <?if(!empty($arResult['FIELDS'])){?>
                    <?foreach ($arResult['FIELDS'] as $field) {
                        if ($field['CODE'] == 'MESSAGE'):?>
                            <label class="form-block">
                                <textarea rows="5" name="<?= $field['CODE'] ?>" placeholder="<?=GetMessage('PRYMERY_FF_FIELD_'.$field['CODE'])?><?= ($field['REQUIRED'] == 'Y') ? ' *' : '' ?>" class="form-control <?=($field['REQUIRED'] == 'Y') ? ' required' : '' ?>"></textarea>
                            </label>
                        <?elseif($field['CODE'] != 'ELEMENT_ID'):?>
                            <label class="form-block" aria-label="<?=GetMessage('PRYMERY_FF_FIELD_'.$field['CODE'])?><?= ($field['REQUIRED'] == 'Y') ? ' *' : '' ?>">
                                <input type="text" name="<?= $field['CODE'] ?>" class="input<?= ($field['CODE'] == 'PHONE') ? ' js-phone-masked' : '' ?><?= ($field['REQUIRED'] == 'Y') ? ' required' : '' ?>" placeholder="<?=GetMessage('PRYMERY_FF_FIELD_'.$field['CODE'])?><?= ($field['REQUIRED'] == 'Y') ? ' *' : '' ?>"<?if($field['REQUIRED'] == 'Y'):?> required<?endif;?>>
                            </label>
                        <?endif;
                    }?>
                <?}?>
                <div class="submit-wrapp"><button type="submit" class="btn submit btn-full"><?=$arParams['~BUTTON']?></button></div>
                <div class="form-agreement">
                    Нажимая кнопку «Отправить», Вы соглашаетесь<br> на обработку <a href="/privacy-policy/">персональных данных</a>.
                </div>
                <div class="form-required-info">* Поля обязательные для заполнения</div>
            </form>
            <div class="true-message" style="display: none;">
                <?=$arParams['TRUE_MESSAGE']?>
            </div>
            <style>.modal {display: block;}</style>
            <script>$(document).ready(function(){initprForm(<?= CUtil::PhpToJSObject($arResult['JS_OBJECT']) ?>);});$('input[name=PHONE]').inputmask('(9)|(+7) (999)999-99-99');</script>
        </div>
    </div>
</div>
<!--/noindex-->