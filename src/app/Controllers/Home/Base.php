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
     * @var string
     */
    public $HomeSessionField = '__SESSION__HOME__';//session

    /**
     * @var array
     */
    public $HomeNotAuthAction = ['login','tis'];

    /**
     * @var string
     */
    public $HomeUploadsConfig = '';

    /**
     * @var int
     */
    public $CookieExpire=3600*24;

    /**
     * @param string $controller_name
     * @param string $method_name
     * @throws \Exception
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
        unset($configs,$configs_config);
        self::check_login();
    }

    /**
     * 装置模板数据
     * @param $key
     * @param $value
     * @return array|void
     */
    protected function templateData($key,$value)
    {
        $arr = [$key=>$value];
        $this->TemplateData = array_merge($this->TemplateData,$arr);
        unset($arr,$key,$value);
    }


    /**
     * 判断是否登录
     * @return bool
     */
    protected function check_login(){
        $obj = new \stdClass();
        $obj->http_output = $this->http_output;
        $obj->http_input = $this->http_input;
        $s =  sessions($obj,$this->HomeSessionField);
        if($s!=null){
            parent::templateData('user.isLogin',true);
            parent::templateData('user.username',$s['username']);
            parent::templateData('user.email',$s['email']);
            unset($s);
            return true;
        }else{
            parent::templateData('user.isLogin',false);
            parent::templateData('user.username','');
            parent::templateData('user.email','');
            return false;
        }
    }

    /**
     * 返回登录用户SESSION信息
     * @return array | bool
     */
    protected function get_login_session(){
        $obj = new \stdClass();
        $obj->http_output = $this->http_output;
        $obj->http_input = $this->http_input;
        $s =  sessions($obj,$this->HomeSessionField);
        if($s){
            return $s;
        }else{
            unset($s);
            return false;
        }
    }

    /**
     * @desc 默认跳转方法
     */
    public function defaultMethod()
    {
        $this->redirectController('Home/Main','login');
    }


}