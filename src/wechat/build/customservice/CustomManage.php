<?php
namespace zongphp\wechat\build\customservice;

use zongphp\curl\Curl;

/**
 * 客服帐号管理
 * Trait manage
 *
 * @package zongphp\wechat\build\customservice
 */
trait CustomManage
{
    /**
     * 添加客服
     *
     * @param $post
     *
     * @return array|mixed
     */
    public function addCustomer($post)
    {
        $url    = $this->apiUrl.'/customservice/kfaccount/add?access_token='
            .$this->getAccessToken();
        $result = Curl::post($url, json_encode($post, JSON_UNESCAPED_UNICODE));

        return $this->get($result);
    }

    /**
     * 修改客服帐号
     *
     * @param $post
     *
     * @return array|mixed
     */
    public function updateCustomer($post)
    {
        $url    = $this->apiUrl.'/customservice/kfaccount/update?access_token='
            .$this->getAccessToken();
        $result = Curl::post($url, json_encode($post, JSON_UNESCAPED_UNICODE));

        return $this->get($result);
    }

    /**
     * 删除客服帐号
     *
     * @param string $kfAccount 客服帐号
     *
     * @return array|mixed
     */
    public function delCustomer($kfAccount)
    {
        $url    = $this->apiUrl.'/customservice/kfaccount/del?access_token='
            .$this->getAccessToken().'&kf_account='.$kfAccount;
        $result = Curl::get($url);

        return $this->get($result);
    }

    /**
     * 设置客服帐号的头像
     *
     * @param $post
     *
     * @return array|mixed
     */
    public function uploadheadimg($post)
    {
        $url    = $this->apiUrl
            .'/customservice/kfaccount/uploadheadimg?access_token='
            .$this->getAccessToken()
            .'&kf_account='.$post['kf_account'];
        $file   = $this->getPostMedia($post['file']);
        $result = Curl::post($url, $file);

        return $this->get($result);
    }

    /**
     * 获取所有客服账号
     *
     * @return array|mixed
     */
    public function getkflist()
    {
        $url    = $this->apiUrl
            .'/cgi-bin/customservice/getkflist?access_token='
            .$this->getAccessToken();
        $result = Curl::get($url);

        return $this->get($result);
    }
}