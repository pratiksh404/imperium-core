<?php

namespace Pratiksh\Imperium\Services\Control;

class Menu
{
    public array $items = [];

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public static function make(array $items): self
    {
        return new static($items);
    }

    public function toArray(): array
    {
        return $this->items;
    }
}
