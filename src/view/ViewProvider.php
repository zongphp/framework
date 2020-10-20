<?php
namespace zongphp\view;

use zongphp\config\Config;
use zongphp\framework\build\Provider;

class ViewProvider extends Provider {

	//延迟加载
	public $defer = true;

	public function boot() {
	}

	public function register() {
		Config::set( 'view.compile_open', Config::get( 'app.debug' ) );
		$this->app->single( 'View', function () {
			return View::single();
		} );
	}
}