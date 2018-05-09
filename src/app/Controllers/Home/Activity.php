<?php
namespace app\Controllers\Home;
/**
 * 活动实现
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-5-9
 * Time: 16:22
 */
class Activity extends Base{

    public function initialization($controller_name, $method_name)
    {
        parent::initialization($controller_name, $method_name); // TODO: Change the autogenerated stub
    }


    //秒杀方案
    public function http_seckill(){

        $this->Data['uid'] = $this->http_input->getPost('uid');

        //获取redis同时链接
        $this->Data['activeCount'] =  yield $this->redis_pool->getRedisPool()->getClientCount();

        if($this->Data['activeCount']>10){
            $this->Data['message'] = '服务器开小差.';

        }else{
            $this->Data['uid'] = $this->http_input->getPost('uid');
            $this->Data['execute_data'] = ['name'=>'llen', 'saleinfo-go'];
            //秒人人数限制
            $saleCount = intval( yield $this->redis_pool->getCoroutine()->lLen('ms-queue') );
            if ($saleCount < 10) {
                //用户锁，有效时间为3600秒，预计3600秒抢完，防止重复，当然可以使用其他方法代替，记录日志
                $this->Data['userlock'] = yield $this->redis_pool->getCoroutine()->set('userlock-'.$this->Data['uid'],$this->Data['uid'],'NX','EX',3600);
                if($this->Data['userlock']){
                    //压入中奖队列
                    yield $this->redis_pool->getCoroutine()->rpush('ms-queue',$this->Data['uid']);
                    print_r("\nyes\n");
                }else{
                    print_r("\nno\n");
                }

            }else{
                $this->Data['message'] = '秒杀结束';
            }

            $this->Data['users'] = yield $this->redis_pool->getCoroutine()->lRange('ms-queue',0,10);
            foreach ( $this->Data['users'] as $key=>$value){
                if($value == $this->Data['uid']){
                    $this->Data['message'] = $this->Data['uid'].'成功秒杀.';
                }
            }
        }
        $this->http_output->end($this->Data);

    }

    public function http_clear(){
        yield $this->redis_pool->getCoroutine()->del('ms-queue');
        yield $this->redis_pool->getCoroutine()->del('userlock-*');
        $this->Data['message'] = 'clear all.';
        $this->http_output->end($this->Data);
    }
}