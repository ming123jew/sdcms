<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2017-12-25
 * Time: 11:04
 */
namespace app\Controllers\Admin;
use app\Models\Data\MenuModel;
use app\Models\Data\ConfigModel;
use app\Helpers\Tree;

/**
 * 系统设置  |  基本设置  |  菜单
 * Class System
 * @package app\Controllers\Admin
 */
class System extends Base
{
    /**
     * @param string $controller_name
     * @param string $method_name
     * @throws \Exception
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

            $this->Model['MenuModel'] =  $this->loader->model(MenuModel::class,$this);
            $all = yield $this->Model['MenuModel']->getAll();
            $info = '';

            if($all){
                $tree       = new Tree();
                $tree->nbsp = '&nbsp;&nbsp;&nbsp;';

                foreach ($all as $n=> $r) {

                    $all[$n]['parent_id_node'] = isset($r['parent_id']) ? ' class="child-of-node-' . $r['parent_id'] . '"' : '';
                    //$all[$n]['str_manage'] = checkRole('auth/menuAdd',["parent_id" => $r['id']]) ? '<a href="'.url("auth/menuAdd",["parent_id" => $r['id']]).'">添加子菜单</a> |':'';
                    $all[$n]['str_manage'] = (yield check_role('Admin','System','menu_edit',$this)) ?'<a href="'.url('','','menu_edit',["menu_id" => $r['id']]).'">编辑</a> |':'';
                    $all[$n]['str_manage'] .= (yield check_role('Admin','System','menu_delete',$this)) ?'<a  onclick="menu_delete('.$r['id'].')" href="javascript:;">删除</a>':'';
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
            unset($all,$tree,$n,$r,$id,$list_order,$name,$spacer,$m,$c,$a,$request,$status,$str_manage);
            //web or app
            parent::webOrApp(function (){
                $template = $this->loader->view('app::Admin/system_menu');
                $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
            });
        }
    }

    /**
     * 显示 | 添加菜单
     */
    public function http_menu_add(){
        if($this->http_input->getRequestMethod()=='POST'){
            $this->Model['MenuModel'] =  $this->loader->model(MenuModel::class,$this);
            $data = [
                $this->http_input->post('parent_id'),
                $this->http_input->post('name'),
                $this->http_input->post('icon'),
                $this->http_input->post('m'),
                $this->http_input->post('c'),
                $this->http_input->post('a'),
                $this->http_input->post('url_param'),
                $this->http_input->post('status'),
                $this->http_input->post('remark'),
                $this->http_input->post('cc'),
            ];
            $r_menu_model = yield $this->Model['MenuModel']->insertMultiple(['parent_id','name','icon','m','c','a','url_param','status','remark','cc'],$data);
            if(!$r_menu_model){
                unset($data,$r_menu_model);
                parent::httpOutputTis('MenuModel添加请求失败.');
            }else{
                unset($data);
                parent::httpOutputEnd('菜单添加成功.','菜单添加失败.',$r_menu_model);
            }

        }else{
            $parent_id  =  $this->http_input->postGet('parent_id') ?? 0;
            $this->Model['MenuModel'] =  $this->loader->model(MenuModel::class,$this);
            $all = yield $this->Model['MenuModel']->getAll();
            $info='';
            if($all) {
                $selected = $parent_id;
                $tree = new Tree();
                foreach ($all as $r) {
                    $r['selected'] = $r['id'] == $selected ? 'selected' : '';
                    $array[] = $r;
                    $str = "<option value='\$id' \$selected>\$spacer \$name</option>";
                    $tree->init($array);
                    $parentid = isset($parent_id)?intval($parent_id):0;
                    $info = $tree->get_tree($parentid, $str);
                }
            }
//here
            parent::templateData('selectCategorys',$info);
            parent::templateData('d_menu_model',[]);
            unset($parent_id,$all,$info,$selected,$tree,$r,$array,$str,$parentid);
            //web or app
            parent::webOrApp(function (){
                $template = $this->loader->view('app::Admin/system_menu_add_and_edit');
                $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
            });
        }
    }

