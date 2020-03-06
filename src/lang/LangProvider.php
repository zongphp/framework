<?php
namespace zongphp\lang;

use zongphp\framework\build\Provider;

class LangProvider extends Provider {

	//延迟加载
	public $defer = true;

	public function boot() {
	}

	public function register() {
		$this->app->single( 'Lang', function (  ) {
			return new Lang(  );
		} );
	}
}