<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?php $APPLICATION->AddChainItem($APPLICATION->GetTitle());?>

    <div class="catalog-head">
        <div class="catalog-nav">
            <div class="catalog-nav-open">
                <h1 class="section-title"><? $APPLICATION->ShowTitle(false) ?></h1>
                <i class="visible-tablet"><svg width="24" height="24"><use xlink:href="#icon-chevron-down"/></svg></i>
            </div>
			<?$APPLICATION->IncludeComponent(
				"bitrix:catalog.section.list",
				"mobile",
				Array(
					"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
					"CACHE_TYPE" => "N",
					"TOP_DEPTH"=>"6",
					"CACHE_TIME" => $arParams["CACHE_TIME"],
					"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
					"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"]
				),
				$component
			);
			?>
        </div>
        <div class="catalog-sort">
            <div class="catalog-sort-title">Сортировать:</div>
            <ul class="catalog-sort-links">
                <li>
                    <a href="#" class="catalog-sort-link catalog-sort-link-arrow active">
                        <span>Цена</span>
                        <i>
                            <svg width="24" height="24"><use xlink:href="#icon-arrow-down"/></svg>
                        </i>
                    </a>
                </li>
                <li>
                    <a href="#" class="catalog-sort-link catalog-sort-link-letter">
                        <span>Название</span>
                        <i>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.251 5.25C16.4499 5.25 16.6407 5.32902 16.7813 5.46967C16.922 5.61032 17.001 5.80109 17.001 6V19.5C17.001 19.6989 16.922 19.8897 16.7813 20.0303C16.6407 20.171 16.4499 20.25 16.251 20.25C16.0521 20.25 15.8613 20.171 15.7206 20.0303C15.58 19.8897 15.501 19.6989 15.501 19.5V6C15.501 5.80109 15.58 5.61032 15.7206 5.46967C15.8613 5.32902 16.0521 5.25 16.251 5.25V5.25Z" fill="#4365AF"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.782 20.7797C16.7123 20.8495 16.6296 20.9049 16.5385 20.9427C16.4473 20.9805 16.3497 21 16.251 21C16.1524 21 16.0547 20.9805 15.9636 20.9427C15.8724 20.9049 15.7897 20.8495 15.72 20.7797L11.22 16.2797C11.0792 16.1388 11.0001 15.9478 11.0001 15.7487C11.0001 15.5495 11.0792 15.3585 11.22 15.2177C11.3608 15.0768 11.5518 14.9977 11.751 14.9977C11.9502 14.9977 12.1412 15.0768 12.282 15.2177L16.251 19.1882L20.22 15.2177C20.3608 15.0768 20.5518 14.9977 20.751 14.9977C20.9502 14.9977 21.1412 15.0768 21.282 15.2177C21.4228 15.3585 21.502 15.5495 21.502 15.7487C21.502 15.9478 21.4228 16.1388 21.282 16.2797L16.782 20.7797Z" fill="#4365AF"/>
                                <path d="M5.13223 4L3 10H4.31405L4.73554 8.76033H6.94215L7.33058 10H8.68595L6.57851 4H5.13223ZM5.83471 5.35537H5.85124L6.66942 7.72727H5.06612L5.83471 5.35537Z" fill="#4365AF"/>
                                <path d="M8.02479 15H4.99174C3.83471 15 3.10744 15.876 3.10744 16.8264C3.10744 17.7769 3.78512 18.314 4.46281 18.5372L3 21H4.46281L5.85124 18.6529H6.77686V21H8.02479V15ZM6.77686 17.6198H5.33058C4.67769 17.6198 4.35537 17.281 4.35537 16.7851C4.35537 16.4628 4.59504 16.0331 5.23141 16.0331H6.77686V17.6198Z" fill="#4365AF"/>
                            </svg>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.251 5.25C16.4499 5.25 16.6407 5.32902 16.7813 5.46967C16.922 5.61032 17.001 5.80109 17.001 6V19.5C17.001 19.6989 16.922 19.8897 16.7813 20.0303C16.6407 20.171 16.4499 20.25 16.251 20.25C16.0521 20.25 15.8613 20.171 15.7206 20.0303C15.58 19.8897 15.501 19.6989 15.501 19.5V6C15.501 5.80109 15.58 5.61032 15.7206 5.46967C15.8613 5.32902 16.0521 5.25 16.251 5.25Z" fill="black"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.782 20.7797C16.7123 20.8495 16.6296 20.9049 16.5385 20.9427C16.4473 20.9805 16.3497 21 16.251 21C16.1524 21 16.0547 20.9805 15.9636 20.9427C15.8724 20.9049 15.7897 20.8495 15.72 20.7797L11.22 16.2797C11.0792 16.1388 11.0001 15.9478 11.0001 15.7487C11.0001 15.5495 11.0792 15.3585 11.22 15.2177C11.3608 15.0768 11.5518 14.9977 11.751 14.9977C11.9502 14.9977 12.1412 15.0768 12.282 15.2177L16.251 19.1882L20.22 15.2177C20.3608 15.0768 20.5518 14.9977 20.751 14.9977C20.9502 14.9977 21.1412 15.0768 21.282 15.2177C21.4228 15.3585 21.502 15.5495 21.502 15.7487C21.502 15.9478 21.4228 16.1388 21.282 16.2797L16.782 20.7797Z" fill="black"/>
                                <path d="M5.13223 15L3 21H4.31405L4.73554 19.7603H6.94215L7.33058 21H8.68595L6.57851 15H5.13223ZM5.83471 16.3554H5.85124L6.66942 18.7273H5.06612L5.83471 16.3554Z" fill="black"/>
                                <path d="M8.02479 4H4.99174C3.83471 4 3.10744 4.87603 3.10744 5.82645C3.10744 6.77686 3.78512 7.31405 4.46281 7.53719L3 10H4.46281L5.85124 7.65289H6.77686V10H8.02479V4ZM6.77686 6.61983H5.33058C4.67769 6.61983 4.35537 6.28099 4.35537 5.78512C4.35537 5.46281 4.59504 5.03306 5.23141 5.03306H6.77686V6.61983Z" fill="black"/>
                            </svg>
                        </i>
                    </a>
                </li>
                <li>
                    <a href="#" class="catalog-sort-link catalog-sort-link-arrow">
                        <span>Рейтинг</span>
                        <i>
                            <svg width="24" height="24"><use xlink:href="#icon-arrow-down"/></svg>
                        </i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="catalog">
        <aside class="catalog-sidebar">
            <?$APPLICATION->IncludeComponent(
				"bitrix:catalog.section.list",
				"",
				Array(
					"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
					"CACHE_TYPE" => "N",
					"CACHE_TIME" => $arParams["CACHE_TIME"],
					"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
					"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"]
				),
				$component
			);
			?>

			<?
			if (CModule::IncludeModule("iblock"))
			{
				$arFilter = array(
					"ACTIVE" => "Y",
					"GLOBAL_ACTIVE" => "Y",
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
				);
				if(strlen($arResult["VARIABLES"]["SECTION_CODE"])>0)
				{
					$arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];
				}
                elseif($arResult["VARIABLES"]["SECTION_ID"]>0)
				{
					$arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
				}

				$obCache = new CPHPCache;
				if($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog"))
				{
					$arCurSection = $obCache->GetVars();
				}
				else
				{
					$arCurSection = array();
					$dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID"));
					$dbRes = new CIBlockResult($dbRes);
					if(defined("BX_COMP_MANAGED_CACHE"))
					{
						global $CACHE_MANAGER;
						$CACHE_MANAGER->StartTagCache("/iblock/catalog");

						if ($arCurSection = $dbRes->GetNext())
						{
							$CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);
						}
						$CACHE_MANAGER->EndTagCache();
					}
					else
					{
						if(!$arCurSection = $dbRes->GetNext())
							$arCurSection = array();
					}
					$obCache->EndDataCache($arCurSection);
				}
				?>
                <?$APPLICATION->IncludeComponent("bitrix:catalog.smart.filter", "bootstrap_v4", array(
                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                "SECTION_ID" => $arCurSection['ID'],
                "FILTER_NAME" => $arParams["FILTER_NAME"],
                "PRICE_CODE" => $arParams["~PRICE_CODE"],
                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                "CACHE_TIME" => $arParams["CACHE_TIME"],
                "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                "SAVE_IN_SESSION" => "N",
                "FILTER_VIEW_MODE" => $arParams["FILTER_VIEW_MODE"],
                "XML_EXPORT" => "N",
                "SECTION_TITLE" => "NAME",
                "SECTION_DESCRIPTION" => "DESCRIPTION",
                'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
                "TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
                'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                "SEF_MODE" => $arParams["SEF_MODE"],
                "SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
                "SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
                "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
                "INSTANT_RELOAD" => $arParams["INSTANT_RELOAD"],
                ),
                $component,
                array('HIDE_ICONS' => 'Y')
                );
            }
			?>



        </aside>


