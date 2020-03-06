<?php
namespace zongphp\lang;

use zongphp\framework\build\Facade;

class LangFacade extends Facade {
	public static function getFacadeAccessor() {
		return 'Lang';
	}
}