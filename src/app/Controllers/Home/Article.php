<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-4-12
 * Time: 15:23
 */

namespace app\Controllers\Home;
use app\Models\Business\HomeBusiness;
use app\Models\Data\ContentCommentModel;
use app\Models\Data\ContentHitsModel;

class Article extends Base
{

    protected $HomeBusiness;
    protected $ContentHitsModel;
    protected $ContentCommentModel;

    protected function initialization($controller_name, $method_name)
    {
        parent::initialization($controller_name, $method_name);

    }


    /**
     * 读取文章
     */
    public function http_read()
    {
        $id = intval( $this->http_input->postGet('id') );
        if($id>0){

            $this->HomeBusiness = $this->loader->model(HomeBusiness::class,$this);
            //[读取内容+点击+更新点击:start]
            $d = yield $this->HomeBusiness->get_article($id);
            //[读取内容+点击+更新点击:end]

            //获取对应的栏目名称
            $d['catname'] = yield get_catname_by_catid( $d['catid'],$this);

            //[获取推荐:start]
            $d_get_recommend = yield $this->HomeBusiness->get_recommend();
            //[获取推荐:end]
            $d['body'] = htmlspecialchars_decode($d['body']);
            parent::templateData('article',$d);
            //print_r($d);
            parent::templateData('d_get_recommend',$d_get_recommend);
            //web or app
            parent::webOrApp(function (){
                $template = $this->loader->view('app::Home/content');
                $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']),false);
            });
        }else{
            parent::httpOutputTis('参数错误.');
        }

    }

    /**
     * 栏目列表
     */
    public function http_list()
    {
        parent::templateData('test',1);
        //web or app
        parent::webOrApp(function (){
            $template = $this->loader->view('app::Home/article_list');
            $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
        });
    }

    /**
     * 点赞
     */
    public function http_praise()
    {
        $content_id = intval( $this->http_input->postGet('id') );
        $praise = intval( $this->http_input->postGet('praise') );
        if($content_id>0){
            $this->ContentHitsModel = $this->loader->model(ContentHitsModel::class,$this);
            $r = yield $this->ContentHitsModel->updatePraise($content_id,['praise'=>$praise]);
            if($r)
            {
                parent::httpOutputEnd('点赞成功.','点赞失败',$r);
            }else{
                parent::httpOutputEnd('点赞成功.','点赞失败',$r);
            }
        }else{
            parent::httpOutputTis('参数错误.');
        }
    }

    /**
     * 发表评论
     */
    public function http_comment()
    {
        $content_id = intval( $this->http_input->postGet('content_id') );
        if($this->http_input->getRequestMethod()=='POST' && $content_id>0)
        {
            $uid = 0;
            $title = $this->http_input->postGet('title');
            $content = $this->http_input->postGet('content');
            $username = $this->http_input->postGet('username');
            $email = $this->http_input->postGet('email');
            $data = [
                'content_id'=>$content_id,
                'content'=>strip_tags($content),
                'title'=>$title,
                'create_time'=>time(),
                'username'=>strip_tags($username),
                'uid'=>$uid,
                'email'=>$email
            ];
            if(empty($data['content'])||empty($data['username']))
            {
                $this->httpOutputTis('请输入用户名、邮箱、评论内容.');
            }else{
                $this->ContentCommentModel = $this->loader->model(ContentCommentModel::class,$this);
                $r = yield $this->ContentCommentModel->insertMultiple(array_keys($data),array_values($data));
                if($r)
                {
                    parent::httpOutputEnd('评论成功.','评论失败',$r);
                }else{
                    parent::httpOutputEnd('评论成功.','评论失败',$r);
                }
            }

        }else{
            $this->httpOutputTis('非法请求.');
        }
    }

    /**
     * 获取评论
     */
    public function http_get_comment()
    {
        $content_id = intval( $this->http_input->postGet('content_id') );
        if($this->http_input->getRequestMethod()=='POST' && $content_id>0)
        {
            $p = intval( $this->http_input->postGet('p') );
            if($p == 0) {$p = 1;}
            $end = 10;
            $start = ($p-1)*$end;
            $this->ContentCommentModel = $this->loader->model(ContentCommentModel::class,$this);
            $r = yield $this->ContentCommentModel->getAllByPage($start,$end);
            if($r)
            {
                $end = [
                    'status' => 1,
                    'code'=>200,
                    'message'=>'list',
                    'data'=>$r['result']
                ];
            }else{
                $end = [];
            }
            parent::httpOutputEnd('获取评论成功.','获取评论失败',$r,$end);

        }else{
            $this->httpOutputTis('非法请求.');
        }
    }

}