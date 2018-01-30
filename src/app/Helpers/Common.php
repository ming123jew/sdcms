<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2017-11-15
 * Time: 15:24
 */
use app\Helpers\Sessions\Session;
use app\Controllers;
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
 * @param $controller   module+controller    如 Admin/Main
 * @param $method
 * @param string $params
 */
function url($controller='',$method='', $params=''){

    $host = Controllers\BaseController::$Host2;

    if(empty($controller)){
        $controller = Controllers\BaseController::$ControllerName2;
    }
    if(empty($method)){
        $method = Controllers\BaseController::$MethodName2;
    }
    $url = $controller.'/'.$method;
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
 * 检查路由权限 | 预留
 * @param $m
 * @param $c
 * @param $a
 * @param array $param
 */
function check_role($m,$c,$a,$param=[]){
    return true;
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