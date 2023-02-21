<?php check_prolog();

use Bitrix\Main\Context;

/**
 * @var CMain $APPLICATION
 * @var array $arResult
 */

$r = Context::getCurrent()->getRequest();

?>
<form action="?"
      class="registration-form form">

	<?= bitrix_sessid_post() ?>
    <input type="hidden"
           name="action"
           value="register">
    <div id="phone-block-reg">
        <label class="form-block"
               aria-label="Имя">
            <input type="text"
                   class="input"
                   placeholder="Имя"
                   required
                   name="name"
                   value="<?= $r['name'] ?>">
        </label>

        <label class="form-block"
               aria-label="Телефон">
            <input type="tel"
                   class="input"
                   placeholder="+7 (777) 777-77-77"
                   required
                   name="phone"
                   value="<?= $r['phone'] ?>">
        </label>
        <button class="btn submit btn-full receive-code">
            Получить
            код
        </button>
    </div>

    <div style="display: none"
         id="code-block-reg">
        <label class="form-block"
               aria-label="Код">
            <input type="text"
                   class="input"
                   placeholder="код"
                   required
                   name="tel_code"
                   value="">
        </label>

        <div class="form-block">
            <label class="checkbox-label">
                <input type="checkbox"
                       class="checkbox-input"
                       name="promotion"
                       value="1">
                <span>Хочу участвовать в скидках, акциях и распродажах.</span>
            </label>
        </div>

        <button type="submit"
                class="btn submit btn-full">
            Зарегистрироваться
        </button>

        <div class="form-agreement">
            Нажимая
            кнопку
            «Зарегистрироваться»,
            я
            соглашаюсь
            на
            получение
            информации
            от
            интернет-магазина
            и
            уведомлений
            о
            состоянии
            моих
            заказов,
            а
            также
            принимаю
            условия
            <a href="#">политики
                конфиденциальности</a>.
        </div>
    </div>


</form>
