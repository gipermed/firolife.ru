<?php check_prolog();

use Bitrix\Main\Context;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Web\Cookie;
use Palladiumlab\Management\User;
use Palladiumlab\Support\Bitrix\Sale\BasketManager;
use Bitrix\Highloadblock\HighloadBlockTable as HLBT;

global $APPLICATION;

$context = Context::getCurrent();
$request = $context->getRequest();

Loc::loadMessages(__FILE__);

$basketManager = BasketManager::createFromCurrent();

if ($request->get('basket-clear') === 'y') {
    $basketManager->clear();
    LocalRedirect($APPLICATION->GetCurPage());
}

if ($request->get('cookie-submit') === 'y') {
    $context
        ->getResponse()
        ->addCookie(new Cookie(
            'cookie-submit',
            'Y',
            time() + 60 * 60 * 24 * 30 * 12 * 5
        ))
        ->writeHeaders();
    LocalRedirect($APPLICATION->GetCurPage());
}

$basketManager->clearUnavailable();

//$user = User::current();
global $USER;
//$user = $USER;

?>
<!DOCTYPE html>
<html lang="<?= LANGUAGE_ID ?>">
<head>

<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();
   for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
   k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(88863090, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true,
        ecommerce:"dataLayer"
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/88863090" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<meta name="yandex-verification" content="9bfb30b5d778d1ba" />

    
    <title><?php $APPLICATION->ShowTitle() ?></title>

    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link rel="icon" type="image/x-icon" href="/favicon.ico"/>
    <?php
    $GLOBALS["PAGE"] = explode("/", $APPLICATION->GetCurPage());
    $asset = asset();

    $arCss = [
        SITE_TEMPLATE_PATH . 'assets/css/vendor/swiper-bundle.min.css',
        SITE_TEMPLATE_PATH . 'assets/css/vendor/jquery.fancybox.min.css',
        SITE_TEMPLATE_PATH . 'assets/css/vendor/jquery.ui.slider.css',
        SITE_TEMPLATE_PATH . 'assets/css/vendor/jquery-ui.min.css',
        SITE_TEMPLATE_PATH . 'assets/select/select2.min.css',
        SITE_TEMPLATE_PATH . 'assets/css/styles.css',
		//SITE_TEMPLATE_PATH . '/assets/css/jquery.fias.min.css',
    ];

    foreach ($arCss as $css) {
        $asset->addCss($css);
    }

    $arJs = [
        SITE_TEMPLATE_PATH . 'assets/js/vendor/jquery-3.6.0.min.js',
        SITE_TEMPLATE_PATH . 'assets/js/vendor/swiper-bundle.min.js',
        SITE_TEMPLATE_PATH . 'assets/js/vendor/jquery.fancybox.min.js',
        SITE_TEMPLATE_PATH . 'assets/js/vendor/jquery.ui.slider.js',
//        SITE_TEMPLATE_PATH . 'assets/js/vendor/jquery.form.min.js',
        SITE_TEMPLATE_PATH . 'assets/js/vendor/jquery-ui.min.js',
//        SITE_TEMPLATE_PATH . 'assets/js/inputmask-robin.min.js',
        SITE_TEMPLATE_PATH . 'assets/js/jquery.sticky-kit.js',
        SITE_TEMPLATE_PATH . 'assets/select/select2.full.min.js',
		'/local/components/prymery/feedback.form/js/inputmask-robin.min.js',
		'/local/components/prymery/feedback.form/js/jquery.form.min.js',
		'/local/components/prymery/feedback.form/js/prForm.js',

        SITE_TEMPLATE_PATH . 'assets/js/scripts.js',
        SITE_TEMPLATE_PATH . 'assets/build/app.js',
    ];
	\Bitrix\Main\UI\Extension::load("ui.bootstrap4");
    foreach ($arJs as $js) {
        $asset->addJs($js);
    }
    $APPLICATION->AddHeadString('<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;700;800&display=swap" rel="stylesheet">');
    $APPLICATION->ShowHead();
    ?>

    <?/*link href="/local/templates/main/assets/select/select2.min.css" type="text/css" rel="stylesheet"/>
    <script type="text/javascript" src="/local/templates/main/assets/select/select2.full.min.js"></script*/?>
</head>
<body class="page-<?php $APPLICATION->ShowProperty('body-class'); ?>">
<?php
function getGroupsByLocation($locationId)
{
    $res = \Bitrix\Sale\Location\LocationTable::getList([
        'filter' => ['=ID' => $locationId,'NAME.LANGUAGE_ID' => LANGUAGE_ID],
        'select' => ['ID', 'CODE','LEFT_MARGIN', 'RIGHT_MARGIN','LOCATION_NAME' => 'NAME.NAME']
    ]);

    if(!$loc = $res->fetch())
    { return [];}

    $arLocs = CSaleLocation::GetLocationZIP($locationId);
    $arLocs = $arLocs->Fetch();

    $locations[0] = $loc['CODE'];
    $locations[1] = $arLocs['ZIP'];
    $locations[2] = $loc['LOCATION_NAME'];

    $res = \Bitrix\Sale\Location\LocationTable::getList([
        'filter' => [
            '<LEFT_MARGIN' => $loc['LEFT_MARGIN'],
            '>RIGHT_MARGIN' => $loc['RIGHT_MARGIN'],
            'NAME.LANGUAGE_ID' => LANGUAGE_ID],
        'select' => ['LOCATION_NAME' => 'NAME.NAME'],
    ]);

    while($locParent = $res->fetch())
    {
        $locations[] = $locParent['LOCATION_NAME'];
    }
    $locations = array_diff($locations, ["Россия"]);
    //  $locations = implode(",", $locations);
    return $locations;
}
$cookieWishList = $APPLICATION->get_cookie('wishlist');
if($cookieWishList && $USER->IsAuthorized()){
    $cookieWishList = str_replace(array('[',']'), '', $cookieWishList);
    $cookieWishList = explode(',',$cookieWishList);
    if($cookieWishList){
        foreach($cookieWishList as $item){
            $cookieWishListFull[$item] = $item;
        }
    }
    CModule::IncludeModule('highloadblock');
    $hl_block = HLBT::getById(2)->fetch();

    $entity = HLBT::compileEntity($hl_block);
    $entity_data_class = $entity->getDataClass();

    $rs_data = $entity_data_class::getList(array(
        'filter' => array('UF_USER'=>$USER->GetId()),
        'select' => array('*')
    ));
    while ($el = $rs_data->fetch()){
        $allWishList[$el['UF_PRODUCT']] = $el['UF_PRODUCT'];
    }
    foreach($cookieWishListFull as $item){
        if(!$allWishList[$item]){
            $addWishList[] = $item;
        }
    }
    if($addWishList){
        foreach($addWishList as $id){
            $result = $entity_data_class::add(array(
                'UF_PRODUCT' => $id,
                'UF_USER' => $USER->GetId(),
            ));
        }
    }
}
?>


<?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
    "AREA_FILE_SHOW" => "file",
    "PATH" => "/include/sprite.php"
), false, ['HIDE_ICONS' => 'Y']) ?>

