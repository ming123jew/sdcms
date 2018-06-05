<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2017-11-15
 * Time: 15:24
 */
use app\Helpers\Sessions\Session;
use app\Controllers;
use Server\Memory\Cache;
use Server\Components\CatCache\CatCacheRpcProxy;

function Test()
{
    return 'test_123';
}

/**
 * Session管理 | 旧版
 * @param string|array  $name session名称，如果为数组表示进行session设置
 * @param mixed         $value session值
 * @param null $prefix  $prefix 前缀
 * @return bool|mixed|void
 * @throws Exception
 */
function session($name, $value = '', $prefix = null)
{
    if (is_array($name))
    {
        // 初始化
        Session::init($name);
    } elseif (is_null($name)) {
        // 清除
        Session::clear('' === $value ? null : $value);
    } elseif ('' === $value) {
        // 判断或获取
        return 0 === strpos($name, '?') ? Session::has(substr($name, 1), $prefix) : Session::get($name, $prefix);
    } elseif (is_null($value)) {
        // 删除
        return Session::delete($name, $prefix);
    } else {
        // 设置
        return Session::set($name, $value, $prefix);
    }
}

function sessions($context,$name, $value = '', $prefix = null){

    if($context==''){
        return false;
    }else{
        $sessions = \app\Helpers\Sessions\Sessions::getInstance($context);
        //$sessions = new app\Helpers\Sessions\Sessions($context);
        $sessions->Start();
        if($value===''){
            // 判断或获取
            $return = 0 === strpos($name, '?') ? $sessions->Has($name,$prefix) : $sessions->Get($name,$prefix);
        }elseif (is_null($value)) {
            // 删除
            $return = $sessions->Del($name,$prefix);
        } else {
            // 设置
            $return = $sessions->Set($name,$value,$prefix);
        }
        $sessions->Save();
        //print_r($sessions->getAllKeys());
        return $return;
    }
}

/**
 * 生成url{全局助手函数}
 * @param string $module
 * @param string $controller
 * @param string $action
 * @param string $params
 * @return string
 */
function url($module='',$controller='',$action='', $params='')
{
    $host = Controllers\BaseController::$Host2;
    if(empty($module))
    {
        $module = Controllers\BaseController::$ModuleName2;
    }
    if(empty($controller))
    {
        $controller = Controllers\BaseController::$ControllerName2;
    }
    if(empty($action))
    {
        $action = Controllers\BaseController::$ActionName2;
    }
    $url = $module.'/'.$controller.'/'.$action;
    //print_r($url);
    // 解析参数
    if (is_string($params))
    {
        // aaa=1&bbb=2 转换成数组
        parse_str($params, $params);
    }
    $url .= '?';
    if(is_array($params))
    {
        foreach ($params as $key=>$value)
        {
            if ('' !== trim($value))
            {
                $url .=  $key . '=' . urlencode($value).'&';
            }
        }
    }

    $url = $host.substr($url,0,-1);
    $end = $url;
    unset($module,$controller,$action,$params,$host,$key,$value,$url);
    return  $end;

}

/**
 * 生成请求令牌{全局助手函数}
 * @param string $name
 * @param string $type
 * @param bool $is_ajax
 * @return mixed
 * @throws Exception
 */
function token($name = '__token__', $type = 'md5', $is_ajax=false)
{
    $type  = is_callable($type) ? $type : 'md5';
    $token = call_user_func($type, $_SERVER['REQUEST_TIME_FLOAT']);
    if ($is_ajax)
    {
        header($name . ': ' . $token);
    }
    Session::set($name, $token);
    unset($name,$type,$is_ajax);
    return $token;
}


/**
 * 设置缓存{全局助手函数}
 * @param $key
 * @param $value
 * @param float|int $expire
 * @return Generator
 */
function set_cache($key,$value,$expire=24*3600)
{

    $data = [
        'data'=>$value,
        'create_time'=>time(),
        'expire_time'=>$expire
    ];

    if(empty($value)||is_null($value)){
        yield CatCacheRpcProxy::getRpc()->offsetUnset($key);
    }else{
        yield CatCacheRpcProxy::getRpc()->offsetSet($key,$data);
    }
    unset($value,$expire);

}

/**
 * 获取缓存{全局助手函数}
 * @param $key
 * @param string $type
 * @return bool|Generator
 */
