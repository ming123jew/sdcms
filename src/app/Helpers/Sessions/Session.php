<?php
namespace app\Helpers\Sessions;
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2017-9-14
 * Time: 14:06
 */


class Session
{
    protected static $prefix = '';
    protected static $init   = null;
    protected static $session_id;

    /**
     * 设置或者获取session作用域（前缀）
     * @param string $prefix
     * @return string|void
     */
    public static function prefix($prefix = '')
    {
        if (empty($prefix) && null !== $prefix) {
            return self::$prefix;
        } else {
            self::$prefix = $prefix;
        }
    }

    /**
     * session初始化
     * @param array $config
     * @return null
     * @throws \Exception
     */
    public static function init(array $config = [])
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
                'path'=>$configs_session[$configs_session['active']]['path']
            ];
        }

        if($config['prefix']){self::$prefix = $config['prefix'];}

        if (!empty($config['type'])) {
            // 读取session驱动
            $class = false !== strpos($config['type'], '\\') ? $config['type'] : '\\app\\Helpers\\Sessions\\driver\\' . ucwords($config['type']);

            // 检查驱动类
            if (!class_exists($class)) {
                throw new \Exception('error session handler:' . $class, $class);
            }else{
                if(self::$init)
                {
                    echo "\nsession had created.\n";
                    return self::$init;
                }else{
                    echo "\nsession created.\n";
                    self::$init = new $class($config);
                    self::$init->open($config['path'],'');
                    return self::$init;
                }
            }

        }
    }

    /**
     * session自动启动或者初始化
     * @throws \Exception
     */
    public static function boot()
    {
        if (is_null(self::$init)) {
            self::init();
        } elseif (false === self::$init) {
            self::init();
        }
    }

    /**
     * session设置
     * @param $name
     * @param string $value
     * @param null $prefix
     * @throws \Exception
     */
    public static function set($name, $value = '', $prefix = null)
    {

        empty(self::$init) && self::boot();
        self::$init->write($prefix.$name,$value);
    }

    /**
     * session获取
     * @param string $name
     * @param null $prefix
     * @return mixed
     * @throws \Exception
     */
    public static function get($name = '', $prefix = null)
    {
        empty(self::$init) && self::boot();
        return self::$init->read($prefix.$name);
    }

    /**
     * session获取并删除
     * @param $name
     * @param null $prefix
     * @return mixed|void
     * @throws \Exception
     */
    public static function pull($name, $prefix = null)
    {
        $result = self::get($name, $prefix);
        if ($result) {
            self::delete($name, $prefix);
            return $result;
        } else {
            return;
        }
    }

    /**
     * session设置 下一次请求有效
     * @param $name
     * @param $value
     * @throws \Exception
     */
    public static function flash($name, $value)
    {
        self::set($name, $value);
        if (!self::has('__flash__.__time__')) {
            self::set('__flash__.__time__', $_SERVER['REQUEST_TIME_FLOAT']);
        }
        self::push('__flash__', $name);
    }

    /**
     * 清空当前请求的session数据
     * @throws \Exception
     */
    public static function flush()
    {
        if (self::$init) {
            $item = self::get('__flash__');

            if (!empty($item)) {
                $time = $item['__time__'];
                if ($_SERVER['REQUEST_TIME_FLOAT'] > $time) {
                    unset($item['__time__']);
                    self::delete($item);
                    self::set('__flash__', []);
                }
            }
        }
    }

    /**
     * 删除session数据
     * @param $name
     * @param null $prefix
     * @return mixed
     * @throws \Exception
     */
    public static function delete($name, $prefix = null)
    {
        empty(self::$init) && self::boot();
        return self::$init->destroy($prefix.$name);
    }

    /**
     * 清空session数据
     * @param null $prefix
     * @throws \Exception
     */
    public static function clear($prefix = null)
    {
        empty(self::$init) && self::boot();
        $prefix = !is_null($prefix) ? $prefix : self::$prefix;
        self::$init->destroy($prefix.'*');
    }

    /**
     * 判断session数据
     * @param $name
     * @param null $prefix
     * @return bool
     * @throws \Exception
     */
    public static function has($name, $prefix = null)
    {
        empty(self::$init) && self::boot();
        $prefix = !is_null($prefix) ? $prefix : self::$prefix;
        return self::$init->read($prefix.$name);
    }

    /**
     * 添加数据到一个session数组
     * @param $key
     * @param $value
     * @throws \Exception
     */
    public static function push($key, $value)
    {
        $array = self::get($key);
        if (is_null($array)) {
            $array = [];
        }
        $array[] = $value;
        self::set($key, $array);
    }

    /**
     * 启动session
     * @throws \Exception
     */
    public static function start()
    {
        //session_start();
        empty(self::$init) && self::boot();
        self::$init = true;
    }

    /**
     * 销毁session
     * @return void
     */
    public static function destroy()
    {
        //session_unset();
        //session_destroy();
        self::$init->gc();
        self::$init = null;
    }

    /**
     * 重新生成session_id
     * @param bool $delete 是否删除关联会话文件
     * @return void
     */
    public static function session_id($id=null)
    {
        echo session_regenerate_id(true);
        //session_regenerate_id($delete);
        if($id==null){
            return self::$session_id;
        }else{
            self::$session_id = $id;
        }
    }

    /**
     * 暂停session
     * @return void
     */
    public static function pause()
    {
        // 暂停session
        self::$init = false;
    }


}