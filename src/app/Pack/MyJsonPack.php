<?php
/**
 * Created by PhpStorm.
 * User: zhangjincheng
 * Date: 16-7-15
 * Time: 下午2:43
 */

namespace Server\Pack;

use Server\CoreBase\SwooleException;

class MyJsonPack implements IPack
{

    protected $package_length_type = 'c';
    protected $package_length_type_length = 1;
    protected $package_length_offset = 1;
    protected $package_body_offset = 13;

    protected $last_data;
    protected $last_data_result;


    public function pack($data, $topic = null)
    {
        if ($this->last_data != null && $this->last_data == $data) {
            return $this->last_data_result;
        }
        $this->last_data = $data;
        $this->last_data_result = json_encode($data, JSON_UNESCAPED_UNICODE);
        return $this->last_data_result;
    }

    public function unPack($data)
    {
        $value = json_decode($data);
        if (empty($value)) {
            throw new SwooleException('json unPack 失败');
        }
        return $value;
    }

    function encode($buffer)
    {

    }

    function decode($buffer)
    {

    }

    public function getProbufSet()
    {
        return [
            'open_length_check' => false,
            'package_length_type' => $this->package_length_type,
            'package_length_offset' => $this->package_length_offset,       //第N个字节是包长度的值
            'package_body_offset' => $this->package_body_offset,       //第几个字节开始计算长度
            'package_max_length' => 2000000,  //协议最大长度)
        ];
    }
    public function errorHandle($e, $fd)
    {
        //get_instance()->close($fd);
    }
}