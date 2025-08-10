<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string method()
 * @method static string anotherMethod($param)
 * 
 * @see \App\Helpers\HelperService
 */
class HelperFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'helper-service';
    }
}