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
$this->setFrameMode(false);
?>
<div class="modals-content -fast-order -fast-order-extended">
    <div class="header">
        Заявка на покупку товара

        <svg class="icon-svg -cross" viewBox="0 0 32 32" id="cross" width="100%" height="100%"
             onclick="$.arcticmodal('close')">
            <path d="M19.8,16l11.5,11.4c1.1,1,1.1,2.7,0,3.8c-1,1-2.8,1-3.8,0L16,19.8L4.6,31.1c-1.1,1-2.8,1-3.8,0c-1-1-1-2.7,0-3.8L12.2,16L0.8,4.7c-1-1-1-2.7,0-3.8c1.1-1,2.8-1,3.8,0L16,12.2L27.4,0.8c1-1,2.8-1,3.8,0c1.1,1,1.1,2.7,0,3.8L19.8,16z"></path>
        </svg>
    </div>
    <div class="content ns">
        <div class="form-success hidden">
            <div class="fs-20">Спасибо! Номер Вашего заказа: <span class="order-number"></span></div>
        </div>

        <form class="b-form b-form--w20by80 js-sale-order-quick-product-form" method="post">
            <input type="hidden" name="component" value="<?= $arResult["COMPONENT"] ?>">
            <input type="hidden" name="form_submitted" value="Y">
			<?= bitrix_sessid_post() ?>

            <div class="fs-13 mb-15">Заполните форму быстрого заказа, наши менеджеры скоро свяжутся с вами</div>

            <div class="b-form__group">
                <div class="b-form__group-label"></div>
                <div class="b-form__group-wrap errors">

                </div>
            </div>

            <div class="b-form__group">
                <label class="b-form__group-label" for="NAME">
                    Имя
                </label>
                <div class="b-form__group-wrap">
                    <input id="NAME" name="NAME" type="text" class="b-form__group-input" value=""
                           placeholder="Введите Ваше имя">
                </div>
            </div>

            <div class="b-form__group">
                <label class="b-form__group-label" for="PHONE">
                    Телефон
                </label>
                <div class="b-form__group-wrap">
                    <input id="PHONE" name="PHONE" type="tel" class="b-form__group-input" value=""
                           placeholder="+7(___)___-__-__">
                </div>
            </div>

            <div class="b-form__group">
                <label class="b-form__group-label" for="EMAIL">
                    Email
                </label>
                <div class="b-form__group-wrap">
                    <input id="EMAIL" name="EMAIL" type="text" class="b-form__group-input" value=""
                           placeholder="Укажите Ваш e-mail">
                </div>
            </div>


            <div class="b-form__group">
                <div class="b-form__group-label"></div>
                <div class="b-form__group-wrap">
                    <input type="submit" class="v-btn v-btn--sm v-btn--red" name="submit" value="Оформить заказ">
                </div>
            </div>
        </form>
    </div>
</div>


<style>
    .modals-content {
        display: flex;
        flex-direction: column;
        align-self: center;
        box-shadow: 0 1px 4px 0 rgba(0, 0, 0, .6);
        border-radius: 6px;
        margin: auto;
        width: 500px;
        background-color: #fff;
    }


    .modals-content .header {
        display: flex;
        justify-content: space-between;
        padding-left: 20px;
        border-radius: 6px 6px 0 0;
        background-color: #e9e9e9;

        line-height: 44px;
        font-size: 18px;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    .modals-content .header .-cross {
        margin: 16px 16px 0 0;
        width: 12px;
        height: 12px;
        fill: #999;
        cursor: pointer;
    }

    .modals-content .header .-cross:hover {
        fill: #d60000;
    }

    .modals-content.-fast-order .modal-row {
        border-bottom: 1px solid #ccc;
    }

    .modals-content.-fast-order .content {
        display: flex;
        flex-direction: column;
        padding: 20px;
    }

    .modals-content .errors {
        color: red;
    }

    @media (max-width: 500px) {
        .modals-content {
            width: 100%;
        }
    }
</style>


<script>
    $(function () {
        setInputmask('.js-sale-order-quick-product-form input#PHONE');

        //	$(".js-sale-order-quick-product-form").on()('submit', ym(52641877,'reachGoal','click1'));

        $(".js-sale-order-quick-product-form").ajaxForm({

            url: "<?=$arResult["AJAX_URL"]?>",
            dataType: "json",
            beforeSubmit: function (formData, jqForm, options) {
                $(".modals-content .errors").html("");

                var $basketBtn = $(".js-add2basket");
                formData.push({name: 'PRODUCT', value: $basketBtn.data("id")});
                formData.push({name: 'BOXING', value: $basketBtn.data("boxing")});
                formData.push({name: 'SIZE', value: $basketBtn.data("size")});
                formData.push({name: 'QTY', value: $basketBtn.data("qty")});
            },
            success: function (response) {
                //response = JSON.parse(response);
                if (!response) return;
                if (response.success) {
                    $(".modals-content form").hide();
                    $(".modals-content .form-success").removeClass("hidden");
                    $(".modals-content .order-number").html(response.orderId);
                    gtag('event', 'cleek1', {'event_category': 'form1'});
                    ym(52641877, 'reachGoal', 'click1');
                } else {
                    $(".modals-content .errors").html(response.errors.join(", "));
                }
            }
        });
    });
</script>