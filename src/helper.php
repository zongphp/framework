<?php
if ( ! function_exists( 'env' ) ) {
	/**
	 * 根据.env配置文件获取匹配项
	 *
	 * @param $name 配置名称
	 * @param $value 为空时的返回值
	 *
	 * @return mixed
	 */
	function env( $name, $value ) {
		$envConfig = [];
		if ( is_file( '.env' ) && empty( $envConfig ) ) {
			$parse = file_get_contents( '.env' );
			$data  = array_filter( preg_split( '@' . PHP_EOL . '@', $parse ) );
			foreach ( $data as $v ) {
				$info                          = explode( '=', $v );
				$envConfig[ trim( $info[0] ) ] = trim( $info[1] );
			}
		}

		return empty( $envConfig[ $name ] ) ? $value : $envConfig[ $name ];
	}
}

if ( ! function_exists( 'pic' ) ) {
	/**
	 * 显示图片
	 * 判断提供的图片文件是否合法
	 * 不是合法图片时返回默认图片替换
	 *
	 * @param $file
	 * @param string $pic
	 *
	 * @return string
	 */
	function pic( $file, $pic = 'resource/images/thumb.jpg' ) {
		if ( preg_match( '@^http@i', $file ) ) {
			return $file;
		} elseif ( empty( $file ) || ! is_file( $file ) ) {
			return __ROOT__ . '/' . $pic;
		} else {
			return __ROOT__ . '/' . $file;
		}
	}
}

if ( ! function_exists( 'u' ) ) {
	/**
	 * 生成url
	 *
	 * @param string $path 模块/动作/方法
	 * @param array $args GET参数
	 *
	 * @return mixed|string
	 */
	function u( $path, $args = [] ) {
		if ( empty( $path ) || preg_match( '@^http@i', $path ) ) {
			return $path;
		}
		$url = C( 'http.rewrite' ) ? __ROOT__ : __ROOT__ . '/' . basename( $_SERVER['SCRIPT_FILENAME'] );
		if ( defined( 'MODULE' ) ) {
			//控制器访问模式
			//URL请求参数
			$urlParam = explode( '/', $_GET[ c( 'http.url_var' ) ] );
			$path     = str_replace( '.', '/', $path );
			switch ( count( explode( '/', $path ) ) ) {
				case 2:
					$path = $urlParam[0] . '/' . $path;
					break;
				case 1:
					$path = $urlParam[0] . '/' . $urlParam[1] . '/' . $path;
					break;
			}

			$url .= '?' . c( 'http.url_var' ) . '=' . $path;
		} else {
			//路由访问模式
			$url .= '?' . c( 'http.url_var' ) . '=' . $path;
		}
		//添加参数
		if ( ! empty( $args ) ) {
			$url .= '&' . http_build_query( $args );
		}

		return $url;
	}
}
if ( ! function_exists( 'url_del' ) ) {
	/**
	 * 从__URL__地址中删除指令的$_GET参数
	 *
	 * @param string|array $args
	 *
	 * @return string
	 */
	function url_del( $args ) {
		if ( ! is_array( $args ) ) {
			$args = [ $args ];
		}
		$url = parse_url( __URL__ );
		parse_str( $url['query'], $output );
		foreach ( $args as $v ) {
			if ( isset( $output[ $v ] ) ) {
				unset( $output[ $v ] );
			}
		}
		$url = $url['scheme'] . '://' . $url['host'] . $url['path'] . '?';
		foreach ( $output as $k => $v ) {
			$url .= $k . '=' . $v . '&';
		}

		return trim( $url, '&' );
	}
}

/**
 * 输出404页面
 */
if ( ! function_exists( '_404' ) ) {
	function _404() {
		\Response::sendHttpStatus( 302 );
		if ( is_file( c( 'app.404' ) ) ) {
			die( view( c( 'app.404' ) ) );
		}
		exit;
	}
}

if ( ! function_exists( 'p' ) ) {
	/**
	 * 打印输出数据
	 *
	 * @param $var
	 */
	function p( $var ) {
		echo "<pre>" . print_r( $var, true ) . "</pre>";
	}
}

if ( ! function_exists( 'dd' ) ) {
	/**
	 * 打印数据有数据类型
	 *
	 * @param $var
	 */
	function dd( $var ) {
		ob_start();
		var_dump( $var );
		echo "<pre>" . ob_get_clean() . "</pre>";
		exit;
	}
}

