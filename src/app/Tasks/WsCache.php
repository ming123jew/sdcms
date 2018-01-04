<?php
namespace app\Tasks;
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-1-4
 * Time: 15:17
 */
use \Server\CoreBase\Task;
class WsCache extends Task
{
    public $map = [];

    public function addMap($key,$value)
    {
        $this->map[$key] = $value;
        return true;
    }

    public function getOneMap($key){
        if(isset($this->map[$key])){
            return $this->map[$key];
        }else{
            return null;
        }

    }

    public function getAllMap()
    {
        return $this->map;
    }
}