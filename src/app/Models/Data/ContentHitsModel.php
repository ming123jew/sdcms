<?php
/**
 * Created by PhpStorm.
 * User: zhangjincheng
 * Date: 16-7-15
 * Time: 下午1:44
 */

namespace app\Models\Data;


class ContentHitsModel extends BaseModel
{

    /**
     * 数据库表名称，不包含前缀
     * @var string
     */
    private $table = 'content_hits';


    public function getTable()
    {
        return $this->prefix.$this->table;
    }

    /**
     * 获取所有
     * @return bool
     */
    public function getAll()
    {
        $r = yield $this->mysql_pool->dbQueryBuilder->from($this->prefix.$this->table)
            ->orderBy('content_id','asc')
            ->select('*')
            ->coroutineSend();
        if(empty($r['result'])){
            return false;
        }else{
            return $r['result'] ;
        }
    }

    /**
     * @param int $role_id
     * @return bool
     */
    public function getByContentId(int $content_id,$fields='*')
    {
        $r = yield $this->mysql_pool->dbQueryBuilder->from($this->prefix.$this->table)
            ->where('content_id',$content_id)
            ->select($fields)
            ->coroutineSend();
        if(empty($r['result'])){
            return false;
        }else{
            return $r['result'][0] ;
        }
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteByContentId(int $content_id,$transaction_id=null)
    {
        $r = yield $this->mysql_pool->dbQueryBuilder->from($this->prefix.$this->table)
            ->where('content_id',$content_id)->delete()->coroutineSend($transaction_id);
        //print_r($r);
        if(empty($r['result'])){
            return false;
        }else{
            return $r['result'] ;
        }
    }

    /**
     * 插入多条数据
     * @param array $arr
     * @return bool
     */
    public function insertMultiple( array $intoColumns,array $intoValues,$transaction_id=null )
    {
        //原生sql执行
//        $sql = 'INSERT INTO '.$this->prefix.$this->table.'(role_id,m,c,a,menu_id) VALUES';
//        foreach ($arr as $key=>$value){
//            $sql .= '("'.$value[0].'","'.$value[1].'","'.$value[2].'","'.$value[3].'","'.$value[4].'"),';
//        }
//        $sql = substr($sql,0,-1);
//        $r = yield $this->mysql_pool->dbQueryBuilder->coroutineSend(null, $sql);
        $r = yield $this->mysql_pool->dbQueryBuilder->insertInto($this->prefix.$this->table)
            ->intoColumns($intoColumns)
            ->intoValues($intoValues)
            ->coroutineSend($transaction_id);
        //print_r($r);
        if(empty($r['result']))
        {
            return false;
        }else{
            return $r['result'] ;
        }
    }


    /**
     * 根据ID更新单条
     * @param int $content_id
     * @param array $columns_values
     * @return bool
     */
    public function updateByContentId(int $content_id,array $columns_values,$transaction_id=null)
    {
        $r = yield $this->mysql_pool->dbQueryBuilder->update($this->prefix.$this->table)
            ->set($columns_values)
            ->where('content_id',$content_id)
            ->coroutineSend($transaction_id);
        //print_r($r);
        if(empty($r['result']))
        {
            return false;
        }else{
            return $r['result'] ;
        }
    }


    /**
     * 更新点击
     * @param int $content_id
     * @param array $sel
     * @return bool
     */
    public function updateHits(int $content_id,array $sel=array())
    {
        $curren_time = time();
        if(!$sel)
        {
            $r = yield self::getByContentId($content_id);
        }else{
            $r = $sel;
        }
        $views = $r['views'] + 1;
        $yesterdayviews = (date('Ymd', $r['updatetime']) == date('Ymd', strtotime('-1 day'))) ? $r['dayviews'] : $r['yesterdayviews'];
        $dayviews = (date('Ymd', $r['updatetime']) == date('Ymd', $curren_time)) ? ($r['dayviews'] + 1) : 1;
        $weekviews = (date('YW', $r['updatetime']) == date('YW', $curren_time)) ? ($r['weekviews'] + 1) : 1;
        $monthviews = (date('Ym', $r['updatetime']) == date('Ym', $curren_time)) ? ($r['monthviews'] + 1) : 1;
        $arr_update = array('views'=>$views,'yesterdayviews'=>$yesterdayviews,'dayviews'=>$dayviews,'weekviews'=>$weekviews,'monthviews'=>$monthviews,'updatetime'=>$curren_time);
        $r = yield self::updateByContentId($content_id,$arr_update);

        if($r==false)
        {
            return false;
        }else{
            return $r;
        }
    }

    /**
     * 更新点赞
     * @param int $content_id
     * @param array $sel
     * @return array|bool
     */
    public function updatePraise(int $content_id,array $sel=array())
    {
        if(!$sel)
        {
            $r = yield self::getByContentId($content_id);
        }else{
            $r = $sel;
        }
        $arr_update = [ 'praise'=> ($r['praise']+1) ];
        $r = yield self::updateByContentId($content_id,$arr_update);

        if($r==false)
        {
            return false;
        }else{
            return $r;
        }
    }

}