<?php
namespace zongphp\cli;

use zongphp\framework\build\Provider;

class CliProvider extends Provider {
	//延迟加载
	public $defer = false;

	public function boot() {
		//执行命令行指令
		Cli::bootstrap();
	}

	public function register() {
		$this->app->single( 'Cli', function () {
			return new Cli();
		} );
	}
}