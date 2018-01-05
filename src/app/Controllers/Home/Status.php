<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2017-12-28
 * Time: 14:55
 */
namespace app\Controllers\Home;

use Server\Memory\Cache;
use app\Tasks\WsCache;

class Status extends Base
{
    protected function initialization($controller_name, $method_name)
    {
        parent::initialization($controller_name, $method_name);
    }

    public function http_index(){

        parent::templateData('test',1);

        //初始化页面  清除缓存
        $cache = Cache::getCache('WsCache');
        $key = 'get_log';
        $cache->addMap($key,md5(1));
        //web or app
        parent::webOrApp(function (){
            $template = $this->loader->view('app::Home/status');
            $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
        });
    }

    public function http_cache(){
        $cache = Cache::getCache('WsCache');
        $this->http_output->end($cache->getOneMap('get_log'));
    }


    public function connect()
    {
        $uid = time();
        $this->bindUid($uid);
        $this->send(['type' => 'welcome', 'id' => $uid,'fd'=>$this->fd]);
    }

    /**
     * ws获取日志信息
     */
    public function getlog()
    {

        //print_r($this->client_data);
        $start_time = microtime(true);
        $log_file = LOG_DIR . '/swoole.log';
        $message = self::tail($log_file,$this->client_data->num ?? 1000);
        //var_dump($message);
        $cache = Cache::getCache('WsCache');
        $key = 'get_log';
        $md5 = $cache->getOneMap($key);
        if($md5 == md5( json_encode($message) )){
            //md5相同，说明没有内容更新
            $end = ['type' => 'getlog','fd'=>$this->fd,'message'=>null];
        }else{
            //md5不同，说明内容更新了，返回给前台
            $cache->addMap($key,md5(json_encode($message)));
            $end = ['type' => 'getlog','fd'=>$this->fd,'message'=>$message];
        }
        //$end = ['type' => 'getlog','fd'=>$this->fd,'message'=>($message)];
        $this->send($end);
    }
    public function update()
    {
        $this->sendToAll(
            [
                'type' => 'update',
                'id' => $this->uid,
                'angle' => $this->client_data->angle + 0,
                'momentum' => $this->client_data->momentum + 0,
                'x' => $this->client_data->x + 0,
                'y' => $this->client_data->y + 0,
                'life' => 1,
                'name' => isset($this->client_data->name) ? $this->client_data->name : 'Guest.' . $this->uid,
                'authorized' => false,
            ]);
    }
    public function message()
    {
        $this->sendToAll(
            [
                'type' => 'message',
                'id' => $this->uid,
                'message' => $this->client_data->message,
            ]
        );
    }
    public function onClose()
    {
        $this->destroy();
    }
    public function onConnect()
    {
        $this->destroy();
    }

    /**
     * 给[]加粗
     * @param $string
     * @return string
     */
    protected function addbold($string){

        $string = str_replace(array('[',']'),array('<b>[',']</b>'),$string);
        //给[error]加红色
        $string = str_replace(array('<b>[ERROR]</b>'),array('<b style="color:#b53636;">[ERROR]</b>'),$string);

        //给[时间]加分隔
        $patten = "/^\d{4}[\-](0?[1-9]|1[012])[\-](0?[1-9]|[12][0-9]|3[01])(\s+(0?[0-9]|1[0-9]|2[0-3])\:(0?[0-9]|[1-5][0-9])\:(0?[0-9]|[1-5][0-9]))?$/";//未实现

        return  $string ;
    }

    /**
     * 获取大文件最后N行方法原理：首先通过fseek找到文件的最后一位EOF，然后找最后一行的起始位置，取这一行的数据，
     * 再找次一行的起始位置， 再取这一行的位置，依次类推，直到找到了$num行。
     * @param $file
     * @param $num
     * @return array
     */
    protected function tail($file,$num){
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
            array_unshift($lines,self::addbold(fgets($fp)));
            if($head){ break; }                 //这一句，只能放上一句后，因为到文件头后，把第一行读取出来再跳出整个循环
            $eof = "";
            $num--;
        }
        fclose($fp);
        return $lines;
    }

}