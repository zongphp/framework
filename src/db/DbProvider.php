<?php
namespace zongphp\db;

use zongphp\config\Config;
use zongphp\framework\build\Provider;

/**
 * Class DbProvider
 *
 * @package zongphp\db
 */
class DbProvider extends Provider
{
    //延迟加载
    public $defer = false;

    public function boot()
    {
        //旧版本没有port,后期删除
        Config::set('database.port', 3306);
    }

    public function register()
    {
        $this->app->bind('Db', function () {
            return new Db();
        });
    }
}