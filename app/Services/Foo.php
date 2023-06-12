<?php

namespace App\Services;

use Illuminate\Support\Facades\Facade;

/**
 * Class Foo
 * @method static string doSomething()
 */

class Foo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'fooService';
    }
}
