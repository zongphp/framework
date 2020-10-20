<?php namespace zongphp\zip;
use zongphp\framework\build\Provider;

class ZipProvider extends Provider {
	//延迟加载
	public $defer = true;

	public function boot() {
	}

	public function register() {
		$this->app->single( 'Zip', function () {
			return new Zip();
		} );
	}
}