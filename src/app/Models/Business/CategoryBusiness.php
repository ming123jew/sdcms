<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-3-23
 * Time: 10:24
 */

namespace app\Models\Business;
use app\Models\Data\CategoryModel;
use app\Helpers\Tree;

class CategoryBusiness extends BaseBusiness
{
    protected $CategoryModel;
    /**
     * @param int $parent_id
     * @return string
     */
    public function get_category_by_parentid(int $parent_id)
    {
        $this->CategoryModel =  $this->loader->model(CategoryModel::class,$this);
        $all = yield $this->CategoryModel->getAll();
        $info='';
        if($all)
        {
            $selected = $parent_id;
            $tree = new Tree();
            foreach ($all as $r)
            {
                $r['selected'] = $r['id'] == $selected ? 'selected' : '';
                $array[] = $r;
                $str = "<option value='\$id' \$selected>\$spacer \$catname</option>";
                $tree->init($array);
                $info = $tree->get_tree(0, $str);
            }
        }
        return $info;
    }

    /**
     * @return string
     */
    public function get_category_for_category_list($context)
    {
        $this->CategoryModel =  $this->loader->model(CategoryModel::class,$this);
        $all = yield $this->CategoryModel->getAll();
        $all_menu = '';
        if($all)
        {
            $tree       = new Tree();
            $tree->nbsp = '&nbsp;&nbsp;&nbsp;';

            foreach ($all as $n=> $r)
            {
                $all[$n]['parent_id_node'] = isset($r['parent_id']) ? ' class="child-of-node-' . $r['parent_id'] . '"' : '';
                //$all[$n]['str_manage'] = checkRole('auth/menuAdd',["parent_id" => $r['id']]) ? '<a href="'.url("auth/menuAdd",["parent_id" => $r['id']]).'">添加子菜单</a> |':'';
                $all[$n]['str_manage'] = (yield check_role('Admin','Category','category_edit',$context)) ?'<a href="'.url('','','category_edit',["id" => $r['id']]).'">编辑</a> |':'';
                $all[$n]['str_manage'] .= (yield check_role('Admin','Category','category_delete',$context)) ?'<a  onclick="category_delete('.$r['id'].')" href="javascript:;">删除</a>':'';
                $all[$n]['status'] = $r['status'] ? '启用' : '禁用';
                $all[$n]['is_menu'] = $r['is_menu'] ? '是' : '否';
                $all[$n]['model_name'] = get_modelname_bymodelid($r['model_id']);
                $all[$n]['cat_type'] = get_cattype_bymodelid($r['model_id']);
            }

            $str = "<tr id='node-\$id' \$parent_id_node>
                    <td style='padding-left:20px;'>
                        <input name='listorders[\$id]' type='text' size='3' value='\$list_order' data='\$id' class='listOrder'>
                    </td>
                    <td>\$id</td>
                    <td>\$spacer  \$catname</td>
                    <td>\$cat_type</td>
                    <td>\$model_name</td>
                    <td>\$arc_count</td>
                    <td>\$is_menu</td>
                    <td>\$status</td>
                    <td>\$str_manage</td>
                </tr>";

            $tree->init($all);
            $info = $tree->get_tree(0, $str);
        }
        return $info;
    }
}