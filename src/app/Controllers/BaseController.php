<?php

namespace app\Controllers;

use Server\CoreBase\Controller;

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

    public $ControllerName = '';
    public static $ControllerName2 = '';
    public $MethodName = '';
    public static $MethodName2 = '';

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
     * @param string $controller_name
     * @param string $method_name
     */
    protected function initialization($controller_name, $method_name)
    {
        parent::initialization($controller_name, $method_name);
        $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
        $host =  $http_type .( $this->http_input->header('host') ).'/';
        //print_r($this->context);
        self::$Host2 = $this->Host = $host;
        $this->Url = str_replace(':http_','/',$method_name);
        $this->Url = $host.str_replace('\\','/', $this->Url);
        $this->Uri = $host.$this->http_input->getRequestUri();
        $this->ControllerName = str_replace('\\','/',$controller_name);
        self::$ControllerName2 = $this->ControllerName;
        $this->MethodName =  str_replace('http_','',$method_name);
        self::$MethodName2 = $this->MethodName;
        $this->IsApp = $this->http_input->postGet('is_app')=='yes'??null;
        self::templateData('__URI__',$this->Uri);
        self::templateData('__URL__',$this->Url);
        self::templateData('__HOST__',$this->Host);
        self::templateData('__C__',$this->ControllerName);
        self::templateData('__M__',$this->MethodName);


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

    //入口可以设置IP限制操作，如1秒内同一个IP访问超出N次，将其IP放进禁止访问列表

}