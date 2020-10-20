<?php namespace zongphp\file;
use zongphp\framework\build\Provider;

class FileProvider extends Provider {

	//延迟加载
	public $defer = true;

	public function boot() {
	}

	public function register() {
		$this->app->single( 'File', function () {
			return new File();
		} );
	}
}