<?if($arParams["USE_COMPARE"]=="Y"):?>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.compare.list",
	"",
	Array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"NAME" => $arParams["COMPARE_NAME"],
		"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
		"COMPARE_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["compare"],
	),
	$component
);?>
<br />
<?endif?>


<?if($arParams["SHOW_TOP_ELEMENTS"]!="N"):?>
<hr />
	<?$APPLICATION->IncludeComponent(
		"bitrix:catalog.section",
		"",
		Array(
			"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
			"ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
			"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
			"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
			"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
			"BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
			"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
			"BASKET_URL" => $arParams["BASKET_URL"],
			"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
			"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
			"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
			"FILTER_NAME" => $arParams["FILTER_NAME"],
			"DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"CACHE_FILTER" => $arParams["CACHE_FILTER"],
			"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
			"SET_TITLE" => $arParams["SET_TITLE"],
			"SET_STATUS_404" => $arParams["SET_STATUS_404"],
			"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
			"PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
			"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
			"PRICE_CODE" => $arParams["PRICE_CODE"],
			"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
			"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
			"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
			"PRICE_VAT_SHOW_VALUE" => $arParams["PRICE_VAT_SHOW_VALUE"],
			"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
			"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
			"PAGER_TITLE" => $arParams["PAGER_TITLE"],
			"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
			"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
			"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
			"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
			"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],

			"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
			"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
			"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
			"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
			//Template parameters
			"LINK_IBLOCK_ID" => $arParams["LINK_IBLOCK_ID"],
			"LINK_PROPERTY_SID" => $arParams["LINK_PROPERTY_SID"],
		),
		$component
	);
	?>
<?endif?>
    </div>
