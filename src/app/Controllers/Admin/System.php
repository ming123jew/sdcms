<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2017-12-25
 * Time: 11:04
 */
namespace app\Controllers\Admin;
use app\Models\MenuModel;
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

                foreach ($all['result'] as $n=> $r) {

                    $all['result'][$n]['parent_id_node'] = isset($r['parent_id']) ? ' class="child-of-node-' . $r['parent_id'] . '"' : '';
                    $all['result'][$n]['str_manage'] = checkPath('auth/menuAdd',["parent_id" => $r['id']]) ? '<a href="'.url("auth/menuAdd",["parent_id" => $r['id']]).'">添加子菜单</a> |':'';
                    $all['result'][$n]['str_manage'] .= checkPath('auth/menuEdit',["id" => $r['id']]) ?'<a href="'.url("auth/menuEdit",["id" => $r['id']]).'">编辑</a> |':'';
                    $all['result'][$n]['str_manage'] .= checkPath('auth/menuDelete',["id" => $r['id']]) ?'<a class="a-post" post-msg="你确定要删除吗" post-url="'.url("auth/menuDelete",["id" => $r['id']]).'">删除</a>|':'';
                    $all['result'][$n]['status'] = $r['status'] ? '开启' : '隐藏';

                }
                $str = "<tr id='node-\$id' \$parent_id_node>
                    <td style='padding-left:20px;'>
                        <input name='listorders[\$id]' type='text' size='3' value='\$list_order' data='\$id' class='listOrder'>
                    </td>
                    <!--<td>\$id</td>-->
                    <td>\$spacer  \$name</td>
                    <td>\$app</td>
                    <td>\$model</td>
                    <td>\$action</td>
                    <td>\$request</td>
                    <td>\$status</td>
                    <td>\$str_manage</td>
                </tr>";

                $tree->init($all['result']);
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
                foreach ($all['result'] as $r) {
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
        if($this->http_input->getRequestMethod()=='POST'){
            $end = [
                'status' => 0,
                'code'=>200,
                'message'=>'message.'
            ];
            $this->http_output->end(json_encode($end),false);
        }else{
            parent::templateData('test',1);
            //web or app
            parent::webOrApp(function (){
                $template = $this->loader->view('app::Admin/system_config');
                $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
            });
        }
    }



}
