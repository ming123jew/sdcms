<?php
/**
 * Created by PhpStorm.
 * User: zhangjincheng
 * Date: 16-7-15
 * Time: 下午1:44
 */

namespace app\Models;


class CategoryModel extends BaseModel
{

    /**
     * 数据库表名称，不包含前缀
     * @var string
     */
    private $table = 'category';


    public function getTable(){
        return $this->prefix.$this->table;
    }

    /**
     * 获取所有菜单
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
     * @param int $role_id
     * @return bool
     */
    public function getByRoleId(int $role_id,$fields='*'){
        $r = yield $this->mysql_pool->dbQueryBuilder->from($this->prefix.$this->table)
            ->where('role_id',$role_id)
            ->select($fields)
            ->coroutineSend();
        if(empty($r['result'])){
            return false;
        }else{
            return $r['result'] ;
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
     * @param array $arr
     * @return bool
     */
    public function insertMultiple( array $intoColumns,array $intoValues,$transaction_id=null){
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
            return $r['result'] ;
        }
    }


    /**
     * 用于验证权限
     * @param int $role_id
     * @param string $m
     * @param string $c
     * @param string $a
     * @param string $fields
     * @return bool
     */
    public function authRole(int $role_id,string $m,string $c,string $a,string $fields='*'){
        $r = yield $this->mysql_pool->dbQueryBuilder->from($this->prefix.$this->table)
            ->where('role_id',$role_id)
            ->where('m',$m)
            ->where('c',$c)
            ->where('a',$a)
            ->select($fields)
            ->coroutineSend();
        if(empty($r['result'])){
            return false;
        }else{
            return $r['result'][0] ;
        }
    }

    /**
     * 自增
     * @return bool
     */
    public function setInc(int $catid, string $field, int $num=1,$transaction_id=null){
        $sql = 'update '.$this->prefix.$this->table.' set '.$field.'='.$field.'+'.$num.' where id='.$catid;
        $r = yield $this->mysql_pool->dbQueryBuilder->coroutineSend($transaction_id,$sql);

        if(empty($r['result'])){
            return false;
        }else{
            return ($r['result']);
        }
    }

    /**
     * 自减
     * @return bool
     */
    public function setDec(int $catid, string $field, int $num=1,$transaction_id=null){
        $sql = 'update '.$this->prefix.$this->table.' set '.$field.'='.$field.'-'.$num.' where id='.$catid;
        $r = yield $this->mysql_pool->dbQueryBuilder->coroutineSend($transaction_id,$sql);

        if(empty($r['result'])){
            return false;
        }else{
            return ($r['result']);
        }
    }

}