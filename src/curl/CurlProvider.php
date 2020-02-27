<?php
namespace zongphp\curl;
use zongphp\framework\build\Provider;

class CurlProvider extends Provider {

	//延迟加载
	public $defer = true;

	public function boot() {
	}

	public function register() {
		$this->app->single( 'Curl', function ( $app ) {
			return new Curl( $app );
		});
	}
}