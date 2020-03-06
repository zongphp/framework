<?php
namespace zongphp\page;

use zongphp\framework\build\Facade;

class PageFacade extends Facade {
	public static function getFacadeAccessor() {
		return 'Page';
	}
}