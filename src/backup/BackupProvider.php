<?php
namespace zongphp\backup;
use zongphp\framework\build\Provider;

class BackupProvider extends Provider {

	//延迟加载
	public $defer = true;

	public function boot() {
	}

	public function register() {
		$this->app->single( 'Backup', function () {
			return new Backup();
		} );
	}
}