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
            $all = yield $this->UserModel->getAll();

            parent::templateData('allrole',$all);
            //web or app
            parent::webOrApp(function (){
                $template = $this->loader->view('app::Admin/user_lists');
                $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
            });
        }
    }

    /**
     * 权限设置页面 | 提交保存
     */
    public function http_role_setting()
    {
        if($this->http_input->getRequestMethod()=='POST'){
            $role_id = intval($this->http_input->post('role_id'));
            //menu_id model controllers method
            $arr_menu_id = $this->http_input->post('menu_id');
            if(!$role_id){
                parent::httpOutputTis('非法请求.');
            }else{
                //删除当前role_id的所有数据
                $this->RolePrivModel = $this->loader->model('RolePrivModel',$this);
                $d_rolepriv_model = yield $this->RolePrivModel->deleteByRoleId($role_id);

                if(!$d_rolepriv_model){
                    parent::httpOutputTis('RoleModel删除请求失败.');
                }else{
                    if(count($arr_menu_id)){
                        foreach ($arr_menu_id as $key=>$value){
                            $arr_value = explode(' ',$value);
                            array_unshift($arr_value,$role_id);
                            $arr_menu_id[$key] =$arr_value;
                        }
                        //插入新的权限数据
                        $i_rolepriv_model = yield $this->RolePrivModel->insertMultiple(['role_id','menu_id','m','c','a'],$arr_menu_id);
                        if(!$i_rolepriv_model){
                            parent::httpOutputTis('RolePrivModel插入请求失败.');
                        }else{
                            parent::httpOutputEnd('权限更新成功.','权限更新失败.',$i_rolepriv_model);
                        }
                    }else{
                        parent::httpOutputTis('没有选项.');
                    }
                }
            }

        }else{

            $id = intval($this->http_input->get('id'));//role_id
            $name = intval($this->http_input->get('name'));
            if(!$id){
                parent::httpOutputTis('参数错误.');
            }else{
                //查找所有菜单
                $this->MenuModel =  $this->loader->model('MenuModel',$this);
                $all = yield $this->MenuModel->getAll();
                //print_r($all);

//                $this->RoleModel = $this->loader->model('RoleModel',$this);
//                $all = yield $this->RoleModel->getAll();

                //查找当前角色组所有权限
                $this->RolePrivModel =  $this->loader->model('RolePrivModel',$this);
                $d_rolepriv_model = yield $this->RolePrivModel->getByRoleId($id,'menu_id');
                $priv_data = [];
                foreach ($d_rolepriv_model as $key=>$value){
                    $priv_data[] = $value['menu_id'];
                }

                $tree       = new Tree();
                foreach ($all as $n => $t) {
                    $all[$n]['checked']  = (in_array($t['id'], $priv_data)) ? ' checked' : '';
                    $all[$n]['level']    = $tree->get_level($t['id'], $all);
                    $all[$n]['width']    = 100-$all[$n]['level'];
                    $all[$n]['disabled'] = [0=>'', 1=>''];
                }

                $tree->init($all);

                $tree->text =[
                    'other' => "<label class='checkbox'>
                        <input \$checked \$disabled[0] name='menu_id[]' value='\$id \$m \$c \$a' level='\$level'
                        onclick='javascript:checknode(this);'type='checkbox'>
                        <span class='text'>\$disabled[1] \$name</span>
                   </label>",
                    '0' => [
                        '0' =>"<dl class='checkmod'>
                    <dt class='hd'>
                        <label class='checkbox'>
                            <input \$checked \$disabled[0] name='menu_id[]' value='\$id \$m \$c \$a' level='\$level'
                             onclick='javascript:checknode(this);' type='checkbox'>
                             <span class='text'>\$disabled[1] \$name</span>
                        </label>
                    </dt>
                    <dd class='bd'>",
                        '1' => "</dd></dl>",
                    ],
                    '1' => [
                        '0' => "
                        <div class='menu_parent'>
                            <label class='checkbox'>
                                <input \$checked \$disabled[0] name='menu_id[]' value='\$id \$m \$c \$a' level='\$level'
                                onclick='javascript:checknode(this);' type='checkbox'>
                                <span class='text'>\$disabled[1] \$name</span>
                            </label>
                        </div>
                        <div class='rule_check' style='width: \$width%;'>",
                        '1' => "</div><span class='child_row'></span>",
                    ]

                ];
                $html   = $tree->get_roleTree(0);

                parent::templateData('cur_role_id',$id);
                parent::templateData('cur_role_name',$name);
                parent::templateData('html',$html);
                //web or app
                parent::webOrApp(function (){
                    $template = $this->loader->view('app::Admin/role_setting');
                    $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
                });
            }


        }
    }
}