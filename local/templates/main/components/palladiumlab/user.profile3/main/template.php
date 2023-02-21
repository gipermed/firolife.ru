<?php check_prolog();

use Palladiumlab\Management\User;

$user = User::current();

global $APPLICATION;
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
$rsUser = CUser::GetByID($USER->GetId());
$arUser = $rsUser->Fetch();

if ($arUser['PERSONAL_BIRTHDAY'] === null) $birthday = ""; else
{
//    $arUser['PERSONAL_BIRTHDAY']->format("Y-m-d");
}
$gender = false;
if ($arUser['PERSONAL_GENDER'] === "M") $gender = true;
$promotion = $user->promotion ? "active" : "";
?>
<div class="cabinet-section cabinet-section-profile-data">
        <div class="cabinet-profile-title-wrapp">
            <div class="cabinet-section-title">
                Профиль

            </div>
        </div>
        <div class="cabinet-profile-form-row flex-row">
            <div class="cabinet-profile-form-col-mainp1 flex-row-item">
                <label class="form-block">
                    <!--<span class="form-block-title">Здравствуйте, <?= $user->surname ?>!</span>-->
                    <span class="form-block-title">Здравствуйте, <?= $arUser['NAME']?>!</span>
                </label>
            </div>
            <div class="cabinet-profile-form-col-mainp2 flex-row-item">
                <label class="form-block">
                    <a class="link-logout" href="?logout=yes&<?= bitrix_sessid_get() ?>">
                        <span>Выйти из аккаунта</span>
                        <svg class="icon"><use xlink:href="#icon-logout-sm"></use></svg>
                    </a>
                </label>
            </div>
            <?/*div class="cabinet-profile-form-col-mainp3 flex-row-item">
                <img src="/local/templates/main/assets/img/Group_2852.jpg" alt="">
            </div*/?>
        </div>
        <div class="cabinet-profile-form-row flex-row">
            <div class="cabinet-profile-form-col-maintel flex-row-item">
                <label class="form-block">
                    <span class="personal-info__char">Номер телефона:</span>
                    <span class="personal-info__val">
                        <div class="personal-info__val__current main-value">
                            <?= $arUser['PERSONAL_MOBILE'] ?>
                        </div>
                    </span>
                </label>
            </div>
            <div class="cabinet-profile-form-col-mainemail flex-row-item">
                <div class="personal-info__group">
                    <span class="personal-info__char">Электронная почта:</span>
                    <div class="personal-info__val">
                        <div class="personal-info__val__current main-value">
                            <?= $arUser['EMAIL'] ?>
                        </div>
                        <div class="personal-info__val__edit">
                            <div class="form-group">
                                <input type="text" class="form-control" name="user-email" value="<?= $arUser['EMAIL'] ?>" placeholder="Введите почту">
                                <div class="step-completed nameComplete jsChangeMail"><svg class="icon"><use xlink:href="#icon-check"></use></svg></div>
                            </div>
                        </div>
                        <div class="edit-personal-success"><svg class="icon"><use xlink:href="#icon-check"></use></svg></div>
                        <div class="edit-personal-value"><svg class="icon"><use xlink:href="#icon-pencil-sm"></use></svg></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="cabinet cabinet-profile">
        <div class="cabinet-profile-body-main">
            <div class="cabinet-profile-title-desc-main">Основные настройки</div>
            <div class="cabinet-section-main">
                <a href="/personal/orders/"> <span>Мои&nbsp;заказы</span> </a><br>
                <div class="cabinet-main-title"></div>
                <a href="/personal/profile/"> <span>Личная информация и подписки</span> </a><br>
                <div class="cabinet-main-title"></div>
                <a href="/personal/profile/review.php"> <span>Мои&nbsp;отзывы</span> </a><br>
                <div class="cabinet-main-title"></div>
                <a href="/personal/profile/adress.php"> <span>Мои&nbsp;адреса</span> </a><br>
            </div>
            <div class="cabinet-profile-title-desc-main"> Избранное и лист ожидания </div>
            <div class="cabinet-section-main">
                <a href="/personal/catalog/fav.php"> <span>Избранное</span> </a><br>
                <div class="cabinet-main-title"></div>
                <a href="/personal/catalog/await.php"> <span>Лист ожидания</span> </a><br>
            </div>
			<?/*div class="cabinet-profile-title-desc-main">Бонусная программа</div>
            <div class="cabinet-section-main">
                <a href="#"> <span>Мои бонусные рубли</span> </a><br>
                <div class="cabinet-main-title"></div>
                <a href="#"> <span>Приведи друга</span> </a>
</div*/?>
            <div class="cabinet-profile-del-desc hidden-desktop">
                <div class="cabinet-profile-form-row flex-row">
                    <div class="cabinet-profile-form-col-main flex-row-item">
                        <label class="form-block">
                            <a href="javascript:void(0)" class="js-open-profile-delete"><button class="cabinet-profile-del-btn btn submit">Удалить профиль</button>                                    </a>
                        </label>
                    </div>
                    <div class="cabinet-profile-form-col-main2 flex-row-item">
                        <label class="form-block">
                            <span class="form-block-title">Вы можете удалить свою учетную запись без возможности восстановления. Ваша история заказов будет очищена.</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    <div class="cabinet-profile-sidebar-main hidden-desktop">
        <img src="/local/templates/main/assets/img/Rectangle_85.jpg" srcset="/local/templates/main/assets/img/loyalty-banner@2x.jpg 2x" alt="">
    </div>

	<div class="cabinet-profile-del visible-desktop">
        <div class="cabinet-profile-del-title">
            Удалить личный кабинет
        </div>
        <div class="cabinet-profile-del-desc">
            <p>
                Обращаем
                внимание,
                что
                при
                удалении
                личного
                кабинета
                будут
                обнулены
                все  накопленные вами проценты.
            <p>
                Как
                только
                ваш
                Личный
                кабинет
                будет
                удален,
                вы
                автоматически
                выйдете
                из
                системы
                и
                больше
                не
                сможете
                войти
                в
                этот
                аккаунт.
        </div>
        <a href="javascript:void(0)" class="cabinet-profile-del-btn btn submit js-open-profile-delete">Удалить личный кабинет</a>
    </div>
</div>

<div class="custom-modal modal-profile-delete">
    <div class="custom-modal__content">
        <div class="custom-modal__close"><svg class="icon"><use xlink:href="#icon-close"></use></svg></div>
        <div class="custom-modal__title">Вы действительно хотите удалить свой профиль?</div>
        <div class="custom-modal__description">
            После удаления вы не сможете восстановить свой профиль. Ваша история заказов будет очищена, информация удалена.
        </div>
        <div class="custom-modal__footer">
            <a href="javascript:void(0)" class="jsDelProfile btn btn-confirm">Да, удалить</a>
            <a href="javascript:void(0)" class="jsCloseModal btn btn-cancel">Нет, я не хочу удалять</a>
        </div>
    </div>
    <div class="custom-modal__bg"></div>
</div>



