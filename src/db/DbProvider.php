<?php
namespace zongphp\db;
use zongphp\framework\build\Provider;

class DbProvider extends Provider {
	//延迟加载
	public $defer = true;

	public function boot() {

	}

	public function register() {
		$this->app->bind( 'Db', function () {
			return new Db();
		} );
	}
}