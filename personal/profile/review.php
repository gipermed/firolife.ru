<? require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetPageProperty("description", "Мои отзывы");
$APPLICATION->SetTitle("Мои отзывы");
$APPLICATION->SetPageProperty('title', 'Мои отзывы');

if (!$USER->IsAuthorized())
{
	$_SESSION["BACKURL"] = $APPLICATION->GetCurPage();
	LocalRedirect("/auth/");
}

$arSelect = Array("ID", "DATE_CREATE", "NAME", "PROPERTY_RATING", "PREVIEW_TEXT");
$arFilter = Array("IBLOCK_ID"=>77, "PROPERTY_USER"=>$USER->GetId(), "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array('ID'=>'DESC'), $arFilter, false, Array("nPageSize"=>8), $arSelect);
while($ob = $res->Fetch()) {
    $res2 = CIBlockElement::GetProperty(77, $ob['ID'], "sort", "asc", array("CODE" => "FILES"));
    while ($ob2 = $res2->GetNext()) {
        $file = CFile::ResizeImageGet($ob2['VALUE'], array('width'=>90, 'height'=>90), BX_RESIZE_IMAGE_PROPORTIONAL, true);
        $file2 = CFile::GetPath($ob2['VALUE']);

        $ob['FILES'][] = ['SMALL'=>$file,'BIG'=>$file2];
    }
    $arReviews[] = $ob;
}
?>

    
    <div class="cabinet cabinet-reviews cabinet-section">
        <div class="cabinet-section-title">
            Мои
            отзывы<a href="/personal/main/" class="btn-lk-return">< Вернуться в профиль</a>
        </div>
        <div class="cabinet-reviews-wrapp">
            <?foreach($arReviews as $item):?>
                <div class="product-review">
                    <div class="product-review-name"><?=$item['NAME']?></div>
                    <div class="product-review-info">
                        <div class="rating">
                            <div class="rating-state" style="width:<?=(($item['PROPERTY_RATING_VALUE']/5)*100);?>%;"></div>
                        </div>
                        <div class="product-review-date">
                            <?=FormatDate(array("" => 'j F Y'), MakeTimeStamp($item["DATE_CREATE"]), time());?>
                        </div>
                    </div>
                    <div class="product-review-text">
                        <p><?=$item['PREVIEW_TEXT']?></p>
                    </div>
                    <?if($item['FILES']):?>
                        <div class="product-review-imgs">
                            <button class="slider-arrow slider-arrow-prev" aria-label="Назад">
                                <svg width="30" height="30"><use xlink:href="#icon-arrow-down"/></svg>
                            </button>
                            <button class="slider-arrow slider-arrow-next" aria-label="Вперед">
                                <svg width="30" height="30"><use xlink:href="#icon-arrow-down"/></svg>
                            </button>
                            <div class="product-review-imgs-slider swiper-container">
                                <div class="swiper-wrapper">
                                    <?foreach($item['FILES'] as $file):?>
                                        <div class="product-review-imgs-slide swiper-slide">
                                            <a href="<?=$file['BIG']?>" data-fancybox="product-review-<?=$item['ID']?>">
                                                <img src="<?=$file['SMALL']['src']?>" alt="">
                                            </a>
                                        </div>
                                    <?endforeach;?>
                                </div>
                            </div>
                        </div>
                    <?endif;?>
                </div>
            <?endforeach;?>
        </div>
    </div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>