<?php check_prolog();

global $APPLICATION;

?>
    </div> <!-- container-->
</div> <!-- main-->
<footer class="footer">
    <div class="footer-body">
        <div class="container">
            <div class="footer-row flex-row">
                <div class="footer-col footer-col-contacts flex-row-item">
                    <div class="footer-contacts">
                        <div class="footer-social">
                            <div class="footer-title">Гипермед в соцсетях:</div>
                            <ul class="social-list">
                                <li>
                                    <a href="#" aria-label="VK" target="_blank">
                                        <img src="<?= SITE_TEMPLATE_PATH ?>/assets/img/social-vkontakte.svg" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#" aria-label="OK" target="_blank">
                                        <img src="<?= SITE_TEMPLATE_PATH ?>/assets/img/social-ok.svg" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#" aria-label="Facebook" target="_blank">
                                        <img src="<?= SITE_TEMPLATE_PATH ?>/assets/img/social-facebook.svg" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#" aria-label="Instagram" target="_blank">
                                        <img src="<?= SITE_TEMPLATE_PATH ?>/assets/img/social-instagram.svg" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#" aria-label="Twitter" target="_blank">
                                        <img src="<?= SITE_TEMPLATE_PATH ?>/assets/img/social-twitter.svg" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#" aria-label="Youtube" target="_blank">
                                        <img src="<?= SITE_TEMPLATE_PATH ?>/assets/img/social-youtube.svg" alt="">
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <ul class="footer-tels hidden-mobile">
                            <li>
                                <a href="tel:<?= include_content_phone('/phone-tp.php') ?>">
                                    <b>
                                        <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                                            "AREA_FILE_SHOW" => "file",
                                            "PATH" => "/include/phone-tp.php"
                                        )) ?>
                                    </b>
                                    <span>Бесплатный звонок по РФ</span>
                                </a>
                            </li>
                            <li>
                                <a href="tel:<?= include_content_phone('/phone.php') ?>">
                                    <b>
                                        <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                                            "AREA_FILE_SHOW" => "file",
                                            "PATH" => "/include/phone.php"
                                        )) ?>
                                    </b>
                                </a>
                            </li>
                        </ul>
                        <ul class="footer-contacts-links footer-menu hidden-mobile">
                            <li>
                                <a href="mailto:<?= include_content('/email-order.php') ?>" target="_blank">
                                    <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                                        "AREA_FILE_SHOW" => "file",
                                        "PATH" => "/include/email-order.php"
                                    )) ?>
                                </a>
                            </li>
                            <li><a href="#modal-recall" class="modal-open-btn">Заказать звонок</a></li>
                        </ul>
                    </div>
                </div>
                <div class="footer-col footer-col-about flex-row-item">
                    <div class="footer-menu-wrapp">
                        <div class="footer-title">О нас</div>
                        <?php $APPLICATION->IncludeComponent("bitrix:menu", "footer", array(
                            "ROOT_MENU_TYPE" => "footer.about",
                            "MAX_LEVEL" => "1",
                            "CHILD_MENU_TYPE" => "bottom",
                            "USE_EXT" => "N",
                            "ALLOW_MULTI_SELECT" => "N",
                            "MENU_CACHE_TYPE" => "Y",
                            "MENU_CACHE_TIME" => "360000",
                            "MENU_CACHE_USE_GROUPS" => "N",
                            "MENU_CACHE_GET_VARS" => "N",
                        )); ?>
                    </div>
                </div>
                <div class="footer-col footer-col-catalog flex-row-item hidden-tablet">
                    <div class="footer-menu-wrapp">
                        <div class="footer-title">Разделы товаров</div>
                        <?php $APPLICATION->IncludeComponent("bitrix:menu", "footer", array(
                            "ROOT_MENU_TYPE" => "footer.catalog",
                            "MAX_LEVEL" => "1",
                            "CHILD_MENU_TYPE" => "bottom",
                            "USE_EXT" => "N",
                            "ALLOW_MULTI_SELECT" => "N",
                            "MENU_CACHE_TYPE" => "Y",
                            "MENU_CACHE_TIME" => "360000",
                            "MENU_CACHE_USE_GROUPS" => "N",
                            "MENU_CACHE_GET_VARS" => "N",
                        )); ?>
                    </div>
                </div>
                <div class="footer-col footer-col-users flex-row-item">
                    <div class="footer-menu-wrapp">
                        <div class="footer-title">Пользователям</div>
                        <?php $APPLICATION->IncludeComponent("bitrix:menu", "footer", array(
                            "ROOT_MENU_TYPE" => "footer.users",
                            "MAX_LEVEL" => "1",
                            "CHILD_MENU_TYPE" => "bottom",
                            "USE_EXT" => "N",
                            "ALLOW_MULTI_SELECT" => "N",
                            "MENU_CACHE_TYPE" => "Y",
                            "MENU_CACHE_TIME" => "360000",
                            "MENU_CACHE_USE_GROUPS" => "N",
                            "MENU_CACHE_GET_VARS" => "N",
                        )); ?>
                    </div>
                </div>
                <div class="footer-col footer-col-order flex-row-item">
                    <div class="footer-menu-wrapp">
                        <div class="footer-title">Получение и оплата</div>
                        <?php $APPLICATION->IncludeComponent("bitrix:menu", "footer", array(
                            "ROOT_MENU_TYPE" => "footer.order",
                            "MAX_LEVEL" => "1",
                            "CHILD_MENU_TYPE" => "bottom",
                            "USE_EXT" => "N",
                            "ALLOW_MULTI_SELECT" => "N",
                            "MENU_CACHE_TYPE" => "Y",
                            "MENU_CACHE_TIME" => "360000",
                            "MENU_CACHE_USE_GROUPS" => "N",
                            "MENU_CACHE_GET_VARS" => "N",
                        )); ?>
                    </div>
                </div>
                <div class="footer-col footer-col-info flex-row-item">
                    <div class="footer-menu-wrapp">
                        <div class="footer-title">Полезная информация</div>
                        <?php $APPLICATION->IncludeComponent("bitrix:menu", "footer", array(
                            "ROOT_MENU_TYPE" => "footer.info",
                            "MAX_LEVEL" => "1",
                            "CHILD_MENU_TYPE" => "bottom",
                            "USE_EXT" => "N",
                            "ALLOW_MULTI_SELECT" => "N",
                            "MENU_CACHE_TYPE" => "Y",
                            "MENU_CACHE_TIME" => "360000",
                            "MENU_CACHE_USE_GROUPS" => "N",
                            "MENU_CACHE_GET_VARS" => "N",
                        )); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="foot">
        <div class="container">
            <div class="foot-row flex-row">
                <div class="foot-col flex-row-item">
                    <div class="copyright">© <?= date('Y') ?>. ООО «ЦТМТ «Гипермед». Все права защищены.</div>
                </div>
                <div class="foot-col flex-row-item">
                    <a href="#">Политика конфиденциальности</a>
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="scroll-btns">
    <a href="#" class="scroll-btn" data-scroll="top" aria-label="Наверх">
        <svg width="48" height="48">
            <use xlink:href="#icon-arrow-down"/>
        </svg>
    </a>
    <a href="#" class="scroll-btn" data-scroll="bottom" aria-label="Вниз">
        <svg width="48" height="48">
            <use xlink:href="#icon-arrow-down"/>
        </svg>
    </a>
</div>

<?php

$modals = [
    'city',
    'sent',
    'feedback',
    'recall',
];

if (!is_authorized()) {
    $modals = array_merge($modals, [
        'enter',
        'forgot',
        'registration',
        'password-change',
        'password-change-sent',
    ]);
}

foreach ($modals as $modal) {
    $APPLICATION->IncludeComponent("bitrix:main.include", "", [
        "AREA_FILE_SHOW" => "file",
        "PATH" => "/include/modals/{$modal}.php"
    ], false, ['HIDE_ICONS' => 'Y']);
}
?>

</body>
</html>
