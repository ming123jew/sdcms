<?php

namespace app\Controllers\Admin;
use app\Helpers\Tree;
use app\Models\Data\UserModel;
use app\Models\Data\RolePrivModel;
use app\Models\Data\MenuModel;
use Server\Components\CatCache\CatCacheRpcProxy;
use Server\Memory\Cache;
use app\Tasks\WebCache;

/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 17-09-14
 * Time: am09:51
 * Module: 登录 | 修改当前用户信息 | 网站基本信息
 */
class Main extends Base
{
    /**
     * @var UserModel
     */
    protected $UserModel;

    /**
     * @var int
     */
    protected $CookieExpire=10;

    /**
     * @var
     */
    protected $MenuModel;

    /**
     * @var
     */
    protected $RolePrivModel;

    /**
     * @param string $controller_name
     * @param string $method_name
     * @throws \Exception
     */
    protected function initialization($controller_name, $method_name)
    {
        parent::initialization($controller_name, $method_name);
    }

    /**
     * 后台首页 | 兼容所有端
     * PC/WAP 使用到VIEW，其他端只在is_app=yes操作返回结果
     */
    public function http_index(){

        parent::templateData('test',1);

        //web or app
        parent::webOrApp(function (){
            $template = $this->loader->view('app::Admin/index');
            $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
        });
    }

    /**
     * ajax获取角色菜单
     */
    public function http_ajaxgetmenu(){
        $login_session = self::get_login_session();
        $role_id = $login_session['roleid'];
        $all = unserialize(parent::get_cache_role_menu_byid($role_id));
        //缓存不存在，则进行数据库读取
        if(!$all){
            $all = yield self::_getRoleMenu($role_id);
            print_r('not cache.');
        }

        $end = [
            'status' => 1,
            'code'=>200,
            'message'=>'login fail.',
            'data'=>$all
        ];
        $this->http_output->setHeader('Content-Type','application/json');
        $this->http_output->end(json_encode($end),false);
        //print_r($all);
    }


    /**
     * 登录 | 兼容所有端
     * PC/WAP 使用到VIEW，其他端只在POST操作返回结果
     * @return view | json
     */
    public function http_login(){

        if($this->http_input->getRequestMethod()=='POST'){

            $this->UserModel = $this->loader->model(UserModel::class,$this);
            $result = yield $this->UserModel->getOneUserByUsernameAndPassword($this->http_input->post('username'),$this->http_input->post('password'));
            print_r($result);
            //验证失败
            if(empty($result)){
                $end = [
                    'status' => 0,
                    'code'=>200,
                    'message'=>'用户名或密码错误。'
                ];
            }else{

                if($result){
                    //储存到SESSION - memory
                    unset($result['password']);
                    $session_data = $result;
                    session($this->AdminSessionField,$session_data);//print_r($session_data);
                    $cookie_data = md5(implode('-',$session_data));
                    //echo $cookie_data;exit(0);
                    $this->http_output->setCookie($this->AdminSessionField,$cookie_data,$this->CookieExpire);

                    //查询权限，并存到Cache
                    $role_id = $session_data['roleid'];
                    $this->RolePrivModel = $this->loader->model(RolePrivModel::class,$this);
                    $d_model_rolepriv = yield  $this->RolePrivModel->getByRoleId($role_id);
                    //cache存在并发内存泄漏,不再使用
                    //$cache = Cache::getCache('WebCache');
                   // $cache->addMap($this->AdminCacheRoleIdDataField.$role_id,serialize($d_model_rolepriv));
                    yield set_cache($this->AdminCacheRoleIdDataField.$role_id,serialize($d_model_rolepriv));

                    //获取角色菜单，并存到cache
                    $role_menu = yield self::_getRoleMenu($role_id);
                    //$cache->addMap($this->AdminCacheRoleIdMenuField.$role_id,serialize($role_menu));
                    yield set_cache($this->AdminCacheRoleIdMenuField.$role_id,serialize($role_menu));

                    $end = [
                        'token'=>$cookie_data,
                        'status' => 1,
                        'code'=>200,
                        'message'=>'login success.'
                    ];
                }else{
                    $end = [
                        'status' => 0,
                        'code'=>200,
                        'message'=>'login fail.'
                    ];
                }

            }

            $this->http_output->end(json_encode($end),false);

        }else{
            parent::templateData('test',1);
            //web or app
            parent::webOrApp(function (){
                $template = $this->loader->view('app::Admin/login');
                $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
            });
        }

    }

    /**
     * 退出登录
     */
    public function http_logout(){
        //销毁session
        session($this->AdminSessionField,null);
        $this->http_output->setCookie($this->AdminSessionField,'');
        parent::templateData('title','成功退出登录.');
        parent::templateData('message','成功退出登录.');
        parent::templateData('gourl',url('Admin','Main','index'));
        parent::webOrApp(function (){
            $template = $this->loader->view('app::Admin/logout');
            $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
        });
        // 清除缓存数据
    }

    public function http_tis(){
//        $r =  get_instance()->getMysql()->select('*')
//            ->from('sd_admin_role_priv')
//            ->limit(10)
//            ->pdoQuery();
//
//        print_r($r);
        parent::httpOutputTis('你没有权限操作.',false);
    }

    public function http_login2(){
        $cache = Cache::getCache('TestCache');
        $a = session($this->AdminSessionField);
        $b = session('wo');
        $end = [
            'a'=>$a,
            'b'=>$b
        ];

        $this->http_output->end($end,false);
    }

    /**
     * 获取角色菜单
     * @return mixed
     */
    private function _getRoleMenu($role_id){

        $this->MenuModel  = $this->loader->model(MenuModel::class,$this);
        $all = yield $this->MenuModel->getAll($role_id);

        //处理数据添加url属性
        foreach ($all as $key=>$value){

            if($value['a']=='#'){
                $all[$key]['url'] = 'javascript:;';
            }else{
                $all[$key]['url'] = url($value['m'],$value['c'],$value['a'],$value['url_param']);
            }
        }
        //获取子级菜单
        $tree = new Tree();
        $tree->init($all);
        $subset = [];
        foreach ($all as $key2=>$value2){
            $subset = $tree->get_child($value2['id']);
            if($subset){
                $all[$key2]['subset'] = array_values($subset);
            }else{
                $all[$key2]['subset'] = $subset;
            }

        }
        return $all;
    }
    /**
     * 销毁操作
     */
    public function destroy()
    {


    }


}