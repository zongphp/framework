<?php
namespace zongphp\cache\build;

use Exception;
use zongphp\config\Config;

/**
 * Redis缓存处理类
 * Class Redis
 */
class Redis implements InterfaceCache {
	use Base;
	protected $link;

	//连接
	public function connect() {
		$conf       = Config::get( 'cache.redis' );

		if ( $this->link = new \Redis ) {
			$this->link->connect( $conf['host'], $conf['port'] );
		} else {
			throw new Exception( "Redis 连接失败" );
		}
		$this->link->auth( $conf['password'] );
		$this->link->select( $conf['database'] );
	}

	//设置
	public function set( $name, $value, $expire = 3600 ) {
		$name = $this->getCacheKey($name);
		$value = serialize($value);
		if($expire){
			return $this->link->setex($name, $expire, $value);
		}else{
			return $this->link->set( $name, $value );
		}
	}

	//获得
	public function get( $name ) {
		$name = $this->getCacheKey($name);
		return unserialize($this->link->get( $name ));
	}

	//删除
	public function del( $name ) {
		$name = $this->getCacheKey($name);
		return $this->link->delete( $name );
	}

	//清空缓存池
	public function delAll() {
		return $this->link->flushall();
	}

	//清除缓存
	public function flush() {

	}

	/**
     * 获取实际的缓存标识
     * @access protected
     * @param  string $name 缓存名
     * @return string
     */
    protected function getCacheKey($name){
        return 'cache#'.md5(Config::get('cache.prefix').$name);
    }
}