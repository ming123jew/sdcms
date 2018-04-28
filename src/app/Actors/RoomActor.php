<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-4-28
 * Time: 10:34
 */

namespace app\Actors;
use app\GameException;
use Server\Components\Event\EventDispatcher;
use Server\CoreBase\Actor;
use Server\CoreBase\ChildProxy;

class RoomActor extends Actor
{
    /**
     * 初始化储存房间信息
     * @param $room_info
     */
    public function initData($room_info){

        $this->saveContext['info'] = $room_info;

    }

    /**
     * 进房询问
     * @param $user_info
     */
    public function joinRoomReply($user_info){
        //代码下文有详细介绍
    }

    public function registStatusHandle($key, $value){}
}
?>