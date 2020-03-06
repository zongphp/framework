<?php

namespace zongphp\qq;

use zongphp\framework\build\Provider;

class QqProvider extends Provider {

	//延迟加载
	public $defer = true;

	public function boot() {
	}

	public function register() {
		$this->app->single( 'Qq', function () {
			return new Qq();
		} );
	}
}