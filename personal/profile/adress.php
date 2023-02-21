<? require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetTitle("Мои адреса");
$APPLICATION->SetPageProperty('title', 'Мои адреса');

use Bitrix\Main\Loader;

Loader::includeModule("highloadblock");

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

if (!$USER->IsAuthorized())
{
    $_SESSION["BACKURL"] = $APPLICATION->GetCurPage();
    LocalRedirect("/auth/");
}
?>
<div class="cabinet cabinet-addresses">
    <div class="cabinet-section-title">Мои адреса<a href="/personal/main/" class="btn-lk-return">< Вернуться в профиль</a></div>
    <div class="personal-address-description">При оформлении заказа выберите необходимый для доставки адрес из выпадающего списка.</div>
</div>
    <script data-skip-moving="true" src="https://api-maps.yandex.ru/2.1.79/?apikey=c617d6aa-9ec6-4567-8bb9-7b600859bc60&lang=ru_RU" type="text/javascript"></script>

<?php
$hlbl = 3; // Указываем ID нашего highloadblock блока к которому будет делать запросы.
$hlblock = HL\HighloadBlockTable::getById($hlbl)->fetch();

$entity = HL\HighloadBlockTable::compileEntity($hlblock);
$entity_data_class = $entity->getDataClass();

$rsData = $entity_data_class::getList(array(
    "select" => array("*"),
    "order" => array("ID" => "ASC"),
    "filter" => array("UF_ID_USER"=>$USER->GetID())  // Задаем параметры фильтра выборки
));
while($arData = $rsData->Fetch()){
    $allAddress[] = $arData;
}
?>
    <div class="personal-address-list">
        <?foreach($allAddress as $arData):?>
            <div class="personal-address__item">
                <div class="personal-address__head">
                    <a href="#modal-delAdr" class="modal-open-btn cabinet-address-item-editnew">
                        <span><?=$arData['UF_TYPE_ADR']; ?></span>
                        <img class="icon" src="/local/templates/main/assets/img/delAdr.jpg" alt="">
                    </a>
                    <a href="#" class="cabinet-address-item-delnew">
                        <span>Удалить адрес</span>
                    </a>
                </div>
                <input type="hidden" class="input cabinet-address-code" value="<?=$arData['UF_CODE']; ?>">
                <input type="hidden" class="input cabinet-address-input-id" value="<?=$arData['ID']; ?>">
                <input type="hidden" class="input cabinet-address-input-typeadr" value="<?=$arData['UF_TYPE_ADR']; ?>">
                <input type="hidden" class="input cabinet-address-input-cityn" value="<?=$arData['UF_CITY']; ?>">
                <input type="hidden" class="input cabinet-address-input-street" value="<?=$arData['UF_STREET']; ?>">
                <input type="hidden" class="input cabinet-address-street_code" value="<?=$arData['UF_STREET_CODE']; ?>">
                <input type="hidden" class="input cabinet-address-input-home" value="<?=$arData['UF_HOME']; ?>">
                <input type="hidden" class="input cabinet-address-input-korpus" value="<?=$arData['UF_KORPUS']; ?>">
                <input type="hidden" class="input cabinet-address-input-stroenie" value="<?=$arData['UF_STROENIE']; ?>">
                <input type="hidden" class="input cabinet-address-input-kvartira" value="<?=$arData['UF_KVARTIRA']; ?>">
                <input type="hidden" class="input cabinet-address-input-coment" value="<?=$arData['UF_COMENT']; ?>">
                <input type="hidden" class="input cabinet-address-input-index" value="<?=$arData['UF_INDEX']; ?>">
                <input type="hidden" class="input cabinet-address-input-floor" value="<?=$arData['UF_FLOOR']; ?>">

                <div class="personal-address__group">
                    <div class="personal-address__char">Адрес доставки:</div>
                    <div class="personal-address__val">Нас. пункт: <?=$arData['UF_CITY']; ?>, ул.<?=$arData['UF_STREET']; ?>, дом: <?=$arData['UF_HOME']; ?>, корп. <?=$arData['UF_KORPUS']; ?>, стр. <?=$arData['UF_STROENIE']; ?><?if($arData['UF_FLOOR']):?>, под. <?=$arData['UF_FLOOR']; ?><?endif;?>, кв. <?=$arData['UF_KVARTIRA']; ?></div>
                </div>

                <div class="personal-address__group">
                    <div class="personal-address__char">Комментарий курьеру:</div>
                    <div class="personal-address__val"><?=$arData['UF_COMENT']; ?></div>
                </div>
            </div>
        <?endforeach;?>
        <?
        if(!$allAddress){$allAddress=[];}
        if(count($allAddress) < 3):?>
            <div class="col-new-personal-addr">
                <div class="cabinet-address-add">
                    <a href="javascript:void(0)" class="cabinet-address-add-btn">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 5.25C12.1989 5.25 12.3897 5.32902 12.5303 5.46967C12.671 5.61032 12.75 5.80109 12.75 6V12C12.75 12.1989 12.671 12.3897 12.5303 12.5303C12.3897 12.671 12.1989 12.75 12 12.75H6C5.80109 12.75 5.61032 12.671 5.46967 12.5303C5.32902 12.3897 5.25 12.1989 5.25 12C5.25 11.8011 5.32902 11.6103 5.46967 11.4697C5.61032 11.329 5.80109 11.25 6 11.25H11.25V6C11.25 5.80109 11.329 5.61032 11.4697 5.46967C11.6103 5.32902 11.8011 5.25 12 5.25Z" fill="#545454"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.25 12C11.25 11.8011 11.329 11.6103 11.4697 11.4697C11.6103 11.329 11.8011 11.25 12 11.25H18C18.1989 11.25 18.3897 11.329 18.5303 11.4697C18.671 11.6103 18.75 11.8011 18.75 12C18.75 12.1989 18.671 12.3897 18.5303 12.5303C18.3897 12.671 18.1989 12.75 18 12.75H12.75V18C12.75 18.1989 12.671 18.3897 12.5303 18.5303C12.3897 18.671 12.1989 18.75 12 18.75C11.8011 18.75 11.6103 18.671 11.4697 18.5303C11.329 18.3897 11.25 18.1989 11.25 18V12Z" fill="#545454"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 22.5C14.7848 22.5 17.4555 21.3938 19.4246 19.4246C21.3938 17.4555 22.5 14.7848 22.5 12C22.5 9.21523 21.3938 6.54451 19.4246 4.57538C17.4555 2.60625 14.7848 1.5 12 1.5C9.21523 1.5 6.54451 2.60625 4.57538 4.57538C2.60625 6.54451 1.5 9.21523 1.5 12C1.5 14.7848 2.60625 17.4555 4.57538 19.4246C6.54451 21.3938 9.21523 22.5 12 22.5ZM12 24C15.1826 24 18.2348 22.7357 20.4853 20.4853C22.7357 18.2348 24 15.1826 24 12C24 8.8174 22.7357 5.76516 20.4853 3.51472C18.2348 1.26428 15.1826 0 12 0C8.8174 0 5.76516 1.26428 3.51472 3.51472C1.26428 5.76516 0 8.8174 0 12C0 15.1826 1.26428 18.2348 3.51472 20.4853C5.76516 22.7357 8.8174 24 12 24Z" fill="#545454"/>
                        </svg>
                        <span>Новый адрес</span>
                    </a>
                </div>
            </div>
        <?endif;?>
    </div>
    <div class="cabinet cabinet-addresses1">
        <div class="cabinet-address-new">
            <form action="?" class="cabinet-address-form form f-personal-new-address">
                <div class="cabinet-address-form-inputs">
                    <div class="row">
                        <div class="col-12">
                            <div class="new-address__title">Новый адрес</div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label class="form-block">
                                <span class="form-block-title">Название адреса (напр. Работа)</span>
                                <input type="text" class="input cabinet-address-input-title" required>
                            </label>
                        </div>
                        <div class="col-12"></div>
                        <div class="col-12 col-md-6">
                            <div class="form-block">
                                <span class="form-block-title">Населённый пункт</span>
                                <div class="form-block-select ordering-delivery-city-select">
                                    <select class="input cabinet-address-input-city" id="my_sity" style="width: 100%"></select>
                                    <?
                                    global $signedParameters;
                                    global $signedTemplate;
                                    ?>
                                    <script>
                                        $(document).ready(function () {
                                            $('#my_sity').select2({
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
                                            $('.jsStreet').select2({
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
                                                        var key = $('#my_sity').val();
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
                                            $('#my_street').on('change',function(){
                                                if($(this).val() == 'other'){
                                                    $('.jsStreet2-block').show();
                                                }
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-block">
                                <span class="form-block-title">Улица</span>
                                <select class="input cabinet-address-input-city input_disabled jsStreet" id="my_street" style="width: 100%" disabled></select>
                                <?/*input type="text" class="input cabinet-address-input-data input_disabled jsStreet" required disabled*/?>
                            </label>
                        </div>
                        <div class="col-12 col-md-12 jsStreet2-block" style="display: none;">
                            <label class="form-block">
                                <span class="form-block-title">Улица</span>
                                <input class="input cabinet-address2-input-data jsStreet2" style="width: 100%">
                                <?/*input type="text" class="input cabinet-address-input-data input_disabled jsStreet" required disabled*/?>
                            </label>
                        </div>
                        <div class="col-6 col-lg-2">
                            <label class="form-block">
                                <span class="form-block-title">Дом</span>
                                <input type="text" class="input cabinet-address-input-data" required>
                            </label>
                        </div>
                        <div class="col-6 col-lg-2">
                            <label class="form-block">
                                <span class="form-block-title">Корпус</span>
                                <input type="text" class="input cabinet-address-input-data">
                            </label>
                        </div>
                        <div class="col-6 col-lg-2">
                            <label class="form-block">
                                <span class="form-block-title">Строение</span>
                                <input type="text" class="input cabinet-address-input-data">
                            </label>
                        </div>
                        <div class="col-6 col-lg-3">
                            <label class="form-block">
                                <span class="form-block-title">Квартира</span>
                                <input type="text" class="input cabinet-address-input-data">
                            </label>
                        </div>
                        <div class="col-6 col-lg-3">
                            <label class="form-block">
                                <span class="form-block-title">Подъезд</span>
                                <input type="text" class="input cabinet-address-input-data">
                            </label>
                        </div>
                        <div class="col-12">
                            <label class="form-block">
                                <span class="form-block-title">Комментарий курьеру:</span>
                                <textarea class="input textarea cabinet-address-input-comment" placeholder="Напишите ваш комментарий"></textarea>
                            </label>
                        </div>
                    </div>
                    <div class="form-footer">
                        <div class="row">
                            <div class="col-auto">
                                <button class="btn btn-full btn-green submit">Сохранить</button>
                            </div>
                            <div class="col-auto">
                                <a href="#" class="btn btn-full cabinet-address-form-del">Отменить</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <template id="cabinet-address-item">
            <div class="cabinet-address-item">
                <div class="cabinet-address-item-head">
                    <div class="cabinet-address-item-title"></div>
                    <div class="cabinet-address-item-city"></div>
                </div>
                <div class="cabinet-address-item-body">
                    <div class="cabinet-address-item-content">
                        <table class="cabinet-address-item-table">
                            <tr>
                                <td>Адрес получения:</td>
                                <td class="cabinet-address-item-data"></td>
                            </tr>
                            <tr>
                                <td>Комментарий курьеру:</td>
                                <td class="cabinet-address-item-comment"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="cabinet-address-form-submit-wrapp submit-wrapp">
                        <div class="btn cabinet-address-form-main-checkbox">
                            <i>
                                <svg width="16" height="16"><use xlink:href="#icon-star"/></svg>
                                <svg width="16" height="16"><use xlink:href="#icon-star-fill"/></svg>
                            </i>
                            <span>Главный адрес</span>
                        </div>
                        <ul class="cabinet-address-form-btns">
                            <li>
                                <a href="#" class="btn btn-full cabinet-address-item-edit">Редактировать</a>
                            </li>
                            <li>
                                <a href="#" class="btn btn-full cabinet-address-item-del">Удалить</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="cabinet-address-item-form"></div>
            </div>
        </template>
        <div class="cabinet-address-list"></div>
    </div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>