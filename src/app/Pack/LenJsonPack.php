<?php
/**
 * Created by PhpStorm.
 * User: zhangjincheng
 * Date: 16-7-15
 * Time: 下午2:43
 */

namespace Server\Pack;

use Server\CoreBase\SwooleException;

class LenJsonPack implements IPack
{
    protected $package_length_type = 'N';
    protected $package_length_type_length = 4;
    protected $package_length_offset = 0;
    protected $package_body_offset = 4;

    protected $last_data = null;
    protected $last_data_result = null;

    /**
     *
     * 数据包编码加上协议头
     * @param $buffer
     * @return string
     * @throws SwooleException
     */
    public function encode($buffer)
    {
        var_dump("encode".$buffer);
        //|版本|设备|指令|数据|
        //| 0  |1~ 7|8   |9~9+n|
        //获取长度
        $length = strlen($buffer) - 9;
        //制作校验码
        $check = '00';
        //|起始|长度|版本|设备|指令|数据|校验
        //| 0  | 1  | 2  |3 ~9|10  |11~11+n|11+n+1~11+n+3|
        return hex2bin('f0') . pack($this->package_length_type, $length).$buffer . $check;
    }

    /**
     * 客户端发来的消息经过Swoole分离成各个独立消息后首先进入unPack中，也就是说unPack传递进去的是完整的协议，然后通过decode去除协议头，传递     * 给路由器进一步处理。
     * 去除协议头 2
     * @param $buffer
     * @return string
     */
    public function decode($buffer)
    {
        var_dump("decode:".$buffer);
        //|起始|长度|版本|设备|指令|数据|校验
        //| 0  | 1  | 2  |3 ~ 9|10|11~11+n|11+n+1~11+n+3|
        //去掉前2个字节（起始和长度）
        $ret = substr($buffer, $this->package_length_type_length + 1);
        //获取后俩个校验字节
        $crc = substr($ret, 0, -2);
        //这里进行校验失败抛异常
        //去除校验字节
        $ret = substr($ret, 0,  - 2);
        return $ret;
    }
// 封装协议体
    public function pack($data, $topic = null)
    {
        var_dump("pack".$data);
        //return $this->encode(hex2bin($data));
        return pack("N", strlen($data)) . $data;
    }
    // 解析协议体 1
    //客户端发来的消息经过Swoole分离成各个独立消息后首先进入unPack中，也就是说unPack传递进去的是完整的协议，然后通过decode去除协议头，传递给路由器进一步处理。
    public function unPack($data)
    {
        var_dump("unPack:".$data);
        //指令类型，1表示文本，2表示二进制数据，9表示心跳ping
//        $data = $this->decode($data);
//        //|版本|设备|指令|数据|
//        //| 0  |1 ~7|8   |9~9+n|
//        $version = $data[0];
//        $device_sn = substr($data,1,7);
//        $command = $data[8];
//        $receivedData = substr($data, 9);
//        $data = [];
//        $data['device_sn'] = $device_sn;
//        $data['command'] = $command;
//        $data['data'] = $receivedData;
        $dataLength = unpack("N", $data)[1];
        $message = substr($data, -$dataLength);
        return $message;
    }

    public function getProbufSet()
    {
        return [
            'open_length_check'     => true,
            'package_length_type'   => $this->package_length_type,
            'package_length_offset' => $this->package_length_offset,       //第N个字节是包长度的值
            'package_body_offset'   => $this->package_body_offset,       //第几个字节开始计算长度
            'package_max_length'    => 2000000,  //协议最大长度
        ];
    }

    public function errorHandle($e, $fd)
    {
        var_dump("error in lenjsonpack");
        get_instance()->close($fd);
    }

}