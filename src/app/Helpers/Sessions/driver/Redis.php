<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2017 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

namespace app\Helpers\Sessions\driver;

use SessionHandler;

class Redis extends SessionHandler
{
    /** @var \Redis */
    protected $handler = null;
    protected $config  = [
        'host'         => '127.0.0.1', // redis主机
        'port'         => 6379, // redis端口
        'password'     => '', // 密码
        'select'       => 0, // 操作库
        'expire'       => 3600*24, // 有效期(秒)
        'timeout'      => 0, // 超时时间(秒)
        'persistent'   => true, // 是否长连接
        'session_name' => '', // sessionkey前缀
    ];

    public function __construct($config = [])
    {
        $this->config = array_merge($this->config, $config);
        //print_r( $this->config);
    }

    /**
     * 打开Session
     * @param string $savePath
     * @param string $sessName
     * @return bool
     * @throws \Exception
     */
    public function open($savePath, $sessName)
    {
        // 检测php环境
        if (!extension_loaded('redis')) {
            throw new \Exception('not support:redis');
        }
        $this->handler = new \Redis;

        // 建立连接
        $func = $this->config['persistent'] ? 'pconnect' : 'connect';
        $this->handler->$func($this->config['host'], $this->config['port'], $this->config['timeout']);

        if ('' != $this->config['password']) {
            $this->handler->auth($this->config['password']);
        }

        if (0 != $this->config['select']) {
            $this->handler->select($this->config['select']);
        }

        return true;
    }

    /**
     * 关闭Session
     * @access public
     */
    public function close()
    {
        $this->gc(ini_get('session.gc_maxlifetime'));
        $this->handler->close();
        $this->handler = null;
        return true;
    }

    /**
     * 读取Session
     * @access public
     * @param string $sessID
     * @return string
     */
    public function read($sessID)
    {

        return unserialize( (string) $this->handler->get($this->config['session_name'] . $sessID) );
    }

    /**
     * 写入Session
     * @access public
     * @param string $sessID
     * @param String $sessData
     * @return bool
     */
    public function write($sessID, $sessData)
    {
        if ($this->config['expire'] > 0) {
            return $this->handler->setex($this->config['session_name'] . $sessID, $this->config['expire'], serialize($sessData));
        } else {
            return $this->handler->set($this->config['session_name'] . $sessID, serialize($sessData));
        }
    }

    /**
     * 删除Session
     * @access public
     * @param string $sessID
     * @return bool
     */
    public function destroy($sessID)
    {
        return $this->handler->delete($this->config['session_name'] . $sessID) > 0;
    }

    /**
     * Session 垃圾回收
     * @access public
     * @param string $sessMaxLifeTime
     * @return bool
     */
    public function gc($sessMaxLifeTime,$prefix='')
    {
        //取出所有的 带有指定前缀的键
        $keys = $this->handler->keys($prefix.'*');
        $now =time(); //取得现在的时间
        foreach($keys as $key){
            //取得当前key的最后更新时间
            $last_time = $this->handler->hGet($key,'last_time');
            /*
             * 查看当前时间和最后的更新时间的时间差是否超过最大生命周期
             */
            if(($now - $last_time) > $sessMaxLifeTime){
                //超过了最大生命周期时间 则删除该key
                $this->handler->del($key);
            }
        }
        return true;
    }

    public function getAllKeys($prefix=''){
        //取出所有的 带有指定前缀的键
        $keys = $this->handler->keys($prefix.'*');
        print_r($keys);
    }
}
