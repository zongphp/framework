<?php
namespace zongphp\tree;
use zongphp\framework\build\Provider;

class TreeProvider extends Provider {

	//延迟加载
	public $defer = true;

	public function boot() {
	}

	public function register() {
		$this->app->single( 'Tree', function () {
			return new Tree();
		} );
	}
}
