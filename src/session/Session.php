<?php
namespace zongphp\session;
use zongphp\config\Config;

class Session {
	//操作驱动
	protected $link;

	//设置驱动
	protected function driver( $driver = null ) {
		$driver     = $driver ?: Config::get( 'session.driver' );
		$driver     = '\zongphp\session\\build\\' . ucfirst( $driver ) . 'Handler';
		$this->link = new $driver();
		$this->link->bootstrap();

		return $this;
	}

	public function __call( $method, $params ) {
		if ( is_null( $this->link ) ) {
			$this->driver();
		}

		return call_user_func_array( [ $this->link, $method ], $params );
	}

	public static function single() {
		static $link = null;
		if ( is_null( $link ) ) {
			$link = new static();
		}

		return $link;
	}

	public static function __callStatic( $name, $arguments ) {
		return call_user_func_array( [ static::single(), $name ], $arguments );
	}
}