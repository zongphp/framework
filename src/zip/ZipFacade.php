<?php namespace zongphp\zip;
use zongphp\framework\build\Facade;

class ZipFacade extends Facade {
	public static function getFacadeAccessor() {
		return 'Zip';
	}
}