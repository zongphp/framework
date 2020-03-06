<?php
if ( ! function_exists('app')) {
    /**
     * 获取应用实例
     *
     * @param string $name 外观名称
     *
     * @return mixed
     */
    function app($name = 'App')
    {
        return \App::make($name);
    }
}

if ( ! function_exists('pic')) {
    /**
     * 显示图片
     * 判断提供的图片文件是否合法
     * 不是合法图片时返回默认图片替换
     *
     * @param        $file
     * @param string $pic
     *
     * @return string
     */
    function pic($file, $pic = 'resource/images/thumb.jpg')
    {
        if (preg_match('@^http@i', $file)) {
            return $file;
        } elseif (empty($file) || ! is_file($file)) {
            return __ROOT__.'/'.$pic;
        } else {
            return __ROOT__.'/'.$file;
        }
    }
}

if ( ! function_exists('p')) {
    /**
     * 打印输出数据
     *
     * @param $var
     */
    function p($var)
    {
        echo "<pre>".print_r($var, true)."</pre>";
    }
}

if ( ! function_exists('dd')) {
    /**
     * 打印数据有数据类型
     *
     * @param $var
     */
    function dd($var)
    {
        ob_start();
        var_dump($var);
        die("<pre>".ob_get_clean()."</pre>");
    }
}

if ( ! function_exists('print_const')) {
    /**
     * 打印用户常量
     */
    function print_const()
    {
        $d = get_defined_constants(true);
        p($d['user']);
    }
}

if ( ! function_exists('v')) {
    /**
     * 全局变量
     *
     * @param null   $name  变量名
     * @param string $value 变量值
     *
     * @return array|mixed|null|string
     */
    function v($name = null, $value = '[null]')
    {
        static $vars = [];
        if (is_null($name)) {
            return $vars;
        } else if ($value == '[null]') {
            //取变量
            $tmp = $vars;
            foreach (explode('.', $name) as $d) {
                if (isset($tmp[$d])) {
                    $tmp = $tmp[$d];
                } else {
                    return null;
                }
            }

            return $tmp;
        } else {
            //设置
            $tmp = &$vars;
            foreach (explode('.', $name) as $d) {
                if ( ! isset($tmp[$d])) {
                    $tmp[$d] = [];
                }
                $tmp = &$tmp[$d];
            }

            return $tmp = $value;
        }
    }
}

/**
 * 获取几分/几秒前的表示
 *
 * @param string $time 时间ISO格式如 2020-2-22 10:22:32
 *
 * @return int
 */
if ( ! function_exists('time_diff')) {
    function time_diff($time)
    {
        $dt  = new \Carbon\Carbon($time);
        $now = \Carbon\Carbon::now();
        $num = $dt->diffInSeconds($now);
        if ($num < 20) {
            return '刚刚';
        } elseif ($num < 60) {
            $unit = '秒前';
        } elseif ($num < 3600) {
            $unit = '分钟前';
            $num  = $num / 60;
        } else if ($num < (24 * 3600)) {
            $unit = '小时前';
            $num  = $num / 3600;
        } else {
            $unit = '天前';
            $num  = $num / (24 * 3600);
        }

        return intval($num).$unit;
    }
}

if ( ! function_exists('collect')) {
    /**
     * 集合
     *
     * @param $data
     *
     * @return mixed
     */
    function collect(array $data)
    {
        return (new \zongphp\collection\Collection())->make($data);
    }
}

if ( ! function_exists('c')) {
    /**
     * 操作配置项
     * @param string $name
     * @param string $value
     *
     * @return mixed
     */
   function c($name = '', $value = '')
   {
       if ($name === '') {
           return \zongphp\config\Config::all();
       }
       if ($value === '') {
           return \zongphp\config\Config::get($name);
       }

       return \zongphp\config\Config::set($name, $value);
   }
}

