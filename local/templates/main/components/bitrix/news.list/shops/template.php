<?php check_prolog();

use Palladiumlab\Support\Util\Str;

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
$mag = 0;

if (!empty($arResult["ITEMS"])) { ?>
    <div class="contacts-section section">
        <div class="content-title">Магазин Firolife</div>
        <?php foreach ($arResult["ITEMS"] as $shop) {
             $mag ++;
            $this->addEditAction($shop['ID'], $shop['EDIT_LINK'], CIBlock::getArrayById($shop["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->addDeleteAction($shop['ID'], $shop['DELETE_LINK'], CIBlock::getArrayById($shop["IBLOCK_ID"], "ELEMENT_DELETE"), ["CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]);

            [$name, $phone, $workTime, $address, $metro, $metroColor, $gallery, $longitude, $latitude, $picture] = [
                $shop['NAME'],

                $shop['DISPLAY_PROPERTIES']['PHONE']['~VALUE'],
                $shop['DISPLAY_PROPERTIES']['WORK_TIME']['~VALUE'],
                $shop['DISPLAY_PROPERTIES']['ADDRESS']['~VALUE'],
                $shop['DISPLAY_PROPERTIES']['METRO']['~VALUE'],
                $shop['DISPLAY_PROPERTIES']['METRO_COLOR']['~VALUE'],
                $shop['DISPLAY_PROPERTIES']['GALLERY']['FILE_VALUE'],
                $shop['DISPLAY_PROPERTIES']['LONGITUDE']['~VALUE'],
                $shop['DISPLAY_PROPERTIES']['LATITUDE']['~VALUE'],

                $shop['PREVIEW_PICTURE']['SRC'],
            ];

            if (!empty($gallery['SRC'])) {
                $gallery = [$gallery];
            }

            $firstGalleryItem = array_shift($gallery);

            ?>
            <div class="contacts-shop section" id="shop_<?=$shop['PROPERTIES']['ID_SHOP']['VALUE']?>" data-lat="<?= $latitude ?>" data-lng="<?= $longitude ?>">
                <div class="contacts-shop-row flex-row">
                    <div class="contacts-shop-col flex-row-item">
                        <div class="contacts-shop-title"><?= $name ?></div>
                        <div class="contacts-shop-row flex-row">
                            <div class="contacts-shop-col flex-row-item">
                                <ul class="contacts-shop-info">
                                    <li>
                                        Телефон:
                                        <a href="tel:<?= Str::phone($phone) ?>"><?= $phone ?></a>
                                    </li>
                                    <li>
                                        <p>Режим работы:</p>
                                        <p><?= $workTime ?></p>
                                    </li>
                                    <li>
                                        Адрес: <b class="contacts-shop-address"><?= $address ?></b>
                                    </li>
                                    <li>
                                        <div class="contacts-shop-metro">
                                            <i style="color:<?= $metroColor ?>"></i>
                                            <?= $metro ?>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="contacts-shop-col hidden-tablet">
                                <a href="<?= $firstGalleryItem['SRC'] ?>"
                                   class="contacts-shop-img cover-img" data-fancybox="shop-<?= $shop['ID'] ?>">
                                    <img src="<?= $firstGalleryItem['SRC'] ?>" srcset="<?= $firstGalleryItem['SRC'] ?>"
                                         alt="">
                                </a>
                            </div>
                        </div>
                        <div class="contacts-shop-slider swiper-container">
                            <button class="slider-arrow slider-arrow-prev" aria-label="Назад">
                                <svg width="30" height="30">
                                    <use xlink:href="#icon-arrow-down"/>
                                </svg>
                            </button>
                            <button class="slider-arrow slider-arrow-next" aria-label="Вперед">
                                <svg width="30" height="30">
                                    <use xlink:href="#icon-arrow-down"/>
                                </svg>
                            </button>
                            <div class="swiper-wrapper">
                                <div class="contacts-shop-slide swiper-slide visible-tablet">
                                    <a href="<?= $firstGalleryItem['SRC'] ?>" class="contacts-shop-img cover-img">
                                        <img src="<?= $firstGalleryItem['SRC'] ?>"
                                             srcset="<?= $firstGalleryItem['SRC'] ?>" alt="">
                                    </a>
                                </div>
                                <?php foreach ($gallery as $galleryPicture) { ?>
                                    <div class="contacts-shop-slide swiper-slide">
                                        <a href="<?= $galleryPicture['SRC'] ?>" class="contacts-shop-img cover-img"
                                           data-fancybox="shop-<?= $shop['ID'] ?>">
                                            <img src="<?= $galleryPicture['SRC'] ?>"
                                                 srcset="<?= $galleryPicture['SRC'] ?>" alt="">
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="contacts-shop-col flex-row-item">
                        <div class="contacts-shop-schema">
                            <div class="contacts-shop-schema-title">Как добраться до магазина</div>
                            <a href="#" class="contacts-shop-schema-print hidden-tablet">
                                <svg width="20" height="20">
                                    <use xlink:href="#icon-print"/>
                                </svg>
                                <span>Распечатать схему</span>
                            </a>
                        </div>
                        <div class="contacts-shop-schema-img">
                            <a href="<?= $picture ?>" class="contacts-shop-img cover-img" data-fancybox>
                                <img src="<?= $picture ?>" srcset="<?= $picture ?>" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($mag == 1) { ?>
                <div class="content-title">Магазины партнеры</div>
            <?php } ?>
        <?php } ?>
    </div>
<?php } ?>