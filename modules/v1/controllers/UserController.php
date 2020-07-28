<?php
namespace app\modules\v1\controllers;

use yii\web\Controller;

class UserController extends Controller{


    /**
     * @SWG\Post(
     *     path="puzzle/rewardPiece",
     *     tags={"puzzle"},
     *     operationId="reward",
     *     summary="系统赠送碎片",
     *     @SWG\Parameter(
     *         name="pieceArr",
     *         in="body",
     *         description="碎片数组,['piece_id'=>num]",
     *     ),
     *     @SWG\Response(
     *         response=1,
     *         description="success",
     *     ),
     *     @SWG\Response(
     *         response=37001,
     *         description="param error",
     *     ),
     *     @SWG\Response(
     *         response=37002,
     *         description="piece id not exist",
     *     )
     * )
     */
    public function actionRewardPiece($pieceArr = [])
    {
       $res['code'] =1;
       $res['message'] = 'success';
        return $res;
    }
}