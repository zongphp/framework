<?php
namespace zongphp\session;

use zongphp\framework\build\Facade;

class SessionFacade extends Facade {
	public static function getFacadeAccessor() {
		return 'Session';
	}
}