<?php

/** @noinspection PhpMultipleClassDeclarationsInspection */


namespace Palladiumlab\Management;


use Bitrix\Main\GroupTable;
use Bitrix\Main\UserGroupTable;
use CSite;

class Group
{
    public const CODE_ADMIN = 'admin_group';

    public function getIdByCode(string $code): int
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return (int)GroupTable::getRow([
            'filter' => ['=STRING_ID' => $code],
            'select' => ['ID'],
            'cache' => ['ttl' => 60 * 60 * 24 * 30]
        ])['ID'];
    }

    public function userAdd(int $userId, int $groupId): bool
    {
        if (!$this->userIn($userId, $groupId)) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $result = UserGroupTable::add([
                'USER_ID' => $userId,
                'GROUP_ID' => $groupId,
            ]);

            if ($result->isSuccess()) {
                $_SESSION["SESS_AUTH"]["GROUPS"][] = $groupId;

                return true;
            }
        }

        return false;
    }

    public function userIn(int $userId, int $groupId): bool
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return UserGroupTable::getCount([
                '=USER_ID' => $userId,
                '=GROUP_ID' => $groupId,
            ]) > 0;
    }

    public function userClear(int $userId, array $groups = []): void
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $list = UserGroupTable::getList([
            'filter' => [
                '=USER_ID' => $userId,
                '=GROUP.STRING_ID' => $groups,
            ],
            'select' => ['USER_ID', 'GROUP_ID'],
        ]);

        foreach ($list as $item) {
            /** @noinspection TypeUnsafeArraySearchInspection */
            if (($key = array_search($item['GROUP_ID'], $_SESSION["SESS_AUTH"]["GROUPS"])) && $key !== false) {
                unset($_SESSION["SESS_AUTH"]["GROUPS"][$key]);
            }

            /** @noinspection PhpUnhandledExceptionInspection */
            UserGroupTable::delete([
                'USER_ID' => $item['USER_ID'],
                'GROUP_ID' => $item['GROUP_ID'],
            ]);
        }
    }
}
