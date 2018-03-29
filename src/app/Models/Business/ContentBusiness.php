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

class ContentBusiness extends BaseBusiness
{
    protected $ContentModel;
    protected $ContentHitsModel;
    protected $CategoryModel;
    protected $TagsModel;
    /**
     * 文章插入{整个逻辑}
     * @param array $data
     * @return bool|\Generator
     */
    public function content_add(array $data)
    {
        //[--start::开始更新操作，执行事务--]
        $transaction_id = yield $this->mysql_pool->coroutineBegin($this);
        //[--start::更新主表--]
        $this->ContentModel =  $this->loader->model(ContentModel::class,$this);
        $r_content_model = yield $this->ContentModel->insertMultiple(array_keys($data),array_values($data),$transaction_id);
        //[--end::更新主表--]

        //[--start::插入统计表--]
        $this->ContentHitsModel =  $this->loader->model(ContentHitsModel::class,$this);
        $r_content_hits_model = yield $this->ContentHitsModel->insertMultiple(['content_id','catid','updatetime'],[$r_content_model['insert_id'],$data['catid'],time()],$transaction_id);
        //[--end::插入统计表--]

        //[--start::更新栏目数据arc_count--]
        $this->CategoryModel = $this->loader->model(CategoryModel::class,$this);
        $r_category_model = yield $this->CategoryModel->setInc($data['catid'],'arc_count',1,$transaction_id);
        //[--end::更新栏目数据arc_count--]

        //[--start::插入标签表--]
        if(!empty($data['keywords']))
        {
            $arr_tags = explode(' ',str_replace(',',' ',$data['keywords']));
            $pinyin = new ChinesePinyin();
            foreach ($arr_tags as $key=>$value)
            {
                $tags[$key]['title'] = $value;
                $tags[$key]['content_id'] = $r_content_model['insert_id'];
                $tags[$key]['ucwords'] = substr($pinyin->TransformUcwords($value),0,1);
            }
            //print_r(array_values($tags));
            $this->TagsModel = $this->loader->model(TagsModel::class,$this);
            $r_tags_model = yield $this->TagsModel->insertMultiple(array_keys($tags[0]),array_values($tags),$transaction_id);
        }
        //[--end::插入标签表--]

        if(!$r_content_model&&!$r_content_hits_model&&!$r_category_model&&!$r_category_model&&!$r_tags_model)
        {
            yield $this->mysql_pool->coroutineRollback($transaction_id);
            return false;
        }else{
            yield $this->mysql_pool->coroutineCommit($transaction_id);
            return $r_content_model;
        }
        //[--end::开始更新操作，执行事务--]
    }

    /**
     * 文章更新{整个逻辑}
     * @param int $id        文章ID
     * @param array $data    数组
     * @param int $oldcatid  旧栏目catid
     * @return bool|\Generator
     */
    public function content_edit(int $id,array $data,int $oldcatid=0)
    {
        //[--start::开始更新操作，执行事务--]
        $transaction_id = yield $this->mysql_pool->coroutineBegin($this);

        //[--start::更新主表--]
        $this->ContentModel =  $this->loader->model(ContentModel::class,$this);
        $r_content_model = yield $this->ContentModel->updateById($id,$data,$transaction_id);
        //[--end::更新主表--]

        //[--start::分类改变，更新统计表catid，更新栏目数据arc_count--]
        if($oldcatid!=0 && $oldcatid!=$data['catid'])
        {
            //更新统计表
            $this->ContentHitsModel =  $this->loader->model(ContentHitsModel::class,$this);
            $r_content_hits_model = yield $this->ContentHitsModel->updateByContentId($id,['catid'=>$data['catid']],$transaction_id);
            //更新栏目数据arc_count
            $this->CategoryModel =  $this->loader->model(CategoryModel::class,$this);
            $r_category_model_1 = yield $this->CategoryModel->setInc($data['catid'],'arc_count',1,$transaction_id);
            $r_category_model_2 = yield $this->CategoryModel->setDec($oldcatid,'arc_count',1,$transaction_id);
        }else{
            $r_content_hits_model = $r_category_model_1 = $r_category_model_2 = true;
        }
        //[--end::分类改变，更新统计表catid，更新栏目数据arc_count--]

        //[--start::更新标签表--]
        if(!empty($data['keywords']))
        {
            $arr_tags = explode(' ', str_replace(',', ' ', $data['keywords']));
            $pinyin = new ChinesePinyin();
            foreach ($arr_tags as $key => $value)
            {
                $tags[$key]['title'] = $value;
                $tags[$key]['content_id'] = $id;
                $tags[$key]['ucwords'] = substr($pinyin->TransformUcwords($value), 0, 1);
            }
            $this->TagsModel =  $this->loader->model(TagsModel::class,$this);
            //先删除标签数据
            $r_tags_model_1 = yield $this->TagsModel->deleteByContentId($id);
            //再重新插入数据
            $r_tags_model_2 = yield $this->TagsModel->insertMultiple(array_keys($tags[0]),array_values($tags),$transaction_id);
        }else{
            $r_tags_model_1 = $r_tags_model_2 =  true;
        }
        //[--end::更新标签表--]

        if(!$r_content_model&&!$r_content_hits_model&&!$r_category_model_1&&!$r_category_model_2&&!$r_tags_model_1&&!$r_tags_model_2)
        {
            yield $this->mysql_pool->coroutineRollback($transaction_id);
            return false;
        }else{
            yield $this->mysql_pool->coroutineCommit($transaction_id);
            return $r_content_model;
        }
        //[--end::开始更新操作，执行事务--]
    }

    /**
     * 删除文章{整个逻辑}
     * @param int $id
     * @param int $catid
     * @return bool|\Generator
     */
    public function delete_by_id_and_catid(int $id,int $catid){
        //[--start::开始删除操作，执行事务--]
        $transaction_id = yield $this->mysql_pool->coroutineBegin($this);
        //[--start::删除主表]
        $this->ContentModel =  $this->loader->model(ContentModel::class,$this);
        $r_content_model = yield $this->ContentModel->deleteById($id,$transaction_id);
        //[--end::删除主表]

        //[--start::删除统计表]
        $this->ContentHitsModel =  $this->loader->model(ContentHitsModel::class,$this);
        $r_content_hits_model = yield $this->ContentHitsModel->deleteByContentId($id,$transaction_id);
        //[--end::删除统计表]

        //[--start::删除标签表]
        $this->TagsModel =  $this->loader->model(TagsModel::class,$this);
        $r_tags_model = yield $this->TagsModel->deleteByContentId($id,$transaction_id);
        //[--end::删除标签表]

        //[--start::更新栏目数据]
        $this->CategoryModel =  $this->loader->model(CategoryModel::class,$this);
        $r_category_model = yield $this->CategoryModel->setDec($catid,'arc_count',1,$transaction_id);
        //[--end::更新栏目数据]

        if(!$r_content_model&&!$r_content_hits_model&&!$r_category_model&&!$r_tags_model)
        {
            yield $this->mysql_pool->coroutineRollback($transaction_id);
            return false;
        }else{
            yield $this->mysql_pool->coroutineCommit($transaction_id);
            return $r_content_model;
        }
        //[--end::开始删除操作，执行事务--]
    }
}