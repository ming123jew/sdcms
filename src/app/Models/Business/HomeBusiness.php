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


    public function get_new_contents()
    {

    }

    public function get_hot()
    {

    }

    public function get_commend()
    {

    }

    public function get_comment()
    {

    }

    public function get_recorded()
    {

    }
}