<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $mobileColumns
 * @var array $arParams
 * @var string $templateFolder
 */

$usePriceInAdditionalColumn = in_array('PRICE', $arParams['COLUMNS_LIST']) && $arParams['PRICE_DISPLAY_MODE'] === 'Y';
$useSumColumn = in_array('SUM', $arParams['COLUMNS_LIST']);
$useActionColumn = in_array('DELETE', $arParams['COLUMNS_LIST']);

$restoreColSpan = 2 + $usePriceInAdditionalColumn + $useSumColumn + $useActionColumn;

$positionClassMap = array(
	'left' => 'basket-item-label-left',
	'center' => 'basket-item-label-center',
	'right' => 'basket-item-label-right',
	'bottom' => 'basket-item-label-bottom',
	'middle' => 'basket-item-label-middle',
	'top' => 'basket-item-label-top'
);

$discountPositionClass = '';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION']))
{
	foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos)
	{
		$discountPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

$labelPositionClass = '';
if (!empty($arParams['LABEL_PROP_POSITION']))
{
	foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos)
	{
		$labelPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}
?>
<script id="basket-item-template" type="text/html">
    {{^SHOW_RESTORE}}
    <div class="cart-item" id="basket-item-{{ID}}" data-entity="basket-item" data-id="{{ID}}">
        <?/*label class="cart-item-checkbox checkbox-label">
            <input type="checkbox" class="checkbox-input">
        </label*/?>
        <div class="cart-item-product">
            <a  href="{{DETAIL_PAGE_URL}}" class="item-link" aria-label="На
            страницу продукта"></a>
            <div class="cart-item-product-img">
                <img alt="{{NAME}}"
                     src="{{{IMAGE_URL}}}{{^IMAGE_URL}}<?=$templateFolder?>/images/no_photo.png{{/IMAGE_URL}}">
            </div>
            <div class="cart-item-product-body">
                {{#PRODUCT_ARTICLE}}
                <div class="cart-item-product-code">Артикул: <b>{{{PRODUCT_ARTICLE}}}</b></div>
                {{/PRODUCT_ARTICLE}}
                <div class="cart-item-product-title">{{NAME}}</div>
                <?/*{{#SKU_BLOCK_LIST}}
                    {{#SKU_VALUES_LIST}}
                        <ul class="cart-item-product-info">
                            <li>
                                {{NAME}}:
                                {{#SELECTED}}{{NAME}}{{/SELECTED}}
                            </li>
                        </ul>
                    {{/SKU_VALUES_LIST}}
                {{/SKU_BLOCK_LIST}}*/?>
            </div>
        </div>
        <div class="cart-item-info">
            <div class="cart-item-prices">

                {{#DISCOUNT_PRICE_PERCENT}}
                    <div class="cart-item-prices__top">
                        <div class="cart-item-price-old">{{{SUM_FULL_PRICE_FORMATED}}}</div>
                        <div class="cart-item-prices__discount">-{{{DISCOUNT_PRICE_PERCENT}}}%</div>
                    </div>
                {{/DISCOUNT_PRICE_PERCENT}}

                <div class="cart-item-price" id="basket-item-sum-price-{{ID}}">{{{SUM_PRICE_FORMATED}}}</div>
            </div>
            <div class="cart-item-number">

                <div class="select-number" data-entity="basket-item-quantity-block">
                    <button type="button" data-entity="basket-item-quantity-minus" class="select-number-btn
                    select-number-btn-minus" aria-label="Убавить"></button>
                    <input type="text"  class="select-number-input"
                           data-min="1" data-max="99" value="{{QUANTITY}}" data-value="{{QUANTITY}}"
                           data-entity="basket-item-quantity-field"
                           id="basket-item-quantity-{{ID}}">
                    <button type="button" data-entity="basket-item-quantity-plus" class="select-number-btn
                    select-number-btn-plus" aria-label="Прибавить"></button>
                </div>
                <?/*div class="cart-item-number-unit active">{{{PRICE_FORMATED}}}/ед.</div*/?>


            </div>
            <a href="javascript:void(0)" class="cart-item-del" data-entity="basket-item-delete">
                <span>Убрать из заказа</span>
            </a>
        </div>
    {{/SHOW_RESTORE}}

    {{#SHOW_RESTORE}}
        <td class="basket-items-list-item-notification" colspan="<?=$restoreColSpan?>">
            <div class="basket-items-list-item-notification-inner basket-items-list-item-notification-removed" id="basket-item-height-aligner-{{ID}}">
                {{#SHOW_LOADING}}
                    <div class="basket-items-list-item-overlay"></div>
                {{/SHOW_LOADING}}
                <div class="basket-items-list-item-removed-container">
                    <div>
                        <?=Loc::getMessage('SBB_GOOD_CAP')?> <strong>{{NAME}}</strong> <?=Loc::getMessage('SBB_BASKET_ITEM_DELETED')?>.
                    </div>
                    <div class="basket-items-list-item-removed-block">
                        <a href="javascript:void(0)" data-entity="basket-item-restore-button">
                            <?=Loc::getMessage('SBB_BASKET_ITEM_RESTORE')?>
                        </a>
                        <span class="basket-items-list-item-clear-btn" data-entity="basket-item-close-restore-button"></span>
                    </div>
                </div>
            </div>
        </td>
    {{/SHOW_RESTORE}}
    </div>

</script>