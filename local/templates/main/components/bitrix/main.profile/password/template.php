<?
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>



<? ShowError($arResult["strProfileError"]); ?>
<?
if ($arResult['DATA_SAVED'] == 'Y') ShowNote(GetMessage('PROFILE_DATA_SAVED'));
?>

<form class="b-form" method="post" action="<?= $arResult["FORM_TARGET"] ?>" enctype="multipart/form-data">
	<?= $arResult["BX_SESSION_CHECK"] ?>
    <input type="hidden" name="lang" value="<?= LANG ?>"/>
    <input type="hidden" name="ID" value=<?= $arResult["ID"] ?>/>

    <div class="b-form__group">
        <label class="b-form__group-label" for="change-pass">
            Новый пароль
        </label>
        <div class="b-form__group-wrap">
            <input id="change-pass" class="b-form__group-input" type="password" name="NEW_PASSWORD" maxlength="50"
                   value="" autocomplete="off"/>
        </div>
    </div>

    <div class="b-form__group">
        <label class="b-form__group-label" for="restore-pass-confirm">
            Повторите пароль
        </label>
        <div class="b-form__group-wrap">
            <input id="restore-pass-confirm" class="b-form__group-input" type="password" name="NEW_PASSWORD_CONFIRM"
                   maxlength="50" value="" autocomplete="off"/>
        </div>
    </div>

    <div class="b-form__group">
        <div class="b-form__group-label"></div>
        <div class="b-form__group-wrap">
            <input type="submit" class="v-btn v-btn--sm v-btn--red" name="save" value="Изменить пароль">
        </div>
    </div>
</form>
