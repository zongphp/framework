<?php
namespace zongphp\view;

use zongphp\config\Config;
use zongphp\framework\build\Provider;
use zongphp\view\build\Csrf;

class ViewProvider extends Provider
{
    //延迟加载
    public $defer = false;

    public function boot()
    {
        View::setPath(Config::get('view.path'));
    }

    public function register()
    {
        $this->app->single('View', function () {
            return View::single();
        });
    }
}