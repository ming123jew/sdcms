<?php
namespace app\Helpers\Sessions;
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2017-9-14
 * Time: 14:06
 */


class Sessions
{

    protected $prefix ;
    protected $config;
    protected $cookie_key = 'PHPSESSID';
    protected $cookie_expire=30;
    protected $cookie_path='/';
    protected $cookie_domain='';
    protected $driver_type;
    protected $driver;
    protected $isStart=false;
    protected $session_id;
    protected static $context;
    protected static $t;

    public static function getInstance($context)
    {
        if(self::$t)
        {
            //echo "\nloading:session-> sessions had create.\n";
            self::$context = $context;
            return self::$t;
        }else{
            //echo "\nloading:session-> sessions creating.\n";
            self::$t = new Sessions($context);
            self::$context = $context;
            return self::$t;
        }
    }

    public function __construct($context)
    {
        if(empty($config)){
            $configs = get_instance()->config;
            $configs_session = ($configs['session']);
            $config = [
                'id'             => '',
                // SESSION_ID的提交变量,解决flash上传跨域
                'var_session_id' => '',
                // SESSION 前缀
                'prefix'         =>$configs_session[$configs_session['active']]['prefix'],
                // 驱动方式 支持redis memcache memcached
                'type'           => $configs_session[$configs_session['active']]['type'],
                // 是否自动开启 SESSION
                'auto_start'     => true,
                'expire'=>  $configs_session[$configs_session['active']]['expire'],
                'path'=>$configs_session[$configs_session['active']]['path'],
                'domain'=>$configs_session[$configs_session['active']]['domain'],
                'cookie_key'=>$configs_session[$configs_session['active']]['cookie_key'],
            ];
        }
        $this->config = $config;
        if($config['prefix']){
            $this->prefix = $config['prefix'];
        }
        if($config['expire']){
            $this->cookie_expire = $config['expire'];
        }
        if($config['path']){
            $this->cookie_path = $config['path'];
        }
        if($config['domain']){
            $this->cookie_domain = $config['domain'];
        }
        if($config['cookie_key']){
            $this->cookie_key = $config['cookie_key'];
        }
        if($context){
            self::$context = $context;
        }

        if (!empty($config['type'])) {
            // 读取session驱动
            $class = false !== strpos($config['type'], '\\') ? $config['type'] : '\\app\\Helpers\\Sessions\\driver\\' . ucwords($config['type']);
            // 检查驱动类
            if (!class_exists($class)) {
                throw new \Exception('error session handler:' . $class, $class);
            }else {
                $this->driver_type = $class;
            }
        }
    }

    public function Start(){
        if(!$this->isStart){
            $this->isStart = true;
            $this->driver = new $this->driver_type( $this->config );
            $this->driver->open('','');
            //PHPSESSIONID = hash_func(客户端IP + 当前时间（秒）+ 当前时间（微妙）+ PHP自带的随机数生产器)
            if(self::$context){
                $sess_id = self::$context->http_input->cookie($this->cookie_key);
                if(empty($sess_id)){
                    $sess_id = self::$context->http_input->getPost($this->cookie_key);
                }
                //echo "\nstart:".$sess_id."\n";
                if(empty($sess_id)){
                    $sess_id = md5('__'.create_uuid().'__').md5('__'.create_uuid().'__');
                    self::$context->http_output->setCookie($this->cookie_key,$sess_id,time()+$this->cookie_expire,$this->cookie_path,$this->cookie_domain);
                    $this->session_id = $sess_id;
                }
                $_SESSION = $this->Load($sess_id);
                return true;
            }else{
                return false;
            }
        }
    }

    public function SessionId(){
        return $this->session_id;
    }

    protected function Load($sess_id) {
        if(!$this->session_id) {
            $this->session_id = $sess_id;
        }
        $data = $this->driver->read($this->prefix . $sess_id);
        //先读数据，如果没有，就初始化一个
        if (!empty($data)) {
            return unserialize($data);
        }else {
            return [];
        }
    }

    public function Save(){
        if (!$this->isStart) {
            return true;
        }
        //设置为Session关闭状态
        $this->isStart = false;
        $session_key = $this->prefix . $this->session_id;
        // 如果没有设置SESSION,则不保存,防止覆盖
        if(empty($_SESSION)) {
            $_SESSION=[];
        }
        //echo "\nend:".$this->session_id;
        return $this->driver->write($session_key,serialize($_SESSION));
    }

    public function Set($key,$data,$prefix=null){
       // print_r("\n{$key}:{$data}");
        if($prefix){
            $key = $key.$prefix;
        }
        if(is_string($key) && isset($data)) {
            $_SESSION[$key] = $data;
            return true;
        }
        return false;
    }

    public function Get($key,$prefix=null){
        //print_r("\n{$key}");
        //print_r($_SESSION);
        if($prefix){
            $key = $key.$prefix;
        }
        if(is_null($key)) {
            return $_SESSION;
        }
        if(isset($_SESSION[$key]))
            return $_SESSION[$key];
        else
            return null;
    }

    public function Del($key,$prefix=null){
        if($prefix){
            $key = $key.$prefix;
        }
        if($this->Has($key,$prefix)) {
            print_r("/nhere/n");
            $_SESSION[$key] = null;
            unset($_SESSION[$key]);
            print_r($_SESSION);
            return true;
        }
        return false;
    }

    public function Has($key,$prefix=null){
        if($prefix){
            $key = $key.$prefix;
        }
        if(!$key) {
            return false;
        }
        return isset($_SESSION[$key]);
    }

    public function destroy() {
        if(!empty($_SESSION)) {
            $_SESSION = [];
            // 使cookie失效
            setcookie($this->cookie_key, $this->session_id, time() - 600, $this->cookie_path, $this->cookie_domain);
            // redis中完全删除session_key
            $session_key = $this->prefix . $this->session_id;
            return $this->driver->destroy($session_key);
        }
        return false;
    }

    public function gc(){
        $this->driver->gc(0,$this->prefix);
        $this->driver = null;
    }

    public function getAllKeys(){
        return $this->driver->getAllKeys();
    }
}