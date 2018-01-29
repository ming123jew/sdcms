<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2017-12-25
 * Time: 11:04
 */
namespace app\Controllers\Admin;
use app\Models\MenuModel;
use app\Models\ConfigModel;
use app\Helpers\Tree;

/**
 * 系统设置  |  基本设置  |  菜单
 * Class System
 * @package app\Controllers\Admin
 */
class System extends Base
{
    protected $UserModel;
    protected $MenuModel;
    protected $ConfigModel;
    /**
     * @param string $controller_name
     * @param string $method_name
     */
    protected function initialization($controller_name, $method_name)
    {
        parent::initialization($controller_name, $method_name);
    }
    /**
     * 后台菜单设置 | 兼容所有端
     * PC/WAP 使用到VIEW，其他端只在is_app=yes操作返回结果
     */
    public function http_menu()
    {
        if($this->http_input->getRequestMethod()=='POST'){
            $end = [
                'status' => 0,
                'code'=>200,
                'message'=>'message.'
            ];
            $this->http_output->end(json_encode($end),false);
        }else{

            $this->MenuModel =  $this->loader->model('MenuModel',$this);
            $all = yield $this->MenuModel->getAll();
            $info = '';

            if($all){
                $tree       = new Tree();
                $tree->nbsp = '&nbsp;&nbsp;&nbsp;';

                foreach ($all as $n=> $r) {

                    $all[$n]['parent_id_node'] = isset($r['parent_id']) ? ' class="child-of-node-' . $r['parent_id'] . '"' : '';
                    $all[$n]['str_manage'] = checkPath('auth/menuAdd',["parent_id" => $r['id']]) ? '<a href="'.url("auth/menuAdd",["parent_id" => $r['id']]).'">添加子菜单</a> |':'';
                    $all[$n]['str_manage'] .= checkPath('auth/menuEdit',["id" => $r['id']]) ?'<a href="'.url("auth/menuEdit",["id" => $r['id']]).'">编辑</a> |':'';
                    $all[$n]['str_manage'] .= checkPath('auth/menuDelete',["id" => $r['id']]) ?'<a class="a-post" post-msg="你确定要删除吗" post-url="'.url("auth/menuDelete",["id" => $r['id']]).'">删除</a>|':'';
                    $all[$n]['status'] = $r['status'] ? '开启' : '隐藏';

                }
                $str = "<tr id='node-\$id' \$parent_id_node>
                    <td style='padding-left:20px;'>
                        <input name='listorders[\$id]' type='text' size='3' value='\$list_order' data='\$id' class='listOrder'>
                    </td>
                    <!--<td>\$id</td>-->
                    <td>\$spacer  \$name</td>
                    <td>\$m</td>
                    <td>\$c</td>
                    <td>\$a</td>
                    <td>\$request</td>
                    <td>\$status</td>
                    <td>\$str_manage</td>
                </tr>";

                $tree->init($all);
                $info = $tree->get_tree(0, $str);
                //print_r($all);

            }
            parent::templateData('allmenu',$info);
            parent::templateData('test',1);
            //web or app
            parent::webOrApp(function (){
                $template = $this->loader->view('app::Admin/system_menu');
                $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
            });
        }
    }


    public function http_menu_add(){
        if($this->http_input->getRequestMethod()=='POST'){
            $end = [
                'status' => 1,
                'code'=>200,
                'message'=>'message.'
            ];
            $this->http_output->end(json_encode($end),false);
        }else{
            $parent_id  =  $this->http_input->postGet('parent_id') ?? 0;

            $this->MenuModel =  $this->loader->model('MenuModel',$this);
            $all = yield $this->MenuModel->getAll();
            $info='';
            if($all) {
                $selected = $parent_id;
                $tree = new Tree();
                foreach ($all as $r) {
                    $r['selected'] = $r['id'] == $selected ? 'selected' : '';
                    $array[] = $r;
                    $str = "<option value='\$id' \$selected>\$spacer \$name</option>";
                    $tree->init($array);
                    $parentid = isset($where['parentid'])?$where['parentid']:0;
                    $info = $tree->get_tree($parentid, $str);
                }
            }
//here
            parent::templateData('selectCategorys',$info);
            parent::templateData('test',1);
            //web or app
            parent::webOrApp(function (){
                $template = $this->loader->view('app::Admin/system_menu_add');
                $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
            });
        }
    }

    /**
     * 后台基本设置 | 兼容所有端
     * PC/WAP 使用到VIEW，其他端只在is_app=yes操作返回结果
     */
    public function http_config()
    {
        $this->ConfigModel = $this->loader->model('ConfigModel',$this);

        if($this->http_input->getRequestMethod()=='POST'){

            $post = [];
            $post['info'] = $this->http_input->post('info');
            $post['attachment'] = $this->http_input->post('attachment');
            $post['params'] = $this->http_input->post('params');

            $data['content'] = json_encode($post);
            $data['id'] = 1;
            //print_r($data);
            $is_had = yield $this->ConfigModel->isHad();
            if( $is_had==false ){
                //不存在
                $r = yield $this->ConfigModel->addOne($data);
                parent::httpOutputEnd('添加成功.','添加失败.',$r);
            }else{
                //存在
                $r = yield $this->ConfigModel->updateOne($data);
                parent::httpOutputEnd('更新成功.','更新失败.',$r);
            }


        }else{
            $data = yield $this->ConfigModel->getOne();
            //print_r($data);
            $system_config = json_decode($data['result'][0]['content'],true);
            parent::templateData('pagedata',$system_config);
            //web or app
            parent::webOrApp(function (){
                $template = $this->loader->view('app::Admin/system_config');
                $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
            });
        }
    }



}
