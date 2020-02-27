<?php
namespace zongphp\page;

use zongphp\framework\build\Provider;

class PageProvider extends Provider {

	//延迟加载
	public $defer = true;

	public function boot() {
	}

	public function register() {
		$this->app->single( 'Page', function ( $app ) {
			return Page::single( $app );
		} );
	}
}