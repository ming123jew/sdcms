<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2017-12-28
 * Time: 14:55
 */
namespace app\Controllers\Home;

use app\Process\MyProcess;
use Server\Components\Event\EventDispatcher;
use Server\Components\Process\ProcessManager;
use Server\Memory\Cache;
use app\Controllers\BaseController;


class Status extends BaseController{
    protected function initialization($controller_name, $method_name)
    {
        parent::initialization($controller_name, $method_name);
        $configs = get_instance()->config;
        $configs_config = $configs['config'];
        //print_r($configs_config);
        //print_r($this->ControllerName);
        //print_r($this->MethodName);
        $this->HtmlUrl = $configs_config[$configs_config['active']]['home']['static_url'];

        parent::templateData('HTML_URL',$this->HtmlUrl);
        unset($configs,$configs_config);
    }

    public function http_index(){

        //初始化页面  清除缓存
        $cache = Cache::getCache('WsCache');
        $key = 'get_log';
        $cache->addMap($key,md5(1));
        unset($key,$cache);
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

    public function http_test(){
        $role_id = $this->http_input->get('id');
        $cache = Cache::getCache('WebCache');
        $this->http_output->end(unserialize($cache->getOneMap('__ROLE_ID__ADMIN__'.$role_id)));
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
//        //version1
//        //print_r($this->client_data);
//        $start_time = microtime(true);
//        $log_file = LOG_DIR . '/swoole.log';
//        $message = self::tail($log_file,$this->client_data->num ?? 300);
//        //var_dump($message);
        //version2
        //延迟100毫秒秒执行异步，防止预先执行
        $fd = $this->fd;
        \swoole_timer_after(100, function ()use($fd ){
            //异步读取
            $log_file = LOG_DIR . '/SERVER-'.date('Y-m-d',time()).'.log';
            $log_file = LOG_DIR . '/swoole.log';
            $file_size = 0;
            $file_size = filesize($log_file);
            if($file_size>5000){
                $file_size = $file_size - 2000;
            }else{
                $file_size = 0;
            }

            \swoole_async_read($log_file, function ($f,$c)use($fd){
                //print_r($fd);
                EventDispatcher::getInstance()->dispatch('unlock'.$fd, $c);
            },8192,$file_size);
        });
        EventDispatcher::getInstance()->removeAll('unlock'.$this->fd);
        $message = yield EventDispatcher::getInstance()
            ->addOnceCoroutine('unlock'.$this->fd)
            ->setTimeout(99999999)
            ->noException('timeout.');
        $message = self::addbold($message);
        $end = ['type' => 'getlog','fd'=>$this->fd,'message'=>$message,'strlen'=>strlen($message)];
        //echo "\n".md5( json_encode($message) )."\n";

        unset($log_file,$message,$cache,$key,$md5,$file_name);
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
        var_dump('close');
       // $this->destroy();
    }
    public function onConnect()
    {
        var_dump('connect');
        //var_dump($this->client_data);

       // $p = new LenJsonPack();
        //$this->send($p->pack('tcp connect'));
        //$this->send('avc');
        //$this->destroy();
    }



    public function onReceive(){
        var_dump($this->client_data);
        //$this->send('avc2');
    }

    public function onPacket(){
        var_dump($this->client_data);
        //$this->send('avc3');
    }



    /**
     * 给[]加粗
     * @param $string
     * @return string
     */
    protected function addbold($string){
        $string = str_replace(array("\t","\n"),array('&nbsp;','<br />'),$string);
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
        unset($fp,$pos,$eof,$head,$num);
        return $lines;
    }

    protected function tail2(){
        $log_file = LOG_DIR . '/SERVER-'.date('Y-m-d',time()).'.log';
        $file_size = 0;
        $file_size = filesize($log_file);
        if($file_size>5000){
            $file_size = $file_size - 2000;
        }else{
            $file_size = 0;
        }
        \swoole_async_read($log_file, function ($f,$c){
            EventDispatcher::getInstance()->dispatch('unlock', $c);
        },8192,$file_size);
    }

    public function http_tail2(){
        $log_file = LOG_DIR . '/SERVER-'.date('Y-m-d',time()).'.log';
        $file_size = 0;
        $file_size = filesize($log_file);
        if($file_size>5000){
            $file_size = $file_size - 2000;
        }else{
            $file_size = 0;
        }

         \swoole_async_read($log_file, function ($f,$c){
             EventDispatcher::getInstance()->dispatch('unlock', $c);
         },8192,$file_size);
        $data = yield EventDispatcher::getInstance()->addOnceCoroutine('unlock')->setTimeout(1000);
        $this->http_output->end($data);

    }

    protected function di($context){

        $context->http_output->end(['fuck']);
    }

    public function http_tail3(){

        $this->http_output->end(yield get_cache('aaa'));
    }


    public function sendAll($data)
    {
        $this->sendToAll($data);
    }
    public function pub($sub, $data)
    {
        $this->sendPub($sub, $data);
    }
    public function sub($sub)
    {
        $this->bindUid($this->fd);
        $this->addSub($sub);
        $this->send("ok.$this->fd");
    }

    public function testTcp(){
        //$this->send("yes");
    }

    public function http_test2(){
        $version    = 1;
        $result     = 0;
        $command_id = 1001;
        $username   = "陈一回";
        $password   = md5("123456");
        // 构造包体
        $bin_body   = pack("a30a32", $username, $password);
        // 包体长度
        $body_len   = strlen($bin_body);
        $bin_head   = pack("nCns", $body_len, $version, $command_id, $result);
        $bin_data   = $bin_head . $bin_body;

        //echo $bin_data;


        file_put_contents( '/home/a.txt', $this->pack("6578616d706c65206865782064617461"));

        $data = yield ProcessManager::getInstance()->getRpcCall(MyProcess::class)->getData();
        $result = yield ProcessManager::getInstance()->getRpcCallWorker(0)->getPoolStatus();
        print_r(get_instance()->getWorkerId());
        //var_dump($result);
        $this->http_output->end($data);
    }

    public function encode($buffer)
    {
        //|版本|设备|指令|数据|
        //| 0 |1 ~ 7|8|9~9+n|
        //获取长度
        $length = strlen($buffer) - 9;
        //制作校验码
        $check = '';
        //|起始|长度|版本|设备|指令|数据|校验
        //| 0 | 1 | 2 |3 ~ 9|10|11~11+n|11+n+1~11+n+3|
        return hex2bin('f0') . pack('c', $length).$buffer . $check;
    }

// 封装协议体
    public function pack($data, $topic = null)
    {
        return   $this->encode(hex2bin($data));
    }

}