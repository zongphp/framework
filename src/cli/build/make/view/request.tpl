<?php
namespace system\request;

use zongphp\request\build\FormRequest;
use zongphp\validate\Validate;

/**
 * Class UserRequest
 *
 * @package system\request
 */
class {{NAME}} extends FormRequest
{
    /**
     * 权限验证
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * 验证规则
     * 验证规则的使用请参数"自动验证"组件
     * @return array
     */
    public function rules()
    {
        return [];
    }
}