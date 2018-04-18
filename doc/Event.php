<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-4-17
 * Time: 11:18
 */
//一个实现了EventGenerator抽象类的类，用于具体定义某个发生的事件
class Event extends EventGenerator
{
    function triger()
    {
        echo "Event\n";
    }
}

//Event触发triger，观测者1需要更新某操作
class Observer1 implements Observer{
    function update(){
        echo "逻辑1\n";
    }
}

//Event触发triger，观测者2需要更新某操作
class Observer2 implements Observer{
    function update(){
        echo "逻辑2\n";
    }
}

