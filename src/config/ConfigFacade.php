<?php
namespace zongphp\config;
use zongphp\framework\build\Facade;

class ConfigFacade extends Facade {
	public static function getFacadeAccessor() {
		return 'Config';
	}
}