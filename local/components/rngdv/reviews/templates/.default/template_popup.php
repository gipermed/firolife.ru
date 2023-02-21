<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
global $APPLICATION;
?>

<? if (!$GLOBALS["USER"]->IsAuthorized()): ?>
    <div class="box-modal" style="text-align: center;">
        Только авторизованные пользователи могут оставлять комментарии
        <br>
        <br>
        <a href="/auth/" class="v-btn v-btn--lg v-btn--red">
            <div class="v-btn__text">
                Войти
            </div>
        </a>
    </div>
<? else: ?>


    <div class="box-modal">
        <style> .box-modal textarea {
                min-height: 85px;
                line-height: 20px;
            } </style>
        <div class="js-review-form-container">
            <div class="heading b-form__title js-review-form-title">Оставить отзыв</div>
            <div class="p js-review-form-desc" style="color:red"></div>
            <form class="form_main js-review-form" action="<?= $arResult["AJAX_URL"] ?>" method="post"
                  enctype="multipart/form-data">
                <input type="hidden" name="action" value="submit">
                <input type="hidden" name="target" value="<?= $_REQUEST["target"] ?>">

                <div class="b-form__group">
                    <div class="b-form__group-label"> Оценка</div>
                    <div class="b-form__group-wrap">
                        <label> <input type="radio" name="rate" value="1"> 1 </label> <br>
                        <label> <input type="radio" name="rate" value="2"> 2 </label> <br>
                        <label> <input type="radio" name="rate" value="3"> 3 </label> <br>
                        <label> <input type="radio" name="rate" value="4"> 4 </label> <br>
                        <label> <input type="radio" name="rate" value="5"> 5 </label> <br>
                        <div class="b-form__group-error"></div>
                    </div>
                </div>

                <label class="b-form__group">
                    <div class="b-form__group-label"> Достоинства</div>
                    <div class="b-form__group-wrap">
                        <textarea class="b-form__group-input" name="advantages"></textarea>
                        <div class="b-form__group-error"></div>
                    </div>
                </label>

                <label class="b-form__group">
                    <div class="b-form__group-label"> Недостатки</div>
                    <div class="b-form__group-wrap">
                        <textarea class="b-form__group-input" name="disadvantages"></textarea>
                        <div class="b-form__group-error"></div>
                    </div>
                </label>

                <label class="b-form__group">
                    <div class="b-form__group-label"> Комментарий</div>
                    <div class="b-form__group-wrap">
                        <textarea class="b-form__group-input" name="comment"></textarea>
                        <div class="b-form__group-error"></div>
                    </div>
                </label>

                <div class="b-form__submit-wrap">
                    <button name="submit" type="submit">
                        Отправить
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(function () {

            var $form = $(".js-review-form");
            var $container = $form.closest(".js-review-form-container");

            var $formDesc = $container.find(".js-review-form-desc");
            var $formTitle = $container.find(".js-review-form-title");

            $form.on("submit", function (e) {
                e.preventDefault();

                $(this).ajaxSubmit({
                    dataType: "json",
                    success: function showResponse(response, statusText, xhr, $form) {
                        $formDesc.html("");

                        if (response) {
                            if (response.success === true) {
                                $formTitle.html("Спасибо за отзыв!");
                                $form.hide();
                            } else {
                                $formDesc.html(response.errors.join("<br>"));
                            }
                        }
                    },
                });
            });
        });
    </script>

<? endif; ?>