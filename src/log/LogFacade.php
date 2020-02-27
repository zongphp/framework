<?php
namespace zongphp\log;

use zongphp\framework\build\Facade;

class LogFacade extends Facade {
	public static function getFacadeAccessor() {
		return 'Log';
	}
}