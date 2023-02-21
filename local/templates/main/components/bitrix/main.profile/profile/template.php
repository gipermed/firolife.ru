<?
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

if ($request->isAjaxRequest())
{
	$APPLICATION->RestartBuffer();

	$res = [];

	if ($arResult['DATA_SAVED'] == 'Y') $res["success"] = "y";

	if ($arResult["strProfileError"]) $res["error"] = $arResult["strProfileError"];


	echo json_encode($res);
	die();
}
?>


<? if (0): ?>

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


		<? // ********************* User properties ***************************************************?>
		<? if ($arResult["USER_PROPERTIES"]["SHOW"] == "Y"): ?>
            <div class="profile-link profile-user-div-link"><a title="<?= GetMessage("USER_SHOW_HIDE") ?>"
                                                               href="javascript:void(0)"
                                                               onclick="SectionClick('user_properties')"><?= strlen(trim($arParams["USER_PROPERTY_NAME"])) > 0 ? $arParams["USER_PROPERTY_NAME"] : GetMessage("USER_TYPE_EDIT_TAB") ?></a>
            </div>
            <div id="user_div_user_properties"
                 class="profile-block-<?= strpos($arResult["opened"], "user_properties") === false ? "hidden" : "shown" ?>">
                <table class="data-table profile-table">
                    <thead>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    </thead>
                    <tbody>
					<? $first = true; ?>
					<? foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField): ?>
                        <tr>
                            <td class="field-name">
								<? if ($arUserField["MANDATORY"] == "Y"): ?>
                                    <span class="starrequired">*</span>
								<? endif; ?>
								<?= $arUserField["EDIT_FORM_LABEL"] ?>:
                            </td>
                            <td class="field-value">
								<? $APPLICATION->IncludeComponent("bitrix:system.field.edit", $arUserField["USER_TYPE"]["USER_TYPE_ID"], array(
										"bVarsFromForm" => $arResult["bVarsFromForm"],
										"arUserField"   => $arUserField
									), null, array("HIDE_ICONS" => "Y")); ?></td>
                        </tr>
					<? endforeach; ?>
                    </tbody>
                </table>
            </div>
		<? endif; ?>
		<? // ******************** /User properties ***************************************************?>
    </form>
	<?
	if ($arResult["SOCSERV_ENABLED"])
	{
		$APPLICATION->IncludeComponent("bitrix:socserv.auth.split", ".default", array(
			"SHOW_PROFILES" => "Y",
			"ALLOW_DELETE"  => "Y"
		), false);
	}
	?>


<? endif ?>