if ( ! function_exists('env')) {
    /**
     * 根据.env配置文件获取匹配项
     *
     * @param $name  配置名称
     * @param $value 为空时的返回值
     *
     * @return mixed
     */
    function env($name, $value = null)
    {
        return \houdunwang\config\Config::getEnv($name) ?: $value;
    }
}

if ( ! function_exists('action')) {
    /**
     * 执行控制器方法
     *
     * @param       $controller
     * @param       $action
     *
     * @return mixed
     */
    function action($controller, $action)
    {
        return \zongphp\route\Route::executeControllerAction($controller.'@'.$action);
    }
}

if ( ! function_exists('request_url')) {
    /**
     * 请求的URL地址
     *
     * @return string
     */
    function request_url()
    {
        return \zongphp\request\Request::url();
    }
}

if ( ! function_exists('history_url')) {
    /**
     * 来源链接
     *
     * @return string
     */
    function history_url()
    {
        return \zongphp\request\Request::history();
    }
}
if ( ! function_exists('root_url')) {
    /**
     * 网站根地址URI
     *
     * @return string
     */
    function root_url()
    {
        return \zongphp\request\Request::domain();
    }
}

if ( ! function_exists('domain_url')) {
    /**
     * 网站根地址URI
     *
     * @return string
     */
    function domain_url()
    {
        return \zongphp\request\Request::domain();
    }
}

if ( ! function_exists('web_url')) {
    /**
     * 网站主页
     * 根据配置项 http.rewrite判断
     * 没有开启伪静态时添加index.php入口文件
     *
     * @param bool $hasRoot 包含入口文件
     *
     * @return string
     */
    function web_url($hasRoot = false)
    {
        if ($hasRoot) {
            return __ROOT__.'/index.php';
        }

        return \zongphp\request\Request::web();
    }
}

if ( ! function_exists('q')) {
    /**
     * 取得或设置全局数据包括:
     * $_COOKIE,$_SESSION,$_GET,$_POST,$_REQUEST,$_SERVER,$_GLOBALS
     *
     * @param string $var     变量名
     * @param mixed  $default 默认值
     * @param string $methods 函数库
     *
     * @return mixed
     */
    function q($var, $default = null, $methods = '')
    {
        return \zongphp\request\Request::query($var, $default, $methods);
    }
}

if ( ! function_exists('old')) {
    /**
     * 获取表单旧数据
     *
     * @param        $name    表单
     * @param string $default 默认值
     *
     * @return string
     */
    function old($name, $default = '')
    {
        $data = \zongphp\session\Session::flash('oldFormData');

        return isset($data[$name]) ? $data[$name] : $default;
    }
}
if ( ! function_exists('clientIp')) {
    /**
     * 客户端IP地址
     *
     * @return mixed
     */
    function clientIp()
    {
        return \zongphp\request\Request::ip();
    }
}

if ( ! function_exists('getallheaders')) {
    /**
     * 获取请求头信息
     *
     * @return mixed
     */
    function getallheaders()
    {
        return \zongphp\request\Request::getallheaders();
    }
}

if ( ! function_exists('ajax')) {
    /**
     * Ajax输出
     *
     * @param  mixed $data 数据
     * @param string $type 数据类型 text html xml json
     */
    function ajax($data, $type = "JSON")
    {
        return \zongphp\response\Response::ajax($data, $type);
    }
}


if ( ! function_exists('confirm')) {
    /**
     * 有确定提示的提示页面
     *
     * @param string $message 提示文字
     * @param string $sUrl    确定按钮跳转的url
     * @param string $eUrl    取消按钮跳转的url
     *
     * @return mixed
     */
    function confirm($message, $sUrl, $eUrl)
    {
        View::with(['message' => $message, 'sUrl' => $sUrl, 'eUrl' => $eUrl]);

        return view(Config::get('app.confirm'));
    }
}

