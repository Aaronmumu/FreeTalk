<?php
/**
 * IDE: PhpStorm
 * Date: 2018/11/23
 * Time: 8:53
 */

namespace http;

use app\index\lib\curl\Config;

class BaseHttp
{
    private $ch;

    private $header;
    private $connTime;
    private $time;
    private $cookie;

    public function __construct()
    {
        $this->ch = curl_init();
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        //不校验ssl证书
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
    }

    protected function baseSetHead($header)
    {
        if (!empty($header)) {
            $this->header = $header;
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, $header);
        }
    }

    protected function baseSetTimeOut($connTime, $time)
    {
        if (empty($connTime)) {
            $connTime = 10;
            $this->connTime = $connTime;
        }
        if (empty($time)) {
            $time = 10;
            $this->time = $time;
        }
        curl_setopt($this->ch, CURLOPT_TIMEOUT, $time);
        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, $connTime);
    }

    protected function baseSetCookie($cookie)
    {
        curl_setopt($this->ch, CURLOPT_COOKIE, $cookie);
        $this->cookie = $cookie;
    }

    protected function baseSetCart()
    {
        curl_setopt($this->ch, CURLOPT_SSLCERTTYPE, Config::CURLOPT_SSLCERTTYPE);
        curl_setopt($this->ch, CURLOPT_SSLCERT, Config::CURLOPT_SSLCERT);
        curl_setopt($this->ch, CURLOPT_SSLKEYTYPE, Config::CURLOPT_SSLKEYTYPE);
        curl_setopt($this->ch, CURLOPT_SSLKEY, Config::CURLOPT_SSLKEY);
    }

    /**
     * 设置参数
     */
    private function setCURLOPT()
    {
        if (!empty($this->header)) {
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->header);
        }
        if (!empty($this->time)) {
            curl_setopt($this->ch, CURLOPT_TIMEOUT, $this->time);
        }
        if (!empty($this->connTime)) {
            curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, $this->connTime);
        }
        if (!empty($this->cookie)) {
            curl_setopt($this->ch, CURLOPT_COOKIE, $this->cookie);
        }

    }

    /**
     * 发起请求
     * @param string $url
     * @param $method
     * @param null $data
     * @return mixed|string
     * @throws \Exception
     */
    protected function doRequest($url = '', $method, $data = null)
    {
        if (empty($url)) {
            throw new \Exception("url is null");
        }
        if ((get_resource_type($this->ch) != 'curl')) {
            $this->ch = curl_init();
            $this->setCURLOPT();
        }
        curl_setopt($this->ch, CURLOPT_URL, $url);
        if ($method == 'POST') {
            curl_setopt($this->ch, CURLOPT_PORT, 0);//设置post请求
            if (is_array($data) && !empty($data)) {
                curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($data));
            } elseif (!is_null($data)) {
                curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);
            } else {
                throw new \Exception("data is null");
            }
        }
        $result = curl_exec($this->ch);

        if (curl_errno($this->ch)) {
            throw new \Exception(curl_error($this->ch));
        }
        curl_close($this->ch);
        return $result;
    }

    public function __destruct()
    {
        if (get_resource_type($this->ch) == 'curl') {
            curl_close($this->ch);
        }
    }

}