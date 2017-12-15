<?php

namespace app\Controllers\Admin;
use app\Models\UserModel;
use Server\Memory\Cache;

/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 17-09-14
 * Time: am09:51
 */
class Main extends Base
{
    /**
     * @var UserModel
     */
    protected $UserModel;
    protected $CookieExpire=10;

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
        if( !in_array($method_name,['http_login']) && !self::has_login() ){
            $this->redirectController($controller_name,'login');
        }
    }

    /**
     * 后台首页 | 兼容所有端
     * PC/WAP 使用到VIEW，其他端只在POST操作返回结果
     */
    public function http_index(){

        if($this->http_input->getRequestMethod()=='POST'){
            $end = [];
            $this->http_output->end(json_encode($end),false);
        }else{
            $template = $this->loader->view('app::Admin/index');
            parent::templateData('test',1);
            $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
        }
    }

    /**
     * 登录 | 兼容所有端
     * PC/WAP 使用到VIEW，其他端只在POST操作返回结果
     * @return view | json
     */
    public function http_login(){

        if($this->http_input->getRequestMethod()=='POST'){

            $this->UserModel = $this->loader->model('UserModel',$this);
            $result = yield $this->UserModel->getOneUserByUsernameAndPassword($this->http_input->post('username'),$this->http_input->post('password'));

            //验证失败
            if(empty($result['result'])){
                $end = [
                    'status' => 0,
                    'code'=>200,
                    'message'=>'info'
                ];
            }else{
                if($result['result'][0]){
                    unset($result['result'][0]['password']);
                    $session_data = $result['result'][0];
                    session($this->AdminSessionField,$session_data);
                    $cookie_data = md5($session_data);
                    $this->http_output->setCookie($this->AdminSessionField,$cookie_data,$this->CookieExpire);
                    $end = [
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
            $template = $this->loader->view('app::Admin/login');
            parent::templateData('test',1);
            $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
            //$this->http_output->end($endData,false);
        }

    }

    public function http_config(){

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
     * 判断是否登录
     * @return bool
     */
    protected function has_login(){
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
    protected function return_login_session(){
        $s =   session($this->AdminSessionField);
        if($s){
            return $s;
        }else{
            return false;
        }
    }



    /**
     * 销毁操作
     */
    public function destroy()
    {


    }


}