<?php

namespace Pratiksh\Imperium;

class Imperium
{
    public function user()
    {
        // @phpstan-ignore-next-line
        return new (config('imperium.models.user', \App\Models\User::class));
    }

    public function role()
    {
        // @phpstan-ignore-next-line
        return new (config('imperium.models.role', \App\Models\Admin\Role::class));
    }

    public function permission()
    {
        // @phpstan-ignore-next-line
        return new (config('imperium.models.permission', \App\Models\Admin\Permission::class));
    }

    public function position()
    {
        // @phpstan-ignore-next-line
        return new (config('imperium.models.position', \App\Models\Admin\Position::class));
    }

    public function application()
    {
        // @phpstan-ignore-next-line
        return new (config('imperium.application', \App\Imperium\Application::class));
    }
}
