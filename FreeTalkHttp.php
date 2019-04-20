<?php
/**
 * Created by PhpStorm.
 * User: 11951
 * Date: 2019/4/20
 * Time: 17:15
 */

class Config
{
    const CURLOPT_SSLCERTTYPE = 'PEM';//证书类型
    const CURLOPT_SSLCERT = '';//证书路径
    const CURLOPT_SSLKEYTYPE = 'PEM';//秘钥类型
    const CURLOPT_SSLKEY = '';//秘钥路径
}

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
            $connTime = 30;
            $this->connTime = $connTime;
        }
        if (empty($time)) {
            $time = 30;
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

interface HttpClient
{
    /**
     * 发起请求
     * @param $url
     * @param $data
     * @return mixed
     */
    public function request($url, $data);

    /**
     * 设置http头信息
     * @param $header
     * @return mixed
     */
    public function setHead($header);

    /**
     * 设置超时时间
     * @param $connTime
     * @param $time
     * @return mixed
     */
    public function setTimeOut($connTime, $time);

    /**
     * 设置cookie
     * @param $cookie
     * @return mixed
     */
    public function setCookie($cookie);

    /**
     * 配置携带证书 访问
     * @return mixed
     */
    public function setCart();
}

class HttpGet extends BaseHttp implements HttpClient
{
    public function __construct()
    {
        parent::__construct();
    }

    public function request($url, $data = null)
    {
        if (!is_null($data) && is_array($data)) {
            $url .= '?' . http_build_query($data);
        }
        try {
            return [
                'code' => 200,
                'result' => $this->doRequest($url, 'GET')
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