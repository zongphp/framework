<?php
namespace zongphp\image;


use zongphp\framework\build\Facade;

class ImageFacade extends Facade {
	public static function getFacadeAccessor() {
		return 'Image';
	}
}