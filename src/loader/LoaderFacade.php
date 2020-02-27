<?php
namespace zongphp\loader;

use zongphp\framework\build\Facade;

class LoaderFacade extends Facade {
	public static function getFacadeAccessor() {
		return 'Loader';
	}
}