<?php

namespace app\Controllers;

use Server\CoreBase\Controller;
use Server\SwooleMarco;

/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 17-09-14
 * Time: am09:51
 */
class BaseController extends Controller
{
    /**
     * 静态根URL
     * @var string
     */
    public $HtmlUrl = '';

    /**
     * @desc 模板公共输出函数
     * @var array
     */
    public $TemplateData = [];

    /**
     * 访问主机
     * @var string
     */
    public $Host = '';
    public static $Host2 = '';
    public  $HostIP = '';

    /**
     * @description 根链接
     * @var string
     */
    public $Url = '';

    /**
     * @description 全链接
     * @var string
     */
    public $Uri = '';

    public $ModuleName = '';
    public static $ModuleName2 = '';
    public $ControllerName = '';
    public static $ControllerName2 = '';//用于默认function url()默认控制器
    public $ActionName = '';
    public static $ActionName2 = '';//用于默认function url()默认方法

    /**
     * @var array
     */
    public $Params = [];

    /**
     * @description 判断是不是APP端
     * @var null
     */
    public $IsApp = null;

    /**
     * 装置所有model
     * @var
     */
    protected $Model;

    /**
     * 装置所有数据
     * @var
     */
    protected $Data;

    /**
     * @param string $controller_name
     * @param string $method_name
     * @throws \Exception
     */
    protected function initialization($controller_name, $method_name)
    {
        if ($this->request_type==SwooleMarco::TCP_REQUEST){
            parent::initialization($controller_name, $method_name);
        }else{
            parent::initialization($controller_name, $method_name);
            $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
            $host =  $http_type .( $this->http_input->header('host') ).'/';
            if(strpos($host,':')!==false){
                $host_domain_arr = explode(':',$this->http_input->header('host'));
                $host_domain = $host_domain_arr[0];
            }else{
                $host_domain = $host;
            }
            $this->HostIP = $host_domain;
            //print_r($this->context);
            self::$Host2 = $this->Host = $host;
            $this->Url = str_replace(':http_','/',$method_name);
            $this->Url = $host.str_replace('\\','/', $this->Url);
            $this->Uri = substr($host,0,-1).$this->http_input->getRequestUri();
            $arr_controller_name = explode('/',str_replace('\\','/',$controller_name));// admin/main 拆分
            //print_r($arr_controller_name);
            $this->ModuleName = $arr_controller_name[0];
            self::$ModuleName2 = $this->ModuleName;
            $this->ControllerName = $arr_controller_name[1];
            self::$ControllerName2 = $this->ControllerName;
            $this->ActionName =  str_replace('http_','',$method_name);
            self::$ActionName2 = $this->ActionName;
            $this->IsApp = $this->http_input->postGet('is_app')=='yes'??null;
            self::templateData('__URI__',$this->Uri);
            self::templateData('__URL__',$this->Url);
            self::templateData('__HOST__',$this->Host);
            self::templateData('HOST_IP', $this->HostIP);
            self::templateData('__M__',$this->ModuleName);
            self::templateData('__C__',$this->ControllerName);
            self::templateData('__A__',$this->ActionName);
        }



//$this->response->header('Access-Control-Allow-Origin', '*');
    }

    /**
     * @desc 装置模板数据
     * @param $key
     * @param $value
     * @return array
     */
    protected function templateData($key,$value){
        $arr = [$key=>$value];
        $this->TemplateData = array_merge($this->TemplateData,$arr);
        unset($arr,$key,$value);
    }

    protected function resetTempateData(){
        $this->TemplateData = [];
        self::templateData('__URI__',$this->Uri);
        self::templateData('__URL__',$this->Url);
        self::templateData('__HOST__',$this->Host);
        self::templateData('HOST_IP', $this->HostIP);
        self::templateData('__M__',$this->ModuleName);
        self::templateData('__C__',$this->ControllerName);
        self::templateData('__A__',$this->ActionName);
    }

    protected function test(){
        $v = yield $this->redis_pool->getCoroutine()->set('a','aaaa');
        print_r($v);
        print_r('test_test');

    }

    /**
     * @description 判断是否是app/wap端，如是返回json数据，不是则执行闭包操作。
     * @param $callback
     */
    protected function webOrApp($callback){
        if($this->IsApp){
            $end = ['data'=>$this->TemplateData];
            $this->http_output->end(json_encode($end),false);
        }else{
            call_user_func($callback);
        }
    }

    /**
     * 简化返回结果
     * @param $success_message      //成功返回前端的提示信息
     * @param $fail_message      //失败返回前端的提示信息
     * @param $result               //结果集
     * @param string $end           //自定义数组  | 如
     * @param bool $gzip            //gzip
     */
    protected function httpOutputEnd($success_message,$fail_message,$result,$end=[],$gzip=false){

        if($end){

        }else{
            if($result){
                $end = [
                    'status' => 1,
                    'code'=>200,
                    'message'=> $success_message
                ];
            }else{
                $end = [
                    'status' => 0,
                    'code'=>200,
                    'message'=>$fail_message
                ];
            }
        }

        $jsonp = $this->http_input->postGet('jsonpcallback');//get接收jsonp自动生成的函数名
        if($jsonp)
        {
            unset($success_message,$fail_message,$result);
            $this->http_output->setHeader('Content-Type','application/json');
            $this->http_output->end($jsonp.'(' .json_encode($end).')',$gzip);
        }else{
            unset($success_message,$fail_message,$result,$jsonp);
            $this->http_output->setHeader('Content-Type','application/json');
            $this->http_output->end(json_encode($end),$gzip);
        }

    }

    /**
     * 返回提示信息，如参数不对，或其他中途请求参数不足导致提示
     * @param $message
     * @param bool $gzip
     */
    protected function httpOutputTis($message,$json_encode=true,$gzip=false){
        $end = [
            'status' => 0,
            'code'=>200,
            'message'=> $message
        ];
        $this->http_output->setHeader('Content-Type','application/json');
        if($json_encode){
            unset($message,$json,$json_encode);
            $this->http_output->end(json_encode($end),$gzip);
        }else{
            unset($message,$json,$json_encode);
            $this->http_output->end(($end),$gzip);
        }
    }

    //入口可以设置IP限制操作，如1秒内同一个IP访问超出N次，将其IP放进禁止访问列表

    public function destroy()
    {
        parent::destroy(); // TODO: Change the autogenerated stub
        $this->Model = null;
        $this->Data = null;
        self::resetTempateData();
        //print_r("end");
    }

}