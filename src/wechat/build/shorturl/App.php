<?php
namespace zongphp\wechat\build\shorturl;

use zongphp\curl\Curl;
use zongphp\wechat\build\Base;

/**
 * 长链接转短链接接口
 * Class Shorturl
 *
 * @package zongphp\wechat\build
 */
class App extends Base
{
    /**
     * 长链接转短链接接口
     *
     * @param $longUrl
     *
     * @return array|mixed
     */
    public function makeShortUrl($longUrl)
    {
        $url   = $this->apiUrl.'/cgi-bin/shorturl?access_token='.$this->getAccessToken();
        $param = [
            'action'   => 'long2short',
            'long_url' => $longUrl,
        ];

        $content = Curl::post($url, json_encode($param, JSON_UNESCAPED_UNICODE));

        return $this->get($content);
    }
}