if ( ! function_exists( 'go' ) ) {
	/**
	 * 跳转网址
	 *
	 * @param string $url url地址
	 * @param int $time 等待时间
	 * @param string $msg 提示信息
	 */
	function go( $url, $time = 0, $msg = '' ) {
		$url = u( $url );
		if ( ! headers_sent() ) {
			$time == 0 ? header( "Location:" . $url ) : header( "refresh:{$time};url={$url}" );
			exit( $msg );
		} else {
			echo "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
			if ( $msg ) {
				echo( $msg );
			}
			exit;
		}
	}
}

if ( ! function_exists( 'print_const' ) ) {
	/**
	 * 打印用户常量
	 */
	function print_const() {
		$d = get_defined_constants( true );
		p( $d['user'] );
	}
}

if ( ! function_exists( 'v' ) ) {
	/**
	 * 全局变量
	 *
	 * @param null $name 变量名
	 * @param string $value 变量值
	 *
	 * @return array|mixed|null|string
	 */
	function v( $name = null, $value = '[null]' ) {
		static $vars = [];
		if ( is_null( $name ) ) {
			return $vars;
		} else if ( $value == '[null]' ) {
			//取变量
			$tmp = $vars;
			foreach ( explode( '.', $name ) as $d ) {
				if ( isset( $tmp[ $d ] ) ) {
					$tmp = $tmp[ $d ];
				} else {
					return null;
				}
			}

			return $tmp;
		} else {
			//设置
			$tmp = &$vars;
			foreach ( explode( '.', $name ) as $d ) {
				if ( ! isset( $tmp[ $d ] ) ) {
					$tmp[ $d ] = [];
				}
				$tmp = &$tmp[ $d ];
			}

			return $tmp = $value;
		}
	}
}

if ( ! function_exists( 'confirm' ) ) {
	/**
	 * 有确定提示的提示页面
	 *
	 * @param string $message 提示文字
	 * @param string $sUrl 确定按钮跳转的url
	 * @param string $eUrl 取消按钮跳转的url
	 */
	function confirm( $message, $sUrl, $eUrl ) {
		View::with( [ 'message' => $message, 'sUrl' => $sUrl, 'eUrl' => $eUrl ] );
		echo view( Config::get( 'app.confirm' ) );
		exit;
	}
}

if ( ! function_exists( 'message' ) ) {
	/**
	 * 消息提示
	 *
	 * @param string $content 消息内容
	 * @param string $redirect 跳转地址有三种方式 1:back(返回上一页)  2:refresh(刷新当前页)  3:具体Url
	 * @param string $type 信息类型  success(成功），error(失败），warning(警告），info(提示）
	 * @param int $timeout 等待时间
	 */
	function message( $content, $redirect = 'back', $type = 'success', $timeout = 2 ) {
		if ( IS_AJAX ) {
			ajax( [ 'code' => $type == 'success' ? 1 : 0, 'msg' => $content ] );
		} else {
			switch ( $redirect ) {
				case 'with':
					\Session::set( 'errors', is_array( $content ) ? $content : [ $content ] );
					echo '<script>location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
					exit;
					break;
				case 'back':
					//有回调地址时回调,没有时返回主页
					$url = "window.history.go(-1)";
					break;
				case 'refresh':
					$url = "location.replace('" . __URL__ . "')";
					break;
				default:
					if ( empty( $redirect ) ) {
						$url = 'window.history.go(-1)';
					} else {
						$url = "location.replace('" . u( $redirect ) . "')";
					}
					break;
			}
			//图标
			switch ( $type ) {
				case 'success':
					$ico = 'fa-check-circle';
					break;
				case 'error':
					$ico = 'fa-times-circle';
					break;
				case 'info':
					$ico = 'fa-info-circle';
					break;
				case 'warning':
					$ico = 'fa-warning';
					break;
			}
			View::with( [
				'content'  => $content,
				'redirect' => $redirect,
				'type'     => $type,
				'url'      => $url,
				'ico'      => $ico,
				'timeout'  => $timeout * 1000
			] );
			echo view( Config::get( 'app.message' ) )->toString();
		}
		exit;
	}
}

