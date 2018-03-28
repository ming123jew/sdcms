<?php
namespace app\Tasks;

use Server\CoreBase\Task;

/**
 * Created by PhpStorm.
 * User: zhangjincheng
 * Date: 16-7-15
 * Time: 下午1:06
 */
class AppTask extends Task
{
    public function testTask()
    {
        print_r("1");
        return "test task\n";
    }
}