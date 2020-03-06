<?php

namespace zongphp\wechat\build\user;

use zongphp\curl\Curl;

/**
 * 黑名单管理
 * Trait Black
 *
 * @package zongphp\wechat\build\user
 */
trait Black
{
    /**
     * 获取公众号的黑名单列表
     *
     * @param string $beginOpenId
     *
     * @return mixed
     */
    public function getblacklist($beginOpenId = '')
    {
        $url     = $this->apiUrl
            .'/cgi-bin/tags/members/getblacklist?access_token='
            .$this->getAccessToken();
        $param   = ['begin_openid' => $beginOpenId];
        $content = Curl::post($url,
            json_encode($param, JSON_UNESCAPED_UNICODE));

        return $this->get($content);
    }

    /**
     * 拉黑用户
     *
     * @param $openIdLists
     *
     * @return mixed
     */
    public function batchBlackList($openIdLists)
    {
        $url     = $this->apiUrl
            .'/cgi-bin/tags/members/batchblacklist?access_token='
            .$this->getAccessToken();
        $param   = ['opened_list' => $openIdLists];
        $content = Curl::post($url,
            json_encode($param, JSON_UNESCAPED_UNICODE));

        return $this->get($content);
    }

    /**
     * 取消拉黑用户
     *
     * @param $openIdLists
     *
     * @return mixed
     */
    public function batchUnBlackList($openIdLists)
    {
        $url     = $this->apiUrl
            .'/cgi-bin/tags/members/batchunblacklist?access_token='
            .$this->getAccessToken();
        $param   = ['opened_list' => $openIdLists];
        $content = Curl::post($url,
            json_encode($param, JSON_UNESCAPED_UNICODE));

        return $this->get($content);
    }
}