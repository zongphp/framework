<?php
namespace zongphp\container;

use zongphp\container\build\Base;
use zongphp\framework\build\Provider;

class ContainerProvider extends Provider
{
    //延迟加载
    public $defer = true;

    public function boot()
    {
    }

    public function register()
    {
        $this->app->single(
            'Container',
            function () {
                return new Base();
            }
        );
    }
}