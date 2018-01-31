<?php

namespace app\Controllers\Admin;

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
    protected $RolePrivModel='';

    /**
     * @var string
     */
    protected $AdminSessionField = '__SESSION__ADMIN__';
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
        if(  strtolower($this->ModuleName) ==  'admin' ){
            $this->HtmlUrl = $configs_config[$configs_config['active']]['admin']['static_url'];
        }else{
            $this->HtmlUrl = $configs_config[$configs_config['active']]['home']['static_url'];
        }
        parent::templateData('HTML_URL',$this->HtmlUrl);

        //测试 绕过登录
        $session_data['username'] = 'ming';
        $session_data['id'] = 1;
        $session_data['roleid'] = 1;
        session($this->AdminSessionField,$session_data);

        if( !in_array($method_name,['http_login','http_tis']) && !self::check_login() ){
            $this->redirectController('Admin/Main','login');
        }

        //检测权限
         self::check_priv();
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
        $this->redirectController('Admin','Main','login');
    }

    /**
     * 权限判断
     */
     public function check_priv() {
         print_r("ok");
         if( strtolower($this->ModuleName) =='admin' && strtolower($this->ControllerName)  =='main' && in_array(strtolower($this->ActionName), array('login','tis'))) return true;
         //if($_SESSION['roleid'] == 1) return true;
         //if(preg_match('/^public_/',ROUTE_A)) return true;
         //if(preg_match('/^ajax_([a-z]+)_/',ROUTE_A,$_match)) {
         //    $action = $_match[1];
         //}
         $login_session = self::get_login_session();
         $role_id = $login_session['roleid'];
         //搞不清楚为啥无法使用协程
         //$this->RolePrivModel  = $this->loader->model('RolePrivModel',$this);
         //$r =$privdb->get_one(array('m'=>ROUTE_M,'c'=>ROUTE_C,'a'=>$action,'roleid'=>$_SESSION['roleid'],'siteid'=>$siteid));
         // $r =  yield $this->RolePrivModel->authRole($role_id,$this->ModuleName,$this->ControllerName,$this->ActionName);
         //var_dump($r);
         $this->RolePrivModel  = $this->loader->model('RolePrivModel',$this);
         $r =  get_instance()->getMysql()->select('*')//pdo注意服务器IP 127.0.0.1
             ->from($this->RolePrivModel->getTable())
             ->limit(10)
             ->where('role_id',$role_id)
             ->where('m',$this->ModuleName)
             ->where('c',$this->ControllerName)
             ->where('a',$this->ActionName)
             ->pdoQuery();

         if(!($r['result'])){
             parent::httpOutputTis('你没有权限操作，m：'.$this->ModuleName.'，c：'.$this->ControllerName.'，a：'.$this->ActionName.'。',false);
         }else{
             print_r($r['result']);
         }

    }

    /**
     * 判断是否登录
     * @return bool
     */
    protected function check_login(){
        $s =  session($this->AdminSessionField);
        if($s){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 返回登录用户SESSION信息
     * @return array | bool
     */
    protected function get_login_session(){
        $s =   session($this->AdminSessionField);
        if($s){
            return $s;
        }else{
            return false;
        }
    }

}