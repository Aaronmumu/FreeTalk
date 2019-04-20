<?php
/**
 * Created by PhpStorm.
 * User: 11951
 * Date: 2019/4/20
 * Time: 15:56
 */

class FreeTalkException extends Exception
{
    public function errorMessage()
    {
        return '闲聊:' . $this->getMessage();
    }
}
