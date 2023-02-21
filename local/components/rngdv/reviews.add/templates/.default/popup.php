<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
global $APPLICATION;
?>


<div>
    <div class="modal_wrap js-review-form-container">
        <div class="title js-review-form-title">Оставить отзыв</div>
        <div class="p js-review-form-desc" style="color:red"></div>
        <form class="form_main js-review-form" action="/ajax/reviews.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="send" value="y">
            <input type="hidden" name="target" value="<?= $arResult["TARGET"] ?>">

            <div class="row">
                <div class="col-lg-6">
                    <div class="input_wrap">
                        <div class="top_input">
                            <span>Ваше Имя</span>
                        </div>
                        <input type="text" name="fio"><br>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="input_wrap">
                        <div class="top_input">
                            <span>Контактный телефон</span>
                        </div>
                        <input type="text" name="phone">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="input_wrap">
                        <div class="top_input">
                            <span>E-mail</span>
                        </div>
                        <input type="text" name="email">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="line"></div>
                    <div class="input_wrap">
                        <div class="top_input">
                            <span>Напишите свой отзыв</span>
                        </div>
                        <textarea name="review"></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="file-select file-select--narrow">
                        <label class="file-select__label" for="file-input">
                            <span class="file-select__text">Загрузить файл</span>
                            <input type="file" name="files[]" id="file-input" multiple>
                        </label>
                        <div class="file-select__list">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="d_flex bottom_form">
                        <div class="capcha">
                            <input type="hidden" name="captcha_sid"
                                   value="<?= htmlspecialchars($arResult["CAPTCHA"]) ?>">
                            <img src="/bitrix/tools/captcha.php?captcha_sid=<?= htmlspecialchars($arResult["CAPTCHA"]) ?>"
                                 width="180" height="40"><br>
                            <input type="text" name="captcha_word" size="30" maxlength="50" value="">


                        </div>
                        <button class="btn_main">Отправить</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(function () {
        try {
            Recaptchafree.reset();
        } catch {
        }

        var fileInput = $("#file-input").fileInput();

        var $container = $(".js-review-form").closest(".js-review-form-container");

        var $formDesc = $container.find(".js-review-form-desc");
        var $formTitle = $container.find(".js-review-form-title");

        $(".js-review-form").on("submit", function (e) {
            e.preventDefault();

            $(this).ajaxSubmit({
                dataType: "json",
                beforeSubmit: function (formData) {
                    $formDesc.html("");

                    var files = fileInput.getFiles();

                    for (var i = 0, len = files.length; i < len; i++) {
                        formData.push({
                            name: "files[]",
                            value: files[i].file,
                            type: "file"
                        });

                    }

                    console.log(formData);

                    return formData;
                },
                success: function showResponse(response, statusText, xhr, $form) {
                    console.log(response);

                    if (response) {
                        if (response.success === true) {
                            $formTitle.html("Спасибо за отзыв!");
                            $form.hide();
                        } else {
                            $formDesc.html(response.errors.join("<br>"));
                            $("[name=captcha_sid]").val(response.captcha);
                        }
                    }
                },
                complete: function () {
                    try {
                        Recaptchafree.reset();
                    } catch {
                    }
                }
            });
        });
    });
</script>