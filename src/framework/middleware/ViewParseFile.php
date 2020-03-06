<?php
namespace zongphp\framework\middleware;

use zongphp\middleware\build\Middleware;
use zongphp\route\Route;
use zongphp\view\View;

/**
 * 模板文件
 * 如果是控制器请求且视图文件不存在时设置方法名为文件名
 * Class ViewParseFile
 *
 * @package zongphp\framework\middleware
 */
class ViewParseFile implements Middleware
{
    public function run($next)
    {
        if (empty(View::getFile())) {
            if ($action = Route::getAction()) {
                View::setFile($action);
            }
        }
        $next();
    }
}