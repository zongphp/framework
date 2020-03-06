<?php
namespace zongphp\cli;

use zongphp\framework\build\Facade;

class CliFacade extends Facade {
	public static function getFacadeAccessor() {
		return 'Cli';
	}
}