<?php
namespace zongphp\dir;

use zongphp\framework\build\Facade;

class DirFacade extends Facade {
	public static function getFacadeAccessor() {
		return 'Dir';
	}
}