function get_cache($key,$type="data")
{
    $result = yield CatCacheRpcProxy::getRpc()->offsetExists($key);
    if($result)
    {
        $result =  yield CatCacheRpcProxy::getRpc()->offsetGet($key);
        //判断是否过期
        //print_r($result);
        if(time() - $result['create_time']>$result['expire_time'])
        {
            yield CatCacheRpcProxy::getRpc()->offsetUnset($key);
            $result = false;
        }
    }else{
        $result = false;
    }
    if($type)
    {
        return $result[$type];
    }else{
        unset($type);
        return $result;
    }
}

/**
 * 获取星期几
 * @param $date
 * @return mixed
 */
function get_week($date){
    //强制转换日期格式
    $date_str=date('Y-m-d',strtotime($date));
    //封装成数组
    $arr=explode("-", $date_str);
    //参数赋值
    //年
    $year=$arr[0];
    //月，输出2位整型，不够2位右对齐
    $month=sprintf('%02d',$arr[1]);
    //日，输出2位整型，不够2位右对齐
    $day=sprintf('%02d',$arr[2]);
    //时分秒默认赋值为0；
    $hour = $minute = $second = 0;
    //转换成时间戳
    $strap = mktime($hour,$minute,$second,$month,$day,$year);
    //获取数字型星期几
    $number_wk=date("w",$strap);
    //自定义星期数组
    $weekArr=array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
    //获取数字对应的星期
    unset($date,$date_str,$arr,$year,$month,$day,$hour,$strap);
    return $weekArr[$number_wk];
}

/**
 * 锁操作
 * @param string $type  file|sync_mutex|redis
 * @param $callback     锁获取成功进行的操作
 * @param $callback2    锁获取失败进行的操作
 * @return Generator
 */
function lock($type="file",$callback,$callback2){
    //检测是否有sync扩展
    if($type=='sync_mutex'&&!class_exists('SyncMutex')){
        $type = 'redis';
    }
    switch ($type){
        case 'file':
            $fp = fopen(BIN_DIR.'/lock', "w+");
            if(is_file(BIN_DIR.'/lock')&&flock($fp,LOCK_EX | LOCK_NB)) {
                echo BIN_DIR.'/lock';
                //..处理订单
                call_user_func($callback);
                yield sleepCoroutine(5000);
                flock($fp,LOCK_UN);
                fclose($fp);
                //print_r("unlock ok.");
            } else {
                call_user_func($callback2);
            }
            break;
        case 'sync_mutex':
            $mutex = new SyncMutex("lock");
            $res = $mutex->lock(0);
            if ($res){
                //echo "\nprocess  successfully got the mutex \n";
                call_user_func($callback);
                //模拟
                yield sleepCoroutine(5000);
                $mutex->unlock();
                //print_r("unlock ok.");
            }else{
                //echo "\nprocess  unable to lock mutex. \n";
                call_user_func($callback2);
            }
            break;

        case 'redis':
            $lock = yield get_instance()->redis_pool->getCoroutine()->set('lock',1,'NX','EX',3600);
            if($lock){
                call_user_func($callback);
                //模拟
                yield sleepCoroutine(5000);
                yield  get_instance()->redis_pool->getCoroutine()->del('lock');
                //print_r("unlock ok.");
            }else{
                call_user_func($callback2);
            }
            break;
    }
}


/**
 * 分页工具条
 * @param $total
 * @param $page
 * @param int $pageSize
 * @param int $showPage
 * @param null $context
 * @return string
 */
