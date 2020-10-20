<?php
namespace zongphp\code;
use zongphp\framework\build\Provider;

class CodeProvider extends Provider {

	//延迟加载
	public $defer = true;

	public function boot() {
	}

	public function register() {
		$this->app->single( 'Code', function () {
			return new Code();
		} );
	}
}