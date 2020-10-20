<?php
namespace zongphp\cookie;

use zongphp\arr\Arr;
use zongphp\config\Config;
use zongphp\cookie\build\Base;

/**
 * Cookie 管理组件
 * Class Cookie
 */
class Cookie {
	protected $link;

	//获取实例
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