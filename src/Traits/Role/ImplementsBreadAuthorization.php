<?php

namespace Pratiksh\Imperium\Traits\Role;

trait ImplementsBreadAuthorization
{
    public function initializeImplementsBreadAuthorization()
    {
        $this->appends[] = 'modules_with_no_bread';
    }

    public function getModulesWithNoBreadAttribute()
    {
        $system_modules = getAllModels();

        $role_that_does_not_have_bread = array_diff(array_keys($system_modules), array_keys($this->bread_for_modules->toArray()));

        return array_intersect_key($system_modules, array_flip($role_that_does_not_have_bread));
    }
}
