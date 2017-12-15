<?php

namespace app\Controllers\Home;


use app\Models\BaseModel;
use app\Models\UserModel;
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

    protected function initialization($controller_name, $method_name)
    {
        parent::initialization($controller_name, $method_name);
        $this->BaseModel = $this->loader->model('BaseModel', $this);

    }

    public function http_hello(){

        $return = [
            '0'=>'hi.'
        ];
        $this->http_output->end($return,false);
    }

    /**
     * http测试
     */
    public function http_test()
    {
        /* $this->redis_pool->getCoroutine()->hMset('test',[1,2,3,4],function ($uids){});
         $redisCoroutine = $this->redis_pool->getCoroutine()->get('test');
         $redis_result = yield $redisCoroutine;*/

        $UserModel = $this->loader->model('UserModel',$this);
        $isExist = yield $UserModel->isExistUser('ming');

        $StatsModel = $this->loader->model('StatsModel',$this);
        $date = date('Ymd',time());
        $val = yield $StatsModel->updateOrInsert($date,'click');

        $redis_key ='RedisStatsModel_'.$date.':click_num';
        $click_num = yield $this->redis_pool->getCoroutine()->get($redis_key);

        $endData = [
            // 'reis_result'=>$redis_result,
            'BaseModel'=>$this->BaseModel->test(),
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


}