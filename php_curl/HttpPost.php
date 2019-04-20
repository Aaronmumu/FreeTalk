<?php
/**
 * IDE: PhpStorm
 * Date: 2018/11/23
 * Time: 10:34
 */

namespace http;


class HttpPost extends BaseHttp implements HttpClient
{
    public function __construct()
    {
        parent::__construct();
        $this->setHead([
            'Content-Type: application/x-www-form-urlencoded'
        ]);
    }

    public function request($url, $data)
    {
        try {
            return [
                'code' => 200,
                'result' => $this->doRequest($url, 'POST', $data)
            ];
        } catch (\Exception $e) {
            return [
                'code' => 500,
                'result' => $e->getMessage()
            ];
        }
    }

    public function setHead($header)
    {
        $this->baseSetHead($header);
        return $this;
    }

    public function setTimeOut($connTime, $time)
    {
        $this->baseSetTimeOut($connTime, $time);
        return $this;
    }

    public function setCookie($cookie)
    {
        $this->baseSetCookie($cookie);
        return $this;
    }

    public function setCart()
    {
        $this->baseSetCart();
        return $this;
    }

    public function __destruct()
    {
        parent::__destruct();
    }

}