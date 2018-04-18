<?php
$url = 'http://118.89.26.188:8081/Home/Article/list?id=1&p=1';
echo $url='?s=view&p=5'."\n";
echo '';
$p=6;

echo preg_replace('/p=([\d]+)/', 'p=' . $p, $url);
echo ''."\n";
//echo preg_replace('/([\d]+)/', $p, $url);

print_r( strpos('http://118.89.26.188:8081/Home/Article/list?id=1','?') );

exit(0);
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-4-17
 * Time: 10:15
 */
//测试单例模式。。
function autoload1($class){
    $dir  = __DIR__;
    $requireFile = $dir."\\".$class.".php";
    require $requireFile;
}
spl_autoload_register('autoload1');

$Danli = Danli::getInstance();
$Danli->echoHi();  //首次创建

$Danli2 = Danli::getInstance();
$Danli2->echoHi();  //重复调用



//测试工厂模式
echo "=================================\n\t";
$Factory = Factory::createT();
$Factory->test();

//测试策略模式
echo "==============\n";
class Page
{
    protected $strategy;
    function index(){
        echo "AD";
        $this->strategy->showAd();
        echo "<br>";
        echo "Category";
        $this->strategy->showCategory();
        echo "<br>";
    }
    //装载器
    function setStrategy(Strategy $strategy){
        $this->strategy=$strategy;
    }
}
$page = new Page();
if(isset($_GET['male'])){
    $strategy = new MaleStrategy();
}else {
    $strategy = new FemaleStrategy();
}
$page->setStrategy($strategy);
$page->index();


//测试观察者模式
echo "==============\n";
$event = new Event();
$event->addObserver(new Observer1());
$event->addObserver(new Observer2());
$event->triger();//触发了事件
$event->notify();//对所有相关类进行下发更新通知


//测试原型模式
echo "===============\n";
$c = new Canvas();
$c->init();
//$canvas1 = new Canvas();
// $canvas1->init();
$canvas1 = clone $c;//通过克隆，可以省去init()方法，这个方法循环两百次  这样就免去了类创建时重复的初始化操作
//去产生一个数组。当项目中需要产生很多的这样的对象时，就会new很多的对象，那样
//是非常消耗性能的。
$canvas1->rect(2, 2, 8, 8);
$canvas1->draw();
echo "-----------------------------------------<br>";
// $canvas2 = new Canvas();
// $canvas2->init();
$canvas2 = clone $c;
$canvas2->rect(1, 4, 8, 8);
$canvas2->draw();