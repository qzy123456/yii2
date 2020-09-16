<?php
namespace app\controllers;
use app\models\Service;
/**
 * @SWG\Swagger(
 *     basePath="/test",
 *     produces={"application/json"},
 *     consumes={"application/x-www-form-urlencoded"},
 *     @SWG\Info(version="1.0", title="Simple API"),
 * )
 */
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
    /**
     * @SWG\Post(path="/delivery/order-sheet/{shippingNumber}/{sign}",
     *   tags={"Delivery"},
     *   summary="Sync order sheet result from warehouse to Glitzhome",
     *   description="从仓库同步发货结果",
     *   operationId="delivery/order-sheet",
     *   produces={"application/xml", "application/json"},
     *   @SWG\Parameter(
     *     name="shippingNumber",
     *     in="path",
     *     description="Shipping Number",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="sign",
     *     in="path",
     *     description="Sign of request parameters",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     description="授权Token，Bearer模式",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     in="body",
     *     name="orderSheet",
     *     description="仓库反馈的Order sheet的结果",
     *     required=true,
     *     type="array",
     *     @SWG\Schema(ref="#/definitions/OrderSheetRequest")
     *   ),
     *
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/OrderSheetResponse"), description="successful operation"),
     *   @SWG\Response(response=400,description="Bad request"),
     *   @SWG\Response(response=401,description="Not authorized"),
     *   @SWG\Response(response=404,description="Method not found"),
     *   @SWG\Response(response=405,description="Method not allowed"),
     *   @SWG\Response(response=426,description="Upgrade required"),
     *   @SWG\Response(response=429,description="Rate limit exceeded"),
     *   @SWG\Response(response=499,description="Customized business errors"),
     *   @SWG\Response(response=500,description="Internal Server Error"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     *
     */
    public function actionTest(){
        \Yii::$app->websocket->send([
            'channel' => 'enter'
        ]);
       return $this->render('/test.html');

    }
}