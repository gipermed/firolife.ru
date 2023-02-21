<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
global $APPLICATION;
?>


<div id="form" class="form-reviews js-review-form-container">
    <h4 class="js-review-form-title">
        Оставьте отзыв о клинике или враче
    </h4>
    <div class="p js-review-form-desc" style="color:red"></div>
    <form class="js-review-form" action="/ajax/reviews.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="send" value="y">
        <div class="two-label-block">
            <div class="item">
                <label>
                    <span> Укажите Ваше ФИО </span>
                    <input type="text" name="fio"><br>
                </label>
            </div>
            <div class="item">
                <div class="two-label">
                    <label>
                        <span> Email </span>
                        <input type="text" name="email">
                    </label>
                    <label>
                        <span> Телефон </span>
                        <input type="text" name="phone">
                    </label>
                </div>
            </div>
        </div>
        <div class="two-label-block two">
            <div class="item">
                <div class="radio-target">
                    <div class="title">
                        Цель отзыва
                    </div>
                    <div class="swich-select">
						<? $first = true; ?>
						<? foreach ($arResult["TARGETS"] as $targetType => $noMatter): ?>
                            <label class="radio-label">
								<? switch ($targetType)
								{
									case "doctors":
										echo "Отзыв о враче";
										break;
									case "clinics":
										echo "Отзыв о клинике";
										break;
								} ?>
                                <input type="radio" data-value='<?= $targetType ?>' name="target-type"
									   <? if ($first): ?>checked<? endif; ?>>
                            </label>
							<? $first = false; ?>
						<? endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="tabs-select">
					<? foreach ($arResult["TARGETS"] as $targetType => $targets): ?>
                        <label data-value="<?= $targetType ?>">
							<span>
								<? switch ($targetType)
								{
									case "doctors":
										echo "Укажите ФИО врача";
										break;
									case "clinics":
										echo "Укажите клинику";
										break;
								} ?>
							</span>
                            <span class="ui-widget">
								<select class="combobox" name="target-<?= $targetType ?>">
									<? foreach ($targets as $id => $name): ?>
                                        <option value="<?= $id ?>"><?= $name ?></option>
									<? endforeach; ?>
								</select>
							</span>
                        </label>
					<? endforeach; ?>
                </div>
            </div>
        </div>
        <label>
            <span> Отзыв </span>
            <textarea name="review"></textarea>
        </label>
        <div class="file-select">
            <label class="file-select__label" for="file-input">
                <span class="file-select__text">Загрузить файл</span>
                <input type="file" name="files[]" id="file-input" multiple>
            </label>
            <div class="file-select__list">
            </div>
        </div>
        <div class="submit">
            <input type="submit" value="Отправить отзыв">

            <div class="capcha">
                <input type="hidden" name="captcha_sid" value="<?= htmlspecialchars($arResult["CAPTCHA"]) ?>">
                <img src="/bitrix/tools/captcha.php?captcha_sid=<?= htmlspecialchars($arResult["CAPTCHA"]) ?>"
                     width="180" height="40">
                <input type="text" name="captcha_word" size="30" maxlength="50" value="">
            </div>
        </div>
    </form>
</div>

<script>
    $(function () {
        $("label[data-value]").hide().eq(0).show();

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

                    var targetType = $("[name=target-type]:checked").data("value");
                    var target = $("[name=target-" + targetType + "]").val();

                    formData.push({
                        name: "target",
                        value: target,
                        type: "text"
                    });

                    return formData;
                },
                success: function showResponse(response, statusText, xhr, $form) {
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