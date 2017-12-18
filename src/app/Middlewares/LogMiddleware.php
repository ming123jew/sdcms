<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2017-12-18
 * Time: 11:10
 */
namespace app\Middlewares;

use Server\Components\Middleware\Middleware;

class LogMiddleware extends Middleware{

    protected $start_run_time;
    protected static $web_debug_enable;

    public function __construct()
    {
        parent::__construct();
        if (LogMiddleware::$web_debug_enable == null) {
            LogMiddleware::$web_debug_enable = $this->config['config'][$this->config['config']['active']]['web_debug_enable'];
        }
    }

    public function before_handle()
    {
        $this->start_run_time = microtime(true);
    }

    public function after_handle($path)
    {

        $log_file = LOG_DIR . '/swoole.log';
        //$log = self::tail($log_file,50);
        //print_r($log);
    }

    /*
     * 获取大文件最后N行方法
     * 原理：
     * 首先通过fseek找到文件的最后一位EOF，然后找最后一行的起始位置，取这一行的数据，再找次一行的起始位置， 再取这一行的位置，依次类推，直到找到了$num行。
      */
    public function tail($file,$num){
        $fp = fopen($file,"r");
        $pos = -2;
        $eof = "";
        $head = false;   //当总行数小于Num时，判断是否到第一行了
        $lines = array();
        while($num>0){
            while($eof != "\n"){
                if(fseek($fp, $pos, SEEK_END)==0){    //fseek成功返回0，失败返回-1
                    $eof = fgetc($fp);
                    $pos--;
                }else{                               //当到达第一行，行首时，设置$pos失败
                    fseek($fp,0,SEEK_SET);
                    $head = true;                   //到达文件头部，开关打开
                    break;
                }

            }
            array_unshift($lines,fgets($fp));
            if($head){ break; }                 //这一句，只能放上一句后，因为到文件头后，把第一行读取出来再跳出整个循环
            $eof = "";
            $num--;
        }
        fclose($fp);
        return $lines;
    }

}