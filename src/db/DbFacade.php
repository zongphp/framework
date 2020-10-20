<?php
namespace zongphp\db;

use zongphp\framework\build\Facade;

class DbFacade extends Facade {
	public static function getFacadeAccessor() {
		return 'Db';
	}
}