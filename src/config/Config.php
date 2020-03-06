<?php
namespace zongphp\config;

//配置项处理
use zongphp\config\build\Base;

/**
 * 配置
 * Class Config
 *
 * @package zongphp\config
 */
class Config
{
    protected static $link = null;

    public function __call($method, $params)
    {
        return call_user_func_array([self::single(), $method], $params);
    }

    public static function single()
    {
        if (is_null(self::$link)) {
            self::$link = new Base();
        }

        return self::$link;
    }

    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([self::single(), $name], $arguments);
    }
}