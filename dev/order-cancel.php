<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
	$APPLICATION->SetTitle('DEV');
?>

	<div class="cabinet cabinet-orders">
		<div class="cabinet-section-title">Отменить заказ</div>
		<div class="order-cancel">
			<div class="order-cancel__return">Вернуться в <a href="#">Мои заказы</a></div>
			<div class="order-cancel__description">
				<span>Вы уверены, что хотите отменить заказ <a href="#">№4353?</a></span>
				<strong>Отмена заказа необратима.</strong>
			</div>
			<div class="order-cancel__reason">Укажите причину отмены заказа:</div>
			<form class="form-order-cancel" action="#" method="POST">
				<textarea class="form-control" name="message" rows="10"></textarea>
				<div class="order-cancel__explain">Если у вас остались вопросы - напишите в службу поддержки на электронную почту: <a href="mailto:order@gipermed.com">order@gipermed.com</a> или&nbsp;свяжитесь с оператором интернет-магазина по телефону: <a href="tel:8 8003014406">8 800 301-44-06</a></div>
				<input type="submit" class="btn btn-submit" value="Отменить заказ">
			</form>

			<div class="order-cancel__success visible">
				<div class="close">
					<svg class="icon"><use xlink:href="#icon-close"></use></svg>
				</div>
				<div class="title">Ваш заказ</div>
				<div class="nubmer">№4353</div>
				<div class="subtitle">отменён</div>
			</div>
		</div>
	</div>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>