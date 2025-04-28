<?php

namespace Pratiksh\Imperium\Services\Resource\Navigation;

class Navigation
{
    public array $menus = [];

    public array $headers = [];

    public function menus(array $menus): self
    {
        $this->menus = $menus;

        return $this;
    }

    public function headers(array $headers): self
    {
        $this->headers = $headers;

        return $this;
    }
}
