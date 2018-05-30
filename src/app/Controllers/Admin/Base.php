<?php

namespace app\Controllers\Admin;
use Server\Memory\Cache;
use app\Tasks\WebCache;
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 17-09-14
 * Time: am09:51
 */
class Base extends \app\Controllers\BaseController
{
    /**
     * @var int
     */
    protected $CookieExpire=3600*1;

    /**
     * @var string
     */
    public $HtmlUrl = '';
    protected $RolePrivModel='';
    protected $MenuModel = '';

    /**
     * @var string
     */
    protected $AdminSessionField = '__SESSION__ADMIN__';//session
    protected $AdminCacheRoleIdDataField = '__ROLEID__DATA__ADMIN__';//角色数据
    protected $AdminCacheRoleIdMenuField = '__ROLEID__MENU__ADMIN__';//角色菜单
    protected $AdminNotAuthAction = ['login','tis'];
    protected $AdminUploadsConfig = '';

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
        if(  strtolower($this->ModuleName) ==  'admin' ){
            $this->HtmlUrl = $configs_config[$configs_config['active']]['admin']['static_url'];
            $this->AdminUploadsConfig =  $configs_config[$configs_config['active']]['uploads'];
        }else{
            $this->HtmlUrl = $configs_config[$configs_config['active']]['home']['static_url'];
        }
        unset($configs,$configs_config);
        parent::templateData('HTML_URL',$this->HtmlUrl);

        //测试 绕过登录
        //$session_data['username'] = 'ming';
        //$session_data['id'] = 1;
        //$session_data['roleid'] = 1;
        //session($this->AdminSessionField,$session_data);

        //如未登录  && 不是admin/main/login  admin/main/tis 则跳转到登录
        if( !in_array(strtolower($this->ActionName),$this->AdminNotAuthAction) && !self::check_login() ){
            $this->redirectController('Admin/Main','login');
        }

        //检测权限
         self::check_priv();

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
     * @desc 默认跳转方法
     */
    public function defaultMethod()
    {
        $this->redirectController('Admin/Main','login',302);
    }

    /**
     * 权限判断
     */
     public function check_priv() {

         if( strtolower($this->ModuleName) =='admin' && strtolower($this->ControllerName)  =='main' && in_array(strtolower($this->ActionName), $this->AdminNotAuthAction)) return true;
         //if($_SESSION['roleid'] == 1) return true;
         //if(preg_match('/^public_/',ROUTE_A)) return true;
         //if(preg_match('/^ajax_([a-z]+)_/',ROUTE_A,$_match)) {
         //    $action = $_match[1];
         //}
         $login_session = self::get_login_session();
         $role_id = $login_session['roleid'];
         $user = $login_session['username'];
         unset($login_session);
         //1为超级管理员，直接跳过
         if($role_id == 1) return true;
         //搞不清楚为啥无法使用协程 无法放到initialization 使用
         //$this->RolePrivModel  = $this->loader->model('RolePrivModel',$this);
         //$r =$privdb->get_one(array('m'=>ROUTE_M,'c'=>ROUTE_C,'a'=>$action,'roleid'=>$_SESSION['roleid'],'siteid'=>$siteid));
         // $r =  yield $this->RolePrivModel->authRole($role_id,$this->ModuleName,$this->ControllerName,$this->ActionName);
         //var_dump($r);

         //数据库方式
         /********************* 可使用 ******************
         $this->RolePrivModel  = $this->loader->model('RolePrivModel',$this);
         $r =  get_instance()->getMysql()->select('*')//pdo注意服务器IP 127.0.0.1
             ->from($this->RolePrivModel->getTable())
             ->limit(1)
             ->where('role_id',$role_id)
             ->where('m',$this->ModuleName)
             ->where('c',$this->ControllerName)
             ->where('a',$this->ActionName)
             ->pdoQuery();

         if(!($r['result'])){
             parent::httpOutputTis('你没有权限操作，m：'.$this->ModuleName.'，c：'.$this->ControllerName.'，a：'.$this->ActionName.'。',false);
         }else{
             //print_r($r['result']);
         }
          *************/

         /**************使用内存模式******************/
         // 获取当前用户组拥有的权限
         //print_r("ok");
         $role_arr = unserialize(yield self::get_cache_role_data_byid($role_id));
         //print_r($role_arr);
         $can = false;
         if(is_array($role_arr)&&!empty($role_arr)){
             foreach ($role_arr as $key=>$value){
                 if($this->ModuleName==$value['m']&&$this->ControllerName==$value['c']&&$this->ActionName==$value['a']){
                     $can = true;
                 }else{
                     continue;
                 }
             }
         }
         unset($role_arr,$key,$value);
         if(!$can){
             //parent::httpOutputTis('你没有权限操作，m：'.$this->ModuleName.'，c：'.$this->ControllerName.'，a：'.$this->ActionName.'。',false);
             print_r('你没有权限操作，m：'.$this->ModuleName.'，c：'.$this->ControllerName.'，a：'.$this->ActionName.'。',false);
             $this->redirectController('Admin/Main','Tis');
         }

    }

    /**
     * 判断是否登录
     * @return bool
     */
    protected function check_login(){
        $obj = new \stdClass();
        $obj->http_output = $this->http_output;
        $obj->http_input = $this->http_input;
        $s =  sessions($obj,$this->AdminSessionField);
        if($s){
            parent::templateData('user.isLogin',true);
            parent::templateData('username',$s['username']);
            parent::templateData('user.email',$s['email']);
            unset($s);
            return true;
        }else{
            parent::templateData('user.isLogin',false);
            parent::templateData('username','');
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
        $s =  sessions($obj,$this->AdminSessionField);
        print_r($s);
        if($s){
            return $s;
        }else{
            unset($s);
            return false;
        }
    }

    /**
     * 根据role_id查找角色分配缓存 | 登录的时候创建此缓存  | 公用 暂时不考虑user_id
     * @param $role_id
     * @return mixed
     */
    protected function get_cache_role_data_byid($role_id){
        //$cache = Cache::getCache('WebCache');
        //return $cache->getOneMap($this->AdminCacheRoleIdDataField.$role_id);
        return yield get_cache($this->AdminCacheRoleIdDataField.$role_id);
    }

    /**
     * 根据role_id查找角色菜单缓存 | 登录的时候创建此缓存  | 公用 暂时不考虑user_id
     * @param $role_id
     * @return mixed
     */
    protected function get_cache_role_menu_byid($role_id){
        //$cache = Cache::getCache('WebCache');
        //return $cache->getOneMap($this->AdminCacheRoleIdMenuField.$role_id);
        return yield get_cache($this->AdminCacheRoleIdMenuField.$role_id);
    }

}