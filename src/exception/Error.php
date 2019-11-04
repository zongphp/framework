<?php
/**
 * 异常处理
 */

namespace zongphp\exception;

class Error extends \ErrorException {

    public function __construct($message, $code = 0) {
        new \zongphp\exception\Handle($message, $code, $this->getFile(), $this->getLine(), $this->getTrace(), false, true, false);
    }
}