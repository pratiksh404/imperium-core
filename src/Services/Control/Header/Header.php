<?php

namespace Pratiksh\Imperium\Services\Control\Header;

use Pratiksh\Imperium\Services\Control\Header\Navigation\HeaderNavigation;

class Header
{
    public bool $includeThemeSwitcher = true;

    public bool $includeHeaderMenu = true;

    public bool $includeBreadcrumb = true;

    public HeaderNavigation $navigation;

    public function navigation(HeaderNavigation $navigation): self
    {
        $this->navigation = $navigation;

        return $this;
    }

    public function includeThemeSwitcher(bool $includeThemeSwitcher): self
    {
        $this->includeThemeSwitcher = $includeThemeSwitcher;

        return $this;
    }

    public function includeHeaderMenu(bool $includeHeaderMenu): self
    {
        $this->includeHeaderMenu = $includeHeaderMenu;

        return $this;
    }

    public function includeBreadcrumb(bool $includeBreadcrumb): self
    {
        $this->includeBreadcrumb = $includeBreadcrumb;

        return $this;
    }
}
