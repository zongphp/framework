<?php
namespace zongphp\wechat\build\material;

use zongphp\curl\Curl;

/**
 * 图文素材
 * Trait news
 *
 * @package zongphp\wechat\material
 */
trait News
{
    /**
     * 上传图文消息内的图片获取URL
     *
     * @param $file
     *
     * @return mixed
     */
    public function addNewsImage($file)
    {
        $url     = $this->apiUrl."/cgi-bin/media/uploadimg?access_token="
                   .$this->getAccessToken();
        $content = Curl::post($url, $this->getPostMedia($file));

        return $this->get($content);
    }

    /**
     * 新增永久图文素材
     *
     * @param $articles
     *
     * @return mixed
     */
    public function addNews($articles)
    {
        $url     = $this->apiUrl."/cgi-bin/material/add_news?access_token={$this->accessToken}";
        $content = Curl::post($url, json_encode($articles, JSON_UNESCAPED_UNICODE));

        return $this->get($content);
    }

    /**
     * 修改永久图文素材
     *
     * @param $article
     *
     * @return mixed
     */
    public function editNews($article)
    {
        $url     = $this->apiUrl
                   ."/cgi-bin/material/update_news?access_token={$this->accessToken}";
        $content = Curl::post($url, json_encode($article, JSON_UNESCAPED_UNICODE));

        return $this->get($content);
    }
}