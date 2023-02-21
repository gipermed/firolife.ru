<?php


namespace Palladiumlab\Deploy\Constants\Dumper;


interface Dumper
{
    public function dump(): ?array;

    public function key(): string;

    public function blockTitle(): string;

    public function itemTitle(array $constant): string;
}