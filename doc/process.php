<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/7
 * Time: 21:48
 */
//$worker_num = 8;
//
//for($i = 0; $i < $worker_num; $i++)
//{
//    $process = new swoole_process('callback_function', $redirect_stdout);
//    $pid = $process->start();
//    $workers[$pid] = $process;
//}
//
//function callback_function(swoole_process $worker)
//{
//    //echo "Worker: start. PID=".$worker->pid."\n";
//    //recv data from master
//    $recv = $worker->read();
//    echo "From Master: $recv\n";
//
//    //send data to master
//    $worker->write("hello master\n");
//
//    sleep(2);
//    $worker->exit(0);
//}

$a = 5;
$b = function ($x) use (&$a) {
    $a += $x;        echo $a;
};
$b(3);
echo $a;