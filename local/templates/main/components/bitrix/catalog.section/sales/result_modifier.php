<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogSectionComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

if($arResult['ITEMS']){
    foreach($arResult['ITEMS'] as $arItem){
        $arIds[] = $arItem['ID'];
    }
}

global $APPLICATION;
$cp = $this->__component;
if (is_object($cp)) {
    $cp->arResult['IDS'] = $arIds;
    $cp->SetResultCacheKeys(array('IDS'));
}