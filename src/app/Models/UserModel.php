<?php
/**
 * Created by PhpStorm.
 * User: zhangjincheng
 * Date: 16-7-15
 * Time: 下午1:44
 */

namespace app\Models;


class UserModel extends BaseModel
{

    /**
     * 数据库表名称，不包含前缀
     * @var string
     */
    private $table = 'user';

    /**
     * @param $data
     * @return bool | array
     */
    public function addUser($data){
        $val = yield $this->mysql_pool->dbQueryBuilder
            ->insert($this->prefix.$this->table)
            ->set('username',$data['username'])
            ->set('password',$data[password])
            ->set('email',$data['email'])
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
        return $val;
    }


}