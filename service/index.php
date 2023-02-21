<? require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetPageProperty('title', 'Мои заказы');

if (!$USER->IsAuthorized())
{
	$_SESSION["BACKURL"] = $APPLICATION->GetCurPage();
	LocalRedirect("/auth/");
}
?>

    
    <div class="cabinet cabinet-service">
        <div class="cabinet-section-title">Возврат</div>
        <div class="content-section section">
            <div class="refund-desc">ООО «ЦТМТ Гипермед» гарантирует возврат товара приобретенного в нашем
                интернет-магазине в течении 7 дней с момента получения.
            </div>
            <div class="refund-title">Условия возврата товара надлежащего качества</div>
            <ul class="info-list">
                <li>Наличие кассового чека
                <li>Сохранение внешнего вида товара (упаковка, ярлыки, бирки, комплектующие, документация)
                <li>Сохранение потребительских свойств товара
                <li>Отсутствие следов эксплуатации товара
                <li>Заполненное заявление на возврат денежных средств
                <li>Заполненное заявление на возврат товара
            </ul>
        </div>
        <div class="content-section section">
            <div class="refund-desc"><span>Направить заявления на возврат денежных средств и на возврат товара покупателя можно на электронную почту</span>
                <a href="mailto:order@gipermed.com" target="_blank">order@gipermed.com</a></div>
            <div class="refund-title refund-title-small">Заявления для заполнения:</div>
            <div class="refund-row flex-row">
                <div class="refund-col flex-row-item">
                    <div class="refund-docs">
                        <ul class="refund-docs-list">
                            <li>
                                <a href="#" class="doc-link">
                                    <img src="img/doc-file-icon.svg" width="25" alt="">
                                    <span class="doc-link-body">
											<span class="doc-link-title">Заявление на возврат денежных средств</span>
											<span class="doc-link-size">Скачать: 14 Кб</span>
										</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="doc-link">
                                    <img src="img/doc-file-icon.svg" width="25" alt="">
                                    <span class="doc-link-body">
											<span class="doc-link-title">Заявление на возврат товара покупателя</span>
											<span class="doc-link-size">Скачать: 27 Кб</span>
										</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="refund-col flex-row-item">
                    <div class="info-alert">
                        <div class="info-alert-icon">
                            <img src="img/alert-icon.svg" alt="">
                        </div>
                        <div class="info-alert-body">Обращаем ваше внимание на то, что возврат денежных средств
                            осуществляется в течение 10 банковских дней.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-section section">
            <div class="refund-desc refund-desc-address"><span>Осуществить возврат товара можно по адресу: <b>121471, г. Москва, Рябиновая улица, дом 53, строение 2</b>, следующими способами:</span>
            </div>
            <div class="refund-row flex-row">
                <div class="refund-col flex-row-item">
                    <ul class="info-list">
                        <li>Отправить Почтой России, транспортной компанией или курьерской службой
                        <li>Привезти лично
                    </ul>
                </div>
                <div class="refund-col flex-row-item">
                    <div class="info-alert">
                        <div class="info-alert-icon">
                            <img src="img/alert-icon.svg" alt="">
                        </div>
                        <div class="info-alert-body">Обращаем ваше внимание на то, что транспортные расходы за возврат
                            товара оплачивает покупатель. В случае повреждения упаковки, или самого товара при
                            транспортировке возврат товара произведен не будет.
                        </div>
                    </div>
                </div>
            </div>
            <div class="refund-desc">По всем вопросам возврата товара, Вы можете обратиться к нашим специалистам по
                телефону <a href="tel:88003014406">8-800-301-44-06</a>, или на электронную почту <a
                        href="mailto:order@gipermed.com" target="_blank">order@gipermed.com</a></div>
        </div>
    </div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>