<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404", "Y");
@define("HIDE_SIDEBAR", true);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle("Страница не найдена");
$APPLICATION->SetPageProperty('body-class', 'error');

$APPLICATION->AddChainItem('404');

?>

<main class="main">
    <div class="container">
        <?php $APPLICATION->IncludeComponent("bitrix:breadcrumb", "main", array(
            "PATH" => "",
            "SITE_ID" => SITE_ID,
            "START_FROM" => "0"
        )); ?>
        <div class="empty-info page-404">
            <div class="page-404-icon">
                <img src="<?= SITE_TEMPLATE_PATH ?>/assets/img/404-icon.svg" alt="">
            </div>
            <div class="page-404-body">
                <h1 class="page-404-title">404</h1>
                <div class="page-404-title-desc">страница не найдена</div>
                <div class="page-404-desc">страницу, на которую вы пытаетесь попасть, не существует или удалена.
                </div>
                <div class="page-404-btn-wrapp">
                    <a href="/" class="page-404-btn btn btn-full btn-green">Перейти на главную.</a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
