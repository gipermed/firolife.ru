<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle("Программа лояльности");
$APPLICATION->SetPageProperty('title', 'Firolife | Программа лояльности');
$APPLICATION->SetPageProperty('body-class', 'loyalty');

?>
<main class="main">
    <div class="container">
		<?php /*$APPLICATION->IncludeComponent("bitrix:breadcrumb", "main", array(
            "PATH" => "",
            "SITE_ID" => SITE_ID,
            "START_FROM" => "0"
)); */?>
        <h1 class="section-title"><?php $APPLICATION->ShowTitle(false); ?></h1>
        <div class="page-banner">
            <img src="/local/templates/main/assets/img/loyalty-banner.jpg"
                 srcset="/local/templates/main/assets/img/loyalty-banner@2x.jpg 2x" alt="">
        </div>
        <div class="why">
            <div class="why-title">Что для этого нужно</div>
            <div class="why-body">
                <div class="why-row flex-row">
                    <div class="why-col flex-row-item">
                        <div class="why-item">
                            <div class="why-item-desc">
                                <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                                    "AREA_FILE_SHOW" => "file",
                                    "PATH" => "/include/loyalty/why.php"
                                )) ?>
                            </div>
                        </div>
                    </div>
                    <div class="why-col flex-row-item">
                        <div class="why-item">
                            <div class="why-item-desc">
                                <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                                    "AREA_FILE_SHOW" => "file",
                                    "PATH" => "/include/loyalty/why-desc.php"
                                )) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-text rules-content">
            <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                "AREA_FILE_SHOW" => "file",
                "PATH" => "/include/loyalty/rules.php"
            )) ?>
        </div>
    </div>
</main>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>