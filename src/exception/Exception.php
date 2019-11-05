<?php
/**
 * 异常处理
 */

namespace zongphp\exception;

class Exception extends \Exception {

    public function __construct($message, $code = 0) {
        new \zongphp\exception\Handle($message, $code, $this->getFile(), $this->getLine(), $this->getTrace(), \zongphp\Config::get('zong.debug'), false, \zongphp\Config::get('zong.log'));
    }
}