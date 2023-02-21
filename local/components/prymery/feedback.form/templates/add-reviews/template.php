<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>
<!--noindex-->
    <form enctype="multipart/form-data" method="POST" class="new-review-add prForm" autocomplete="off" method="post" action="<?= $arResult['JS_OBJECT']['AJAX_PATH'] ?>">
        <?if($arResult['ERROR_COUNTERS_ID']):?>
            <div class="prForm__error"><?=$arResult['ERROR_COUNTERS_ID']?></div>
        <?endif;?>
        <?if($arResult['JS_OBJECT']['FIELDS']['ELEMENT_NAME']):?>
            <input value="<?=$arResult['JS_OBJECT']['FIELDS']['ELEMENT_NAME']?>" name="ELEMENT_NAME" type="hidden">
            <input value="<?=$arParams['ELEMENT_ID']?>" name="ELEMENT_ID" type="hidden">
        <?endif;?>
        <input type="hidden" name="rating" class="js-rating-val">
        <input type="hidden" name="USER_ID" value="<?=$USER->GetId();?>">
        <?if(!empty($arResult['FIELDS'])){?>
            <?foreach ($arResult['FIELDS'] as $field) {
                if ($field['CODE'] == 'MESSAGE'):?>
                    <div class="form-group form-group-review-message">
                        <div class="form-group-header">
                            <div class="form-group-title"><?=GetMessage('PRYMERY_FF_FIELD_'.$field['CODE'])?><?= ($field['REQUIRED'] == 'Y') ? ' *' : '' ?></div>
                            <div class="message-length">Введено символов <span class="review-current-symbols">0</span> / 1000</div>
                        </div>
                        <textarea rows="7" name="<?= $field['CODE'] ?>" placeholder="Текст отзыва" class="js-review-message form-control <?=($field['REQUIRED'] == 'Y') ? ' required' : '' ?>"></textarea>
                    </div>
                <?elseif($field['CODE'] == 'RATING'):?>
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
                <?elseif($field['CODE'] == 'FILE'):?>
                    <div class="col-12 col-lg-auto">
                        <div class="form-group text-center">
                            <label class="form-file">
                                <input type="file" accept=".jpg, .jpeg, .png" name="FILE" class="form-control-file">
                                <div class="form-file-caption">Добавить фото букета</div>
                            </label>
                        </div>
                    </div>
                <?elseif($field['CODE'] == 'USER_ID'):?>
                <?elseif($field['CODE'] == 'FILES'):?>

                <?elseif($field['CODE'] != 'ELEMENT_ID'):?>
                    <div class="col-12 col-lg-6">
                        <div class="form-group field-required label-floating">
                            <label class="control-label"><?=GetMessage('PRYMERY_FF_FIELD_'.$field['CODE'])?><?= ($field['REQUIRED'] == 'Y') ? ' *' : '' ?></label>
                            <input class="form-control<?= ($field['REQUIRED'] == 'Y') ? ' required' : '' ?><?= ($field['CODE'] == 'PHONE') ? ' js-phone-masked' : '' ?>" name="<?= $field['CODE'] ?>" type="text" value="">
                        </div>
                    </div>
                <?endif;
            }?>
        <?}?>
        <div class="form-group form-group--photos">
            <div class="form-group-title">Загрузите фотографии</div>
            <div class="custom-file__list">
                <label class="custom-file__item">
                    <span class="custom-file__preview"></span>
                    <input class="custom-file__value" name="FILES[]" type="file" accept="image/*">
                </label>
                <label class="custom-file__item">
                    <span class="custom-file__preview"></span>
                    <input class="custom-file__value" name="FILES[]" type="file" accept="image/*">
                </label>
                <label class="custom-file__item">
                    <span class="custom-file__preview"></span>
                    <input class="custom-file__value" name="FILES[]" type="file" accept="image/*">
                </label>
                <label class="custom-file__item">
                    <span class="custom-file__preview"></span>
                    <input class="custom-file__value" name="FILES[]" type="file" accept="image/*">
                </label>
                <label class="custom-file__item">
                    <span class="custom-file__preview"></span>
                    <input class="custom-file__value" name="FILES[]" type="file" accept="image/*">
                </label>
            </div>
            <div class="review-photo-formats"><span>Поддерживаемые форматы:</span> JPG, JPEG, PNG</div>
        </div>

        <div class="form-footer">
            <input type="submit" class="btn btn-form-submit" value="Отправить">
            <input type="reset" class="btn new-review-cancel" value="Отменить">
        </div>
        <div class="form-extra-tip">Размещая отзыв на сайте, вы даёте согласие на использование данных отзыва на сторонних ресурсах</div>
    </form>
    <div class="true-message" style="display: none;">
        <?=$arParams['TRUE_MESSAGE']?>
    </div>
    <script>
        $(document).ready(function(){
            initprForm(<?= CUtil::PhpToJSObject($arResult['JS_OBJECT']) ?>);
            $('.form-control-file').change(function() {
                $(this).next().text($(this)[0].files[0].name);
            });
            $('.leave-rating').on('mouseover', '.rating__star', function(){
                let index = $(this).index();
                $('.leave-rating:not(.active) .rating__star').removeClass('active');
                for (var i = 0; i <= index; i++) {
                    $('.leave-rating:not(.active) .rating__star').eq(i).addClass('active');
                }
            });

            $('.leave-rating').on('click', '.rating__star', function(){
                let index = $(this).index();
                $('.leave-rating .rating__star').removeClass('active');
                for (var i = 0; i <= index; i++) {
                    $('.leave-rating .rating__star').eq(i).addClass('active');
                }
                $('.js-rating-val').val(index+1);
                $('.leave-rating').addClass('active');
            });
        });
        $('input[name=PHONE]').inputmask('(9)|(+7) (999)999-99-99');
    </script>

<!--/noindex-->