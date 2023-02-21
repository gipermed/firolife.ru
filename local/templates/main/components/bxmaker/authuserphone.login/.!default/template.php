<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)die();
    $CPN = 'bxmaker.authuserphone.login';
    $oManager = \Bxmaker\AuthUserPhone\Manager::getInstance();
    $this->setFrameMode(true);
    $rand = $arParams['RAND_STRING'];

//global $USER;
//if($USER->IsAuthorized()){
//    $APPLICATION->SetTitle('Личный кабинет');
//    $APPLICATION->SetPageProperty('title','Личный кабинет');
//    $APPLICATION->AddChainItem("Личный кабинет", "");
//}else{
//    $APPLICATION->SetTitle('Вход / Регистрация');
//    $APPLICATION->SetPageProperty('title','Вход / Регистрация');
//    $APPLICATION->AddChainItem("Вход / Регистрация", "");
//}
?>
    <div class="col-12 col-lg-7 c-bxmaker-authuserphone_login-default-box bxmaker-authuserphone-login bxmaker-authuserphone-login--default" id="bxmaker-authuserphone-login--<?= $rand; ?>" data-rand="<?= $rand; ?>" data-consent="<?= $arParams['CONSENT_SHOW']; ?>">
        <?/*span class="cbaup_btn_reg"><?= GetMessage($CPN . 'BTN_REGISTER'); ?></span*/?>
        <? if (\Bxmaker\AuthUserPhone\Manager::getInstance()->isExpired()): ?>
            <p style="color:red; padding:0;margin:0 ;"><?= GetMessage($CPN . 'DEMO_EXPIRED'); ?></p>
        <? endif; ?>
        <div class="cbaup_title page-title" data-register-title="<?= GetMessage($CPN . 'BTN_REGISTER'); ?>"
             data-auth-title="<?= GetMessage($CPN . 'AUTH_TITLE'); ?>">Вход или Регистрация</div>
        <?
            $frame = $this->createFrame('bxmaker-authuserphone-login--' . $rand)->begin('<div class="bxmaker-authuserphone-loading"></div>');
            $frame->setAnimation(true);
        ?>
        <? if ($arResult['USER_IS_AUTHORIZED'] == 'Y'): ?>
            <div class="msg success" style="margin-bottom:0;display:none;">
                <?= GetMessage($CPN . 'USER_IS_AUTHORIZED'); ?>
            </div>
        <? else: ?>
            <div class="msg ">
            </div>
            <div class="cbaup_row">
                <input type="text" name="phone" class="phone js-phone-masked2" placeholder="Номер телефона"
                       data-reg-placeholder="Номер телефона" data-auth-placeholder="Номер телефона"/>
            </div>
            <? if ($oManager->param()->isEnabledRegisterEmail()): ?>
                <div class="cbaup_row email_box">
                    <input type="text" name="email" class="email" placeholder="<?= GetMessage($CPN . 'INPUT_EMAIL'); ?>"/>
                </div>
            <? endif; ?>
            <? if ($oManager->param()->isEnabledRegisterLogin()): ?>
                <div class="cbaup_row login_box">
                    <input type="text" name="login" class="login" placeholder="<?= GetMessage($CPN . 'INPUT_LOGIN'); ?>"/>
                </div>
            <? endif; ?>

            <div class="cbaup_row captcha">
                <?
                    /*
                    <input type="hidden" name="captcha_sid" value="0b853532ea27dba6a71666bb89ab6760"/>
                    <img src="/bitrix/tools/captcha.php?captcha_sid=0b853532ea27dba6a71666bb89ab6760" title="<?= GetMessage($CPN . 'UPDATE_CAPTCHA_IMAGE');?>" alt=""/>
                    <span class="btn_captcha_reload" title="<?= GetMessage($CPN . 'UPDATE_CAPTCHA_IMAGE');?>"></span>
                    <input type="text" name="captcha_word" class="captcha_word" placeholder="<?= GetMessage($CPN . 'INPUT_CAPTHCA');?>"/>
                    */
                ?>
            </div>
            <div class="cbaup_row mini hidden" style="display: none;">
                <input type="checkbox" name="remember" id="cbaup_remember" checked value="Y"/>
                <label for="cbaup_remember"><?= GetMessage($CPN . 'REMEMBER_ME'); ?></label>
            </div>
            <div class="cbaup_row codeInputJs" style="display: none">

                <input style="display: none" type="password" name="password" class="password" data-auth="<?= GetMessage($CPN . 'INPUT_PASSWORD'); ?>"
                       data-reg="<?= GetMessage($CPN . 'INPUT_SMSCODE'); ?>" placeholder="<?= GetMessage($CPN . 'INPUT_PASSWORD'); ?>"/>

                <div class="auth-number__send">
                    На номер <span>+7 (999) 990-99-99</span> был отправлен код
                </div>

                <div class="auth-description">
                    Этот код используется для входа или регистрации в личном кабинете.
                    Введите 4-х значный числовой код в поле отображаемое ниже.
                </div>

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

                <span style="display: none" class="btn_show_password" title="<?= GetMessage($CPN . 'BTN_SHOW_PASSWORD'); ?>"
                      data-title-show="<?= GetMessage($CPN . 'BTN_SHOW_PASSWORD'); ?>" data-title-hide="<?= GetMessage($CPN . 'BTN_HIDE_PASSWORD'); ?>"></span>

                <? if ($arResult['USER_IS_AUTHORIZED'] != 'Y'): ?>
                    <div class="cbaup_row btn_box form-footer">
                        <div class="cbaup_btn btn btn--primary" data-auth-title="<?= GetMessage($CPN . 'BTN_INTER'); ?>"
                             data-reg-title="<?= GetMessage($CPN . 'BTN_REG_INTER'); ?>"><?= GetMessage($CPN . 'BTN_INTER'); ?></div>
                    </div>
                <? endif; ?>
            </div>
            <div class="cbaup_row text-center">
                <span class="cbaup_btn_link codeLinkJs btn btn--primary"><?= GetMessage($CPN . 'BTN_SEND_CODE'); ?></span>
            </div>
        <?/*div class="cbaup_row bxmaker-authuserphone-login__restore-email">
            <span class="cbaup_btn_send_email" ><?= GetMessage($CPN . 'BTN_SEND_EMAIL');?></span>
        </div*/?>
        <? endif; ?>
        <?
            if ($arParams['CONSENT_SHOW'] == 'Y'):
                $arFields = array();
                $arFields[] = GetMessage($CPN . 'INPUT_PHONE_REG');

                if ($oManager->param()->isEnabledRegisterEmail()) {
                    $arFields[] = GetMessage($CPN . 'INPUT_EMAIL');
                }
                if ($oManager->param()->isEnabledRegisterLogin()) {
                    $arFields[] = GetMessage($CPN . 'INPUT_LOGIN');
                }
                ?>
                <div class="cbaup_row cbaup_row--registration ">
                    <? $APPLICATION->IncludeComponent("bitrix:main.userconsent.request", "", array(
                            'ID'                => $arParams['CONSENT_ID'],
                            "IS_CHECKED"        => 'N',
                            "IS_LOADED"         => "Y",
                            "AUTO_SAVE"         => "N",
                            'SUBMIT_EVENT_NAME' => 'bxmaker_authuserphone_registration',
                            'REPLACE'           => array(
                                'button_caption' => GetMessage($CPN . 'BTN_REG_INTER'),
                                'fields'         => $arFields
                            ),
                        ), $component); ?>
                </div>
            <? endif; ?>

        <script type="text/javascript" class="bxmaker-authuserphone-jsdata">
            $(document).ready(function(){
                $('.auth-inputs__input').on('keyup',function(){
                    $('.codeInputJs .password').val($('input[name=auth-input-1]').val()+''+$('input[name=auth-input-2]').val()+''+$('input[name=auth-input-3]').val()+''+$('input[name=auth-input-4]').val());
                });
               $('.auth-other__link').on('click',function(){
                   $('.js-phone-masked2').parent().show();
                   $('.codeLinkJs').parent().show();
                   $('.codeInputJs').hide();
                   $('.auth-time__text').text('Получить код в СМС');
                   $('.codeLinkJs').text('Получить код в СМС');
                   $('.auth-time__text').removeClass("timeout");
                   $('.codeLinkJs').removeClass("timeout");

                   $('.auth-inputs__input').val('');
               });

               // $('.codeLinkJs').on('click',function(){
               //
               // });
            });

            <?
            // component parameters
            $signer = new \Bitrix\Main\Security\Sign\Signer;
            $signedParameters = $signer->sign(base64_encode(serialize($arResult['_ORIGINAL_PARAMS'])), 'bxmaker.authuserphone.login');
            $signedTemplate = $signer->sign($arResult['TEMPLATE'], 'bxmaker.authuserphone.login');
            ?>

            window.BxmakerAuthUserPhoneLoginData = window.BxmakerAuthUserPhoneLoginData || {};
            window.BxmakerAuthUserPhoneLoginData["<?=$rand;?>"] = <?= Bitrix\Main\Web\Json::encode(array(
                'parameters' => $signedParameters,
                'template'   => $signedTemplate,
                'siteId'     => SITE_ID,
                'ajaxUrl'    => $this->getComponent()->getPath() . '/ajax.php',
                'rand' => $rand,

                'messages' => array(
                    'UPDATE_CAPTCHA_IMAGE'  => GetMessage($CPN . 'UPDATE_CAPTCHA_IMAGE'),
                    'INPUT_CAPTHCA'         => GetMessage($CPN . 'INPUT_CAPTHCA'),
                    'REGISTER_INFO'         => GetMessage($CPN . 'REGISTER_INFO'),
                    'BTN_SEND_CODE'         => GetMessage($CPN . 'BTN_SEND_CODE'),
                    'BTN_SEND_EMAIL'        => GetMessage($CPN . 'BTN_SEND_EMAIL'),
                    'BTN_SEND_CODE_TIMEOUT' => GetMessage($CPN . 'BTN_SEND_CODE_TIMEOUT')
                ),
            ));?>;
        </script>
        <?$frame->end();?>
    </div>
<?
