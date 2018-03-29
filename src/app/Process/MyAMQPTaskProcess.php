<?php
/**
 * Created by PhpStorm.
 * User: zhangjincheng
 * Date: 17-9-15
 * Time: 下午2:28
 */

namespace app\Process;


use app\AMQPTasks\TestAMQPTask;
use PhpAmqpLib\Message\AMQPMessage;
use Server\Components\AMQPTaskSystem\AMQPTaskProcess;
//创建异步作业进程
class MyAMQPTaskProcess extends AMQPTaskProcess
{
    protected $queueName = 'amqp-cache';
    protected $exchange = 'amqp-cache';
    protected $consumerTag = 'sys';

    public function start($process)
    {
        parent::start($process);
        $this->createDirectConsume($this->queueName,2,false,$this->exchange,$this->consumerTag);
    }

    /**
     * 创建完全匹配队列名称的消费者
     * @param $queue{队列名称}
     * @param int $prefetch_count
     * @param bool $global
     * @param null $exchange{指定交换机}
     * @param null $consumerTag{消费者标签}
     */
    public function createDirectConsume($queue, $prefetch_count = 2, $global = false, $exchange = null, $consumerTag = null)
    {
        if ($exchange == null) {
            $exchange = create_uuid('route');
        }
        if ($consumerTag == null) {
            $consumerTag = create_uuid('consumer');
        }
        //passive:被动的 durable:持久  exclusive:专用的 auto_delete:自动删除
        $this->channel->queue_declare($queue, false, true, false, false);
        $this->channel->exchange_declare($exchange, 'direct', false, true, false);
        $this->channel->queue_bind($queue, $exchange);
        //$this->channel->basic_qos(0, $prefetch_count, $global);
        $this->channel->basic_consume($queue, $consumerTag, false, false, false, false, [$this, 'process_message']);
    }

    /**
     * 路由消息返回class名称
     * @param $body
     * @return string
     */
    protected function route($body)
    {
        //print_r($body);
        return TestAMQPTask::class;
    }



    protected function onShutDown()
    {
        // TODO: Implement onShutDown() method.
    }
}