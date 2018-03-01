<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2017-12-27
 * Time: 15:17
 */
namespace app\Controllers\Admin;
use app\Models\MenuModel;
use app\Helpers\Tree;

/**
 * 内容管理 | 菜单管理 | 推荐位管理
 * Class Content
 * @package app\Controllers\Admin
 */

class Content extends Base
{
    /**
     * @param string $controller_name
     * @param string $method_name
     */
    protected function initialization($controller_name, $method_name)
    {
        parent::initialization($controller_name, $method_name);
    }

    /**
     * 内容列表
     */
    public function http_content_list()
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
                $template = $this->loader->view('app::Admin/content_list');
                $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
            });
        }
    }

    /**
     * 添加内容
     */
    public function http_content_add()
    {
        if($this->http_input->getRequestMethod()=='POST'){
            $end = [
                'status' => 0,
                'code'=>200,
                'message'=>'message.'
            ];
            $this->http_output->end(json_encode($end),false);
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
            parent::templateData('token',token('__CONTENT_ADD__'));
            //web or app
            parent::webOrApp(function (){
                $template = $this->loader->view('app::Admin/content_add_and_edit');
                $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
            });
        }
    }



}
