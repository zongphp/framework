<?php

namespace zongphp\wechat\build\material;

use zongphp\curl\Curl;

/**
 * 临时素材管理
 * Trait Media
 *
 * @package zongphp\wechat\material
 */
trait Media
{
    /**
     * 上传临时素材
     *
     * @param     $type
     * @param     $file
     *
     * @return mixed
     */
    public function addMedia($type, $file)
    {
        $url = $this->apiUrl
            ."/cgi-bin/media/upload?access_token={$this->accessToken}&type=$type";

        $result = Curl::post($url, $this->getPostMedia($file));

        return $this->get($result);
    }

    /**
     * 下载临时素材
     *
     * @param $mediaId
     *
     * @return bool|string
     */
    public function getMedia($mediaId)
    {
        $url = $this->apiUrl
            ."/cgi-bin/media/get?access_token={$this->accessToken}&media_id={$mediaId}";

        $res = Curl::get($url);

        return $this->get($res);
    }
}