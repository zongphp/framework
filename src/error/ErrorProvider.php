<?php
namespace zongphp\error;
use zongphp\framework\build\Provider;

class ErrorProvider extends Provider {
	//延迟加载
	public $defer = false;

	public function boot() {
		Config::set( 'error.debug', Config::get( 'app.debug' ) );
		Error::bootstrap();
	}

	public function register() {
		$this->app->single( 'Error', function () {
			return new Error();
		} );
	}
}