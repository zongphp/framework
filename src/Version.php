<?php namespace zongphp\framework;

trait Version
{
    static public function version()
    {
        defined('ZONGPHP_VERSION') or define('ZONGPHP_VERSION', '2.0.138');
    }
}
