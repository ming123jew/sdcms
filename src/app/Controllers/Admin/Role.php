<?php
namespace app\Controllers\Admin;
use app\Helpers\Tree;
use app\Models\RolePrivModel;

/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-1-5
 * Time: 12:02
 */
class Role  extends Base{

    protected $RoleModel;
    protected $RolePrivModel;
    protected $MenuModel;


    /**
     * @param string $controller_name
     * @param string $method_name
     */
    protected function initialization($controller_name, $method_name)
    {
        parent::initialization($controller_name, $method_name);
    }

    /**
     * 角色列表
     */
    public function http_role_lists()
    {
        if($this->http_input->getRequestMethod()=='POST'){
            $end = [
                'status' => 0,
                'code'=>200,
                'message'=>'message.'
            ];
            $this->http_output->end(json_encode($end),false);
        }else{
            $this->RoleModel = $this->loader->model('RoleModel',$this);
            $all = yield $this->RoleModel->getAll();
            //增加管理操作
            foreach ($all as $key=>$value){
                $all[$key]['str_manage'] = (yield check_role('Admin','Role','role_setting',$this)) ?'<a href="'.url('Admin','Role','role_setting',["id" => $value['id']]).'">权限设置</a> |':'';
                $all[$key]['str_manage'] .= (yield check_role('Admin','Role','role_edit',$this)) ?'<a href="'.url('Admin','Role','role_edit',["id" => $value['id']]).'">编辑</a> |':'';
                $all[$key]['str_manage'] .= (yield check_role('Admin','Role','role_delete',$this)) ?'<a  onclick="role_delete('.$value['id'].')" href="javascript:;">删除</a>':'';
            }
            parent::templateData('allrole',$all);
            //web or app
            parent::webOrApp(function (){
                $template = $this->loader->view('app::Admin/role_lists');
                $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
            });
        }
    }

    /**
     * 添加角色
     */
    public function http_role_add(){
        if($this->http_input->getRequestMethod()=='POST'){
            $this->RoleModel =  $this->loader->model('RoleModel',$this);
            $data = $this->http_input->post('info');
            unset($data['id']);
            $r_role_model = yield $this->RoleModel->insertMultiple(array_keys($data),array_values($data));
            if(!$r_role_model ){
                parent::httpOutputTis('RoleModel添加请求失败.');
            }else{
                parent::httpOutputEnd('角色添加成功.','角色添加失败.',$r_role_model );
            }
        }else{

            //web or app
            parent::webOrApp(function (){
                $template = $this->loader->view('app::Admin/role_add_and_edit');
                $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
            });
        }
    }

    /**
     * 修改角色
     */
    public function http_role_edit(){
        if($this->http_input->getRequestMethod()=='POST'){
            $data = $this->http_input->post('info');
            $id = $data['id'];
            unset($data['id']);
            $this->RoleModel =  $this->loader->model('RoleModel',$this);
            $r_role_model = yield $this->RoleModel->updateById($id,$data);
            if(!$r_role_model){
                parent::httpOutputTis('RoleModel编辑请求失败.');
            }else{
                parent::httpOutputEnd('权限更新成功.','权限更新失败.',$r_role_model);
            }
        }else{ //web or app
            $id = $this->http_input->get('id');
            $this->RoleModel =  $this->loader->model('RoleModel',$this);
            $d = yield $this->RoleModel->getOneById($id);
            if($id && $d){
                parent::templateData('d_role_model',$d);
                parent::webOrApp(function (){
                    $template = $this->loader->view('app::Admin/role_add_and_edit');
                    $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
                });
            }else{

            }

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
                parent::httpOutputTis('非法请求.',false);
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

    /**
     * 删除角色权限，连同对应分配删除
     * @return \Generator
     */
    public function http_role_delete(){
        $id =  intval($this->http_input->post('id'));//role_id
        if($this->http_input->getRequestMethod()=='POST' && $id){
            //查找是否存在角色分配
            //这里由于关联到2个表，使用事务
            $transaction_id = yield $this->mysql_pool->coroutineBegin($this);
            //删除权限分配表中数据
            $this->RolePrivModel = $this->loader->model('RolePrivModel',$this);
            $delete_model_rolepriv = yield $this->mysql_pool->dbQueryBuilder->from($this->RolePrivModel->getTable())->where('role_id',$id)->delete()->coroutineSend($transaction_id);
            //删除主表中数据
            $this->RoleModel = $this->loader->model('RoleModel',$this);
            $delete_model_role = yield $this->mysql_pool->dbQueryBuilder->from($this->RoleModel->getTable())->where('id',$id)->delete()->coroutineSend($transaction_id);
            //print_r( $delete_model_rolepriv);
            //print_r($delete_model_role);
            //print_r($transaction_id);
            if($delete_model_role['result']){
                parent::httpOutputEnd('角色删除成功.','角色删除失败.',$delete_model_role);
                yield $this->mysql_pool->coroutineCommit($transaction_id);
            }else{
                parent::httpOutputTis('删除请求失败.');
                yield $this->mysql_pool->coroutineRollback($transaction_id);
            }
        }
    }

}