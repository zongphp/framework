<?php
namespace zongphp\code;

use zongphp\code\build\Base;
use zongphp\config\Config;

class Code {
	protected $link;

	public function __call( $method, $params ) {
		if ( ! $this->link ) {
			$this->link = new Base();
		}

		return call_user_func_array( [ $this->link, $method ], $params );
	}

	public static function single() {
		static $link = null;
		if ( is_null( $link ) ) {
			$link = new Code();
		}

		return $link;
	}

	public static function __callStatic( $name, $arguments ) {
		return call_user_func_array( [ static::single(), $name ], $arguments );
	}
}