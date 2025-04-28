<?php

namespace Pratiksh\Imperium\Services\Resource\Navigation;

class MenuItem
{
    //    Menu Type
    public const ROUTE = 'route';

    public const URL = 'url';

    public string $type = self::ROUTE;

    public string $label;

    public ?string $description = null;

    public ?string $icon = 'pi pi-circle';

    public ?string $url;

    public ?array $items = null;

    public ?string $badge;

    public ?string $shortcut;

    public bool $authorize = true;

    public function __construct(string $label)
    {
        $this->label = $label;
    }

    public static function make(string $label): self
    {
        return new static($label);
    }

    public function type(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function authorize(bool $authorize = true): self
    {
        $this->authorize = $authorize;

        return $this;
    }

    public function url(?string $url = null): self
    {
        $this->url = $url;

        return $this;
    }

    public function description(?string $description = null): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Set the icon for this menu item.
     *
     * @return $this
     */
    public function icon(?string $icon = null): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function badge(?string $badge = null): self
    {
        $this->badge = $badge;

        return $this;
    }

    public function shortcut(?string $shortcut = null): self
    {
        $this->shortcut = $shortcut;

        return $this;
    }

    public function child(?MenuItem $child = null): self
    {
        if ($child !== null) {
            $this->items[] = $child;
        }

        return $this;
    }

    public function children(?array $items = null): self
    {
        $this->items = ! is_null($items) ? $items : null;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'label' => $this->label,
            'icon' => $this->icon,
            'url' => $this->url,
            'items' => $this->items,
            'badge' => $this->badge,
            'authorize' => $this->authorize,
        ];
    }
}
