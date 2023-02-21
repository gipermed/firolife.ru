<?php
    require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
    $APPLICATION->SetTitle('DEV');
?>

<br><br><br><br><br>

<div class="cabinet-profile-form-row flex-row">
    <div class="cabinet-profile-form-col-main flex-row-item">
        <label class="form-block">
            <a href="javascript:void(0)" class="js-open-profile-delete">
                <button class="cabinet-profile-del-btn btn submit">Удалить профиль</button>
            </a>
        </label>
    </div>

    <div class="custom-modal modal-profile-delete">
        <div class="custom-modal__content">
            <div class="custom-modal__close"><svg class="icon"><use xlink:href="#icon-close"></use></svg></div>
            <div class="custom-modal__title">Вы действительно хотите удалить свой профиль?</div>
            <div class="custom-modal__description">
                После удаления вы не сможете восстановить свой профиль. Ваша история заказов будет очищена, информация удалена.
            </div>
            <div class="custom-modal__footer">
                <a href="#" class="btn btn-confirm">Да, удалить</a>
                <a href="#" class="btn btn-cancel">Нет, я не хочу удалять</a>
            </div>
        </div>
        <div class="custom-modal__bg"></div>
    </div>
</div>

<br><br><br><br><br>

<div class="container">
    <div class="custom-file__list">
        <label class="custom-file__item">
            <span class="custom-file__preview"></span>
            <input class="custom-file__value" name="custom-file-val-1" type="file" accept="image/*">
        </label>
        <label class="custom-file__item">
            <span class="custom-file__preview"></span>
            <input class="custom-file__value" name="custom-file-val-2" type="file" accept="image/*">
        </label>
        <label class="custom-file__item">
            <span class="custom-file__preview"></span>
            <input class="custom-file__value" name="custom-file-val-3" type="file" accept="image/*">
        </label>
        <label class="custom-file__item">
            <span class="custom-file__preview"></span>
            <input class="custom-file__value" name="custom-file-val-4" type="file" accept="image/*">
        </label>
        <label class="custom-file__item">
            <span class="custom-file__preview"></span>
            <input class="custom-file__value" name="custom-file-val-5" type="file" accept="image/*">
        </label>
    </div>
</div>

<br><br><br><br><br>

<div class="section product-tabs-section">
    <div class="container">
        <div class="product-tabs-nav-wrapp">
            <ul class="product-tabs-nav tabs-nav" data-tabs="#product-tabs">
                <li class="active"><a href="#product-tab-2">Отзывы (Написать для незарегистрированных)</a></li>
            </ul>
        </div>
        <div id="product-tabs" class="tabs-wrapp">
            <div id="product-tab-2" class="tab-block active">
                <div class="product-tab-section">
                    <div class="custom-modal modal-user-enter">
                        <div class="custom-modal__content">
                            <div class="custom-modal__close"><svg class="icon"><use xlink:href="#icon-close"></use></svg></div>
                            <div class="custom-modal__description">
                                Для того, чтобы написать отзыв вам необходимо войти в свой аккаунт или зарегистрироваться на сайте
                            </div>
                            <div class="custom-modal__footer">
                                <a href="#">Регистрация</a> <span>|</span> <a href="#">Вход</a>
                            </div>
                        </div>
                        <div class="custom-modal__bg"></div>
                    </div>
                    <div class="tab-product-reviews__head">
                        <div class="tab-product-reviews__title">
                            <div class="product-tab-title product-tab-review-title">Все отзывы <span>(0)</span></div>
                            <a href="#" class="js-open-user-enter btn btn-review-toggle desktop"><span>Написать отзыв</span><span>Закрыть отзыв</span></a>
                        </div>
                        <div class="tab-product-reviews__main">
                            <div class="reviews-main">
                                <div class="reviews-main__head">
                                    <div class="review-main__val">3.7</div>
                                    <div class="review-main__description">На основании 120 отзывов</div>
                                    <div class="review-main__stars">
                                        <div class="rating"><div class="rating-state" style="width:70%;"></div></div>
                                    </div>
                                </div>
                                <div class="reviews-main__values">
                                    <div class="review-main__value">
                                        <div class="review-main__grade">5</div>
                                        <div class="review-main__slider"><div class="review-main__slider-track" style="width: 25%"></div></div>
                                        <div class="review-main__percentage">25%</div>
                                    </div>
                                    <div class="review-main__value">
                                        <div class="review-main__grade">4</div>
                                        <div class="review-main__slider"><div class="review-main__slider-track" style="width: 45%"></div></div>
                                        <div class="review-main__percentage">45%</div>
                                    </div>
                                    <div class="review-main__value">
                                        <div class="review-main__grade">3</div>
                                        <div class="review-main__slider"><div class="review-main__slider-track" style="width: 45%"></div></div>
                                        <div class="review-main__percentage">30%</div>
                                    </div>
                                    <div class="review-main__value">
                                        <div class="review-main__grade">2</div>
                                        <div class="review-main__slider"><div class="review-main__slider-track" style="width: 0%"></div></div>
                                        <div class="review-main__percentage">0</div>
                                    </div>
                                    <div class="review-main__value">
                                        <div class="review-main__grade">1</div>
                                        <div class="review-main__slider"><div class="review-main__slider-track" style="width: 0%"></div></div>
                                        <div class="review-main__percentage">0</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="js-open-user-enter btn btn-review-toggle mobile"><span>Написать отзыв</span><span>Закрыть отзыв</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<br><br><br><br><br>

