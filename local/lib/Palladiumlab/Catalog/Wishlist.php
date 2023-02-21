<?php


namespace Palladiumlab\Catalog;

use Bitrix\Main\Result;
use Palladiumlab\Management\User;
use Palladiumlab\Orm\WishlistTable;
use Palladiumlab\Support\Bitrix\Bitrix;
use Palladiumlab\Support\Bitrix\Cookie;
use Palladiumlab\Support\Util\Arr;

/**
 * Working with current user only (auth/not auth)
 *
 * Class Wishlist
 * @package Palladiumlab\Catalog
 */
class Wishlist
{
    public const COOKIE_NAME = 'wishlist';
    public const COOKIE_TIME = 60 * 60 * 24 * 7;

    protected static array $state;
    protected ?User $user;
    protected Cookie $cookie;

    public function __construct()
    {
		Bitrix::modules('highloadblock');

		$this->user = User::current();

		$this->cookie = new Cookie();

		if (empty(static::$state))
		{
			static::$state = $this->loadCurrentState();
		}
	}

    protected function loadCurrentState(): array
    {
		if ($this->user)
		{
			/** @noinspection PhpUnhandledExceptionInspection */
			return array_map(static function (array $wishlistItem) {
				return (int)$wishlistItem['UF_PRODUCT'];
			}, WishlistTable::getList([
				'filter' => ['UF_USER' => $this->user->id],
				'select' => ['UF_PRODUCT'],
			])->fetchAll());
		}
		if ($this->cookie->get(static::COOKIE_NAME)) /** @noinspection JsonEncodingApiUsageInspection */ return array_map('intval', json_decode($this->cookie->get(static::COOKIE_NAME), true)); else
		{
			return [];
		}
    }

    public function add(int $productId): ?Result
    {
        if ($productId <= 0 || in_array($productId, static::$state, true)) {
            return null;
        }

        if ($this->user) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $result = WishlistTable::add([
                'UF_USER' => $this->user->id,
                'UF_PRODUCT' => $productId,
            ]);
            if ($result->isSuccess()) {
                static::$state[] = $productId;
            }

            return $result;
        }

        static::$state[] = $productId;
        $this->saveCookieState();

        return new Result();
    }

    protected function saveCookieState(): void
    {
        /** @noinspection JsonEncodingApiUsageInspection */
        $this->cookie->add(static::COOKIE_NAME, json_encode(self::$state), static::COOKIE_TIME);
    }

    public function exists(int $productId): bool
    {
        return in_array($productId, static::$state, true);
    }

    public function remove(int $productId): ?Result
    {
        if ($productId <= 0 || !in_array($productId, static::$state, true)) {
            return null;
        }

        if ($this->user) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $primary = (int)WishlistTable::getRow([
                'filter' => [
                    'UF_USER' => $this->user->id,
                    'UF_PRODUCT' => $productId,
                ],
                'select' => ['ID'],
            ])['ID'];

            if ($primary > 0) {
                /** @noinspection PhpUnhandledExceptionInspection */
                $result = WishlistTable::delete($primary);

                if ($result->isSuccess()) {
                    unset(static::$state[array_search($productId, static::$state, true)]);
                }

                return $result;
            }

            return null;
        }

        unset(static::$state[array_search($productId, static::$state, true)]);

        $this->saveCookieState();

        return new Result();
    }

    public function state(): array
    {
        return self::$state;
    }

    public function clear()
    {
        $result = new Result();

        if ($this->user) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $primaries = Arr::pluck(WishlistTable::getList([
                'filter' => ['UF_USER' => $this->user->id],
                'select' => ['ID'],
            ])->fetchAll(), 'UF_PRODUCT', 'ID');

            if (!empty($primaries)) {
                foreach ($primaries as $primary => $productId) {
                    /** @noinspection PhpUnhandledExceptionInspection */
                    $result = WishlistTable::delete($primary);

                    if (!$result->isSuccess()) {
                        return $result;
                    }

                    unset(static::$state[array_search($productId, static::$state, true)]);
                }
            }

            return $result;
        }

        static::$state = [];

        $this->saveCookieState();

        return new Result();
    }
}