<?php check_prolog();

use Palladiumlab\Management\User;

$user = User::current();

global $APPLICATION;

?>

<div class="profile-settings">
    <form action="<?= POST_FORM_ACTION_URI ?>"
          class="profile-form form"
          method="post">

		<?= bitrix_sessid_post() ?>
        <input type="hidden"
               name="action"
               value="update-profile">

        <div class="form-row flex-row">
            <div class="form-col flex-row-item">
                <label class="form-block">
                    <span class="form-block-title">Имя <span>*</span></span>
                    <span class="form-block-input">
                        <input type="text"
                               name="name"
                               class="input"
                               required
                               value="<?= $user->name ?>">
                        <i class="form-block-icon form-block-icon-valid">
                            <svg width="16"
                                 height="16"><use
                                        xlink:href="#icon-check"/></svg>
                        </i>
                        <a href="#"
                           class="form-block-icon form-block-icon-clear">
                            <svg width="16"
                                 height="16"><use
                                        xlink:href="#icon-close"/></svg>
                        </a>
                    </span>
                </label>
            </div>
            <div class="form-col flex-row-item">
                <label class="form-block">
                    <span class="form-block-title">Компания <span>*</span></span>
                    <span class="form-block-input">
                        <input type="text"
                               name="company"
                               class="input"
                               required
                               value="<?= $user->company ?>">
                        <i class="form-block-icon form-block-icon-valid">
                            <svg width="16"
                                 height="16"><use
                                        xlink:href="#icon-check"/></svg>
                        </i>
                        <a href="#"
                           class="form-block-icon form-block-icon-clear">
                            <svg width="16"
                                 height="16"><use
                                        xlink:href="#icon-close"/></svg>
                        </a>
                    </span>
                </label>
            </div>
            <div class="form-col flex-row-item">
                <label class="form-block">
                    <span class="form-block-title">Сайт компании</span>
                    <span class="form-block-input">
                        <input type="url"
                               name="company_site"
                               class="input"
                               value="<?= $user->company_site ?>">
                        <i class="form-block-icon form-block-icon-valid">
                            <svg width="16"
                                 height="16"><use
                                        xlink:href="#icon-check"/></svg>
                        </i>
                        <a href="#"
                           class="form-block-icon form-block-icon-clear">
                            <svg width="16"
                                 height="16"><use
                                        xlink:href="#icon-close"/></svg>
                        </a>
                    </span>
                </label>
            </div>
            <div class="form-col flex-row-item">
                <label class="form-block">
                    <span class="form-block-title">E-mail <span>*</span></span>
                    <span class="form-block-input">
                        <input type="email"
                               name="email"
                               class="input"
                               required
                               value="<?= $user->email ?>">
                        <i class="form-block-icon form-block-icon-valid">
                            <svg width="16"
                                 height="16"><use
                                        xlink:href="#icon-check"/></svg>
                        </i>
                        <a href="#"
                           class="form-block-icon form-block-icon-clear">
                            <svg width="16"
                                 height="16"><use
                                        xlink:href="#icon-close"/></svg>
                        </a>
                    </span>
                </label>
            </div>
            <div class="form-col flex-row-item">
                <label class="form-block">
                    <span class="form-block-title">Телефон <span>*</span></span>
                    <span class="form-block-input">
                        <input type="tel"
                               name="personal_phone"
                               class="input"
                               required
                               value="<?= $user->personal_phone ?>">
                        <i class="form-block-icon form-block-icon-valid">
                            <svg width="16"
                                 height="16"><use
                                        xlink:href="#icon-check"/></svg>
                        </i>
                        <a href="#"
                           class="form-block-icon form-block-icon-clear">
                            <svg width="16"
                                 height="16"><use
                                        xlink:href="#icon-close"/></svg>
                        </a>
                    </span>
                </label>
            </div>
            <div class="form-col flex-row-item">
                <label class="form-block">
                    <span class="form-block-title">Адрес <span>*</span></span>
                    <span class="form-block-input">
                        <input type="text"
                               name="address"
                               class="input"
                               required
                               value="<?= $user->address ?>">
                        <i class="form-block-icon form-block-icon-valid">
                            <svg width="16"
                                 height="16"><use
                                        xlink:href="#icon-check"/></svg>
                        </i>
                        <a href="#"
                           class="form-block-icon form-block-icon-clear">
                            <svg width="16"
                                 height="16"><use
                                        xlink:href="#icon-close"/></svg>
                        </a>
                    </span>
                </label>
            </div>
        </div>
        <div class="form-submit">
            <button type="submit"
                    class="submit btn"
                    formnovalidate
                    disabled>
                Сохранить
                изменения
            </button>
        </div>
    </form>
    <div class="profile-contacts">
        <div class="profile-contacts-body">
            <div class="profile-contacts-title">
                В
                случае
                возникновения
                вопросов,
                Вы
                всегда
                можете
                связаться
                с
                нами
                по
                следующим
                контактам:
            </div>
            <ul class="profile-contacts-links">
                <li>
                    <a href="tel:<?= include_content_phone('/phone.php') ?>">
						<?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
							"AREA_FILE_SHOW" => "file",
							"PATH"           => "/include/phone.php"
						)) ?>
                    </a>
                </li>
                <li>
                    <a href="mailto:<?= include_content('/email.php') ?>"
                       target="_blank">
						<?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
							"AREA_FILE_SHOW" => "file",
							"PATH"           => "/include/email.php"
						)) ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
