<?php

namespace zongphp\wechat\build\user;

/**
 * 粉丝管理
 * Class User
 *
 * @package zongphp\wechat\build
 */
use houzongphpdunwang\curl\Curl;
use zongphp\wechat\build\Base;

/**
 * Class User
 *
 * @package zongphp\wechat\build
 */
class App extends Base
{
    use Black;

    /**
     * 设置备注名
     *
     * @param $param
     *
     * @return array|mixed
     */
    public function setRemark($param)
    {
        $url     = $this->apiUrl.'/cgi-bin/user/info/updateremark?access_token='
                   .$this->getAccessToken();
        $content = Curl::post($url,
            json_encode($param, JSON_UNESCAPED_UNICODE));

        return $this->get($content);
    }

    /**
     * 获取用户基本信息
     *
     * @param $openid
     *
     * @return array|mixed
     */
    public function getUserInfo($openid)
    {
        $url     = $this->apiUrl
                   ."/cgi-bin/user/info?openid={$openid}&lang=zh_CN&access_token="
                   .$this->getAccessToken();
        $content = Curl::get($url);

        return $this->get($content);
    }

    /**
     * 批量获取用户基本信息
     *
     * @param $param
     *
     * @return array|mixed
     */
    public function getUserInfoLists($param)
    {
        $url     = $this->apiUrl.'/cgi-bin/user/info/batchget?access_token='
                   .$this->getAccessToken();
        $content = Curl::post($url,
            json_encode($param, JSON_UNESCAPED_UNICODE));

        return $this->get($content);
    }

    /**
     * 获取用户列表
     *
     * @param string $next_openid
     *
     * @return array|mixed
     */
    public function getUserLists($next_openid = '')
    {
        $url = $this->apiUrl
               ."/cgi-bin/user/get?access_token=".$this->getAccessToken();
        if ($next_openid) {
            $url .= "&next_openid={$next_openid}";
        }
        $content = Curl::get($url);

        return $this->get($content);
    }
}