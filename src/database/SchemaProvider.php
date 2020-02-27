<?php
namespace zongphp\database;
use zongphp\framework\build\Provider;

/**
 * Class SchemaProvider
 */
class SchemaProvider extends Provider {
	//延迟加载
	public $defer = true;

	public function boot() {

	}

	public function register() {
		$this->app->single( 'Schema', function () {
			return new Schema();
		} );
	}
}