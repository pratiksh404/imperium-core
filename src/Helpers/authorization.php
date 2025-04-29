<?php

use Illuminate\Auth\Authenticatable;
use Pratiksh\Imperium\Facades\Imperium;

if (! function_exists('ifUserCanForAllModules')) {
    function ifUserCanForAllModules($user, $ability)
    {
        $user = Imperium::user()->find($user->id ?? auth()->user()->id);

        return collect(getAllModels())->mapWithKeys(function ($model, $model_name) use ($user, $ability) {
            return [strtolower($model_name) => $user->can($ability, $model)];
        });
    }
}
