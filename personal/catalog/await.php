<? require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetPageProperty('title', 'Лист ожидания');

use Bitrix\Catalog\SubscribeTable;
use Bitrix\Catalog\Product\SubscribeManager;

if (!$USER->IsAuthorized())
{
	$_SESSION["BACKURL"] = $APPLICATION->GetCurPage();
	LocalRedirect("/auth/");
}

$subscribe = SubscribeTable::getList(array(
    'select' => array('*'),
    'filter' => array(
        '=USER_ID' => $USER->GetId(),
    ),
    'runtime' => array()
))->fetchAll();
foreach($subscribe as $item){
    $listRealItemId[$item['ITEM_ID']] = $item['ITEM_ID'];
    $listSubscribeId[$item['ITEM_ID']] = $item['ID'];
}

if($listSubscribeId){
    $arSelect = Array("ID", "NAME", "DETAIL_PAGE_URL",'PREVIEW_PICTURE', 'PROPERTY_CML2_LINK');
    $arFilter = Array("ID"=>$listRealItemId, "ACTIVE"=>"Y");
    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
    while($ob = $res->GetNext()) {
        $db_res = CPrice::GetList(array(),array("PRODUCT_ID" => $ob['ID']));
        if ($ar_res = $db_res->Fetch()){
            $ob['PRICE'] = $ar_res["PRICE"];
        }
        $favElements[] = $ob;

        if($ob['PROPERTY_CML2_LINK_VALUE']){
            $allProducts[$ob['PROPERTY_CML2_LINK_VALUE']] = $ob['PROPERTY_CML2_LINK_VALUE'];
        }
    }

    if($allProducts){
        $arSelect = Array('PREVIEW_PICTURE','ID');
        $arFilter = Array("ID"=>$allProducts, "ACTIVE"=>"Y");
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
        while($ob = $res->GetNext()) {
            $allProducts[$ob['ID']] = $ob;
        }
    }
}
?>
    <div class="cabinet cabinet-products">
        <div class="cabinet-section-title">
            Лист ожидания<a href="/personal/main/" class="btn-lk-return">< Вернуться в профиль</a>
        </div>
        <div class="catalog-row catalog-row-full products-row flex-row active">
            <?
            if(!$favElements){
                echo "У Вас нет товаров в листе ожидания";
            }
            foreach ($favElements as $el):
                $el_id = $allProducts[$el['PROPERTY_CML2_LINK_VALUE']]['ID'];
                if(!$el_id){
                    $el_id = $el['ID'];
                }
                ?>
                <div class="products-col">
                    <div class="product-item">
                        <a href="javascript:void(0)"
                           class="add-to-favorites-btn product-item-favorites js-add-favorites"
                           data-product="<?=$el_id?>"
                           data-title-active="Убрать из избранного"
                           data-title="Добавить в избранное"
                           aria-label="Добавить в избранное"
                        >
                            <svg width="24"
                                 height="24">
                                <use xlink:href="#icon-like"/>
                            </svg>
                        </a>
                        <a href="javascript:void(0)" data-id="<?=$listSubscribeId[$el['ID']];?>" data-product="<?=$el['ID']?>" class="delAwait product-item-favorites product-item-remove" aria-label="Убрать из листа ожидания" data-title="Убрать из листа ожидания" data-title-active="Убрать из листа ожидания">
                            <svg width="24" height="24"><use xlink:href="#icon-trash"></use></svg>
                        </a>
                        <a href="<?=$el['DETAIL_PAGE_URL']?>" class="product-item-img product-item-img-no-photo">
                            <?if(!$el['PREVIEW_PICTURE']):?>
                                <img src="<?= CFile::GetPath($allProducts[$el['PROPERTY_CML2_LINK_VALUE']]['PREVIEW_PICTURE']); ?>" alt="" width="144">
                            <?else:?>
                                <img src="<?= CFile::GetPath($el['PREVIEW_PICTURE']) ?>" alt="" width="144">
                            <?endif;?>
                        </a>
                        <div class="product-item-title">
                            <a href="<?=$el['DETAIL_PAGE_URL']?>"><?= $el['NAME'] ?></a>
                        </div>
                        <div class="product-item-foot">
                            <div class="product-item-prices">
                                <div class="product-item-cost">
                                    <?=\CCurrencyLang::CurrencyFormat($el["PRICE"], "RUB");?>
                                </div>
                            </div>
                            <a href="<?=$el['DETAIL_PAGE_URL']?>" class="btn btn-full">Посмотреть</a>
                        </div>
                    </div>
                </div>
            <? endforeach ?>
        </div>
    </div>
<?foreach($favElements as $id):?>
    <script>
        $(document).ready(function(){
            isFavoriteShow("<?=$id['ID']?>");
        })
    </script>
<?endforeach;?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>