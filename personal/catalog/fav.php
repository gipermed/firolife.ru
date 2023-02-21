<? use Bitrix\Catalog\PriceTable;
use Bitrix\Main\Loader;
use Palladiumlab\Catalog\CatalogProducts;
use Palladiumlab\Catalog\Wishlist;
use Palladiumlab\Price\PriceProduct;

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetPageProperty('title', 'Избранное');

//if (!$USER->IsAuthorized())
//{
//	$_SESSION["BACKURL"] = $APPLICATION->GetCurPage();
//	LocalRedirect("/auth/");
//}
$wishList = new Wishlist();
?>

    <div class="cabinet cabinet-products">
        <div class="cabinet-section-title">
            Избранное<a href="/personal/main/" class="btn-lk-return">< Вернуться в профиль</a>
        </div>
        <div class="catalog-row catalog-row-full products-row flex-row active">
<?
            Loader::includeModule("catalog");

			$cat = new CatalogProducts();
			$favElements = $cat->get($wishList->state());
			if($favElements===null)
            {
                echo "У Вас нет избранных товаров";
            }
			foreach ($favElements as $el):
                $price = PriceProduct::getMinPriceOfProduct($el['ID']);
			?>
            <div class="products-col">
                <div class="product-item">
                    <a href="/personal/catalog/fav.php"
                       class="add-to-favorites-btn product-item-favorites active"
                       aria-label="Убрать из избранного"
                       data-product="<?=$el['ID']?>"
                       data-title="Убрать из избранного"
                       data-title-active="Убрать из избранного">
                        <svg width="24"
                             height="24">
                            <use xlink:href="#icon-like"/>
                        </svg>
                    </a>
                    <a href="<?=$el['DETAIL_PAGE_URL']?>" class="product-item-img product-item-img-no-photo">
                        <img src="<?= CFile::GetPath($el['PREVIEW_PICTURE']) ?>" alt="" width="144">
                    </a>
                    <div class="product-item-title">
                        <a href="<?=$el['DETAIL_PAGE_URL']?>"><?= $el['NAME'] ?></a>
                    </div>
                    <div class="product-item-foot">
                        <div class="product-item-prices">
                            <div class="product-item-cost">
                                <?=\CCurrencyLang::CurrencyFormat($price, "RUB");?>
                            </div>
                        </div>
                        <a href="<?=$el['DETAIL_PAGE_URL']?>" class="btn btn-full ">Посмотреть</a>
                    </div>
                </div>
            </div>
			<? endforeach ?>
        </div>
    </div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>