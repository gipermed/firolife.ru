<?php


namespace Palladiumlab\Orm;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\SystemException;

Loc::loadMessages(__FILE__);

/**
 * Class WishlistTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> UF_USER int optional
 * <li> UF_PRODUCT int optional
 * </ul>
 *
 * @package Palladiumlab\Orm
 **/
class WishlistTable extends DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return 'pl_wishlist';
    }

    /**
     * Returns entity map definition.
     *
     * @return array
     * @throws SystemException
     */
    public static function getMap(): array
    {
        return [
            new IntegerField('ID', [
                'primary' => true,
                'autocomplete' => true,
                'title' => Loc::getMessage('WISHLIST_ENTITY_ID_FIELD')
            ]),
            new IntegerField('UF_USER', [
                'title' => Loc::getMessage('WISHLIST_ENTITY_UF_USER_FIELD')
            ]),
            new IntegerField('UF_PRODUCT', [
                'title' => Loc::getMessage('WISHLIST_ENTITY_UF_PRODUCT_FIELD')
            ]),
        ];
    }
}