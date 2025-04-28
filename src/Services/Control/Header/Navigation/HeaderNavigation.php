<?php

namespace Pratiksh\Imperium\Services\Control\Header\Navigation;

use Pratiksh\Imperium\Services\Resource\Navigation\MenuItem;

class HeaderNavigation
{
    public $authorize = true;

    public array $profileMenuItems = [];

    public array $headerLinkMenuItems = [];

    public array $headerFlyoutMenuItems = [];

    public function profileMenus(array $profileMenuItems = []): self
    {
        $this->profileMenuItems = (count($profileMenuItems) > 0 ? $profileMenuItems : []) ? $profileMenuItems : [
            MenuItem::make('Profile')->url(route('profile.edit'))->icon('pi pi-user'),
            MenuItem::make('Logout')->url(route('logout'))->icon('pi pi-sign-out'),
        ];

        return $this;
    }

    public function headerLinkMenus(array $headerLinkMenuItems = []): self
    {
        $this->headerLinkMenuItems = $headerLinkMenuItems;

        return $this;
    }

    public function headerFlyoutMenus(array $headerFlyoutMenuItems = []): self
    {
        $this->headerFlyoutMenuItems = $headerFlyoutMenuItems;

        return $this;
    }

    public function authorize(bool $authorize = true): self
    {
        $this->authorize = $authorize;

        return $this;
    }
}
