<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-3-23
 * Time: 10:24
 */

namespace app\Models\Business;
use app\Models\Data\ModelModel;
use app\Helpers\Tree;

class ModelBusiness extends BaseBusiness
{
    protected $ModelModel;

    /**
     * @param int $parent_id
     * @return string
     */
    public function get_all_by_parent_id(int $parent_id)
    {
        $this->ModelModel =  $this->loader->model(ModelModel::class,$this);
        $all = yield $this->ModelModel->getAll();
        $info='';
        if($all)
        {
            $selected = $parent_id;
            $tree = new Tree();
            foreach ($all as $r)
            {
                $r['selected'] = $r['id'] == $selected ? 'selected' : '';
                $array[] = $r;
                $str = "<option value='\$id' \$selected>\$spacer \$name</option>";
                $tree->init($array);
                $info = $tree->get_tree(0, $str);
            }
        }
        return $info;
    }

}