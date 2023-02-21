<?php check_prolog();

use Palladiumlab\Management\User;

$user = User::current();

global $APPLICATION;
global $USER;
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */
global $USER;
//$rsUser = CUser::GetByID($USER->GetId());
//$arUser = $rsUser->Fetch();
$rsUsers = CUser::GetList(($by="id"), ($order="desc"), array("ID"=>$USER->GetId()), array('SELECT'=>array('UF_*'),'FIELDS'=>array('*')));
while($arUser = $rsUsers->Fetch()){
    $curUser = $arUser;
}
if ($curUser['PERSONAL_BIRTHDAY'] === null) $birthday = ""; else
{
//    $curUser['PERSONAL_BIRTHDAY']->format("Y-m-d");
}
$gender = false;
if ($curUser['PERSONAL_GENDER'] === "M") $gender = true;
$promotion = $user->promotion ? "active" : "";
if ($curUser['PERSONAL_GENDER'] === "M")
$polM = "Мужской";
if ($curUser['PERSONAL_GENDER'] === "F")
	$polM = "Женский";



?>
<div class="cabinet cabinet-profile">
    <div class="cabinet-section cabinet-section-profile-data">
        <p style="color: red"> <?= $arResult['ERROR'] ?></p>
        <div class="cabinet-profile-title-wrapp">
            <div class="cabinet-section-title">Личная информация и подписки<a href="/personal/main/" class="btn-lk-return">< Вернуться в профиль</a></div>
        </div>
        <form action="<?= POST_FORM_ACTION_URI ?>" method="post" class="form">
			<?= bitrix_sessid_post() ?>
            <input type="hidden" name="action" value="update-profile">
            <div class="personal-info__list">
				<div class="personal-info__group">
                    <span class="personal-info__char">Пол:</span>
					<div class="personal-info__val">
                        <div class="personal-info__val__current">
                            <?= $polM ?>
                        </div>
                        <div class="personal-info__val__edit">
                            <label class="custom-checkbox">
                                <input type="radio" name="personal-gender" value="val-1" class="personal-gender-value custom-checkbox__value">
                                <span class="custom-checkbox__icon"></span>
                                <span class="custom-checkbox__text">Не указан</span>
                            </label>
                            <label class="custom-checkbox">
                                <input type="radio" name="personal-gender" value="val-2" class="personal-gender-value custom-checkbox__value">
                                <span class="custom-checkbox__icon"></span>
                                <span class="custom-checkbox__text">Мужской</span>
                            </label>
                            <label class="custom-checkbox">
                                <input type="radio" name="personal-gender" value="val-3" class="personal-gender-value custom-checkbox__value">
                                <span class="custom-checkbox__icon"></span>
                                <span class="custom-checkbox__text">Женский</span>
                            </label>
                        </div>
                        <div class="edit-personal-success"><svg class="icon"><use xlink:href="#icon-check"></use></svg></div>
                        <div class="edit-personal-value"><svg class="icon"><use xlink:href="#icon-pencil-sm"></use></svg></div>
                    </div>
                </div>
                <div class="personal-info__group">
                    <span class="personal-info__char">Дата рождения:</span>
					<div class="personal-info__val">
                        <div class="personal-info__val__current">
                            <?= $curUser['PERSONAL_BIRTHDAY'] ?>
                        </div>
                        <div class="personal-info__val__edit">
                            <div class="form-group has-datepicker">
                                <svg class="icon icon-help"><use xlink:href="#icon-calendar"></use></svg>
                                <input type="text" class="js-datepicker form-control" name="personal-birthday" placeholder="Выберите дату" autocomplete="off">
                                <div class="step-completed"><svg class="icon"><use xlink:href="#icon-check"></use></svg></div>
                            </div>
                        </div>
                        <div class="edit-personal-success"><svg class="icon"><use xlink:href="#icon-check"></use></svg></div>
                        <div class="edit-personal-value"><svg class="icon"><use xlink:href="#icon-pencil-sm"></use></svg></div>
                    </div>
                </div>
                <div class="personal-info__group">
                    <span class="personal-info__char">Имя:</span>
					<div class="personal-info__val">
                        <div class="personal-info__val__current">
                            <?= $curUser['NAME'] ?>
                        </div>
                        <div class="personal-info__val__edit">
                            <div class="form-group">
                                <input type="text" class="form-control" name="user-name" placeholder="Введите имя">
                                <div class="step-completed nameComplete"><svg class="icon"><use xlink:href="#icon-check"></use></svg></div>
                            </div>
                        </div>
                        <div class="edit-personal-success"><svg class="icon"><use xlink:href="#icon-check"></use></svg></div>
                        <div class="edit-personal-value"><svg class="icon"><use xlink:href="#icon-pencil-sm"></use></svg></div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="personal-notification__group cabinet-profile-form-submit-wrapp submit-wrapp" style="border-top: solid 1px #E2E2E2; padding-top: 20px;">
    <div class="personal-notification__title">Управление подписками</div>
    <?/*<label class="checkbox-label <?= $promotion ?>">
        <input type="checkbox"
               class="checkbox-input"
               name="promotion"
        >
        <span>E‐mail</span>
    </label>*/?>
	<p class="personal-notification__description">Управление подписками помогает пользователю получать только ту информацию от сайта gipermed.com, которая ему интересна. Чтобы настроить свои подписки, включите или, наоборот, отключите нужную вам категорию подписок в списке ниже.</p>
