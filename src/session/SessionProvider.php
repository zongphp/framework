<?php

namespace zongphp\session;

use zongphp\framework\build\Provider;

class SessionProvider extends Provider
{
    //延迟加载
    public $defer = false;

    public function boot()
    {
        Session::bootstrap();
    }

    public function register()
    {
        $this->app->single('Session', function () {
            return Session::single();
        });
    }
}