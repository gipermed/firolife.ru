<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

?>
<p>111111111111</p>11111111111111
<div class="product">
    123
    <div class="product-head">
        <div class="product-head-content">
            <h1 class="product-title section-title"><?=$arResult1["NAME"]?></h1>
            <div class="product-head-info">
                <div class="product-code">Артикул:
                    <span><?=$arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]?></span></div>
                <div class="product-reviews">
                    <i class="visible-mobile">
                        <svg width="16" height="16"><use xlink:href="#icon-star-fill"/></svg>
                    </i>
                    <div class="rating hidden-mobile">
                        <div class="rating-state" style="width:70%;"></div>
                    </div>
                    <div class="product-reviews-value">3.7</div>
                    <a href="#" class="product-reviews-count">120 отзывов</a>
                </div>
                <a href="#" class="add-to-favorites-btn product-favorites">
                    <svg width="24" height="24"><use xlink:href="#icon-like"/></svg>
                    <span>В избранное</span>
                </a>
            </div>
        </div>
        <div class="product-programm hidden-tablet">
            <div class="product-programm-icon">
                <img src="<?=SITE_TEMPLATE_PATH?>assets/img/product-programm-icon.svg" alt="">
            </div>
            <div class="product-programm-body">
                <div class="product-programm-desc">Данный товар участвует в индивидуальной программе реабилитации</div>
                <a href="#" class="product-programm-link">Подробнее&nbsp;&#62;</a>
            </div>
        </div>
    </div>
        <div class="product-gallery">

            <div class="product-gallery-nav">
                <button class="slider-arrow slider-arrow-prev" aria-label="Назад">
                    <svg width="30" height="30"><use xlink:href="#icon-arrow-down"/></svg>
                </button>
                <button class="slider-arrow slider-arrow-next" aria-label="Вперед">
                    <svg width="30" height="30"><use xlink:href="#icon-arrow-down"/></svg>
                </button>

                <div class="product-gallery-nav-slider swiper-container hidden-mobile">
                    <div class="swiper-wrapper">
                        <?if(isset($arResult["DETAIL_PICTURE"]["SRC"])):?>
                        <div class="product-gallery-nav-slide swiper-slide">
									<span>

										<img src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"
										srcset="img/product-img-small@2x.jpg 2x" alt="">
									</span>
                        </div>
                        <?endif;?>
                        <?if(isset($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"]) && is_array($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"])):?>
                            <?foreach($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $PHOTO):?>

                                <div class="product-gallery-nav-slide swiper-slide">
									<span>

										<img src="<?=CFile::GetFileArray($PHOTO)['SRC']?>"
                                             srcset="img/product-img-small@2x.jpg 2x" alt="">
									</span>
                                </div>
                                <?endforeach?>
                        <?endif?>

                    </div>
                </div>
            </div>

            <div class="product-gallery-body">
                <div class="product-item-stikers">
                    <div class="product-item-stiker product-item-stiker-sale">Скидка</div>
                </div>
                <div class="product-item-sale-profit">-25%</div>



                <div class="product-gallery-zoom hidden-mobile">
                    <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/product-zoom.svg" alt="">
                </div>
                <div class="product-gallery-slider swiper-container">
                    <div class="swiper-wrapper">
						<?if(isset($arResult["DETAIL_PICTURE"]["SRC"])):?>
                            <div class="product-gallery-slide swiper-slide">
                                <a href="img/product-img-full.jpg" class="product-img" data-fancybox="product">
                                    <img src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" srcset="img/product-img@2x.jpg 2x" alt="">
                                </a>
                            </div>

						<?endif;?>
						<?if(count($arResult["MORE_PHOTO"])>0):?>
							<?foreach($arResult["MORE_PHOTO"] as $PHOTO):?>

                                <div class="product-gallery-slide swiper-slide">
                                    <a href="img/product-img-full.jpg" class="product-img" data-fancybox="product">
                                        <img src="<?=$PHOTO["SRC"]?>" srcset="img/product-img@2x.jpg 2x" alt="">
                                    </a>
                                </div>

							<?endforeach?>
						<?endif?>
                    </div>
                </div>

            </div>
        </div>
        <div class="product-body">
            <div class="product-info product-size">
                <div class="product-info-title">Размер:</div>
                <ul class="product-size-list">
                    <li><a href="#">M</a></li>
                    <li class="active"><a href="#">L</a></li>
                    <li><a href="#">XL</a></li>
                    <li><a href="#">XXL</a></li>
                </ul>
            </div>
            <div class="product-info product-color">
                <div class="product-info-title">Цвет: <span class="product-color-selected">Салатовый</span></div>
                <ul class="product-color-list">
                    <li>
                        <a href="#" data-color="Белай" aria-label="Белай" style="color:#fff;"></a>
                    </li>
                    <li>
                        <a href="#" data-color="Оранжевый" aria-label="Оранжевый" style="color:#FFB21E;"></a>
                    </li>
                    <li class="active">
                        <a href="#" data-color="Салатовый" aria-label="Салатовый" style="color:#CDDC33;"></a>
                    </li>
                    <li>
                        <a href="#" data-color="Красный" aria-label="Красный" style="color:#ED2226;"></a>
                    </li>
                    <li>
                        <a href="#" data-color="Серый" aria-label="Серый" style="color:#C4C4C4;"></a>
                    </li>
                </ul>
            </div>
            <div class="product-info product-number">
                <div class="product-info-title">Количество:</div>
                <div class="select-number">
                    <button type="button" class="select-number-btn select-number-btn-minus disabled" aria-label="Убавить"></button>
                    <input type="text" class="select-number-input" data-min="1" data-max="99" value="1">
                    <button type="button" class="select-number-btn select-number-btn-plus" aria-label="Прибавить"></button>
                </div>
            </div>
            <div class="product-info product-price">
                <div class="product-info-title">Цена:</div>
                <div class="product-price-old">2 820 ₽</div>
                <div class="product-price-body">
                    <div class="product-cost">5 094 ₽</div>
                    <div class="product-cost-unit">2 547 ₽/ед.</div>
                </div>
            </div>
            <div class="product-info product-btns">
                <ul class="product-btns-list">



                    <li>
                        <a href="#" class="btn btn-large btn-full product-cart-btn add-to-cart-btn" data-text="Добавить в корзину" data-text-active="В корзине">Добавить в корзину</a>
                    </li>


                    <li>
                        <a href="#modal-fast-buy" class="btn btn-large btn-full btn-border btn-border-alt product-fast-buy-btn modal-open-btn">Купить в один клик</a>
                    </li>
                    <li>
                        <a href="#modal-registration" class="btn btn-large btn-full btn-border btn-border-alt product-registration-btn modal-open-btn">Зарегистистрируйтесь и получите скидку на первую покупку</a>
                    </li>
                </ul>
            </div>

            <div class="product-info product-state product-state-available">В наличии</div>




            <div class="product-info product-delivery">
                <div class="product-info-title">Доставка:</div>
                <div class="product-info-desc">
                    <p>Доставим по Москве и МО 05 марта - от 100 ₽
                    <p>Самовывоз в магазине в Москве 04 марта - бесплатно
                    <p>В пункте выдачи 05 марта - от 1 ₽
                </div>
            </div>
            <div class="product-info product-short-desc">
                <div class="product-info-title">Кратко о товаре:</div>
                <div class="product-info-desc">
                    <p>• С эффектом памяти;
                    <p>• Пенополиуретановый наполнитель;
                    <p>• Съёмная наволочка.
                </div>
            </div>
            <div class="product-info product-brand">
                <div class="product-info-title">Бренд:</div>
                <a href="#" class="product-brand-logo">
                    <img src="<?=SITE_TEMPLATE_PATH?>assets/img/product-brand-logo.svg" alt="">
                </a>
            </div>
        </div>
</div>
<?php var_dump($arResult['SKU_PROPS']);?>





