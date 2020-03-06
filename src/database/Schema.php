<?php
namespace zongphp\database;

use zongphp\database\build\Base;

/**
 * 数据库操作
 * Class Schema
 * @package zongphp\schema
 */
class Schema {
	//连接
	protected $link = null;

	//更改缓存驱动
	protected function driver() {
		$this->link = new Base( $this );

		return $this;
	}

	public function __call( $method, $params ) {
		if ( is_null( $this->link ) ) {
			$this->driver();
		}

		return call_user_func_array( [ $this->link, $method ], $params );
	}

	public static function __callStatic( $name, $arguments ) {
		return call_user_func_array( [ new static(), $name ], $arguments );
	}
}