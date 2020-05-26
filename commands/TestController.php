<?php
namespace app\commands;

use Workerman\Worker;
use yii\console\Controller;
use yii\helpers\Console;

/**
 *
 * WorkermanWebSocket
 *
 * @author durban.zhang <durban.zhang@gmail.com>
 */

class TestController extends Controller
{
    public $send;
    public $daemon;
    public $gracefully;

    // 这里不需要设置，会读取配置文件中的配置
    public $config = [];
    private $ip = '127.0.0.1';
    private $port = '2346';

    public function options($actionID)
    {
        return ['send', 'daemon', 'gracefully'];
    }

    public function optionAliases()
    {
        return [
            's' => 'send',
            'd' => 'daemon',
            'g' => 'gracefully',
        ];
    }

    public function actionIndex()
    {
        $worker = new Worker('websocket://127.0.0.1:1234');
// ====这里进程数必须必须必须设置为1====
        $worker->count = 1;
// 新增加一个属性，用来保存uid到connection的映射(uid是用户id或者客户端唯一标识)
        $worker->uidConnections = array();
// 当有客户端发来消息时执行的回调函数
        $worker->onMessage = function ($connection, $data) {
            global $worker;
            // 判断当前客户端是否已经验证,即是否设置了uid
            if (!isset($connection->uid)) {
                // 没验证的话把第一个包当做uid（这里为了方便演示，没做真正的验证）
                $connection->uid = $data;
                /* 保存uid到connection的映射，这样可以方便的通过uid查找connection，
                 * 实现针对特定uid推送数据
                 */
                $worker->uidConnections[$connection->uid] = $connection;
                return $connection->send('login success, your uid is ' . $connection->uid);
            }
            // 其它逻辑，针对某个uid发送 或者 全局广播
            // 假设消息格式为 uid:message 时是对 uid 发送 message
            // uid 为 all 时是全局广播
            list($recv_uid, $message) = explode(':', $data);
            // 全局广播
            if ($recv_uid == 'all') {
                $this->broadcast($message);
            } // 给特定uid发送
            else {
                $this->sendMessageByUid($recv_uid, $message);
            }
        };

// 当有客户端连接断开时
        $worker->onClose = function ($connection) {
            global $worker;
            if (isset($connection->uid)) {
                // 连接断开时删除映射
                unset($worker->uidConnections[$connection->uid]);
            }
        };
        Worker::runAll();

    }
    // 向所有验证的用户推送数据
    function broadcast($message)
    {
        global $worker;
        foreach ($worker->uidConnections as $connection) {
            $connection->send($message);
        }
    }

// 针对uid推送数据
    function sendMessageByUid($uid, $message)
    {
        global $worker;
        if (isset($worker->uidConnections[$uid])) {
            $connection = $worker->uidConnections[$uid];
            $connection->send($message);
        }
    }
}
