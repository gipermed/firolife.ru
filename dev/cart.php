<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
	$APPLICATION->SetTitle('DEV');
?>

<div class="cart section">
	<div class="cart-body">
		
	</div>

	<div data-entity="basket-total-block">
		<div class="cart-sidebar">

			<div class="cart-total__group">
				<div class="cart-total__title">Промокод</div>
				<input type="text" class="form-control" placeholder="Промокод">
				<a href="#" class="cart-promo-link-tip">Как получить промокод?</a>
			</div>
			<div class="cart-total__group">
				<div class="cart-total__title">
					<span>Бонусные рубли</span>
					<div class="tip-hover">
						<div class="tip-hover__head"><svg class="icon"><use xlink:href="#question-circle-sm"></use></svg></div>
						<div class="tip-hover__body">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis, porro?</div>
					</div>
				</div>
				<div class="cart-total-bonus-group">
					<input type="text" class="form-control" placeholder="Бонусные рубли">
					<div class="btn">Списать</div>
				</div>
				<div class="cart-bonuces-value">Нет бонусных рублей для скидки</div>
			</div>
			<div class="cart-total__group">
				<div class="cart-bonuces-reward">
					<div class="char">Бонусы за заказ</div>
					<div class="val">+45<div class="icon">₽</div></div>
				</div>
			</div>
			<div class="cart-total__group">
				<div class="cart-total__title">Ваш заказ</div>
				<div class="order-total__list">
                    <div class="order-total__item order-total__item--total">
                        <div class="order-total__char">Сумма товаров</div>
                        <div class="order-total__val">46 823 ₽</div>
                    </div>
                    <div class="order-total__list--extra" style="display: block">
                    	<div class="order-total__item order-total__item--total">
	                        <div class="order-total__char">Скидки</div>
	                        <div class="order-total__val">- 1 729 ₽</div>
	                    </div>
	                    <div class="order-total__item">
	                        <div class="order-total__char">Скидки по товарам</div>
	                        <div class="order-total__val">- 1 652 ₽</div>
	                    </div>
	                    <div class="order-total__item">
	                        <div class="order-total__char">Бонусные рубли</div>
	                        <div class="order-total__val">- 77 ₽</div>
	                    </div>
                    </div>
                    <div class="toggle-order-extra open">
                    	<span>Развернуть</span>
                    	<span>Свернуть</span>
                    	<svg class="icon"><use xlink:href="#icon-chevron-down"></use></svg>
                    </div>
                </div>
			</div>
			<div class="cart-sidebar-total">
	            <div class="cart-sidebar-total-title">Итого</div>
	            <div class="cart-sidebar-total-sum">1&nbsp;319 ₽</div>
	        </div>

	        <div class="order-finish-tip">Внимательно проверьте данные заказа</div>
	        <a href="#" data-entity="basket-checkout-button" class="btn btn-full btn-green cart-btn">Оформить заказ</a>
		</div>
		<div class="cart-delivery-info">
			<div class="cart-delivery-info__item">
				<div class="char">Самовывоз из магазина</div>
				<div class="val">Бесплатно</div>
			</div>
			<div class="cart-delivery-info__item">
				<div class="char">Доставка до пункта выдачи заказов Москва и МО</div>
				<div class="val">от 99 ₽</div>
			</div>
			<div class="cart-delivery-info__item">
				<div class="char">Доставка курьером по Москве и МО</div>
				<div class="val">от 299 ₽</div>
			</div>
			<div class="cart-delivery-info__item cart-delivery-info__item--summ">
				<div class="char">Оплата</div>
				<div class="val">Онлайн или при получении</div>
			</div>
		</div>
	</div>
</div>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>