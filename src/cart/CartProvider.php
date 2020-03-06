<?php
namespace zongphp\cart;

use zongphp\framework\build\Provider;

class CartProvider extends Provider {

	//延迟加载
	public $defer = true;

	public function boot() {
	}

	public function register() {
		$this->app->single( 'Cart', function () {
			return new Cart();
		} );
	}
}