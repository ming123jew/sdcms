<?php

namespace app\Controllers\Home;


use app\Models\BaseModel;
use app\Models\Business\HomeBusiness;
use app\Models\Task\CacheTask;
use app\Models\UserModel;
use app\Process\MyAMQPTaskProcess;
use app\Tasks\AppTask;
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Exception\AMQPException;
use PhpAmqpLib\Connection\AMQPQueue;
use PhpAmqpLib\Message\AMQPMessage;
use Server\Asyn\AMQP\AMQP;
use Server\Components\CatCache\CatCacheRpcProxy;
use Server\Components\Process\ProcessManager;

/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 17-09-14
 * Time: am09:51
 */
class Main extends Base
{
    /**
     * @var AppModel
     */
    public $BaseModel;
    protected $HomeBusiness;

    protected function initialization($controller_name, $method_name)
    {
        parent::initialization($controller_name, $method_name);

        //$this->Model['BaseModel'] = $this->loader->model(BaseModel::class, $this);
    }

    public function http_index(){

        $p = intval( $this->http_input->postGet('p') );
        if($p == 0) {$p = 1;}
        $end = 10;
        $start = ($p-1)*$end;

        $this->Model['HomeBusiness'] = $this->loader->model(HomeBusiness::class,$this);
        //[获取幻灯:start]
        $d_slide = yield $this->Model['HomeBusiness']->get_slide();
        //[获取幻灯:end]

        //[获取推荐:start]
        $d_get_recommend = yield $this->Model['HomeBusiness']->get_recommend();
        //[获取推荐:end]

        //[获取最新文章:start]
        $d_get_new = yield $this->Model['HomeBusiness']->get_new(0,$start,$end);
        //[获取最新文章:end]

        //[获取最新评论:start]
        $d_get_new_comment = yield $this->Model['HomeBusiness']->get_new_comment();
        //[获取最新评论:end]

        //print_r($d_get_new);
        //print_r($d_get_recommend);
        parent::templateData('d_slide',$d_slide);
        parent::templateData('d_get_recommend',$d_get_recommend);
        parent::templateData('d_get_new',$d_get_new['result']);
        parent::templateData('page_d_get_new',page_bar($d_get_new['num'],$p,10,5,$this));
        parent::templateData('d_get_new_comment',$d_get_new_comment);
        $date = date('Y-m-d');
        parent::templateData('date',$date.' '.get_week($date));
        unset($p,$end,$start,$d_slide,$d_get_recommend,$d_get_new,$d_get_new_comment,$date);
        //web or app
        parent::webOrApp(function (){
            $template = $this->loader->view('app::Home/index');
            $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
        });
    }

    public function http_about(){
        $this->Model['HomeBusiness'] = $this->loader->model(HomeBusiness::class,$this);
        $this->Data['d_get_recommend']  = yield $this->Model['HomeBusiness']->get_recommend();
        $this->Data['d_get_new_comment']  = yield $this->Model['HomeBusiness']->get_new_comment();
        parent::templateData('d_get_recommend',$this->Data['d_get_recommend']);
        parent::templateData('d_get_new_comment',$this->Data['d_get_new_comment']);
        $this->Data['date'] = date('Y-m-d');
        $this->Data['week'] = get_week($this->Data['date']);
        parent::templateData('date',$this->Data['date'].' '. $this->Data['week']);
        //web or app
        parent::webOrApp(function (){
            $template = $this->loader->view('app::Home/about');
            $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
        });
    }

    public function http_link(){
        $this->Model['HomeBusiness'] = $this->loader->model(HomeBusiness::class,$this);
        $this->Data['d_get_recommend']  = yield $this->Model['HomeBusiness']->get_recommend();
        $this->Data['d_get_new_comment']  = yield $this->Model['HomeBusiness']->get_new_comment();
        parent::templateData('d_get_recommend',$this->Data['d_get_recommend']);
        parent::templateData('d_get_new_comment',$this->Data['d_get_new_comment']);
        $this->Data['date'] = date('Y-m-d');
        $this->Data['week'] = get_week($this->Data['date']);
        parent::templateData('date',$this->Data['date'].' '. $this->Data['week']);
        //web or app
        parent::webOrApp(function (){
            $template = $this->loader->view('app::Home/link');
            $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
        });
    }

    public function http_hello(){

        $return = [
            '0'=>'hi.'
        ];
        parent::templateData('test',1);
        parent::httpOutputTis($return);
    }