<div class="section product-tabs-section">
    <div class="container">
        <div class="product-tabs-nav-wrapp">
            <ul class="product-tabs-nav tabs-nav" data-tabs="#product-tabs">
                <li class="active"><a href="#product-tab-2">Отзывы (0)</a></li>
                <li><a href="#product-tab-4">Статьи</a></li>
            </ul>
        </div>
        <div id="product-tabs" class="tabs-wrapp">
            <div id="product-tab-2" class="tab-block active">
                <div class="product-tab-section">
                    <div class="tab-product-reviews__head">
                        <div class="tab-product-reviews__title">
                            <div class="product-tab-title product-tab-review-title">Все отзывы <span>(0)</span></div>
                            <a href="#" class="btn btn-review-toggle desktop"><span>Написать отзыв</span><span>Закрыть отзыв</span></a>
                        </div>
                        <div class="tab-product-reviews__main">
                            <div class="reviews-main">
                                <div class="reviews-main__head">
                                    <div class="review-main__val">3.7</div>
                                    <div class="review-main__description">На основании 120 отзывов</div>
                                    <div class="review-main__stars">
                                        <div class="rating"><div class="rating-state" style="width:70%;"></div></div>
                                    </div>
                                </div>
                                <div class="reviews-main__values">
                                    <div class="review-main__value">
                                        <div class="review-main__grade">5</div>
                                        <div class="review-main__slider"><div class="review-main__slider-track" style="width: 25%"></div></div>
                                        <div class="review-main__percentage">25%</div>
                                    </div>
                                    <div class="review-main__value">
                                        <div class="review-main__grade">4</div>
                                        <div class="review-main__slider"><div class="review-main__slider-track" style="width: 45%"></div></div>
                                        <div class="review-main__percentage">45%</div>
                                    </div>
                                    <div class="review-main__value">
                                        <div class="review-main__grade">3</div>
                                        <div class="review-main__slider"><div class="review-main__slider-track" style="width: 45%"></div></div>
                                        <div class="review-main__percentage">30%</div>
                                    </div>
                                    <div class="review-main__value">
                                        <div class="review-main__grade">2</div>
                                        <div class="review-main__slider"><div class="review-main__slider-track" style="width: 0%"></div></div>
                                        <div class="review-main__percentage">0</div>
                                    </div>
                                    <div class="review-main__value">
                                        <div class="review-main__grade">1</div>
                                        <div class="review-main__slider"><div class="review-main__slider-track" style="width: 0%"></div></div>
                                        <div class="review-main__percentage">0</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="btn btn-review-toggle mobile"><span>Написать отзыв</span><span>Закрыть отзыв</span></a>
                    </div>
                    <form action="#" method="POST" class="new-review-add">
                        <div class="form-group form-group-review">
                            <div class="form-group-title">Ваша оценка</div>
                            <ul class="rating-stars js-rating-star">
                                <li class="active"><a href="javascript:void(0)">1</a></li>
                                <li class="active"><a href="javascript:void(0)">2</a></li>
                                <li class="active"><a href="javascript:void(0)">3</a></li>
                                <li class="active"><a href="javascript:void(0)">4</a></li>
                                <li class="active"><a href="javascript:void(0)">5</a></li>
                            </ul>
                            <input type="hidden" name="rating-value" class="rating-value" value="5">
                        </div>
                        <div class="form-group form-group-review-message">
                            <div class="form-group-header">
                                <div class="form-group-title">Отзыв</div>
                                <div class="message-length">Введено символов <span class="review-current-symbols">0</span> / 1000</div>
                            </div>
                            <textarea class="form-control js-review-message" name="review-message" rows="7" placeholder="Текст отзыва"></textarea>
                        </div>
                        <div class="form-group form-group--photos">
                            <div class="form-group-title">Загрузите фотографии</div>
                            <label class="label-review-photo">
                                <div class="review-item-photos">
                                    <div class="review-item__photo current-photo"></div>
                                    <div class="review-item__photo"></div>
                                    <div class="review-item__photo"></div>
                                    <div class="review-item__photo"></div>
                                    <div class="review-item__photo"></div>
                                </div>
                                <input type="file" name="reviews-photo" class="reviews-photo__value" multiple accept="image/*">
                            </label>
                            <div class="review-photo-formats"><span>Поддерживаемые форматы:</span> JPG, JPEG, PNG</div>
                        </div>

                        <div class="form-footer">
                            <input type="submit" class="btn btn-form-submit" value="Отправить">
                            <input type="reset" class="btn new-review-cancel" value="Отменить">
                        </div>
                        <div class="form-extra-tip">Размещая отзыв на сайте, вы даёте согласие на использование данных отзыва на сторонних ресурсах</div>
                    </form>
                    <div class="product-tab-reviews">
                        <div class="product-review">
                            <div class="product-review-name">Кирилл Сергеев</div>
                            <div class="product-review-info">
                                <div class="rating">
                                    <div class="rating-state" style="width:70%;"></div>
                                </div>
                                <div class="product-review-date">
                                    13 марта 2021 г.
                                </div>
                            </div>
                            <div class="product-review-text">
                                <p>Очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец, очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец.</p>
                            </div>
                        </div>
                        <div class="product-review">
                            <div class="product-review-name">Кирилл Сергеев</div>
                            <div class="product-review-info">
                                <div class="rating">
                                    <div class="rating-state" style="width:70%;"></div>
                                </div>
                                <div class="product-review-date">
                                    13 марта 2021 г.
                                </div>
                            </div>
                            <div class="product-review-text">
                                <p>Очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец, очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец.</p>
                            </div>
                        </div>
                        <div class="product-review">
                            <div class="product-review-name">Кирилл Сергеев</div>
                            <div class="product-review-info">
                                <div class="rating">
                                    <div class="rating-state" style="width:70%;"></div>
                                </div>
                                <div class="product-review-date">
                                    13 марта 2021 г.
                                </div>
                            </div>
                            <div class="product-review-text">
                                <p>Очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец, очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец.</p>
                            </div>
                        </div>
                        <div class="product-review">
                            <div class="product-review-name">Кирилл Сергеев</div>
                            <div class="product-review-info">
                                <div class="rating">
                                    <div class="rating-state" style="width:70%;"></div>
                                </div>
                                <div class="product-review-date">
                                    13 марта 2021 г.
                                </div>
                            </div>
                            <div class="product-review-text">
                                <p>Очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец, очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец.</p>
                            </div>
                        </div>
                        <div class="product-review">
                            <div class="product-review-name">Кирилл Сергеев</div>
                            <div class="product-review-info">
                                <div class="rating">
                                    <div class="rating-state" style="width:70%;"></div>
                                </div>
                                <div class="product-review-date">
                                    13 марта 2021 г.
                                </div>
                            </div>
                            <div class="product-review-text">
                                <p>Очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец, очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец.</p>
                            </div>
                        </div>
                        <div class="product-review">
                            <div class="product-review-name">Кирилл Сергеев</div>
                            <div class="product-review-info">
                                <div class="rating">
                                    <div class="rating-state" style="width:70%;"></div>
                                </div>
                                <div class="product-review-date">
                                    13 марта 2021 г.
                                </div>
                            </div>
                            <div class="product-review-text">
                                <p>Очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец, очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец.</p>
                            </div>
                        </div>
                        <div class="product-review">
                            <div class="product-review-name">Кирилл Сергеев</div>
                            <div class="product-review-info">
                                <div class="rating">
                                    <div class="rating-state" style="width:70%;"></div>
                                </div>
                                <div class="product-review-date">
                                    13 марта 2021 г.
                                </div>
                            </div>
                            <div class="product-review-text">
                                <p>Очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец, очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец.</p>
                            </div>
                        </div>
                        <div class="product-review">
                            <div class="product-review-name">Кирилл Сергеев</div>
                            <div class="product-review-info">
                                <div class="rating">
                                    <div class="rating-state" style="width:70%;"></div>
                                </div>
                                <div class="product-review-date">
                                    13 марта 2021 г.
                                </div>
                            </div>
                            <div class="product-review-text">
                                <p>Очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец, очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец.</p>
                                <p>Очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец, очень удобная подушка, со временем перестала болеть шея, сплю всю ночь как младенец.</p>
                            </div>
                            <div class="product-review-imgs">
                                <button class="slider-arrow slider-arrow-prev" aria-label="Назад">
                                    <svg width="30" height="30"><use xlink:href="#icon-arrow-down"/></svg>
                                </button>
                                <button class="slider-arrow slider-arrow-next" aria-label="Вперед">
                                    <svg width="30" height="30"><use xlink:href="#icon-arrow-down"/></svg>
                                </button>
                                <div class="product-review-imgs-slider swiper-container">
                                    <div class="swiper-wrapper">
                                        <div class="product-review-imgs-slide swiper-slide">
                                            <a href="/local/templates/main/assets/img/product-img-full.jpg" data-fancybox="product-review-2">
                                                <img src="/local/templates/main/assets/img/product-img-small.jpg" srcset="/local/templates/main/assets/img/product-img-small@2x.jpg 2x" alt="">
                                            </a>
                                        </div>
                                        <div class="product-review-imgs-slide swiper-slide">
                                            <a href="/local/templates/main/assets/img/product-img-full.jpg" data-fancybox="product-review-2">
                                                <img src="/local/templates/main/assets/img/product-img-small.jpg" srcset="/local/templates/main/assets/img/product-img-small@2x.jpg 2x" alt="">
                                            </a>
                                        </div>

                                        <div class="product-review-imgs-slide swiper-slide">
                                            <a href="/local/templates/main/assets/img/product-img-full.jpg"
                                               data-fancybox="product-review-2">
                                                <img src="/local/templates/main/assets/img/product-img-small.jpg" srcset="/local/templates/main/assets/img/product-img-small@2x.jpg 2x" alt="">
                                            </a>
                                        </div>

                                        <div class="product-review-imgs-slide swiper-slide">
                                            <a href="/local/templates/main/assets/img/product-img-full.jpg"
                                               data-fancybox="product-review-2">
                                                <img src="/local/templates/main/assets/img/product-img-small.jpg" srcset="/local/templates/main/assets/img/product-img-small@2x.jpg 2x" alt="">
                                            </a>
                                        </div>

                                        <div class="product-review-imgs-slide swiper-slide">
                                            <a href="/local/templates/main/assets/img/product-img-full.jpg"
                                               data-fancybox="product-review-2">
                                                <img src="/local/templates/main/assets/img/product-img-small.jpg" srcset="/local/templates/main/assets/img/product-img-small@2x.jpg 2x" alt="">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="read-more-btn-wrapp reviews-load-more">
                        <a href="#" class="btn read-more-btn">Показать ещё</a>
                    </div>
                </div>
            </div>
            <div id="product-tab-4" class="tab-block">
                <div class="product-tab-section">
                    <div class="product-tab-title">Статьи</div>
                    <div class="articles-row flex-row">
                        <div class="articles-col flex-row-item">
                            <div class="article-item">
                                <a href="#" class="item-link" aria-label="Читать статью"></a>
                                <div class="article-item-img">
                                    <span><img src="/local/templates/main/assets/img/article-img-1.jpg" srcset="/local/templates/main/assets/img/article-img-1.jpg 2x" alt=""></span>
                                </div>
                                <div class="article-item-body">
                                    <div class="article-item-title">Ортопедические подушки, основные критерии выбора.</div>
                                    <div class="article-item-desc">Статья про бандажи противогрыжевые</div>
                                    <div class="article-item-foot">
                                        <div class="article-item-views">
                                            <svg width="20" height="20">
                                                <use xlink:href="#icon-eye"></use>
                                            </svg>
                                            <span class="js-view-counter" data-item-id="57634">44</span>
                                        </div>
                                        <div class="article-item-btn">Читать ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="articles-col flex-row-item">
                            <div class="article-item">
                                <a href="#" class="item-link" aria-label="Читать статью"></a>
                                <div class="article-item-img">
                                    <span><img src="/local/templates/main/assets/img/article-img-2.jpg" srcset="/local/templates/main/assets/img/article-img-2.jpg 2x" alt=""></span>
                                </div>
                                <div class="article-item-body">
                                    <div class="article-item-title">Осанка у ребенка. Как бороться с искривлением позвоночника у детей? Методы решения проблемы.</div>
                                    <div class="article-item-desc">Статья про бандажи противогрыжевые</div>
                                    <div class="article-item-foot">
                                        <div class="article-item-views">
                                            <svg width="20" height="20">
                                                <use xlink:href="#icon-eye"></use>
                                            </svg>
                                            <span class="js-view-counter" data-item-id="5">48</span>
                                        </div>
                                        <div class="article-item-btn">Читать ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="articles-col flex-row-item">
                            <div class="article-item">
                                <a href="#" class="item-link" aria-label="Читать статью"></a>
                                <div class="article-item-img">
                                    <span><img src="/local/templates/main/assets/img/article-item-img-3.jpg" srcset="/local/templates/main/assets/img/article-item-img-3.jpg 2x" alt=""></span>
                                </div>
                                <div class="article-item-body">
                                    <div class="article-item-title">Ортопедические подушки, основные критерии выбора.</div>
                                    <div class="article-item-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Leo ac turpis nunc bibendum quam venenatis. Nunc amet, ullamcorper in nunc.</div>
                                    <div class="article-item-foot">
                                        <div class="article-item-views">
                                            <svg width="20" height="20">
                                                <use xlink:href="#icon-eye"></use>
                                            </svg>
                                            <span class="js-view-counter" data-item-id="4">116</span>
                                        </div>
                                        <div class="article-item-btn">Читать ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="articles-col flex-row-item">
                            <div class="article-item">
                                <a href="#" class="item-link" aria-label="Читать статью"></a>
                                <div class="article-item-img">
                                    <span><img src="/local/templates/main/assets/img/article-item-img-4.jpg" srcset="/local/templates/main/assets/img/article-item-img-4.jpg 2x" alt=""></span>
                                </div>
                                <div class="article-item-body">
                                    <div class="article-item-title">Осанка у ребенка. Как бороться с искривлением позвоночника у детей? Методы решения проблемы.</div>
                                    <div class="article-item-desc">Статья про бандажи противогрыжевые</div>
                                    <div class="article-item-foot">
                                        <div class="article-item-views">
                                            <svg width="20" height="20">
                                                <use xlink:href="#icon-eye"></use>
                                            </svg>
                                            <span class="js-view-counter" data-item-id="5">48</span>
                                        </div>
                                        <div class="article-item-btn">Читать ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<br><br><br><br><br>

