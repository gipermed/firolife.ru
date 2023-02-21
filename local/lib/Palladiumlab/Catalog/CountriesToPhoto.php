<?php
namespace Palladiumlab\Catalog;
use Bitrix\Iblock\Elements\ElementcountriesTable;
use Palladiumlab\Database\Model;
use Bitrix\Main\Type\DateTime;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;
/**
 *
 *
 *
 * @property int|string $id
 * @property bool $active
 * @property string $name
 * @property string $detail_picture
 *
 */
class CountriesToPhoto implements Model,Arrayable,Jsonable
{
	public function __construct(array $attributes = [])
	{
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

			if ($value instanceof DateTime) {
				$value = $value->format('d.m.Y H:i:s');
			}

			if ($value instanceof Arrayable) {
				$value = $value->toArray();
			}

			return [$attribute => $value];
		})->all();
	}

	public function setAttributes(array $newValues): CountriesToPhoto
	{
		foreach (self::getPropertyMap() as $bxKey=>$property)
		{
			$value=$newValues[$property];
			$this->{$property} = $value;
		}
		foreach (self::getAttributesMap() as $bxKey => $attribute) {
			if (!array_key_exists($attribute, $newValues)) {
				continue;
			}

			$value = $newValues[$attribute];

			if (array_key_exists($bxKey, self::getBooleanAttributesMap())) {
				$this->{$attribute} = $value === 'Y' || $value === '1' || $value === true;
				continue;
			}

			$this->{$attribute} = $value;
		}

		return $this;
	}

	protected static function getBooleanAttributesMap(): array
	{
		return [
			'ACTIVE' => 'active',
		];
	}

	protected static function getAttributesMap(): array
	{
		return array_merge([
			'ID' => 'id',
			'CODE' => 'code',
			'NAME' => 'name',
			'DETAIL_PICTURE' => 'detail_picture'
		], self::getBooleanAttributesMap());
	}

	protected static function getPropertyMap():array
	{
		return [];
	}

	protected static function getPropertyMapValue():array
	{
		$ret=[];
		foreach (self::getPropertyMap() as $k=>$v)
		{
			$ret[$k."VALUE"]=$v;
		}
		return $ret;
	}
	protected static function fieldsToAttributes(array $fields): array
	{
		$attributesMap = array_merge(self::getAttributesMap(),self::getPropertyMapValue());

		return collect($fields)->mapWithKeys(fn($value, $key) => [$attributesMap[$key] => $value])->all();
	}

	public static function findById(int $id): ?CharacteristicsToPhoto
	{
		return static::findOne(['=ID' => $id]);
	}

	protected static function getRuntimeFields(): array
	{
		return [];
	}


	public static function findOne(array $filter = []): ?CountriesToPhoto
	{
		/** @noinspection PhpUnhandledExceptionInspection */
		$userFields = ElementcountriesTable::getRow([
			'filter' => $filter,
			'select' => array_merge(array_keys(self::getAttributesMap()),self::getPropertyMap()),
			'runtime' => self::getRuntimeFields(),
		]);
		return $userFields ? new static(self::fieldsToAttributes($userFields)) : null;
	}

	public static function find(array $filter = [], array $order = ['id' => 'desc']): Collection
	{
		/** @noinspection PhpUnhandledExceptionInspection */
		$users = collect(ElementcountriesTable::getList([
			'filter' => $filter,
			'select' => array_merge(array_keys(self::getAttributesMap()),self::getPropertyMap()),
			'runtime' => self::getRuntimeFields(),
			'order' => $order,
		])->fetchAll());

		return $users->map(fn(array $fields) => new static(self::fieldsToAttributes($fields)));
	}


	public function getModelName(): string
	{
		return "countries";
	}

	public function isExists(): bool
	{
		// TODO: Implement isExists() method.
	}

	public function save()
	{
		// TODO: Implement save() method.
	}
}