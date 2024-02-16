<?php

namespace Odat\LaravelLens\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Odat\LaravelLens\Skeleton\SkeletonClass
 */
class LaravelLens extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-lens';
    }
}
