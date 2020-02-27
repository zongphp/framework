<?php namespace zongphp\crypt;
use zongphp\framework\build\Provider;

class CryptProvider extends Provider {

	//延迟加载
	public $defer = true;

	public function boot() {
		Config::set( 'crypt.key', Config::get( 'app.key' ) );
	}

	public function register() {
		$this->app->single( 'Crypt', function () {
			return new Crypt();
		} );
	}
}