<?php

namespace Pratiksh\Imperium\Services\Resource\Navigation;

class Breadcrumb
{
    public string $title;

    public string $for;

    public ?array $items;

    final public function __construct(string $title, string $for)
    {
        $this->title = $title;
        $this->for = $for;
    }

    public static function make(string $title, string $for): self
    {
        return new static($title, $for);
    }

    public function items(array $items): self
    {
        $this->items = $items;

        return $this;
    }

    public function item(BreadcrumbItem $item): self
    {
        $this->items[] = $item;

        return $this;
    }
}

class BreadcrumbItem
{
    public string $label;

    public string $route;

    final public function __construct(string $label, string $route)
    {
        $this->label = $label;
        $this->route = $route;
    }

    public static function make(string $label, string $route): self
    {
        return new static($label, $route);
    }
}
