<?php

use App\Models\User;

if (! function_exists('ifUserCanForAllModules')) {
    function ifUserCanForAllModules(User $user, $ability)
    {
        $user = Imperium::user()->find(auth()->user()->id);

        return collect(getAllModels())->mapWithKeys(function ($model, $model_name) use ($user, $ability) {
            return [strtolower($model_name) => $user->can($ability, $model)];
        });
    }
}
