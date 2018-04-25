<?php
namespace app;

use app\Process\SpiderTaskProcess;
use PhpAmqpLib\Message\AMQPMessage;
use Server\Asyn\AMQP\AMQP;
use Server\Components\Process\ProcessManager;
use Server\CoreBase\HttpInput;
use Server\CoreBase\Loader;
use Server\SwooleDistributedServer;
use app\Process\MyProcess;
use app\Process\MyAMQPTaskProcess;
/**
 * Created by PhpStorm.
 * User: zhangjincheng
 * Date: 16-9-19
 * Time: 下午2:36
 */
class AppServer extends SwooleDistributedServer
{
    /**
     * 可以在这里自定义Loader，但必须是ILoader接口
     * AppServer constructor.
     */
    public function __construct()
    {
        $this->setLoader(new Loader());
        //通过这个可以精确判断发生异常和错误的位置，也可以了解到SD框架的工作流程。
        $this->setDebugMode();

        parent::__construct();
    }

    /**
     * 开服初始化(支持协程)
     * @return mixed
     */
    public function onOpenServiceInitialization()
    {
        yield parent::onOpenServiceInitialization();
    }

    /**
     * 这里可以进行额外的异步连接池，比如另一组redis/mysql连接
     * @param $workerId
     * @return array
     */
    public function initAsynPools($workerId)
    {
        parent::initAsynPools($workerId);

        $this->addAsynPool('AMQP',new AMQP('localhost',5672,'guest','guest'));

    }

    /**
     * 用户进程
     */
    public function startProcess()
    {
        parent::startProcess();

        ProcessManager::getInstance()->addProcess(MyProcess::class);

        //ProcessManager::getInstance()->addProcess(MyProcess::class,true,1);
        for ($i=0;$i<5;$i++)
        {
            ProcessManager::getInstance()->addProcess(MyAMQPTaskProcess::class,true,$i);
        }
        for ($i=0;$i<5;$i++)
        {
            ProcessManager::getInstance()->addProcess(SpiderTaskProcess::class,true,$i);
        }
    }

    /**
     * 可以在这验证WebSocket连接,return true代表可以握手，false代表拒绝
     * @param HttpInput $httpInput
     * @return bool
     */
    public function onWebSocketHandCheck(HttpInput $httpInput)
    {
        return true;
    }
    /**
     * ws开始连接
     * @param $server
     * @param $request
     */
    public function onSwooleWSOpen($server, $request)
    {
        //转发到控制器处理
        //$this->onSwooleWSAllMessage($server,$request->fd,'{"type":"connect"}');
    }
    public function onSwooleConnect($serv, $fd)
    {
        print_r("ok");

        parent::onSwooleConnect($serv, $fd); // TODO: Change the autogenerated stub

    }

    public function onSwooleReceive($serv, $fd, $from_id, $data, $server_port = null)
    {

        var_dump("onSwooleReceive:".$data);
        return parent::onSwooleReceive($serv, $fd, $from_id, $data, $server_port); // TODO: Change the autogenerated stub
    }


    /**
     * @return string
     */
    public function getCloseMethodName()
    {
        return 'onClose';
    }

    /**
     * @return string
     */
    public function getEventControllerName()
    {
        return 'Home/Status';
    }



    /**
     * @return string
     */
    public function getConnectMethodName()
    {
        return 'onConnect';
    }

}