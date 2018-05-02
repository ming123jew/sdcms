<?php
namespace app\Tasks;
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-1-4
 * Time: 15:17
 */
use \Server\CoreBase\Task;
class WebCache extends Task
{
    public $map = [];

    /**
     * 写入缓存
     * @param $key
     * @param $value
     * @param int $expire
     * @return bool
     */
    public function addMap($key,$value,$expire=24*3600)
    {
        $this->map[$key]['create_time'] = time();
        $this->map[$key]['expire_time'] = $expire;
        $this->map[$key] = $value;
        return true;
    }

    public function getOneMap($key){

        if(isset($this->map[$key])){
            //判断是否过期
            if( time() - $this->map[$key]['create_time'] > $this->map[$key]['expire_time'] ){
               self::destroy();
            }else{
                return $this->map[$key];
            }
        }else{
            return false;
        }

    }

    public function getAllMap()
    {
        return $this->map;
    }

    public function destroy(){
        unset($this->map);
    }
}