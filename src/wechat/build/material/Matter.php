<?php
namespace zongphp\wechat\build\material;

use zongphp\curl\Curl;

/**
 * 永久素材
 * Trait LongMaterial
 *
 * @package zongphp\wechat\material
 */
trait Matter
{
    /**
     * 上传永久素材
     *
     * @param string $type 素材类型
     * @param string $file 文件资源
     *
     * @return array|mixed
     */
    public function addMaterial($type, $file)
    {
        $url = $this->apiUrl."/cgi-bin/material/add_material?access_token={$this->accessToken}&type=$type";

        return $this->get(Curl::post($url, $this->getPostMedia($file)));
    }

    /**
     * 上传永久视频素材
     *
     * @param string $file        素材文件
     * @param array  $description 描述信息
     *
     * @return array|mixed
     */
    public function addVideoMaterial($file, array $description)
    {
        $url                 = $this->apiUrl
                               ."/cgi-bin/material/add_material?access_token={$this->accessToken}&type=video";
        $post                = $this->getPostMedia($file);
        $post['description'] = json_encode($description,
            JSON_UNESCAPED_UNICODE);

        return $this->get(Curl::post($url, $post));
    }

    /**
     * 获取永久素材
     *
     * @param $mediaId
     *
     * @return array|mixed
     */
    public function getMaterial($mediaId)
    {
        $url  = $this->apiUrl
                ."/cgi-bin/material/get_material?access_token={$this->accessToken}";
        $json = '{"media_id":"'.$mediaId.'"}';
        return $this->get(Curl::post($url, $json));
    }

    /**
     * 删除永久素材
     *
     * @param $media_id
     *
     * @return array|mixed
     */
    public function delMaterial($media_id)
    {
        $url  = $this->apiUrl
                ."/cgi-bin/material/del_material?access_token={$this->accessToken}";
        $json = '{"media_id":"'.$media_id.'"}';

        return $this->get(Curl::post($url, $json));
    }
}