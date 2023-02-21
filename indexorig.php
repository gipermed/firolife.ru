<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle("Gipermed");
$APPLICATION->SetPageProperty('body-class', 'home');

?><main class="main">
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"slider.main",
	Array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array("NAME","PREVIEW_TEXT","PREVIEW_PICTURE",""),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "3",
		"IBLOCK_TYPE" => "lists",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "999",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array("LINK","LINK_TITLE",""),
		"SET_BROWSER_TITLE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "ACTIVE_FROM",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "DESC",
		"STRICT_SECTION_CHECK" => "N"
	)
);?>
<div class="section best-sales-section">
	<div class="container">
		<div class="section-title">
			 Топ продаж
		</div>
		<div class="best-sales-row products-row flex-row">
		</div>
	</div>
</div>
<div class="section home-promotions-section">
	<div class="container">
		<div class="section-title">
			 Акции
		</div>
		<div class="home-promotions-row promotions-row flex-row">
		</div>
	</div>
</div>
 <?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"articles.main",
	Array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array("NAME","PREVIEW_TEXT","PREVIEW_PICTURE",""),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "2",
		"IBLOCK_TYPE" => "lists",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "999",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array("VIEW_COUNTER",""),
		"SET_BROWSER_TITLE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "ACTIVE_FROM",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "DESC",
		"STRICT_SECTION_CHECK" => "N"
	)
);?>
<div class="section category-section">
	<div class="container">
		<div class="category-section-body">
			<div class="category-section-icon">
 <img src="/local/templates/main/assets/img/category-section-icon.svg" alt="">
			</div>
			<div class="category-section-content">
				<div class="category-section-title">
					 Товары для спорта и фитнеса
				</div>
				<div class="category-section-desc">
					 Позаботьтесь о себе и своих близких
				</div>
 <a href="#" class="category-section-btn btn btn-border btn-white">Все товары</a>
			</div>
		</div>
		<div class="category-section-products">
			<div class="category-section-products-slider swiper-container">
			</div>
		</div>
	</div>
</div>
<div class="section subscription-section hidden-mobile">
	<div class="container">
		<div class="subscription-section-desc">
			 Выгодные предложения для подписчиков. Вы будете одними из первых узнавать о новых скидках, акциях и распродажах. Подписаться.
		</div>
		<form action="?" class="subscription-section-form form">
 <label class="form-block" aria-label="Электронная почта"> <input type="email" class="input subscription-input" placeholder="Электронная почта" required=""> </label> <button type="submit" class="subscription-submit btn">Подписаться</button>
		</form>
	</div>
</div>
<div class="section novelty-section hidden-mobile">
	<div class="container">
		<div class="section-title">
			 Новинки
		</div>
		<div class="novelty-row products-row flex-row">
		</div>
	</div>
</div>
<div class="section seo-section">
	<div class="container">
		<div class="content-text">
			<p>
				 В интернет магазине «Гипермед» можно купить домашнюю медицинскую технику, расходные материалы и приборы для ухода за больными на дому, товары для стомы, восстановления после операции или травм, приспособления для пожилых пациентов, расходники для салонов красоты и косметологов.
			</p>
			<p>
				 Кроме широкого ассортимента изделий у нас низкие цены, удобная доставка по России и СНГ, самовывоз со склада в Москве и простые условия возврата и обмена. Магазин медицинских товаров в москве «Гипермед» предлагает только те медицинские изделия, которые прошли проверку качества, а также получили необходимые сертификаты.
			</p>
		</div>
	</div>
</div>
 </main><?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>