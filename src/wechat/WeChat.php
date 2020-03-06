<?php namespace zongphp\wechat;

use zongphp\wechat\build\Base;

class WeChat
{
    //连接
    protected static $link;

    public static function single()
    {
        if (is_null(self::$link)) {
            self::$link = new Base();
        }

        return self::$link;
    }

    public function __call($method, $params)
    {
        return call_user_func_array([self::single(), $method], $params);
    }

    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([self::single(), $name], $arguments);
    }
}