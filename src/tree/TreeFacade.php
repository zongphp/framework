<?php
namespace zongphp\tree;
use zongphp\framework\build\Facade;

class TreeFacade extends Facade {
	public static function getFacadeAccessor() {
		return 'Tree';
	}
}