<div class="personal-forms">
    <div class="personal-forms__errors"></div>
    <div class="personal-form">
        <div class="personal-form__placeholder">
            <div class="personal-form__placeholder-label">ФИО</div>
            <div class="personal-form__placeholder-value">
				<?= $arResult["arUser"]["LAST_NAME"] ?>
				<?= $arResult["arUser"]["NAME"] ?>
				<?= $arResult["arUser"]["SECOND_NAME"] ?>
            </div>
        </div>
        <form class="personal-form__form b-form" method="post" action="<?= $arResult["FORM_TARGET"] ?>"
              enctype="multipart/form-data">
			<?= $arResult["BX_SESSION_CHECK"] ?>
            <input type="hidden" name="lang" value="<?= LANG ?>"/>
            <input type="hidden" name="ID" value=<?= $arResult["ID"] ?>/>
            <input type="hidden" name="save" value="someval"/>

            <div class="b-form__group">
                <label class="b-form__group-label" for="profile-f">
                    Фамилия:
                </label>
                <div class="b-form__group-wrap">
                    <input class="b-form__group-input" type="text" id="profile-f" name="LAST_NAME" maxlength="50"
                           value="<?= $arResult["arUser"]["LAST_NAME"] ?>">
                </div>
            </div>
            <div class="b-form__group">
                <label class="b-form__group-label" for="profile-i">
                    Имя:
                </label>
                <div class="b-form__group-wrap">
                    <input class="b-form__group-input" type="text" id="profile-i" name="NAME" maxlength="50"
                           value="<?= $arResult["arUser"]["NAME"] ?>">
                </div>
            </div>
            <div class="b-form__group">
                <label class="b-form__group-label" for="profile-o">
                    Отчество:
                </label>
                <div class="b-form__group-wrap">
                    <input class="b-form__group-input" type="text" id="profile-o" name="SECOND_NAME" maxlength="50"
                           value="<?= $arResult["arUser"]["SECOND_NAME"] ?>">
                </div>
            </div>
        </form>
        <div class="personal-form__actions">
            <a href="#" style="display:block"
               class="personal-form__action-change c-gray6 linkRedHover linkDotted keepDotted">
                <span class="linkDotted">Изменить</span>
            </a>
            <a href="#" style="display:none"
               class="personal-form__action-send c-gray6 linkRedHover linkDotted keepDotted">
                <span class="linkDotted">Сохранить</span>
            </a>
        </div>
    </div>
    <div class="personal-form">
        <div class="personal-form__placeholder">
            <div class="personal-form__placeholder-label">Email</div>
            <div class="personal-form__placeholder-value">
				<?= $arResult["arUser"]["EMAIL"] ?>
            </div>
        </div>
        <form class="personal-form__form b-form" method="post" action="<?= $arResult["FORM_TARGET"] ?>"
              enctype="multipart/form-data">
			<?= $arResult["BX_SESSION_CHECK"] ?>
            <input type="hidden" name="lang" value="<?= LANG ?>"/>
            <input type="hidden" name="ID" value=<?= $arResult["ID"] ?>/>
            <input type="hidden" name="save" value="someval"/>
            <div class="b-form__group">
                <label class="b-form__group-label" for="profile-login-mail">
                    Email:
                </label>
                <div class="b-form__group-wrap">
                    <input class="b-form__group-input" type="text" id="profile-login-mail" name="EMAIL" maxlength="50"
                           value="<?= $arResult["arUser"]["EMAIL"] ?>"
                           onchange="$(this).siblings('[name=LOGIN]').val($(this).val())">
                    <input type="hidden" name="LOGIN" maxlength="50" value="<?= $arResult["arUser"]["LOGIN"] ?>">
                </div>
            </div>
        </form>
        <div class="personal-form__actions">
            <a href="#" style="display:block"
               class="personal-form__action-change c-gray6 linkRedHover linkDotted keepDotted">
                <span class="linkDotted">Изменить</span>
            </a>
            <a href="#" style="display:none"
               class="personal-form__action-send c-gray6 linkRedHover linkDotted keepDotted">
                <span class="linkDotted">Сохранить</span>
            </a>
        </div>
    </div>
    <div class="personal-form">
        <div class="personal-form__placeholder">
            <div class="personal-form__placeholder-label">Телефон</div>
            <div class="personal-form__placeholder-value">
				<?= $arResult["arUser"]["PERSONAL_PHONE"] ?>
            </div>
        </div>
        <form class="personal-form__form b-form" method="post" action="<?= $arResult["FORM_TARGET"] ?>"
              enctype="multipart/form-data">
			<?= $arResult["BX_SESSION_CHECK"] ?>
            <input type="hidden" name="lang" value="<?= LANG ?>"/>
            <input type="hidden" name="ID" value=<?= $arResult["ID"] ?>/>
            <input type="hidden" name="save" value="someval"/>
            <div class="b-form__group">
                <label class="b-form__group-label" for="profile-phone">
                    Телефон:
                </label>
                <div class="b-form__group-wrap">
                    <input class="b-form__group-input" type="text" id="profile-phone" name="PERSONAL_PHONE"
                           maxlength="255" value="<?= $arResult["arUser"]["PERSONAL_PHONE"] ?>">
                </div>
            </div>
        </form>
        <div class="personal-form__actions">
            <a href="#" style="display:block"
               class="personal-form__action-change c-gray6 linkRedHover linkDotted keepDotted">
                <span class="linkDotted">Изменить</span>
            </a>
            <a href="#" style="display:none"
               class="personal-form__action-send c-gray6 linkRedHover linkDotted keepDotted">
                <span class="linkDotted">Сохранить</span>
            </a>
        </div>
    </div>
    <div class="personal-form">
        <div class="personal-form__placeholder">
            <div class="personal-form__placeholder-label">Доп. телефон</div>
            <div class="personal-form__placeholder-value">
				<?= $arResult["arUser"]["PERSONAL_MOBILE"] ?>
            </div>
        </div>
        <form class="personal-form__form b-form" method="post" action="<?= $arResult["FORM_TARGET"] ?>"
              enctype="multipart/form-data">
			<?= $arResult["BX_SESSION_CHECK"] ?>
            <input type="hidden" name="lang" value="<?= LANG ?>"/>
            <input type="hidden" name="ID" value=<?= $arResult["ID"] ?>/>
            <input type="hidden" name="save" value="someval"/>
            <div class="b-form__group">
                <label class="b-form__group-label" for="profile-phone2">
                    Доп. телефон:
                </label>
                <div class="b-form__group-wrap">
                    <input class="b-form__group-input" type="text" id="profile-phone2" name="PERSONAL_MOBILE"
                           maxlength="255" value="<?= $arResult["arUser"]["PERSONAL_MOBILE"] ?>">
                </div>
            </div>
        </form>
        <div class="personal-form__actions">
            <a href="#" style="display:block"
               class="personal-form__action-change c-gray6 linkRedHover linkDotted keepDotted">
                <span class="linkDotted">Изменить</span>
            </a>
            <a href="#" style="display:none"
               class="personal-form__action-send c-gray6 linkRedHover linkDotted keepDotted">
                <span class="linkDotted">Сохранить</span>
            </a>
        </div>
    </div>
    <div class="personal-form">
        <div class="personal-form__placeholder">
            <div class="personal-form__placeholder-label">Дата рождения</div>
            <div class="personal-form__placeholder-value">
				<?= $arResult["arUser"]["PERSONAL_BIRTHDAY"] ?>
            </div>
        </div>
        <form class="personal-form__form b-form" method="post" action="<?= $arResult["FORM_TARGET"] ?>"
              enctype="multipart/form-data">
			<?= $arResult["BX_SESSION_CHECK"] ?>
            <input type="hidden" name="lang" value="<?= LANG ?>"/>
            <input type="hidden" name="ID" value=<?= $arResult["ID"] ?>/>
            <input type="hidden" name="save" value="someval"/>
            <div class="b-form__group">
                <label class="b-form__group-label" for="profile-birthday">
                    Дата рождения:
                </label>
                <div class="b-form__group-wrap">
                    <input class="b-form__group-input datepicker-here" type="text" id="profile-birthday"
                           name="PERSONAL_BIRTHDAY" maxlength="255"
                           value="<?= $arResult["arUser"]["PERSONAL_BIRTHDAY"] ?>">
                </div>
            </div>
        </form>
        <div class="personal-form__actions">
            <a href="#" style="display:block"
               class="personal-form__action-change c-gray6 linkRedHover linkDotted keepDotted">
                <span class="linkDotted">Изменить</span>
            </a>
            <a href="#" style="display:none"
               class="personal-form__action-send c-gray6 linkRedHover linkDotted keepDotted">
                <span class="linkDotted">Сохранить</span>
            </a>
        </div>
    </div>
