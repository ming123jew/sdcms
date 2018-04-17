<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-4-17
 * Time: 10:41
 */
namespace IMooc;
use IMooc\IDatabase;
class Mysql implements IDatabase
{
    protected $conn;
    function connect($host, $user, $password, $dbname)
    {
        // TODO: Implement connect() method.
        $conn = mysql_connect($host, $user, $password);
        mysql_select_db($dbname, $conn);
        $this->conn = $conn;
    }
    function query($sql)
    {
        // TODO: Implement query() method.
        $res = mysql_query($sql, $this->conn);
        return $res;
    }
    function close()
    {
        // TODO: Implement close() method.
        mysql_close($this->conn);
    }
}