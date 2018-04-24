<?php
/**
 * Created by PhpStorm.
 * User: zhangjincheng
 * Date: 17-9-7
 * Time: 上午10:35
 */

namespace app\AMQPTasks;

use PhpAmqpLib\Exception\AMQPBasicCancelException;
use PhpAmqpLib\Message\AMQPMessage;
use Server\Components\AMQPTaskSystem\AMQPTask;
use Server\Components\Process\ProcessManager;

//创建作业任务
class TestAMQPTask extends AMQPTask
{
    /**
     * @var TestModel
     */
    public $TestModel;

    public function initialization(AMQPMessage $message)
    {
        parent::initialization($message);
    }

    /**
     * 处理任务
     * handle
     * @param $body
     */
    public function handle($body)
    {
        //print_r('testaqptask-handle'.$body);
        //file_put_contents('/home/wwwroot/sdcms/a.txt',var_export($body,true), FILE_APPEND);
        //file_put_contents('/home/wwwroot/sdcms/c.txt','aa');
        var_dump($body);
        //echo get_instance()->workerId."\n";
        echo "work-over."."\n";
        $this->ack();
    }


}