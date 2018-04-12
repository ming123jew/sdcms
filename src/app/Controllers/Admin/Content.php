<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2017-12-27
 * Time: 15:17
 */
namespace app\Controllers\Admin;
use app\Models\Business\ContentBusiness;
use app\Models\Data\ContentModel;
use app\Models\Business\CategoryBusiness;

/**
 * 内容管理 | 菜单管理 | 推荐位管理
 * Class Content
 * @package app\Controllers\Admin
 */

class Content extends Base
{
    protected $ContentModel;
    protected $ContentBusiness;
    protected $CategoryBusiness;
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
        if($this->http_input->getRequestMethod()=='POST')
        {
            $end = [
                'status' => 0,
                'code'=>200,
                'message'=>'message.'
            ];
            $this->http_output->end(json_encode($end),false);
        }else{
            $this->ContentModel =  $this->loader->model(ContentModel::class,$this);
            $p = intval( $this->http_input->postGet('p') );
            if($p == 0) {$p = 1;}
            $end = 10;
            $start = ($p-1)*$end;
            $r = yield $this->ContentModel->getAllByPage($start,$end);

            if($r['result'])
            {
                foreach ($r['result'] as $n=> $v)
                {
                    $r['result'][$n]['str_manage'] = (yield check_role('Admin', 'Content', 'content_edit', $this)) ? '<a href="' . url('Admin', 'Content', 'content_edit', ["id" => $v['id']]) . '">编辑</a> |' : '';
                    $r['result'][$n]['str_manage'] .= (yield check_role('Admin', 'Content', 'content_delete', $this)) ? '<a  onclick="content_delete(' . $v['id'] . ')" href="javascript:;">删除</a>' : '';
                }
            }

            parent::templateData('list',$r['result']);
            parent::templateData('page',page_bar($r['num'],$p,10,5,$this));

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
        if($this->http_input->getRequestMethod()=='POST')
        {
            //数据处理
            $data['info'] = $this->http_input->postGet('info');
            $data['info']['body'] = $this->http_input->postGet('editorValue');
            //获取登录信息
            $login_session = self::get_login_session();
            $data['info']['username'] = $login_session['username'];
            $data['info']['create_time'] = time();
            $data['info']['update_time'] = time();
            if(isset($data['info']['isgourl']))
            {
                unset($data['info']['isgourl']);
            }else{
                $data['info']['gourl'] = '';
            }
            if(empty($data['info']['copyfrom']))
            {
                $data['info']['copyfrom'] = '本站';
            }
            if(isset($data['info']['oldcatid']))
            {
                unset($data['info']['oldcatid']);
            }
            if(isset($data['info']['flag']))
            {
                //FIND_IN_SET('b','a,b,c,d');
                $data['info']['flag'] = implode(',',$data['info']['flag']);
            }else{
                $data['info']['flag'] = '';
            }

            //[--start::添加文章{业务逻辑}--]
            $this->ContentBusiness = $this->loader->model(ContentBusiness::class,$this);
            $r = yield $this->ContentBusiness->content_add($data['info']);
            if($r)
            {
                parent::httpOutputEnd('内容添加成功.','内容添加失败.',$r);
            }else{
                parent::httpOutputTis('ContentModel添加请求失败.');
            }
            //[--end::添加文章{业务逻辑}--]

        }else{
            //显示添加内容页面
            $parent_id  =  $this->http_input->postGet('parent_id') ?? 0;
            //显示分类
            $this->CategoryBusiness =  $this->loader->model(CategoryBusiness::class,$this);
            $selectCategorys= yield  $this->CategoryBusiness->get_category_by_parentid(intval($parent_id));

            parent::templateData('selectCategorys',$selectCategorys);
            parent::templateData('test',1);
            parent::templateData('token',token('__CONTENT_ADD__'));
            parent::templateData('d_content_model',[]);
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
        if($this->http_input->getRequestMethod()=='POST')
        {
            //数据处理
            $data['info'] = $this->http_input->postGet('info');
            $data['info']['body'] = $this->http_input->postGet('editorValue');
            //获取登录信息
            $login_session = self::get_login_session();
            $data['info']['username'] = $login_session['username'];
            $data['info']['create_time'] = time();
            $data['info']['update_time'] = time();
            if(isset($data['info']['isgourl']))
            {
                unset($data['info']['isgourl']);
            }else{
                $data['info']['gourl'] = '';
            }
            if(empty($data['info']['copyfrom']))
            {
                $data['info']['copyfrom'] = '本站';
            }
            if(isset($data['info']['flag']))
            {
                $data['info']['flag'] = implode(',',$data['info']['flag']);
            }else{
                $data['info']['flag'] = '';
            }
            $id = $data['info']['id'];
            unset($data['info']['id']);
            $oldcatid = intval($data['info']['oldcatid']);
            unset($data['info']['oldcatid']);

            //[--start::更新文章{业务逻辑}--]
            $this->ContentBusiness = $this->loader->model(ContentBusiness::class,$this);
            $r = yield $this->ContentBusiness->content_edit($id,$data['info'],$oldcatid);
            if($r)
            {
                parent::httpOutputEnd('内容更新成功.','内容更新失败.',$r);
            }else{
                parent::httpOutputTis('ContentModel编辑请求失败.');
            }
            //[--end::更新文章{业务逻辑}--]
        }else{
            $id = $this->http_input->get('id');
            $this->ContentModel =  $this->loader->model(ContentModel::class,$this);
            $d = yield $this->ContentModel->getById($id);

            if($id && $d)
            {
                //自动选择分类
                $this->CategoryBusiness =  $this->loader->model(CategoryBusiness::class,$this);
                $selectCategorys= yield  $this->CategoryBusiness->get_category_by_parentid(intval($d['catid']));
                parent::templateData('d_content_model',$d);
                parent::templateData('selectCategorys',$selectCategorys);
                parent::templateData('token',token('__CONTENT_EDIT__'));
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
        if($this->http_input->getRequestMethod()=='POST')
        {
            //查找对应文章，验证是否存在
            $id = $this->http_input->postGet('id');
            $this->ContentModel =  $this->loader->model(ContentModel::class,$this);
            $d = yield $this->ContentModel->getById(intval($id));
            if($id && $d)
            {
                //[--start::删除文章{业务逻辑}--]
                $this->ContentBusiness = $this->loader->model(ContentBusiness::class,$this);
                $r = yield $this->ContentBusiness->delete_by_id_and_catid($id,$d['catid']);
                if($r)
                {
                    parent::httpOutputEnd('文章删除成功.','文章删除失败.',$r);
                }else{
                    parent::httpOutputTis('ContentBusiness请求失败.');
                }
                //[--end::删除文章{业务逻辑}--]
            }else{
                parent::httpOutputTis('id参数错误，或数据不存在.');
            }
        }else{
            parent::httpOutputTis('非法请求.');
        }
    }



    private function _check_title(){

    }



}
