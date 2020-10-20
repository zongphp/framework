<?php
namespace zongphp\image;

use zongphp\framework\build\Provider;

class ImageProvider extends Provider {

	//延迟加载
	public $defer = true;

	public function boot() {
	}

	public function register() {
		$this->app->single( 'Image', function () {
			return new Image();
		} );
	}
}