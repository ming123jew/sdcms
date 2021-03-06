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
            //小于10个则有机会
            if ($saleCount < 10) {
                //用户锁，有效时间为3600秒，预计3600秒抢完，防止重复，当然可以使用其他方法代替，记录日志
                $this->Data['userlocks'] = yield $this->redis_pool->getCoroutine()->set('userlock-'.$this->Data['uid'],$this->Data['uid'],'NX','EX',3600);
                if($this->Data['userlocks']){
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

            //查看所有用户锁
            $this->Data['userlocks'] = yield $this->redis_pool->getCoroutine()->keys('userlock*');

        }
        $this->http_output->end($this->Data);
    }

    public function http_clear(){
        yield $this->redis_pool->getCoroutine()->del('ms-queue');
        $this->Data['userlocks'] = yield $this->redis_pool->getCoroutine()->keys('userlock*');
        foreach ($this->Data['userlocks'] as $key=>$value){
            yield $this->redis_pool->getCoroutine()->del($value);
        }

        $this->Data['message'] = 'clear all.';
        $this->http_output->end($this->Data);
    }

    public function http_test(){


       yield lock("redis",function (){
            //echo "get lock...";
            $this->http_output->end("fuck");
        },function (){
            $this->http_output->end("fail");
        });

    }

    /**
     * @desc  随机返回语句，每一句概率为14.3%
     */
    private function _returnSentences(){
        //用session加1的方式，暂不使用
        /*
         * 奖项数组
         * 是一个二维数组，记录了所有本次抽奖的奖项信息，
         * 其中id表示中奖等级，prize表示奖品，v表示中奖概率。
         * 注意其中的v必须为整数，你可以将对应的 奖项的v设置成0，即意味着该奖项抽中的几率是0，
         * 数组中v的总和（基数），基数越大越能体现概率的准确性。
         * 本例中v的总和为100，那么平板电脑对应的 中奖概率就是1%，
         * 如果v的总和是10000，那中奖概率就是万分之一了。
         *
         */

        $prize_arr = array(
            '0' => array('id'=>1,'prize'=>'result1','v'=>1,'s'=>1),
            '1' => array('id'=>2,'prize'=>'result2','v'=>1,'s'=>1),
            '2' => array('id'=>3,'prize'=>'result3','v'=>1,'s'=>1),
            '3' => array('id'=>4,'prize'=>'result4','v'=>1,'s'=>1),
            '4' => array('id'=>5,'prize'=>'result5','v'=>1,'s'=>1)
        );

        //库存量 s
        /*
            $stock_arr = array(
            '0' => array('id'=>1,'prize'=>'result1','s'=>1),
            '1' => array('id'=>2,'prize'=>'result2','s'=>1),
            '2' => array('id'=>3,'prize'=>'result3','s'=>1),
            '3' => array('id'=>4,'prize'=>'result4','s'=>1),
            '4' => array('id'=>5,'prize'=>'result5','s'=>1)
        );*/
        $stock_arr = $prize_arr;

        /*
         * 每次前端页面的请求，PHP循环奖项设置数组，
         * 通过概率计算函数get_rand获取抽中的奖项id。
         * 将中奖奖品保存在数组$res['yes']中，
         * 而剩下的未中奖的信息保存在$res['no']中，
         * 最后输出json个数数据给前端页面。
         */
        foreach ($prize_arr as $key => $val) {
            $arr[$val['id']] = $val['v'];
        }
        $rid = self::_get_rand($arr); //根据概率获取奖项id

        //得到rid，进行对比库存，是否还有货，无货则直接返回不中
        $rid_stock = self::_select_stock($rid,$stock_arr);
        //$rid_stock为false，则说明库存无货
        if($rid_stock===false){
            $res['yes'] = "不中奖"; //中奖项
            shuffle($prize_arr); //打乱数组顺序
            for($i=0;$i<count($prize_arr);$i++){
                $pr[] = $prize_arr[$i]['prize'];
            }
            $res['no'] = $pr;
            //print_r($res);
        }else{
            $res['yes'] = $prize_arr[$rid-1]['prize']; //中奖项
            $res['yes_rid'] = $prize_arr[$rid-1]['id']; //中奖项
            unset($prize_arr[$rid-1]); //将中奖项从数组中剔除，剩下未中奖项
            shuffle($prize_arr); //打乱数组顺序
            for($i=0;$i<count($prize_arr);$i++){
                $pr[] = $prize_arr[$i]['prize'];
            }
            $res['no'] = $pr;
            //print_r($res);
        }

        return $res;
    }

    /*
       * 经典的概率算法，
       * $proArr是一个预先设置的数组，
       * 假设数组为：array(100,200,300，400)，
       * 开始是从1,1000 这个概率范围内筛选第一个数是否在他的出现概率范围之内，
       * 如果不在，则将概率空间，也就是k的值减去刚刚的那个数字的概率空间，
       * 在本例当中就是减去100，也就是说第二个数是在1，900这个范围内筛选的。
       * 这样 筛选到最终，总会有一个数满足要求。
       * 就相当于去一个箱子里摸东西，
       * 第一个不是，第二个不是，第三个还不是，那最后一个一定是。
       * 这个算法简单，而且效率非常 高，
       * 关键是这个算法已在我们以前的项目中有应用，尤其是大数据量的项目中效率非常棒。
       */
    private function _get_rand($proArr) {
        $result = '';
        //概率数组的总概率精度
        $proSum = array_sum($proArr);
        //echo $proSum;
        //概率数组循环
        foreach ($proArr as $key => $proCur) {
            $randNum = mt_rand(1, $proSum);
            if ($randNum <= $proCur) {
                $result = $key;
                break;
            } else {
                $proSum -= $proCur;
            }
        }
        unset ($proArr);
        return $result;
    }

    /**
     * @desc  查询库存是否还有货
     * @param $rid  rid = 1 默认为不中奖项(注意数据库需对应id为1是不中奖)
     * @param $stockArr
     * @return bool
     */
    private function _select_stock($rid,$stockArr){
        $now_rid_stock = 0;
        foreach ($stockArr as $key=>$value){
            //如果是设置的ID，返回对应的库存量
            if($rid==$value['id']){
                $now_rid_stock = $value['s'];
            }
        }

        //rid 1 默认为不中奖项
        if($now_rid_stock>0 && $rid!=1){
            //mysql.....
            //如果库存大于0，并可在此进行锁定礼物操作
            //此处不使用model，为了保证事务一致
            //启用事务
            DB::startTrans();
            try{
                //锁定对应的礼物
                $data = [
                    'uid'=>$this->uid,
                    'status'=>1
                ];
                $map = [
                    'uid'=>0,//版本信息
                    'status'=>0,//版本信息
                    'pid'=>$rid,//版本信息
                ];
                Db::name('taibao_fsbaby_prize_info')->limit(1)->where($map)->update($data);
                //更新库存量
                $data_taibao_fsbaby_prize = [
                    's' => ['exp','s-1'],
                    'update_time'=>time()
                ];
                $map_taibao_fsbaby_prize = [
                    'id'=>$rid
                ];
                Db::name('taibao_fsbaby_prize')->where($map_taibao_fsbaby_prize)->update($data_taibao_fsbaby_prize);
                // 提交事务
                Db::commit();
                return true;
            }catch (\Exception $e){
                print_r($e->getMessage());
                // 回滚事务
                Db::rollback();
                return false;
            }

        }else{
            return false;
        }
        return false;
    }



}