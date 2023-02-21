<?php check_prolog();

use Bitrix\Main\Context;
use Palladiumlab\Support\Bitrix\Sale\BasketManager;

/**
 * @var array $arResult
 * @var array $arParams
 */

$r = Context::getCurrent()->getRequest();

$basketManager = BasketManager::createFromCurrent();

$products = array_column($arResult['BASKET_ITEMS'], 'JS_DATA');
?>

<?php if (!empty($arResult['ERRORS'])) { ?>
    <?php foreach ($arResult['ERRORS'] as $error) { ?>
        <span style="color: #e53636"><?= $error ?></span>
    <?php } ?>
<?php } ?>

<cart-table class="js-vue-app" :base-items="<?= e(json_encode($products)) ?>"></cart-table>
