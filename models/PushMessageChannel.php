<?php

namespace app\models;
use app\models\Lives;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;

class PushMessageChannel extends BaseObject implements \yiiplus\websocket\ChannelInterface
{
    public function execute($fd, $data)
    {
       // var_dump('fd==>'.$fd);
        //var_dump($data);
        //string(6) "fd==>2"
        //object(stdClass)#29 (3) {
        //  ["channel"]=>
        //  string(12) "push-message"
        //  ["room_id"]=>
        //  string(2) "11"
        //  ["message"]=>
        //  string(2) "21"
        //}
        $liveRoomIds = Lives::findAll(['room_id' => 1]);
        $liveRoomIds =  ArrayHelper::getColumn($liveRoomIds,"id");
        return [
            $liveRoomIds,
            $data->message
        ];
    }

    public function close($fd)
    {

        return  false;
    }





}
