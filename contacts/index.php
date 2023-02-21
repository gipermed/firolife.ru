<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle("Контакты");
$APPLICATION->SetPageProperty('title', 'Firolife | Контакты');
$APPLICATION->SetPageProperty('body-class', 'contacts');

?><h1 class="section-title"><?php $APPLICATION->ShowTitle(false); ?></h1>
<div class="contacts-section section">
    <div class="content-title">Интернет - магазин</div>
    <div class="contacts-internet">
        <div class="contacts-internet-block contacts-internet-tels">
            <div class="contacts-internet-tels-title">Телефон:</div>
            <ul class="contacts-tels">
                <li>
                    <a href="tel:<?= include_content_phone('/phone.php') ?>">
                        <b>
                            <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "/include/phone.php"
                            )) ?>
                        </b>
                        <span>Для Москвы</span>
                    </a>
                </li>
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
            </ul>
        </div>
        <div class="contacts-internet-block">
            <div class="contacts-internet-title">Приём звонков:</div>
            <div class="contacts-internet-desc">
                <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => "/include/contacts/work-time.php"
                )) ?>
            </div>
        </div>
        <div class="contacts-internet-block">
            <div class="contacts-internet-title">Заказы принимаются круглосуточно</div>
        </div>
    </div>
    <div class="contacts-internet-info">*Часы работы указаны по московскому времени.</div>
</div>

<?php $APPLICATION->IncludeComponent("bitrix:news.list", "shops", array(
        "IBLOCK_TYPE" => "lists",
        "IBLOCK_ID" => IBLOCK_SHOPS_ID,
        "NEWS_COUNT" => "999",
        "SORT_BY1" => "SORT",
        "SORT_ORDER1" => "ASC",
        "SORT_BY2" => "ACTIVE_FROM",
        "SORT_ORDER2" => "DESC",
        "FILTER_NAME" => "",
        "FIELD_CODE" => array("NAME", "PREVIEW_PICTURE", ""),
        "PROPERTY_CODE" => array("PHONE", "WORK_TIME", "ADDRESS", "METRO", "METRO_COLOR", "GALLERY", "LONGITUDE", "LATITUDE", ""),
        "CHECK_DATES" => "Y",
        "SET_TITLE" => "N",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "INCLUDE_SUBSECTIONS" => "Y",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "3600",
    )
); ?>

<div class="contacts-section section">
    <div class="contacts-map-title">Магазины на карте</div>
    <div class="contacts-map-wrapp">
        <div class="contacts-map" data-lat="55.755819" data-lng="37.617644" data-zoom="11"
             data-zoom-mobile="9"></div>
    </div>
</div>
<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>