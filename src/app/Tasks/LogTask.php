<?php
namespace app\Tasks;

use Server\CoreBase\Task;

/**
 * Created by PhpStorm.
 * User: zhangjincheng
 * Date: 16-7-15
 * Time: 下午1:06
 */
class LogTask extends Task
{
    public function CutLog()
    {
        $config = get_instance()->config;
        print_r($config['server']['set']['log_file']);
        return "test task\n";
    }
}