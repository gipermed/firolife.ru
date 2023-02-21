<? require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetTitle("");
$APPLICATION->SetPageProperty('title', 'Оформление заказа');

use Bitrix\Main\Loader;
use Bitrix\Highloadblock as HL;

Loader::includeModule("highloadblock");
$hlbl = 3; // Указываем ID нашего highloadblock блока к которому будет делать запросы.
$hlblock = HL\HighloadBlockTable::getById($hlbl)->fetch();
$entity = HL\HighloadBlockTable::compileEntity($hlblock);
$entity_data_class = $entity->getDataClass();

$rsData = $entity_data_class::getList(array(
    "select" => array("*"),
    "order" => array("ID" => "ASC"),
    "filter" => array("UF_ID_USER" => $USER->GetID())  // Задаем параметры фильтра выборки
));

/*$rsStore = \Bitrix\Catalog\StoreTable::getList(array(
    'filter' => array('ACTIVE'>='Y'),
));
    $res2 = \Bitrix\Sale\Location\LocationTable::getList(array(
    'filter' => array('>=TYPE.ID' => '5', '<=TYPE.ID' => '6', '=NAME.LANGUAGE_ID' => LANGUAGE_ID),
    'select' => array('ID','NAME_RU' => 'NAME.NAME')
));*/
?>
    <script src="/local/templates/main/assets/js/vendor/jquery.maskedinput.js"></script>
    <script type="text/javascript" src="https://t.gipermed.com/widget/widjet.js" id="ISDEKscript" ></script>
    <link href="/sale/salecss.css" type="text/css" rel="stylesheet"/>
    <script type="text/javascript" src="/sale/salejs.js"></script>

    <div class="form-wrap">
        <div class="profile">
            <img src="https://html5book.ru/wp-content/uploads/2016/10/profile-image.png">
            <h1>Оформление заказа</h1>
        </div>
        <form method="post" action="zakaz.php">
            <div class="blok registr">
                <h4>1 Контактные данные</h4>
                <div class="tel">
                    Введите ваш номер телефона, чтобы мы могли сообщить вам о статусе заказа
                    <input type="text" class="phone" placeholder="Телефон" required>
                    <button type="button" class="check1">Выслать код</button>
                </div>
                <div id="code" class="hidden">
                    <input type="text" name="tel" placeholder="Код подтверждения" required>
                    <button type="button" class="check3 ">Подтвердить</button>
                </div>
            </div>
            <div class="hidden dillev">
                <div class="blok">
                    <h4>2 Доставка</h4>
                    <p>
                        <input class="curradio" name="deliv" type="radio" value="18"> Доставка курьером от <span id='SDEK_cPrice2'></span>
                    </p>
                    <div class="hidden">

                    </div>
                    <p>
                        <input class="punktradio" name="deliv" type="radio" value="19"> Доставка до пункта выдачи заказов от <span id='SDEK_cPrice'></span>

                    </p>
                    <p class="samoviviz hidden">
                        <input class="samradio" name="deliv"  type="radio" value="22"> Самовывоз Бесплатно из магазинов гипермед
                    </p>

                    <div class="fio hidden">
                        <h5>Получатель заказа</h5>
                        <p>
                            Введите ФИО, как в паспорте
                        </p>
                        <p>
                            <input class="fioinput" type="text" required name="fio" placeholder="ФИО">
                        </p>
                    </div>
                    <div class="blok curier hidden">
                        <p>
                            Доставка осуществляется на следующий день после оплаты
                        </p>

                        <h5>Адрес доставки</h5>
                        <p>
                            <input class="myadrradio" name="delivadr" type="radio" value="1" checked=""> Мои адреса
                        </p>
                        <p>
                            <select class="select" name="adrdost">
                                <? foreach ($rsData as $arData) {
                                    ?>
                                    <option  id="adrdost" adr="<?= $arData['UF_CITY']; ?>"
                                            value="<?= $arData['ID']; ?>"><?= $arData['UF_TYPE_ADR']; ?></option>
                                <? } ?>
                            </select>
                        </p>
                        <p>
                            <input class="newadrradio" name="delivadr" type="radio" value="3"> Новый адрес
                        </p>
                        <div class=" newadr hidden">
                            <div class="form-block-select ordering-delivery-city-select">
                                <select  class="select2 input cabinet-address-input-city2" name="selectreg" style="width: 100%">
                                    <?/*
                                    while ($item = $res2->fetch()) {
                                        $loc = getGroupsByLocation($item['ID']);
                                        $text = $loc;
                                        $region = $loc;
                                        unset($region[0],$region[1],$region[2]);
                                        unset($text[0],$text[1]);
                                        $text = implode(",", $text);
                                        $region = implode(",", $region);
                                        ?>
                                        <option adr="<?= $loc[2]; ?>" value="<? print_r($loc[0]);print_r(";");print_r($loc[1]);?>">
                                            <? print_r($text); ?>
                                        </option>
                                    <?} */?>
                                </select>
                            </div>
                            <span class="form-block-title">Адрес</span>
                            <input type="text" name="adres" class="input cabinet-address-input-data">
                            <span class="form-block-title">Комментарий курьеру:</span>
                            <textarea
                                    class="input textarea cabinet-address-input-comment"
                                    placeholder="Напишите ваш комментарий" name="comentcur"></textarea>
                        </div>
                        <button type="button" class="checkcur" >
                            Применить
                        </button>
                    </div>
                    <div class="blok punkt hidden">
                        <p> <a href='javascript:void(0)' onclick='widjet.open()'>Выбрать ПВЗ</a> </p>
                        <div id="linkForWidjet" style="display: none;">
                            <input type='hidden' name='chosenPost' value=''/>
                            <p>Выбран город выдачи заказов: <input type='text' name='cityPost' value=''/></p>
                            <input type='hidden' name='cityIdPost' value=''/>
                            <p>Адрес пункта: <input type='text' name='addresPost' value=''/></p>
                            <p>Стоимость доставки: <input type='text' name='pricePost' value=''/></p>
                            <p>Примерные сроки доставки: <input type='text' name='timePost' value=''/></p>
                            <input type='hidden' name='tarifPost' value=''/>
                        </div>
                    </div>
                    <div class=" blok samovivoz hidden">
                        <div class="form-block-select ordering-delivery-city-select">

                            <select id="selectsam" name="adrsam">
                                <?/*
                                while($arStore=$rsStore->fetch())
                                {?>
                                    <option value="<?= $arStore['TITLE']; ?>"><?= $arStore['TITLE']; ?></option>
                                <?
                                }*/
                                ?>
                            </select>
                            <h5>Оплата</h5>
                            <p>
                                <input  name="PaySystem" type="radio" value="2" checked=""> Онлайн оплата
                            </p>
                            <p>
                                <input  name="PaySystem" type="radio" value="3"> Оплата при получении
                            </p>
                        </div>
                    </div>

                    <div class="blok curieritog hidden">
                        <h5>Адрес доставки</h5>
                        <p id="city">
                        </p>
                        <p>
                        <h5>Стоимость доставки</h5>
                        </p>
                        <p>
                            <span id='SDEK_cPrice3'></span>
                        </p>
                    </div>
                </div>
            </div>
            <button class="hidden send" type="submit">Отправить</button>
        </form>
    </div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>