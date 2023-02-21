<?php check_prolog();?>
<?php if (!empty($arResult)) {

    $first_li = $arResult[0];
    unset($arResult[0]);
    $first_li['DEPTH_LEVEL'] = 2;
    $first_li['IS_PARENT'] = '';
    $arResult[] = $first_li;

    CModule::IncludeModule('iblock');
    $arFilter = Array('IBLOCK_ID'=>IBLOCK_CATALOG_ID, 'GLOBAL_ACTIVE'=>'Y', 'ELEMENT_SUBSECTIONS'=>'Y', 'PROPERTY'=>Array('SRC'=>'https://%'));
    $db_list = CIBlockSection::GetList(Array(), $arFilter, true, array('ID','NAME','CODE','SECTION_PAGE_URL'));
    while($ar_result = $db_list->GetNext()) {
        $arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM");
        $arFilter = Array("IBLOCK_ID"=>IBLOCK_CATALOG_ID, "SECTION_ID"=>$ar_result['ID'], "INCLUDE_SUBSECTIONS"=>"Y", "ACTIVE"=>"Y", ">CATALOG_QUANTITY"=>0);
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), $arSelect);
        while($ob = $res->Fetch()) {
            if($ob){
                $allSections[str_replace('/','',$ar_result['SECTION_PAGE_URL'])] = $ar_result['ELEMENT_CNT'];
            }
        }
    }
    ?>
