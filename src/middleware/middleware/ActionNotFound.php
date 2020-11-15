<?php namespace zongphp\middleware\middleware;

use zongphp\container\Container;
use zongphp\config\Config;
/**
 * 控制器方法不存在时执行的中间件
 * Class ActionNotFound
 * @package zongphp\middleware\middleware
 */
class ActionNotFound {
	public function run() {
		$class = Config::get( 'app.exception_handle' );
		if ( class_exists( $class ) && method_exists( $class, 'missAction' ) ) {
			return Container::callMethod( $class, 'missAction' );
		}
		_404();
		
	}
}