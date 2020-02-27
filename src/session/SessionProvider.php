<?php
namespace zongphp\session;
use zongphp\framework\build\Provider;

class SessionProvider extends Provider {

	//延迟加载
	public $defer = true;

	public function boot() {
	}

	public function register() {
		$this->app->single( 'Session', function () {
			return Session::single();
		} );
	}


}