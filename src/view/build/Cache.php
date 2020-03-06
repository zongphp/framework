<?php
namespace zongphp\view\build;

use zongphp\config\Config;

/**
 * Trait Cache
 *
 * @package zongphp\view\build
 */
trait Cache
{
    //缓存时间
    protected $expire;

    /**
     * 设置缓存时间
     *
     * @param int $expire 时间
     *
     * @return $this
     */
    public function setExpire($expire)
    {
        $this->expire = $expire;

        return $this;
    }

    /**
     * 设置缓存时间
     *
     * @param int $expire 缓存时间
     *
     * @return $this
     */
    public function cache($expire)
    {
        $this->expire = $expire;

        return $this;
    }

    /**
     * 缓存标识
     *
     * @return string
     */
    protected function cacheName()
    {
        return md5($_SERVER['REQUEST_URI'].$this->getFile());
    }

    /**
     * 验证缓存文件
     *
     * @return mixed
     */
    public function isCache()
    {
        $dir = Config::get('view.cache_dir');

        return \zongphp\cache\Cache::driver('file')->dir($dir)->get($this->cacheName());
    }

    /**
     * 获取模板缓存
     *
     * @return mixed
     */
    public function getCache()
    {
        $dir = Config::get('view.cache_dir');
        return \zongphp\cache\Cache::driver('file')->dir($dir)->get($this->cacheName());
    }

    /**
     * 设置模板缓存
     *
     * @param $content
     *
     * @return mixed
     */
    public function setCache($content)
    {
        $dir = Config::get('view.cache_dir');

        return \zongphp\cache\Cache::driver('file')->dir($dir)->set($this->cacheName(), $content, $this->expire);
    }

    /**
     * 删除模板缓存
     *
     * @param string $file
     *
     * @return mixed
     */
    public function delCache($file = '')
    {
        $dir = Config::get('view.cache_dir');

        return \zongphp\cache\Cache::driver('file')->dir($dir)->del($this->cacheName($file));
    }
}