<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2017-12-27
 * Time: 15:17
 */
namespace app\Controllers\Admin;
use app\Models\CategoryModel;
use app\Helpers\Tree;

/**
 *  菜单管理
 * Class Content
 * @package app\Controllers\Admin
 */

class Category extends Base
{
    protected $CategoryModel;
    /**
     * @param string $controller_name
     * @param string $method_name
     */
    protected function initialization($controller_name, $method_name)
    {
        parent::initialization($controller_name, $method_name);
    }

    /**
     * 栏目列表
     */
    public function http_category_list()
    {
        if($this->http_input->getRequestMethod()=='POST'){
            $end = [
                'status' => 0,
                'code'=>200,
                'message'=>'message.'
            ];
            $this->http_output->end(json_encode($end),false);
        }else{
            $this->CategoryModel =  $this->loader->model('CategoryModel',$this);
            $all = yield $this->CategoryModel->getAll();
            $all_menu = '';
            if($all){
                $tree       = new Tree();
                $tree->nbsp = '&nbsp;&nbsp;&nbsp;';

                foreach ($all as $n=> $r) {

                    $all[$n]['parent_id_node'] = isset($r['parent_id']) ? ' class="child-of-node-' . $r['parent_id'] . '"' : '';
                    //$all[$n]['str_manage'] = checkRole('auth/menuAdd',["parent_id" => $r['id']]) ? '<a href="'.url("auth/menuAdd",["parent_id" => $r['id']]).'">添加子菜单</a> |':'';
                    $all[$n]['str_manage'] = (yield check_role('Admin','Category','category_edit',$this)) ?'<a href="'.url('','','menu_edit',["menu_id" => $r['id']]).'">编辑</a> |':'';
                    $all[$n]['str_manage'] .= (yield check_role('Admin','Category','category_delete',$this)) ?'<a  onclick="category_delete('.$r['id'].')" href="javascript:;">删除</a>':'';
                    $all[$n]['status'] = $r['status'] ? '启用' : '禁用';
                    $all[$n]['is_menu'] = $r['is_menu'] ? '是' : '否';
                }

                $str = "<tr id='node-\$id' \$parent_id_node>
                    <td style='padding-left:20px;'>
                        <input name='listorders[\$id]' type='text' size='3' value='\$list_order' data='\$id' class='listOrder'>
                    </td>
                    <td>\$id</td>
                    <td>\$spacer  \$catname</td>
                    <td>内部栏目</td>
                    <td>get_modelname_bymodelid(\$model_id)</td>
                    <td>\$arc_count</td>
                    <td>\$is_menu</td>
                    <td>\$status</td>
                    <td>\$str_manage</td>
                </tr>";

                $tree->init($all);
                $info = $tree->get_tree(0, $str);
            }
            parent::templateData('allcategory',$info);
            //web or app
            parent::webOrApp(function (){
                $template = $this->loader->view('app::Admin/category_list');
                $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
            });
        }
    }

    /**
     * 添加栏目
     */
    public function http_category_add()
    {
        if($this->http_input->getRequestMethod()=='POST'){
            $data['info'] = ($this->http_input->postGet('info'));
            $data['info']['setting'] = json_encode($this->http_input->postGet('setting'));
            //print_r(array_keys($data['info']));
            //print_r(array_values($data['info']));
            //print_r(array_values($data['info']));
            $this->CategoryModel =  $this->loader->model('CategoryModel',$this);
            $r_category_model = yield $this->CategoryModel->insertMultiple(array_keys($data['info']),array_values($data['info']));
            if(!$r_category_model){
                parent::httpOutputTis('CategoryModel添加请求失败.');
            }else{
                parent::httpOutputEnd('栏目添加成功.','栏目添加失败.',$r_category_model);
            }
        }else{
            $parent_id  =  $this->http_input->postGet('parent_id') ?? 0;
            $this->CategoryModel =  $this->loader->model('CategoryModel',$this);
            $all = yield $this->CategoryModel->getAll();
            $info='';

            if($all) {
                $selected = $parent_id;
                $tree = new Tree();
                foreach ($all as $r) {
                    $r['selected'] = $r['id'] == $selected ? 'selected' : '';
                    $array[] = $r;
                    $str = "<option value='\$id' \$selected>\$spacer \$catname</option>";
                    $tree->init($array);
                    $parentid = isset($parent_id)?intval($parent_id):0;
                    $info = $tree->get_tree($parentid, $str);
                }
            }
            parent::templateData('selectCategorys',$info);
            parent::templateData('test',1);
            //web or app
            parent::webOrApp(function (){
                $template = $this->loader->view('app::Admin/category_add_and_edit');
                $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
            });
        }
    }

}
