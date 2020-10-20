<?php
namespace zongphp\curl;
use zongphp\framework\build\Facade;

class CurlFacade extends Facade {
	public static function getFacadeAccessor() {
		return 'Curl';
	}
}