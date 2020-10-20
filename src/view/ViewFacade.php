<?php
namespace zongphp\view;

use zongphp\framework\build\Facade;

class ViewFacade extends Facade {
	public static function getFacadeAccessor() {
		return 'View';
	}
}