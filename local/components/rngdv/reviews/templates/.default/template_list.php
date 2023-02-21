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
// Шаблон пагинации подключается внутри кешируемой области,
// поэтому, когда данные грузятся из кеша, скрипт шаблона пагинации не подключается
// (используется CPHPCache, а не дефолтное кеширование компонентов)
// Надо это сделать как-то по-нормальному, но пока что у меня лучше идей нет
//$this->addExternalJS($arResult["PAGEN_TEMPLATE"] . "/script.js");
?>
<? if (is_array($arResult["ITEMS"]) && count($arResult["ITEMS"]) > 0): ?>

    <div class="reviews__list js-items-<?= $arResult['NAV_NUM'] ?>">
        <!--items-<?= $arResult['NAV_NUM'] ?>-->
		<? foreach ($arResult["ITEMS"] as $arItem): ?>
            <div class="reviews__item review" data-review-id="<?= $arItem["ID"] ?>"
                 data-target="<?= $arParams["TARGET"] ?>">
                <div class="review__head">
                    <div class="review__name"><?= $arItem["NAME"] ?></div>
                    <div class="review__date"><?= FormatDate("j F Y", MakeTimeStamp($arItem["DATE_CREATE"])) ?></div>
                    <div class="review__rating rating rating--big">
						<? $w = $arItem["PROPERTIES"]["TARGET_RATE"]["VALUE"] / 5 * 100 ?>
                        <div class="rating__inner" style="width:<?= $w ?>%"></div>
                    </div>
                </div>
                <div class="review__body">
                    <div class="review__title"> Достоинства</div>
                    <div class="review__text"> <?= $arItem["PREVIEW_TEXT"] ?> </div>
                    <div class="review__title"> Недостатки</div>
                    <div class="review__text"> <?= $arItem["DETAIL_TEXT"] ?> </div>
                    <div class="review__title"> Комментарий</div>
                    <div class="review__text"> <?= $arItem["PROPERTIES"]["COMMENT"]["~VALUE"]["TEXT"] ?> </div>

                    <div class="review__rates">
						<? $goodIsActive = $arItem["PERSONAL_RATE"] == "Y" ? "active" : "" ?>
						<? $badIsActive = $arItem["PERSONAL_RATE"] == "N" ? "active" : "" ?>

                        <div class="review__like <?= $goodIsActive ?>" data-make="good"
                             onclick="rateReview(this); return false;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="">
                                <path fill="currentColor"
                                      d="M3 6a1.5 1.5 0 011.5 1.5v4a1.5 1.5 0 01-3 0v-4A1.5 1.5 0 013 6zm6.834-4c.304 0 .59.144.77.388l.082.112c.234.317.316.721.223 1.104L10.332 6h2.17a2 2 0 011.93 2.53l-.826 3A2 2 0 0111.678 13H7.5a2 2 0 01-2-2V6.806a2 2 0 01.56-1.387l2.956-3.071c.214-.222.51-.348.818-.348z"></path>
                            </svg>
                            <span class="review__rate js-review-rate"><?= $arItem["RATES"]["1"] ?: 0 ?></span>
                        </div>
                        <div class="review__dislike <?= $badIsActive ?>" data-make="bad"
                             onclick="rateReview(this); return false;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="">
                                <path fill="currentColor"
                                      d="M3 11a1.5 1.5 0 001.5-1.5v-4a1.5 1.5 0 00-3 0v4A1.5 1.5 0 003 11zm6.834 4c.304 0 .59-.144.77-.388l.082-.112a1.33 1.33 0 00.223-1.104L10.332 11h2.17a2 2 0 001.93-2.53l-.826-3A2 2 0 0011.678 4H7.5a2 2 0 00-2 2v4.194a2 2 0 00.56 1.387l2.956 3.071c.214.222.51.348.818.348z"></path>
                            </svg>
                            <span class="review__rate js-review-rate"><?= $arItem["RATES"]["0"] ?: 0 ?></span>
                        </div>
                    </div>
                </div>
            </div>
		<? endforeach ?>
        <!--items-<?= $arResult['NAV_NUM'] ?>-->
    </div>

    <!--pagen-<?= $arResult['NAV_NUM'] ?>-->
    <div class="js-pagen-<?= $arResult['NAV_NUM'] ?>">
		<?= $arResult["NAV_STRING"] ?>
        <script>
			<? include $_SERVER["DOCUMENT_ROOT"] . $arResult["PAGEN_TEMPLATE"] . "/script.js" ?>
        </script>
    </div>
    <!--pagen--<?= $arResult['NAV_NUM'] ?>-->

    <script>
        var reviewsAjaxUrl = '<?=$arResult["AJAX_URL"]?>';

		<? include $_SERVER["DOCUMENT_ROOT"] . $templateFolder . "/script_list.js" ?>
    </script>

<? else: ?>
    <div class="reviews__list reviews__list--empty">
        Для этого товара пока что нет ни одного отзыва
    </div>
<? endif ?>

