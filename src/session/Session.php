<?php
namespace zongphp\session;

use zongphp\config\Config;

/**
 * SESSION处理
 * Class Session
 *
 * @package zongphp\session
 */
class Session
{
    //操作驱动
    protected static $link;

    /**
     * 生成实例
     *
     * @return null|static
     */
    public static function single()
    {
        if (is_null(self::$link)) {
            $driver = ucfirst(Config::get('session.driver'));
            $class  = '\zongphp\session\\build\\'.$driver.'Handler';
            self::$link = new $class();
        }
        return self::$link;
    }

    public function __call($method, $params)
    {
        return call_user_func_array([self::single(), $method], $params);
    }

    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([static::single(), $name], $arguments);
    }
}