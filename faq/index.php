<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle("Вопрос - ответ");
$APPLICATION->SetPageProperty('title', 'Firolife | Вопрос - ответ');
$APPLICATION->SetPageProperty('body-class', 'faq');

?><h1 class="section-title"><?php $APPLICATION->ShowTitle(false); ?></h1>
<div class="faq section">
    <div class="faq-item">
        <a href="#" class="faq-item-toggle">
            <span>
                <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => "/include/faq/item1.php"
                )) ?>
            </span>
            <i>
                <svg width="24" height="24">
                    <use xlink:href="#icon-chevron-down"/>
                </svg>
            </i>
        </a>
        <div class="faq-item-body">
            <div class="faq-item-content content-text">
                <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => "/include/faq/item1-text.php"
                )) ?>
            </div>
        </div>
    </div>
    <div class="faq-item">
        <a href="#" class="faq-item-toggle">
            <span>
                <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => "/include/faq/item2.php"
                )) ?>
            </span>
            <i>
                <svg width="24" height="24">
                    <use xlink:href="#icon-chevron-down"/>
                </svg>
            </i>
        </a>
        <div class="faq-item-body">
            <div class="faq-item-content content-text">
                <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => "/include/faq/item2-text.php"
                )) ?>
            </div>
        </div>
    </div>
</div>
<div class="section content-section">
    <div class="faq-desc">
        <p>Не нашли ответы на свои вопросы и всё ещё нужна помощь?</p>
        <p>
            Обратитесь в службу поддержки по тел.
            <a href="tel:<?= include_content_phone('/phone-tp.php') ?>">
                <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => "/include/phone-tp.php"
                )) ?>
            </a>
            или на почту
            <a href="mailto:<?= include_content('/email-order.php') ?>">
                <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => "/include/email-order.php"
                )) ?>
            </a>.
        </p>
    </div>
</div>
<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>