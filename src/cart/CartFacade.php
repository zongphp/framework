<?php
namespace zongphp\cart;


use zongphp\framework\build\Facade;

class CartFacade extends Facade {
	public static function getFacadeAccessor() {
		return 'Cart';
	}
}