    public function http_redis_set(){
        $r = yield $this->redis_pool->getCoroutine()->set('aa','aa');
        print_r($r);
        $this->http_output->end($r);
    }

    public function http_redis_get(){
        $r = yield $this->redis_pool->getCoroutine()->get('aa');
        $this->http_output->end($r);
    }

    /**
     * http测试
     */
    public function http_test()
    {
        /* $this->redis_pool->getCoroutine()->hMset('test',[1,2,3,4],function ($uids){});
         $redisCoroutine = $this->redis_pool->getCoroutine()->get('test');
         $redis_result = yield $redisCoroutine;*/

        $UserModel = $this->loader->model(UserModel::class,$this);
        $isExist = yield $UserModel->isExistUser('ming');

        $StatsModel = $this->loader->model(StatsModel::class,$this);
        $date = date('Ymd',time());
        $val = yield $StatsModel->updateOrInsert($date,'click');

        $redis_key ='RedisStatsModel_'.$date.':click_num';
        $click_num = yield $this->redis_pool->getCoroutine()->get($redis_key);

        $endData = [
            // 'reis_result'=>$redis_result,
            'BaseModel'=>$this->Model['BaseModel']->test(),
            'UserModel'=>$isExist,
            //'jsskd'=>self::_getJsSdk(),
            'StatsModel'=>$val,
            'RdeisClickNum'=>intval($click_num)
        ];


        $this->http_output->end($endData,false);
    }


    public function http_test_task()
    {
        $AppTask = $this->loader->task('AppTask');
        $AppTask->testTask();
        $AppTask->startTask(function ($serv, $task_id, $data) {
            $this->http_output->end($data,false);
        });
    }

    /**
     * mysql效率测试
     * 协程模式
     */
    public function http_smysql(){
        $result = yield $this->mysql_pool->dbQueryBuilder->select('*')->from('user')->limit(10)->coroutineSend();
        $this->http_output->end($result,false);
    }
    /**
     * mysql效率测试
     * 同步模式
     */
    public function http_amysql(){
        $result = get_instance()->getMysql()->select('*')
            ->from('user')
            ->limit(10)
            ->pdoQuery();
        $this->http_output->end($result,false);
    }

    /**
     * mysql效率测试
     * 异步回调模式
     */
    public function http_cmysql(){
        $this->mysql_pool->dbQueryBuilder->select('*')
            ->from('sd')
            ->limit(10);
        $this->mysql_pool->query(function ($result){
            $this->http_output->end($result,false);
        });

    }

    public function http_testSC1()
    {

        $result = yield set_cache('test1','ok',10);
        $this->http_output->end($result, false);
    }

    public function http_testSC2()
    {

        $result = yield get_cache('test1');
        $this->http_output->end($result, false);
    }

    public function http_testSC5()
    {
        $result = yield CatCacheRpcProxy::getRpc()->getAll();
        $this->http_output->end($result, false);
    }

    public function http_phpquery(){
        /**
         * 下面实现多线程采集文章信息
         */

        //$res = QueryList::get('https://github.com')->find('img')->attrs('src');

        $html = file_get_html('https://www.baidu.com');

        $this->http_output->end($html,false);

    }

    public function http_task(){
        $testTask = $this->loader->task( AppTask::class);
        $testTask->testTask();
        $testTask->startTask(null,function($serv, $task_id, $data){
            $this->http_output->end($data,false);
        });
    }


    protected $queueName = 'amqp-cache';
    protected $exchange = 'amqp-cache';
    protected $consumerTag = 'sys';

    public function http_process(){
        //投递一个信息到队列

        $amqt =  get_instance()->getAsynPool('AMQP');
        $channel = $amqt->channel();

        $msgBody = json_encode(["name" => "iGoo`1", "age" => 22]);
        $msg = new AMQPMessage($msgBody, ['content_type' => 'text/plain', 'delivery_mode' => 2]); //生成消息  //, ['content_type' => 'text/plain', 'delivery_mode' => 2]
        $r = $channel->basic_publish($msg,$this->exchange); //推送消息到某个交换机
        $channel->close();
        //print_r($r);
        $this->http_output->end($r,false);
    }


    public function http_test_sessions(){
        sessions($this,'ABC','fuck');
        $this->http_output->end("ok");
    }
    public function http_test_sessions2(){
        $session = (sessions($this,'ABC'));
        $this->http_output->end($session);
    }
}