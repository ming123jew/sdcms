<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-4-12
 * Time: 15:23
 */

namespace app\Controllers\Home;


use app\Controllers\Home\Interfaces\IUserService;
use app\Helpers\Sessions\Session;
use app\Models\Data\UserModel;
use Server\CoreBase\ChildProxy;

class User extends Base
{

    protected function initialization($controller_name, $method_name)
    {
        parent::initialization($controller_name, $method_name);
    }

    /**
     * 登录 
     */
    public function http_login()
    {

        if($this->http_input->getRequestMethod()=='POST'){
            $family = new IUserServiceFamily();
            //权限装饰器
            $family->addDecorator(  new Check() );
            //积分装饰器 - 预留
            $family->addDecorator(  new Score() );
            //before操作，由于控制器必须使用浏览器访问controllor才能正常调用end()..因此此处使用结果数组进行返回，如结果数组包含错误则直接返回第一个错误。
            $tis='';
            yield $family->before($this);
            $result =  ($family->getBeforeResult());
            foreach ($result as $key=>$value){
                if($value&&$value['status']==0){$tis = $value['message'];}
            }
            if($tis){
                unset($family,$result,$key,$value);
                parent::httpOutputTis($tis);
            }else{
                //调用数据访问层
                //....//print_r("\nmiddle\n");
                //after操作，由于控制器必须使用浏览器访问controllor才能正常调用http_output->end()..因此此处使用结果数组进行返回，如结果数组包含错误则直接返回第一个错误。
                $tis='';
                yield $family->after($this);
                $result =  ($family->getAfterResult());
                foreach ($result as $key=>$value){
                    if($value&&$value['status']==0){$tis = $value['message'];}
                }
                if($tis){
                    unset($family,$result,$key,$value);
                    parent::httpOutputTis($tis);
                }else{
                    unset($family,$result,$key,$value);
                    parent::httpOutputEnd('登录成功.','登录失败.',true);
                }
            }
        }else{
            parent::webOrApp(function (){//web or app
                $template = $this->loader->view('app::Home/login');
                $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
            });
        }

    }

    /**
     * 注册
     */
    public function http_register(){
        if($this->http_input->getRequestMethod()=='POST'){
            $family = new IUserServiceFamily();
            //注册装饰器
            $family->addDecorator(  new Register() );
            //注册成功前
            $tis='';
            yield $family->before($this);
            $result =  ($family->getBeforeResult());
            foreach ($result as $key=>$value){
                if($value&&$value['status']==0){$tis = $value['message'];}
            }
            if($tis){
                unset($family,$result,$key,$value);
                parent::httpOutputTis($tis);
            }else{
                //注册成功后
                $tis='';
                yield $family->after($this);
                $result =  ($family->getAfterResult());
                foreach ($result as $key=>$value){
                    if($value&&$value['status']==0){$tis = $value['message'];}
                }
                if($tis){
                    unset($family,$result,$key,$value);
                    parent::httpOutputTis($tis);
                }else{
                    unset($family,$result,$key,$value);
                    parent::httpOutputEnd('注册成功.','注册失败.',true);
                }
            }
        }else{
            parent::webOrApp(function (){//web or app
                $template = $this->loader->view('app::Home/register');
                $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
            });
        }
    }

    /**
     * 退出登录
     */
    public function http_logout(){
        //销毁session
        sessions($this,$this->HomeSessionField,null);
        parent::templateData('title','成功退出登录.');
        parent::templateData('message','成功退出登录.');
        parent::templateData('gourl',$this->Host);
        parent::webOrApp(function (){
            $template = $this->loader->view('app::Home/logout');
            $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
        });
        // 清除缓存数据
    }
}



