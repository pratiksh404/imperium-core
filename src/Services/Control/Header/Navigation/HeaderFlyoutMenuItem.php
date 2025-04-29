<?php

namespace Pratiksh\Imperium\Services\Control\Header\Navigation;

class HeaderFlyoutMenuItem
{
    public string $label;

    public array $items = [];

    public HeaderFlyoutMenuItemFooter $footer;

    public bool $authorize = true;

    final public function __construct(string $label)
    {
        $this->label = $label;
    }

    public static function make(string $label): self
    {
        return new static($label);
    }

    public function authorize(bool $authorize = true): self
    {
        $this->authorize = $authorize;

        return $this;
    }

    public function children(array $items): self
    {
        $this->items = $items;

        return $this;
    }

    public function footer(HeaderFlyoutMenuItemFooter $footer): self
    {
        $this->footer = $footer;

        return $this;
    }
}

class HeaderFlyoutMenuItemFooter
{
    public ?string $title = null;

    public ?string $description = null;

    public ?string $badge = null;

    public $items = [];

    public bool $authorize = true;

    // Footer Item Orientation
    const VERTICAL = 'vertical';

    const HORIZONTAL = 'horizontal';

    public string $orientation = self::VERTICAL;

    public function title(?string $title = null): self
    {
        $this->title = $title;

        return $this;
    }

    public function description(?string $description = null): self
    {
        $this->description = $description;

        return $this;
    }

    public function badge(?string $badge = null): self
    {
        $this->badge = $badge;

        return $this;
    }

    public function authorize(bool $authorize = true): self
    {
        $this->authorize = $authorize;

        return $this;
    }

    public function children(array $items): self
    {
        $this->items = $items;

        return $this;
    }
}
