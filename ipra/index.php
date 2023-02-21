<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('ИПРА');
$APPLICATION->SetPageProperty('title', 'Gipermed | ИПРА');
$APPLICATION->SetPageProperty('body-class', 'ipra');

?>
<h1 class="section-title ipra-page-title"><?php $APPLICATION->ShowTitle(false); ?></h1>
<div class="ipra-row ipra-row-head flex-row">
    <div class="ipra-col flex-row-item">
        <div class="ipra-head-info">
            <div class="ipra-head-info-icon">
                <img src="<?= SITE_TEMPLATE_PATH ?>/assets/img/product-programm-icon.svg" width="100" alt="">
            </div>
            <div class="ipra-head-info-desc">
                <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => "/include/ipra/text1.php"
                )) ?>
            </div>
        </div>
    </div>
    <div class="ipra-col flex-row-item">
        <div class="info-alert">
            <div class="info-alert-icon">
                <img src="<?= SITE_TEMPLATE_PATH ?>/assets/img/alert-icon.svg" alt="">
            </div>
            <div class="info-alert-body">
                <div class="info-alert-desc">
                    <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => "/include/ipra/text2.php"
                    )) ?>
                </div>
                <a href="https://fss.ru/ru/fund/41108/41110/index.shtml" class="info-alert-link"
                   target="_blank">https://fss.ru/ru/fund/41108/41110/index.shtml</a>
            </div>
        </div>
    </div>
</div>
<div class="why">
    <div class="why-title">Что для этого нужно</div>
    <div class="why-body">
        <div class="why-row flex-row">
            <div class="why-col flex-row-item">
                <div class="why-item">
                    <div class="why-item-title">ПРАВО НА КОМПЕНСАЦИЮ</div>
                    <div class="why-item-desc">
                        <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/ipra/why1.php"
                        )) ?>
                    </div>
                </div>
            </div>
            <div class="why-col flex-row-item">
                <div class="why-item">
                    <div class="why-item-title">ВАШ ЛЕЧАЩИЙ ВРАЧ В ПОЛИКЛИНИКЕ</div>
                    <div class="why-item-desc">
                        <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/ipra/why2.php"
                        )) ?>
                    </div>
                </div>
            </div>
            <div class="why-col flex-row-item">
                <div class="why-item">
                    <div class="why-item-title">ВЫ МОЖЕТЕ КУПИТЬ НУЖНОЕ ТСР САМОСТОЯТЕЛЬНО</div>
                    <div class="why-item-desc">
                        <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/ipra/why3.php"
                        )) ?>
                    </div>
                </div>
            </div>
            <div class="why-col flex-row-item">
                <div class="why-item">
                    <div class="why-item-title">ПОДПИШИТЕ ЗАЯВЛЕНИЕ НА КОМПЕНСАЦИЮ В ФСС</div>
                    <div class="why-item-desc">
                        <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/ipra/why4.php"
                        )) ?>
                    </div>
                </div>
            </div>
            <div class="why-col flex-row-item">
                <div class="why-item">
                    <div class="why-item-title">ПОЛУЧИТЬ КОМПЕНСАЦИЮ</div>
                    <div class="why-item-desc">
                        <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/ipra/why5.php"
                        )) ?>
                    </div>
                </div>
            </div>
            <div class="why-col flex-row-item">
                <div class="why-item">
                    <div class="why-item-title">РАЗМЕР КОМПЕНСАЦИИ</div>
                    <div class="why-item-desc">
                        <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/ipra/why6.php"
                        )) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="ipra-row ipra-docs-row flex-row">
    <div class="ipra-col flex-row-item">
        <div class="ipra-section-title">Пакет документов для предоставления компенсации в ФСС:</div>
        <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
            "AREA_FILE_SHOW" => "file",
            "PATH" => "/include/ipra/docs.php"
        )) ?>
    </div>
    <div class="ipra-col flex-row-item">
        <div class="info-alert">
            <div class="info-alert-icon">
                <img src="<?= SITE_TEMPLATE_PATH ?>/assets/img/alert-icon.svg" alt="">
            </div>
            <div class="info-alert-body">
                <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => "/include/ipra/alert.php"
                )) ?>
            </div>
        </div>
    </div>
</div>
<div class="ipra-products">
    <div class="ipra-section-title">ЗА КАКИЕ ИЗДЕЛИЯ МОЖНО ПОЛУЧИТЬ КОМПЕНСАЦИЮ:</div>
    <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
        "AREA_FILE_SHOW" => "file",
        "PATH" => "/include/ipra/products.php"
    )) ?>
</div>
<div class="section ipra-products-section">
    <div class="container">
        <div class="section-title">Товары из нашего каталога</div>

    </div>
</div>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
