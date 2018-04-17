<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-4-17
 * Time: 14:24
 */

/**
 * PHP 装饰器模式
 * 1.装饰器模式（Decorator），可以动态地添加修改类的功能
 * 2.一个类提供了一项功能，如果要在修改并添加额外的功能，传统的编程模式，需要写一个子类继承它，并重新实现类的方法
 * 3.使用装饰器模式，仅需在运行时添加一个装饰器对象即可实现，可以实现最大的灵活性
 */

/**
 * 输出一个字符串
 * 装饰器动态添加功能
 * Class EchoText
 */
class EchoText
{
    protected $decorator = [];

    public function Index()
    {
        //调用装饰器前置操作
        $this->beforeEcho();
        echo "你好，我是装饰器。";
        //调用装饰器后置操作
        $this->afterEcho();
    }

    //增加装饰器
    public function addDecorator(Decorator $decorator)
    {
        $this->decorator[] = $decorator;
    }

    //执行装饰器前置操作 先进先出原则
    protected function beforeEcho()
    {
        foreach ($this->decorator as $decorator)
            $decorator->before();
    }

    //执行装饰器后置操作 先进后出原则
    protected function afterEcho()
    {
        $tmp = array_reverse($this->decorator);
        foreach ($tmp as $decorator)
            $decorator->after();
    }
}


/**
 * 装饰器接口
 * Class Decorator
 */
interface Decorator
{
    public function before();

    public function after();
}

/**
 * 颜色装饰器实现
 * Class ColorDecorator
 */
class ColorDecorator implements Decorator
{
    protected $color;

    public function __construct($color)
    {
        $this->color = $color;
    }

    public function before()
    {
        echo "<dis style='color: {$this->color}'>";
    }

    public function after()
    {
        echo "</div>";
    }
}

/**
 * 字体大小装饰器实现
 * Class SizeDecorator
 */
class SizeDecorator implements Decorator
{
    protected $size;

    public function __construct($size)
    {
        $this->size = $size;
    }

    public function before()
    {
        echo "<dis style='font-size: {$this->size}px'>";
    }

    public function after()
    {
        echo "</div>";
    }
}

//实例化输出类
$echo = new EchoText();
//增加装饰器
$echo->addDecorator(new ColorDecorator('red'));
//增加装饰器
$echo->addDecorator(new SizeDecorator('22'));
//输出
$echo->Index();
