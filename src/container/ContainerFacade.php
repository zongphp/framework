<?php
namespace zongphp\container;

use zongphp\framework\build\Facade;

class ContainerFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'Config';
    }
}