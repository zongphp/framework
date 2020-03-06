<?php
namespace zongphp\str;

use zongphp\framework\build\Provider;

class StrProvider extends Provider
{
    //延迟加载
    public $defer = true;
    public function boot()
    {
    }

    public function register()
    {
        $this->app->single(
            'Str',
            function ($app) {
                return new Str();
            }
        );
    }
}