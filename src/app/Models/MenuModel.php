<?php
/**
 * Created by PhpStorm.
 * User: zhangjincheng
 * Date: 16-7-15
 * Time: 下午1:44
 */

namespace app\Models;


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
    public function getAll(){
        $val = yield $this->mysql_pool->dbQueryBuilder->select('*')
            ->from($this->prefix.$this->table)
            ->orderBy('list_order','asc')
            ->orderBy('id','asc')
            ->coroutineSend();
        if(empty($val['result'])){
            return false;
        }else{
            return $val;
        }
    }




}