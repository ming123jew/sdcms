<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-3-22
 * Time: 17:54
 * Desc: 添加&更新文章逻辑
 */
namespace app\Models\Business;
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


    public function get_new_contents(int $catid=0,int $limit=8,bool $cache=true,int $expire=24*3600)
    {

    }

    public function get_hot(int $catid=0,int $limit=8,bool $cache=true,int $expire=24*3600)
    {

    }

    public function get_commend(int $catid=0,int $limit=8,bool $cache=true,int $expire=24*3600)
    {

    }

    public function get_comment(int $catid=0,int $limit=8,bool $cache=true,int $expire=24*3600)
    {

    }

    public function get_recorded(int $catid=0,int $limit=8,bool $cache=true,int $expire=24*3600)
    {

    }
}