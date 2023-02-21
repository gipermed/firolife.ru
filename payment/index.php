<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle("Оплата и доставка");
$APPLICATION->SetPageProperty('title', 'Firolife | Оплата и доставка');
$APPLICATION->SetPageProperty('body-class', 'payment');

?><h1 class="section-title"><?php $APPLICATION->ShowTitle(false); ?></h1>
<div class="page-banner">
    <img src="/local/templates/main/assets/img/payment-banner.jpg"
         srcset="/local/templates/main/assets/img/payment-banner@2x.jpg 2x" alt="">
</div>
<div class="content-section section" id="pay">
    <div class="content-title">Оплата заказа</div>
    <div class="payment-title">
        <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
            "AREA_FILE_SHOW" => "file",
            "PATH" => "/include/payment/payment-title.php"
        )) ?>
    </div>
    <div class="payment-info">
        <div class="payment-row flex-row">
            <div class="payment-col flex-row-item">
                <div class="payment-info-title">
                    <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => "/include/payment/payment-info-title1.php"
                    )) ?>
                </div>
                <ul class="info-list">
                    <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => "/include/payment/payment-info-list1.php"
                    )) ?>
                </ul>
            </div>
            <div class="payment-col flex-row-item">
                <div class="payment-info-title">
                    <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => "/include/payment/payment-info-title2.php"
                    )) ?>
                </div>
                <ul class="info-list">
                    <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => "/include/payment/payment-info-list2.php"
                    )) ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="payment-methods">
        <div class="payment-methods-title">
            <img src="/local/templates/main/assets/img/payment-methods-icon.svg" alt="">
            <span>Безопасная оплата:</span>
        </div>
        <div class="payment-methods-body">
            <ul class="payment-methods-logos">
                <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => "/include/payment/payment-methods-logos.php"
                )) ?>
            </ul>
        </div>
    </div>
</div>
<div class="content-section section" id="#delivery">
    <div class="content-title">Доставка</div>
    <div class="payment-title">Способы доставки:</div>
    <div class="delivery">
        <div class="delivery-row flex-row">
            <div class="delivery-col flex-row-item">
                <div class="delivery-item">
                    <div class="delivery-item-title">
                        <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/payment/delivery-item-info-title1.php"
                        )) ?>
                    </div>
                    <div class="delivery-item-body">
                        <div class="delivery-item-info delivery-item-shops">
                            <div class="delivery-shops">
                                <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                                    "AREA_FILE_SHOW" => "file",
                                    "PATH" => "/include/payment/delivery-shops.php"
                                )) ?>
                            </div>
                            <div class="delivery-item-info-icon">
                                <img src="/local/templates/main/assets/img/shop-icon.svg" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="delivery-col flex-row-item">
                <div class="delivery-item">
                    <div class="delivery-item-title">
                        <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/payment/delivery-item-info-title2.php"
                        )) ?>
                    </div>
                    <div class="delivery-item-body">
                        <div class="delivery-item-row flex-row">
                            <div class="delivery-item-col flex-row-item">
                                <div class="delivery-item-info">
                                    <div class="delivery-item-info-body">
                                        <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                                            "AREA_FILE_SHOW" => "file",
                                            "PATH" => "/include/payment/delivery-item-info-body1.php"
                                        )) ?>
                                    </div>
                                    <div class="delivery-item-info-icon">
                                        <img src="/local/templates/main/assets/img/delivery-icon-1.svg" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="delivery-item-col flex-row-item">
                                <div class="delivery-item-info">
                                    <div class="delivery-item-info-body">
                                        <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                                            "AREA_FILE_SHOW" => "file",
                                            "PATH" => "/include/payment/delivery-item-info-body2.php"
                                        )) ?>
                                    </div>
                                    <div class="delivery-item-info-icon">
                                        <img src="/local/templates/main/assets/img/delivery-icon-2.svg" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="delivery-item-info-desc">
                            <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "/include/payment/delivery-item-info-desc1.php"
                            )) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="delivery-col flex-row-item">
                <div class="delivery-item">
                    <div class="delivery-item-title">
                        <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/payment/delivery-item-info-title3.php"
                        )) ?>
                    </div>
                    <div class="delivery-item-body">
                        <div class="delivery-item-info">
                            <div class="delivery-item-info-body">
                                <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                                    "AREA_FILE_SHOW" => "file",
                                    "PATH" => "/include/payment/delivery-item-info-body3.php"
                                )) ?>
                            </div>
                            <div class="delivery-item-info-icon">
                                <img src="/local/templates/main/assets/img/delivery-icon-3.svg" alt="">
                            </div>
                        </div>
                        <div class="delivery-item-info-desc">
                            <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "/include/payment/delivery-item-info-desc2.php"
                            )) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="delivery-col flex-row-item">
                <div class="delivery-item">
                    <div class="delivery-item-title">
                        <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/payment/delivery-item-info-title4.php"
                        )) ?>
                    </div>
                    <div class="delivery-item-body">
                        <div class="delivery-item-info">
                            <div class="delivery-item-info-body">
                                <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                                    "AREA_FILE_SHOW" => "file",
                                    "PATH" => "/include/payment/delivery-item-info-body4.php"
                                )) ?>
                            </div>
                            <div class="delivery-item-info-icon">
                                <img src="/local/templates/main/assets/img/delivery-icon-4.svg" alt="">
                            </div>
                        </div>
                        <div class="delivery-item-info-desc">
                            <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "/include/payment/delivery-item-info-desc3.php"
                            )) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="delivery-desc">
        <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
            "AREA_FILE_SHOW" => "file",
            "PATH" => "/include/payment/delivery-desc.php"
        )) ?>
    </div>
</div>
<div class="content-section section">
    <div class="payment-title">
        <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
            "AREA_FILE_SHOW" => "file",
            "PATH" => "/include/payment/delivery-courier-title.php"
        )) ?>
    </div>
    <ul class="info-list">
        <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
            "AREA_FILE_SHOW" => "file",
            "PATH" => "/include/payment/delivery-courier-list.php"
        )) ?>
    </ul>
</div>
<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>