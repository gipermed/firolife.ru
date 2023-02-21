<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
	$APPLICATION->SetTitle('DEV');
?>

<section class="cabinet s-personal-bonus">
	<div class="cabinet-section-title">Мои бонусные рубли</div>
	<div class="personal-bonus">
		<div class="personal-bonus__main">
			<div class="personal-bonus__thumb">
				<div class="title">У вас нет доступных<br> Бонусных рублей</div>
				<div class="description">Получайте Бонусные рубли за<br> заказы и дополнительные акции</div>
			</div>
			<div class="personal-bouns__tips">
				<div class="bonus-tip">
					<div class="bonus-tip__thumb">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<circle cx="12" cy="12" r="11" fill="white" stroke="#4365AF" stroke-width="2"/>
							<path d="M12.7098 13.8137C15.575 13.8137 17.3346 12.5946 17.3346 10.2479C17.3346 7.88604 15.575 6.66699 12.7098 6.66699H8.22515V14.6822H6.66797V15.7489H8.22515V17.3337H10.2495V15.7489H13.6753V14.6822H10.2495V13.8137H12.7098ZM15.2947 10.2632C15.2947 11.4975 14.3604 12.2137 12.6942 12.2137H10.2495V8.34318H12.6942C14.3604 8.34318 15.2947 9.01366 15.2947 10.2632Z" fill="#4365AF"/>
						</svg>
					</div>
					<div class="bonus-tip__description">Бонусные рубли сразу после выкупа заказа начисляются на счет.</div>
				</div>
				<div class="bonus-tip">
					<div class="bonus-tip__thumb">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M17.8247 7.62015L17.0733 7.01055L16.7233 7.91336C16.7166 7.93058 16.0444 9.6302 15.0122 9.32057C14.7837 9.25199 14.6304 9.11976 14.5299 8.90432C14.2735 8.35522 14.3826 7.36132 14.8077 6.37224C15.3954 5.00458 15.138 3.57148 14.0633 2.22779C13.3074 1.28267 12.3991 0.710497 12.3608 0.686575L11.2603 0L11.2849 1.29693C11.2853 1.3201 11.309 3.62425 9.60293 4.46918C8.55765 4.98685 7.8094 5.84304 7.49592 6.88005C7.20271 7.85018 7.32584 8.91088 7.83379 9.79015C8.04173 10.1501 8.10472 10.4553 8.02113 10.6975C7.90166 11.0434 7.51571 11.2215 7.40023 11.2679C6.18056 11.7577 5.38216 10.1223 5.34989 10.0548L4.79353 8.86735L4.11174 9.98753C3.23617 11.426 2.77344 13.0814 2.77344 14.7747C2.77344 19.8245 6.85241 23.939 11.8888 23.9986C11.9256 23.9996 11.9624 24 11.9994 24H11.9995H11.9996C17.087 24 21.2258 19.8616 21.2258 14.7747C21.2258 11.9892 19.9862 9.3815 17.8247 7.62015ZM9.11411 19.7077L9.11406 19.699C9.10717 19.139 9.21383 18.5384 9.43186 17.9074L11.166 18.4143L11.1835 17.4941C11.2103 16.0848 12.005 15.2197 12.6404 14.7516C12.8033 15.4605 13.0573 16.0925 13.4081 16.6658C13.8081 17.3185 14.1868 17.8717 14.5362 18.3717C14.7607 18.6936 14.888 19.1796 14.8854 19.705V19.7084C14.8854 20.4788 14.5852 21.2033 14.0401 21.7484C13.4955 22.2929 12.7708 22.5928 11.9995 22.5928C11.9994 22.5928 11.9993 22.5928 11.9993 22.5928C10.4089 22.5927 9.11467 21.299 9.11411 19.7077ZM15.8722 21.5646C16.1469 20.9929 16.2924 20.3627 16.2926 19.7099C16.2962 18.8899 16.0824 18.1288 15.6901 17.5662C15.3005 17.0084 14.9673 16.5168 14.6082 15.9308C14.2077 15.2764 13.9669 14.5052 13.8721 13.5731L13.7794 12.662L12.9229 12.9863C12.8426 13.0167 12.1171 13.3028 11.3735 13.9774C10.5849 14.6927 10.0759 15.5773 9.87409 16.5706L8.61633 16.203L8.36806 16.7692C7.9186 17.7943 7.69616 18.7843 7.70691 19.712C7.70756 20.376 7.85982 21.0051 8.1308 21.5667C5.77313 20.2188 4.18059 17.6793 4.18059 14.7747C4.18059 13.718 4.39299 12.6791 4.80084 11.7186C4.86337 11.7877 4.92988 11.8568 5.00038 11.9247C5.86225 12.7543 6.90072 12.9847 7.92446 12.5737C8.61605 12.2961 9.13606 11.7796 9.35118 11.1568C9.50433 10.7134 9.5768 9.99424 9.05219 9.08617C8.73337 8.53427 8.65902 7.89535 8.84285 7.28716C9.04262 6.62633 9.5343 6.0734 10.2274 5.73013C11.686 5.00772 12.2823 3.65155 12.5255 2.62279C12.679 2.77374 12.8367 2.94471 12.9849 3.13272C13.7079 4.04937 13.8861 4.95237 13.5147 5.81668C12.9207 7.19902 12.8235 8.57578 13.2547 9.49956C13.5256 10.08 13.9935 10.4841 14.6078 10.6684C15.5734 10.9582 16.5178 10.6209 17.2671 9.7189C17.3844 9.57771 17.488 9.43394 17.5781 9.2958C19.0113 10.7521 19.8185 12.7055 19.8185 14.7747C19.8186 17.6778 18.2278 20.2161 15.8722 21.5646Z" fill="#FF4500"/>
						</svg>
					</div>
					<div class="bonus-tip__description">Бонусные рубли сгорят, если вы не сделаете ни одного заказа в течение 12 месяцев</div>
				</div>
			</div>
		</div>
		<div class="personal-bonus__info">
			<div class="personal-bonus__description">Вы можете использовать Бонусные рубли для получения дополнительной скидки при оформлении заказа, но не более 10% суммарной скидки по заказу.<br> <b>1 Бонусный рубль = 1 рублю</b></div>
			<div class="personal-bonus__links">
				<a href="#">Как накопить?</a>
				<a href="#">Как потратить?</a>
				<a href="#">Подробнее о бонусной программе</a>
			</div>
		</div>
	</div>
