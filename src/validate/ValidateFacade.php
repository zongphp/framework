<?php
namespace zongphp\validate;

use zongphp\framework\build\Facade;

class ValidateFacade extends Facade {
	public static function getFacadeAccessor() {
		return 'Validate';
	}
}