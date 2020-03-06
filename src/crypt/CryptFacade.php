<?php
namespace zongphp\crypt;

use zongphp\framework\build\Facade;

class CryptFacade extends Facade {
	public static function getFacadeAccessor() {
		return 'Crypt';
	}
}