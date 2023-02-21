<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 */

$this->setFrameMode(true);
?>

<script>
    var itemsInBasket = <?=CUtil::PhpToJSObject($arResult)?>;

    $(function () {
        $.each(itemsInBasket, function (key, value) {

            var selector = ".js-add2basket[data-id=" + key + "]";

            if (value.length) {
                value.forEach(function (size) {
                    if (!size) return;
                    var tmp = selector + "[data-size='" + size + "']";
                    markAsAdded($(tmp));
                });
            } else {
                markAsAdded($(selector));
            }
        });


        $(".js-add2basket------").on("click", function (e) {
            e.preventDefault();
            var $self = $(this);

            if ($self.hasClass("js-added")) return true;//window.location.href='/basket/';

            markAsAdded($self);

            var url = "/basket/popup.php?act=add&html=y&component=basket.simple.ajax";
            var id = $self.data("id");
            url += "&id=" + id; 		// какой товар добавляем
            url += "&product=" + id;	// какой товар показываем в попапе

            $.arcticmodal({
                type: 'ajax',
                url: url
            });
        });


        $(".js-add2basket").on("click", add2basket);

        function add2basket(e) {
            e.preventDefault();
            var $self = $(this);

            if ($self.hasClass("js-added")) return true;//window.location.href='/basket/';

            markAsAdded($self);

            var size = this.dataset.size;
            if (!size) size = "";

            if (!itemsInBasket[this.dataset.id]) itemsInBasket[this.dataset.id] = [];
            itemsInBasket[this.dataset.id].push(size);

            var url = "/basket/popup.php?act=add&html=y&component=basket.simple.ajax";
            url += "&product=" + this.dataset.id;	// какой товар показываем в попапе
            url += "&id=" + this.dataset.id; 		// какой товар добавляем
            url += "&qty=" + this.dataset.qty;
            url += "&boxing=" + this.dataset.boxing;
            url += "&size=" + size;

            $.arcticmodal({
                type: 'ajax',
                url: url
            });
        }


        $(".js-curr-qty").on("change", function () {
            var $this = $(this);

            var maxQty = parseInt($this.attr("max") || 0);
            var price = $("[data-raw-price]").data("raw-price");
            var boxing = parseInt($(".js-add2basket").data("boxing"));
            var newQty = parseInt($this.val());

            if (isNaN(newQty) || newQty <= 0) newQty = boxing;
            if (newQty > maxQty) newQty = maxQty;

            var sum = (price * newQty * 100).toFixed(0) / 100;
            if (sum % 1 !== 0) sum = sum.toFixed(2);

            $(".js-curr-qty").val(newQty);
            $(".js-curr-sum").html(sum);

            $(".js-add2basket").attr("data-qty", newQty);
        });

        $(".js-select-size").on("click", function () {
            var $this = $(this);

            $(".js-size-selected")
                .removeClass("js-size-selected")
                .removeClass("sizes__item--current")
            ;

            var sizeId = $this.data("id");
            $("[data-id='" + sizeId + "']")
                .addClass("js-size-selected")
                .addClass("sizes__item--current ")
            ;

            var price = $("[data-raw-price]").data("raw-price");
            var boxing = parseInt($this.data("boxing"));
            var sum = (price * boxing * 100).toFixed(0) / 100;
            if (sum % 1 !== 0) sum = sum.toFixed(2);

            $(".js-curr-qty").val(boxing);
            $(".js-curr-boxing").html(boxing);
            $(".js-curr-sum").html(sum);
            $(".js-curr-boxing-pieces").html(pw(boxing.toString(), "штуке", "штукам", "штук"));

            $(".js-add2basket")
                .attr("data-qty", boxing)
                .attr("data-boxing", boxing)
                .attr("data-size", this.innerHTML)
            ;


            var id = $(".js-add2basket").data("id");

            if (itemsInBasket[id] && itemsInBasket[id].length && itemsInBasket[id].indexOf(this.innerHTML) != -1) {
                markAsAdded($(".js-add2basket[data-id=" + id + "]"));
            } else {
                markAsNotAdded($(".js-added[data-id=" + id + "]"))
            }

            $(".js-add2basket").off("click").on("click", add2basket);
        });

        $(".js-qty-inc, .js-qty-dec").on("click", function () {
            var isInc = $(this).hasClass("js-qty-inc");

            var price = $("[data-raw-price]").data("raw-price");
            var boxing = parseInt($(".js-curr-boxing").html());
            var qty = parseInt($(".js-curr-qty").val());
            var maxQty = parseInt($(".js-curr-qty").attr("max") || 0);


            if (isInc) {
                qty += boxing;
                if (qty > maxQty) qty = maxQty;
            } else if (qty > boxing) {
                qty -= boxing;
            }

            var sum = (price * qty * 100).toFixed(0) / 100;
            if (sum % 1 !== 0) sum = sum.toFixed(2);

            $(".js-curr-qty").val(qty);
            $(".js-curr-sum").html(sum);

            $(".js-add2basket").attr("data-qty", qty);
        });
    });


    function markAsAdded($button) {
        $button.each(function () {
            $btn = $(this);
            $btn
                .removeClass("v-btn--red")
                .addClass("v-btn--green")
                .addClass("v-btn--pressed")
                .addClass("js-added")
                .attr("href", "/basket/")
                .find(".v-btn__text")
                .html("В корзине")
            ;

            var $icon = $btn.find(".v-icon");

            if ($icon.hasClass("v-icon--basket-white"))
                $icon
                    .removeClass("v-icon--basket-white")
                    .addClass("v-icon--check-white")
                ;

            if ($icon.hasClass("v-icon--basket-white-sm"))
                $icon
                    .removeClass("v-icon--basket-white-sm")
                    .addClass("v-icon--check-white-sm")
                ;
        });
    }

    function markAsNotAdded($button) {
        $button.each(function () {
            $btn = $(this);
            $btn
                .addClass("v-btn--red")
                .removeClass("v-btn--green")
                .removeClass("v-btn--pressed")
                .removeClass("js-added")
                .find(".v-btn__text")
                .html("В корзину")
            ;

            var $icon = $btn.find(".v-icon");

            if ($icon.hasClass("v-icon--check-white"))
                $icon
                    .removeClass("v-icon--check-white")
                    .addClass("v-icon--basket-white")
                ;

            if ($icon.hasClass("v-icon--check-white-sm"))
                $icon
                    .removeClass("v-icon--check-white-sm")
                    .addClass("v-icon--basket-white-sm")
                ;
        });


    }

    function pw(val, w0, w1, w2) {
        if (val.search(/1\d$/) >= 0) return w2;
        else if (val.search(/1$/) >= 0) return w0;
        else if (val.search(/(2|3|4)$/) >= 0) return w1;
        else return w2;
    }
</script>
