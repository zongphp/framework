<?php
namespace zongphp\collection;

use zongphp\framework\build\Facade;

class CollectionFacade extends Facade {
	public static function getFacadeAccessor() {
		return 'Collection';
	}
}