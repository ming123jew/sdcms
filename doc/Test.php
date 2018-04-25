<?php
$url = 'http://118.89.26.188:8081/Home/Article/list?id=1&p=1';
echo $url='?s=view&p=5'."\n";
echo '';
$p=6;

echo preg_replace('/p=([\d]+)/', 'p=' . $p, $url);
echo ''."\n";
//echo preg_replace('/([\d]+)/', $p, $url);

print_r( strpos('http://118.89.26.188:8081/Home/Article/list?id=1','?') );

test();
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


//抓取

function test(){
//搜狗抓取微信公众号
    $url="http://weixin.sogou.com/weixin?type=1&s_from=input&query=农产品&ie=utf8";
    $ifpost = 0;
    $datafields = '';
    $cookiefile = '';
    $v = false;
//构造随机ip
    $ip_long = array(
        array('607649792', '608174079'), //36.56.0.0-36.63.255.255
        array('1038614528', '1039007743'), //61.232.0.0-61.237.255.255
        array('1783627776', '1784676351'), //106.80.0.0-106.95.255.255
        array('2035023872', '2035154943'), //121.76.0.0-121.77.255.255
        array('2078801920', '2079064063'), //123.232.0.0-123.235.255.255
        array('-1950089216', '-1948778497'), //139.196.0.0-139.215.255.255
        array('-1425539072', '-1425014785'), //171.8.0.0-171.15.255.255
        array('-1236271104', '-1235419137'), //182.80.0.0-182.92.255.255
        array('-770113536', '-768606209'), //210.25.0.0-210.47.255.255
        array('-569376768', '-564133889'), //222.16.0.0-222.95.255.255
    );
    $rand_key = mt_rand(0, 9);
    $ip= long2ip(mt_rand($ip_long[$rand_key][0], $ip_long[$rand_key][1]));
//模拟http请求header头
    $header = array("Connection: Keep-Alive","Accept: text/html, application/xhtml+xml, */*", "Pragma: no-cache", "Accept-Language: zh-Hans-CN,zh-Hans;q=0.8,en-US;q=0.5,en;q=0.3","User-Agent: Mozilla/5.0
 (compatible; MSIE 10.0; Windows NT 6.2; WOW64; Trident/6.0)",'CLIENT-IP:'.$ip,'X-FORWARDED-FOR:'.$ip);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, $v);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    $ifpost && curl_setopt($ch, CURLOPT_POST, $ifpost);
    $ifpost && curl_setopt($ch, CURLOPT_POSTFIELDS, $datafields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $cookiefile && curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiefile);
    $cookiefile && curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiefile);
    curl_setopt($ch,CURLOPT_TIMEOUT,30); //允许执行的最长秒数
    $ok = curl_exec($ch);
    curl_close($ch);
    unset($ch);
//正则匹配出微信名称
    preg_match_all('|<label name="em_weixinhao">(.*?)<\/label>|is',$ok,$m);
    var_dump($m);
}


