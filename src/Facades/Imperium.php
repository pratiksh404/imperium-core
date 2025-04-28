<?php

namespace Pratiksh\Imperium\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Pratiksh\Imperium\Skeleton
 */
class Imperium extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Pratiksh\Imperium\Imperium::class;
    }
}
