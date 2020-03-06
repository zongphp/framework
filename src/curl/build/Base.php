<?php namespace houdunwang\curl\build;

class Base
{
    protected $code;
    protected $result;

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }


    /**
     * GET提交
     *
     * @param $url
     *
     * @return string
     * @throws \Exception
     */
    public function get($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        if (curl_exec($ch) === false) {
            throw new \Exception(curl_error($ch));
            $data = '';
        } else {
            $data = curl_multi_getcontent($ch);
        }
        $this->setCode(curl_getinfo($ch, CURLINFO_HTTP_CODE));
        curl_close($ch);
        $this->setResult($data);

        return $data;
    }

    /**
     * POST提交
     *
     * @param       $url
     * @param array $postData
     *
     * @return string
     * @throws \Exception
     */
    public function post($url, $postData = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        if (curl_exec($ch) === false) {
            throw new \Exception(curl_error($ch));
            $data = '';
        } else {
            $data = curl_multi_getcontent($ch);
        }
        $this->setResult($data);
        $this->setCode(curl_getinfo($ch, CURLINFO_HTTP_CODE));
        curl_close($ch);

        return $data;
    }
}