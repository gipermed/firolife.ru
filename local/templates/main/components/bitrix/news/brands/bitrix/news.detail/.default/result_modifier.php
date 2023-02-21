<?check_prolog();

if($arResult['DETAIL_PICTURE']){
    $arResult['DETAIL_PICTURE'] = CFile::ResizeImageGet($arResult['DETAIL_PICTURE'], array('width'=>270, 'height'=>9999), BX_RESIZE_IMAGE_PROPORTIONAL, true);
}