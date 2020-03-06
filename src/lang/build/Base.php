<?php
namespace zongphp\lang\build;

use zongphp\arr\Arr;
use zongphp\config\Config;

class Base
{
    //语句包
    private $language;

    public function __construct()
    {
        $this->language = include(Config::get('lang.lang'));
    }

    /**
     * 语言包文件
     *
     * @param $file
     */
    public function file($file)
    {
        $this->language = include $file;
    }

    //获取语言
    public function get($lang)
    {
        return Arr::get($this->language, $lang);
    }

    //设置单个语言
    public function set($name, $value)
    {
        $this->language = Arr::set($this->language, $name, $value);

        return true;
    }
}