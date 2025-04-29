<?php

namespace Pratiksh\Imperium\Services\Resource\Navigation;

class PageHeader
{
    public string $title;

    public string $for;

    public ?Breadcrumb $breadcrumb;

    public ?array $points;

    public array $actions;

    final public function __construct(string $title, string $for)
    {
        $this->title = $title;
        $this->for = $for;
    }

    public static function make(string $title, string $for): self
    {
        return new static($title, $for);
    }

    public function breadcrumb(Breadcrumb $breadcrumb): self
    {
        $this->breadcrumb = $breadcrumb;

        return $this;
    }

    public function points(array $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function point(HeaderPoint $point): self
    {
        $this->points[] = $point;

        return $this;
    }
}

class HeaderPoint
{
    public string $information;

    public string $icon;

    public $authorize = true;

    final public function __construct(string $information, ?string $icon = null)
    {
        $this->information = $information;
        $this->icon = $icon;
    }

    public static function make(string $information, ?string $icon = null): self
    {
        return new static($information, $icon);
    }

    public function authorize(bool $authorize = true): self
    {
        $this->authorize = $authorize;

        return $this;
    }
}