function page_bar($total,$page,$pageSize=10,$showPage=5,$context=null)
{    //第一个参数为表总数 第二个参数为每页显示几个
    if($total&&$context){
        $totalPage = ceil($total / $pageSize);    //获取总页数
        $pageOffset = ($showPage - 1) / 2;    //页码偏移量
        $return_url = function ($p,$context){
            if(strpos($context->Uri,'p=')!==false)
            {
                return preg_replace('/p=([\d]+)/', 'p=' . $p, $context->Uri);
            }else{

                if(strpos($context->Uri,'?')!==false)
                {
                    return $context->Uri.'&p='.$p;
                }else{
                    return $context->Uri.'?p='.$p;
                }
            }
        };
        $start = 1;    //开始页码
        $end = $totalPage;    //结束页码
        $pageBanner = <<<html
                            <div class="row DTTTFooter" style="margin-top: 25px;">
                                <div class="col-sm-6">
                                    <div style="display: none" class="dataTables_info" id="simpledatatable_info" role="alert" aria-live="polite" aria-relevant="all">
                                        Showing 21 to 25 of 25 entries
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="dataTables_paginate paging_bootstrap" id="simpledatatable_paginate">
                                        <ul class="pagination">
html;
        if($page > 1){
            $pageBanner .= "<li class='prev'><a href='".$return_url(($page - 1),$context)."'>Prev</a></li>";
            $pageBanner .= "<li class='prev'><a href='".$return_url(1,$context)."'>First</a></li>";
        }
        if($totalPage > $showPage){    //当总页数大于显示页数时
            if($page > $pageOffset + 1){    //当当前页大于页码偏移量+1时，也就是当页码为4时 开始页码1替换为...
                $pageBanner .= "...";
            }
            if($page > $pageOffset){        //当当前页大于页码偏移量时 开始页码变为当前页-偏移页码
                $start = $page - $pageOffset;
                $end = $totalPage > $page + $pageOffset ?  $page + $pageOffset : $totalPage;
                //如果当前页数+偏移量大于总页数 那么$end为总页数
            }else{
                $start = 1;
                $end = $totalPage > $showPage ? $showPage : $totalPage;
            }
            if($page + $pageOffset > $totalPage){
                $start = $start - ($page + $pageOffset - $end);
            }
        }
        for($i = $start ; $i <= $end ; $i++){    //循环出页码
            if($i == $page){
                $pageBanner .= "<li class='active'><a href='javascript:;'>".$i."</a></li>";
            }else{
                $pageBanner .= "<li><a href='".$return_url($i,$context)."'>".$i."</a></li>";

            }
        }
        if($totalPage > $showPage && $totalPage > $page + $pageOffset){    //当总页数大于页码显示页数时 且总页数大于当前页+偏移量
            $pageBanner .= "...";
        }
        if($page < $totalPage){
            $pageBanner .= "<li class='next'><a href='".$return_url(($page + 1),$context)."'>Next</a></li>";
            $pageBanner .= "<li><a href='".$return_url($totalPage,$context)."'>Last</a></li>";
        }
        $pageBanner .=<<<html
                                        </ul>
                                    </div>
                                </div>
                                <div style="display: none;"></div>
                            </div>
html;
        unset($total,$page,$pageSize,$showPage,$context,$totalPage,$pageOffset,$return_url,$start,$end,$i,$p);
        return  $pageBanner;
    }else{
        unset($total,$page,$pageSize,$showPage,$context);
        return '';
    }

}

/**
 * Curl版本post提交{全局助手函数}
 * 使用方法：
 * $post_string = "app=request&version=beta";
 * request_by_curl('http://facebook.cn/restServer.php',$post_string);
 */
function http_post_url($remote_server, array $params)
{
    $post_string = "{";
    foreach($params as $key => &$val)
    {
        $post_string .= '"'.$key .'":"'.$val .'",';
    }
    $post_string .= "}";

    //$post_string = substr($post_string,0,-1);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $remote_server);
    curl_setopt($ch, CURLOPT_POSTFIELDS,  $post_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "Ming123jew");
    //curl_setopt($ch, CURLOPT_HTTPHEADER, '');//设置HTTP头
    curl_setopt($ch, CURLOPT_POST, 1);//设置为POST方式
    $data = curl_exec($ch);
    curl_close($ch);
    unset($remote_server,$params,$ch,$key,$val,$post_string);
    return $data;
}

/**
 * 检查路由权限 | 预留  首先读取缓存，如不存在则读数据库
 * @param $m
 * @param $c
 * @param $a
 * @param $context
 * @param array $param
 * @return bool
 */
