<?php


namespace Palladiumlab\Support\Bitrix;


use CAllDBResult;
use Generator;
use Illuminate\Support\Collection;

class Resource
{
    public const TYPE_FETCH = 'fetch';
    public const TYPE_NEXT = 'next';

    protected CAllDBResult $resource;

    public function __construct(CAllDBResult $resource)
    {
        $this->resource = $resource;
    }

    public function toArray(string $type = 'fetch'): array
    {
        return iterator_to_array($this->toGenerator($type), false);
    }

    public function toCollection(string $type = 'fetch'): Collection
    {
        return new Collection($this->toArray($type));
    }

    public function toGenerator(string $type = 'fetch'): Generator
    {
        switch ($type) {
            case self::TYPE_NEXT:
                while ($element = $this->resource->getNext()) {
                    yield $element;
                }
                break;

            case self::TYPE_FETCH:
            default:
                while ($element = $this->resource->fetch()) {
                    yield $element;
                }
                break;
        }
    }
}