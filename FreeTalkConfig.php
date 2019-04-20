<?php
/**
 * Created by PhpStorm.
 * User: 11951
 * Date: 2019/4/20
 * Time: 15:55
 */
include_once 'FreeTalkException.php';

class FreeTalkConfig
{
    /**
     * 获取闲聊配置
     * @param string $name
     * @return array
     * @throws Exception
     */
    public static function getConfig($name = '')
    {
        $config = [
            'robotId' => 'ETAw9uO02g7QIJ83',
            'robotSecret' => 'BMlkjuDtM0IKkRPDb5Bx',
        ];
        if (empty($config)) {
            throw new FreeTalkException('未设置闲聊配置');
        }
        if (!empty($name)) {
            if (!isset($config[$name])) {
                throw new FreeTalkException('未设置闲聊配置:' . $name);
            }
            return $config[$name];
        }
        return $config;
    }

    /**
     * 获取闲聊对应地址
     * @param string $name
     * @return mixed
     * @throws FreeTalkException
     */
    public static function getServerApi($name = '模板2')
    {
        $serverApi = [
            '模板2' => 'https://robot.xianliao.updrips.com/robot/shareResult',
            '同步关键字' => 'https://robot.xianliao.updrips.com/robot/updateGroupKeyword',
        ];
        if (!isset($serverApi[$name])) {
            throw new FreeTalkException('找不到对应服务地址');
        }
        return $serverApi[$name];
    }
}
