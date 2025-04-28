<?php

namespace Pratiksh\Imperium\Traits;

trait HasPermission
{
    public function initializeHasPermission()
    {
        $this->fillable[] = 'role_id';
    }

    public function breadPermissionForModule($module)
    {
        $role = $this->role;
        $module_bread = ! is_null($role) ? $role->bread_for_modules->first(function ($bread, $module_name) use ($module) {
            return $module_name == $module;
        }) : null;

        return ! is_null($module_bread) ? $module_bread->mapWithKeys(function ($bread, $name) {
            return [strtolower($name) => $bread['active']];
        }) : null;
    }
}
