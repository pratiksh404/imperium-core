<?php

namespace Pratiksh\Imperium\Services\Control;

class Sidebar
{
    public bool $includeUserProfile = true;

    public bool $collapsed = false;

    public bool $includeApplicationLogo = true;

    public function includeUserProfile(bool $includeUserProfile = true): self
    {
        $this->includeUserProfile = $includeUserProfile;

        return $this;
    }

    public function collapsed(bool $collapsed = false): self
    {
        $this->collapsed = $collapsed;

        return $this;
    }

    public function includeApplicationLogo(bool $includeApplicationLogo = true): self
    {
        $this->includeApplicationLogo = $includeApplicationLogo;

        return $this;
    }
}
