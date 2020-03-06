<?php

namespace zongphp\zip\build;


use Alchemy\Zippy\Zippy;

class Base
{
    protected $link;

    public function __construct()
    {
        $this->link = Zippy::load();
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->link, $name], $arguments);
    }
}