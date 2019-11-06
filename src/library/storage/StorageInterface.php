<?php
/**
 * 存储驱动接口
 */
namespace zongphp\library\storage;

Interface StorageInterface {

	/**
	 * 读取缓存
	 * @param string  $key    缓存名
	 */
	public function get($key);

    /**
     * 设置存储内容
     * @param string  $key    缓存名
     * @param mixed   $value  缓存内容
     * @param integer $expire 缓存时间
     */
    public function set($key, $value, $expire = 0);

	/**
	 * 递增缓存值
	 * @param  string  $key   缓存名
	 * @param  integer $value 递增数量
	 * @return boolean
	 */
	public function inc($key, $value = 1);

	/**
	 * 递减缓存值
	 * @param  string  $key   缓存名
	 * @param  integer $value 递增数量
	 * @return boolean
	 */
	public function des($key, $value = 1);
	
	/**
	 * 删除缓存
	 * @param  string $key 缓存名
	 * @return boolean
	 */
	public function del($key);

	/**
	 * 清空缓存
	 * @return void
	 */
    public function clear();
		
}