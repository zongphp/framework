<?php

namespace zongphp\error;

use zongphp\framework\build\Facade;

class ErrorFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'Error';
    }
}