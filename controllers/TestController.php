<?php
namespace app\controllers;
use app\models\Service;
class TestController extends \yii\web\Controller{
    /**
     * @SWG\Get(path="/user",
     *     tags={"User"},
     *     summary="Retrieves the collection of User resources.",
     *     @SWG\Response(
     *         response = 200,
     *         description = "User collection response",
     *         @SWG\Schema(ref = "#/definitions/User")
     *     ),
     * )
     */
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