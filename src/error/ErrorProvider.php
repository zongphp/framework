<?php
namespace zongphp\error;

use zongphp\framework\build\Provider;

class ErrorProvider extends Provider
{
    //延迟加载
    public $defer = false;

    public function boot()
    {
        Error::bootstrap();
    }

    public function register()
    {
        $this->app->single('Error', function () {
            return new Error();
        });
    }
}