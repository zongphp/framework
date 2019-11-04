<?php

namespace dux;

class Engine {

    public static $classes = [];

    /**
     * Engine constructor.
     */
    public function __construct() {
        $this->init();
    }

    /**
     * 初始化框架
     */
    public function init() {
        $this->autoload();
        $this->handleErrors();
        $this->route();
    }

    /**
     * 注册类
     */
    public function autoload() {
        spl_autoload_register([__CLASS__, 'loadClass']);
    }

    /**
     * 加载类文件
     * @param $class
     * @return bool
     */
    public function loadClass($class) {
        $classFile = str_replace(['\\', '_'], '/', $class) . '.php';
        $file = ROOT_PATH . $classFile;
        if (!isset(self::$classes[$file])) {
            if (!file_exists($file)) {
                return false;
            }
            self::$classes[$classFile] = $file;
            require_once $file;
        }
        return true;
    }

    /**
     * 异常接管
     */
    public function handleErrors() {
        set_error_handler([$this, 'handleError']);
        set_exception_handler([$this, 'handleException']);
    }

    /**
     * 错误接管
     * @param $error
     * @param $message
     * @param $filename
     * @param $line
     */
    public function handleError($error, $message, $file, $line) {
        if ($error & error_reporting()) {
            new \dux\exception\Handle($message, 500, $file, $line, [], \dux\Config::get('dux.debug'), false, \dux\Config::get('dux.log'));
        }
    }

    /**
     * 异常接管
     * @param $e
     */
    public function handleException($e) {
        new \dux\exception\Handle($e->getMessage(), $e->getCode(), $e->getFile(), $e->getLine(), $e->getTrace(), \dux\Config::get('dux.debug'), false, \dux\Config::get('dux.log'));
    }

    /**
     * 解析路由
     */
    public function route() {
        $routes = \dux\Config::get('dux.route');
        foreach ($routes as $module => $rule) {
            if (empty($module)) {
                continue;
            }
            $rule = explode(" ", $rule, 2);
            array_map(function ($vo) {
                return trim($vo);
            }, $rule);
            list($method, $url) = $rule;
            if (empty($method) || empty($url)) {
                continue;
            }
            \dux\Dux::route()->add($method, $url, $module);
        }
        if (IS_CLI) {
            $params = getopt('u:');
            $url = $params['u'];
        } else {
            $url = URL;
        }
        $data = \dux\Dux::route()->dispatch($_SERVER['REQUEST_METHOD'], $url);
        if (!defined('DEFAULT_LAYER_NAME')) {
            define('DEFAULT_LAYER_NAME', $data['default_layer']);
        }
        if (!defined('ROLE_NAME')) {
            define('ROLE_NAME', $data['role']);
        }
        if (!defined('LAYER_NAME')) {
            define('LAYER_NAME', $data['layer']);
        }
        if (!defined('APP_NAME')) {
            define('APP_NAME', strtolower($data['app']));
        }
        if (!defined('MODULE_NAME')) {
            define('MODULE_NAME', ucfirst($data['module']));
        }
        if (!defined('ACTION_NAME')) {
            define('ACTION_NAME', $data['action']);
        }
    }

    /**
     * 运行框架
     * @throws \Exception
     */
    public function run() {
        if (IS_CLI && (!APP_NAME || !LAYER_NAME || !MODULE_NAME || !ACTION_NAME)) {
            exit('dux cli start');
        }
        $class = '\app\\' . APP_NAME . '\\' . LAYER_NAME . '\\' . MODULE_NAME . ucfirst(LAYER_NAME);
        $action = ACTION_NAME;
        if (!class_exists($class)) {
            \dux\Dux::notFound();
        }
        if (!method_exists($class, $action) && !method_exists($class, '__call')) {
            \dux\Dux::notFound();
        }
        (new $class())->$action();
    }
}
