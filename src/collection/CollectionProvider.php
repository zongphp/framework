<?php
namespace zongphp\collection;

use zongphp\framework\build\Provider;

class CollectionProvider extends Provider {

	//延迟加载
	public $defer = true;

	public function boot() {
	}

	public function register() {
		$this->app->bind( 'Collection', function () {
			return new Collection();
		} );
	}
}