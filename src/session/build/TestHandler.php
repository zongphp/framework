<?php

namespace zongphp\session\build;

/**
 * 单元测试
 * Class TestHandler
 *
 * @package zongphp\session\build
 */
class TestHandler implements AbSession
{
    use Base;

    //初始
    public function connect()
    {
        return true;
    }

    //读取
    public function read()
    {
        return [];
    }

    //写入
    public function write()
    {
        return true;
    }

    /**
     * SESSION垃圾处理
     *
     * @return boolean
     */
    public function gc()
    {
        return true;
    }
}