</section>

<br>
<br>
<br>
<br>
<br>

<section class="cabinet s-personal-bonus">
	<div class="cabinet-section-title">Мои бонусные рубли</div>
	<div class="personal-bonus has-bonuns">
		<div class="personal-bonus__main">
			<div class="personal-bonus__thumb">
				<div class="title">На счету</div>
				<div class="bonus-main">
					<div class="bonus-main__thumb">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M22.9088 12.1007V8.7275C22.9088 7.5837 22.0216 6.6535 20.9006 6.56329L17.7681 1.09179C17.4778 0.585754 17.009 0.224073 16.4481 0.0738875C15.8899 -0.0752748 15.3061 0.00306481 14.8064 0.293873L4.06783 6.5457H2.1818C0.978529 6.5457 0 7.52418 0 8.7275V21.8182C0 23.0215 0.978478 24 2.1818 24H20.727C21.9302 24 22.9088 23.0215 22.9088 21.8182V18.445C23.5423 18.2191 23.9996 17.6194 23.9996 16.9092V13.6365C23.9996 12.9263 23.5423 12.3266 22.9088 12.1007ZM19.633 6.5457H14.8789L18.4445 4.4698L19.633 6.5457ZM17.9025 3.52313L12.7108 6.5457H10.5573L17.3641 2.5827L17.9025 3.52313ZM15.3556 1.23666C15.6022 1.0923 15.8904 1.05395 16.1658 1.12748C16.4444 1.20204 16.6766 1.38209 16.821 1.63403L16.8221 1.63603L8.38935 6.5457H6.23598L15.3556 1.23666ZM21.8178 21.8182C21.8178 22.4195 21.3283 22.9091 20.727 22.9091H2.1818C1.58045 22.9091 1.09093 22.4195 1.09093 21.8182V8.7275C1.09093 8.12615 1.58045 7.63663 2.1818 7.63663H20.727C21.3283 7.63663 21.8178 8.12615 21.8178 8.7275V12.0002H18.5452C16.7405 12.0002 15.2725 13.4682 15.2725 15.2728C15.2725 17.0775 16.7405 18.5455 18.5452 18.5455H21.8178V21.8182ZM22.9088 16.9092C22.9088 17.2101 22.6643 17.4546 22.3633 17.4546H18.5452C17.3419 17.4546 16.3634 16.4762 16.3634 15.2728C16.3634 14.0696 17.3418 13.091 18.5452 13.091H22.3633C22.6642 13.091 22.9088 13.3355 22.9088 13.6365V16.9092Z" fill="white"/>
							<path d="M18.544 14.1821C17.9426 14.1821 17.4531 14.6716 17.4531 15.273C17.4531 15.8744 17.9426 16.3639 18.544 16.3639C19.1454 16.3639 19.6349 15.8744 19.6349 15.273C19.6349 14.6716 19.1454 14.1821 18.544 14.1821Z" fill="white"/>
						</svg>
					</div>
					<div class="bonus-main__value">445</div>
					<div class="bonus-main__icon">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<circle cx="12" cy="12" r="11" fill="white" stroke="#4365AF" stroke-width="2"/>
							<path d="M12.7098 13.8137C15.575 13.8137 17.3346 12.5946 17.3346 10.2479C17.3346 7.88604 15.575 6.66699 12.7098 6.66699H8.22515V14.6822H6.66797V15.7489H8.22515V17.3337H10.2495V15.7489H13.6753V14.6822H10.2495V13.8137H12.7098ZM15.2947 10.2632C15.2947 11.4975 14.3604 12.2137 12.6942 12.2137H10.2495V8.34318H12.6942C14.3604 8.34318 15.2947 9.01366 15.2947 10.2632Z" fill="#4365AF"/>
						</svg>
					</div>
				</div>
				<div class="title">Бонусных рублей</div>
				<div class="description">Получайте Бонусные рубли за<br> заказы и дополнительные акции</div>
			</div>
			<div class="personal-bouns__tips">
				<div class="bonus-tip">
					<div class="bonus-tip__thumb">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<circle cx="12" cy="12" r="11" fill="white" stroke="#4365AF" stroke-width="2"/>
							<path d="M12.7098 13.8137C15.575 13.8137 17.3346 12.5946 17.3346 10.2479C17.3346 7.88604 15.575 6.66699 12.7098 6.66699H8.22515V14.6822H6.66797V15.7489H8.22515V17.3337H10.2495V15.7489H13.6753V14.6822H10.2495V13.8137H12.7098ZM15.2947 10.2632C15.2947 11.4975 14.3604 12.2137 12.6942 12.2137H10.2495V8.34318H12.6942C14.3604 8.34318 15.2947 9.01366 15.2947 10.2632Z" fill="#4365AF"/>
						</svg>
					</div>
					<div class="bonus-tip__description">Бонусные рубли сразу после выкупа заказа начисляются на счет.</div>
				</div>
				<div class="bonus-tip">
					<div class="bonus-tip__thumb">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M17.8247 7.62015L17.0733 7.01055L16.7233 7.91336C16.7166 7.93058 16.0444 9.6302 15.0122 9.32057C14.7837 9.25199 14.6304 9.11976 14.5299 8.90432C14.2735 8.35522 14.3826 7.36132 14.8077 6.37224C15.3954 5.00458 15.138 3.57148 14.0633 2.22779C13.3074 1.28267 12.3991 0.710497 12.3608 0.686575L11.2603 0L11.2849 1.29693C11.2853 1.3201 11.309 3.62425 9.60293 4.46918C8.55765 4.98685 7.8094 5.84304 7.49592 6.88005C7.20271 7.85018 7.32584 8.91088 7.83379 9.79015C8.04173 10.1501 8.10472 10.4553 8.02113 10.6975C7.90166 11.0434 7.51571 11.2215 7.40023 11.2679C6.18056 11.7577 5.38216 10.1223 5.34989 10.0548L4.79353 8.86735L4.11174 9.98753C3.23617 11.426 2.77344 13.0814 2.77344 14.7747C2.77344 19.8245 6.85241 23.939 11.8888 23.9986C11.9256 23.9996 11.9624 24 11.9994 24H11.9995H11.9996C17.087 24 21.2258 19.8616 21.2258 14.7747C21.2258 11.9892 19.9862 9.3815 17.8247 7.62015ZM9.11411 19.7077L9.11406 19.699C9.10717 19.139 9.21383 18.5384 9.43186 17.9074L11.166 18.4143L11.1835 17.4941C11.2103 16.0848 12.005 15.2197 12.6404 14.7516C12.8033 15.4605 13.0573 16.0925 13.4081 16.6658C13.8081 17.3185 14.1868 17.8717 14.5362 18.3717C14.7607 18.6936 14.888 19.1796 14.8854 19.705V19.7084C14.8854 20.4788 14.5852 21.2033 14.0401 21.7484C13.4955 22.2929 12.7708 22.5928 11.9995 22.5928C11.9994 22.5928 11.9993 22.5928 11.9993 22.5928C10.4089 22.5927 9.11467 21.299 9.11411 19.7077ZM15.8722 21.5646C16.1469 20.9929 16.2924 20.3627 16.2926 19.7099C16.2962 18.8899 16.0824 18.1288 15.6901 17.5662C15.3005 17.0084 14.9673 16.5168 14.6082 15.9308C14.2077 15.2764 13.9669 14.5052 13.8721 13.5731L13.7794 12.662L12.9229 12.9863C12.8426 13.0167 12.1171 13.3028 11.3735 13.9774C10.5849 14.6927 10.0759 15.5773 9.87409 16.5706L8.61633 16.203L8.36806 16.7692C7.9186 17.7943 7.69616 18.7843 7.70691 19.712C7.70756 20.376 7.85982 21.0051 8.1308 21.5667C5.77313 20.2188 4.18059 17.6793 4.18059 14.7747C4.18059 13.718 4.39299 12.6791 4.80084 11.7186C4.86337 11.7877 4.92988 11.8568 5.00038 11.9247C5.86225 12.7543 6.90072 12.9847 7.92446 12.5737C8.61605 12.2961 9.13606 11.7796 9.35118 11.1568C9.50433 10.7134 9.5768 9.99424 9.05219 9.08617C8.73337 8.53427 8.65902 7.89535 8.84285 7.28716C9.04262 6.62633 9.5343 6.0734 10.2274 5.73013C11.686 5.00772 12.2823 3.65155 12.5255 2.62279C12.679 2.77374 12.8367 2.94471 12.9849 3.13272C13.7079 4.04937 13.8861 4.95237 13.5147 5.81668C12.9207 7.19902 12.8235 8.57578 13.2547 9.49956C13.5256 10.08 13.9935 10.4841 14.6078 10.6684C15.5734 10.9582 16.5178 10.6209 17.2671 9.7189C17.3844 9.57771 17.488 9.43394 17.5781 9.2958C19.0113 10.7521 19.8185 12.7055 19.8185 14.7747C19.8186 17.6778 18.2278 20.2161 15.8722 21.5646Z" fill="#FF4500"/>
						</svg>
					</div>
					<div class="bonus-tip__description">Бонусные рубли сгорят, если вы не сделаете ни одного заказа в течение 12 месяцев</div>
				</div>
			</div>
		</div>
		<div class="personal-bonus__info">
			<div class="personal-bonus__description">Вы можете использовать Бонусные рубли для получения дополнительной скидки при оформлении заказа, но не более 10% суммарной скидки по заказу.<br> <b>1 Бонусный рубль = 1 рублю</b></div>
			<div class="personal-bonus__links">
				<a href="#">Как накопить?</a>
				<a href="#">Как потратить?</a>
				<a href="#">Подробнее о бонусной программе</a>
			</div>
		</div>
	</div>
</section>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>