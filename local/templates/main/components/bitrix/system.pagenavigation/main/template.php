<?php

/** @noinspection SpellCheckingInspection */

check_prolog();

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->setFrameMode(true);
if (!$arResult["NavShowAlways"]) {
    if ($arResult["NavRecordCount"] === 0 || ($arResult["NavPageCount"] === 1 && $arResult["NavShowAll"] === false)) {
        return;
    }
}

$strNavQueryString = ($arResult["NavQueryString"] !== "" ? $arResult["NavQueryString"] . "&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] !== "" ? "?" . $arResult["NavQueryString"] : "");

const AFTER_PAGINATION = 4;
const BEFORE_PAGINATION = 4;

/** @var CIBlockResult $navigation */
$navigation = $arResult;

if ($navigation['bDescPageNumbering'] === true) {
    $makeWeight = ($navigation['NavRecordCount'] % $navigation['NavPageSize']);
    $NavFirstRecordShow = 0;
    if ((int)$navigation['NavPageNomer'] !== (int)$navigation['NavPageCount']) {
        $NavFirstRecordShow += $makeWeight;
    }

    $NavFirstRecordShow += ($navigation['NavPageCount'] - $navigation['NavPageNomer']) * $navigation['NavPageSize'] + 1;
    $NavLastRecordShow = ((int)$navigation['NavPageCount'] === 1) ?
        $navigation['NavRecordCount']
        : $makeWeight + ($navigation['NavPageCount'] - $navigation['NavPageNomer'] + 1) * $navigation['NavPageSize'];

} else {
    $NavFirstRecordShow = ($navigation['NavPageNomer'] - 1) * $navigation['NavPageSize'] + 1;
    $NavLastRecordShow = ((int)$navigation['NavPageNomer'] !== (int)$navigation['NavPageCount']) ?
        $NavLastRecordShow = $navigation['NavPageNomer'] * $navigation['NavPageSize']
        : $NavLastRecordShow = $navigation['NavRecordCount'];
}
$arResult['NAVIGATION'] = [
    'ALL_COUNT' => $navigation['NavRecordCount'],
    'FROM_COUNT' => $navigation['NavRecordCount'] ? $NavFirstRecordShow : 0,
    'TO_COUNT' => $navigation['NavRecordCount'] ? $NavLastRecordShow : 0,
];

?>
<div class="pagination-wrapp">
    <ul class="pagination">
        <?php if ($arResult["NavPageNomer"] > 1) { ?>
            <?php if ($arResult["bSavePage"]) { ?>
                <li class="pagination-prev">
                    <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] - 1) ?>"
                       aria-label="Назад">
                        <svg width="22" height="22">
                            <use xlink:href="#icon-arrow-down"/>
                        </svg>
                    </a>
                </li>
            <?php } else { ?>
                <?php if ($arResult["NavPageNomer"] > 2) { ?>
                    <li class="pagination-prev">
                        <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] - 1) ?>"
                           aria-label="Назад">
                            <svg width="22" height="22">
                                <use xlink:href="#icon-arrow-down"/>
                            </svg>
                        </a>
                    </li>
                <?php } else { ?>
                    <li class="pagination-prev">
                        <a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>" aria-label="Назад">
                            <svg width="22" height="22">
                                <use xlink:href="#icon-arrow-down"/>
                            </svg>
                        </a>
                    </li>
                <?php } ?>
            <?php } ?>
        <?php } else { ?>
            <li class="pagination-prev disabled">
                <a href="#" aria-label="Назад">
                    <svg width="22" height="22">
                        <use xlink:href="#icon-arrow-down"/>
                    </svg>
                </a>
            </li>
        <?php } ?>

        <?php if ($arResult['NavPageNomer'] - BEFORE_PAGINATION > 1) { ?>
            <li><a href="<?= $arResult["sUrlPath"] ?>">1</a></li>
            <?php if ($arResult['NavPageNomer'] - BEFORE_PAGINATION !== 2) { ?>
                <li><span>...</span></li>
            <?php } ?>
            <?php for ($page = $arResult['NavPageNomer'] - BEFORE_PAGINATION; $page <= $arResult['NavPageNomer'] - 1; $page++) { ?>
                <li>
                    <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $page ?>"><?= $page ?></a>
                </li>
            <?php } ?>
        <?php } else { ?>
            <?php for ($page = 1; $page < $arResult['NavPageNomer']; $page++) { ?>
                <li>
                    <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $page ?>"><?= $page ?></a>
                </li>
            <?php } ?>
        <?php } ?>

        <li class="active">
            <span><?= $arResult['NavPageNomer'] ?></span>
        </li>

        <?php if ($arResult['NavPageNomer'] + AFTER_PAGINATION < $arResult['NavPageCount']) { ?>
            <?php for ($page = $arResult['NavPageNomer'] + 1; $page <= $arResult['NavPageNomer'] + AFTER_PAGINATION; $page++) { ?>
                <li>
                    <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $page ?>">
                        <?= $page ?>
                    </a>
                </li>
            <?php } ?>
            <li><span>...</span></li>
        <?php } else { ?>
            <?php for ($page = $arResult['NavPageNomer'] + 1; $page < $arResult['NavPageCount']; $page++) { ?>
                <li>
                    <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $page ?>">
                        <?= $page ?>
                    </a>
                </li>
            <?php } ?>
        <?php } ?>
        <?php if ((int)$arResult['NavPageNomer'] !== (int)$arResult['NavPageCount'] && $arResult['NavPageCount']) { ?>
            <li>
                <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult['NavPageCount'] ?>">
                    <?= $arResult['NavPageCount'] ?>
                </a>
            </li>
        <?php } ?>

        <?php if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]) { ?>
            <li class="pagination-next">
                <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] + 1) ?>"
                   aria-label="Вперед">
                    <svg width="22" height="22">
                        <use xlink:href="#icon-arrow-down"/>
                    </svg>
                </a>
            </li>
        <?php } else { ?>
            <li class="pagination-next disabled">
                <a href="#" aria-label="Вперед">
                    <svg width="22" height="22">
                        <use xlink:href="#icon-arrow-down"/>
                    </svg>
                </a>
            </li>
        <?php } ?>
    </ul>
</div>
