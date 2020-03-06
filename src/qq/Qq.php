<?php

namespace zongphp\qq;

use zongphp\config\Config;
use zongphp\qq\build\QC;

class Qq {
	protected $link = null;

	//更改缓存驱动
	public function driver() {
		$this->link = new QC();
		$this->link->config( Config::get( 'qq' ) );

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