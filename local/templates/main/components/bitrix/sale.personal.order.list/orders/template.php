<link href="/local/templates/.default/css/jquery-ui.min.css" type="text/css" rel="stylesheet"/>
<script src="/local/templates/.default/js/jquery-ui.min.js"></script>
<? /*<script src="https://unpkg.com/vue2-datepicker@2.12.0/lib/index.js" ></script>*/ ?>

<script>
    $(function () {

    });
</script>

<?php ?>
<div id="orders-app" class="personal-page__page my-orders">


    <div class="p-tabs">
        <span @click="selectFilter('current')"
              :class="{ 'p-tabs__item':true, 'p-tabs__item--active': selectedFilter === 'current' }">Текущие заказы</span>
        <span @click="selectFilter('history')"
              :class="{ 'p-tabs__item':true, 'p-tabs__item--active': selectedFilter === 'history' }">История заказов</span>
    </div>

    <form v-if="selectedFilter === 'history'" class="b-form my-orders__form">
        <div class="b-form__group">
            <label class="b-form__group-label">Наименование товара</label>
            <div class="b-form__group-wrap"><input v-model="filterProductName" type="text" class="b-form__group-input">
            </div>
        </div>

        <div class="b-form__group">
            <label class="b-form__group-label">Номер заказа</label>
            <div class="b-form__group-wrap"><input v-model="filterOrderId" type="text" class="b-form__group-input">
            </div>
        </div>

        <div class="b-form__group">
            <label class="b-form__group-label">Дата заказа</label>
            <div class="b-form__group-wrap">
                <span class="b-form__dates-text1">С</span>
                <input v-model="filterDateBegin" name="filterDateBegin" type="text"
                       class="b-form__group-input b-form__dates-input jqui-datepicker" placeholder="__-__-____">
                <span class="b-form__dates-text2">по</span>
                <input v-model="filterDateEnd" name="filterDateEnd" type="text"
                       class="b-form__group-input b-form__dates-input jqui-datepicker" placeholder="__-__-____">
            </div>
        </div>

    </form>


    <div class="my-orders__table">
        <table class="orders-table">
            <thead>
            <tr>
                <th class="number">Номер<br> заказа</th>
                <th class="date">Дата<br> заказа</th>
                <th class="status">Статус<br> заказа</th>
                <th class="status-pay">Статус<br> оплаты</th>
                <th class="sum">Сумма<br> заказа</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in orderListFiltered">
                <td><a :href="item.url">{{ item.id }}</a></td>
                <td class="date">{{ item.date }}</td>
                <td>{{ item.status }}</td>
                <td>{{ item.payment }}</td>
                <td>{{ item.price }} р.</td>
            </tr>
            </tbody>
        </table>
    </div>

</div>

<script>
    console.log(<?=CUtil::PhpToJsObject($arResult)?>);
    initOrdersApp("#orders-app", <?=CUtil::PhpToJsObject($arResult)?> );
</script>