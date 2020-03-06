<?php

namespace zongphp\validate\build;

/**
 * 记录验证错误信息
 * Class Errors
 *
 * @package zongphp\validate\build
 */
class Errors
{
    protected $errors = [];

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param mixed $errors
     */
    public function setErrors(array $errors)
    {
        $this->errors = $errors;
    }

}