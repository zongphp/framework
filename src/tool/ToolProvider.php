<?php namespace zongphp\tool;

use zongphp\framework\build\Provider;

class ToolProvider extends Provider {

	//延迟加载
	public $defer = true;

	public function boot() {
	}

	public function register() {
		$this->app->single( 'Tool', function ( $app ) {
			return new Tool();
		} );
	}
}