if ( ! function_exists( 'csrf_field' ) ) {
	/**
	 * CSRF 表单
	 * @return string
	 */
	function csrf_field() {
		return "<input type='hidden' name='csrf_token' value='" . Session::get( 'csrf_token' ) . "'/>\r\n";
	}
}

if ( ! function_exists( 'method_field' ) ) {
	/**
	 * CSRF 表单
	 *
	 * @param $type
	 *
	 * @return string
	 */
	function method_field( $type ) {
		return "<input type='hidden' name='_method' value='" . strtoupper( $type ) . "'/>\r\n";
	}
}
if ( ! function_exists( 'csrf_token' ) ) {
	/**
	 * CSRF 值
	 * @return mixed
	 */
	function csrf_token() {
		return Session::get( 'csrf_token' );
	}
}

if (!function_exists('getallheaders'))
{
	/**
	 * 修复在Nginx环境下hetallheaders()丢失
	 */
		function getallheaders()
    {
           $headers = [];
       foreach ($_SERVER as $name => $value)
       {
           if (substr($name, 0, 5) == 'HTTP_')
           {
               $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
           }
       }
       return $headers;
    }
}

/**
 * 文件缓存
 *
 * @param $name
 * @param string $value
 * @param string $path
 *
 * @return bool
 */
if ( ! function_exists( 'f' ) ) {
	function f( $name, $value = '[get]', $expire = 3600, $path = '' ) {
		static $instance = null;
		if ( is_null( $instance ) ) {
			$instance = \zongphp\cache\Cache::driver( 'file' );
		}
		$path     = $path ?: \zongphp\config\Config::get( 'cache.file.dir' );
		$instance = $instance->dir( $path );
		if ( is_null( $name ) ) {
			//删除所有缓存
			return $instance->flush();
		}
		switch ( $value ) {
			case '[get]':
				//获取
				return $instance->get( $name );
			case '[del]':
				//删除
				return $instance->del( $name );
			default:
				return $instance->set( $name, $value, $expire );
		}
	}
}

/**
 * 数据库缓存
 *
 * @param $key
 * @param null $value
 *
 * @return mixed
 */
if ( ! function_exists( 'd' ) ) {
	/**
	 * 数据表缓存操作函数
	 *
	 * @param string $name 缓存标识
	 * @param string $value 缓存数据
	 * @param int $expire 过期时间
	 * @param array $field 附加字段
	 *
	 * @return mixed
	 */
	function d( $name, $value = '[get]', $expire = 0, $field = [ ] ) {
		static $instance = null;
		if ( is_null( $instance ) ) {
			$instance = \zongphp\cache\Cache::driver( 'mysql' );
		}
		switch ( $value ) {
			case '[get]':
				//获取
				return $instance->get( $name );
			case '[del]':
				//删除
				return $instance->del( $name );
			case '[truncate]':
				//删除所有缓存
				return $instance->flush( $name );
			default:
				return $instance->set( $name, $value, $expire, $field );
		}
	}
}

function cli( $cli ) {
	$_SERVER['argv'] = preg_split( '/\s+/', $cli );
	//执行命令行指令
	\Cli::bootstrap(true);
}

/**
 * 集合
 */
if ( ! function_exists( 'collect' ) ) {
	/**
	 * @param $data
	 *
	 * @return mixed
	 */
	function collect( $data ) {
		return ( new \zongphp\collection\Collection() )->make( $data );
	}
}

/**
 * 操作配置项
 *
 * @param string $name
 * @param string $value
 *
 * @return mixed
 */
if ( ! function_exists( 'c' ) ) {
	function c( $name = '', $value = '' ) {
		if ( $name === '' ) {
			return \zongphp\config\Config::all();
		}
		if ( $value === '' ) {
			return \zongphp\config\Config::get( $name );
		}

		return \zongphp\config\Config::set( $name, $value );
	}
}

/**
 * 执行控制器方法
 * action('admin.user.add',1,3,4)
 * 从第2个参数开始为方法参数
 */
function action() {
	$args  = func_get_args();
	$info  = explode( '.', array_shift( $args ) );
	$class = Config::get( 'controller.app' ) . '\\' . $info[0] . '\\controller\\' . ucfirst( $info[1] );
	$res   = call_user_func_array( [ new $class, $info[2] ], $args );
	echo $res->toString();
	die;
}

