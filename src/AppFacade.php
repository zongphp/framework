<?php
namespace zongphp\framework;

use zongphp\framework\build\Facade;

class AppFacade extends Facade {
	public static function getFacadeAccessor() {
		return 'App';
	}
}