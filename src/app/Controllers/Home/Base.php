<?php
namespace app\Controllers\Home;

/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 17-09-14
 * Time: am09:51
 */
class Base extends \app\Controllers\BaseController
{
    /**
     * @var string
     */
    public $HtmlUrl = '';


    /**
     * @param string $controller_name
     * @param string $method_name
     */
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
    }

    /**
     * @desc 装置模板数据
     * @param $key
     * @param $value
     * @return array
     */
    protected function templateData($key,$value)
    {
        $arr = [$key=>$value];
        $this->TemplateData = array_merge($this->TemplateData,$arr);
    }

    /**
     * @desc 默认跳转方法
     */
    public function defaultMethod()
    {
        $this->redirectController('Home/Main','login');
    }



}