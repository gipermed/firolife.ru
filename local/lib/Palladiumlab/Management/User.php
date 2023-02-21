<?php

/** @noinspection PhpMultipleClassDeclarationsInspection */


namespace Palladiumlab\Management;


use BadMethodCallException;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\UserTable;
use CUser;
use Exception;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Palladiumlab\Database\Model;

/**
 * @method bool isAdmin()
 *
 * @property-read Group $group
 *
 * @property int|string $id
 * @property string $login
 * @property string $password
 * @property string $email
 * @property bool $active
 * @property string $gender
 * @property DateTime $date_register
 * @property DateTime $birthday
 * @property DateTime|null $last_login
 * @property string $name
 * @property string $surname
 * @property string $second_name
 * @property string $external_id
 * @property string $site_id
 * @property string $personal_phone
 * @property string $mobile
 *
 * @property bool promotion
 *
 * @property-read string $fio
 */
class User implements Model, Arrayable, Jsonable
{
	protected const GROUP_METHODS = [
		'isAdmin' => Group::CODE_ADMIN,
	];

	public function __construct(array $attributes = [])
	{
		$this->id = (int)$attributes['id'];

		$this->setAttributes($attributes);

		$this->group = new Group();
	}

	public function setAttributes(array $newValues): User
	{
		foreach (self::getAttributesMap() as $bxKey => $attribute)
		{
			if (!array_key_exists($attribute, $newValues))
			{
				continue;
			}

			$value = $newValues[$attribute];

			if (array_key_exists($bxKey, self::getBooleanAttributesMap()))
			{
				$this->{$attribute} = $value === 'Y' || $value === '1' || $value === true;
				continue;
			}

			$this->{$attribute} = $value;
		}

		return $this;
	}

	protected static function getAttributesMap(): array
	{
		return array_merge([
			'ID'                => 'id',
			'LOGIN'             => 'login',
			'PASSWORD'          => 'password',
			'PERSONAL_BIRTHDAY' => 'birthday',
			'EMAIL'             => 'email',
			'DATE_REGISTER'     => 'date_register',
			'LAST_LOGIN'        => 'last_login',
			'NAME'              => 'name',
			'SECOND_NAME'       => 'second_name',
			'LAST_NAME'         => 'surname',
			'XML_ID'            => 'external_id',
			'LID'               => 'site_id',
			'PERSONAL_PHONE'    => 'personal_phone',
			'PERSONAL_MOBILE'   => 'personal_mobile',
			'PHONE_AUTH'        => 'mobile',
			'PERSONAL_GENDER'   => 'gender',
			'FIO'               => 'fio',

		], self::getBooleanAttributesMap());
	}

	protected static function getBooleanAttributesMap(): array
	{
		return [
			'ACTIVE'       => 'active',
			'UF_PROMOTION' => 'promotion',
		];
	}

	public static function current(): ?User
	{
		global $USER;

		return static::findById($USER->getId() ?: 0);
	}

	public static function findById(int $id): ?User
	{
		return static::findOne(['=ID' => $id]);
	}

	public static function findOne(array $filter = []): ?User
	{
		/** @noinspection PhpUnhandledExceptionInspection */
//		$userFields = UserTable::getRow([
//			'filter'  => $filter,
//			'select'  => array_keys(self::getAttributesMap()),
//			'runtime' => self::getRuntimeFields(),
//		]);
//
//		return $userFields ? new static(self::fieldsToAttributes($userFields)) : null;
        return null;
	}

	protected static function getRuntimeFields(): array
	{
		return [
			'FIO' => [
				'data_type'  => 'string',
				'expression' => [
					'CONCAT(%s, " ", %s, " ", %s)',
					'LAST_NAME',
					'NAME',
					'SECOND_NAME'
				],
			]
		];
	}

	protected static function fieldsToAttributes(array $fields): array
	{
		$attributesMap = self::getAttributesMap();

		return collect($fields)->mapWithKeys(fn($value, $key) => [$attributesMap[$key] => $value])->all();
	}

	public static function find(array $filter = [], array $order = ['id' => 'desc']): Collection
	{
		/** @noinspection PhpUnhandledExceptionInspection */
		$users = collect(UserTable::getList([
			'filter'  => $filter,
			'select'  => array_keys(self::getAttributesMap()),
			'runtime' => self::getRuntimeFields(),
			'order'   => $order,
		])->fetchAll());

		return $users->map(fn(array $fields) => new static(self::fieldsToAttributes($fields)));
	}

	public static function authorize(int $userId): bool
	{
		global $USER;

		return $USER->authorize($userId);
	}

	public static function isAuthorized()
	{
		global $USER;

		return $USER->isAuthorized();
	}

	public function addGroup(string $code): bool
	{
		return $this->group->userAdd($this->id, $this->group->getIdByCode($code));
	}

