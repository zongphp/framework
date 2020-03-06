<?php namespace zongphp\crypt;

use zongphp\framework\build\Provider;

class CryptProvider extends Provider
{
    //延迟加载
    public $defer = false;

    public function boot()
    {
    }

    public function register()
    {
        $this->app->single('Crypt', function () {
            return new Crypt();
        });
    }
}