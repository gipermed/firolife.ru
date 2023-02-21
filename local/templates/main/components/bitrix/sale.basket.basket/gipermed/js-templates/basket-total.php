<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 */
?>
<script id="basket-total-template" type="text/html">
        <div class="cart-sidebar">
            <?/*div class="cart-total__group">
                <div class="cart-total__title">Промокод</div>
                <input type="text" class="form-control" placeholder="Промокод">
                <a href="#" class="cart-promo-link-tip">Как получить промокод?</a>
            </div>
            <div class="cart-total__group">
                <div class="cart-total__title">
                    <span>Бонусные рубли</span>
                    <div class="tip-hover">
                        <div class="tip-hover__head"><svg class="icon"><use xlink:href="#question-circle-sm"></use></svg></div>
                        <div class="tip-hover__body">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis, porro?</div>
                    </div>
                </div>
                <div class="cart-total-bonus-group">
                    <input type="text" class="form-control" placeholder="Бонусные рубли">
                    <div class="btn">Списать</div>
                </div>
                <div class="cart-bonuces-value">Нет бонусных рублей для скидки</div>
            </div>
            <div class="cart-total__group">
                <div class="cart-bonuces-reward">
                    <div class="char">Бонусы за заказ</div>
                    <div class="val">+45<div class="icon">₽</div></div>
                </div>
            </div*/?>
            <div class="cart-total__group">
                <div class="cart-total__title">Ваш заказ</div>
                <div class="order-total__list">
                    <div class="order-total__item order-total__item--total">
                        <div class="order-total__char">Сумма товаров</div>
                        <div class="order-total__val">{{{PRICE_WITHOUT_DISCOUNT_FORMATED}}}</div>
                    </div>
                    <div class="order-total__list--extra" style="display: block">

                        {{#DISCOUNT_PRICE_FORMATED}}
                        <div class="order-total__item order-total__item--total">
                            <div class="order-total__char">Скидки</div>
                            <div class="order-total__val">- {{{DISCOUNT_PRICE_FORMATED}}}</div>
                        </div>
                        {{/DISCOUNT_PRICE_FORMATED}}

                        {{#DISCOUNT_PRICE_FORMATED}}
                        <!--<div class="order-total__item">
                            <div class="order-total__char">Скидки по товарам</div>
                            <div class="order-total__val">- {{{DISCOUNT_PRICE_FORMATED}}}</div>
                        </div>-->
                        {{/DISCOUNT_PRICE_FORMATED}}

                        <?/*div class="order-total__item">
                            <div class="order-total__char">Бонусные рубли</div>
                            <div class="order-total__val">- 77 ₽</div>
                        </div*/?>
                    </div>
                   <!-- <div class="toggle-order-extra open">
                        <span>Развернуть</span>
                        <span>Свернуть</span>
                        <svg class="icon"><use xlink:href="#icon-chevron-down"></use></svg>
                    </div>-->
                </div>
            </div>
            <div class="cart-sidebar-total">
                <div class="cart-sidebar-total-title">Итого</div>
                <div class="cart-sidebar-total-sum" data-entity="basket-total-price">{{{PRICE_FORMATED}}}</div>
            </div>
            <div class="order-finish-tip">Внимательно проверьте данные заказа</div>
            <a href="/sale/" data-entity="basket-checkout-button" class="btn btn-full btn-green cart-btn">Перейти к оформлению</a>
        </div>
</script>