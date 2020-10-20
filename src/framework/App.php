<?php namespace zongphp\framework;
use zongphp\framework\build\Base;

class App {
	protected $link;

	public function __construct() {
		/*--------------------------------------------------------------------------
		| 框架版本
		|--------------------------------------------------------------------------
		|-------------------------------------------------------------------------*/
		define( 'ZONGPHP_VERSION', '1.0.4' );
	}

	//更改缓存驱动
	protected function driver() {
		$this->link = new Base();

		return $this;
	}

	public function __call( $method, $params ) {
		if ( is_null( $this->link ) ) {
			$this->driver();
		}

		return call_user_func_array( [ $this->link, $method ], $params );
	}

	//生成单例对象
	public static function single() {
		static $link;
		if ( is_null( $link ) ) {
			$link = new static();
		}

		return $link;
	}

	public static function __callStatic( $name, $arguments ) {
		return call_user_func_array( [ static::single(), $name ], $arguments );
	}
}
