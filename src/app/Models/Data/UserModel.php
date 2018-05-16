<?php
/**
 * Created by PhpStorm.
 * User: zhangjincheng
 * Date: 16-7-15
 * Time: 下午1:44
 */

namespace app\Models\Data;


class UserModel extends BaseModel
{

    /**
     * 数据库表名称，不包含前缀
     * @var string
     */
    private $table = 'user';

    public function getTable(){
        return $this->prefix.$this->table;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function getById(int $id){
        $val = yield $this->mysql_pool->dbQueryBuilder->from($this->prefix.$this->table)
            ->where('id',$id)
            ->orderBy('id','desc')
            ->select('*')
            ->coroutineSend();
        if(empty($val['result'])){
            return false;
        }else{
            return $val['result'][0] ;
        }
    }

    /**
     * 获取所有
     * @return bool
     */
    public function getAll(){
        $val = yield $this->mysql_pool->dbQueryBuilder->from($this->prefix.$this->table)
            ->orderBy('id','desc')
            ->select('*')
            ->coroutineSend();
        if(empty($val['result'])){
            return false;
        }else{
            return $val['result'] ;
        }
    }

    /**
     * @param $data
     * @return bool | array
     */
    public function addUser($data){
        $val = yield $this->mysql_pool->dbQueryBuilder
            ->insert($this->prefix.$this->table)
            ->set('username',$data['username'])
            ->set('password',$data['password'])
            ->set('email',$data['email'])
            ->set('regtime',time())
            ->coroutineSend();
        if(empty($val['result'])){
            return false;
        }else{
            return $val;
        }
    }

    /**
     * @param $username
     * @return bool | array
     */
    public function isExistUser($username){
        $val = yield $this->mysql_pool->dbQueryBuilder->select('*')
            ->from($this->prefix.$this->table)
            ->where('username',$username)
            ->limit(1)
            ->coroutineSend();
        if(empty($val['result'])){
            return false;
        }else{
            return $val;
        }
    }

    /**
     * @param $username
     * @param $password
     * @return mixed
     */
    public function getOneUserByUsernameAndPassword($username,$password){
        $val = yield $this->mysql_pool->dbQueryBuilder->select('*')
            ->from($this->prefix.$this->table)
            ->where('username',$username)
            ->where('password',$password)
            ->limit(1)
            ->coroutineSend();
        if(empty($val['result'])){
            return false;
        }else{
            return $val['result'][0];
        }

    }
}