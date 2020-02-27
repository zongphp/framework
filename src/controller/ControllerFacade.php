<?php
namespace zongphp\controller;
use zongphp\framework\build\Facade;

class ControllerFacade extends Facade {
	public static function getFacadeAccessor() {
		return 'Controller';
	}
}