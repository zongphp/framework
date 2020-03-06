<?php
namespace zongphp\mail;

use zongphp\framework\build\Facade;

class MailFacade extends Facade {
	public static function getFacadeAccessor() {
		return 'Mail';
	}
}