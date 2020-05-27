<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Test;
use yii\db\QueryInterface;
use yii\db\QueryTrait;
use yii\mongodb\Query;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;
class SiteController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        //$customers = Customer::find()->with('orders')->asArray()->all();
        $session = Yii::$app->session;
        $session->set('test11',2222);
        $cc = $session->get('test11');
        var_dump($cc);
        die;
        //$customers = Customer::find()->with('orders')->asArray()->all();
          $db = Yii::$app->db;
        $transaction = $db->beginTransaction();  //开启事务
        try {
            for($i=1;$i<=3;$i++) {
                $model = new Test();
                $model->name = 111;
                $model->name1 = 222;
                $model->name2 = 333;
                $model->name3 = 4444;
                $Res = $model->insert();
                if (!$Res) {
                    throw new \Exception("save fail 1");//抛出异
                }
            }
            $model = new Test();
            $model->name1111 = 222;
            $Res = $model->insert();
            var_dump($Res);
            if (!$Res) {
                throw new \Exception("save fail 2");//抛出异
            }

            $transaction->commit();

        } catch (\Exception $e) {
            // 记录回滚（事务回滚）
            $transaction->rollBack();
            echo $e->getMessage();

        }

        var_dump(1111);die;
        $data = [
            "id"=>"zhansg",
            "name"=>111
        ];

        //添加
        $model = new Test();
        $model->name= $data['name'];
        $model->name1= $data['name'];
        $model->name2= $data['name'];
        $model->name3= json_encode($data);
        $Res = $model->insert();
        $dada = Test::findAll(['name'=>111]);
        echo '<pre>';
        //print_r($dada);die;
        //删除
        $q = Test::find()->where(['name'=>111])->one();
       // $cc =  $q->delete();
        print_r($q);die;
        //更新,查询
        $q = Test::find()->where(['name'=>222])->one();
        $q->name=221222;
        $cc =  $q->update();
        print_r($cc);die;


        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $request = Yii::$app->getRequest();
        $signer = new Sha256();//使用Sha256加密，常用加密方式有Sha256,Sha384,Sha512
        $time = time();
        $tokenBuilder = (new Builder())
            ->issuedBy($request->getHostInfo()) // 设置发行人
            ->permittedFor(isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '') // 设置接收
            ->identifiedBy(Yii::$app->security->generateRandomString(10), true) // 设置id
            ->issuedAt($time) // 设置生成token的时间
            ->canOnlyBeUsedAfter($time) // 设置token使用时间(实时使用)
            ->expiresAt($time + 3600); //设置token过期时间
//定义自己所需字段
        $user = $request->post();
        $tokenBuilder->withClaim('user', $user);
        $tokenBuilder->withClaim('ceshi', '测试字段');
//使用Sha256加密生成token对象，该对象的字符串形式为一个JWT字符串
        $token = $tokenBuilder->getToken($signer, new Key('jwt_secret'));
        return (string)$token;
    }

    /**
     * 校验token
     *
     * @return Response|string
     */
    public function actionGetTokenInfo()
    {
        $request = Yii::$app->getRequest()->post();
        $token = (new Parser())->parse($request['token']);
//数据校验
        $data = new ValidationData(); // 使用当前时间来校验数据
        if (!$token->validate($data)) {
            //数据校验失败
            return '数据校验失败';
        }
//token校验
        $signer = new Sha256();//生成JWT时使用的加密方式
        if (!$token->verify($signer, new Key('jwt_secret'))) {
            //token校验失败
            return 'token校验失败';
        }
        echo '校验成功';
    }
    /**
     * 检测到期时间
     *
     * @return Response|string
     */
    public function actionCheckToken()
    {
        $request = Yii::$app->getRequest()->post();
        $token = (new Parser())->parse($request['token']);
        $token->getHeaders(); // 获取JWT的Header(头部)信息
        $token->getClaims(); // 获取JWT的PayLoad(负载)信息
//获取指定参数的PayLoad(负载)信息
        $token->getClaim('jti');
        $token->getClaim('user');
          $token->isExpired();
          var_dump($token);
          //得到过期时间
       // var_dump($token->getClaim('exp'));
        //正常情况下，先判断用户的token过期没有，
        //没有的话 比较字段里面的user(自定义的字段)
        //["exp"]=>
        //object(Lcobucci\JWT\Claim\GreaterOrEqualsTo)#88 (2) {
        //["name":"Lcobucci\JWT\Claim\Basic":private]=>
        //string(3) "exp"
        //["value":"Lcobucci\JWT\Claim\Basic":private]=>
        //int(1590395730)
        //}
        //["user"]=>
        //object(Lcobucci\JWT\Claim\Basic)#89 (2) {
        //["name":"Lcobucci\JWT\Claim\Basic":private]=>
        //string(4) "user"
        //["value":"Lcobucci\JWT\Claim\Basic":private]=>
        //object(stdClass)#83 (2) {
        //["user_name"]=>
        //string(6) "测试"
        //["user_no"]=>
        //string(3) "001"
        //}
        //}
        //["ceshi"]=>
        //object(Lcobucci\JWT\Claim\Basic)#90 (2) {
        //["name":"Lcobucci\JWT\Claim\Basic":private]=>
        //string(5) "ceshi"
        //["value":"Lcobucci\JWT\Claim\Basic":private]=>
        //string(12) "测试字段"
        //}
    }
}
