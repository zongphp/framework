<?php
namespace zongphp\mail;

use zongphp\framework\build\Provider;

class MailProvider extends Provider {

	//延迟加载
	public $defer = true;

	public function boot() {
	}

	public function register() {
		$this->app->single( 'Mail', function ( $app ) {
			return new Mail( $app );
		} );
	}
}