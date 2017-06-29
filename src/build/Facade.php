<?php
namespace zongphp\framework\build;

use RuntimeException;

abstract class Facade {
	protected static $app;

	public static $resolvedInstance = [ ];

	public static function getFacadeRoot() {
		return self::resolveFacadeInstance( static::getFacadeAccessor() );
	}

	protected static function getFacadeAccessor() {
		throw new RuntimeException( "Facade does not implement getFacadeAccessor method." );
	}

	protected static function resolveFacadeInstance( $name ) {
		if ( is_object( $name ) ) {
			return $name;
		}

		return static::$resolvedInstance[ $name ] = static::$app[ $name ];
	}

	public static function setFacadeApplication( $app ) {
		static::$app = $app;
	}

	public static function __callStatic( $method, $args ) {
		$instance = static::getFacadeRoot();

		return call_user_func_array( [ $instance, $method ], $args );
	}
}