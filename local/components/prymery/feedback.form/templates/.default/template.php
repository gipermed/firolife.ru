<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->setFrameMode(true);
?>
<!--noindex-->
<?if($arResult['ERROR_COUNTERS_ID']):?>
    <div class="prForm__error"><?=$arResult['ERROR_COUNTERS_ID']?></div>
<?endif;?>
<form enctype="multipart/form-data" class="form prForm" autocomplete="off" method="post" action="<?= $arResult['JS_OBJECT']['AJAX_PATH'] ?>">
    <div class="form-row">
        <?if($arParams['~TITLE']):?>
            <h3 class="form__title letter-spacing-md"><?=$arParams['~TITLE']?></h3>
        <?endif;?>
        <?if($arParams['~SUBTITLE']):?>
            <div class="form__description letter-spacing-md"><?=$arParams['~SUBTITLE']?></div>
        <?endif;?>
        <?if($arResult['JS_OBJECT']['FIELDS']['ELEMENT_NAME']):?>
            <input value="<?=$arResult['JS_OBJECT']['FIELDS']['ELEMENT_NAME']?>" name="ELEMENT_NAME" type="hidden">
            <input value="<?=$arParams['ELEMENT_ID']?>" name="ELEMENT_ID" type="hidden">
        <?endif;?>
        <?if(!empty($arResult['FIELDS'])){?>
            <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                <?foreach ($arResult['FIELDS'] as $field) {
                    if ($field['CODE'] != 'MESSAGE'):?>
                        <div class="form-group is-empty">
                            <input placeholder="<?=GetMessage('PRYMERY_FF_FIELD_'.$field['CODE'])?><?= ($field['REQUIRED'] == 'Y') ? ' *' : '' ?>" class="form-control<?= ($field['REQUIRED'] == 'Y') ? ' required' : '' ?>" name="<?= $field['CODE'] ?>" type="text">
                        </div>
                    <? endif;
                }?>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                <?foreach ($arResult['FIELDS'] as $field) {
                    if ($field['CODE'] == 'MESSAGE'):?>
                        <div class="form-group is-empty">
                            <textarea name="<?= $field['CODE'] ?>" placeholder="<?=GetMessage('PRYMERY_FF_FIELD_'.$field['CODE'])?><?= ($field['REQUIRED'] == 'Y') ? ' *' : '' ?>"
                                      class="form-control <?=($field['REQUIRED'] == 'Y') ? ' required' : '' ?>" rows="5"></textarea>
                        </div>
                    <? endif;
                }?>
            </div>
        <?}?>
        <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 order-4 order-lg-3">
            <div class="form-finish">
                <div class="form-group">
                    <button type="submit" class="adp-btn adp-btn--danger adp-btn-lg text-uppercase font-bold has-icon-right"><?=$arParams['~BUTTON']?> <svg class="icon icon-md"><use xlink:href="#long-arrow-right"></use></svg></button>
                </div>
                <? if($arParams['PERSONAL_DATA'] == 'Y') :?>
                    <div class="form-confirm">
                        <?=GetMessage('PRYMERY_FF_PERSONAL_DATA');?>
                        <?if($arParams['PERSONAL_DATA_PAGE']):?>
                            <a href="<?=$arParams['PERSONAL_DATA_PAGE']?>">
                        <?endif;?>
                        <?=GetMessage('PRYMERY_FF_PERSONAL_DATA_2');?>
                        <?if($arParams['PERSONAL_DATA_PAGE']):?>
                            </a>
                        <?endif;?>
                    </div>
                <?endif;?>
            </div>
        </div>
        <? if($arParams['USE_CAPTCHA'] == 'Y') :?>
            <div class="form-group is-empty row">
                <div class="col-6">
                    <img class="captcha-img" src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>"
                         width="180" height="40" alt="CAPTCHA">
                </div>
                <div class="col-6">
                    <label class="control-label captcha-label"><?= GetMessage("PRYMERY_FF_CAPTCHA_CODE")?> <span class="text-warning">*</span></label>
                    <input type="text"
                           name="captcha_word"
                           class="required form-control captcha-control">
                    <input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
                </div>
                <div class="update-captcha"></div>
            </div>
        <? endif ?>
    </div>
</form>
<div class="true-message" style="display: none;">
    <?=$arParams['TRUE_MESSAGE']?>
</div>
<script>$(document).ready(function(){initprForm(<?= CUtil::PhpToJSObject($arResult['JS_OBJECT']) ?>);});</script>
<!--/noindex-->