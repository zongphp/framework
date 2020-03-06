<?php
namespace zongphp\cli;

use zongphp\config\Config;
use zongphp\framework\build\Provider;

class CliProvider extends Provider
{
    //延迟加载
    public $defer = false;

    public function boot()
    {
        Cli::setPath([
            'controller' => 'app',
            'middleware' => 'system/middleware',
            'model'      => 'system/model',
            'request'    => 'system/request',
            'migration'  => 'system/database/migrations',
            'seed'       => 'system/database/seeds',
            'service'    => 'system/service',
            'tag'        => 'system/tag',
        ]);
        Cli::setBinds(Config::get('cli'));
        if (RUN_MODE == 'CLI') {
            //执行命令行指令
            die(Cli::bootstrap());
        }
    }

    public function register()
    {
        $this->app->single('Cli', function () {
            return new Cli();
        });
    }
}