    /**
     * 编辑菜单
     */
    public function http_menu_edit(){
        $menu_id =  intval($this->http_input->post('menu_id'));
        if($this->http_input->getRequestMethod()=='POST' && $menu_id){
            $this->Model['MenuModel'] =  $this->loader->model(MenuModel::class,$this);
            $data = [
                'parent_id'=> $this->http_input->post('parent_id'),
                'name'=>$this->http_input->post('name'),
                'icon'=>$this->http_input->post('icon'),
                'm'=>$this->http_input->post('m'),
                'c'=>$this->http_input->post('c'),
                'a'=>$this->http_input->post('a'),
                'url_param'=>$this->http_input->post('url_param'),
                'status'=>$this->http_input->post('status'),
                'remark'=>$this->http_input->post('remark'),
                'cc'=>$this->http_input->post('cc'),
            ];
            $r_menu_model = yield $this->Model['MenuModel']->updateById($menu_id,$data);
            if(!$r_menu_model){
                unset($menu_id,$data,$r_menu_model);
                parent::httpOutputTis('MenuModel编辑请求失败.');
            }else{
                unset($menu_id,$data);
                parent::httpOutputEnd('菜单更新成功.','菜单更新失败.',$r_menu_model);
            }

        }else{
            $menu_id = intval($this->http_input->get('menu_id'));//menu_id
            if(!$menu_id){
                unset($menu_id);
                parent::httpOutputTis('参数错误.');
            }else{
                $this->Model['MenuModel'] =  $this->loader->model(MenuModel::class,$this);
                // 查找单条记录
                $d_menu_model = yield $this->Model['MenuModel']->getOneById($menu_id);
                $parent_id  =  $d_menu_model['parent_id'];
                //查找所有
                $all = yield $this->Model['MenuModel']->getAll();
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

                parent::templateData('selectCategorys',$info);
                parent::templateData('d_menu_model',$d_menu_model);
                unset($d_menu_model,$parent_id,$all,$info,$selected,$r,$array,$str,$tree,$parentid,$where,$selected,$spacer,$name);
                //web or app
                parent::webOrApp(function (){
                    $template = $this->loader->view('app::Admin/system_menu_add_and_edit');
                    $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
                });
            }

        }
    }


    public function http_menu_delete(){
        $menu_id =  intval($this->http_input->post('menu_id'));
        if($this->http_input->getRequestMethod()=='POST' && $menu_id){
            //查找是否存在子菜单
            $this->Model['MenuModel'] =  $this->loader->model(MenuModel::class,$this);
            $all = yield $this->Model['MenuModel']->getAll();
            if($all){
                $tree       = new Tree();
                $tree->init($all);
                $arr_all_child = $tree->get_child($menu_id);
                $arr_delete[] = $menu_id;
                foreach ($arr_all_child as $key=>$value){
                    $arr_delete[] = $value['id'];
                }
                //print_r($arr_delete);
                $r_menu_model = yield $this->Model['MenuModel']->delete($arr_delete);
                //print_r($all_child);
                if(!$r_menu_model){
                    unset($menu_id,$all,$tree,$arr_all_child,$arr_delete,$key,$value,$r_menu_model);
                    parent::httpOutputTis('MenuModel删除请求失败.');
                }else{
                    unset($menu_id,$all,$tree,$arr_all_child,$arr_delete,$key,$value);
                    parent::httpOutputEnd('菜单删除成功.','菜单删除失败.',$r_menu_model);
                }
            }
        }
    }

    /**
     * 后台基本设置 | 兼容所有端
     * PC/WAP 使用到VIEW，其他端只在is_app=yes操作返回结果
     */
    public function http_config()
    {
        $this->Model['ConfigModel'] = $this->loader->model(ConfigModel::class,$this);
        if($this->http_input->getRequestMethod()=='POST'){
            $post = [];
            $post['info'] = $this->http_input->post('info');
            $post['attachment'] = $this->http_input->post('attachment');
            $post['params'] = $this->http_input->post('params');
            $data['content'] = json_encode($post);
            $data['id'] = 1;
            //print_r($data);
            $is_had = yield $this->Model['ConfigModel']->isHad();
            if( $is_had==false ){
                //不存在
                $r = yield $this->Model['ConfigModel']->addOne($data);
                unset($post,$data,$is_had);
                parent::httpOutputEnd('添加成功.','添加失败.',$r);
            }else{
                //存在
                $r = yield $this->Model['ConfigModel']->updateOne($data);
                unset($post,$data,$is_had);
                parent::httpOutputEnd('更新成功.','更新失败.',$r);
            }
        }else{
            $data = yield $this->Model['ConfigModel']->getOne();
            //print_r($data);
            $system_config = json_decode($data['result'][0]['content'],true);
            parent::templateData('pagedata',$system_config);
            unset($data,$system_config);
            //web or app
            parent::webOrApp(function (){
                $template = $this->loader->view('app::Admin/system_config');
                $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
            });
        }
    }
}