function check_role($m,$c,$a,$context,$param=[])
{
    $login_info = sessions($context,'__SESSION__ADMIN__');
    //print_r($login_info);
    $role_id = $login_info['roleid'];
    //cache存在内存泄漏
    //$cache = Cache::getCache('WebCache');
    //$role_id_priv =  unserialize($cache->getOneMap('__ROLEID__DATA__ADMIN__'.$role_id));
    //$role_id_priv = yield unserialize(get_cache('__ROLEID__DATA__ADMIN__'.$role_id));
    //var_dump($role_id_priv);
    $role_id_priv = false;
    if(!$role_id_priv)
    {
        //数据库查找
        $model = get_instance()->loader->model(\app\Models\Data\RolePrivModel::class,$context);
        $r =  yield $model->authRole($role_id,$m,$c,$a);
        //print_r('check_role from db \n;');

        if(!($r))
        {
            unset($m,$c,$a,$context,$param,$login_info,$role_id,$role_id_priv,$model,$r);
            return false;
        }else{
            unset($m,$c,$a,$context,$param,$login_info,$role_id,$role_id_priv,$model,$r);
           return true;
        }
    }else{
        //print_r("check_role from cache \n");
        //从缓存种查找
        $find = false;
        if(is_array($role_id_priv)&&!empty($role_id_priv))
        {
            foreach ($role_id_priv as $key=>$value)
            {
                if($m==$value['m']&&$c==$value['c']&&$a==$value['a'])
                {
                    $find = true;
                }
            }
        }
        unset($m,$c,$a,$context,$param,$login_info,$role_id,$role_id_priv,$key,$value);
        return $find;
    }
    //print_r($role_id_priv);
    unset($m,$c,$a,$context,$param,$login_info,$role_id,$role_id_priv);
    return false;
}

/**
 * 获取权限组对应名称
 * @param $roleid
 * @param $context  传入上下文
 * @param string $flag
 * @return bool
 */
function get_role_byid($roleid,$context,$flag='__CACHE_ROLE__')
{
    if($roleid&&$flag)
    {
        $cache = Cache::getCache('WebCache');
        $d = $cache->getOneMap($flag);
        if($d)
        {
            $all_role =  unserialize($d);
            print_r('role from cache.');
        }else{
            $m = get_instance()->loader->model(\app\Models\Data\RoleModel::class,$context);
            $d = yield $m->getAll();
            $all_role = $d;
            //存入缓存
            $cache->addMap($flag,serialize($d));
            print_r('role from db.');

        }
        $find = [];
        foreach ($all_role as $key=>$value)
        {
            if($roleid==$value['id'])
            {
                $find = $value;
            }else{
                continue;
            }
        }
        unset($roleid,$context,$flag,$cache,$d,$all_role,$m,$d,$key,$value);
        return $find;
    }
    return false;
}

/**
 * 获取文章模型ID
 * @param $model_id
 * @return string
 */
function get_modelname_bymodelid($model_id)
{
    $return = '';
    switch ($model_id)
    {
        case 1:
            $return = "文章模型";break;
        case 2:
            $return = "";break;
    }
    unset($model_id);
    return $return;
}

/**
 * 获取文章栏目类型
 * @param $model_id
 * @return string
 */
function get_cattype_bymodelid($model_id)
{
    $return = '';
    switch ($model_id)
    {
        case 1:
            $return = "内部栏目";break;
        default :
            $return = "单页";break;
    }
    unset($model_id);
    return $return;
}


/**
 * 根据catid查找对应的栏目信息
 * @param int $catid
 * @param $context
 * @param string $alias 返回对应字段信息，默认是catname,如设置为*，则读取栏目所有信息
 * @return bool|mixed
 */
function get_catname_by_catid(int $catid,$context,$alias='catname')
{
    $cache_arr = [];
    $find = false;
    $key = '__CACHE_CATEGORY_ALL_DATA__';
    if($catid>0)
    {
        //查找缓存
        $cache_arr = yield get_cache($key);
        //var_dump($cache_arr);
        if($cache_arr)
        {
            //print_r('catname from cache');
        }else{
            //数据库查找
            $model = get_instance()->loader->model(\app\Models\Data\CategoryModel::class,$context);
            $r =  yield $model->getAll();
            if($r)
            {
                $cache_arr = $r;
                //存入缓存
                yield set_cache($key,$r);
                //print_r('catname from db');
            }
        }
    }

    if($cache_arr)
    {
        //查找对应catid数据
        foreach ($cache_arr as $key=>$value)
        {
            if ($catid==$value['id'])
            {
                if($alias=='*')
                {
                    $find = $value;
                }else{
                    $find = $value[$alias];
                }
            }
        }
    }

    unset($catid,$context,$alias,$cache_arr,$key,$value,$model,$r);
    return $find;
}
