<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-4-17
 * Time: 14:11
 */

/**
 * 原型模式
 *
 * 原型模式（对象克隆以避免创建对象时的消耗）
 * 1：与工厂模式类似，都是用来创建对象。
 * 2：与工厂模式的实现不同，原型模式是先创建好一个原型对象，然后通过clone原型对象来创建新的对象。这样就免去了类创建时重复的初始化操作。
 * 3：原型模式适用于大对象的创建，创建一个大对象需要很大的开销，如果每次new就会消耗很大，原型模式仅需要内存拷贝即可。
 * Class Canvas
 */
class Canvas
{
    private $data;
    function init($w=20,$h=10)
    {
        $data = array();
        for($i = 0; $i < $h; $i++)
        {
            for($j = 0; $j < $w; $j++)
            {
                $data[$i][$j] = '*';
            }
        }
        $this->data = $data;
    }

    function rect($x1, $y1, $x2, $y2)
    {
        foreach($this->data as $k1 => $line)
        {
            if ($x1 > $k1 or $x2 < $k1) continue;
            foreach($line as $k2 => $char)
            {
                if ($y1>$k2 or $y2<$k2) continue;
                $this->data[$k1][$k2] = '#';
            }
        }
    }

    function draw(){
        foreach ($this->data as $line){
            foreach ($line as $char){
                echo $char;
            }
            echo "\n;";
        }
    }
}