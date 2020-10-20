<?php
namespace zongphp\database;

use zongphp\framework\build\Facade;

class SchemaFacade extends Facade {
	public static function getFacadeAccessor() {
		return 'Schema';
	}
}