	/**
	 * @param array $fields
	 * @return bool
	 * @throws Exception
	 */
	public function save(array $fields = []): bool
	{
		$bitrixUser = new CUser();
		$attributesFields = [];

		foreach (self::getAttributesMap() as $bxKey => $attribute)
		{
			if (isset($this->{$attribute}))
			{
				$value = $this->{$attribute};

				if (array_key_exists($bxKey, self::getBooleanAttributesMap()))
				{
					if (Str::startsWith($bxKey, 'UF'))
					{
						$attributesFields[$bxKey] = $value ? '1' : '0';
					} else
					{
						$attributesFields[$bxKey] = $value ? 'Y' : 'N';
					}
					continue;
				}

				$attributesFields[$bxKey] = $value;
			}
		}

		$fields = array_merge($attributesFields, $fields);

		unset($fields['FIO']);

		if ($this->isExists())
		{
			unset($fields['ID']);

			if (!$bitrixUser->update($this->id, $fields))
			{
				throw new Exception('Не удалось обновить пользователя: ' . strip_tags($bitrixUser->LAST_ERROR));
			}
		} else
		{
			$userId = (int)$bitrixUser->add($fields);

			if ($userId <= 0)
			{
				throw new Exception('Не удалось создать пользователя: ' . strip_tags($bitrixUser->LAST_ERROR));
			}

			$this->id = $userId;
			$this->reset();
		}

		return true;
	}

	public function isExists(): bool
	{
		if ($this->id <= 0)
		{
			return false;
		}

		/** @noinspection PhpUnhandledExceptionInspection */
		return UserTable::getCount(['=ID' => $this->id]) > 0;
	}

	public function reset(): void
	{
		if ($this->id <= 0)
		{
			return;
		}

		$attributesMap = self::getAttributesMap();

		/** @noinspection PhpUnhandledExceptionInspection */
		$attributes = collect(UserTable::getRow([
			'filter'  => ['=ID' => $this->id],
			'select'  => array_keys($attributesMap),
			'runtime' => self::getRuntimeFields(),
		]))->mapWithKeys(fn($value, $key) => [$attributesMap[$key] => $value])->all();

		$this->setAttributes($attributes);
	}

	public function toJson($options = 0): string
	{
		/** @noinspection JsonEncodingApiUsageInspection */
		return json_encode($this->toArray(), $options ?: JSON_UNESCAPED_UNICODE);
	}

	public function toArray(): array
	{
		return collect(self::getAttributesMap())->mapWithKeys(function ($attribute) {
			$value = $this->{$attribute};

			if ($value instanceof DateTime)
			{
				$value = $value->format('d.m.Y H:i:s');
			}

			if ($value instanceof Arrayable)
			{
				$value = $value->toArray();
			}

			return [$attribute => $value];
		})->all();
	}

	/**
	 * @param $name
	 * @param $arguments
	 * @return bool
	 * @throws Exception
	 */
	public function __call($name, $arguments)
	{
		if (array_key_exists($name, static::GROUP_METHODS))
		{
			return $this->inGroup(static::GROUP_METHODS[$name]);
		}

		throw new BadMethodCallException("Method {$name} not found in " . static::class);
	}

	/**
	 * Метод определяет наличие пользователя в группе
	 *
	 * @param string $code
	 * @return bool
	 */
	public function inGroup(string $code): bool
	{
		return $this->group->userIn($this->id, $this->group->getIdByCode($code));
	}

	public function clearGroup(string $group): void
	{
		$this->clearGroups([$group]);
	}

	/**
	 * @param array $groups
	 */
	public function clearGroups(array $groups = []): void
	{
		$this->group->userClear($this->id, $groups);
	}

	/**
	 * @return string
	 * @throws Exception
	 */
	public function makeUuid(): string
	{
		return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', // 32 bits for "time_low"
			random_int(0, 0xffff), random_int(0, 0xffff),

			// 16 bits for "time_mid"
			random_int(0, 0xffff),

			// 16 bits for "time_hi_and_version",
			// four most significant bits holds version number 4
			random_int(0, 0x0fff) | 0x4000,

			// 16 bits, 8 bits for "clk_seq_hi_res",
			// 8 bits for "clk_seq_low",
			// two most significant bits holds zero and one for variant DCE1.1
			random_int(0, 0x3fff) | 0x8000,

			// 48 bits for "node"
			random_int(0, 0xffff), random_int(0, 0xffff), random_int(0, 0xffff));
	}

	public function remove(): bool
	{
		if ($this->id <= 0)
		{
			return false;
		}

		if (CUser::Delete($this->id))
		{
			$this->id = 0;

			return true;
		}

		return false;
	}

	public function getModelName(): string
	{
		return 'User';
	}
}