</div>

<div class="mt-3">
    <span class="v-icon v-icon--exchange valign-t" style="margin-right: 2px;"></span>
    <a href="/personal/changepass/" class="c-gray6 linkRedHover keepUnderline" title="Изменить пароль">
        Изменить пароль
    </a>
</div>


<script>
    $(function () {
        $(".personal-form__action-change").click(function () {
            var $this = $(this).hide();
            var $container = $this.closest(".personal-form");

            $container.find(".personal-form__placeholder").hide();
            $container.find(".personal-form__form").show();
            $container.find(".personal-form__action-send").show();
        });

        $(".personal-form__action-send").click(function () {
            var $this = $(this);
            var $container = $this.closest(".personal-form");

            $(".personal-forms__errors").hide().html("");

            $container.find(".personal-form__form").ajaxSubmit({
                dataType: 'json',
                success: function (response, statusText, xhr, $form) {
                    if (response && response.error) {
                        $(".personal-forms__errors").show().html(response.error);
                    } else {
                        var values = [];
                        $container.find("input[type=text]").each(function () {
                            values.push($(this).val());
                        });

                        $this.hide();
                        $container.find(".personal-form__placeholder-value").html(values.join(" "));
                        $container.find(".personal-form__placeholder").show();
                        $container.find(".personal-form__form").hide();
                        $container.find(".personal-form__action-change").show();
                    }
                }
            });
        });
    })

</script>
