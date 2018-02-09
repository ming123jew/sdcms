<?php
namespace app\Controllers\Admin;
use app\Helpers\Tree;

/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-2-1
 * Time: 12:02
 */
class User  extends Base{

    protected $UserModel;


    /**
     * @param string $controller_name
     * @param string $method_name
     */
    protected function initialization($controller_name, $method_name)
    {
        parent::initialization($controller_name, $method_name);
    }

    /**
     * 用户列表
     */
    public function http_user_lists()
    {
        if($this->http_input->getRequestMethod()=='POST'){
            $end = [
                'status' => 0,
                'code'=>200,
                'message'=>'message.'
            ];
            $this->http_output->end(json_encode($end),false);
        }else{
            $this->UserModel = $this->loader->model('UserModel',$this);
            $d_user_model = yield $this->UserModel->getAll();

            //增加管理操作
            foreach ($d_user_model as $key=>$value){

                $d_user_model[$key]['str_manage'] = (yield check_role('Admin','User','user_edit',$this)) ?'<a href="'.url('Admin','User','role_edit',["id" => $value['id']]).'">编辑</a> |':'';
                $d_user_model[$key]['str_manage'] .= (yield check_role('Admin','User','user_delete',$this)) ?'<a  onclick="role_delete('.$value['id'].')" href="javascript:;">删除</a>':'';
                $d_user_model[$key]['role'] = yield get_role_byid($value['roleid'],$this);//角色权限表所有数据 缓存标识

            }
            parent::templateData('allrole',$d_user_model);
            //web or app
            parent::webOrApp(function (){
                $template = $this->loader->view('app::Admin/user_lists');
                $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
            });
        }
    }

    /**
     * 添加用户
     */
    public function http_user_add()
    {
        if($this->http_input->getRequestMethod()=='POST'){

        }else{

            parent::templateData('allrole',[]);
            //web or app
            parent::webOrApp(function (){
                $template = $this->loader->view('app::Admin/user_add_and_edit');
                $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
            });
        }
    }
}