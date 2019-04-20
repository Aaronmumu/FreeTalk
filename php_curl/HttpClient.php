<?php
/**
 * IDE: PhpStorm
 * Date: 2018/11/23
 * Time: 9:00
 */

namespace http;


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