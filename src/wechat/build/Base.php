<?php

namespace zongphp\wechat\build;

use zongphp\config\Config;
use zongphp\curl\Curl;
use zongphp\dir\Dir;
use zongphp\wechat\build\common\Error;
use zongphp\wechat\build\common\Sign;
use zongphp\wechat\build\common\Xml;
use zongphp\cache\Cache;

/**
 * 基础类
 * Class Base
 *
 * @package zongphp\wechat\build
 */
class Base extends Error
{
    use Xml, Sign;
    protected $appid;
    protected $appsecret;

    //验证令牌
    protected $accessToken;

    //微信服务器发来的数据
    protected $message;

    //API 根地址
    protected $apiUrl = 'https://api.weixin.qq.com';

    //缓存目录
    protected $cacheDir;

    public function __construct()
    {
        $this->appid     = Config::get('wechat.appid');
        $this->appsecret = Config::get('wechat.appsecret');
        $this->cacheDir  = Config::get('wechat.cache_path');
        $this->setAccessToken();
        $this->setMessage();
    }

    /**
     * 获取微信消息内容
     *
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * 获取微信发送来的消息
     */
    public function setMessage()
    {
        $content    = file_get_contents('php://input');
        $xml_parser = xml_parser_create();
        if ( ! xml_parse($xml_parser, $content, true)) {
            xml_parser_free($xml_parser);

            return false;
        } else {
            $this->message = simplexml_load_string($content, 'SimpleXMLElement', LIBXML_NOCDATA);
        }
    }

    /**
     * 获取消息内容
     *
     * @param string $name 消息字段
     *
     * @return null
     */
    public function __get($name)
    {
        return isset($this->message->$name) ? $this->message->$name : null;
    }

    /**
     * 获取指定消息内容
     *
     * @param string $name 变量名
     *
     * @return null
     */
    public function content($name)
    {
        return isset($this->message->$name) ? $this->message->$name : null;
    }

    /**
     * 获取消息类型
     *
     * @return mixed
     */
    public function getMessageType()
    {
        //事件消息时取Event属性做为消息类型
        $message = $this->getMessage();

        return $message->MsgType == 'event' ? $message->Event : $message->MsgType;
    }

    /**
     * 微信接口整合验证进行绑定
     *
     * @return bool
     */
    public function valid()
    {
        if ( ! isset($_GET["echostr"]) || ! isset($_GET["signature"])
             || ! isset($_GET["timestamp"])
             || ! isset($_GET["nonce"])) {
            return false;
        }
        $echoStr   = $_GET["echostr"];
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce     = $_GET["nonce"];
        $token     = Config::get('wechat.token');
        $tmpArr    = [$token, $timestamp, $nonce];
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if ($tmpStr == $signature) {
            echo $echoStr;
            exit;
        } else {
            return false;
        }
    }

    /**
     * @return mixed
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * 设置accessToken
     *
     * @param bool $force 强制设置
     *
     * @throws \Exception
     */
    public function setAccessToken($force = false)
    {
        static $accessToken;
        if ( ! $accessToken) {
            $cacheName = $this->appid . $this->appsecret . '_wechat_access_token_';
            $data      = Cache::get($cacheName);
            if ($force === true || ! $data) {
                $url  = $this->apiUrl . '/cgi-bin/token?grant_type=client_credential&appid='
                        . $this->appid . '&secret=' . $this->appsecret;
                $data = json_decode(Curl::get($url), true);
                //获取失败
                if (isset($data['errmsg'])) {
                    throw new \Exception($data['errmsg']);
                }
                //缓存access_token
                Cache::set($cacheName, $data, 7000);
            }
            $accessToken = $data['access_token'];
        }

        $this->accessToken = $accessToken;
    }

    /**
     * 获取实例
     *
     * @param string $api
     *
     * @return mixed
     */
    public function instance($api)
    {
        $class = '\zongphp\wechat\build\\' . strtolower($api) . '\\App';

        return new $class();
    }

    /**
     * 格式化上传素材的数据
     *
     * @param $file
     *
     * @return array
     */
    protected function getPostMedia($file)
    {
        if (class_exists('\CURLFile')) {
            //关键是判断curlfile,官网推荐php5.5或更高的版本使用curlfile来实例文件
            $data = [
                'media' => new \CURLFile (realpath($file)),
            ];
        } else {
            $data = [
                'media' => '@' . realpath($file),
            ];
        }

        return $data;
    }
}