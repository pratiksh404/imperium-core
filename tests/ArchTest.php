<?php

// Global Concerns
arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

// Commands Concerns
arch('commands folder classes must extend Illuminate\Console\Command')
    ->expect(['Pratiksh\Imperium\Commands'])
    ->toExtend('Illuminate\Console\Command');

arch('generator commands must use trait Pratiksh\Imperium\Traits\Console\NeedsModel')
    ->expect(['Pratiksh\Imperium\Commands\Generator'])
    ->toUseTrait('Pratiksh\Imperium\Traits\Console\NeedsModel');

// Contracts Concerns
arch('it will only be interface')
    ->expect(['Pratiksh\Imperium\Contracts'])
    ->toBeInterfaces();

// Facades Concerns
arch('it will only be facades')
    ->expect(['Pratiksh\Imperium\Facades'])
    ->toHaveMethod('getFacadeAccessor');

// Controller Concerns
arch('it will only be controller')
    ->expect(['Pratiksh\Imperium\Http\Controllers'])
    ->toExtend('Pratiksh\Imperium\Http\Controllers\Controller');

// Repositories Concerns
arch('repository ResourcefulRepository complies with imperium resourceful interface')
    ->expect(['Pratiksh\Imperium\Repositories\ResourcefulRepository'])
    ->toImplement('Pratiksh\Imperium\Contracts\ResourcefulInterface')
    ->toHaveMethods([
        'index',
        'create',
        'store',
        'show',
        'edit',
        'update',
        'destroy',
    ]);

// Traits Concerns
arch('it will not contain anything but traits in Traits folder')
    ->expect(['Pratiksh\Imperium\Traits'])
    ->toBeTraits();


arch()->preset()->php();
arch()->preset()->security();
arch()->preset()->laravel();
