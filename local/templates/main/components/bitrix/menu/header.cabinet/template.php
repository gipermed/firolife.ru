<?php check_prolog();

/**
 * @var array $arResult
 * @var array $arParams
 */

$class = array(
    'Профиль'=>'has-divider ',
    'Мои адреса'=>'has-divider ',
//    'Лист ожидания'=>'has-divider ',
);
?>

<? if (!empty($arResult)) { ?>
    <ul class="header-cabinet-menu">
        <? foreach ($arResult as $item) { ?>
            <? if ($item['DEPTH_LEVEL'] > $arParams['MAX_LEVEL']) {
                continue;
            } ?>
            <li class="<?=$class[$item['TEXT']];?><? if ($item['SELECTED']) { ?>active <?}?><?= $item['PARAMS']['ITEM_CLASS'] ?>">
                <a href="<? if ($item['SELECTED']) { ?>javascript:void(0);<?}else{?><?= $item['LINK'] ?><?}?>">
                    <span><?= $item['TEXT'] ?></span>
                </a>
            </li>
        <? } ?>
    </ul>
<? } ?>