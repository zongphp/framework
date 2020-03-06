<?php
namespace zongphp\wechat\build\customservice;

use zongphp\wechat\build\Base;

/**
 * 客服接口
 * Class App
 *
 * @package zongphp\wechat\build
 */
class App extends Base
{
    use CustomManage, CustomMessage;
}