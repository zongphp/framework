<?php
namespace zongphp\config;

use zongphp\framework\build\Provider;

class ConfigProvider extends Provider {

	//延迟加载
	public $defer = true;

	public function boot() {
	}

	public function register() {
		$this->app->single( 'Config', function () {
			return Config::single();
		} );
	}
}