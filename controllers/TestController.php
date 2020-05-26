<?php
namespace app\controllers;
use app\models\Service;
class TestController extends \yii\web\Controller{

    public function actionIndex(){
        \Yii::$app->websocket->send([
            'channel' => 'push-message',
            'name' => \Yii::$app->request->get('name', 1),
            'message' => \Yii::$app->request->get('message', '用户 Gunn 送给主播 象拔河 一架飞机！')
        ]);
        //return true;
    }

    public function actionTest(){
        \Yii::$app->websocket->send([
            'channel' => 'enter'
        ]);
       return $this->render('/test.html');

    }
}