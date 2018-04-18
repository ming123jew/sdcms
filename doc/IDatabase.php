<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-4-17
 * Time: 10:38
 */

/**
 * 适配器模式
 *
 * 将各种截然不同的函数接口封装成统一的API。
 * PHP中的数据库操作有MySQL,MySQLi,PDO三种，可以用适配器模式统一成一致，使不同的数据库操作，统一成一样的API。
 * 类似的场景还有cache适配器，可以将memcache,redis,file,apc等不同的缓存函数，统一成一致。
 * 首先定义一个接口(有几个方法，以及相应的参数)。然后，有几种不同的情况，就写几个类实现该接口。将完成相似功能的函数，统一成一致的方法。
 * Class IDatabase
 */
namespace IMooc;
interface IDatabase
{
    function connect($host,$user,$password,$dbname);
    function query($sql);
    function close();
}