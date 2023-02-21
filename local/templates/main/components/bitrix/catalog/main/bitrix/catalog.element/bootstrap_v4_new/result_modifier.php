<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();
//foreach ($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $key=>$photo)
//{
//	$fileImg=CFile::GetFileArray($photo);
//	$arImg = CFile::ResizeImageGet(
//		$photo,
//		array('width' => $fileImg['WIDTH']*2, 'height'=>$fileImg['HEIGHT']*2),
//		BX_RESIZE_IMAGE_PROPORTIONAL_ALT,
//		true
//	);
//	$arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE2X"][$key]=$arImg;
//}

if($arResult['PROPERTIES']['FILES']['VALUE']){
    foreach($arResult['PROPERTIES']['FILES']['VALUE'] as $key=>$file){
        $explode_name = explode('___fil',$arResult['PROPERTIES']['FILES']['DESCRIPTION'][$key]);
        if($explode_name[1]){
            $arFile = CFile::GetFileArray($file);
            $arResult['FILES'][] = array(
                'SRC' => CFile::GetPath($file),
                'NAME' => str_replace('___file','',$arResult['PROPERTIES']['FILES']['DESCRIPTION'][$key]),
                'FILE_SIZE' => CFile::FormatSize($arFile['FILE_SIZE'])
            );
        }
    }
}
if($arResult['PROPERTIES']['MORE_PHOTO']['VALUE']){
    $count=0;
    foreach($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'] as $key=>$file){
        $explode_name = explode('___fil',$arResult['PROPERTIES']['MORE_PHOTO']['DESCRIPTION'][$key]);
        $explode_name2 = explode('YM_',$arResult['PROPERTIES']['MORE_PHOTO']['DESCRIPTION'][$key]);
        if($explode_name2[1]){
            continue;
        }
        $count++;
        if($explode_name[1]){
            $arFile = CFile::GetFileArray($file);
            $arResult['FILES'][] = array(
                'SRC' => CFile::GetPath($file),
                'NAME' => str_replace('___file','',$arResult['PROPERTIES']['MORE_PHOTO']['DESCRIPTION'][$key]),
                'FILE_SIZE' => CFile::FormatSize($arFile['FILE_SIZE'])
            );
        }else{
            $arResult['MORE_PHOTO'][] = array(
                'ID' => $file,
                'SRC' => CFile::GetPath($file),
                'WIDTH' => 1000,
                'HEIGHT' => 1000,
            );
        }
    }
    $arResult['MORE_PHOTO_COUNT2'] = $count;
    $arResult['MORE_PHOTO_COUNT'] = count($arResult['MORE_PHOTO']);
}
if($arResult['OFFERS']){
    foreach($arResult['OFFERS'] as $i=>$offer){
        if($offer['PROPERTIES']['MORE_PHOTO']['VALUE']){
//            foreach($offer['PROPERTIES']['MORE_PHOTO']['VALUE'] as $key=>$file){
//                $explode_name = explode('___fil',$offer['PROPERTIES']['MORE_PHOTO']['DESCRIPTION'][$key]);
//                $explode_name2 = explode('YM_',$offer['PROPERTIES']['MORE_PHOTO']['DESCRIPTION'][$key]);
//                if($explode_name2[1]){
//                    continue;
//                }
//                if($explode_name[1]){
//                    $arFile = CFile::GetFileArray($file);
//                    $arResult['OFFERS'][$i]['FILES'][] = array(
//                        'SRC' => CFile::GetPath($file),
//                        'NAME' => str_replace('___file','',$offer['PROPERTIES']['MORE_PHOTO']['DESCRIPTION'][$key]),
//                        'FILE_SIZE' => CFile::FormatSize($arFile['FILE_SIZE'])
//                    );
//                }else{
//                    $arResult['OFFERS'][$i]['MORE_PHOTO'][] = array(
//                        'ID' => $file,
//                        'SRC' => CFile::GetPath($file),
//                        'WIDTH' => 1000,
//                        'HEIGHT' => 1000,
//                    );
//                }
//            }
//            $arResult['MORE_PHOTO_COUNT'] = count($arResult['MORE_PHOTO']);
        }
    }
}
$avg_rating = 0;
$arSelect = Array("ID", "DATE_CREATE", "NAME", "PROPERTY_RATING", "PREVIEW_TEXT");
$arFilter = Array("IBLOCK_ID"=>77, "PROPERTY_PRODUCT"=>$arResult['ID'], "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array('ID'=>'DESC'), $arFilter, false, Array("nPageSize"=>8), $arSelect);
while($ob = $res->Fetch()) {
    $res2 = CIBlockElement::GetProperty(77, $ob['ID'], "sort", "asc", array("CODE" => "FILES"));
    while ($ob2 = $res2->GetNext()) {
        $file = CFile::ResizeImageGet($ob2['VALUE'], array('width'=>90, 'height'=>90), BX_RESIZE_IMAGE_PROPORTIONAL, true);
        $file2 = CFile::GetPath($ob2['VALUE']);

        $ob['FILES'][] = ['SMALL'=>$file,'BIG'=>$file2];
    }

    $avg_rating = $avg_rating + $ob['PROPERTY_RATING_VALUE'];
    $arResult['REVIEWS_GROUP'][$ob['PROPERTY_RATING_VALUE']][] = $ob;
    $arResult['REVIEWS'][] = $ob;
}
if($avg_rating){
    $arResult['AVG_RATING'] = round($avg_rating / count($arResult['REVIEWS']),2);
}
//pre($arResult['AVG_RATING']);
$db_old_groups = CIBlockElement::GetElementGroups($arResult['ID'], true);
while($ar_group = $db_old_groups->Fetch()){
    $allSections[] = $ar_group['ID'];
}


$arSelect = Array("ID", "DATE_CREATE", "SHOW_COUNTER",  "NAME", "PREVIEW_TEXT", "PREVIEW_PICTURE", "DETAIL_PAGE_URL");
$arFilter = Array("IBLOCK_ID"=>2, "PROPERTY_VIEW_SECTIONS"=>$allSections, "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array('ID'=>'DESC'), $arFilter, false, Array("nPageSize"=>4), $arSelect);
while($ob = $res->GetNext()) {
    if($ob['PREVIEW_PICTURE']){
        $file = CFile::ResizeImageGet($ob['PREVIEW_PICTURE'], array('width'=>266, 'height'=>266), BX_RESIZE_IMAGE_PROPORTIONAL, true);
        $ob['PREVIEW_PICTURE'] = $file['src'];
    }
    $arResult['ARTICLES'][] = $ob;
}



global $APPLICATION;
$cp = $this->__component;
if (is_object($cp)) {
    $cp->arResult['ID'] = $arResult["ID"];
    $cp->arResult['IBLOCK_SECTION_ID'] = $arResult["IBLOCK_SECTION_ID"];
    $cp->SetResultCacheKeys(array('ID','IBLOCK_SECTION_ID'));
}



//$arResult["META_TAGS"]["TITLE"] = "То что хочу видеть";
//$this->__component->SetResultCacheKeys('META_TAGS');


?>