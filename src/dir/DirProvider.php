<?php
namespace zongphp\dir;

use zongphp\framework\build\Provider;

class DirProvider extends Provider
{
    //延迟加载
    public $defer = true;

    public function boot()
    {
    }

    public function register()
    {
        $this->app->single('Dir', function ($app) {
            return new Dir($app);
        });
    }
}