</div>

<div class="personal-notification__group cabinet-profile-form-submit-wrapp submit-wrapp" style="border-top: solid 1px #E2E2E2; padding-top: 20px; font-weight: 600; font-size: 15px;">
    <div class="personal-notification__subtitle">Сообщения о новых акциях</div>
    <div class="personal-notification__values">
        <label class="notification-checkbox checkbox-label<?if($curUser['UF_PROMO_SMS']):?> active<?endif;?>">
            <input type="checkbox" class="checkbox-input promoJs" data-code="UF_PROMO_SMS" name="promotion-sms"<?if($curUser['UF_PROMO_SMS']):?> checked<?endif;?>>
            <span class="notification-checkbox__text">СМС</span>
        </label>
        <label class="notification-checkbox checkbox-label<?if($curUser['UF_PROMO_MAIN']):?> active<?endif;?>">
            <input type="checkbox" class="checkbox-input promoJs" data-code="UF_PROMO_MAIN" name="promotion-mail"<?if($curUser['UF_PROMO_MAIN']):?> checked<?endif;?>>
            <span class="notification-checkbox__text">E‐mail</span>
        </label>
        <label class="notification-checkbox checkbox-label<?if($curUser['UF_PROMO_CALL']):?> active<?endif;?>">
            <input type="checkbox" class="checkbox-input promoJs" data-code="UF_PROMO_CALL" name="promotion-call"<?if($curUser['UF_PROMO_CALL']):?> checked<?endif;?>>
            <span class="notification-checkbox__text">Звонок оператора</span>
        </label>
    </div>
    <p class="personal-notification__description">Вы будете получать еженедельные уведомления об акциях и скидках на сайте gipermed.com</p>
</div>

<div class="personal-notification__group cabinet-profile-form-submit-wrapp submit-wrapp" style="border-top: solid 1px #E2E2E2; padding-top: 20px; font-weight: 600; font-size: 15px;">
    <div class="personal-notification__subtitle">Запросы отзывов об удовлетворенности работой сервиса gipermed.com</div>
    <div class="personal-notification__values">
        <label class="notification-checkbox checkbox-label<?if($curUser['UF_REVIEWS_EMAIL']):?> active<?endif;?>">
            <input type="checkbox" class="checkbox-input promoJs" data-code="UF_REVIEWS_EMAIL" name="reviews-mail"<?if($curUser['UF_REVIEWS_EMAIL']):?> checked<?endif;?>>
            <span class="notification-checkbox__text">E‐mail</span>
        </label>
        <label class="notification-checkbox checkbox-label<?if($curUser['UF_REVIEWS_CALL']):?> active<?endif;?>">
            <input type="checkbox" class="checkbox-input promoJs" data-code="UF_REVIEWS_CALL" name="reviews-call"<?if($curUser['UF_REVIEWS_CALL']):?> checked<?endif;?>>
            <span class="notification-checkbox__text">Звонок оператора</span>
        </label>
    </div>
    <p class="personal-notification__description">Мы стремимся улучшить наш сервис, поэтому можем связаться с вами для того, чтобы узнать, нравится ли вам как выглядит и работает сайт, как организовано оповещение и доставка.</p>
</div>

<div class="personal-notification__group cabinet-profile-form-submit-wrapp submit-wrapp" style="border-top: solid 1px #E2E2E2; padding-top: 20px; font-weight: 600; font-size: 15px;">
    <div class="personal-notification__subtitle">Сервисные сообщения</div>
    <div class="personal-notification__values">
        <label class="notification-checkbox checkbox-label<?if($curUser['UF_SERVICE_EMAIL']):?> active<?endif;?>">
            <input type="checkbox" class="checkbox-input promoJs" data-code="UF_SERVICE_EMAIL" name="services-mail"<?if($curUser['UF_SERVICE_EMAIL']):?> checked<?endif;?>>
            <span class="notification-checkbox__text">E‐mail</span>
        </label>
    </div>
    <p class="personal-notification__description">Вы будете получать сервисные уведомления о статусе заказа.</p>
</div>
<div class="personal-notification-all">
    <a href="javascript:void(0)" class="notification-enable-all">Bключить все уведомления</a>
    <a href="javascript:void(0)" class="notification-disable-all">Отключить все уведомления</a>
</div>