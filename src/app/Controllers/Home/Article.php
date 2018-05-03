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

            $this->Model['HomeBusiness'] = $this->loader->model(HomeBusiness::class,$this);
            //[读取内容+点击+更新点击:start]
            $d = yield $this->Model['HomeBusiness']->get_article($id);
            //[读取内容+点击+更新点击:end]

            //获取对应的栏目名称
            $d['catname'] = yield get_catname_by_catid( $d['catid'],$this);

            //[获取推荐:start]
            $d_get_recommend = yield $this->Model['HomeBusiness']->get_recommend();
            //[获取推荐:end]

            //[获取最新评论:start]
            $d_get_new_comment = yield $this->Model['HomeBusiness']->get_new_comment();
            //[获取最新评论:end]

            $d['body'] = htmlspecialchars_decode($d['body']);
            parent::templateData('article',$d);
            //print_r($d);

            parent::templateData('d_get_recommend',$d_get_recommend);
            parent::templateData('d_get_new_comment',$d_get_new_comment);
            $date = date('Y-m-d');
            parent::templateData('date',$date.' '.get_week($date));

            unset($id,$d,$d_get_recommend,$d_get_new_comment,$date);
            //web or app
            parent::webOrApp(function (){
                $template = $this->loader->view('app::Home/article_read');
                $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']),false);
            });
        }else{
            unset($id);
            parent::httpOutputTis('参数错误.');
        }

    }

    /**
     * 栏目列表
     */
    public function http_list()
    {
        $catid = intval( $this->http_input->postGet('id') );
        if($catid>0)
        {
            //获取栏目最新信息
            $category = yield get_catname_by_catid($catid,$this,'*');
            $p = intval( $this->http_input->postGet('p') );
            if($p == 0) {$p = 1;}
            $end = 10;
            $start = ($p-1)*$end;
            $this->Model['HomeBusiness'] = $this->loader->model(HomeBusiness::class,$this);
            //[获取分类最新文章:start]
            $d_get_new = yield $this->Model['HomeBusiness']->get_new($catid,$start,$end);
            //[获取分类最新文章:end]
            //[获取推荐:start]
            $d_get_recommend = yield $this->Model['HomeBusiness']->get_recommend();
            //[获取推荐:end]
            //[获取最新评论:start]
            $d_get_new_comment = yield $this->Model['HomeBusiness']->get_new_comment();
            //[获取最新评论:end]

            parent::templateData('category',$category);
            parent::templateData('d_get_new',$d_get_new['result']);
            parent::templateData('page_d_get_new',page_bar($d_get_new['num'],$p,10,5,$this));
            parent::templateData('d_get_recommend',$d_get_recommend);
            parent::templateData('d_get_new_comment',$d_get_new_comment);

            $date = date('Y-m-d');
            parent::templateData('date',$date.' '.get_week($date));

            unset($catid,$category,$p,$start,$end,$d_get_new,$d_get_recommend,$d_get_new_comment);
            //web or app
            parent::webOrApp(function (){
                $template = $this->loader->view('app::Home/article_list');
                $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
            });
        }else{
            unset($catid);
            parent::httpOutputTis('参数错误.');
        }

    }

    /**
     * 单页
     */
    public function http_page()
    {

    }

    /**
     * 点赞
     */
    public function http_praise()
    {
        $content_id = intval( $this->http_input->postGet('id') );
        $praise = intval( $this->http_input->postGet('praise') );
        if($content_id>0){
            $this->Model['ContentHitsModel'] = $this->loader->model(ContentHitsModel::class,$this);
            $r = yield $this->Model['ContentHitsModel']->updatePraise($content_id,['praise'=>$praise]);
            unset($content_id,$praise);
            parent::httpOutputEnd('点赞成功.','点赞失败',$r);
        }else{
            unset($content_id,$praise);
            parent::httpOutputTis('参数错误.');
        }
    }

    /**
     * 发表评论
     */
    public function http_comment()
    {
        $content_id = intval( $this->http_input->postGet('content_id') );
        $catid = intval( $this->http_input->postGet('catid') );
        if($this->http_input->getRequestMethod()=='POST' && $content_id>0)
        {
            $session_user = $this->get_login_session();
            if($session_user){
                $uid = $session_user['id'];
                $username =  $session_user['username'];
                $email =  $session_user['email'];
            }else{
                $uid = 0;
                $username = $this->http_input->postGet('username');
                $email = $this->http_input->postGet('email');
            }

            $title = $this->http_input->postGet('title');
            $content = $this->http_input->postGet('content');
            $data = [
                'content_id'=>$content_id,
                'content'=>strip_tags($content),
                'title'=>$title,
                'create_time'=>time(),
                'username'=>strip_tags($username),
                'uid'=>$uid,
                'email'=>$email,
                'catid'=>$catid
            ];
            if(empty($data['content'])||empty($data['username']))
            {
                unset($content_id,$catid,$data,$title,$content,$session_user,$uid,$username,$email);
                $this->httpOutputTis('请输入用户名、邮箱、评论内容.');
            }else{
                $this->Model['ContentCommentModel'] = $this->loader->model(ContentCommentModel::class,$this);
                $r = yield $this->Model['ContentCommentModel']->insertMultiple(array_keys($data),array_values($data));
                unset($content_id,$catid,$data,$title,$content,$session_user,$uid,$username,$email);
                parent::httpOutputEnd('评论成功.','评论失败',$r);
            }
        }else{
            unset($content_id,$catid);
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
            $this->Model['ContentCommentModel'] = $this->loader->model(ContentCommentModel::class,$this);
            $r = yield $this->Model['ContentCommentModel']->getAllByPage($content_id,$start,$end);
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
            unset($content_id,$p,$start);
            parent::httpOutputEnd('获取评论成功.','获取评论失败',$r,$end);

        }else{
            unset($content_id);
            $this->httpOutputTis('非法请求.');
        }
    }

}