<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
use Bitrix\Main\Localization\Loc;
if ($arResult["ITEMS"]): ?>
    <div class="youtube-section__list">
        <? foreach ($arResult["ITEMS"] as $arItem):
            $this->addEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::getArrayById($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->addDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::getArrayById($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            ?>
            <div class="youtube-section__item" id="<?= $this->getEditAreaId($arItem['ID']) ?>">
                <?if($arItem['PREVIEW_PICTURE']):?>
                    <a target="_blank" href="<?=$arItem['PROPERTIES']['LINK']['VALUE']?>" class="youtube-section__thumb">
                        <img src="<?=$arItem['PREVIEW_PICTURE']['src']?>" alt="<?=$arItem['~NAME']?>">
                    </a>
                <?endif;?>
                <div class="youtube-section__title">
                    <?=$arItem['~NAME']?>
                </div>
                <a target="_blank" href="<?=$arItem['PROPERTIES']['LINK']['VALUE']?>" class="youtube-section__view">
                    <img src="/local/templates/main/assets/img/icons/youtube.svg" alt="<?=Loc::getMessage('YOUTUBE_SECTION_vIEW');?>">
                    <?=Loc::getMessage('YOUTUBE_SECTION_vIEW');?>
                </a>
            </div>
        <?endforeach; ?>
    </div>
<?endif; ?>