<?php namespace zongphp\framework\build;

use zongphp\framework\Version;
use zongphp\middleware\build\Dispatcher;
use ReflectionClass;

class Base extends \zongphp\container\build\Base
{
    use Bootstrap, Dispatcher, Version;
    //应用已启动
    protected $booted = false;

    //延迟加载服务提供者
    protected $deferProviders = [];

    //已加载服务提供者
    protected $serviceProviders = [];

    //系统服务
    protected $providers = [];

    //外观别名
    protected $facades = [];

    public function bootstrap()
    {
        self::version();
        $this->services();
        spl_autoload_register([$this, 'autoload']);
        $this->instance('App', $this);
        //设置外观类APP属性
        Facade::setFacadeApplication($this);
        //绑定核心服务提供者
        $this->bindServiceProvider();
        //执行服务启动程序
        $this->boot();
        //运行项目应用
        $this->runApp();
    }

    /**
     * 服务设置
     */
    public function services()
    {
        defined('ROOT_PATH') or define('ROOT_PATH', '.');
        //加载服务配置项
        $servers         = require __DIR__.'/../build/service.php';
        $users           = require ROOT_PATH.'/system/config/service.php';
        $this->providers = array_merge($servers['providers'], $users['providers']);
        $this->facades   = array_merge($servers['facades'], $users['facades']);
    }

    /**
     * 外观类文件自动加载
     *
     * @param $class
     *
     * @return mixed
     */
    public function autoload($class)
    {
        //通过外观类加载系统服务
		$file   = str_replace( '\\', '/', $class );
		$facade = basename( $file );
        if (isset($this->facades[$facade])) {
            //加载facade类
            class_alias($this->facades[$facade], $class);
        }
    }

    /**
     * 系统启动
     */
    protected function boot()
    {
        if ($this->booted) {
            return;
        }
        foreach ($this->serviceProviders as $p) {
            $this->bootProvider($p);
        }
        $this->booted = true;
    }

    //服务加载处理
    protected function bindServiceProvider()
    {
        foreach ($this->providers as $provider) {
            $reflectionClass = new ReflectionClass($provider);
            $properties      = $reflectionClass->getDefaultProperties();
            //获取服务延迟属性
            if (isset($properties['defer']) && $properties['defer'] === false) {
                //立即加载服务
                $this->register(new $provider($this));
            } else {
                //延迟加载服务
                $alias                        = substr($reflectionClass->getShortName(), 0, -8);
                $this->deferProviders[$alias] = $provider;
            }
        }
    }

    /**
     * 获取服务对象
     *
     * @param 服务名  $name  服务名
     * @param bool $force 是否单例
     *
     * @return Object
     */
    public function make($name, $force = false)
    {
        if (isset($this->deferProviders[$name])) {
            $this->register(new $this->deferProviders[$name]($this));
            unset($this->deferProviders[$name]);
        }

        return parent::make($name, $force);
    }

    /**
     * 注册服务
     *
     * @param $provider 服务名
     *
     * @return object
     */
    protected function register($provider)
    {
        //服务对象已经注册过时直接返回
        if ($registered = $this->getProvider($provider)) {
            return $registered;
        }
        if (is_string($provider)) {
            $provider = new $provider($this);
        }
        $provider->register($this);
        //记录服务
        $this->serviceProviders[] = $provider;
        if ($this->booted) {
            $this->bootProvider($provider);
        }
    }

    /**
     * 运行服务提供者的boot方法
     *
     * @param $provider
     */
    protected function bootProvider($provider)
    {
        if (method_exists($provider, 'boot')) {
            $provider->boot($this);
        }
    }

    /**
     * 获取已经注册的服务
     *
     * @param $provider 服务名
     *
     * @return mixed
     */
    protected function getProvider($provider)
    {
        $class = is_object($provider) ? get_class($provider) : $provider;
        foreach ($this->serviceProviders as $value) {
            if ($value instanceof $class) {
                return $value;
            }
        }
    }
}
