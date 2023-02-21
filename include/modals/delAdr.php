<?php check_prolog();

?>

<div id="modal-delAdr" class="modal modal-thanks">
    <form action="?"
          class="cabinet-address-formedit form">
    <div class="modal-body modal-edit" style="padding: 30px">
        <a href="#" class="modal-close-btn" aria-label="Закрыть">
            <svg width="24" height="24"><use xlink:href="#icon-close"/></svg>
        </a>
        <input id="street_code" type="hidden" class="input cabinet-address-street_code2">
        <input id="index" type="hidden" class="input cabinet-address-index">
        <input id="idadr" type="hidden" class="input cabinet-address-input-id" >
                <div class="cabinet-address-form-inputs">
                    <div class="cabinet-address-form-row flex-row">
                        <div class="cabinet-address-form-col flex-row-item">
                            <label class="form-block">
                                <span class="form-block-title">Название </span>
                                <input id = "nameadr" type="text"
                                       class="input cabinet-address-input-title"
                                       required>
                            </label>
                        </div>
                        <div class="cabinet-address-form-col flex-row-item">
                            <div class="form-block">
                                <span class="form-block-title">Населённый пункт</span>
                                <?/*div id="one_string" class="form-block-select ordering-delivery-city-select">
                                    <input id = "city" name="address"  type="search" class="input cabinet-address-input-city" required>
                                </div*/?>
                                <select class="input cabinet-address-input-city" id="my_sity2" style="width: 100%"></select>
                                <?
                                global $signedParameters;
                                global $signedTemplate;
                                ?>
                                <script>
                                    $(document).ready(function () {
                                        $('#my_sity2').select2({
                                            searchInputPlaceholder: "Начните вводить размер",
                                            formatInputTooShort : "Введите больше 3-х символов",
                                            "language": {"searching": function(){ return "Поиск.."; },"noResults": function(){ return "Ничего не найдено"; },"inputTooShort": function(){ return "Введите больше 3-х символов"; },},
                                            minimumInputLength: 3,
                                            dropdownPosition: 'below',
                                            ajax: {
                                                url: "/local/ajax/address_city.php",
                                                type: "post",
                                                dataType: "json",
                                                quietMillis: 100,
                                                cache: true,
                                                data: function (obj) {
                                                    var key = $('#my_sity').val();
                                                    obj.query = obj.term;
                                                    obj.method = 'search';
                                                    obj.siteId = '<?=SITE_ID?>';
                                                    obj.parameters = '<?=$signedParameters?>';
                                                    obj.template = '<?=$signedTemplate?>';
                                                    return obj;
                                                },
                                                processResults: function (data) {
                                                    var newResults = [];
                                                    for(var k=0;k<data['response']['count'];k++){
                                                        var text = '';
                                                        if(data['response']['items'][k]['city']){
                                                            text = text + data['response']['items'][k]['city'];
                                                        }
                                                        if(data['response']['items'][k]['area']){
                                                            text = text + ', ' + data['response']['items'][k]['area'];
                                                        }
                                                        if(data['response']['items'][k]['region']){
                                                            text = text + ', ' + data['response']['items'][k]['region'];
                                                        }
                                                        newResults.push({'id':data['response']['items'][k]['location'],'text':text});
                                                    }
                                                    console.log(newResults);
                                                    return {
                                                        // results: data.results
                                                        results: newResults
                                                    };
                                                },
                                                results: function (data) {
                                                    return {
                                                        results: data
                                                    };
                                                }
                                            }
                                        });

                                        $('.jsStreet3').select2({
                                            searchInputPlaceholder: "Начните вводить",
                                            formatInputTooShort : "Введите больше 3-х символов",
                                            "language": {"searching": function(){ return "Поиск.."; },"noResults": function(){ return "Ничего не найдено"; },"inputTooShort": function(){ return "Введите больше 3-х символов"; },},
                                            minimumInputLength: 3,
                                            dropdownPosition: 'below',
                                            ajax: {
                                                url: "/local/ajax/address_street.php",
                                                type: "post",
                                                dataType: "json",
                                                quietMillis: 100,
                                                cache: true,
                                                data: function (obj) {
                                                    var key = $('#my_sity2').val();
                                                    obj.KEY = key;
                                                    return obj;
                                                },
                                                processResults: function (data) {
                                                    return {
                                                        results: data.results
                                                    };
                                                },
                                                results: function (data) {
                                                    return {
                                                        results: data
                                                    };
                                                }
                                            }
                                        });
                                        $('#my_sity').on('change',function(){
                                            $('.jsStreet').removeClass('input_disabled');
                                            $('.jsStreet').prop('disabled',false);
                                        });
                                        $('#my_street2').on('change',function(){
                                            if($(this).val() == 'other'){
                                                $('.jsStreet2-block').show();
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <div class="cabinet-address-form-col flex-row-item">
                            <label class="form-block">
                                <span class="form-block-title">Улица</span>
                                <select class="input cabinet-address-input-city input_disabled jsStreet3" id="my_street2" style="width: 100%"></select>

                                <?/*input id = "street" type="text"
                                       class="input cabinet-address-input-street"
                                       required*/?>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 jsStreet2-block" style="display: none;">
                    <label class="form-block">
                        <span class="form-block-title">Улица</span>
                        <input class="input cabinet-address2-input-data jsStreet2" style="width: 100%">
                        <?/*input type="text" class="input cabinet-address-input-data input_disabled jsStreet" required disabled*/?>
                    </label>
                </div>
                <div class="cabinet-address-form-inputs cabinet-address-form-inputs-small">
                    <div class="cabinet-address-form-row flex-row">
                        <div class="cabinet-address-form-col flex-row-item">
                            <label class="form-block">
                                <span class="form-block-title">Дом</span>
                                <input id = "home" type="text"
                                       class="input cabinet-address-input-home"
                                       required>
                            </label>
                        </div>
                        <div class="cabinet-address-form-col flex-row-item">
                            <label class="form-block">
                                <span class="form-block-title">Корпус</span>
                                <input id = "korpus" type="text"
                                       class="input cabinet-address-input-korpus">
                            </label>
                        </div>
                        <div class="cabinet-address-form-col flex-row-item">
                            <label class="form-block">
                                <span class="form-block-title">Строение</span>
                                <input id = "stroenie" type="text"
                                       class="input cabinet-address-input-stroenie">
                            </label>
                        </div>
                        <div class="cabinet-address-form-col flex-row-item">
                            <label class="form-block">
                                <span class="form-block-title">Подъезд</span>
                                <input id = "floor" type="text"
                                       class="input cabinet-address-input-floor">
                            </label>
                        </div>
                        <div class="cabinet-address-form-col flex-row-item">
                            <label class="form-block">
                                <span class="form-block-title">Квартира</span>
                                <input id = "kvartira" type="text"
                                       class="input cabinet-address-input-kvartira">
                            </label>
                        </div>
                    </div>
                </div>
                <label class="form-block">
                    <span class="form-block-title">Комментарий курьеру:</span>
                    <textarea id = "coment"
                            class="input textarea cabinet-address-input-comment"
                            placeholder="Напишите ваш комментарий"></textarea>
                </label>
                <div class="cabinet-address-form-submit-wrapp submit-wrapp">

                    <ul class="cabinet-address-form-btns">
                        <li>
                            <button class="btn btn-full btn-green submit">
                                Сохранить
                            </button>
                        </li>
                        <li>
                            <a href="#"
                               class="btn btn-full cabinet-address-form-del modal-close-link"">Отменить</a>
                        </li>
                    </ul>
                </div>
    </div>
    </form>
</div>