if ( ! function_exists('message')) {
    /**
     * 消息提示
     *
     * @param        $content  消息内容
     * @param string $redirect 跳转地址有三种方式 1:back(返回上一页)  2:refresh(刷新当前页)  3:具体Url
     * @param string $type     信息类型  success(成功），error(失败），warning(警告），info(提示）
     * @param int    $timeout  等待时间
     *
     * @return mixed|string
     */
    function message($content, $redirect = 'back', $type = 'success', $timeout = 2)
    {
        return \zongphp\response\Response::show($content, $redirect, $type, $timeout);
    }
}

if ( ! function_exists('u')) {
    /**
     * 生成控制器链接
     *
     * @param string $path 模块.动作.方法
     * @param array  $args GET参数
     * @param bool   $merge
     *
     * @return mixed
     */
    function u($path, $args = [], $merge = false)
    {
        return redirect($path, $args, $merge)->string();
    }
}
if ( ! function_exists('go')) {
    /**
     * 跳转网址
     *
     * @param $path
     * @param $args
     *
     * @return mixed
     */
    function go($path, $args = [])
    {
        return redirect($path, $args);
    }
}

if ( ! function_exists('redirect')) {
    /**
     * 跳转链接
     *
     * @param string $url  back/refresh/控制器
     * @param array  $args 链接参数
     * @param bool   $merge
     *
     * @return mixed
     */
    function redirect($url = '', array $args = [], $merge = false)
    {
        return \zongphp\response\Response::redirect($url, $args, $merge);
    }
}

if ( ! function_exists('url_del')) {
    /**
     * 从__URL__地址中删除指令的$_GET参数
     *
     * @param string|array $args
     *
     * @return string
     */
    function url_del($args)
    {
        if ( ! is_array($args)) {
            $args = [$args];
        }
        $url = parse_url(__URL__);
        parse_str($url['query'], $output);
        foreach ($args as $v) {
            if (isset($output[$v])) {
                unset($output[$v]);
            }
        }
        $url = $url['scheme'].'://'.$url['host'].$url['path'].'?';
        foreach ($output as $k => $v) {
            $url .= $k.'='.$v.'&';
        }

        return trim($url, '&');
    }
}

/**
 * 文件缓存
 *
 * @param        $name
 * @param string $value
 * @param string $path
 *
 * @return bool
 */
if ( ! function_exists('f')) {
    function f($name, $value = '[get]', $expire = 3600, $path = '')
    {
        static $instance = null;
        if (is_null($instance)) {
            $instance = \zongphp\cache\Cache::driver('file');
        }
        $path     = $path ?: \zongphp\config\Config::get('cache.file.dir');
        $instance = $instance->dir($path);
        if (is_null($name)) {
            //删除所有缓存
            return $instance->flush();
        }
        switch ($value) {
            case '[get]':
                //获取
                return $instance->get($name);
            case '[del]':
                //删除
                return $instance->del($name);
            default:
                return $instance->set($name, $value, $expire);
        }
    }
}

/**
 * 数据库缓存
 *
 * @param      $key
 * @param null $value
 *
 * @return mixed
 */
if ( ! function_exists('d')) {
    /**
     * 数据表缓存操作函数
     *
     * @param string $name   缓存标识
     * @param string $value  缓存数据
     * @param int    $expire 过期时间
     * @param array  $field  附加字段
     *
     * @return mixed
     */
    function d($name, $value = '[get]', $expire = 0, $field = [])
    {
        static $instance = null;
        if (is_null($instance)) {
            $instance = \zongphp\cache\Cache::driver('mysql');
        }

        if (is_null($name)) {
            //删除所有缓存
            return $instance->flush();
        }
        switch ($value) {
            case '[get]':
                //获取
                return $instance->get($name);
            case '[del]':
                //删除
                return $instance->del($name);
            default:
                return $instance->set($name, $value, $expire, $field);
        }
    }
}

function cli($cli)
{
    $_SERVER['argv'] = preg_split('/\s+/', $cli);

    //执行命令行指令
    return \Cli::bootstrap(true);
}

