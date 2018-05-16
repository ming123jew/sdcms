<?php
/**
 * Created by PhpStorm.
 * User: zhangjincheng
 * Date: 16-7-15
 * Time: 下午1:44
 */

namespace app\Models\Data;

class ImGroupModel extends BaseModel
{

    /**
     * 数据库表名称，不包含前缀
     * @var string
     */
    private $table = 'im_group';

    public function getTable(){
        return $this->prefix.$this->table;
    }

    /**
     * 根据UID获取所有数据
     * @return bool
     */
    public function getAllByUid(int $uid){
        $r = yield $this->mysql_pool->dbQueryBuilder->from($this->prefix.$this->table)
            ->orderBy('id','asc')
            ->where('uid',$uid)
            ->select('*')
            ->coroutineSend();
        if(empty($r['result'])){
            return false;
        }else{
            return $r['result'] ;
        }
    }

    /**
     * 获取所有数据
     * @return bool
     */
    public function getAll(){
        $r = yield $this->mysql_pool->dbQueryBuilder->from($this->prefix.$this->table)
            ->orderBy('id','asc')
            ->select('*')
            ->coroutineSend();
        if(empty($r['result'])){
            return false;
        }else{
            return $r['result'] ;
        }
    }

    /**
     * 后台列表
     * @param int $start
     * @param int $end
     * @return bool
     */
    public function getAllByPage(int $start,int $end=10){

        $m = $this->loader->model(ContentHitsModel::class,$this);
        $r = yield $this->mysql_pool->dbQueryBuilder->from($this->prefix.$this->table)
            ->orderBy('id','desc')
            ->select('*')
            ->limit("{$start},{$end}")
            ->coroutineSend();
        //嵌入总记录
        $count_arr = yield $this->mysql_pool->dbQueryBuilder->coroutineSend(null,"select count(0) as num from {$this->getTable()}");
        $count = $count_arr['result'][0]['num'];
        if($count>$end){
            $r['num'] =$count;
        }else{
            $r['num'] = $end;
        }

        if(empty($r['result'])){
            return false;
        }else{
            return $r ;
        }
    }

    /**
     * @param int $id
     * @param string $fields
     * @return bool
     */
    public function getById(int $id,$fields='*')
    {
        $r = yield $this->mysql_pool->dbQueryBuilder->from($this->prefix.$this->table)
            ->where('id',$id)
            ->select($fields)
            ->coroutineSend();
        if(empty($r['result'])){
            return false;
        }else{
            return $r['result'][0];
        }
    }


    /**
     * @param $id
     * @return bool
     */
    public function deleteById(int $id,$transaction_id=null){
        $r = yield $this->mysql_pool->dbQueryBuilder->from($this->prefix.$this->table)
            ->where('id',$id)->delete()->coroutineSend($transaction_id);
        //print_r($r);
        if(empty($r['result'])){
            return false;
        }else{
            return $r['result'] ;
        }
    }

    /**
     * 插入多条数据
     * @param array $intoColumns
     * @param array $intoValues
     * @param null $transaction_id
     * @return bool
     */
    public function insertMultiple( array $intoColumns,array $intoValues ,$transaction_id=null){
        //原生sql执行
//        $sql = 'INSERT INTO '.$this->prefix.$this->table.'(role_id,m,c,a,menu_id) VALUES';
//        foreach ($arr as $key=>$value){
//            $sql .= '("'.$value[0].'","'.$value[1].'","'.$value[2].'","'.$value[3].'","'.$value[4].'"),';
//        }
//        $sql = substr($sql,0,-1);
//        $r = yield $this->mysql_pool->dbQueryBuilder->coroutineSend(null, $sql);
        $r = yield $this->mysql_pool->dbQueryBuilder->insertInto($this->prefix.$this->table)
            ->intoColumns($intoColumns)
            ->intoValues($intoValues)
            ->coroutineSend($transaction_id);
        //print_r($r);
        if(empty($r['result'])){
            return false;
        }else{
            return $r ;//插入返回所有结果集
        }
    }

    /**
     * 根据ID更新单条
     * @param int $id
     * @param array $columns_values
     * @param null $transaction_id
     * @return bool
     */
    public function updateById(int $id,array $columns_values,$transaction_id=null){
        $r = yield $this->mysql_pool->dbQueryBuilder->update($this->prefix.$this->table)
            ->set($columns_values)
            ->where('id',$id)
            ->coroutineSend($transaction_id);
        //print_r($r);
        if(empty($r['result'])){
            return false;
        }else{
            return $r['result'] ;
        }
    }


}