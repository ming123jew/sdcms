<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-4-17
 * Time: 11:13
 */

//定义一个事件触发抽象类。
abstract class EventGenerator
{
    private $observers = [];
    function addObserver(Observer $observer)
    {
        $this->observers[] = $observer;
    }
    function notify()
    {
        foreach ($this->observers as $observer)
        {
            $observer->update();
        }

    }
}