<?php
/**
 * 操作配置项
 *
 * @param string $name
 * @param string $value
 *
 * @return mixed
 */
if ( ! function_exists( 'c' ) ) {
	function c( $name = '', $value = '' ) {
		if ( $name === '' ) {
			return \zongphp\config\Config::all();
		}
		if ( $value === '' ) {
			return \zongphp\config\Config::get( $name );
		}

		return \zongphp\config\Config::set( $name, $value );
	}
}