<?php
/**
 * 闲聊-机器人API
 * Created by PhpStorm.
 * User: 11951
 * Date: 2019/4/20
 * Time: 15:54
 */

include_once 'FreeTalkException.php';
include_once 'FreeTalkConfig.php';
include_once 'HttpHandle.php';
include_once 'FreeTalkHttp.php';

class FreeTalkApi
{

    /**
     * 检验SIGN
     * @param array $param
     * @return bool
     * @throws FreeTalkException
     */
    public static function checkSign(array $param)
    {
        if (empty($param['sign'])) {
            throw new FreeTalkException('没有可检验SIGN');
        }
        $sign = $param['sign'];
        unset($param['sign']);
        return self::makeSign($param) === $sign ? true : false;

    }

    /**
     * 生成SIGN
     * @param $param
     * @return string
     * @throws Exception
     */
    public static function makeSign($param)
    {
        $signStr = '';
        $robotSecret = FreeTalkConfig::getConfig('robotSecret');
        if (is_array($param)) {
            ksort($param);
            foreach ($param as $index => $item) {
                $signStr .= $index . '=' . $item . '&';
            }
        }
        $signStr = trim($signStr, '&');
        $signStr .= empty($signStr) ? 'robotSecret=' . $robotSecret : '&robotSecret=' . $robotSecret;
        return strtoupper(hash_hmac('sha256', $signStr, $robotSecret));
    }

    /**
     * 向闲聊发消息统一入口
     * @param $type
     * @param $data
     * @return array|mixed
     */
    public static function sendMess($type, $data)
    {
        switch ($type) {
            case 'sendTemplate2' :
                return self::sendTemplate2($data);
                break;
            case 'notifyXianLiaoKeyWord' :
                return self::notifyXianLiaoKeyWord($data);
                break;
        }
    }

    /**
     * 打印
     * @param $param
     */
    public static function p($param)
    {
        echo '<pre>';
        print_r($param);
        exit();
    }

    /**
     * 模板2消息推送
     * @param $param
     * @return array|mixed
     * @throws FreeTalkException
     */
    public static function sendTemplate2($param)
    {
        $param['robotId'] = FreeTalkConfig::getConfig('robotId');
        return self::exec(FreeTalkConfig::getServerApi('模板2'), $param);
    }

    /**
     * 同步关键字到闲聊
     * @param $param
     * @return array|mixed
     * @throws FreeTalkException
     */
    public static function notifyXianLiaoKeyWord($param)
    {
        $post = new HttpPost();
        $res = $post->request(FreeTalkConfig::getServerApi('同步关键字'), $param);
        return $res;
    }

    public static function checkFormat()
    {

    }

    /**
     * 执行请求
     * @param $url
     * @param string $data
     * @param string $method
     * @return array|mixed
     */
    public static function exec($url, $data = '', $method = 'post')
    {
        switch ($method) {
            case 'post' :
                $data['nonce'] = self::getRandomStr();
                $data['sign'] = self::makeSign($data);
                $post = new HttpPost();
                $res = $post->request($url, $data);
                break;
        }
        return $res;
    }

    /**
     * 获得随机字符串
     * @param $len
     * @return string
     */
    public static function getRandomStr($len = 20)
    {
        $chars = [
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k',
            'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v',
            'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G',
            'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R',
            'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '0', '1', '2',
            '3', '4', '5', '6', '7', '8', '9'
        ];
        $charsLen = count($chars) - 1;
        shuffle($chars);
        $str = '';
        for ($i = 0; $i < $len; $i++) {
            $str .= $chars[mt_rand(0, $charsLen)];
        }
        return $str;
    }
}

class FreeTalkErrorCode
{

}