<?php
namespace zongphp\arr;
use zongphp\framework\build\Facade;

class ArrFacade extends Facade {
	public static function getFacadeAccessor() {
		return 'Arr';
	}
}