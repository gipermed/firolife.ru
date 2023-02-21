<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

if (!empty($arResult)) {?>
	<nav>
		<?$lastDepth = 0;
		foreach($arResult as $arItem) {
			$openClass = ($arItem['SELECTED']) ? ' class="opened"' : '';
			$currentClass = POST_FORM_ACTION_URI == $arItem['LINK'] ? 'current' : '';
			$openBlockClass = ($arItem['SELECTED']) ? ' style="display: block;"' : '';
			if ($arItem['DEPTH_LEVEL'] > $lastDepth) {?>
				<ul<?=$openBlockClass?>><li<?=$openClass?>>
			<?} elseif ($arItem['DEPTH_LEVEL'] < $lastDepth && $lastDepth != 0) {
				$level = $lastDepth - $arItem['DEPTH_LEVEL'];
				while ($level > 0) {?>
					</ul></li>
					<?$level--;
				}?>
				<li<?=$openClass?>>
			<?} elseif ($arItem['DEPTH_LEVEL'] == $lastDepth) {?>
				</li><li<?=$openClass?>>
			<?}
			if ($arItem['PARAMS']['IS_PARENT']) {?>
				<span><a class="no-icon <?=$currentClass?>" href="<?=$arItem['LINK']?>"><?=$arItem['TEXT']?></a></span>
			<?} else {?>
				<a class="<?=$currentClass?>" href="<?=$arItem['LINK']?>"><?=$arItem['TEXT']?></a>
			<?}
			$lastDepth = $arItem['DEPTH_LEVEL'];
		}
		$level = $arItem['DEPTH_LEVEL'];
		while ($level > 0) {?>
			</li></ul>
			<?$level--;
		}?>
	</nav>
<?}?>