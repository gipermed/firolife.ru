<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle("Политика конфиденциальности");
$APPLICATION->SetPageProperty('title', 'Firolife | Политика конфиденциальности');
$APPLICATION->SetPageProperty('body-class', 'privacy-policy');

?>
<main class="main">
    <div class="container">
        <?/*php $APPLICATION->IncludeComponent("bitrix:breadcrumb", "main", array(
            "PATH" => "",
            "SITE_ID" => SITE_ID,
            "START_FROM" => "0"
        )); */?>
        <h1 class="section-title"><?php $APPLICATION->ShowTitle(false); ?></h1>
        <div class="content-text rules-content">
            <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                "AREA_FILE_SHOW" => "file",
                "PATH" => "/include/privacy-policy/content.php"
            )) ?>
        </div>
    </div>
</main>
<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>