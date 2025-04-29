<?php

namespace Pratiksh\Imperium\Services\Resource\Navigation;

use Illuminate\Support\Arr;

class MenuGroup
{
    public string $label;

    public ?string $icon = 'pi pi-circle';

    public ?string $badge;

    public bool $expanded = true;

    public ?array $group = null;

    public $authorize = true;

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

    public function badge(?string $badge = null): self
    {
        $this->badge = $badge;

        return $this;
    }

    public function expanded(bool $expanded = true): self
    {
        $this->expanded = $expanded;

        return $this;
    }

    public function item(?MenuItem $child = null): self
    {
        if ($child !== null) {
            $this->group[] = $child;
        }

        return $this;
    }

    public function group(?array $group = null): self
    {
        if (! is_null($group)) {
            $this->group = Arr::flatten($group);
        }

        return $this;
    }
}
