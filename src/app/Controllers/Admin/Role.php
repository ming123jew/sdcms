<?php
namespace app\Controllers\Admin;
use app\Helpers\Tree;

/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-1-5
 * Time: 12:02
 */
class Role  extends Base{

    protected $RoleModel;
    protected $MenuModel;

    /**
     * @param string $controller_name
     * @param string $method_name
     */
    protected function initialization($controller_name, $method_name)
    {
        parent::initialization($controller_name, $method_name);
    }

    public function http_lists()
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

            parent::templateData('allrole',$all);
            //web or app
            parent::webOrApp(function (){
                $template = $this->loader->view('app::Admin/role_lists');
                $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
            });
        }
    }


    public function http_setting()
    {
        if($this->http_input->getRequestMethod()=='POST'){
            $end = [
                'status' => 0,
                'code'=>200,
                'message'=>'message.'
            ];
            $this->http_output->end(json_encode($end),false);
        }else{
            $id = intval($this->http_input->get('id'));
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
                $priv_data=[];
                $tree       = new Tree();
                foreach ($all as $n => $t) {
                    $all[$n]['checked']  = (in_array($t['id'], $priv_data)) ? ' checked' : '';
                    $all[$n]['level']    = $tree->get_level($t['id'], $all);
                    $all[$n]['width']    = 100-$all[$n]['level'];
                    $all[$n]['disabled'] = [0=>'', 1=>''];
                }

                $tree->init($all);

                $tree->text =[
                    'other' => "<label class='checkbox' data-original-title='' data-toggle='' >
                        <input \$checked \$disabled[0] name='menu_id[]' value='\$id \$m \$c \$a' level='\$level'
                        onclick='javascript:checknode(this);'type='checkbox'>
                        <span class='text'>\$disabled[1] \$name</span>
                   </label>",
                    '0' => [
                        '0' =>"<dl class='checkmod'>
                    <dt class='hd'>
                        <label class='checkbox' data-original-title='' data-toggle='tooltip'>
                            <input \$checked \$disabled[0] name='menu_id[]' value='\$id \$m \$c \$a' level='\$level'
                             onclick='javascript:checknode(this);'
                             type='checkbox'>
                             <span class='text'>\$disabled[1] \$name</span>
                        </label>
                    </dt>
                    <dd class='bd'>",
                        '1' => "</dd></dl>",
                    ],
                    '1' => [
                        '0' => "
                        <div class='menu_parent'>
                            <label class='checkbox' data-original-title='' data-toggle='tooltip'>
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