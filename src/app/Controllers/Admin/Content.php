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
use app\Helpers\ChinesePinyin;

/**
 * 内容管理 | 菜单管理 | 推荐位管理
 * Class Content
 * @package app\Controllers\Admin
 */

class Content extends Base
{
    protected $ContentModel;
    protected $ContentHitsModel;
    protected $CategoryModel;
    protected $TagsModel;
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
            $this->ContentModel =  $this->loader->model('ContentModel',$this);
            $p = intval( $this->http_input->postGet('p') );
            if($p == 0){
                $p = 1;
            }
            $end = 10;
            $start = ($p-1)*$end;
            $r = yield $this->ContentModel->getAllByPage($start,$end);
            if($r){
                foreach ($r as $n=> $v) {
                    $r[$n]['str_manage'] = (yield check_role('Admin', 'Content', 'content_edit', $this)) ? '<a href="' . url('Admin', 'Content', 'content_edit', ["id" => $v['id']]) . '">编辑</a> |' : '';
                    $r[$n]['str_manage'] .= (yield check_role('Admin', 'Content', 'content_delete', $this)) ? '<a  onclick="content_delete(' . $v['id'] . ')" href="javascript:;">删除</a>' : '';
                }
            }
            parent::templateData('list',$r);

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
            //数据处理
            $data['info'] = $this->http_input->postGet('info');
            $data['info']['body'] = $this->http_input->postGet('editorValue');
            //获取登录信息
            $login_session = self::get_login_session();
            $data['info']['username'] = $login_session['username'];
            $data['info']['create_time'] = time();
            $data['info']['update_time'] = time();
            if($data['info']['isgourl']=='on'&&$data['info']['gourl']){
                unset($data['info']['isgourl']);
            }else{
                $data['info']['gourl'] = '';
            }
            if(empty($data['info']['copyfrom'])){
                $data['info']['copyfrom'] = '本站';
            }

            //插入主表
            $this->ContentModel =  $this->loader->model('ContentModel',$this);
            $r_content_model = yield $this->ContentModel->insertMultiple(array_keys($data['info']),array_values($data['info']));
            //print_r($r_content_model);
            if(!$r_content_model['result']){
                parent::httpOutputTis('ContentModel添加请求失败.');
            }else{
                //插入统计表
                $this->ContentHitsModel =  $this->loader->model('ContentHitsModel',$this);
                $r_content_hits_model = yield $this->ContentHitsModel->insertMultiple(['content_id','catid','updatetime'],[$r_content_model['insert_id'],$data['info']['catid'],time()]);
                if(!$r_content_hits_model){
                    parent::httpOutputTis('ContentHitsModel添加请求失败.');
                }else{
                    //更新栏目数据arc_count
                    $this->CategoryModel = $this->loader->model('CategoryModel',$this);
                    $r_category_model = yield $this->CategoryModel->setInc($data['info']['catid'],'arc_count');
                    if(!$r_category_model){
                        parent::httpOutputTis('CategoryModel更新请求失败.');
                    }else{
                        //插入标签表
                        if(!empty($data['info']['keywords'])){
                            $arr_tags = explode(' ',str_replace(',',' ',$data['info']['keywords']));
                            $pinyin = new ChinesePinyin();
                            foreach ($arr_tags as $key=>$value){
                                $tags[$key]['title'] = $value;
                                $tags[$key]['content_id'] = $r_content_model['insert_id'];
                                $tags[$key]['ucwords'] = substr($pinyin->TransformUcwords($value),0,1);
                            }
                            //print_r(array_values($tags));
                            $this->TagsModel = $this->loader->model('TagsModel',$this);
                            $r_tags_model = yield $this->TagsModel->insertMultiple(array_keys($tags[0]),array_values($tags));
                            if(!$r_tags_model){
                                parent::httpOutputTis('TagsModel更新请求失败.');
                            }else{
                                parent::httpOutputEnd('内容添加成功.','内容添加失败.',$r_tags_model);
                            }
                        }//标签
                    }//$r_category_model
                }//$r_content_model
            }

        }else{

            //显示添加内容页面
            $parent_id  =  $this->http_input->postGet('parent_id') ?? 0;
            //显示分类
            $selectCategorys= yield self::_get_category_info(intval($parent_id));

            parent::templateData('selectCategorys',$selectCategorys);
            parent::templateData('test',1);
            parent::templateData('token',token('__CONTENT_ADD__'));
            //web or app
            parent::webOrApp(function (){
                $template = $this->loader->view('app::Admin/content_add_and_edit');
                $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
            });
        }
    }

    /**
     * 编辑内容
     */
    public function http_content_edit()
    {
        if($this->http_input->getRequestMethod()=='POST'){
            $data = $this->http_input->post('info');
            $id = $data['id'];
            unset($data['id']);
            $this->ContentModel =  $this->loader->model('ContentModel',$this);
            $r_content_model = yield $this->ContentModel->updateById($id,$data);
            if(!$r_content_model){
                parent::httpOutputTis('ContentModel编辑请求失败.');
            }else{
                parent::httpOutputEnd('权限更新成功.','权限更新失败.',$r_content_model);
            }
        }else{
            $id = $this->http_input->get('id');
            $this->ContentModel =  $this->loader->model('ContentModel',$this);
            $d = yield $this->ContentModel->getById($id);
            if($id && $d){
                //自动选择分类
                $selectCategorys= yield self::_get_category_info(intval($d['catid']));
                parent::templateData('d_content_model',$d);
                parent::templateData('selectCategorys',$selectCategorys);
                parent::webOrApp(function (){
                    $template = $this->loader->view('app::Admin/content_add_and_edit');
                    $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
                });
            }else{
                $this->http_output->setHeader('Content-type','text/html;charset=utf-8');
                $this->http_output->end('参数错误');
            }
        }
    }

    /**
     * 删除内容
     */
    public function http_content_delete()
    {

    }

    /**
     * 获取分类内容
     * @param int $parent_id
     * @return string
     */
    private function _get_category_info(int $parent_id)
    {
        //显示分类
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
                $info = $tree->get_tree(0, $str);
            }
        }
        return $info;
    }

    private function _check_title(){

    }



}
