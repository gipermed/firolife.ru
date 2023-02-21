<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$hasReviews = is_array($arResult["SUMMARY"]["AVG"]);
?>
<div class="reviews">
    <div class="reviews__summary <?= $hasReviews ? "" : "reviews__summary--no-rating" ?>">

        <div class="reviews__rating">
            <div class="reviews__rating-stars">
                <div class="rating rating--giant">
                    <div class="rating__inner"
                         style="width: <?= $arResult["SUMMARY"]["AVG"]["PERCENT"] ?: 0 ?>%;"></div>
                </div>
            </div>
			<? if ($hasReviews): ?>
                <div class="reviews__rating-digits"> <?= $arResult["SUMMARY"]["AVG"]["NUMBER"] ?> / 5</div>
			<? else: ?>
                <div class="reviews__no-rating">Нет оценок</div>
			<? endif ?>
        </div>


		<? if ($hasReviews): ?>
            <div class="reviews__count-list review-cnt">
				<? for ($rate = 5; $rate > 0; $rate--): ?>
                    <div class="review-cnt__item">
                        <div class="review-cnt__title"><?= $rate ?> <?= pw($rate, "звезда", "звезды", "звезд") ?></div>
                        <div class="review-cnt__bar">
                            <div class="review-cnt__progress"
                                 style="width: <?= $arResult["SUMMARY"]["ITEMS"][$rate]["PERCENT"] ?>%"></div>
                        </div>
                        <div class="review-cnt__count"><?= $arResult["SUMMARY"]["ITEMS"][$rate]["CNT"] ?></div>
                    </div>
				<? endfor ?>
            </div>
		<? endif ?>
        <div class="reviews__add-review">
            <div class="v-btn v-btn--red v-btn--lg v-btn--w100"
                 data-modal="<?= $arResult["AJAX_URL"] ?>?action=popup&target=<?= $arParams["TARGET"] ?>">
                <div class="v-btn__text">
                    Написать отзыв
                </div>
            </div>
        </div>
    </div>
    <div class="reviews__sort-wrap">
        <div class="reviews__sort ddl js-reviews-sort">
            <div class="ddl__text"></div>
            <svg class="ddl__arr" xmlns="http://www.w3.org/2000/svg">
                <g fill="none" fill-rule="evenodd">
                    <path d="M0 0h16v16H0z"></path>
                    <path d="M5.22 3.28a.75.75 0 011.06-1.06l5.25 5.25a.75.75 0 010 1.06l-5.25 5.25a.75.75 0 01-1.06-1.06L9.94 8 5.22 3.28z"
                          fill="currentColor" fill-rule="nonzero"></path>
                </g>
            </svg>
            <div class="ddl__list">
				<? foreach ($arParams["SORT"] as $arSort): ?>
                    <div class="ddl__item" data-value="<?= $arSort["CODE"] ?>"><?= $arSort["NAME"] ?></div>
				<? endforeach; ?>
            </div>
        </div>
    </div>

    <div class="js-reviews-list"></div>
</div>

<script>
    $(function () {
        $(".js-product-top-rating").attr("title", '<?=$arResult["SUMMARY"]["AVG"]["NUMBER"] ?: 0?>');
        $(".js-product-top-rating > *").css("width", '<?=$arResult["SUMMARY"]["AVG"]["PERCENT"] ?: 0?>%');

        $(".js-product-top-review").on("click", function (e) {
            e.preventDefault();

            $.arcticmodal({
                type: 'ajax',
                url: '<?=$arResult["AJAX_URL"]?>?action=popup&target=<?=$arParams["TARGET"]?>',
            });
        });
    });

    $(".js-reviews-sort").on("select", function (e, val) {
        var url = '<?=$arResult["AJAX_URL"]?>';
        if (window.location.href.indexOf("clear_cache=Y") > 0) {
            url += "?clear_cache=Y";
        }

        $.ajax({
            url: url,
            data: {
				<?$arParams["COMPONENT_TEMPLATE"] = $templateName?>
                params: '<?=(new ComponentParamsSerializer)->serialize($arParams)?>',
                sort: val
            },
            success: function (response) {
                $(".js-reviews-list").html(response);
            }
        });
    });
</script>