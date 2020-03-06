<?php

namespace zongphp\framework\build;

use zongphp\config\Config;
use zongphp\framework\middleware\ViewParseFile;
use zongphp\middleware\Middleware;
use zongphp\request\Request;
use zongphp\response\Response;
use zongphp\route\Route;
use zongphp\session\Session;
use zongphp\view\View;

trait Bootstrap
{
    protected function runApp()
    {
        if (RUN_MODE == 'HTTP') {
            //解析路由
            require ROOT_PATH.'/system/routes.php';
            //执行全局中间件
            $this->middleware(Config::get('middleware.global'));
            //分配闪存错误信息
            $this->withErrors();
            //模板文件处理中间件
            Middleware::add('view_parse_file', [ViewParseFile::class]);
            //执行路由或控制器方法
            $content = Route::bootstrap()->exec();
            echo is_object($content) ? $content : Response::make($content);
        }
    }

    /**
     * 分配闪存错误信息
     */
    protected function withErrors()
    {
        //分配SESSION闪存中的错误信息
        View::with('errors', Session::flash('errors'));
        if ($post = Request::post()) {
            Session::flash('oldFormData', $post);
        }
    }
}