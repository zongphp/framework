<?php
namespace zongphp\qq;

use zongphp\framework\build\Facade;

class QqFacade extends Facade {
	public static function getFacadeAccessor() {
		return 'Qq';
	}
}