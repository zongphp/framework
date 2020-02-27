<?php
namespace zongphp\cookie;

use zongphp\framework\build\Facade;

class CookieFacade extends Facade {
	public static function getFacadeAccessor() {
		return 'Cookie';
	}
}