if ( ! function_exists('encrypt')) {
    /**
     * 加密
     *
     * @param $content
     *
     * @return mixed
     */
   function encrypt($content)
   {
       return \zongphp\crypt\Crypt::encrypt($content);
   }
}

if ( ! function_exists('decrypt')) {
    /**
     * 解密
     *
     * @param $content
     *
     * @return mixed
     */
   function decrypt($content)
   {
       return \zongphp\crypt\Crypt::decrypt($content);
   }
}

//表名加前缀
if ( ! function_exists( 'tablename' ) ) {
	function tablename( $table ) {
		return \zongphp\config\Config::get( 'database.prefix' ) . $table;
	}
}

if ( ! function_exists( 'trace' ) ) {
	/**
	 * trace
	 *
	 * @param string $value 变量
	 * @param string $label 标签
	 * @param string $level 日志级别(或者页面Trace的选项卡)
	 * @param bool|false $record 是否记录日志
	 *
	 * @return mixed
	 */
	function trace( $value = '[zongphp]', $label = '', $level = 'DEBUG', $record = false ) {
		return Error::trace( $value, $label, $level, $record );
	}
}

if ( ! function_exists('model')) {
    /**
     * 生成模型实例对象
     *
     * @param $name
     *
     * @return mixed
     */
    function model($name)
    {
        $class = '\system\model\\'.ucfirst($name);

        return \zongphp\container\Container::make($class);
    }
}

if ( ! function_exists('view')) {
    /**
     * 显示模板
     *
     * @param string $tpl
     * @param array  $vars
     *
     * @return mixed
     */
    function view($tpl = '', $vars = [])
    {
        return \zongphp\view\View::make($tpl, $vars);
    }
}
if ( ! function_exists('widget')) {
    //解析页面组件
    function widget()
    {
        $vars = func_get_args();
        $info = preg_split('@[\./]@', array_shift($vars));
        //方法名
        $method = array_pop($info);
        //类名
        $className = array_pop($info);
        $class     = implode('\\', $info).'\\'.ucfirst($className);

        return call_user_func_array([new $class, $method], $vars);
    }
}

if ( ! function_exists('truncate')) {
    /**
     * 截取文字内容
     *
     * @param string $content 内容
     * @param int    $len     长度
     *
     * @return string
     */
    function truncate($content, $len = 30)
    {
        return mb_substr($content, 0, $len, 'utf8');
    }
}

if ( ! function_exists('view_path')) {
    /**
     * 模板目录
     *
     * @return string
     */
    function view_path()
    {
        return \zongphp\view\View::getPath();
    }
}

if ( ! function_exists('csrf_field')) {
    /**
     * CSRF 表单
     *
     * @return string
     */
    function csrf_field()
    {
        return "<input type='hidden' name='csrf_token' value='".Session::get('csrf_token')."'/>\r\n";
    }
}

if ( ! function_exists('csrf_token')) {
    /**
     * CSRF 值
     *
     * @return mixed
     */
    function csrf_token()
    {
        return Session::get('csrf_token');
    }
}

if ( ! function_exists('view_url')) {
    /**
     * 模板目录链接
     *
     * @return string
     */
    function view_url()
    {
        return __ROOT__.'/'.view_path();
    }
}
if ( ! function_exists('widget_css')) {
    /**
     * 加载部件CSS文件
     *
     * @param $css
     *
     * @return string
     */
    function widget_css($css)
    {
        return "<style>".file_get_contents($css)."</style>";
    }
}

if ( ! function_exists('widget_js')) {
    /**
     * 加载部件JS文件
     *
     * @param $js
     *
     * @return string
     */
    function widget_js($js)
    {
        return "<script>".file_get_contents(__DIR__."/js/{$js}.js")."</script>";
    }
}

if ( ! function_exists('method_field')) {
    /**
     * CSRF 表单
     *
     * @param $type
     *
     * @return string
     */
    function method_field($type)
    {
        return "<input type='hidden' name='_method' value='".strtoupper($type)."'/>\r\n";
    }
}