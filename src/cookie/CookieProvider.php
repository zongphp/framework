<?php
namespace zongphp\cookie;

use zongphp\config\Config;
use zongphp\framework\build\Provider;

class CookieProvider extends Provider
{
    //延迟加载
    public $defer = false;

    public function boot()
    {
        Config::set('cookie.key', Config::get('app.key'));
    }

    public function register()
    {
        $this->app->single('Cookie', function () {
            return Cookie::single();
        });
    }
}