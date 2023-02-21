<?php
if (!\defined("B_PROLOG_INCLUDED") || \B_PROLOG_INCLUDED !== \true) { die; }
$CPN = 'bxmaker.authuserphone.login';
$oManager = \BXmaker\AuthUserPhone\Manager::getInstance();
$this->setFrameMode(\true);
$rand = $arParams['RAND_STRING'];
?>
<div class="col-12 col-lg-7 bxmaker-authuserphone-login bxmaker-authuserphone-login--auth <? echo $arParams['IS_ENABLED_REGISTER'] !== 'Y' ? 'bxmaker-authuserphone-login--noreg' : '';?>" id="bxmaker-authuserphone-login--<?echo $rand;?>" data-rand="<?echo $rand;?>" data-consent="<? echo $arParams['CONSENT_SHOW']; ?>">
    <div class="modal-close-btn ">Х</div>
    <div class="page-title">Вход или Регистрация</div>
    <?
    $frame = $this->createFrame('bxmaker-authuserphone-login--' . $rand)->begin('<div class="bxmaker-authuserphone-login-loading"></div>');
    $frame->setAnimation(\true);
    ?>
    <? if ($arResult['USER_IS_AUTHORIZED'] == 'Y') {    ?>
        <div class="bxmaker-authuserphone-login-msg bxmaker-authuserphone-login-msg--success"
             style="margin-bottom:0;">
            <? echo \GetMessage($CPN . 'USER_IS_AUTHORIZED');    ?>
        </div>
    <?} else {?>
        <div class="bxmaker-authuserphone-login-msg"></div>
        <?
        $authInputNames = [\GetMessage($CPN . 'INPUT_PHONE')];
        $bLogin = $arParams['IS_ENABLED_AUTH_BY_LOGIN'] == 'Y';
        $bEmail = $arParams['IS_ENABLED_AUTH_BY_EMAIL'] == 'Y';
        if ($bLogin) {
            $authInputNames[] = \mb_strtolower(\GetMessage($CPN . 'INPUT_LOGIN'));
        }
        if ($bEmail) {
            $authInputNames[] = \mb_strtolower(\GetMessage($CPN . 'INPUT_EMAIL'));
        }
        $name = $authInputNames[0];
        if (\count($authInputNames) > 1) {
            $name = \implode(', ', \array_slice($authInputNames, 0, -1));
            $name .= ' ' . \GetMessage($CPN . 'INPUT_OR') . ' ' . \end($authInputNames);
        }
        ?>
        <div class="cbaup_row bxmaker-authuserphone-login-row bxmaker-authuserphone-login__onlyauth ">
            <div class="bxmaker-authuserphone-login-row__flag bxmaker-authuserphone-login-row__flag--auth"></div>
            <input type="text" name="phone" class="phone js-phone-masked2" placeholder="Номер телефона"/>
            <script>
                $(".js-phone-masked2").inputmask("+7 (999) 999-99-99",{ showMaskOnHover: false });
            </script>
        </div>
        <? if ($arParams['IS_ENABLED_REGISTER_LOGIN'] == 'Y') {?>
            <div class="cbaup_row bxmaker-authuserphone-login-row bxmaker-authuserphone-login__onlyreg">
                <input type="text" name="login" class="login" placeholder="<? echo \GetMessage($CPN . 'INPUT_LOGIN'); ?>"/>
            </div>
        <? } ?>
        <? if ($arParams['IS_ENABLED_REGISTER_EMAIL'] == 'Y') {?>
            <div class="cbaup_row bxmaker-authuserphone-login-row bxmaker-authuserphone-login__onlyreg">
                <input type="text" name="email" class="email" placeholder="<? echo \GetMessage($CPN . 'INPUT_EMAIL'); ?>"/>
            </div>
        <? } ?>
        <div class="bxmaker-authuserphone-login-row cbaup_row beforeSendSms">
            <span class="bxmaker-authuserphone-login-link btn btn--primary"><? echo \GetMessage($CPN . 'BTN_SEND_CODE'); ?></span>
        </div>
        <div class="cbaup_row codeInputJs" style="display: none">
            <div class="auth-number__send">
                На номер <span></span> был отправлен код
            </div>
            <div class="auth-description">
                Этот код используется для входа или регистрации в личном кабинете.
                Введите 4-х значный числовой код в поле отображаемое ниже.
            </div>
            <? if ($arParams['IS_ENABLED_REGISTER_PASSWORD'] == 'Y') {?>
                <div class="cbaup_row bxmaker-authuserphone-login-row bxmaker-authuserphone-login__onlyreg">
                    <input type="password" name="password" class="password" placeholder="<? echo \GetMessage($CPN . 'INPUT_PASSWORD'); ?>"/>
                    <span class="bxmaker-authuserphone-login__show-password"
                          title="<? echo \GetMessage($CPN . 'BTN_SHOW_PASSWORD'); ?>"
                          data-title-show="<? echo \GetMessage($CPN . 'BTN_SHOW_PASSWORD'); ?>"
                          data-title-hide="<? echo \GetMessage($CPN . 'BTN_HIDE_PASSWORD'); ?>">
                    </span>
                </div>
            <? } ?>
            <div class="cbaup_row bxmaker-authuserphone-login-row bxmaker-authuserphone-login__onlyreg">
                <div class="auth-inputs">
                    <input type="tel" name="auth-input-1" size="1" maxlength="1" tabindex="1" class="auth-inputs__input">
                    <input type="tel" name="auth-input-2" size="1" maxlength="1" tabindex="2" class="auth-inputs__input">
                    <input type="tel" name="auth-input-3" size="1" maxlength="1" tabindex="3" class="auth-inputs__input">
                    <input type="tel" name="auth-input-4" size="1" maxlength="1" tabindex="4" class="auth-inputs__input">
                </div>

                <div class="text-center">
                    <div class="auth-time">
                        <div class="auth-time__text cbaup_btn_link timeout">
                            Отправить код ещё раз через
                        </div>
                    </div>
                    <a href="javascript:void(0)" class="auth-other__link">Ввести другой номер</a>
                </div>

                <input type="text" name="sms_code" style="display: none;" class="smscode" placeholder="<? echo \GetMessage($CPN . 'INPUT_SMS_CODE'); ?>"/>
            </div>
            <div class="bxmaker-authuserphone-login-row bxmaker-authuserphone-login__onlyauth" style="display: none;">
                <input type="password" name="password_sms_code" placeholder="<? echo \GetMessage($CPN . 'INPUT_PASSWORD_OR_SMS_CODE');?>"/>
                <span class="bxmaker-authuserphone-login__show-password"
                      title="<? echo \GetMessage($CPN . 'BTN_SHOW_PASSWORD'); ?>"
                      data-title-show="<? echo \GetMessage($CPN . 'BTN_SHOW_PASSWORD');?>"
                      data-title-hide="<? echo \GetMessage($CPN . 'BTN_HIDE_PASSWORD');?>">
                </span>
            </div>
            <div class="bxmaker-authuserphone-login-row bxmaker-authuserphone-login-captcha"></div>
            <?if ($arResult['USER_IS_AUTHORIZED'] != 'Y') {?>
                <div class="bxmaker-authuserphone-login-row btn_box">
                    <div class="bxmaker-authuserphone-login-btn btnAfterSms btn btn--primary" data-auth-title="<? echo \GetMessage($CPN . 'BTN_INTER'); ?>" data-reg-title="<? echo \GetMessage($CPN . 'BTN_REG_INTER'); ?>"><? echo \GetMessage($CPN . 'BTN_INTER'); ?></div>
                </div>
            <? } ?>
        </div>
    <? }?>
    <?if ($arParams['CONSENT_SHOW'] == 'Y') {
        $arFields = [];
        $arFields[] = \GetMessage($CPN . 'INPUT_PHONE_REG');
        if ($oManager->param()->isEnabledRegisterEmail()) {
            $arFields[] = \GetMessage($CPN . 'INPUT_EMAIL');
        }
        if ($oManager->param()->isEnabledRegisterLogin()) {
            $arFields[] = \GetMessage($CPN . 'INPUT_LOGIN');
        }
        ?>
        <div class="bxmaker-authuserphone-login-row bxmaker-authuserphone-login-row--registration ">
            <? $APPLICATION->IncludeComponent("bitrix:main.userconsent.request", "bxmaker-authuserphone", ['ID' => $arParams['CONSENT_ID'], "IS_CHECKED" => 'N', "IS_LOADED" => "Y", "AUTO_SAVE" => "N", 'SUBMIT_EVENT_NAME' => 'bxmaker-authuserphone-login__consent--' . $rand, 'REPLACE' => ['button_caption' => \GetMessage($CPN . 'BTN_REG_INTER'), 'fields' => $arFields]], $component); ?>
        </div>
    <? }?>

    <script type="text/javascript" class="bxmaker-authuserphone-jsdata">
        <?
            // component parameters
            $signer = new \Bitrix\Main\Security\Sign\Signer();
            $signedParameters = $signer->sign(\base64_encode(\serialize($arResult['_ORIGINAL_PARAMS'])));
            $signedTemplate = $signer->sign($arResult['TEMPLATE']);
            ?>
        window.BXmakerAuthUserPhoneLoginData = window.BXmakerAuthUserPhoneLoginData || {};
        window.BXmakerAuthUserPhoneLoginData["<?echo $rand;?>"] = <?echo \Bitrix\Main\Web\Json::encode(['parameters' => $signedParameters, 'template' => $signedTemplate, 'siteId' => \SITE_ID, 'ajaxUrl' => $this->getComponent()->getPath() . '/ajax.php', 'rand' => $rand, 'isEnabledRegister' => $arParams['IS_ENABLED_REGISTER'] == 'Y', 'isEnabledAuthByLogin' => $arParams['IS_ENABLED_AUTH_BY_LOGIN'] == 'Y', 'isEnabledAuthByEmail' => $arParams['IS_ENABLED_AUTH_BY_EMAIL'] == 'Y', 'isEnabledPhoneMask' => $arParams['IS_ENABLED_PHONE_MASK'] == 'Y', 'phoneMaskDefaultCountry' => $arParams['PHONE_MASK_DEFAULT_COUNTRY'], 'phoneMaskCountryTopList' => $arParams['PHONE_MASK_COUNTY_TOP_LIST'], 'messages' => ['UPDATE_CAPTCHA_IMAGE' => \GetMessage($CPN . 'UPDATE_CAPTCHA_IMAGE'), 'INPUT_CAPTHCA' => \GetMessage($CPN . 'INPUT_CAPTHCA'), 'REGISTER_INFO' => \GetMessage($CPN . 'REGISTER_INFO'), 'BTN_SEND_CODE' => \GetMessage($CPN . 'BTN_SEND_CODE'), 'BTN_SEND_EMAIL' => \GetMessage($CPN . 'BTN_SEND_EMAIL'), 'BTN_SEND_CODE_TIMEOUT' => \GetMessage($CPN . 'BTN_SEND_CODE_TIMEOUT')]]);?>;
    </script>
    <?$frame->end();?>
</div>