<?php if (!$request->getCookie('cookie-submit')) { ?>
    <div class="cookie">
        <div class="container">
            <div class="cookie-info">
                <p>Наш сайт использует cookie для того, чтобы обеспечить максимальное удобство пользователям.</p>
                <p>Продолжая просматривать наш сайт, вы соглашаетесь с использованием cookie.</p>
            </div>
            <ul class="cookie-links">
                <li>
                    <a href="?cookie-submit=y" class="btn submit btn-green cookie-submit">
                        Согласиться
                    </a>
                </li>
                <li><a href="/privacy-policy/">Подробнее</a></li>
            </ul>
        </div>
    </div>
<?php } ?>

<div id="panel"><?php $APPLICATION->ShowPanel() ?></div>

<header class="header">
    <div class="header-alert">
        <!--<div class="container">
            <div class="header-alert-text">
                Для приобретения товаров по счету <span class="hidden-mobile">(юридические лица)</span>
                перейдите на сайт <a href="https://gipermed.ru/" target="_blank">www.gipermed.ru</a>
            </div>
            <a href="https://gipermed.ru/" class="header-alert-link" target="_blank">Перейти ></a>
        </div>

<div class="container">
            <div class="header-alert-text">
                Вернуться на старую версию сайта <a href="https://gipermed.com/" target="_blank">gipermed.com</a>
            </div>
            <a href="https://gipermed.com/" class="header-alert-link" target="_blank">Перейти ></a>
        </div>-->

    </div>
    <div class="head">
        <div class="container">
            <div class="head-row flex-row">
                <div class="head-col head-col-city flex-row-item">
                    <?/*a href="#modal-city" class="head-city-link modal-open-btn">
                        <svg width="24" height="24">
                            <use xlink:href="#icon-cursor"/>
                        </svg>
                        <span><span class="hidden-desktop">Ваш регион доставки:</span> <b><span class="user-region" > </span></b></span>
                    </a*/?>
                    <?/* $APPLICATION->IncludeComponent(
                        "prymery:geoip.city",
                        ".default",
                        array(
                            "COMPONENT_TEMPLATE" => ".default",
                            "CITY_SHOW" => "Y",
                            "CITY_LABEL" => "Ваш регион доставки:",
                            "QUESTION_SHOW" => "Y",
                            "QUESTION_TEXT" => "Ваш город<br/>#CITY#<span>?</span>",
                            "INFO_SHOW" => "N",
                            "INFO_TEXT" => "<a href=\"#\" rel=\"nofollow\" target=\"_blank\">Подробнее о доставке</a>",
                            "BTN_EDIT" => "Изменить город",
                            "SEARCH_SHOW" => "Y",
                            "FAVORITE_SHOW" => "Y",
                            "CITY_COUNT" => "30",
                            "FID" => "1",
                            "CACHE_TYPE" => "A",
                            "CACHE_TIME" => "3600",
                            "COMPOSITE_FRAME_MODE" => "A",
                            "COMPOSITE_FRAME_TYPE" => "AUTO",
                            "POPUP_LABEL" => "Выберите ваш город",
                            "INPUT_LABEL" => "Начните вводить название",
                            "MSG_EMPTY_RESULT" => "Ничего не найдено",
                            "RELOAD_PAGE" => "N",
                            "ENABLE_JQUERY" => "Y",
                            "REDIRECT_WAIT_CONFIRM" => "N"
                        ),
                        $component
                    ); */?>
					<?
                    $QUESTION_SHOW = 'Y';
                    if($_COOKIE['bxmaker_geoip_2_8_1_d_location']){
                        $QUESTION_SHOW = 'N';
                    }
                    $APPLICATION->IncludeComponent(
                        "bxmaker:geoip.city",
                        ".default",
                        array(
                            "COMPONENT_TEMPLATE" => ".default",
                            "CITY_SHOW" => "Y",
                            "CITY_LABEL" => "Ваш город:",
                            "QUESTION_SHOW" => $QUESTION_SHOW,
                            "QUESTION_TEXT" => "Ваш город<br/>#CITY#?",
                            "INFO_SHOW" => "N",
                            "INFO_TEXT" => "<a href=\"#\" rel=\"nofollow\" target=\"_blank\">Подробнее о доставке</a>",
                            "BTN_EDIT" => "Изменить город",
                            "SEARCH_SHOW" => "Y",
                            "FAVORITE_SHOW" => "Y",
                            "CITY_COUNT" => "30",
                            "FID" => "1",
                            "CACHE_TYPE" => "A",
                            "CACHE_TIME" => "3600",
                            "COMPOSITE_FRAME_MODE" => "A",
                            "COMPOSITE_FRAME_TYPE" => "AUTO",
                            "POPUP_LABEL" => "Выберите ваш город",
                            "INPUT_LABEL" => "Начните вводить название",
                            "MSG_EMPTY_RESULT" => "Ничего не найдено",
                            "RELOAD_PAGE" => "N",
                            "ENABLE_JQUERY" => "N",
                            "REDIRECT_WAIT_CONFIRM" => "N"
                        ),
                        false
                    ); ?>
                </div>
                <div class="head-col head-col-menu flex-row-item">
                    <?php $APPLICATION->IncludeComponent("bitrix:menu", "header", array(
                        "ROOT_MENU_TYPE" => "header",
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
                <div class="head-col head-col-cabinet flex-row-item">
                    <?php if ($USER && is_authorized()) { ?>
                        <div class="header-cabinet">
                            <a href="#" class="header-cabinet-link">
                                <svg width="24" height="24">
                                    <use xlink:href="#icon-person"/>
                                </svg>
                                <span><?= $USER->GetLogin() ?></span>
                            </a>
                            <nav class="header-cabinet-nav hidden-tablet">
                                <a href="#" class="header-cabinet-name"><?= $USER->GetFullName() ?></a>
                                <?$APPLICATION->IncludeComponent("bitrix:menu", "header.cabinet", array(
									"ROOT_MENU_TYPE"        => "headercabinet",
									"MAX_LEVEL"             => "1",
									"CHILD_MENU_TYPE"       => "bottom",
									"USE_EXT"               => "N",
									"ALLOW_MULTI_SELECT"    => "N",
									"MENU_CACHE_TYPE"       => "Y",
									"MENU_CACHE_TIME"       => "360000",
									"MENU_CACHE_USE_GROUPS" => "N",
									"MENU_CACHE_GET_VARS"   => "N",
								)); ?>

                                <a href="?logout=yes&<?= bitrix_sessid_get() ?>" class="header-cabinet-exit">Выход</a>
                                <?if ($_GET['logout'] === 'y') { LocalRedirect('/');}?>
                            </nav>
                        </div>
                    <?php } else { ?>
                        <ul class="head-cabinet-links">
                            <li>
                                <a href="#modal-enter" class="modal-open-btn">
                                    Регистрация
                                </a>
                            </li>
                            <li>
                                <a href="#modal-enter" class="modal-open-btn">
                                    Вход
                                </a>
                            </li>
                        </ul>
                    <?php } ?>
                </div>

            </div>
        </div>
    </div>

    <div class="header-body">
        <div class="container">
            <div class="header-row flex-row">
                <div class="header-col header-col-nav-open flex-row-item">
                    <a href="#" class="header-nav-open" aria-label="Меню"></a>
                </div>
                <div class="header-col header-col-logo flex-row-item">
                    <a href="/" class="logo" aria-label="На Главную страницу сайта">
                        <img src="<?= SITE_TEMPLATE_PATH ?>/assets/img/logo_new.svg" alt="">
                    </a>
                </div>
                <div class="header-col header-col-phones flex-row-item">
                    <div class="header-phones">
                        <svg class="icon icon:header-phones"><use xlink:href="#icon-phone"></use></svg>
                        <?/*php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/phone.php"
                        )) */?>
                        <a href="tel:84951183406"><strong>8 495 118-34-06</strong> Для Москвы</a>
                        <a href="tel:88003014406"><strong>8 800 301-44-06</strong> Бесплатный звонок по РФ</a>
                    </div>
                </div>

                <?/*div class="header-col header-col-contacts flex-row-item">
                    <div class="header-contacts">
                        <a href="#" class="header-contacts-open" aria-label="Открыть контакты">
                            <svg width="24" height="24">
                                <use xlink:href="#icon-phone"/>
                            </svg>
                            <span>
                                <?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                                    "AREA_FILE_SHOW" => "file",
                                    "PATH" => "/include/phone.php"
                                )) ?>
                            </span>
                            <i>
                                <svg width="24" height="24">
                                    <use xlink:href="#icon-chevron-down"/>
                                </svg>
                            </i>
                        </a>
                        <div class="header-contacts-body">
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
                            <ul class="header-contacts-links">
                                <li>
                                    <a data-fancybox="" data-type="ajax" data-touch="false" data-src="/local/ajax/form/feedback.php?ajax=y" href="javascript:void(0)">
                                        <svg width="16" height="16">
                                            <use xlink:href="#icon-email"/>
                                        </svg>
                                        <span>Связаться с нами</span>
                                    </a>
                                </li>
                                <li>
                                    <a data-fancybox="" data-type="ajax" data-touch="false" data-src="/local/ajax/form/recall.php?ajax=y" href="javascript:void(0)">
                                        <svg width="16" height="16">
                                            <use xlink:href="#icon-call-back"/>
                                        </svg>
                                        <span>Заказать звонок</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div*/?>
                <div class="header-col header-col-search flex-row-item">
                    <?$APPLICATION->IncludeComponent(
	"bitrix:search.title",
	"header",
	array(
		"SHOW_INPUT" => "Y",
		"INPUT_ID" => "title-search-input",
		"CONTAINER_ID" => "title-search",
		"PRICE_CODE" => array(
			0 => "BASE",
			1 => "RETAIL",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "150",
		"SHOW_PREVIEW" => "Y",
		"PREVIEW_WIDTH" => "75",
		"PREVIEW_HEIGHT" => "75",
		"CONVERT_CURRENCY" => "Y",
		"CURRENCY_ID" => "RUB",
		"PAGE" => "#SITE_DIR#catalog/search.php",
		"NUM_CATEGORIES" => "1",
		"TOP_COUNT" => "10",
		"ORDER" => "date",
		"USE_LANGUAGE_GUESS" => "Y",
		"CHECK_DATES" => "N",
		"SHOW_OTHERS" => "N",
		"CATEGORY_0_TITLE" => "Каталог",
		"CATEGORY_0" => array(
			0 => "iblock_1c_catalog",
		),
		"CATEGORY_0_iblock_news" => array(
			0 => "all",
		),
		"CATEGORY_1_TITLE" => "Форумы",
		"CATEGORY_1" => array(
			0 => "forum",
		),
		"CATEGORY_1_forum" => array(
			0 => "all",
		),
		"CATEGORY_2_TITLE" => "Каталоги",
		"CATEGORY_2" => array(
			0 => "iblock_books",
		),
		"CATEGORY_2_iblock_books" => "all",
		"CATEGORY_OTHERS_TITLE" => "Прочее",
		"COMPONENT_TEMPLATE" => "header",
		"CATEGORY_0_iblock_1c_catalog" => array(
			0 => "98",
		)
	),
	false
);?>
                </div>
                <div class="header-col header-col-links flex-row-item">
                    <ul class="header-links">
                        <li class="header-links__item hidden-lg">
                            <a href="tel:88003014406" aria-label="Позвонить">
                                <svg width="24" height="24">
                                    <use xlink:href="#icon-phone"/>
                                </svg>
                            </a>
                        </li>
                        <li class="header-links__item hidden-lg" aria-label="Кабинет">
                            <a<?if($USER->IsAuthorized()):?> href="/personal/profile/"<?else:?> href="#modal-enter" class="modal-open-btn"<?endif;?>>
                                <svg width="24"
                                     height="24">
                                    <use xlink:href="#icon-person"/>
                                </svg>
                            </a>
                        </li>
                        <li class="header-links__item hidden-mobile">
                            <a data-fancybox="" data-type="ajax" data-touch="false" data-src="/local/ajax/form/feedback.php?ajax=y" href="javascript:void(0)">
                                <svg width="24" height="24">
                                    <use xlink:href="#icon-email"/>
                                </svg>
                                <span>Связаться с нами</span>
                            </a>
                        </li>
                        <?
                        use Bitrix\Catalog\PriceTable;
                        use Bitrix\Main\Loader;
                        use Palladiumlab\Catalog\CatalogProducts;
                        use Palladiumlab\Catalog\Wishlist;
                        use Palladiumlab\Price\PriceProduct;
                        $wishList = new Wishlist();
                        $cat = new CatalogProducts();
                        $favElements = $cat->get($wishList->state());
                        ?>
                        <?php if ($USER->IsAuthorized() && is_authorized()) { ?>
                            <li class="header-links__item">
                                <a href="/personal/catalog/fav.php"
                                   class="header-favorites<?if($favElements):?> active<?endif;?>">
                                    <svg width="24"
                                         height="24">
                                        <use xlink:href="#icon-like"/>
                                    </svg>
                                    <span class="hidden-mobile">Избранное</span>
                                </a>
                            </li>
                        <?}else{?>
                            <li class="header-links__item hidden-mobile"></li>
                        <?php }?>
                        <li class="header-links__item hidden-mobile">
                            <a data-fancybox="" data-type="ajax" data-touch="false" data-src="/local/ajax/form/recall.php?ajax=y" href="javascript:void(0)">
                                <svg width="24" height="24">
                                    <use xlink:href="#icon-call-back"/>
                                </svg>
                                <span>Заказать звонок</span>
                            </a>
                        </li>
                        <li class="header-links__item">
                            <a href="/cart/" class="header-cart active">
                                <svg width="24" height="24">
                                    <use xlink:href="#icon-basket"/>
                                </svg>
                                <span class="hidden-mobile">Корзина</span>
                                <span class="header-cart-count"><?= $basketManager->getQuantity() ?></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <nav class="header-nav">
        <div class="header-alert">
            <div class="container">
                <div class="header-alert-text">Для приобретения товаров по счету <span class="hidden-mobile">(юридические лица)</span>
                    перейдите на сайт <a href="https://gipermed.ru/" target="_blank">www.gipermed.ru</a></div>
                <a href="https://gipermed.ru/" class="header-alert-link" target="_blank">Перейти ></a>
            </div>
        </div>
        <div class="header-nav-head visible-tablet">
            <div class="container">
                <a href="#" class="header-nav-close" aria-label="Закрыть">
                    <svg width="24" height="24">
                        <use xlink:href="#icon-close"/>
                    </svg>
                </a>
                <?global $USER;
                if(!$USER->IsAuthorized()):?>
                    <ul class="head-cabinet-links">
                        <li>
                            <a href="#modal-enter" class="modal-open-btn">
                                Регистрация
                            </a>
                        </li>
                        <li>
                            <a href="#modal-enter" class="modal-open-btn">
                                Вход
                            </a>
                        </li>
                    </ul>
                <?endif;?>
            </div>
        </div>

        <?  $APPLICATION->IncludeComponent(
	"bitrix:menu",
	"catalog",
	array(
		"ROOT_MENU_TYPE" => "catalog",
		"MAX_LEVEL" => "4",
		"CHILD_MENU_TYPE" => "catalog",
		"USE_EXT" => "Y",
		"ALLOW_MULTI_SELECT" => "N",
		"MENU_CACHE_TYPE" => "Y",
		"MENU_CACHE_TIME" => "360000",
		"MENU_CACHE_USE_GROUPS" => "N",
		"MENU_CACHE_GET_VARS" => array(
			0 => "N",
			1 => "",
		),
		"COMPONENT_TEMPLATE" => "catalog",
		"DELAY" => "N"
	),
	false
); ?>

        <div class="header-catalog">
            <div class="container">

            </div>
        </div>
        <div class="header-nav-mobile visible-tablet">
            <div class="container">
                <div class="header-nav-mobile-menus">
                    <ul class="header-nav-mobile-menu">
                        <li>
                            <a href="/sales/">
                                <i>
                                    <svg width="24" height="24">
                                        <use xlink:href="#icon-discount"/>
                                    </svg>
                                </i>
                                <span>Акции</span>
                            </a>
                        </li>
                        <li>
                            <a<?if($USER->IsAuthorized()):?> href="/personal/orders/"<?else:?> href="#modal-enter" class="modal-open-btn"<?endif;?>>
                                <i>
                                    <svg width="24" height="24">
                                        <use xlink:href="#icon-bag"/>
                                    </svg>
                                </i>
                                <span>Мои заказы</span>
                            </a>
                        </li>
                        <li>
                            <a href="/personal/catalog/fav.php">
                                <i>
                                    <svg width="24" height="24">
                                        <use xlink:href="#icon-like"/>
                                    </svg>
                                </i>
                                <span>Избранное</span>
                            </a>
                        </li>
                        <?/*li>
                            <? $APPLICATION->IncludeComponent( "prymery:geoip.city",
                                "mobile",
                                array(
                                    "COMPONENT_TEMPLATE" => ".default",
                                    "CITY_SHOW" => "Y",
                                    "CITY_LABEL" => "Город:",
                                    "QUESTION_SHOW" => "N",
                                    "QUESTION_TEXT" => "Ваш город<br/>#CITY#?",
                                    "INFO_SHOW" => "N",
                                    "INFO_TEXT" => "<a href=\"#\" rel=\"nofollow\" target=\"_blank\">Подробнее о доставке</a>",
                                    "BTN_EDIT" => "Изменить город",
                                    "SEARCH_SHOW" => "Y",
                                    "FAVORITE_SHOW" => "Y",
                                    "CITY_COUNT" => "30",
                                    "FID" => "1",
                                    "CACHE_TYPE" => "A",
                                    "CACHE_TIME" => "3600",
                                    "COMPOSITE_FRAME_MODE" => "A",
                                    "COMPOSITE_FRAME_TYPE" => "AUTO",
                                    "POPUP_LABEL" => "Выберите ваш город",
                                    "INPUT_LABEL" => "Начните вводить название",
                                    "MSG_EMPTY_RESULT" => "Ничего не найдено"
                                ),
                                $component
                            ); ?>
                        </li*/?>
                        <li>
                            <a href="/contacts/">
                                <i>
                                    <svg width="24" height="24">
                                        <use xlink:href="#icon-map"/>
                                    </svg>
                                </i>
                                <span>Адреса магазинов</span>
                            </a>
                        </li>
                    </ul>
                    <?/*ul class="header-nav-mobile-menu">
                        <li>
                            <a href="#">
                                <i>
                                    <svg width="24" height="24">
                                        <use xlink:href="#icon-discount"/>
                                    </svg>
                                </i>
                                <span>Акции</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i>
                                    <svg width="24" height="24">
                                        <use xlink:href="#icon-bag"/>
                                    </svg>
                                </i>
                                <span>Мои заказы</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i>
                                    <svg width="24" height="24">
                                        <use xlink:href="#icon-like"/>
                                    </svg>
                                </i>
                                <span>Избранное</span>
                            </a>
                        </li>
                        <li>
                            <a href="#modal-city" class="modal-open-btn">
                                <i>
                                    <svg width="24" height="24">
                                        <use xlink:href="#icon-location"/>
                                    </svg>
                                </i>
                                <span>Город: Москва</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i>
                                    <svg width="24" height="24">
                                        <use xlink:href="#icon-map"/>
                                    </svg>
                                </i>
                                <span>Адреса магазинов</span>
                            </a>
                        </li>
                    </ul*/?>
                </div>
                <div class="header-nav-mobile-menus">
                    <a href="#" class="header-nav-mobile-about-toggle">
                        <span>О нас</span>
                        <i>
                            <svg width="24" height="24">
                                <use xlink:href="#icon-chevron-down"/>
                            </svg>
                        </i>
                    </a>
                    <ul class="header-nav-mobile-about-menu">
                        <li><a href="/about/">О компании</a></li>
                        <?/*li><a href="#">Миссия</a></li>
                        <li><a href="#">Вакансии</a></li*/?>
                        <li><a href="/contacts/">Контакты</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
<div class="main">
    <?if($GLOBALS["PAGE"][1]):?>
        <div class="container">
        <?$APPLICATION->IncludeComponent(
	"bitrix:breadcrumb",
	"main",
	array(
		"0" => "",
		"COMPONENT_TEMPLATE" => "main",
		"START_FROM" => "0",
		"PATH" => "",
		"SITE_ID" => "s1"
	),
	false
);?>
    <?endif;?>