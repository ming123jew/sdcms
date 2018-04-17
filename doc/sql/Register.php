<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-4-17
 * Time: 10:34
 */

/**
 * 注册模式，解决全局共享和交换对象。已经创建好的对象，挂在到某个全局可以使用的数组上，
 * 在需要使用的时候，直接从该数组上获取即可。将对象注册到全局的树上。任何地方直接去访问。
 * Class Register
 */
class Register{
    protected static $objects;
    function set($alias,$object)
    {
        self::$objects[$alias] = $object;
    }
    function get($name)
    {
       return self::$objects[$name];
    }

    function _unset($name)
    {
        unset(self::$objects[$name]);
    }
}