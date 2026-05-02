<?php

namespace Zakarialabib\BComponents\Facades;

use Illuminate\Support\Facades\Facade;

class BComponents extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'bcomponents';
    }
}