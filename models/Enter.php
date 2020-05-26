<?php

namespace app\models;
use app\models\Lives;
use yii\base\BaseObject;
class Enter extends BaseObject implements \yiiplus\websocket\ChannelInterface
{
    /**
     * 进入直播间绑定关联关系
     *
     * @param interge $fd   客户端ID
     * @param string  $data 客户端数据
     *
     * @return null
     */
    public function execute($fd, $data)
    {
        var_dump($fd);
        var_dump($data);
        $liveRoomModel = new Lives();
        $liveRoomModel->id = $fd;
        $liveRoomModel->room_id = 1;
        $liveRoomModel->uid = 1;
       echo $liveRoomModel->insert();
    }
    public function close($fd)
    {
        $customer = Lives::find()->where(['id'=>$fd])->one();
        $customer->delete();
    }





}