//检查权限
class Check implements IUserService {
    protected $UserModel;
    /**
     * 登录前
     * @param $context
     * @return mixed
     */
    public function before($context)
    {
        $result = [];
        // TODO: Implement before() method.
        $username = ($context->http_input->postGet('username'));
        $password = ($context->http_input->postGet('password'));
        if(empty($username)){
            $result = ['status'=>0,'message'=>'用户名不能为空.'];
        }else if(empty($password)){
            $result = ['status'=>0,'message'=>'用户密码不能为空.'];
        }else{
            //进行验证
            $this->UserModel = $context->loader->model(UserModel::class,$context);
            $result = yield $this->UserModel->getOneUserByUsernameAndPassword($username,$password);
            if($result){
                unset($result['password']);
                $result = array_merge($result,['status'=>1,'message'=>'验证成功.']);
                //写入session
                $session_data = $result;
                sessions($context,$context->HomeSessionField,$session_data);//print_r($session_data);

            }else{
                $result = ['status'=>0,'message'=>'用户名/密码错误.'];
            }
        }
        //检查用户名
        return $result;
    }

    /**
     * 登录后
     * @param $context
     * @return mixed
     */
    public function after($context)
    {
        // TODO: Implement after() method.
    }
}

// 用户积分
class Score implements IUserService {
    /**
     * 登录前
     * @param $context
     * @return mixed
     */
    public function before($context)
    {
        // TODO: Implement before() method.
    }

    /**
     * 登录后
     * @param $context
     * @return mixed
     */
    public function after($context)
    {
        // TODO: Implement after() method.
        $result = ['status'=>1,'message'=>'用户积分.'];
        return $result;

    }
}

//注册
class Register implements IUserService{
    protected $UserModel;
    public function before($context)
    {
        // TODO: Implement before() method.
        $username = ($context->http_input->postGet('username'));
        $password = ($context->http_input->postGet('password'));
        $email = ($context->http_input->postGet('email'));
        $checkmail="/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/";//定义正则表达式
        if(empty($username)){
            $result = ['status'=>0,'message'=>'请输入用户名.'];
        }else if(empty($password)||strlen($password)<6){
            $result = ['status'=>0,'message'=>'请输入六位以上的密码.'];
        }else if(!preg_match($checkmail,$email)){
            $result = ['status'=>0,'message'=>'请输入正确的邮箱.'];
        }else{
            $this->UserModel = $context->loader->model(UserModel::class,$context);
            $data['username'] = $username;
            $data['password'] = $password;
            $data['email'] = $email;
            $had = yield $this->UserModel->isExistUser($username);
            if($had){
                $result = ['status'=>0,'message'=>'用户已存在.'];
            }else{
                $result = yield $this->UserModel->addUser($data);
                $result = array_merge($result,['status'=>1,'message'=>'注册成功.']);
                print_r($result);
            }
        }
        //unset($username,$password,$email,$checkmail,$context,$had);
        return $result;
    }

    public function after($context)
    {
        // TODO: Implement after() method.
    }

}

// 扩展家族
class IUserServiceFamily implements IUserService{
    /**
     * 前置操作结果集
     * @var array
     */
    protected $before_result = [];

    /**
     * 后置操作结果集
     * @var array
     */
    protected $after_result = [];

    /**
     * 装饰器
     * @var array
     */
    protected $decorator = [];

    /**
     * 增加装饰器
     * @param IUserService $decorator
     */
    public function addDecorator(IUserService $decorator)
    {
        $this->decorator[] = $decorator;
    }

    /**
     * 获取前置操作结果
     * @return array
     */
    public function getBeforeResult(){

        return $this->before_result;
    }

    /**
     * 获取后置操作结果
     * @return array
     */
    public function getAfterResult(){
        return $this->after_result;
    }

    /**
     * 登录前
     * @param $context
     * @return mixed
     */
    public function before($context)
    {
        // TODO: Implement before() method.
        foreach ($this->decorator as $decorator) {
            $this->before_result[] = yield $decorator->before($context);
        }
    }

    /**
     * 登录后
     * @param $context
     * @return mixed
     */
    public function after($context)
    {
        // TODO: Implement after() method.
        foreach ($this->decorator as $decorator) {
            $this->after_result[] = yield $decorator->after($context);
        }

    }
}