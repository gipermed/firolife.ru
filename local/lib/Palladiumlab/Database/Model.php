<?php

namespace Palladiumlab\Database;

interface Model
{
    public static function findById(int $id);

    public static function findOne();

    public static function find();

    public function getModelName(): string;

    public function isExists(): bool;

    public function save();

    public function toArray(): array;

    public function toJson(): string;
}