<div class="header-catalog">
    <div class="container">
        <a href="/catalog/" class="header-catalog-open active">
            <svg width="24" height="24"><use xlink:href="#icon-book"/></svg>
            <span>Каталог</span>
            <i><svg width="24" height="24"><use xlink:href="#icon-chevron-down"/></svg></i>
        </a>
        <div class="header-catalog-menu-marker hidden-tablet"></div>
        <ul class="header-catalog-menu-level-1" style="display: block;">
            <li class="header-catalog-menu-view-all header-catalog-menu-close-sub-menu">
                <a href="/catalog/">
                    <i class="visible-tablet">
                        <svg width="24" height="24"><use xlink:href="#icon-chevron-down"/></svg>
                    </i>
                    <span>Все категории</span>
                </a>
            </li>
            <?php foreach ($arResult as $arItem) { ?>
                <?php if (($arItem['DEPTH_LEVEL']-1) > $arParams['MAX_LEVEL']) {
                    continue;
                }
                ?>
                <?if ($previousLevel && ($arItem['DEPTH_LEVEL']-1) < $previousLevel):?>
                    <?=str_repeat("</ul></li>", ($previousLevel - ($arItem['DEPTH_LEVEL']-1)));?>
                <?endif?>
                <?if ($arItem["IS_PARENT"]):?>
                    <li class="is-parent catalog-menu-level-<?=$arItem['DEPTH_LEVEL']?> <?php if ($arItem['SELECTED']) { ?>menu-item-has-children current-menu-item<?}?>">
                        <a href="<?= $arItem['LINK'] ?>">
                            <?/*i class="visible-tablet">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.0968 6.38344H12.5991C12.9679 6.38344 13.2692 6.08555 13.28 5.71521C13.6462 5.70423 13.9408 5.39956 13.9408 5.02659V4.51851C13.9408 4.14554 13.6462 3.84083 13.28 3.82985C13.2692 3.45951 12.9679 3.16162 12.5991 3.16162H12.0968C11.728 3.16162 11.4267 3.45951 11.4159 3.82985C11.0497 3.84083 10.7551 4.14554 10.7551 4.51847V5.02655C10.7551 5.39952 11.0497 5.70419 11.4159 5.71517C11.4267 6.08555 11.728 6.38344 12.0968 6.38344ZM11.3366 5.02655V4.51851C11.3366 4.46292 11.3813 4.41767 11.4363 4.41767H11.6857C11.8574 4.41767 11.9971 4.27637 11.9971 4.10273V3.85059C11.9971 3.795 12.0418 3.74975 12.0968 3.74975H12.5991C12.6541 3.74975 12.6988 3.795 12.6988 3.85059V4.10273C12.6988 4.27641 12.8385 4.41767 13.0102 4.41767H13.2596C13.3146 4.41767 13.3593 4.46292 13.3593 4.51855V5.02659C13.3593 5.08218 13.3146 5.12743 13.2596 5.12743H13.0102C12.8385 5.12743 12.6988 5.26872 12.6988 5.44237V5.69451C12.6988 5.7501 12.6541 5.79538 12.5991 5.79538H12.0968C12.0418 5.79538 11.9971 5.75014 11.9971 5.69454V5.44241C11.9971 5.26872 11.8573 5.12746 11.6857 5.12746H11.4363C11.3813 5.12743 11.3366 5.08218 11.3366 5.02655Z" fill="black"/>
                                    <path d="M18.15 15.1606L14.5266 13.7864C14.4316 13.7504 14.3678 13.6573 14.3678 13.5546V12.2555C15.2576 11.6557 15.881 10.6823 16.0171 9.55862C16.7078 9.5033 17.2533 8.9176 17.2533 8.2051C17.2533 7.50225 16.7226 6.92247 16.0453 6.85378V4.08174C16.0453 3.55437 15.7688 3.05614 15.3236 2.78146L14.6166 2.34509C14.2507 2.11934 13.8308 2 13.4023 2H11.1803C10.7517 2 10.3318 2.11934 9.96599 2.34509L9.25888 2.78146C8.81375 3.05614 8.53727 3.55437 8.53727 4.08174V6.85045C7.8393 6.89824 7.28583 7.48735 7.28583 8.20514C7.28583 8.93266 7.85438 9.52832 8.56576 9.56172C8.70265 10.6841 9.32579 11.6562 10.2148 12.2555V13.5546C10.2148 13.6572 10.151 13.7504 10.056 13.7864L6.43256 15.1606C5.15177 15.6463 4.29126 16.9021 4.29126 18.2854V20.0934C4.29126 20.2558 4.42144 20.3875 4.58201 20.3875C4.74259 20.3875 4.87277 20.2558 4.87277 20.0934V18.2854C4.87277 17.1459 5.58166 16.1114 6.63671 15.7112L7.75948 15.2854V17.1671C7.26384 17.2978 6.89695 17.7542 6.89695 18.2958C6.89695 18.939 7.4143 19.4622 8.05024 19.4622C8.68617 19.4622 9.20352 18.939 9.20352 18.2958C9.20352 17.7542 8.83659 17.2978 8.34099 17.1671V15.0649L8.50722 15.0018C8.51501 15.0091 8.52319 15.0162 8.53196 15.0227L9.25159 15.5626C10.1373 16.2272 11.1884 16.5784 12.2913 16.5784C13.3941 16.5784 14.4453 16.2272 15.331 15.5626L16.052 15.0217C16.0603 15.0155 16.0681 15.0088 16.0756 15.0019L16.478 15.1545V16.9213C15.7523 16.9707 15.1768 17.583 15.1768 18.3292V20.658C15.1768 20.8204 15.3069 20.9521 15.4675 20.9521H15.9103C16.071 20.9521 16.2011 20.8204 16.2011 20.658C16.2011 20.4956 16.071 20.364 15.9103 20.364H15.7583V18.3292C15.7583 17.8752 16.1235 17.5058 16.5724 17.5058H16.932C17.3809 17.5058 17.7461 17.8752 17.7461 18.3292V20.364H17.5956C17.435 20.364 17.3048 20.4956 17.3048 20.658C17.3048 20.8204 17.435 20.9521 17.5956 20.9521H18.0368C18.1974 20.9521 18.3276 20.8204 18.3276 20.658V18.3292C18.3276 17.5944 17.7695 16.9893 17.0595 16.9239V15.3751L17.9458 15.7113C19.0009 16.1114 19.7098 17.1459 19.7098 18.2855V21.3993C19.7098 21.4062 19.7042 21.4119 19.6973 21.4119H4.88525C4.87839 21.4119 4.87277 21.4062 4.87277 21.3993V21.2696C4.87277 21.1072 4.74259 20.9756 4.58201 20.9756C4.42144 20.9756 4.29126 21.1072 4.29126 21.2696V21.3993C4.29126 21.7305 4.55774 22 4.88525 22H19.6973C20.0248 22 20.2913 21.7305 20.2913 21.3993V18.2855C20.2913 16.9021 19.4307 15.6463 18.15 15.1606ZM8.62201 18.2958C8.62201 18.6147 8.36553 18.8741 8.05024 18.8741C7.73494 18.8741 7.47846 18.6147 7.47846 18.2958C7.47846 17.977 7.73494 17.7176 8.05024 17.7176C8.36553 17.7176 8.62201 17.977 8.62201 18.2958ZM16.6718 8.20518C16.6718 8.58317 16.4009 8.89772 16.0453 8.96245V7.44791C16.4009 7.5126 16.6718 7.82719 16.6718 8.20518ZM7.86729 8.20518C7.86729 7.8119 8.16045 7.48716 8.53723 7.44121V8.9692C8.16045 8.92321 7.86729 8.59842 7.86729 8.20518ZM9.11877 9.09426V7.43846H10.7118C10.8724 7.43846 11.0026 7.30681 11.0026 7.14442C11.0026 6.98202 10.8724 6.85037 10.7118 6.85037H9.11877V4.08174C9.11877 3.75797 9.28853 3.45208 9.5618 3.28346L10.2689 2.84713C10.5435 2.67768 10.8586 2.58809 11.1803 2.58809H13.4023C13.724 2.58809 14.0391 2.67768 14.3137 2.84713L15.0208 3.28346C15.294 3.45208 15.4638 3.75797 15.4638 4.08174V6.85037H11.8748C11.7143 6.85037 11.5841 6.98202 11.5841 7.14442C11.5841 7.30681 11.7143 7.43846 11.8748 7.43846H15.4638V9.09426C15.4638 10.8634 14.0406 12.3027 12.2913 12.3027C10.542 12.3027 9.11877 10.8634 9.11877 9.09426ZM14.9845 15.0904C14.1997 15.6792 13.2684 15.9904 12.2913 15.9904C11.3141 15.9904 10.3828 15.6792 9.59805 15.0904L9.15343 14.7568L10.2601 14.3371C10.5808 14.2155 10.7963 13.901 10.7963 13.5546V12.5764C11.2546 12.7785 11.7602 12.8908 12.2913 12.8908C12.8224 12.8908 13.3279 12.7785 13.7863 12.5764V13.5546C13.7863 13.901 14.0018 14.2155 14.3224 14.3371L15.4291 14.7568L14.9845 15.0904Z" fill="black"/>
                                </svg>
                                <svg width="24" height="24"><use xlink:href="#icon-chevron-down"/></svg>
                            </i*/?>
                            <span>
                                <?= $arItem['TEXT'] ?>
                            </span>
                            <i><svg width="24" height="24"><use xlink:href="#icon-chevron-down"/></svg></i>
                        </a>
                        <ul class="catalog-items-<?=$arItem['DEPTH_LEVEL']+1?>">
                <?else:?>
                    <?if($allSections[str_replace('/','',$arItem['LINK'])]):?>
                        <li class="catalog-menu-level-<?=$arItem['DEPTH_LEVEL']?> <?php if ($arItem['SELECTED']) { ?> !menu-item-has-children current-menu-item<?}?>">
                            <a href="<?= $arItem['LINK'] ?>">
                                <?/*i class="visible-tablet">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12.0968 6.38344H12.5991C12.9679 6.38344 13.2692 6.08555 13.28 5.71521C13.6462 5.70423 13.9408 5.39956 13.9408 5.02659V4.51851C13.9408 4.14554 13.6462 3.84083 13.28 3.82985C13.2692 3.45951 12.9679 3.16162 12.5991 3.16162H12.0968C11.728 3.16162 11.4267 3.45951 11.4159 3.82985C11.0497 3.84083 10.7551 4.14554 10.7551 4.51847V5.02655C10.7551 5.39952 11.0497 5.70419 11.4159 5.71517C11.4267 6.08555 11.728 6.38344 12.0968 6.38344ZM11.3366 5.02655V4.51851C11.3366 4.46292 11.3813 4.41767 11.4363 4.41767H11.6857C11.8574 4.41767 11.9971 4.27637 11.9971 4.10273V3.85059C11.9971 3.795 12.0418 3.74975 12.0968 3.74975H12.5991C12.6541 3.74975 12.6988 3.795 12.6988 3.85059V4.10273C12.6988 4.27641 12.8385 4.41767 13.0102 4.41767H13.2596C13.3146 4.41767 13.3593 4.46292 13.3593 4.51855V5.02659C13.3593 5.08218 13.3146 5.12743 13.2596 5.12743H13.0102C12.8385 5.12743 12.6988 5.26872 12.6988 5.44237V5.69451C12.6988 5.7501 12.6541 5.79538 12.5991 5.79538H12.0968C12.0418 5.79538 11.9971 5.75014 11.9971 5.69454V5.44241C11.9971 5.26872 11.8573 5.12746 11.6857 5.12746H11.4363C11.3813 5.12743 11.3366 5.08218 11.3366 5.02655Z" fill="black"/>
                                        <path d="M18.15 15.1606L14.5266 13.7864C14.4316 13.7504 14.3678 13.6573 14.3678 13.5546V12.2555C15.2576 11.6557 15.881 10.6823 16.0171 9.55862C16.7078 9.5033 17.2533 8.9176 17.2533 8.2051C17.2533 7.50225 16.7226 6.92247 16.0453 6.85378V4.08174C16.0453 3.55437 15.7688 3.05614 15.3236 2.78146L14.6166 2.34509C14.2507 2.11934 13.8308 2 13.4023 2H11.1803C10.7517 2 10.3318 2.11934 9.96599 2.34509L9.25888 2.78146C8.81375 3.05614 8.53727 3.55437 8.53727 4.08174V6.85045C7.8393 6.89824 7.28583 7.48735 7.28583 8.20514C7.28583 8.93266 7.85438 9.52832 8.56576 9.56172C8.70265 10.6841 9.32579 11.6562 10.2148 12.2555V13.5546C10.2148 13.6572 10.151 13.7504 10.056 13.7864L6.43256 15.1606C5.15177 15.6463 4.29126 16.9021 4.29126 18.2854V20.0934C4.29126 20.2558 4.42144 20.3875 4.58201 20.3875C4.74259 20.3875 4.87277 20.2558 4.87277 20.0934V18.2854C4.87277 17.1459 5.58166 16.1114 6.63671 15.7112L7.75948 15.2854V17.1671C7.26384 17.2978 6.89695 17.7542 6.89695 18.2958C6.89695 18.939 7.4143 19.4622 8.05024 19.4622C8.68617 19.4622 9.20352 18.939 9.20352 18.2958C9.20352 17.7542 8.83659 17.2978 8.34099 17.1671V15.0649L8.50722 15.0018C8.51501 15.0091 8.52319 15.0162 8.53196 15.0227L9.25159 15.5626C10.1373 16.2272 11.1884 16.5784 12.2913 16.5784C13.3941 16.5784 14.4453 16.2272 15.331 15.5626L16.052 15.0217C16.0603 15.0155 16.0681 15.0088 16.0756 15.0019L16.478 15.1545V16.9213C15.7523 16.9707 15.1768 17.583 15.1768 18.3292V20.658C15.1768 20.8204 15.3069 20.9521 15.4675 20.9521H15.9103C16.071 20.9521 16.2011 20.8204 16.2011 20.658C16.2011 20.4956 16.071 20.364 15.9103 20.364H15.7583V18.3292C15.7583 17.8752 16.1235 17.5058 16.5724 17.5058H16.932C17.3809 17.5058 17.7461 17.8752 17.7461 18.3292V20.364H17.5956C17.435 20.364 17.3048 20.4956 17.3048 20.658C17.3048 20.8204 17.435 20.9521 17.5956 20.9521H18.0368C18.1974 20.9521 18.3276 20.8204 18.3276 20.658V18.3292C18.3276 17.5944 17.7695 16.9893 17.0595 16.9239V15.3751L17.9458 15.7113C19.0009 16.1114 19.7098 17.1459 19.7098 18.2855V21.3993C19.7098 21.4062 19.7042 21.4119 19.6973 21.4119H4.88525C4.87839 21.4119 4.87277 21.4062 4.87277 21.3993V21.2696C4.87277 21.1072 4.74259 20.9756 4.58201 20.9756C4.42144 20.9756 4.29126 21.1072 4.29126 21.2696V21.3993C4.29126 21.7305 4.55774 22 4.88525 22H19.6973C20.0248 22 20.2913 21.7305 20.2913 21.3993V18.2855C20.2913 16.9021 19.4307 15.6463 18.15 15.1606ZM8.62201 18.2958C8.62201 18.6147 8.36553 18.8741 8.05024 18.8741C7.73494 18.8741 7.47846 18.6147 7.47846 18.2958C7.47846 17.977 7.73494 17.7176 8.05024 17.7176C8.36553 17.7176 8.62201 17.977 8.62201 18.2958ZM16.6718 8.20518C16.6718 8.58317 16.4009 8.89772 16.0453 8.96245V7.44791C16.4009 7.5126 16.6718 7.82719 16.6718 8.20518ZM7.86729 8.20518C7.86729 7.8119 8.16045 7.48716 8.53723 7.44121V8.9692C8.16045 8.92321 7.86729 8.59842 7.86729 8.20518ZM9.11877 9.09426V7.43846H10.7118C10.8724 7.43846 11.0026 7.30681 11.0026 7.14442C11.0026 6.98202 10.8724 6.85037 10.7118 6.85037H9.11877V4.08174C9.11877 3.75797 9.28853 3.45208 9.5618 3.28346L10.2689 2.84713C10.5435 2.67768 10.8586 2.58809 11.1803 2.58809H13.4023C13.724 2.58809 14.0391 2.67768 14.3137 2.84713L15.0208 3.28346C15.294 3.45208 15.4638 3.75797 15.4638 4.08174V6.85037H11.8748C11.7143 6.85037 11.5841 6.98202 11.5841 7.14442C11.5841 7.30681 11.7143 7.43846 11.8748 7.43846H15.4638V9.09426C15.4638 10.8634 14.0406 12.3027 12.2913 12.3027C10.542 12.3027 9.11877 10.8634 9.11877 9.09426ZM14.9845 15.0904C14.1997 15.6792 13.2684 15.9904 12.2913 15.9904C11.3141 15.9904 10.3828 15.6792 9.59805 15.0904L9.15343 14.7568L10.2601 14.3371C10.5808 14.2155 10.7963 13.901 10.7963 13.5546V12.5764C11.2546 12.7785 11.7602 12.8908 12.2913 12.8908C12.8224 12.8908 13.3279 12.7785 13.7863 12.5764V13.5546C13.7863 13.901 14.0018 14.2155 14.3224 14.3371L15.4291 14.7568L14.9845 15.0904Z" fill="black"/>
                                    </svg>
                                    <svg width="24" height="24"><use xlink:href="#icon-chevron-down"/></svg>
                                </i*/?>
                                <span>
                                    <?= $arItem['TEXT'] ?>
                                    <?if($arItem['DEPTH_LEVEL']>2):?>
                                        <?if($allSections[str_replace('/','',$arItem['LINK'])]):?>
                                            (<?=$allSections[str_replace('/','',$arItem['LINK'])]?>)
                                        <?endif;?>
                                    <?endif;?>
                                </span>
                            </a>
                        </li>
                    <?endif;?>
                <?endif?>
                <?$previousLevel = ($arItem['DEPTH_LEVEL']-1);?>
            <?php } ?>
            <?if ($previousLevel > 1)://close last item tags?>
                <?=str_repeat("</ul></li>", ($previousLevel-1) );?>
            <?endif?>
        </ul>
    </div>
</div>
<?php } ?>