<div class="cabinet cabinet-products">
    <div class="cabinet-section-title">Лист ожидания</div>
    <div class="catalog-row catalog-row-full products-row flex-row active">
        <div class="products-col">
            <div class="product-item">
                <a href="#" class="add-to-favorites-btn product-item-favorites active" aria-label="Убрать из избранного" data-title="Убрать из избранного" data-title-active="Убрать из избранного">
                    <svg width="24" height="24"><use xlink:href="#icon-like"></use></svg>
                </a>
                <a href="#" class="product-item-favorites product-item-remove" aria-label="Убрать из листа ожидания" data-title="Убрать из листа ожидания" data-title-active="Убрать из листа ожидания">
                    <svg width="24" height="24"><use xlink:href="#icon-trash"></use></svg>
                </a>
                <a href="#" class="product-item-img">
                    <span class="product-item-image-original" style="background-image: url('/local/templates/main/components/bitrix/catalog.section/main/images/no_photo.png'); ">
                    </span>
                </a>
                <div class="product-item-title">
                    <a href="#">Чулки ID-315, XL(V), 2 класс, норм., закрытый носок LUOMMA IDEALISTA Черный</a>
                </div>
                <div class="product-item-foot">
                    <div class="product-item-prices">
                        <div class="product-item-cost">3&nbsp;720 ₽</div>
                    </div>
                    <a href="#" class="btn btn-full ">Посмотреть</a>
                </div>
            </div>
        </div>
        <div class="products-col">
            <div class="product-item">
                <a href="#" class="add-to-favorites-btn product-item-favorites" aria-label="Убрать из избранного" data-title="Убрать из избранного" data-title-active="Убрать из избранного">
                    <svg width="24" height="24"><use xlink:href="#icon-like"></use></svg>
                </a>
                <a href="#" class="product-item-favorites product-item-remove" aria-label="Убрать из листа ожидания" data-title="Убрать из листа ожидания" data-title-active="Убрать из листа ожидания">
                    <svg width="24" height="24"><use xlink:href="#icon-trash"></use></svg>
                </a>
                <a href="#" class="product-item-img">
                    <span class="product-item-image-original" style="background-image: url('/local/templates/main/components/bitrix/catalog.section/main/images/no_photo.png'); ">
                    </span>
                </a>
                <div class="product-item-title">
                    <a href="#">Чулки 221_телесный, размер 4 (2класс компр./23-32мм рт.ст.) ERGOFORMA</a>
                </div>
                <div class="product-item-foot">
                    <div class="product-item-prices">
                        <div class="product-item-cost">1&nbsp;519 ₽</div>
                    </div>
                    <a href="#" class="btn btn-full ">Посмотреть</a>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>