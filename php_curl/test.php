<?php
/**
 * IDE: PhpStorm
 * Date: 2018/11/23
 * Time: 10:49
 */
include 'HttpClient.php';
include 'BaseHttp.php';
include 'HttpPost.php';
include 'HttpGet.php';

//初始化HTTP Post
$post = new http\HttpPost();
//普通的HTTP,post请求,默认content_type为application/x-www-form-urlencoded
$res = $post->request('url', ['id' => 1, 'name' => 'name']);
if ($res['code'] == 200) {//请求成功
    //打印返回结果
    var_dump($res['result']);
    //获取返回的cookie(key为HTTP报文中的head的key;当key参数为null时,返回所有信息)
}
//携带证书的HTTP,post,Content-Type为text/xml请求
$res = $post->setHead(['Content-Type: text/xml'])->setCart()->request('url', ['id' => 1, 'name' => 'name']);
if ($res['code'] == 200) {//请求成功
    //打印返回结果
    var_dump($res['result']);
}
//初始化HTTP  Get
$get = new \http\HttpGet();
//简单的HTTP,get请求
var_dump($get->request('https://www.baidu.com'));