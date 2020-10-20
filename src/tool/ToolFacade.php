<?php namespace zongphp\tool;
use zongphp\framework\build\Facade;


class ToolFacade extends Facade {
	public static function getFacadeAccessor() {
		return 'Tool';
	}
}