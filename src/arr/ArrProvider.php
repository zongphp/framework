<?php
namespace zongphp\arr;
use zongphp\framework\build\Provider;

class ArrProvider extends Provider {

	//延迟加载
	public $defer = true;

	public function boot() {
	}

	public function register() {
		$this->app->single( 'Arr', function () {
			return new Arr();
		} );
	}
}