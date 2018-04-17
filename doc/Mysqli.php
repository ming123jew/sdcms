<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-4-17
 * Time: 10:43
 */
namespace IMooc;
use IMooc\IDatabase;
class Mysqli implements IDatabase
{
    protected $conn;
    function connect($host, $user, $password, $dbname)
    {
        // TODO: Implement connect() method.
        $conn = mysqli_connect($host, $user, $password, $dbname);
        $this->conn = $conn;
    }
    function query($sql)
    {
        // TODO: Implement query() method.
        return mysqli_query($this->conn, $sql);
    }
    function close()
    {
        // TODO: Implement close() method.
        mysqli_close($this->conn);
    }
}