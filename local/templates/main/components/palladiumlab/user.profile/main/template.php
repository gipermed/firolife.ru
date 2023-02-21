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
if ($user->birthday === null) $birthday = ""; else
{
	$user->birthday->format("Y-m-d");
}
$gender = false;
if ($user->gender === "M") $gender = true;
$promotion = $user->promotion ? "active" : "";
?>
<div class="cabinet cabinet-profile">
    <div class="cabinet-profile-body">
        <div class="cabinet-section cabinet-section-profile-data">
            <p style="color: red"> <?= $arResult['ERROR'] ?></p>
            <div class="cabinet-profile-title-wrapp">
                <div class="cabinet-section-title">
                    Личные
                    данные
                </div>
                <div class="cabinet-profile-title-desc">
                    Информация
                    для
                    заказов
                </div>
            </div>
            <form action="<?= POST_FORM_ACTION_URI ?>"
                  method="post"
                  class="cabinet-profile-form form">
				<?= bitrix_sessid_post() ?>
                <input type="hidden"
                       name="action"
                       value="update-profile">
                <div class="cabinet-profile-form-row flex-row">
                    <div class="cabinet-profile-form-col flex-row-item">
                        <label class="form-block">
                            <span class="form-block-title">Фамилия:</span>
                            <input type="text"
                                   class="input"
                                   name="surname"
                                   value="<?= $user->surname ?>"
                                   required>
                        </label>
                    </div>
                    <div class="cabinet-profile-form-col flex-row-item">
                        <label class="form-block">
                            <span class="form-block-title">Имя:</span>
                            <input type="text"
                                   class="input"
                                   name="name"
                                   value="<?= $user->name ?>"
                                   required>
                        </label>
                    </div>
                    <div class="cabinet-profile-form-col flex-row-item">
                        <label class="form-block">
                            <span class="form-block-title">Отчество:</span>
                            <input type="text"
                                   class="input"
                                   name="second_name"
                                   value="<?= $user->second_name ?>">
                        </label>
                    </div>
                    <div class="cabinet-profile-form-col flex-row-item">
                        <label class="form-block">
                            <span class="form-block-title">Мобильный телефон:</span>
                            <input type="tel"
                                   class="input"
                                   name="login"
                                   value="<?= $user->login ?>"
                                   required>
                        </label>
                    </div>
                    <div class="cabinet-profile-form-col flex-row-item">
                        <label class="form-block">
                            <span class="form-block-title">Электронная почта:</span>
                            <input type="email"
                                   class="input"
                                   name="email"
                                   value="<?= $user->email ?>"
                                   required>
                        </label>
                    </div>
                    <div class="cabinet-profile-form-col flex-row-item"></div>
                    <div class="cabinet-profile-form-col flex-row-item">
                        <label class="form-block">
                            <span class="form-block-title">Дата рождения:</span>
                            <input type="date"
                                   class="input"
                                   name="birthday"
                                   value="<?= $birthday ?>">
                        </label>
                    </div>
                    <div class="cabinet-profile-form-col flex-row-item">
                        <div class="form-block">
                            <span class="form-block-title">Пол:</span>
                            <ul class="radio-btns">
                                <li>
                                    <label class="radio-label radio-ladel-btn <?= $gender ? 'active' : '' ?>">
                                        <input type="radio"
                                               class="radio-input"
                                               name="cabinet-profile-gender"
                                               value="Мужской"
											<?= $gender ? 'checked' : '' ?>>
                                        <span>Мужской</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="radio-label radio-ladel-btn <?= !$gender ? 'active' : '' ?>">
                                        <input type="radio"
                                               class="radio-input"
                                               name="cabinet-profile-gender"
                                               value="Женский"
											<?= !$gender ? 'checked' : '' ?>>
                                        <span>Женский</span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="cabinet-profile-form-submit-wrapp submit-wrapp">
                    <label class="checkbox-label <?= $promotion ?>">
                        <input type="checkbox"
                               class="checkbox-input"
                               name="promotion"
                        >
                        <span>Хочу участвовать в скидках, акциях и распродажах.</span>
                    </label>
                    <button type="submit"
                            class="btn btn-green submit"
                            disabled>
                        Сохранить
                        изменения
                    </button>
                </div>
            </form>
        </div>
        <form action="<?= POST_FORM_ACTION_URI ?>"
              method="post">
			<?= bitrix_sessid_post() ?>
            <input type="hidden"
                   name="action"
                   value="delete-profile">
            <div class="cabinet-section hidden-desktop">
                <div class="cabinet-profile-del">
                    <div class="cabinet-profile-del-title">
                        Удалить
                        личный
                        кабинет
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
                            все
                            накопленные
                            вами
                            проценты.
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
                    <button type="submit"
                            class="cabinet-profile-del-btn btn submit">
                        Удалить
                        личный
                        кабинет
                    </button>
                </div>
            </div>
        </form>

    </div>
    <div class="cabinet-profile-sidebar">
        <div class="cabinet-section cabinet-section-profile-password">
            <div class="cabinet-section-title">
                Изменить
                пароль
            </div>
            <form action="<?= POST_FORM_ACTION_URI ?>"
                  method="post"
                  class="cabinet-password-form ordering-form form">
				<?= bitrix_sessid_post() ?>
                <input type="hidden"
                       name="action"
                       value="update-profile">
                <label class="form-block form-block-password">
                    <span class="form-block-title">Пароль (Тот, что сейчас)</span>
                    <span class="input-wrapp">
								<input type="password"
                                       name="old_password"
                                       class="input"
                                       required>
								<a href="#"
                                   class="password-input-type-toggle">
									<svg width="18"
                                         height="18"><use
                                                xlink:href="#icon-eye-open"/></svg>
									<svg width="18"
                                         height="18"><use
                                                xlink:href="#icon-eye-close"/></svg>
								</a>
							</span>
                </label>
                <label class="form-block form-block-password">
                    <span class="form-block-title">Новый пароль</span>
                    <span class="input-wrapp">
								<input type="password"
                                       pattern=".{8,}"
                                       name="password"
                                       class="input"
                                       required>
								<a href="#"
                                   class="password-input-type-toggle">
									<svg width="18"
                                         height="18"><use
                                                xlink:href="#icon-eye-open"/></svg>
									<svg width="18"
                                         height="18"><use
                                                xlink:href="#icon-eye-close"/></svg>
								</a>
							</span>
                    <span class="form-block-desc">Пароль должен быть не меньше 8 символов</span>
                </label>
                <label class="form-block form-block-password">
                    <span class="form-block-title">Новый пароль</span>
                    <span class="input-wrapp">
								<input type="password"
                                       name="confirm_password"
                                       class="input"
                                       pattern=".{8,}"
                                       required>
								<a href="#"
                                   class="password-input-type-toggle">
									<svg width="18"
                                         height="18"><use
                                                xlink:href="#icon-eye-open"/></svg>
									<svg width="18"
                                         height="18"><use
                                                xlink:href="#icon-eye-close"/></svg>
								</a>
							</span>
                </label>
                <div class="submit-wrapp">
                    <button type="submit"
                            class="btn btn-green submit"
                            disabled>
                        Сохранить
                        изменения
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="cabinet-profile-del visible-desktop">
        <div class="cabinet-profile-del-title">
            Удалить
            личный
            кабинет
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
                все
                накопленные
                вами
                проценты.
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
        <form action="<?= POST_FORM_ACTION_URI ?>"
              method="post"
              class="cabinet-password-form ordering-form form">
			<?= bitrix_sessid_post() ?>
            <input type="hidden"
                   name="action"
                   value="delete-profile">
            <button type="submit"
                    class="cabinet-profile-del-btn btn submit"
            >
                Удалить
                личный
                кабинет
            </button>
        </form>
    </div>
</div>
