<?php
/**
 * 集合
 */
if ( ! function_exists( 'collect' ) ) {
	/**
	 * @param $data
	 *
	 * @return mixed
	 */
	function collect( $data ) {
		return ( new \zongphp\collection\Collection() )->make( $data );
	}
}