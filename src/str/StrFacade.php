<?php
namespace zongphp\str;

use zongphp\framework\build\Facade;

class StrFacade extends Facade {
	public static function getFacadeAccessor() {
		return 'Str';
	}
}