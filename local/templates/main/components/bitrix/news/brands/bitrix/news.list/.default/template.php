<?php check_prolog();
$this->setFrameMode(true);
?>
<div class="brandsPage-row">
    <?php foreach ($arResult["ITEMS"] as $item) { ?>
        <?php
        $this->addEditAction($item['ID'], $item['EDIT_LINK'], CIBlock::getArrayById($item["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->addDeleteAction($item['ID'], $item['DELETE_LINK'], CIBlock::getArrayById($item["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

        $picture = $item['PREVIEW_PICTURE']['SRC'] ?: $item['DETAIL_PICTURE']['SRC'];
        ?>
        <a href="<?= $item['DETAIL_PAGE_URL'] ?>" class="brandsPage-item" id="<?= $this->getEditAreaId($item['ID']) ?>">
            <div class="brandsPage-item-img">
               <img src="<?= $picture ?>" srcset="<?= $picture ?> 2x" alt="">
            </div>
            <div class="brandsPage-item-title"><?= $item['NAME'] ?></div>
        </a>
    <?php } ?>
</div>