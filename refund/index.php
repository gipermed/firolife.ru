<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle("Возврат");
$APPLICATION->SetPageProperty('title', 'Firolife | Возврат');
$APPLICATION->SetPageProperty('body-class', 'refund');

?>
        <h1 class="section-title"><?php $APPLICATION->ShowTitle(false); ?></h1>
        <div class="content-section section">
            <div class="refund-desc">
                <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => "/include/refund/desc1.php"
                )) ?>
            </div>
            <div class="refund-title">
                <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => "/include/refund/title1.php"
                )) ?>
            </div>
            <ul class="info-list">
                <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => "/include/refund/info-list1.php"
                )) ?>
            </ul>
        </div>
        <div class="content-section section">
            <div class="refund-desc">
                <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => "/include/refund/desc2.php"
                )) ?>
            </div>
            <div class="refund-title refund-title-small">
                <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => "/include/refund/title2.php"
                )) ?>
            </div>
            <div class="refund-row flex-row">
                <div class="refund-col flex-row-item">
                    <div class="refund-docs">
                        <ul class="refund-docs-list">
                            <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "/include/refund/refund-docs-list.php"
                            )) ?>
                        </ul>
                    </div>
                </div>
                <div class="refund-col flex-row-item">
                    <div class="info-alert">
                        <div class="info-alert-icon">
                            <img src="/local/templates/main/assets/img/alert-icon.svg" alt="">
                        </div>
                        <div class="info-alert-body">
                            <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "/include/refund/alert1.php"
                            )) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-section section">
            <div class="refund-desc refund-desc-address">
                <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => "/include/refund/desc3.php"
                )) ?>
            </div>
            <div class="refund-row flex-row">
                <div class="refund-col flex-row-item">
                    <ul class="info-list">
                        <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/refund/info-list2.php"
                        )) ?>
                    </ul>
                </div>
                <div class="refund-col flex-row-item">
                    <div class="info-alert">
                        <div class="info-alert-icon">
                            <img src="/local/templates/main/assets/img/alert-icon.svg" alt="">
                        </div>
                        <div class="info-alert-body">
                            <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "/include/refund/alert2.php"
                            )) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="refund-desc">
                <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => "/include/refund/desc4.php"
                )) ?>
            </div>
        </div>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>