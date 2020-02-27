<?php namespace zongphp\file;
use zongphp\framework\build\Facade;

class FileFacade extends Facade {
	public static function getFacadeAccessor() {
		return 'File';
	}
}