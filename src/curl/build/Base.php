<?php namespace zongphp\curl\build;

class Base {
	//请求服务器
	public function get( $url ) {
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );

		if (  curl_exec( $ch ) ===false) {
			throw new \Exception( curl_error( $ch ) );
			$data = '';
		} else {
			$data = curl_multi_getcontent( $ch );
		}
		curl_close( $ch );

		return $data;
	}

	//提交POST数据
	public function post( $url, $postData ) {
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt( $ch, CURLOPT_TIMEOUT, 30 );
		curl_setopt( $ch, CURLOPT_POST, 1 );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $postData );
		if ( curl_exec( $ch ) ===false) {
			throw new \Exception( curl_error( $ch ) );
			$data = '';
		} else {
			$data = curl_multi_getcontent( $ch );
		}
		curl_close( $ch );

		return $data;
	}
}