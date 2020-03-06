<?php

namespace zongphp\view;

use zongphp\view\build\Base;

/**
 * 视图
 * Class View
 *
 * @package zongphp\view
 */
class View
{
    /**
     * 连接驱动
     *
     * @var
     */
    protected static $link;

    /**
     * 生成单例视图
     *
     * @return \zongphp\view\build\Base
     */
    public static function single()
    {
        if ( ! self::$link) {
            self::$link = new Base();
        }

        return self::$link;
    }

    /**
     * 动态调用
     *
     * @param $method
     * @param $params
     *
     * @return mixed
     */
    public function __call($method, $params)
    {
        return call_user_func_array([self::single(), $method], $params);
    }

    /**
     * 静态调用
     *
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([self::single(), $name], $arguments);
    }
}