if ( ! function_exists( 'encrypt' ) ) {
	/**
	 * 加密
	 * @param $content
	 *
	 * @return mixed
	 */
	function encrypt( $content ) {
		return Crypt::encrypt( $content, 'zongphp.com' );
	}
}

if ( ! function_exists( 'decrypt' ) ) {
	/**
	 * 解密
	 * @param $content
	 *
	 * @return mixed
	 */
	function decrypt( $content ) {
		return Crypt::decrypt( $content, 'zongphp.com' );
	}
}

//表名加前缀
if ( ! function_exists( 'tablename' ) ) {
	function tablename( $table ) {
		return c( 'database.prefix' ) . $table;
	}
}

/*
 * 获取格式化后的时间戳
 */
if ( ! function_exists( 'getDateTimeStamp' ) ) {
    function getDateTimeStamp($str = ''){
        if($str == ''){
            $str = 'today';
        }
        $returnTime = [
            'start_time' =>'',
            'end_time' =>''
        ];
        switch ($str) {
            case 'today':
                $returnTime = [
                    'start_time' =>strtotime(date("Y-m-d 00:00:00")),
                    'end_time' =>strtotime(date("Y-m-d 23:59:59"))
                ];
                break;
            case 'yesterday':
                $returnTime = [
                    'start_time' =>strtotime(date("Y-m-d 00:00:00",strtotime("-1 day"))),
                    'end_time' =>strtotime(date("Y-m-d 23:59:59",strtotime("-1 day")))
                ];
                break;
            case 'tomorrow':
                $returnTime = [
                    'start_time' =>strtotime(date("Y-m-d 00:00:00",strtotime("+1 day"))),
                    'end_time' =>strtotime(date("Y-m-d 23:59:59",strtotime("+1 day")))
                ];
                break;
            case 'lastweek':
                $returnTime = [
                    'start_time' =>strtotime(date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),date("d")-date("w")+1-7,date("Y")))),
                    'end_time' =>strtotime(date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("d")-date("w")+7-7,date("Y"))))
                ];
                break;
            case 'thisweek':
                $returnTime = [
                    'start_time' =>strtotime(date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),date("d")-date("w")+1,date("Y")))),
                    'end_time' =>strtotime(date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("d")-date("w")+7,date("Y"))))
                ];
                break;
            case 'lastmonth':
                $returnTime = [
                    'start_time' =>strtotime(date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m")-1,1,date("Y")))),
                    'end_time' =>strtotime(date("Y-m-d H:i:s",mktime(23,59,59,date("m") ,0,date("Y"))))
                ];
                break;
            case 'thismonth':
                $returnTime = [
                    'start_time' =>strtotime(date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),1,date("Y")))),
                    'end_time' =>strtotime(date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("t"),date("Y"))))
                ];
                break;
            case 'thisquarter':
                $getMonthDays = date("t",mktime(0, 0 , 0,date('n')+(date('n')-1)%3,1,date("Y")));
                $returnTime = [
                    'start_time' =>strtotime(date('Y-m-d H:i:s', mktime(0, 0, 0,date('n')-(date('n')-1)%3,1,date('Y')))),
                    'end_time' =>strtotime(date('Y-m-d H:i:s', mktime(23,59,59,date('n')+(date('n')-1)%3,$getMonthDays,date('Y'))))
                ];
                break;
						case 'lastyear':
		            $time = strtotime('-1 year', time());
		            $returnTime = [
		                'start_time' =>strtotime(date('Y-m-d 00:00:00', mktime(0, 0,0, 1, 1, date('Y', $time)))),
		                'end_time' =>strtotime(date('Y-m-d 23:39:59', mktime(0, 0, 0, 12, 31, date('Y',$time))))
		            ];
		            break;
            case 'thisyear':
                $returnTime = [
                    'start_time' =>strtotime(date('Y-m-d 00:00:00', mktime(0, 0,0, 1, 1, date('Y', time())))),
                    'end_time' =>strtotime(date('Y-m-d 23:39:59', mktime(0, 0, 0, 12, 31, date('Y'))))
                ];
                break;
          default:
            # code...
            break;
        }
        return $returnTime;
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

