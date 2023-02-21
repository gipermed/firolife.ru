<?php check_prolog();

/**
 * @var array $arResult
 * @var array $arParams
 */

?>

<?php if (!empty($arResult)) { ?>
    <ul class="head-menu">
        <?php foreach ($arResult as $item) { ?>
            <?php if ($item['DEPTH_LEVEL'] > $arParams['MAX_LEVEL']) {
                continue;
            } ?>
            <?php if ($item['SELECTED']) { ?>
                <li class="active <?= $item['PARAMS']['ITEM_CLASS'] ?>">
                    <a href="javascript:void(0);">
                        <span><?= $item['TEXT'] ?></span>
                    </a>
                </li>
            <?php } else { ?>
                <li class="<?= $item['PARAMS']['ITEM_CLASS'] ?>">
                    <a href="<?= $item['LINK'] ?>">
                        <span><?= $item['TEXT'] ?></span>
                    </a>
                </li>
            <?php } ?>
        <?php } ?>
    </ul>
<?php } ?>
