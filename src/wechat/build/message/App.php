<?php

namespace zongphp\wechat\build\message;

use zongphp\wechat\build\Base;

/**
 * 消息管理
 * Class Message
 *
 * @package zongphp\wechat\build
 */
class App extends Base
{
    use  Event, Basic, Send, SendAll;
}