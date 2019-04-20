<?php
/**
 * Created by PhpStorm.
 * User: 11951
 * Date: 2019/4/20
 * Time: 16:54
 */

include_once 'FreeTalkApi.php';

class Runfast {

    public function __construct()
    {

    }

    /**
     * 获取游戏结算结果
     */
    public function getGameCredits()
    {
        
    }

    /**
     * 获取该俱乐部是否绑定群助手
     */
    public function getOpenGroupId($culdId)
    {

    }

    /**
     * 接收C++推送 判断是否需要推送消息
     */
    public function notifyGameXianLiao()
    {
        try {
            $freeTalk = FreeTalkApi::sendMess('sendTemplate2', [
                'unionId' => 'cyS6/CiCnYSId11JSdUvzA==',
                'openGroupId' => '/V461falreuHaZPbnwB6BK/u4aToGZRVskmHg5eFf4g=',
                'title' => "P步活动\n2018.02.27 15:35:04",
                'content' => json_encode([
                    [
                        'imageUrl' => 'http://xl3rdapplogo.updrips.com/i14982019041814193251316981.png',
                        'line1' => '<html><body><p>凉风有信1874</p></body><html>',
                        'line2' => '<html><body>游戏ID:195279</body><html>',
                        'line3' => '<html><body><div><a>结算:</a><h1>5分</h1></div></body><html>',
                        'rightImageUrl' => 'http://xl3rdapplogo.updrips.com/i14982019041814193251316981.png',
                    ],
                    [
                        'imageUrl' => 'http://xl3rdapplogo.updrips.com/i14982019041814193251316981.png',
                        'line1' => '<html><body><p>凉风有信1874</p></body><html>',
                        'line2' => '<html><body>游戏ID:195279</body><html>',
                        'line3' => '<html><body><div><a>结算:</a><h1>5分</h1></div></body><html>',
                        'rightImageUrl' => 'http://xl3rdapplogo.updrips.com/i14982019041814193251316981.png',
                    ],
                    [
                        'imageUrl' => 'http://xl3rdapplogo.updrips.com/i14982019041814193251316981.png',
                        'line1' => '<html><body><p>凉风有信1874</p></body><html>',
                        'line2' => '<html><body>游戏ID:195279</body><html>',
                        'line3' => '<html><body><div><a>结算:</a><h1>5分</h1></div></body><html>',
                        'rightImageUrl' => 'http://xl3rdapplogo.updrips.com/i14982019041814193251316981.png',
                    ],
                ]),
                'nonce' => '865479nbhuybert34uyw',
            ]);
        } catch (FreeTalkException $e) {
            $freeTalk = $e->errorMessage();
        } catch (Exception $e) {
            $freeTalk = $e->getMessage();
        }

        return $freeTalk;
    }
}

$send = new Runfast();

FreeTalkApi::p($send->notifyGameXianLiao());
