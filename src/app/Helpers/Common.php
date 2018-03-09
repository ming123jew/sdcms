<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2017-11-15
 * Time: 15:24
 */
use app\Helpers\Sessions\Session;
use app\Controllers;
use  Server\Memory\Cache;
function Test(){
    return 'test_123';
}

/**
 * Session管理
 * @param string|array  $name session名称，如果为数组表示进行session设置
 * @param mixed         $value session值
 * @param string        $prefix 前缀
 * @return mixed
 */
function session($name, $value = '', $prefix = null)
{
    if (is_array($name)) {
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



/**
 * 生成url
 * @param $module       module
 * @param $controller   controller
 * @param $method
 * @param string $params
 */
function url($module='',$controller='',$action='', $params=''){

    $host = Controllers\BaseController::$Host2;
    if(empty($module)){
        $module = Controllers\BaseController::$ModuleName2;
    }
    if(empty($controller)){
        $controller = Controllers\BaseController::$ControllerName2;
    }
    if(empty($action)){
        $action = Controllers\BaseController::$ActionName2;
    }
    $url = $module.'/'.$controller.'/'.$action;
    //print_r($url);
    // 解析参数
    if (is_string($params)) {
        // aaa=1&bbb=2 转换成数组
        parse_str($params, $params);
    }
    $url .= '?';
    if(is_array($params)){
        foreach ($params as $key=>$value){
            if ('' !== trim($value)) {
                $url .=  $key . '=' . urlencode($value).'&';
            }
        }
    }

    $url = $host.substr($url,0,-1);
    $end = $url;
    return  $end;

}

/**
 * 生成请求令牌
 * @access public
 * @param string $name 令牌名称
 * @param mixed  $type 令牌生成方法
 * @return string
 */
function token($name = '__token__', $type = 'md5', $is_ajax=false)
{
    $type  = is_callable($type) ? $type : 'md5';
    $token = call_user_func($type, $_SERVER['REQUEST_TIME_FLOAT']);
    if ($is_ajax) {
        header($name . ': ' . $token);
    }
    Session::set($name, $token);
    return $token;
}

/**
 * 检查路由权限 | 预留  首先读取缓存，如不存在则读数据库
 * @param $m
 * @param $c
 * @param $a
 * @param $context
 * @param array $param
 */
function check_role($m,$c,$a,$context,$param=[]){
    $login_info = session('__SESSION__ADMIN__');
    //print_r($login_info);

    $role_id = $login_info['roleid'];
    $cache = Cache::getCache('WebCache');
    $role_id_priv =  unserialize($cache->getOneMap('__ROLEID__DATA__ADMIN__'.$role_id));
    if(!$role_id_priv){
        //数据库查找
        $model = get_instance()->loader->model(\app\Models\RolePrivModel::class,$context);
        $r =  yield $model->authRole($role_id,$m,$c,$a);
        //print_r('check_role from db \n;');
        if(!($r)){
            return false;
        }else{
           return true;
        }
    }else{
        //print_r('check_role from cache \n;');
        //从缓存种查找
        $find = false;
        if(is_array($role_id_priv)&&!empty($role_id_priv)){
            foreach ($role_id_priv as $key=>$value){
                if($m==$value['m']&&$c==$value['c']&&$a==$value['a']){
                    $find = true;
                }else{
                    continue;
                }
            }
        }
        return $find;
    }
    //print_r($role_id_priv);
    return false;
}

/**
 * 获取权限组对应名称
 * @param $roleid
 * @param $context  传入上下文
 * @param string $flag
 * @return bool
 */
function get_role_byid($roleid,$context,$flag='__CACHE_ROLE__'){
    if($roleid&&$flag){

        $cache = Cache::getCache('WebCache');
        $d = $cache->getOneMap($flag);
        if($d){
            $all_role =  unserialize($d);
            print_r('role from cache.');
        }else{
            $m = get_instance()->loader->model(\app\Models\RoleModel::class,$context);
            $d = yield $m->getAll();
            $all_role = $d;
            //存入缓存
            $cache->addMap($flag,serialize($d));
            print_r('role from db.');

        }
        $find = [];
        foreach ($all_role as $key=>$value){
            if($roleid==$value['id']){
                $find = $value;
            }else{
                continue;
            }
        }

        return $find;
    }
    return false;
}

/**
 * Curl版本   post 提交
 * 使用方法：
 * $post_string = "app=request&version=beta";
 * request_by_curl('http://facebook.cn/restServer.php',$post_string);
 */
function http_post_url($remote_server, array $params){

    $post_string = "{";
    foreach($params as $key => &$val){
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
    return $data;
}

function get_modelname_bymodelid($model_id){
    $return = '';
    switch ($model_id){
        case 1:
            $return = "文章模型";break;
        case 2:
            $return = "";break;
    }
    return $return;
}

function get_cattype_bymodelid($model_id){
    $return = '';
    switch ($model_id){
        case 1:
            $return = "内部栏目";break;
        default :
            $return = "单页";break;
    }
    return $return;
}

