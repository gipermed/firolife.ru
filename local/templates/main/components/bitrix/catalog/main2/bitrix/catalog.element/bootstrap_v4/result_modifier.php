<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();
foreach ($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $key=>$photo)
{
	$fileImg=CFile::GetFileArray($photo);
	$arImg = CFile::ResizeImageGet(
		$photo,
		array('width' => $fileImg['WIDTH']*2, 'height'=>$fileImg['HEIGHT']*2),
		BX_RESIZE_IMAGE_PROPORTIONAL_ALT,
		true
	);
	$arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE2X"][$key]=$arImg;
}
?>