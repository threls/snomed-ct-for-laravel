<?php

namespace Threls\SnomedCTForLaravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Threls\SnomedCTForLaravel\SnomedCTForLaravel
 */
class SnomedCTForLaravel extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Threls\SnomedCTForLaravel\SnomedCTForLaravel::class;
    }
}
