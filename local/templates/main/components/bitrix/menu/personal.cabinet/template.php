<?php check_prolog();

/**
 * @var array $arResult
 * @var array $arParams
 */

?>

<?php if (!empty($arResult)) { ?>
    <ul class="cabinet-menu">
		<?php foreach ($arResult as $item) { ?>
			<?php if ($item['DEPTH_LEVEL'] > $arParams['MAX_LEVEL'])
			{
				continue;
			} ?>
			<?php if ($item['SELECTED']) { ?>
                <li class="current-menu-item">
                    <a href="javascript:void(0);">
						<?= $item['PARAMS']['ICO'] ?>
                        <span><?= $item['TEXT'] ?></span>
                    </a>
                </li>
			<?php } else { ?>
                <li>
                    <a href="<?= $item['LINK'] ?>">
						<?= $item['PARAMS']['ICO'] ?>
                        <span><?= $item['TEXT'] ?></span>
                    </a>
                </li>
			<?php } ?>
		<?php } ?>
    </ul>
<?php } ?>
