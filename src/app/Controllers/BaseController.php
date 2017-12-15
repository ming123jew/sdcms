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

    /**
     * 根链接
     * @var string
     */
    public $Url = '';

    /**
     * 全链接
     * @var string
     */
    public $Uri = '';

    public $ControllerName = '';
    public $MethodName = '';

    /**
     * @var array
     */
    public $Params = [];

    /**
     * @param string $controller_name
     * @param string $method_name
     */
    protected function initialization($controller_name, $method_name)
    {
        parent::initialization($controller_name, $method_name);
        $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
        $host =  $http_type .($this->http_input->header('host')).'/';
        $this->Host = $host;
        $this->Url = str_replace(':http_','/',$method_name);
        $this->Url = $host.str_replace('\\','/', $this->Url);
        $this->Uri = $host.$this->http_input->getRequestUri();
        $this->ControllerName = str_replace('\\','/',$controller_name);
        $this->MethodName = $method_name;
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

    //入口可以设置IP限制操作，如1秒内同一个IP访问超出N次，将其IP放进禁止访问列表

}