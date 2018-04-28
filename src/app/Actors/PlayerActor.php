<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-4-28
 * Time: 10:36
 */

namespace app\Actors;


use app\GameException;
use Server\Components\Event\EventDispatcher;
use Server\CoreBase\Actor;
use Server\CoreBase\ChildProxy;

class PlayerActor extends Actor
{
    /**
     * 初始化储存用户信息
     * @param $user_info
     */
    public function initData($user_info){

        $this->saveContext['info'] = $user_info;

    }
    public function registStatusHandle($key, $value){}

}
?>