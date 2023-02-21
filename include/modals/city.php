<?php check_prolog();

$res = \Bitrix\Sale\Location\LocationTable::getList(array(
    'filter' => array('>=TYPE.ID' => '5', '<=TYPE.ID' => '6', '=NAME.LANGUAGE_ID' => LANGUAGE_ID),
    'select' => array('ID','NAME_RU' => 'NAME.NAME')
));

?>

<script>
    $(document).ready(function () {
        $('.cabinet-address-input-city').select2();
    });
</script>

<div id="modal-city" class="modal modal-city">
    <div class="modal-body">
        <a href="#" class="modal-close-btn" aria-label="Закрыть">
            <svg width="24" height="24"><use xlink:href="#icon-close"/></svg>
        </a>
        <div class="modal-title modal-city-title">Выберите ваш город</div>
		<form action="?" class="city-search">
            <label class="form-block" aria-label="Начните вводить название">
                <!--<input name="address" id="answer" type="search" class="input city-search-input" placeholder="Начните вводить название" required >-->

                <select  class="input cabinet-address-input-city"  style="width: 100%">

                    <?
                    while ($item = $res->fetch()) {
                        $loc = getGroupsByLocation($item['ID']);
                        $text = $loc;
                        $region = $loc;

                        unset($region[0],$region[1],$region[2]);
                        unset($text[0],$text[1]);

                        $text = implode(",", $text);
                        $region = implode(",", $region);
                        ?>
                        <option value="<? print_r($text);?>" >
                            <? print_r($text); ?>
                        </option>
                    <?} ?>
                </select>
            </label>
            <button onclick="region();" type="button" class="city-search-submit modal-close-link">
                <svg width="20" height="20"><use xlink:href="#icon-search"/></svg>
            </button>
        </form>
        <div class="modal-city-popular">
            <div class="modal-city-popular-title">Популярные города</div>
            <ul class="modal-city-popular-list">
                <li class="active"><a name = "Москва" href="#" onclick="ans(this);">Москва</a></li>
                <li><a name = "Тула" href="#" onclick="ans(this);">Тула</a></li>
                <li><a name = "Вологда" href="#" onclick="ans(this);">Вологда</a></li>
                <li><a name = "Казань" href="#" onclick="ans(this);">Казань</a></li>
                <li><a name = "Краснодар" href="#" onclick="ans(this);">Краснодар</a></li>
                <li><a name = "Новосибирск" href="#" onclick="ans(this);">Новосибирск</a></li>
                <li><a name = "Ростов-на-Дону" href="#" onclick="ans(this);">Ростов-на-Дону</a></li>
                <li><a name = "Чебоксары" href="#" onclick="ans(this);">Чебоксары</a></li>
                <li><a name = "Владимир" href="#" onclick="ans(this);">Владимир</a></li>
                <li><a name = "Брянск" href="#" onclick="ans(this);">Брянск </a></li>
                <li><a name = "Воронеж" href="#" onclick="ans(this);">Воронеж</a></li>
                <li><a name = "Калининград" href="#" onclick="ans(this);">Калининград </a></li>
                <li><a name = "Красноярск" href="#" onclick="ans(this);">Красноярск</a></li>
                <li><a name = "Омск" href="#" onclick="ans(this);">Омск</a></li>
                <li><a name = "Рязань" href="#" onclick="ans(this);">Рязань</a></li>
                <li><a name = "Челябинск" href="#" onclick="ans(this);">Челябинск</a></li>
                <li><a name = "Санкт-Петербург" href="#" onclick="ans(this);">Санкт-Петербург</a></li>
                <li><a name = "Владивосток" href="#" onclick="ans(this);">Владивосток </a></li>
                <li><a name = "Екатеринбург" href="#" onclick="ans(this);">Екатеринбург</a></li>
                <li><a name = "Калуга" href="#" onclick="ans(this);">Калуга </a></li>
                <li><a name = "Липецк" href="#" onclick="ans(this);">Липецк</a></li>
                <li><a name = "Орел" href="#" onclick="ans(this);">Орел</a></li>
                <li><a name = "Самара" href="#" onclick="ans(this);">Самара</a></li>
                <li><a name = "Ярославль" href="#" onclick="ans(this);">Ярославль</a></li>
                <li><a name = "Тверь" href="#" onclick="ans(this);">Тверь</a></li>
                <li><a name = "Волгоград" href="#" onclick="ans(this);">Волгоград </a></li>
                <li><a name = "Иваново" href="#" onclick="ans(this);">Иваново</a></li>
                <li><a name = "Кострома" href="#" onclick="ans(this);">Кострома </a></li>
                <li><a name = "Нижний Новгород" href="#" onclick="ans(this);">Нижний Новгород</a></li>
                <li><a name = "Пермь" href="#" onclick="ans(this);">Пермь</a></li>
                <li><a name = "Тюмень" href="#" onclick="ans(this);">Тюмень</a></li>
                <li><a name = "Чита" href="#" onclick="ans(this);">Чита</a></li>
            </ul>
        </div>
    </div>
</div>
