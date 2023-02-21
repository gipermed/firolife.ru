<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle("Акции");
$APPLICATION->SetPageProperty('title', 'Firolife | Акции');
$APPLICATION->SetPageProperty('body-class', 'promotions');

?>
<main class="main">
    <div class="container">
        <?php $APPLICATION->IncludeComponent("bitrix:breadcrumb", "main", array(
            "PATH" => "",
            "SITE_ID" => SITE_ID,
            "START_FROM" => "0"
        )); ?>
        <h1 class="section-title"><?php $APPLICATION->ShowTitle(false); ?></h1>
    </div>

</main>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>