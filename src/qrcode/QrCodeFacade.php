<?php
namespace zongphp\qrcode;

use zongphp\framework\build\Facade;

class QrCodeFacade extends Facade {
	public static function getFacadeAccessor() {
		return 'QrCode';
	}
}