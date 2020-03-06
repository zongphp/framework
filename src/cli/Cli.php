<?php namespace zongphp\cli;

use zongphp\cli\build\Base;

/**
 * 命令行模式
 * Class Cli
 */
class Cli
{
    protected static $link;

    public function __call($method, $params)
    {
        return call_user_func_array([static::single(), $method], $params);
    }

    public static function single()
    {
        if ( ! self::$link) {
            self::$link = new Base();
        }

        return self::$link;
    }

    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([static::single(), $name], $arguments);
    }
}