<?php
/**
 * Created by PhpStorm.
 * User: zhangjincheng
 * Date: 16-7-15
 * Time: 下午1:44
 */

namespace app\Models\Data;


class MenuModel extends BaseModel
{

    /**
     * 数据库表名称，不包含前缀
     * @var string
     */
    private $table = 'admin_menu';

    /**
     * 获取所有菜单
     * @return bool
     */
    public function getAll($status=''){
        if(is_numeric($status)){
            $val = yield $this->mysql_pool->dbQueryBuilder->select('*')
                ->from($this->prefix.$this->table)
                ->where('status',$status)
                ->orderBy('list_order','asc')
                ->orderBy('id','asc')
                ->coroutineSend();
        }else{
            $val = yield $this->mysql_pool->dbQueryBuilder->select('*')
                ->from($this->prefix.$this->table)
                ->orderBy('list_order','asc')
                ->orderBy('id','asc')
                ->coroutineSend();
        }

        if(empty($val['result'])){
            return false;
        }else{
            return $val['result'];
        }
    }

    /**
     * 根据ID查找一条
     * @param int $id
     * @param string $fields
     * @return bool
     */
    public function getOneById(int $id,$fields='*'){
        $r = yield $this->mysql_pool->dbQueryBuilder->from($this->prefix.$this->table)
            ->where('id',$id)
            ->select($fields)
            ->coroutineSend();
        if(empty($r['result'])){
            return false;
        }else{
            //返回一条
            return $r['result'][0] ;
        }
    }

    /**
     * 批量插入
     * @param array $intoColumns
     * @param array $intoValues
     * @return bool
     */
    public function insertMultiple( array $intoColumns,array $intoValues ){

        $r = yield $this->mysql_pool->dbQueryBuilder->insertInto($this->prefix.$this->table)
            ->intoColumns($intoColumns)
            ->intoValues($intoValues)
            ->coroutineSend();
        //print_r($r);
        if(empty($r['result'])){
            return false;
        }else{
            return $r['result'] ;
        }
    }

    /**
     * 根据ID更新单条
     * @param array $intoColumns
     * @param array $intoValues
     * @return bool
     */
    public function updateById(int $id,array $columns_values){
        $r = yield $this->mysql_pool->dbQueryBuilder->update($this->prefix.$this->table)
            ->set($columns_values)
            ->where('id',$id)
            ->coroutineSend();
        //print_r($r);
        if(empty($r['result'])){
            return false;
        }else{
            return $r['result'] ;
        }
    }

    /**
     * @param array $values
     * @return bool
     */
    public function delete(array $values){
        $r = yield $this->mysql_pool->dbQueryBuilder->from($this->prefix.$this->table)
            ->whereIn('id',$values)
            ->delete()
            ->coroutineSend();
        //print_r($r);
        if(empty($r['result'])){
            return false;
        }else{
            return $r['result'] ;
        }
    }


}