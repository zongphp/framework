<?php
namespace zongphp\code;
use zongphp\framework\build\Facade;

class CodeFacade extends Facade {
	public static function getFacadeAccessor() {
		return 'Code';
	}
}