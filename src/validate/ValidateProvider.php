<?php
namespace zongphp\validate;

use zongphp\framework\build\Provider;

class ValidateProvider extends Provider {

	//延迟加载
	public $defer = true;

	public function boot() {
	}

	public function register() {
		$this->app->single( 'Validate', function () {
			return new Validate();
		} );
	}
}