if (!function_exists('exception')) {
    /**
     * 抛出异常处理
     *
     * @param string    $msg  异常消息
     * @param integer   $code 异常代码 默认为0
     * @param string    $exception 异常类
     *
     * @throws Exception
     */
    function exception($msg, $code = 0, $exception = '')
    {
        $e = $exception ?: '\zongphp\exception\Exception';
        throw new $e($msg, $code);
    }
}

if ( ! function_exists( 'import' ) ) {
	/**
	 * 导入类库
	 *
	 * @param $class
	 *
	 * @return bool
	 */
	function import( $class ) {
		$file = str_replace( [ '.', '#' ], [ '/', '.' ], $class );
		if ( is_file( $file ) ) {
			require_once $file;
		} else {
			return false;
		}
	}
}

/**
 * 请求参数
 *
 * @param $var 变量名
 * @param null $default 默认值
 * @param string $filter 数据处理函数
 *
 * @return mixed
 */
if ( ! function_exists( 'q' ) ) {
	/**
	 * 取得或设置全局数据包括:
	 * $_COOKIE,$_SESSION,$_GET,$_POST,$_REQUEST,$_SERVER,$_GLOBALS
	 *
	 * @param string $var 变量名
	 * @param mixed $default 默认值
	 * @param string $methods 函数库
	 *
	 * @return mixed
	 */
	function q( $var, $default = null, $methods = '' ) {
		return \zongphp\request\Request::query( $var, $default, $methods );
	}
}

if ( ! function_exists( 'ajax' ) ) {
	/**
	 * Ajax输出
	 *
	 * @param  mixed $data 数据
	 * @param string $type 数据类型 text html xml json
	 */
	function ajax( $data, $type = "JSON" ) {
		\zongphp\response\Response::ajax( $data, $type );
	}
}

if ( ! function_exists( 'clientIp' ) ) {
	/**
	 * 获取客户端ip
	 * @param int $type
	 *
	 * @return mixed|string
	 */
	function clientIp( $type = 0 ) {
		$type = intval( $type );
		//保存客户端IP地址
		if ( isset( $_SERVER ) ) {
			if ( isset( $_SERVER["HTTP_X_FORWARDED_FOR"] ) ) {
				$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
			} else if ( isset( $_SERVER["HTTP_CLIENT_IP"] ) ) {
				$ip = $_SERVER["HTTP_CLIENT_IP"];
			} else if ( isset( $_SERVER["REMOTE_ADDR"] ) ) {
				$ip = $_SERVER["REMOTE_ADDR"];
			} else {
				return '';
			}
		} else {
			if ( getenv( "HTTP_X_FORWARDED_FOR" ) ) {
				$ip = getenv( "HTTP_X_FORWARDED_FOR" );
			} else if ( getenv( "HTTP_CLIENT_IP" ) ) {
				$ip = getenv( "HTTP_CLIENT_IP" );
			} else if ( getenv( "REMOTE_ADDR" ) ) {
				$ip = getenv( "REMOTE_ADDR" );
			} else {
				return '';
			}
		}
		$long     = ip2long( $ip );
		$clientIp = $long ? [ $ip, $long ] : [ "0.0.0.0", 0 ];

		return $clientIp[ $type ];
	}
}

if ( ! function_exists('doAction')) {
    /**
     * 执行控制器方法
     *
     * @param       $controller
     * @param       $action
     *
     * @return mixed
     */
    function doAction($controller, $action)
    {
        return \zongphp\route\Route::executeControllerAction($controller.'@'.$action);
    }
}

/**
 * 显示模板
 */
if ( ! function_exists( 'view' ) ) {
	function view( $tpl = '', $expire = 0 ) {
		return \zongphp\view\View::make( $tpl, $expire );
	}
}
if ( ! function_exists( 'widget' ) ) {
	//解析页面组件
	function widget() {
		$vars = func_get_args();
		$info = preg_split( '@[\./]@', array_shift( $vars ) );
		//方法名
		$method = array_pop( $info );
		//类名
		$className = array_pop( $info );
		$class     = implode( '\\', $info ) . '\\' . ucfirst( $className );

		return call_user_func_array( [ new $class, $method ], $vars );
	}
}

if ( ! function_exists( 'truncate' ) ) {
	/**
	 * 截取文字内容
	 *
	 * @param string $content 内容
	 * @param int $len 长度
	 *
	 * @return string
	 */
	function truncate( $content, $len = 30 ) {
		return mb_substr( $content, 0, $len, 'utf8' );
	}
}