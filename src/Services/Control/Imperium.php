<?php

namespace Pratiksh\Imperium\Services\Control;

use Pratiksh\Imperium\Services\Control\Header\Header;

abstract class Imperium
{
    const HOME = 'dashboard';

    const THEME_SWITCHER = true;

    abstract public function menu(): Menu;

    abstract public function header(): Header;

    abstract public function sidebar(): Sidebar;

    public function homeRoute(): string
    {
        return route(static::HOME);
    }
}
