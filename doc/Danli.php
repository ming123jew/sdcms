<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-4-17
 * Time: 10:03
 */

/**
 * 单例模式，使某个类的对象仅允许创建一个。构造函数private修饰，
 * 申明一个static getInstance方法，在该方法里创建该对象的实例。如果该实例已经存在，则不创建。比如只需要创建一个数据库连接。
 * Class Danli
 */

class Danli
{
    protected static $t;
    private function __construct()
    {
    }

    static function getInstance()
    {
        if(self::$t)
        {
            echo "obj had created.";
            return self::$t;
        }else{
            echo "create obj.";
            self::$t = new Danli();
            return self::$t;
        }
    }

    public function echoHi()
    {
        echo "hi.\n";
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }
}

