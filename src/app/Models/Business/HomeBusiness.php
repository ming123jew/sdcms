<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-3-22
 * Time: 17:54
 * Desc: 添加&更新文章逻辑
 */
namespace app\Models\Business;
use app\Models\Data\ContentCommentModel;
use app\Models\Data\ContentModel;
use app\Models\Data\ContentHitsModel;
use app\Models\Data\TagsModel;
use app\Models\Data\CategoryModel;
use app\Helpers\ChinesePinyin;

class HomeBusiness extends BaseBusiness
{
    protected $ContentModel;
    protected $ContentHitsModel;
    protected $CategoryModel;
    protected $TagsModel;
    protected $ContentCommentModel;


    /**
     * 获取幻灯{flag字段包含p}
     * @param string $flag
     * @param int $start
     * @param int $end
     * @param int $catid
     * @param int $status
     * @param string $fields
     * @param bool $cache
     * @param int $expire
     * @return bool
     */
    public function get_slide(string $flag='p',int $start=0,int $end=3,int $catid=0,int $status=0,$fields='*',bool $cache=true,int $expire=24*3600)
    {
        $this->ContentModel =  $this->loader->model(ContentModel::class,$this);
        $d = yield $this->ContentModel->getByFlag($flag,$start,$end,$catid,$status,$fields);
        if($d!=false){
            return $d;
        }else{
            return false;
        }
    }

    /**
     * 获取推荐
     * @param string $flag
     * @param int $start
     * @param int $end
     * @param int $catid
     * @param int $status
     * @param string $fields
     * @param bool $cache
     * @param int $expire
     * @return bool
     */
    public function get_recommend(string $flag='r',int $start=0,int $end=9,int $catid=0,int $status=0,$fields='*',bool $cache=true,int $expire=24*3600)
    {
        $this->ContentModel =  $this->loader->model(ContentModel::class,$this);
        $d = yield $this->ContentModel->getByFlag($flag,$start,$end,$catid,$status,$fields);
        if($d!=false){
            return $d;
        }else{
            return false;
        }
    }

    /**
     * 获取最新文章，带分页
     * @param int $catid
     * @param int $start
     * @param int $end
     * @param int $status
     * @param string $fields
     * @param bool $cache
     * @param int $expire
     * @return bool
     */
    public function get_new(int $catid=0,int $start=0,int $end=9,int $status=0,$fields='*',bool $cache=true,int $expire=24*3600)
    {
        $this->ContentModel =  $this->loader->model(ContentModel::class,$this);
        $d = yield $this->ContentModel->getNew($catid,$start,$end);
        if($d!=false){
            return $d;
        }else{
            return false;
        }
    }

    /**
     * 热门文章
     * @param int $catid
     * @param int $limit
     * @param bool $cache
     * @param int $expire
     */
    public function get_hot(int $catid=0,int $limit=8,bool $cache=true,int $expire=24*3600)
    {

    }


    /**
     * 获取评论
     * @param int $catid
     * @param int $start
     * @param int $end
     * @param bool $cache
     * @param int $expire
     * @return bool
     */
    public function get_new_comment(int $catid=0,int $start=0,int $end=9,bool $cache=true,int $expire=24*3600)
    {
        $this->ContentCommentModel =  $this->loader->model(ContentCommentModel::class,$this);
        $d = yield $this->ContentCommentModel->get_new_comment($catid,$start,$end);
        if($d!=false){
            return $d;
        }else{
            return false;
        }
    }

    /**
     * 获取语录
     * @param int $catid
     * @param int $limit
     * @param bool $cache
     * @param int $expire
     */
    public function get_recorded(int $catid=0,int $limit=8,bool $cache=true,int $expire=24*3600)
    {

    }

    /**
     * 文章内页
     * 获取文章内容+点击+更新点击
     * @param int $content_id
     * @return bool
     */
    public function get_article(int $content_id)
    {
        $this->ContentModel =  $this->loader->model(ContentModel::class,$this);
        //获取内容
        $d = yield $this->ContentModel->getArticle($content_id);
        //获取上下篇
        $d['prev'] = '最前一篇';
        $d['next'] = '最后一篇';
        $d_prev_next = yield $this->ContentModel->getArticlePrevNext($d['id'],$d['catid']);
        foreach ($d_prev_next as $k=>$v)
        {
            if($v['flag']=='prev')
            {
                if($v)
                {
                    $d['prev'] = '<a href="'.url('','','read',['id'=>$v['id']]).'" rel="prev">'.$v['title'].'</a>';
                } else {
                    $d['prev'] = '最前一篇';
                }

            }else if($v['flag']=='next')
            {
                if($v)
                {
                    $d['next'] = '<a href="'.url('','','read',['id'=>$v['id']]).'" rel="next">'.$v['title'].'</a>';
                } else {
                    $d['next'] = '最后一篇';
                }
            }
        }
        //更新点击
        $this->ContentHitsModel = $this->loader->model(ContentHitsModel::class,$this);
        $d_ContentHitsModel = yield $this->ContentHitsModel->updateHits($content_id,$d);

        if($d!=false&&$d_ContentHitsModel!=false){
            return $d;
        }else{
            return false;
        }
    }

}