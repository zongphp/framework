<?php
namespace zongphp\backup;

use zongphp\framework\build\Facade;

class BackupFacade extends Facade {
	public static function getFacadeAccessor() {
		return 'Backup';
	}
}